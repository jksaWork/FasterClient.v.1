@extends('layouts.Edum')

@section('content')

<div class="content-wrapper ">
    <div class=" p-5">
        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
        <div style='width:50%'>
            <img src='{{ asset('approved.svg') }}'  style='width:100%'/>
        </div>
        <h3 class='mt-5'> {{ __('translation.your_account_under_revions') }}</h3>

        </div>
    </div>
</div>
@endsection

