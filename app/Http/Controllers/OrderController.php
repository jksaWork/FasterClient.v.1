<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function printInvoice($id)
    {

        $order = Order::find($id);
        return view("orders.invoice", [
            "order" => $order,
        ]);
    }
    public function importCSV()
    {
        return view('orders.importCSV');
    }

    public function orderTracking($id = null)
    {
        return view('orders.tracking', compact('id'));
    }

    public function show($id){
        $order = Order::find($id);
        return view('orders.info' , compact('order'));
    }

    public function printInvoices(Request $request){
        $ArrayIds =  explode(',' ,  $request->ids);
        $Orders = Order::whereIn('id' ,$ArrayIds)->get();
        $order = Order::first();
        return view('orders.invoices' , compact('Orders' , 'order'));
    }

    public function getOrderById($id){
        $validaotr = validator(compact('id') , [
            'id' => 'required',
        ]);
        if($validaotr->fails()) return $validaotr->errors();
        // Return Order If Exist ---------------------
        try{
            $order = DB::table('orders_full_data')
                ->select("*")
                ->where('id', '=', $id)
                ->where('is_deleted', '=', '0')
                ->get();
            // response ------------------------------
            return response([
                "status" => true,
                "data" => $order,
            ]);
        }catch(Exception $ex){
            return $ex;
        }
    }
}
