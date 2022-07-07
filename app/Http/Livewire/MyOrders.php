<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class MyOrders extends Component
{
    public  $orders, $order_date, $order_id, $order_status, $to_order_date;
    public function mount()
    {
        $this->orders = Order::where('client_id', auth()->user()->id)->whereNotIn('status' , ['completed' , 'returned'])->get();
        // dd($jksa);
    }
    public function updatedOrderDate($val)
    {
        $this->GetOrdersWithAllFilter();
    }

    public function updatedOrderStatus($val)
    {
        $this->GetOrdersWithAllFilter();
    }

    public function updatedToOrderDate($val)
    {
        $this->GetOrdersWithAllFilter();
    }
    public function updatedOrderId($val)
    {
        $this->validate(['order_id' => 'required|exists:orders,id']);
        $this->orders = Order::where(['id' => $val, 'client_id' => auth()->user()->id])->get();
    }

    public function GetOrdersWithAllFilter()
    {
        $query = Order::query();
        $query->where('client_id' , auth()->user()->id);
        $query->whereNotIn('status' , ['completed' , 'returned']);
        $query->when($this->order_date != null, function ($q) {
            return $q->where('order_date', '>', $this->order_date);
        });
        $query->when($this->to_order_date != null, function ($q) {
            return $q->where('order_date', '<', $this->to_order_date);
        });

        $query->when($this->order_status != null, function ($q) {
            return $q->where('status', $this->order_status);
        });
        $this->orders =  $query->get();
    }

    public function render()
    {
        return view('livewire.my-orders' ,
        [
            'Orders' => $this->orders,
        ])
        ->layout('layouts.Edum')
        ;
    }
}
