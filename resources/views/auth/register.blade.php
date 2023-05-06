@extends('layouts.login-layout')
@section('title', 'Register Page')
@section('content')
    <div class="content-wrapper" style="
    background-image: url({{ asset('wave.png') }});
    background-repeat:no-repeat;
    background-size:cover;
    ">

        {{-- <div class="content-body " id="particles-js"> --}}
            <div class="" style="width: 100%">
                <div class="">
                    <div id="register-container"></div>
                </div>
            </div>
            </div>
    <script>
        window.lang = { ar:'' , en:''}
        window.lang.en = @json(__('en/translation', [] , '/'));
        window.lang.ar = @json(__('ar/translation', [] , '/'));
    </script>
    <script src="{{ mix('js/app.js') }}"></script>

@endsection
