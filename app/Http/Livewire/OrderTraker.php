<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\orderTracking;
use Livewire\Component;

class OrderTraker extends Component
{
    // public
    public $order_id, $AddedID, $traker;
    public function mount(){
        $this->traker = orderTracking::where('id' , null)->get();
    }
    public function AddIdToIds(){
        // if()
        $order = Order::where(['client_id' => 'client_id' , 'id' => $this->AddedID])->get();

        if($order)$this->traker = orderTracking::where('order_id' , $this->AddedID)->get();
        else $this->traker = orderTracking::where('id' , null)->get();// dd($this->traker);
    }
    public function render()
    {
        return view('livewire.order-traker', [
            'traker' => $this->traker,
            'statusList' =>  ['pending' => 'badge-success', 'pickup' => 'badge-info', 'inProgress' => 'badge-info', 'delivered' =>'badge-success', 'completed' => 'badge-light', 'returned'=> 'badge-secondary', 'canceled' => 'badge-success'],
        ])
        ->layout('layouts.Edum');
    }
}
