<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientDashboradController extends Controller
{
    public function index(){
        $data['chart'] = DB::select('SELECT status as name , count(id) as y FROM orders WHERE client_id = ? GROUP BY status', [auth()->user()->id]);#->get();
        $data['orders'] = Order::with('service')->latest()->limit(5)->get();
        $data['order_in_month'] = Order::where('created_at', '>', Carbon::now()->subMonth())->get();
        // dd($data['order_in_month']);
        // dd();
        $chart2 = collect($data['chart']);
        $MappedChart  = $chart2->map(function($el, $i){
            return ["name" => __('translation.' . $el->name) , 'y' => $el->y];
        });
        $data['chart'] = $MappedChart;
        // dd($data['chart']);
        // notify()->error('The provided credentials do not match our records.');
        return view('clients.dashboard.index', $data);
    }

    public function addOrder(){
        return view('clients.dashboard.addorder');
    }

    public function OrderHistory(){
        $Orders = Order::where('client_id' , auth()->user()->id)->paginate();
        return view('clients.dashboard.orderHistory' , compact('Orders'));
    }

    public function profile(){
        return view('clients.dashboard.profile');
    }
}
