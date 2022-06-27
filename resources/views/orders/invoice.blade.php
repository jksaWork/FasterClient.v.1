@extends('layouts.Edum')
@push('links')
<style>
    /* media order print */
    @media print {
        body * {
            visibility: hidden;
        }

        #invoice-template-large,
        #invoice-template-large * {
            visibility: visible;
        }

        #invoice-template-large {
            left: 0px;
            right: 0;
            top: 0px;
            position: fixed;
        }

        #invoice-template-small,
        #invoice-template-small * {
            visibility: visible;
        }

        #invoice-template-small {
            left: 0px;
            right: 0;
            top: 0px;
            position: fixed;
        }
    }
</style>

@endpush

@section('content')

<div x-data="{miniinvoice : true, items : {{ $order->number_of_pieces}} }">
    {{-- @dd($order->number_of_pieces); --}}
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{--__('translation.invoices')--}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{-- Breadcrumbs::render('order.invoice', $order) --}}
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            {{-- <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <button class="btn btn-info round dropdown-toggle dropdown-menu-right box-shadow-2 px-2"
                    id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="ft-settings icon-left"></i>
                    {{__('translation.invoices.types')}}</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a @click.prevent="miniinvoice=false" class="dropdown-item"
                        href="{{route('print.invoice', $order->id)}}">{{__('translation.large.invoice')}}</a>
                    <a @click.prevent="miniinvoice=true" class="dropdown-item"
                        href="component-buttons-extended.html">{{__('translation.mini.invoice')}}</a>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="">
        @for ($i = 1 ; $i <= $order->number_of_pieces ;$i++)
        <div class="mt-3"></div>
        <template x-if="miniinvoice==true">
            <section class="card m-auto col-md-6 p-2">
                <div id="invoice-template-small" class="card-body">
                    <div id="invoice-company-details" class="d-flex justify-content-between align-items-center">
                        <div class="text-center">
                            <h3> الفاتوره</h3>
                            <h4> {{$OrganizationProfile->name }}</h4>
                            <h6> {{date('y/m/d')}}</h6>
                        </div>
                        <div></div>
                        <div class="  text-center">
                            <img src="{{asset('uploads/' . $OrganizationProfile->logo)}}" style="width: 125px;"
                                alt="company logo" class="" />
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->
                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="">
                        <div class="row justify-content-between p-2" style="border-top:1px solid #000">
                            <div class="">
                                <b>{{__('translation.order_id')}}</b> : {{$order->id}}
                            </div>
                            <div class="">
                                <b>{{$order->service->name}}</b>
                            </div>
                        </div>
                        <div class="row justify-content-between p-2" style="border-top:1px solid #000">
                            <div class="col-12">
                                <h3 class="text-center mt-1">
                                    {{__('translation.send.data')}}
                                </h3>
                            </div>
                            <div class="d-flex justify-content-between col-12">
                                <div class=" py-1">
                                    <b>{{__('translation.sender')}}</b> : {{$order->sender_name}}
                                </div>
                                <div class=" py-1">
                                    <b>{{__('translation.resever')}}</b> : {{$order->receiver_name}}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between col-12">
                                <div class=" py-1">
                                    <b>{{__('translation.where_from')}}</b> : {{ $order->senderArea->name }}
                                </div>
                                <div class=" py-1">
                                    <b>{{__('translation.where_to')}}</b> : {{ $order->receiverArea->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between p-3" style="border-top:1px solid #000">
                        <div>
                            <b>{{__('translation.number_of_paces_in_invocie')}}</b>: {{$order->number_of_pieces}}
                        </div>
                        <div>
                            <b>
                                {{
                                __('translation.total.fees')
                                }}:
                            </b>
                            {{$order->total_fees}}
                        </div>
                    </div>
                    <div class="text-center m-1 ">
                        <div class="text-center">
                            <b>{{__('translation.order_id')}}</b> : #{{$order->id}}
                        </div>
                        <img height='50px'
                            src="data:image/png;base64,{!! DNS1D::getBarcodePNG($order->id . "", 'C128',3,33,array(1,1,1), true) !!}"
                            alt="BARCODE">
                        <div class="text-center">
                            {{$i}} <span class="mx-1"> {{__('translation.where_from')}}</span> {{$order->number_of_pieces}}
                        </div>
                        {{-- {!! DNS1D::getBarcodeHTML($order->id . "", 'C128') !!} --}}
                    </div>
                    <div class="row justify-content-between p-2" style="border-top:1px solid #000">
                        <div class="col-12">
                            <h3 class="text-center mt-1">
                                {{__('translation.order.data')}}
                            </h3>
                        </div>

                        <div>
                            <div class=" py-1">
                                <b>{{__('translation.peace')}}</b> : {{ $order->number_of_pieces }}
                            </div>
                            <div class=" py-1">
                                <b>{{__('translation.weight')}}</b> : {{ $order->order_weight }}
                            </div>
                            <div class=" py-1">
                                <b>{{__('translation.order.fees')}}</b> : {{ $order->order_fees }}
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Footer -->
                    {{-- <div id="invoice-footer">
                        <div class="row">
                            <div class="col-md-7 col-sm-12">
                                <h6>Terms & Condition</h6>
                                <p>You know, being a test pilot isn't always the healthiest business
                                    in the world. We predict too much for the next year and yet far
                                    too little for the next 10.</p>
                            </div>
                            <div class="col-md-5 col-sm-12 text-center">
                                <button type="button" class="btn btn-info btn-lg my-1"><i
                                        class="la la-paper-plane-o"></i>
                                    Send Invoice</button>
                            </div>
                        </div>
                    </div> --}}
                    <!--/ Invoice Footer -->
                </div>
            </section>
        </template>
        @endfor
        </template>
    </div>
</div>
@endsection
