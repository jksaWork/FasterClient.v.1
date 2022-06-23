<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\ClientPay;
use App\Models\IssueClientStatement;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ClientAccountTransaction extends Component
{
    public $client_id;
    public $from_date;
    public $to_date, $client, $client_name;
    public $total_amount_in = 0;
    public $total_amount_out = 0;
    public $client_current_account_balance = 0;
    public $checked_orders = [], $total_fees = 0;
    public $ClientIssue;
    // public $listeners  = ['fresh' => '$refresh'];
    // public function updatedCheckedOrders($value, $order_id)
    // {

    //     // dd($value , $order_id);
    //     // dd($this->checked_orders);
    //     // dd([$order_id ,$this->checked_orders]);
    //     // if ($value) {
    //     //     $this->total_fees += Order::find($order_id)->total_fees;
    //     // } else {
    //     //     $this->total_fees -= Order::find($order_id)->total_fees;
    //     // }
    //     // dd($this->total_fees);
    // }

    public function updatedClientIssue($key, $value)
    {
        dd($key, $value);
    }

    public function hydrate()
    {
        $this->emit("select2");
        $this->total_amount_in = 0;
        $this->total_amount_out = 0;
    }




    public function getData()
    {
        $this->client_name = null;
        return $data = Order::where('id', null)->IsDeleted()->whereIn('service_id', [1, 2])->get();
    }

    public function PayToClient()
    {
        if ($this->client_id) {
            $ids = array_keys($this->checked_orders);
            $idsJson = json_encode($ids);
            Order::whereIn('id', $ids)->update(['is_collected' => 1]);
            $this->client_id = null;
            $this->total_fees = 0;
            $this->checked_orders = [];
            session()->flash('success', 'collection are done');
        } else {
            session()->flash('error', 'you must have a client');
        }
        // dd( , $this->total_fees);
    }


    public function getDataWithName()
    {
        $fromDate = $this->from_date;
        $ToDate = $this->to_date;
        $this->client_name = Client::find($this->client_id)->fullname;
        // dd($this->client_name);
        return $data = Order::IsDeleted()->whereIn('service_id', [1, 2])->where(['client_id' => $this->client_id, 'is_collected' => 0])->when($fromDate, function ($query, $from_date) {
                return $query->where('order_date', '>', $from_date);
            })->when($ToDate, function ($query, $from_date) {
                return $query->where('order_date', '<', $from_date);
            })
            ->get();
    }

    public function ExportIssueToClient($id)
    {
        $Client  = Client::with('Orders')->where(['id' =>  $id, 'in_accounts_order' => 1])->first();
        if($Client->Orders ==  null ) return ;
        if ($Client) {
            $totalBlade = 0;
            $DeliveryFess = [];
            // $totalOfService = 0;
            $OrderDeliveryFess = 0;
            foreach ($Client->Orders as $Order) {
                $OrderDeliveryFess += $Order->delivery_fees;
                $totalBlade += $Order->total_fees;
                // $totalOfService += $Order->total_fees - $Order->delivery_fees;
                if (isset($DeliveryFess[$Order->service_id])) {
                    $DeliveryFess[$Order->service_id] +=  (int) $Order->delivery_fees;
                } else {
                    $DeliveryFess[$Order->service_id] =  (int) $Order->delivery_fees;
                }
            }
            $totalOfService = ($DeliveryFess[1] ?? 0) + ($DeliveryFess[2] ?? 0);
            $OrderArray = $Client->Orders->pluck('id');
            $OrdersTotalFess = $totalBlade - $OrderDeliveryFess;
            // dd($DeliveryFess , $totalOfService ,$totalBlade , $DeliveryFess[1] + $DeliveryFess[2] );
            Order::whereIn('id', $OrderArray)->update(['is_collected' =>  1]);
            $DataForCreate = [
                'total_shiping_type' => $DeliveryFess[2]  ?? 0,
                'total_deleviry_fess' => $DeliveryFess[1] ?? 0,
                'total_order_fess' => $totalBlade,
                'total_service_fess' => $totalOfService,
                'total_fess' => $OrdersTotalFess,
                'orders_ids' => json_encode($OrderArray),
                'status' => 'unpaid',
                'client_id' => $Client->id,
            ];
            // dd($DataForCreate);
            IssueClientStatement::create($DataForCreate);
            $Client->in_accounts_order = 0;
            $Client->save();
        } else {
            dd('Client Is Not Exsit');
        }
    }

    public function ExportIssueToClientWithCheckBoxs()
    {
        foreach ($this->checked_orders as $ClientId) {
            $this->ExportIssueToClient($ClientId);
        }
    }

    public function render()
    {
        $Client = Client::with('Orders')->where('in_accounts_order', 1)->orderBy('updated_at', 'DESC')->get();
        // dd($Client);
        if (!$this->client_id && !$this->from_date && !$this->to_date) {
            $data = $this->getData();
        } elseif ($this->client_id && !$this->from_date && !$this->to_date) {
            $data = $this->getDataWithName();
        } elseif ($this->client_id && $this->from_date && !$this->to_date) {
            $data =  $this->getDataWithName();
        } elseif ($this->client_id && $this->from_date && $this->to_date) {
            $data =  $this->getDataWithName();
        } else {
            $data = $this->getData();
        }
        $total_fess = $data->sum('total_fees');
        $total_delevirey = $data->sum('delivery_fees');

        $total_delevirey_inner  = $data->where('service_id', 2)->sum('delivery_fees');
        $total_delevirey_outer = $data->where('service_id', 3)->sum('delivery_fees');
        $total_of_total = ($total_fess - $total_delevirey_outer) - $total_delevirey_inner;

        return view('livewire.client-account-transaction', [
            "data" => $data,
            "clients" => $Client,
            'total_delevirey_inner' => $total_delevirey_inner,
            'total_delevirey_outer' => $total_delevirey_outer,
            'total_fess' => $total_fess,
            'total_of_total' => $total_of_total,
            'total_delevirey' => $total_delevirey,
            'client_name' => $this->client_name,
        ]);
    }
}
