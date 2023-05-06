<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Scope\ApprovedScope;
use App\Traits\LoginWithToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    use LoginWithToken;
    public function Login(Request $request)
    {
        $new_account = false;
        $LoginKey = $this->getPhoneNumberFromApiToken($request->access_token, $request->login_type);
        // dd($LoginKey, $request->login_type);
        if ($request->login_type == 'phoneNumber') {
            $client = Client::withoutGlobalScope(new ApprovedScope)->where('phone', "$LoginKey")->first();
        } else {
            $client = Client::withoutGlobalScope(new ApprovedScope)->where('email', $LoginKey)->first();
        }

        // if ($client->is_approved = 0) {
        //     $client->is_approved = 1;
        //     $client->save();
        //     $new_account = true;
        // }

        // $client = Client::firstWhere('email' , $request->email);
        // dd();
        // dd($client);
        if (empty($client)) {
            notify()->error('invalid Credinatilas');
            return redirect()->back()->withErors('invalid Credinatilas');
        }
        // dd('Heelo From Here');
        // dd($client->id);
        Auth::guard('client')->login($client);
        // dd(Auth::guard('client')->check());
        if (Auth::guard('client')->check()) {
            $request->session()->regenerate();
            // dd('asd');
            // if ($new_account) {
            //     $client->is_approved = 0;
            //     $client->save();
            // }
            return redirect()->intended('dashboard');
        }
        // dd('Second If');

        notify()->error('The provided credentials do not match our records.');

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function register_client()
    {
    }
}