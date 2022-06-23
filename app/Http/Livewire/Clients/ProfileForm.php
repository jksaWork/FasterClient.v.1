<?php

namespace App\Http\Livewire\Clients;

use App\Models\Area;
use App\Models\Client;
use App\Models\SubArea;
use Exception;
use Livewire\Component;

class ProfileForm extends Component
{
    public $area_id, $subareas, $areas, $shipping_address,$name_in_invoice, $sub_area_id,$shipping_phone;

    public function mount(){
        $this->areas = Area::get();
        $this->subareas = SubArea::get();
        $this->sub_area_id = 1;
        $this->area_id = 1;
        $this->name_in_invoice = auth()->user()->name_in_invoice;
        $this->shipping_address = auth()->user()->address;
        $this->shipping_phone = auth()->user()->phone;
    }

    public function UpdateClient(){
            try{
                $ValidData = $this->validate([
                    'name_in_invoice' => 'required',
                    'shipping_address' => 'required',
                    'area_id'=> 'required',
                    'sub_area_id'=> 'required',
                    'shipping_phone' => 'required',
                ]);
                // jksa altigani osamn
                $data = [
                    'address' => $ValidData['shipping_address'],
                    'area_id'=> $ValidData['area_id'],
                    'sub_area_id'=>$ValidData['sub_area_id'],
                    'name_in_invoice'=>$ValidData['name_in_invoice'],
                    'phone' => $ValidData['shipping_phone'],
                ];
                Client::find(auth()->user()->id)->update($data);
                $this->emit('success_message');
                redirect()->route('profile');
            }catch(Exception $e){
                dd($e);
            }
    }
    public function updatedAreaId($val){
        $this->subareas = SubArea::where('area_id' , $val)->get();
    }
    public function render()
    {
        return view('livewire.clients.profile-form',
        [
            'areas' =>$this->areas,
            'subareas'=>$this->subareas,
        ]);
    }
}
