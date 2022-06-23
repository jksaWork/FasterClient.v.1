<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ShowClientsPayment extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $client_id;
    public $checked_orders = [];
    public $total_fees = 0;


    public function updatedCheckedOrders($value, $row_id)
    {
        // dd($row_id);

        if ($value) {
            $this->total_fees += Order::find($row_id)->order_fees;
        } else {
            $this->total_fees -= Order::find($row_id)->order_fees;
        }
    }


    public function collectCheckedOrders()
    {
        // dd($this->checked_orders);
        if ($this->total_fees > 0) {
            try {
                //percentage process
                DB::transaction(
                    function () {
                        //Insert into transactions
                        $transaction_id = insertTransaction('is_client_payment', null, $this->client_id, $this->total_fees);
                        foreach ($this->checked_orders as $order_id => $client_id) {
                            $order = Order::find($order_id);
                            //update table
                            $order->update([
                                'is_client_payment_made' => 1,
                                // 'payment_date' => date('Y-m-d h:m:s'),
                                'client_payment_transaction_id' => $transaction_id,
                            ]);
                        }
                        //update representative account balance
                        $client = Client::find($this->client_id);
                        $client_new_balance = ($client->account_balance - $this->total_fees);
                        $client->update(['account_balance' => $client_new_balance]);
                    }
                );

                session()->flash('success', __('translation.fees.collection.done'));

                $this->resetInputFields();

                $this->resetPage();
            } catch (\Throwable $th) {
                dd($th);
                session()->flash('error', __('translation.fees.collection.error'));
            }
        } else {
            session()->flash('error', __('translation.no.order.chosen.error'));
        }
    }


    public function updatedClientId()
    {
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->checked_orders = [];
        $this->total_fees = 0;
    }

    public function render()
    {
        $clients = DB::table('clients')->selectRaw('clients.*')->get();
        foreach ($clients as $key => $value) {
            $value->orders_count = Order::where(['client_id' => $value->id, 'is_client_payment_made' => '0', 'status' => 'completed'])->where("order_fees", "!=", 0)->count();
        }
        // $data = clientOrdersPercentage::where(['client_id' => $this->client_id, 'is_paid' => 0])->paginate();
        $data = DB::table('orders')->selectRaw('orders.order_fees as deserve, orders.id as order_id')
            ->where(['orders.client_id' => $this->client_id, 'is_client_payment_made' => 0, 'status' => 'completed'])->where("order_fees", "!=", 0)->paginate();
        return view('livewire.show-clients-payment', [
            'data' => $data,
            'clients' => $clients,
        ]);
    }
}
