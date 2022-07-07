<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Client;
use App\Models\ClientServicePrice;
use App\Models\Order;
use App\Models\orderTracking;
use App\Models\Representative;
use App\Models\SerialSetting;
use App\Models\Service;
use App\Models\SubArea;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReturedOrder extends Component
{

    public  $order_id,  $order,  $show_from, $sub_areas;
    public $service_id, $client_id, $representative_id,
        $sender_name, $sender_phone, $sender_area_id,
        $sender_sub_area_id, $sender_address,
        $receiver_name, $receiver_phone_no,
        $receiver_area_id, $receiver_sub_area_id,
        $number_of_pieces,
        $order_value,
        $order_weight,
        $receiver_address, $police_file, $order_fees, $is_payment_on_delivery, $payment_method = 'balance', $status;
    public $SenderSubArea, $ResevierSubArea, $SendingArea, $ResevingArea;

    public function mount()
    {
        $this->SendingArea = Area::withCount('subAreas')->get();
        $this->ResevingArea = Area::withCount('subAreas')->get();
        $this->ResevierSubArea = SubArea::get();
        $this->SenderSubArea = SubArea::get();
        $this->sub_areas  = SubArea::get();
        // $this->client_id = auth()->user()->id;
        // $this->receiver_name = auth()->user()->fullname;
        // $this->receiver_phone_no =  auth()->user()->phone;
        // $this->sender_area_id =  auth()->user()->area_id;
        // $this->sender_sub_area_id = auth()->user()->sub_area_id;
        // $this->sender_address = auth()->user()->address;
    }


    public function NextPage()
    {
        $this->validate(['order_id'  => 'required|integer|exists:orders,id']);
        $this->order  = Order::where(['id' => $this->order_id, 'client_id' => auth()->user()->id])->first();

        if ($this->order) {
            $this->show_from = true;
            $this->fillForm();
        } else {
            session()->put('order_id', 'Re Type The Order Id');
        };
    }
    public function render()
    {
        return view('livewire.retured-order')
            ->layout('layouts.Edum');
    }



    public function fillForm()
    {
        $this->service_id = 1;
        $this->client_id = auth()->user()->id;
        $this->representative_id = $this->order->representative_id  ?? null;
        // sender data
        $this->sender_name  =        $this->order->receiver_name;
        $this->sender_phone  =       $this->order->receiver_phone_no;
        $this->sender_area_id   =    $this->order->receiver_area_id;
        $this->sender_sub_area_id  = $this->order->receiver_sub_area_id;
        $this->sender_address  =     $this->order->receiver_address;

        // $this->sender_name = $this->order->sender_name;
        // $this->sender_phone = $this->order->sender_phone;
        // $this->sender_area_id  = $this->order->sender_area_id;
        // $this->sender_sub_area_id =  $this->order->sender_sub_area_id;
        // $this->sender_address = $this->order->sender_address;
        // resever data
        $this->receiver_name = $this->order->sender_name;
        $this->receiver_phone_no = $this->order->sender_phone;
        $this->receiver_area_id = $this->order->sender_area_id;
        $this->receiver_sub_area_id = $this->order->sender_sub_area_id;
        $this->receiver_address = $this->order->sender_address;     // $this->order->order_weight;

        $this->number_of_pieces = $this->order->number_of_pieces;
        $this->order_value = $this->order->order_value;
        $this->order_weight = $this->order->order_weight;
        $this->order_fees  = $this->order->order_fees;
    }

    public function store()
    {
        $this->order->status = 'completed';
        $this->order->save();
        // dd($this->order);
        $validatedData = $this->validate([
            'sender_name' => 'required|string',
            'sender_phone' => 'required',
            'sender_area_id' => 'required|exists:areas,id',
            'sender_sub_area_id' => 'required|exists:sub_areas,id',
            'sender_address' => 'required',
            'service_id' => 'required|exists:services,id',
            'receiver_name' => 'required|string',
            'receiver_phone_no' => 'required|String',
            'receiver_area_id' => 'required|exists:areas,id',
            'receiver_sub_area_id' => 'required|exists:sub_areas,id',
            'receiver_address' => 'required',
            'representative_id' => 'nullable|exists:representatives,id',
            'order_fees' => 'numeric|min:0',
            'police_file' => 'nullable|mimes:jpg,jpeg,png,bmp,svg,webp,pdf',
            'number_of_pieces' => 'required',
            'order_weight' => 'required',
            'order_value' => 'required',
        ]);

        try {
            if ($this->police_file) {
                $police_file_path = $this->police_file->store('orders');
            } else {
                $police_file_path = "";
            }

            $Client = Client::find(auth()->user()->id);
            if ($Client->is_has_custom_price) {
                $validatedData['delivery_fees'] = (int) filter_var(ClientServicePrice::where('service_id', $this->service_id)->where('client_id', $Client->id)->first()->price, FILTER_SANITIZE_NUMBER_INT);
                $validatedData['total_fees'] =  $validatedData['order_fees'] - $validatedData['delivery_fees'];
            } else {
                $validatedData['delivery_fees'] = (int) filter_var(Service::find($this->service_id)->price, FILTER_SANITIZE_NUMBER_INT);
                $validatedData['total_fees'] =  $validatedData['order_fees'] - $validatedData['delivery_fees'];
            }

            // $validatedData['delivery_fees'] = (int) Area::find($this->sender_area_id)->fees;
            // $validatedData['total_fees'] = $validatedData['delivery_fees'] + $validatedData['order_fees'];
            $validatedData['order_date'] = date('Y-m-d H:i:s');
            $validatedData['status'] = 'returned';
            $validatedData['police_file'] = $police_file_path;


            DB::transaction(function () use ($validatedData, $Client) {

                //generate invoice no
                $inv_no = SerialSetting::first()->inv_no;
                SerialSetting::first()->update(["inv_no" => ($inv_no + 1)]);
                $validatedData['invoice_sn'] = genInvNo($inv_no);
                $validatedData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
                $user_name = auth()->user()->name;
                $note = "order has been placed by admin ($user_name)";

                if ($this->representative_id) {
                    $representative_name = Representative::find($validatedData['representative_id'])->fullname;
                    $note .= "and assigned to representative ($representative_name)";
                } else {
                    $this->representative_id = null;
                }

                $validatedData['client_id'] = auth()->user()->id;
                $validatedData['representative_id'] = null;
                $validatedData['status'] = 'returned';
                $order_id = Order::insertGetId($validatedData);
                // dd($order_id);
                orderTracking::insertOrderTracking($order_id, $validatedData['status'], $note, 'admin', auth()->user()->id);
                $Client->account_balance = $Client->account_balance +  $validatedData['total_fees'];

                $Client->save();
            });
            session()->flash('success', __('translation.item.created.successfully'));
            return redirect()->route('OrderHistory');
            $this->resetInputFields();
            // toastr()->success('Success Message');
            return redirect()->route('OrderHistory');
            $this->emit('stored'); // Close model to using to jquery
        } catch (\Throwable $th) {
            throw $th;
            session()->flash('error', __('translation.error.exception'));
        }
    }

    public function GoBack()
    {
        $this->show_from = false;
    }
    private function resetInputFields()
    {
        $this->service_id = '';
        $this->order_id = '';
        $this->client_id = '';
        $this->sender_name = '';
        $this->sender_phone = '';
        $this->sender_area_id = '';
        $this->sender_sub_area_id = '';
        $this->sender_address = '';
        $this->receiver_name = '';
        $this->receiver_phone_no = '';
        $this->receiver_area_id = '';
        $this->receiver_sub_area_id = '';
        $this->receiver_address = '';
        $this->representative_id = '';
        $this->order_fees = '';
        $this->payment_method = '';
        $this->police_file = '';
        $this->is_payment_on_delivery = '';
    }
}
