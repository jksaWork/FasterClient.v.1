<?php

namespace App\Http\Livewire\Clients;

use App\Models\Order;
use Livewire\Component;

class ClientDashBoardOrders extends Component
{
    public $order, $ids = [];
    public function mount(){
        // $this->ids = [];
        $this->orders = Order::with('service')->latest()->limit(5)->get();
    }
    // add Order To Order Ids  ---------------
    public function AddIdTOOrderIds($val){
        array_push($this->ids, $val);
        dd($this->ids);
    }
    public function render()
    {
        return view('livewire.clients.client-dash-board-orders',
        [
            'orders' => $this->orders,
        ]
    );
    }
}
