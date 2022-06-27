<?php

namespace App\Http\Livewire\Clients;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class ClientHitory extends Component
{
    // use WithPagination;
    public  $orders , $order_date, $order_id , $order_status;
    public function mount(){
        $this->orders = Order::where('client_id', auth()->user()->id)->get();
        // dd($jksa);
    }
    public function updatedOrderDate($val){
        $this->orders = Order::where('order_date', '>' , $val)->get();
        // dd($this->orders);
    }
    public function updatedOrderStatus($val){
        $this->orders = Order::where(['status'=> $val , 'client_id' => auth()->user()->id])->get();
        // dd($val);
    }
    public function updatedOrderId($val){
        $this->validate(['order_id' => 'required|exists:orders,id']);
        $this->orders = Order::where(['id'=> $val , 'client_id' => auth()->user()->id])->get();
    }
    public function render()
    {
        // dd($this->orders2);
        return view('livewire.clients.client-hitory',[
            'Orders' => $this->orders,
        ]
        );
    }
}
