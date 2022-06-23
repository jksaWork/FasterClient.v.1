<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Representative;
use Livewire\Component;

class MultiOrderMangement extends Component
{

    public $orders , $reps ,  $AddedID   , $ids = [] , $Status = ['pending', 'pickup', 'inProgress', 'delivered', 'completed', 'returned', 'canceled'];
    public $NewRep ,  $NewStatus;

    public function  mount(){
        $this->orders = [];
        $this->reps = Representative::all();
    }
    public function AddIdToIds(){
        $this->validate([
            'AddedID' => 'integer|exists:orders,id'
        ] , [
            'integer' => 'يجب ان يكوت الحقل رقمي' ,
            'exists' => 'رقم الطلب غير موجود' ,
        ]
    );
        array_push($this->ids , $this->AddedID);
        $this->orders = Order::whereIn('id',$this->ids)->get();
        $this->AddedID = '';
    }
    //  remove Order From List  ##########################
    public function removeFromOrder($id){
        $this->ids = array_filter($this->ids, fn($el) => $el != $id);
        $this->orders = Order::whereIn('id',$this->ids)->get();
    }
    // change Orders Status        ########################
    public function ChangeOrdersStatus(){
        Order::whereIn('id' ,$this->ids)->update(['status' => $this->NewStatus]);
        $this->orders = Order::whereIn('id' ,$this->ids)->get();
        $this->emit('hidemodel');
    }

    public function ChangeRep(){
        // dd($this->NewRep);
        Order::whereIn('id' , $this->ids)->update(['representative_id' => $this->NewRep]);
        $this->orders = Order::whereIn('id' ,$this->ids)->get();
        $this->emit('hidemodel');
    }
    public function render()
    {
        return view('livewire.multi-order-mangement' , [
            "orders" => $this->orders,
            'representatives' => Representative::all(),
        ])
        ->layout('layouts.master');
        ;
    }
}
