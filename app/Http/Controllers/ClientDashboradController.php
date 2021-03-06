<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientDashboradController extends Controller
{
    public function index(){
        $data['chart'] = DB::select('SELECT status as name , count(id) as y FROM orders WHERE client_id = ? and order_date > ?  GROUP BY status', [auth()->user()->id , Carbon::now()->subMonth()]);#->get();
        $data['orders'] = Order::with('service')->where('client_id' , auth()->user()->id)->latest()->limit(5)->get();
        $data['order_in_month'] = Order::where('client_id' , auth()->user()->id)->where('order_date', '>', Carbon::now()->subMonth())->get();
        $returndCount =  Order::where('status' , 'completed')->where('order_date', '>', Carbon::now()->subMonth())->count();
        // dd(Carbon::now()->subMonth() , auth()->user()->id , $returndCount);
        $chart2 = collect($data['chart']);
        $colorsarray = ['inProgress'=>'#FFAA16','pending' =>'#673bb7' , 'completed' => '#7ED321' ,'returned'=> '#FF1616', 'cancled' => 'red', 'delivered' => '#0370ed', 'pickup' => '#11cff5'];
        $MappedChart  = $chart2->map(function($el, $i) use ($colorsarray){
            return ["name" => __('translation.' . $el->name) , 'y' => $el->y , 'color' => $colorsarray[$el->name] ?? 'black'];
        });
        $data['chart'] = $MappedChart;
        // dd($data['chart']);
        // notify()->error('The provided credentials do not match our records.');
        return view('clients.dashboard.index', $data);
    }

    public function addOrder(){
        return view('clients.dashboard.addorder');
    }

    public function OrderHistory(){
        $Order = Order::where('client_id' , auth()->user()->id)->paginate(10);
        return view('clients.dashboard.orderHistory' , compact('Order'));
    }

    public function profile(){
        return view('clients.dashboard.profile');
    }
}
