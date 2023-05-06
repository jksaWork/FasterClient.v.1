<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AnalyticsLivewire extends Component
{
    public $orders, $DailyOrders, $StartDate, $endDate, $areaChart, $area;

    public function updatedEndDate($val)
    {
        if ($this->StartDate == null) {
            $this->getDataWithEndDate();
        } else {
            $this->getDataWithBoth();
        }
    }

    public function updatedStartDate($val)
    {
        // dd('jksa altigani');
        if ($this->endDate == null) {
            // dd($this->StartDate);
            $this->getDataWithStartDate();
        } else {
            $this->getDataWithBoth();
        }
    }
    public function mount()
    {
        $sql = "SELECT `orders`.`sender_area_id`, count(`orders`.`id`) as y , `areas`.`name`  FROM `orders` , `areas` WHERE `areas`.`id` = `orders`.`sender_area_id` and `orders`.`client_id` = ?   GROUP BY `orders`.`sender_area_id`";
        $this->orders = DB::select($sql, [auth()->user()->id]);
        $sqlToGetOrdersInWeek = 'SELECT DAYNAME(order_date) as label , Count(id) as Data FROM orders  where client_id = ? GROUP BY date(order_date)';
        $this->DailyOrders = DB::select($sqlToGetOrdersInWeek, [auth()->user()->id]);
        $sql2 = "SELECT count(`orders`.`id`) as data   , `orders`.`sender_area_id` , MONTHNAME(`orders`.`order_date`) as monname , `areas`.`name` as lable FROM `orders` , `areas` WHERE  client_id = ? and`areas`.`id` =  `orders`.`sender_area_id`  GROUP BY  monname , sender_area_id;";

        foreach (['May', 'June', 'July'] as $item) {
            $query  = "select name, areas.id , orders.sender_area_id as sendid, COUNT(orders.id) as c from areas , orders where MOnthName(orders.order_date) = ? and orders.client_id  = ? and orders.sender_area_id = areas.id GROUP BY name";
            $chart3[$item] = DB::select($query, [$item, auth()->user()->id]);
        }
        // dd($chart3);
        $this->areaChart = $chart3;
        $this->area = Area::get();
    }

    public function getDataWithStartDate(): void
    {
        $sql = "SELECT `orders`.`sender_area_id`, count(`orders`.`id`) as y , `areas`.`name`  FROM `orders` , `areas` WHERE `areas`.`id` = `orders`.`sender_area_id` and `orders`.`client_id` = ?  and order_date  >  ? GROUP BY `orders`.`sender_area_id`";
        $this->orders = DB::select($sql, [auth()->user()->id,  $this->StartDate]);
        $sqlToGetOrdersInWeek = 'SELECT DAYNAME(order_date) as label , Count(id) as Data FROM orders  where client_id = ? and order_date > ? GROUP BY date(order_date)';
        $this->DailyOrders = DB::select($sqlToGetOrdersInWeek, [auth()->user()->id,  $this->StartDate]);
        $this->emit('updatedCharts', $this->DailyOrders, $this->orders);
    }

    public function getDataWithEndDate(): void
    {
        $sql = "SELECT `orders`.`sender_area_id`, count(`orders`.`id`) as y , `areas`.`name`  FROM `orders` , `areas` WHERE `areas`.`id` = `orders`.`sender_area_id` and `orders`.`client_id` = ?  and order_date  <  ? GROUP BY `orders`.`sender_area_id`";
        $this->orders = DB::select($sql, [auth()->user()->id,  $this->endDate]);
        $sqlToGetOrdersInWeek = 'SELECT DAYNAME(order_date) as label , Count(id) as Data FROM orders  where client_id = ? and order_date < ? GROUP BY date(order_date)';
        $this->DailyOrders = DB::select($sqlToGetOrdersInWeek, [auth()->user()->id, $this->endDate]);

        $this->emit('updatedCharts', $this->DailyOrders, $this->orders);
    }

    public function getDataWithBoth(): void
    {
        $sql = "SELECT `orders`.`sender_area_id`, count(`orders`.`id`) as y , `areas`.`name`  FROM `orders` , `areas` WHERE `areas`.`id` = `orders`.`sender_area_id` and `orders`.`client_id` = ?  and  (order_date BETWEEN ? AND ? )  GROUP BY `orders`.`sender_area_id`";
        $this->orders = DB::select($sql, [auth()->user()->id,  $this->StartDate, $this->endDate]);
        $sqlToGetOrdersInWeek = 'SELECT DAYNAME(order_date) as label , Count(id) as Data FROM orders  where client_id = ? and  (order_date BETWEEN ? AND ? ) GROUP BY date(order_date)';
        $this->DailyOrders = DB::select($sqlToGetOrdersInWeek, [auth()->user()->id, $this->StartDate, $this->endDate]);
        $this->emit('updatedCharts', $this->DailyOrders, $this->orders);
        // $sql2 = "SELECT count(`orders`.`id`) as data   , `orders`.`sender_area_id` , MONTHNAME(`orders`.`order_date`) as monname , `areas`.`name` as lable FROM `orders` , `areas` WHERE `areas`.`id` =  `orders`.`sender_area_id`  GROUP BY  monname , sender_area_id;"
    }

    public function render()
    {
        return view(
            'livewire.analytics-livewire',
            [
                'orders' => $this->orders,
                'DailyOrders' => $this->DailyOrders,
            ]
        )->layout('layouts.Edum');
        // ->layout('layouts.Edum');
    }
}