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
    public function Login(Request $request){
        
        $LoginKey = $this->getPhoneNumberFromApiToken($request->access_token, $request->login_type);
        // dd($LoginKey);
        if ($request->login_type == 'phoneNumber') {
            $client = Client::withoutGlobalScope(new ApprovedScope)->where('phone', "$LoginKey")->first();
        }else {
            $client = Client::withoutGlobalScope(new ApprovedScope)->where('email', $LoginKey)->first();
        }
        // $client = Client::firstWhere('email' , $request->email);
        // dd();
        // dd($client);
        if(empty($client)){
            return redirect()->back()->withErors('invalid Credinatilas');
        }

        if(Auth::guard('client')->loginUsingId($client->id)){
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        // dd('jksa altigani');
        // dd(auth()->user());

        // notify()->error('The provided credentials do not match our records.');

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
