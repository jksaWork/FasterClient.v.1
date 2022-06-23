@extends('layouts.Edum')
@section('content')
<div>

            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-hidden card-info">
                            <div class="card-header">
                                <div class="card-title">
                                    {{__('translation.orders.details')}}
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h4 class="form-section my-3"><i
                                                                    class="la la-pencil-square-o"></i>
                                                                {{__('translation.service.info')}}
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <b>{{__('translation.service')}} : </b>

                                                                </div>
                                                                <div class="col-8">
                                                                    {{$order->service->name}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <b>{{__('translation.client')}} : </b>

                                                                </div>
                                                                <div class="col-8">
                                                                    {{$order->client->fullname}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4 class="form-section my-3"><i
                                                                    class="la la-pencil-square-o"></i>
                                                                {{__('translation.area.info')}}
                                                            </h4>
                                                        </div>
                                                   <div class="row col-12 m-1">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <b>{{__('translation.sender.name')}} : </b>
                                                            </div>
                                                            <div class="col-8">
                                                                {{$order->sender_name}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-7 p-0">
                                                                <b>{{__('translation.sender.phone.no')}} :
                                                                </b>

                                                            </div>
                                                            <div class="col-5 p-0">
                                                                {{$order->sender_phone}}

                                                            </div>
                                                        </div>
                                                    </div>
                                                   </div>
                                                    <div class="row col-12 m-1">
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>{{__('translation.sender.area')}} : </b>

                                                                </div>
                                                                <div class="col-4">
                                                                    {{$order->senderArea->name}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <b>{{__('translation.sender.sub.area')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-4">
                                                                    {{$order->senderSubArea->name}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <b>{{__('translation.sender.address')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-6">
                                                                    {{$order->sender_address}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <hr>
                                                    </div>
                                                        <div class="row col-12 m-1">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <b>{{__('translation.receiver.name')}} :
                                                                        </b>

                                                                    </div>
                                                                    <div class="col-8">
                                                                        {{$order->receiver_name}}

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-7 p-0">
                                                                        <b>{{__('translation.receiver.phone.no')}} :
                                                                        </b>
                                                                    </div>
                                                                    <div class="col-5 p-0">
                                                                        {{$order->receiver_phone_no}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row col-12 m-1">

                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>{{__('translation.receiver.area')}} :
                                                                    </b>
                                                                </div>
                                                                <div class="col-4">
                                                                    {{$order->receiverArea->name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>{{__('translation.receiver.sub.area')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-4">
                                                                    {{$order->receiverSubArea->name}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-4 p-0">
                                                                    <b>{{__('translation.receiver.address')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-8">
                                                                    {{$order->receiver_address}}

                                                                </div>
                                                            </div>
                                                        </div>

                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4 class="form-section my-5"><i
                                                                    class="la la-pencil-square-o"></i>
                                                                {{__('translation.management.info')}}
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-3 p-2">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <b>{{__('translation.representative')}} :
                                                                    </b>
                                                                </div>
                                                                <div class="col-8">
                                                                    {{$order->representative ?
                                                                    $order->representative->fullname : '-'}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 p-2">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <b>{{__('translation.status')}} : </b>

                                                                </div>
                                                                <div class="col-6">
                                                                    {{__('translation.'.$order->status)}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 p-2">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>{{__('translation.delivery.fees')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-4">
                                                                    {{$order->delivery_fees}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 p-2">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>{{__('translation.order.fees')}} : </b>

                                                                </div>
                                                                <div class="col-4">

                                                                    {{$order->order_fees}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <b>{{__('translation.total.fees')}} : </b>
                                                                </div>
                                                                <div class="col-7">
                                                                    {{$order->total_fees}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 p-2">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <b>{{__('translation.order.date')}} : </b>
                                                                </div>
                                                                <div class="col-8">
                                                                    {{date('Y-m-d
                                                                    h:m:s',strtotime($order->order_date))}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 p-2">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <b>{{__('translation.payment.method')}} :
                                                                    </b>
                                                                </div>
                                                                <div class="col-6">
                                                                    {{__('translation.'.$order->payment_method)}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 p-2">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <b>{{__('translation.delivery.date')}} :
                                                                    </b>
                                                                </div>
                                                                <div class="col-6">
                                                                    {{$order->delivery_date ?
                                                                    $order->delivery_date : "-"}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 p-2">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <b>{{__('translation.police.file')}} :
                                                                    </b>
                                                                </div>
                                                                <div class="col-6">
                                                                    @if ($order->police_file)
                                                                    <a href="{{asset('uploads/'.$order->police_file)}}">
                                                                        <i
                                                                            class="la la-link"></i>{{__('translation.police.file')}}
                                                                    </a>
                                                                    @else
                                                                    -
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


@endsection
