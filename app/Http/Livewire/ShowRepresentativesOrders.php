<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\orderTracking;
use App\Models\Representative;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Events\SendNotifcationWithFireBase;
use App\Traits\SendNotifcationWithFirebaseTrait;
use Exception;
use App\Exceptions\NotifcationException;

class ShowRepresentativesOrders extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ["status_change_confirmation" => 'status_change_confirmed', 'representative_change_confirmation' => 'representative_change_confirmed'];
    public $representative_id, $status = "pickup";
    public $order_transfer_data;
    public $status_change_data;

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function updatedStatusChangeData($status_change_data)
    {
        // dd('jksa');
        $status_change_data = json_decode($status_change_data);

        if ($status_change_data->status == "pending") {
            $this->emit('status_change_to_pending_confirmation', $status_change_data);
        } else {
            $this->emit('status_change_confirmation', $status_change_data);
            // dd('emit' , $status_change_data);
        }
    }

    public function status_change_confirmed($status_change_data)
    {

        // dd($status_change_data);
        try {
            $order = Order::find($status_change_data['order_id']);
             $noteFromOuteScope  = DB::transaction(function () use ($status_change_data, $order) {
                if ($status_change_data['status'] == "pending") {
                    $order->update(['status' => $status_change_data['status'], 'representative_id' => null]);
                    // session()->flash('success', __('translation.item.updated.successfully'));
                } else if ($status_change_data['status'] == "returned") {
                    $order_return_price = Setting::where('key', 'order_return_price')->first()->value;
                    $order->update(['delivery_fees' => $order_return_price, 'status' => $status_change_data['status']]);
                    // session()->flash('success', __('translation.item.updated.successfully'));
                } else {
                    $order->update(['status' => $status_change_data['status']]);
                    // session()->flash('success', __('translation.item.updated.successfully'));
                }

                // insert into order tracking
                $user_name = auth()->user()->name;
                $Representative = Representative::find($order->representative_id);
                $note = "order status has been changed to " . $status_change_data['status'] . " by admin ($user_name)";
                $note_ar = __('translation.Order_status_change_to') ." " . __('translation.' . $status_change_data['status'] ) ." " . __('translation.By') . " ". ($user_name);
                orderTracking::insertOrderTracking($status_change_data['order_id'], $status_change_data['status'], $note, 'admin', auth()->user()->id , $note_ar);
                session()->flash('success', __('translation.item.status.updated.successfully'));
                return [$note , $note_ar];
            });
            $Representative = Representative::find($order->representative_id);
            event(new SendNotifcationWithFireBase($Representative->message_token , __('translation.OrderMangemnt') , $noteFromOuteScope[1] , '' , $order->id));
            // dd($noteFromOuteScope[1]);
            session()->flash('sccuess' ,__('translation.ChangeRepreSentiveSuccessFuly'));

        } catch(NotifcationException $Ne){
            session()->flash('error' ,__('translation.Notification_Send_Error'));
        }
         catch (\Throwable $th) {
            // dd($th);
            session()->flash('error', __('translation.error.exception'));
        }
    }



    public function updatedOrderTransferData($order_transfer_data)
    {
        $this->emit('representative_change_confirmation', $order_transfer_data);
    }
    public function representative_change_confirmed($order_transfer_data)
    {
        $order_transfer_data = json_decode($order_transfer_data);
        // dd();

        try{
            if ($order_transfer_data) {
                $order = Order::find($order_transfer_data->order_id);
                // dd($order_transfer_data['representative_id']);
                if($order->representative_id == $order_transfer_data->representative_id) return;
                $representativeMessageToken  = Representative::find($order_transfer_data->representative_id)->message_token;
                $CancelNotification =__('translation.Notification_Cancel_order') ." " .$order_transfer_data->order_id . " " . __('translation.ByMangement');
                event(new SendNotifcationWithFireBase($representativeMessageToken , __('translation.OrderMangemnt') ,$CancelNotification , '', null ));
                $order->update(['representative_id' => $order_transfer_data->representative_id]);
                // insert into order tracking
                $user_name = auth()->user()->name;
                $representative2 = Representative::find($order_transfer_data->representative_id);
                $status = $order->status;
                $note = "order has been transferred to another representative ( " . $representative2->fullname . " ) by admin ($user_name)";
                $note_ar = __('translation.Admin_Order_representative_change_to') ." $representative2->fullname ";
                orderTracking::insertOrderTracking($order_transfer_data->order_id, $status, $note, 'admin', auth()->user()->id);
                $NotificationNote = __('translation.OrderMangemnt_Add_New_Order_You') ." ".  $order->id ." ".__('translation.ByMangement');
                event(new SendNotifcationWithFireBase($representative2->message_token , __('translation.OrderMangemnt') ,$NotificationNote , '', null ));
                $this->render();
                session()->flash('success', __('translation.ChangeRepreSentiveSuccessFuly'));
                // dd([ $CancelNotification , $NotificationNote ]);
            }
        } catch(NotifcationException $Ne){
            session()->flash('error' ,__('translation.Notification_Send_Error'));
        }
         catch (\Throwable $th) {
            // dd($th);
            session()->flash('error', __('translation.error.exception'));
        }
    }


    public function render()
    {
        $data = Order::when($this->representative_id, function ($query) {
            $query->where(['representative_id' => $this->representative_id]);
        })->when($this->status, function ($query) {
            $query->where(['status' => $this->status]);
        })->IsDeleted()->paginate(10);
        return view('livewire.show-representatives-orders', [
            'data' => $data,
            'representatives' => Representative::get(),
        ]);
    }
}
