<?php

namespace App\Http\Livewire;

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
        $this->traker = orderTracking::where('order_id' , $this->AddedID)->get();
        // dd($this->traker);
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
