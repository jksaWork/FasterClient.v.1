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
<div class="col-12">
<div x-data="{miniinvoice : false}" >
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{__('translation.invoices')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{-- Breadcrumbs::render('order.invoice', $order) --}}
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <button class="btn btn-info round dropdown-toggle dropdown-menu-right box-shadow-2 px-2"
                    id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="ft-settings icon-left"></i>
                    {{__('translation.invoices.types')}}</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a @click.prevent="miniinvoice=false" class="dropdown-item"
                        href="{{route('print.invoice', $order->id)}}">{{__('translation.large.invoice')}}</a>
                    <a @click.prevent="miniinvoice=true" class="dropdown-item"
                        href="component-buttons-extended.html">{{__('translation.mini.invoice')}}</a></div>
            </div>
        </div>
    </div>
    @foreach ($Orders as $order)
    <div class="content-body mt-3 m-0">
        <template x-if="miniinvoice==false">
            <section class="card">
                <div id="invoice-template-large" class="card-body col-12">
                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row">
                        <div class="col-sm-6 text-left">
                            <div class="media">
                                <img src="{{asset('uploads/' . $OrganizationProfile->logo)}}" style="width: 125px;"
                                    alt="company logo" class="" />
                                <div class="media-body">
                                    <ul class="ml-2 px-0 list-unstyled">
                                        <li class="text-bold-800">{{$OrganizationProfile->name}}</li>
                                        <li>{{$OrganizationProfile->address}}</li>
                                        <li>{{$OrganizationProfile->phone_no}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <h2>رقم الفاتوره</h2>
                            <p class="pb-3"># {{$order->invoice_sn}}</p>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->
                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                        <div class="col-sm-12 text-left">
                            <p class="text-muted">بيانات العميل</p>
                        </div>
                        <div class="col-sm-6 text-left">
                            <ul class="px-0 list-unstyled">
                                <li class="text-bold-800">{{$order->client->fullname}}</li>
                                <li>{{$order->client->subArea->area->name}},</li>
                                <li>{{$order->client->subArea->name}},</li>
                                <li>{{$order->client->address}},</li>
                                <li>{{$order->client->phone}}</li>
                            </ul>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p>
                                <span class="text-muted">الخدمه :</span> {{$order->service->name}}</p>
                            <p>
                                <span class="text-muted">تاريخ الطلب :</span> {{$order->order_date}}</p>
                            {{-- <p>
                                <span class="text-muted">Terms :</span> Due on Receipt</p> --}}
                            <p>
                                <span class="text-muted">تاريخ التوصيل :</span>
                                {{$order->delivery_date ? $order->delivery_date : "-"}}</p>
                        </div>
                    </div>
                    <!--/ Invoice Customer Details -->
                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <p class="lead">بيانات المرسل:</p>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>الاسم:</td>
                                                    <td class="text-right">{{$order->sender_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>المدينه:</td>
                                                    <td class="text-right">{{$order->senderArea->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>المحافظه:</td>
                                                    <td class="text-right">{{$order->senderSubArea->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>العنوان:</td>
                                                    <td class="text-right">{{$order->sender_address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>رقم الهاتف:</td>
                                                    <td class="text-right">{{$order->sender_phone}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 text-left">
                                <p class="lead">بيانات المستلم:</p>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>الاسم:</td>
                                                    <td class="text-right">{{$order->receiver_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>المدينه:</td>
                                                    <td class="text-right">{{$order->receiverArea->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>المحافظه:</td>
                                                    <td class="text-right">{{$order->receiverSubArea->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>العنوان:</td>
                                                    <td class="text-right">{{$order->receiver_address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>رقم الهاتف:</td>
                                                    <td class="text-right">{{$order->receiver_phone_no}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="lead">تفاصيل ماليه</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>طريقه الدفع</td>
                                                <td class="pink text-right">
                                                    {{__('translation.'.$order->payment_method)}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>رسوم الطلب</td>
                                                <td class="text-right">{{$order->order_fees}} ر.س</td>
                                            </tr>
                                            <tr>
                                                <td>رسوم التوصيل</td>
                                                <td class="text-right">{{$order->delivery_fees}} ر.س</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold-800">الاجمالي</td>
                                                <td class="text-bold-800 text-right">{{$order->total_fees}} ر.س</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </template>
        <template x-if="miniinvoice==true">
            <section class="card m-auto m-2 w-25">
                <div id="invoice-template-small" class="card-body">
                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row">
                        <div class="col-md-12 col-sm-12 text-center">
                            <img src="{{asset('uploads/' . $OrganizationProfile->logo)}}" style="width: 125px;"
                                alt="company logo" class="" />
                        </div>
                        <div class="col-md-12 col-sm-12 text-center">
                            <h2>رقم الفاتوره</h2>
                            <p class=""># {{$order->invoice_sn}}</p>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->
                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="">
                        <div class="row">
                            <div class=" col-sm-12">
                                <p class="lead text-center">تفاصيل الطلب</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>اسم المستلم</td>
                                                <td class="text-right">{{$order->receiver_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>مدينه المستلم</td>
                                                <td class="text-right">{{$order->receiverArea->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>محافظه المستلم</td>
                                                <td class="text-right">{{$order->receiverSubArea->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>رقم هاتف المستلم</td>
                                                <td class="text-right">{{$order->receiver_phone_no}}</td>
                                            </tr>
                                            <tr>
                                                <td>طريقه الدفع</td>
                                                <td class="pink text-right">
                                                    {{__('translation.'.$order->payment_method)}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>مدفوع</td>
                                                <td class="text-right">
                                                    {{$order->payment_method == "on_sending" || $order->payment_method == "balance" ? $order->total_fees : 0}}
                                                    ر.س</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold-800" style="font-weight: bold">الاجمالي</td>
                                                <td class="text-bold-800 text-right" style="font-weight: bold">
                                                    {{$order->total_fees}} ر.س</td>
                                            </tr>
                                            {{-- <tr>
                                                <td class="text-center">
                                                    {!! DNS1D::getBarcodeHTML($order->id, 'CODABAR') !!}
                                                </td>
                                                <td class="text-right">
                                                    BARCODE
                                                </td>

                                            </tr> --}}
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($order->id . "", 'C128',3,33,array(1,1,1), true) !!}"
                                            alt="BARCODE">
                                        {{-- {!! DNS1D::getBarcodeHTML($order->id . "", 'C128') !!} --}}
                                    </div>
                                </div>
                                {{-- <div class="text-center">
                                                            <p>Authorized person</p>
                                                            <img src="../../../app-assets/images/pages/signature-scan.png" alt="signature"
                                                                class="height-100" />
                                                            <h6>Amanda Orton</h6>
                                                            <p class="text-muted">Managing Director</p>
                                                        </div> --}}
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
                                <button type="button" class="btn btn-info btn-lg my-1"><i class="la la-paper-plane-o"></i>
                                    Send Invoice</button>
                            </div>
                        </div>
                    </div> --}}
                    <!--/ Invoice Footer -->
                </div>
            </section>
        </template>
    </div>
    @endforeach
</div>
@endsection
