<?php

namespace App\Http\Livewire;

use App\Http\Resources\AreaService;
use App\Models\Area;
use App\Models\AreaServices;
use App\Models\Client;
use App\Models\ClientServicePrice;
use App\Models\Order;
use App\Models\orderTracking;
use App\Models\Representative;
use App\Models\RepresentativeOrdersPercentage;
use App\Models\SerialSetting;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SubArea;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Nette\Utils\Random;

class ShowOrder extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $service_id, $client_id, $representative_id,
     $sender_name, $sender_phone, $sender_area_id,
     $sender_sub_area_id, $sender_address,
     $receiver_name, $receiver_phone_no,
      $receiver_area_id, $receiver_sub_area_id,
      $receiver_address, $police_file, $order_fees, $is_payment_on_delivery, $payment_method = 'balance', $status;
    public $is_fill_sender = 1;
    public $update_mode = false;
    public $order_id;
    public $searchTerm, $from_date, $to_date;
    protected $listeners = ['orderDelete'];

    // last edit in this class by jksa  ############################
    public $SenderSubArea , $ResevierSubArea ,$SendingArea , $ResevingArea;

    public function mount(){
        $this->SendingArea = Area::withCount('subAreas')->get();
        $this->ResevingArea = Area::withCount('subAreas')->get();
        $this->ResevierSubArea = SubArea::get();
        $this->SenderSubArea = SubArea::get();
    }

    public function updatedServiceId($service_id)
    {
        // dd($service_id);
        $AreaSendingIds =  AreaServices::where('service_id' , $service_id)->where('is_sending' , 1)->get()->pluck('area_id');
        $AreaResivingIds =  AreaServices::where('service_id' , $service_id)->where('is_resiving' , 1)->get()->pluck('area_id');
        // $this->Area = Area::withCount('subAreas')->whereIn('id', $AreaSendingIds)->get();
        $this->ResevingArea = Area::withCount('subAreas')->whereIn('id', $AreaResivingIds)->get();
        $this->SendingArea = Area::withCount('subAreas')->whereIn('id', $AreaSendingIds)->get();
        // dd( $this->Areas);
        if($service_id)
        $this->is_fill_sender = Service::find($service_id)->is_fill_sender;
    }

    public function HandelServiceChange($id){
        dd($this->service_id);
    }
    public function updatedSenderAreaId($val){
        $this->SenderSubArea = SubArea::where('area_id' , $val)->get();

    }
    public function updatedReceiverAreaId($val){ #receiver_area_id
        $this->updatedServiceId($this->service_id);

        $this->ResevierSubArea = SubArea::where('area_id' , $val)->get();
    }
    public function HandelCahnge($id){
        $id1 = $id;
        // dd($id);
    }

    // public function updatedServiceId

    public function updated(){
        $this->updatedServiceId($this->service_id);
    }
    public function hydrate()
    {
        $this->emit('select2');
    }

    public function orderDelete($order_id)
    {
        $status = Order::find($order_id)->update(['is_deleted' => 1]);
        if ($status) {
            session()->flash('success', __('translation.item.deleted.successfully'));
            $this->render();
        } else {
            session()->flash('success', __('translation.delete.exception'));
        }
    }

    public function updatedClientId($clientId)
    {
        try{
        $this->validate(['client_id' =>'exists:clients,id']);
        $client = Client::find($clientId);
        if ($this->is_fill_sender) {
            $this->sender_name = $client->fullname;
            $this->sender_phone = $client->phone;
            $this->sender_area_id = $client->subArea->area_id;
            $this->sender_sub_area_id = $client->sub_area_id;
            $this->sender_address = $client->address;
        } else {
            $this->receiver_name = $client->fullname;
            $this->receiver_phone_no = $client->phone;
            $this->receiver_area_id = $client->subArea->area_id;
            $this->receiver_sub_area_id = $client->sub_area_id;
            $this->receiver_address = $client->address;
        }
        }catch(Exception $e){

        }
    }

    public function store()
    {
        $validatedData = $this->validate([
            'service_id' => 'required|exists:services,id',
            'client_id' => 'required|exists:clients,id',
            'sender_name' => 'required|string',
            'sender_phone' => 'required',
            'sender_area_id' => 'required|exists:areas,id',
            'sender_sub_area_id' => 'required|exists:sub_areas,id',
            'sender_address' => 'required',
            'receiver_name' => 'required|string',
            'receiver_phone_no' => 'required|String',
            'receiver_area_id' => 'required|exists:areas,id',
            'receiver_sub_area_id' => 'required|exists:sub_areas,id',
            'receiver_address' => 'required',
            'representative_id' => 'nullable|exists:representatives,id',
            // 'payment_method' => 'required|in:"on_sending", "on_receiving","balance"',
            'order_fees' => 'numeric|min:0',
            'police_file' => 'nullable|mimes:jpg,jpeg,png,bmp,svg,webp,pdf',
            // 'is_payment_on_delivery' => 'nullable|in:0,1',
        ]);

        try {
            //ensure order fees is 0 when payment method = balance
            // if ($validatedData['payment_method'] == "balance") {
            //     $validatedData["order_fees"] = 0;
            // }


            if ($this->police_file) {
                $police_file_path = $this->police_file->store('orders');
            } else {
                $police_file_path = "";
            }

            $Client = Client::find($this->client_id);
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


            DB::transaction(function () use ($validatedData , $Client) {
                //generate invoice no
                $inv_no = SerialSetting::first()->inv_no;
                SerialSetting::first()->update(["inv_no" => ($inv_no + 1)]);
                $validatedData['invoice_sn'] = genInvNo($inv_no);

                $validatedData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
                $user_name = auth()->user()->name;
                $note = "order has been placed by admin ($user_name)" ;
                if($this->representative_id){
                    $representative_name = Representative::find($validatedData['representative_id'])->fullname;
                    $note .="and assigned to representative ($representative_name)";
                }else{
                    $this->representative_id = null;
                }

                $order_id = Order::insertGetId($validatedData);

                //insert order tracking

                orderTracking::insertOrderTracking($order_id, $validatedData['status'], $note, 'admin', auth()->user()->id);
                $Client->account_balance = $Client->account_balance +  $validatedData['total_fees'];
                $Client->save();

            });

            // representative deserves calculation
            // $representative_deserves_calculation_method = Setting::where('key', 'representative_deserves_calculation_method')->first()->value;
            // if ($representative_deserves_calculation_method == 'percentage') {
            //     $representative_percentage = Setting::where('key', 'representative_percentage')->first()->value;
            //     $representative_deserves = $validatedData['delivery_fees'] * ($representative_percentage / 100);
            //     RepresentativeOrdersPercentage::create(
            //         ['representative_id' => $validatedData['representative_id'], 'order_id' => $order_id, 'deserve' => $representative_deserves]
            //     );
            // }

            session()->flash('success', __('translation.item.created.successfully'));

            $this->resetPage();

            $this->resetInputFields();

            $this->emit('stored'); // Close model to using to jquery
        } catch (\Throwable $th) {
            // throw $th;
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

    public function edit($id)
    {
        $this->updateMode = true;
        $order = Order::where('id', $id)->first();
        $this->order_id = $id;
        $this->service_id = $order->service_id;
        $this->client_id = $order->client_id;
        $this->sender_name = $order->sender_name;
        $this->sender_phone = $order->sender_phone;
        $this->sender_area_id = $order->sender_area_id;
        $this->sender_sub_area_id = $order->sender_sub_area_id;
        $this->sender_address = $order->sender_address;
        $this->receiver_name = $order->receiver_name;
        $this->receiver_phone_no = $order->receiver_phone_no;
        $this->receiver_area_id = $order->receiver_area_id;
        $this->receiver_sub_area_id = $order->receiver_sub_area_id;
        $this->receiver_address = $order->receiver_address;
        $this->representative_id = $order->representative_id;
        $this->order_fees = $order->order_fees;
        $this->payment_method = $order->payment_method;
        $this->police_file = $order->police_file;
        $this->is_payment_on_delivery = $order->is_payment_on_delivery;
    }

    public function update()
    {
        try{
            $validatedData = $this->validate([
                'service_id' => 'required|exists:services,id',
                'client_id' => 'required|exists:clients,id',
                'sender_name' => 'required|string',
                'sender_phone' => 'required',
                'sender_area_id' => 'required|exists:areas,id',
                'sender_sub_area_id' => 'required|exists:sub_areas,id',
                'sender_address' => 'required',
                'receiver_name' => 'required|string',
                'receiver_phone_no' => 'required|String',
                'receiver_area_id' => 'required|exists:areas,id',
                'receiver_sub_area_id' => 'required|exists:sub_areas,id',
                'receiver_address' => 'required',
                'representative_id' => 'nullable|exists:representatives,id',
                'order_fees' => 'numeric|min:0',
                'payment_method' => 'required|in:"on_sending", "on_receiving", "balance"',
                'police_file' => 'nullable',
                // 'is_payment_on_delivery' => 'nullable',
            ]);

            if ($this->order_id) {
                $order = Order::find($this->order_id);
                if ($this->police_file != $order['police_file']) {
                    $photo_path = $this->police_file->store('orders');
                } else {
                    $photo_path = $order['police_file'];
                }

                //ensure order fees is 0 when payment method = balance
                // if ($validatedData['payment_method'] == "balance") {
                //     $validatedData["order_fees"] = 0;
                // }

                if ($this->order_fees !== $order->order_fees) {

                    $validatedData['delivery_fees'] = (int) filter_var(service::find($this->service_id)->price, FILTER_SANITIZE_NUMBER_INT);
                    $validatedData['total_fees'] =  $validatedData['order_fees'] - $validatedData['delivery_fees'];
                    $Client = Client::find($this->client_id);
                    // sub old value and add new Fees
                    $Client->account_balance = $Client->account_balance  - $order->total_fees + $validatedData['total_fees'];
                    // add new order fees
                    // $Client->account_balance =   $Client->account_balance + $request->order_fess;
                    $Client->save();
                }
                if(!$this->representative_id)
                    $validatedData['representative_id'] = null;
                $validatedData['representative_deserves'] = (int) filter_var(Area::find($this->sender_area_id)->fees, FILTER_SANITIZE_NUMBER_INT) * (env('REPRESENTATIVE_PERCENTAGE') / 100);
                $validatedData['company_deserves'] = $validatedData['delivery_fees'] - $validatedData['representative_deserves'];
                // $validatedData['is_payment_on_delivery'] = $validatedData['is_payment_on_delivery'] ? 1 : 0;
                // $validatedData['order_date'] = date('Y-m-d H:i:s');
                // $validatedData['status'] = 'inProgress';
                $validatedData['police_file'] = $photo_path;

                $order->update($validatedData);
                $this->updateMode = false;
                session()->flash('success', __('translation.item.updated.successfully'));
                $this->emit('updated'); // Close model to using to jquery
                $this->resetInputFields();
            }
        }catch(\Exception $e){
            session()->flash('error', __('error.exception'));
            $this->emit('updated');
        }
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatedPaymentMethod($value)
    {
        // if ($value == "balance") {
        //     $this->order_fees = 0;
        // }
    }





    public function render()
    {


        $searchTerm = '%' . $this->searchTerm . '%';

        $data = Order::where('id', 'like', $searchTerm)
        ->when($this->from_date, function ($query, $from_date) {
            return $query->where('order_date', ">=", $from_date . " 00:00:00");
        })
        ->when($this->to_date, function ($query, $to_date) {
            return $query->where('order_date', "<=", $to_date . " 23:59:59");
        })
        ->IsDeleted()
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('livewire.show-order', [
            'data' => $data,
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
