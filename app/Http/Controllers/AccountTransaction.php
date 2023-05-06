<?php

namespace App\Http\Controllers;

// use Facade\FlareClient\Http\Client;

use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;

class AccountTransaction extends Controller
{
    public function index()
    {
        $client = Client::with([
            'ServicePrice', 'Orders' => function ($q) {
                // $q->where('is_collected', 0);
                // $q->where('status', 'completed');
            }
        ])->find(auth()->user()->id);

        $data['clients'] = [$client];
        $ServiceHeading = [
            1 => [
                '<div>
        <h4> COD Orders - Delivered </h4>
        <h4> الدفع عند الاستلام  - تم التوصيل  </h4> </div>  ',
                '<div>
        <h4> Orders - Delivered </h4>
        <h4> طلبات التوصيل - المدفوعه - تم التوصيل </h4> </div>  ',
            ],
            2 => '<div>
        <h4> Local shipping Orders </h4>
        <h4>  شحن الطلبات خارج المنطقة </h4> </div>',
            3 => '<div>
        <h4> Returned Orders </h4>
        <h4> اعاده الشحنات بعد اعاده التسليم</h4> </div>',
            4 => '<div>
        <h4> International shipping Orders </h4>
        <h4> شحن دولي </h4> </div>',
        ];

        $data = array_merge($data, [
            'Services' => Service::all(),
            'ServiceHeading'  => $ServiceHeading
        ]);

        return  view('account.show', $data);
    }
}