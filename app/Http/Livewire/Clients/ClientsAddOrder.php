<?php

namespace App\Http\Livewire\Clients;

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
use Livewire\WithFileUploads;
use phpDocumentor\Reflection\DocBlock\Serializer;

class ClientsAddOrder extends Component
{
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $service_id, $client_id, $representative_id,
        $sender_name, $sender_phone, $sender_area_id,
        $sender_sub_area_id, $sender_address,
        $receiver_name, $receiver_phone_no,
        $receiver_area_id, $receiver_sub_area_id,
        $number_of_pieces,
        $order_value,
        $order_weight ,
        $receiver_address, $police_file, $order_fees, $is_payment_on_delivery, $payment_method = 'balance', $status;
    public $SenderSubArea, $ResevierSubArea, $SendingArea, $ResevingArea;

    public function mount()
    {
        $this->SendingArea = Area::withCount('subAreas')->get();
        $this->ResevingArea = Area::withCount('subAreas')->get();
        $this->ResevierSubArea = SubArea::get();
        $this->SenderSubArea = SubArea::get();
        $this->client_id = auth()->user()->id;
        $this->sender_name = auth()->user()->fullname;
        $this->sender_phone =  auth()->user()->phone;
        $this->sender_area_id =  auth()->user()->area_id;
        $this->sender_sub_area_id = auth()->user()->sub_area_id;
        $this->sender_address = auth()->user()->address;
    }
    public function store()
    {
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
                $validatedData['delivery_fees'] = (int) filter_var(service::find($this->service_id)->price, FILTER_SANITIZE_NUMBER_INT);
                $validatedData['total_fees'] =  $validatedData['order_fees'] - $validatedData['delivery_fees'];
            }

            // $validatedData['delivery_fees'] = (int) Area::find($this->sender_area_id)->fees;
            // $validatedData['total_fees'] = $validatedData['delivery_fees'] + $validatedData['order_fees'];
            $validatedData['order_date'] = date('Y-m-d H:i:s');
            $validatedData['status'] = 'pickup';
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
                    $validatedData['status'] = 'pending';

                $order_id = Order::insertGetId($validatedData);
                // insert order tracking
                orderTracking::insertOrderTracking($order_id, $validatedData['status'], $note, 'admin', auth()->user()->id);
                $Client->account_balance = $Client->account_balance +  $validatedData['total_fees'];
                $Client->save();
            });
            session()->flash('success', __('translation.item.created.successfully'));
            $this->resetInputFields();
            // toastr()->success('Success Message');
            return redirect()->route('OrderHistory');
            $this->emit('stored'); // Close model to using to jquery
        } catch (\Throwable $th) {
            throw $th;
            session()->flash('error', __('translation.error.exception'));
        }
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


    public function render()
    {
        return view('livewire.clients.clients-add-order', [
            'services' => Service::orderBy('id', 'desc')->get(),
            // 'areas' => $this->Area,
            'sub_areas' => SubArea::orderBy('id', 'desc')->get(),
            'clients' => Client::orderBy('id', 'desc')->get(),
            'representatives' => Representative::orderBy('id', 'desc')->get(),
            'SenderSubArea' => $this->SenderSubArea,
            'ResevierSubArea' => $this->ResevierSubArea,
            'ResevingArea' => $this->ResevingArea,
            'SendingArea' => $this->SendingArea,
        ]);
    }
}
