@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.clients.management')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('clients') }}
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-6 col-12">
        </div>
    </div>
    <div class="content-body">
        <!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    {{-- <li><a data-action="close"><i class="ft-x"></i></a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="card-body ">
                            <ul class="HiddenInPrint nav nav-tabs nav-linetriangle no-hover-bg "
                                style="border-bottom-color:#1e9ff2">
                                <li class="nav-item ">
                                    <a class="nav-link active" id="base-tab41" data-toggle="tab" aria-controls="tab41"
                                        href="#tab41" aria-expanded="true">{{__('translation.data.issue')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="base-tab42" data-toggle="tab" aria-controls="tab42"
                                        href="#tab42" aria-expanded="false">{{ __('translation.file.issue')}}</a>
                                </li>

                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="tab41" aria-expanded="true"
                                    aria-labelledby="base-tab41">
                                    <p>
                                    <div class="card-content collapse show">
                                        <div class="card-body card-dashboard">
                                            {{-- prefrix the print section --}}
                                            <div class="d-flex justify-content-between align-items-center my-3">
                                                <div class="col-md-6 inprintOnly p-2">
                                                    <div class="imgContinaer">
                                                        <h3> <b>{{__('translation.name.of.company')}}</b> : {{
                                                           '  ' . $OrganizationProfile->name}} </h3>
                                                            <h3>
                                                                <span><b>{{__('translation.name')}} :</b></span>
                                                                <span>
                                                                    {{$ClientStatementIsues->Client->fullname }}
                                                                </span>
                                                                {{-- @dd($ClientStatementIsues->status); --}}
                                                            </h3>
                                                            <h3>
                                                                <span><b>{{__('translation.issue_date')}} :</b></span>
                                                                <span>
                                                                    {{ "  ".date('y-m-d') ." | ". date('Y-M-D') }}
                                                                </span>
                                                            </h3>
                                                        </div>
                                                </div>
                                                <div class="col-md-6  p-2 text-right inprintOnly">
                                                    <div class="imgContinaer text-right inprintOnly">
                                                        <img src="{{asset('uploads/' . $OrganizationProfile->logo)}}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end prefix section --}}
                                            <div class="HiddenInPrint">
                                                <div class=" d-flex justify-content-between ">
                                                    <h3>
                                                        <span>
                                                            {{$ClientStatementIsues->Client->fullname }}
                                                        </span>
                                                        {{-- @dd($ClientStatementIsues->status); --}}
                                                        <span class="badge badge-sm mx-1 @switch($ClientStatementIsues->status)
                                                            @case('paid')
                                                                badge-success
                                                                @break
                                                            @case('unpaid')
                                                                badge-warning
                                                                @break
                                                            @default
                                                        @endswitch ">{{
                                                            __('translation.'.$ClientStatementIsues->status) }}</span>
                                                    </h3>
                                                    <div>
                                                        <button
                                                            onclick="document.querySelector('.ft-maximize').click(); window.print()"
                                                            href="#tab42" class="btn btn-sm btn-primary">
                                                            {{-- <i class="la  la-sm la-print"></i> --}}
                                                            {{__('translation.print')}}
                                                        </button>

                                                        <button id="base-tab42" data-toggle="tab" aria-controls="tab42"
                                                            onclick="document.getElementById('base-tab42').click()"
                                                            href="#tab42" class="btn btn-sm btn-primary">
                                                            {{__('translation.add.file')}}
                                                        </button>

                                                        @if ($ClientStatementIsues->status != 'paid')
                                                        <a href="{{route('issue.status', $ClientStatementIsues->id)}}"
                                                            class="btn btn-sm btn-success">
                                                            {{__('translation.asCompleted')}}
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="inprintOnly">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h3>
                                                            <span>
                                                                <b>{{__('translation.client.name')}} : </b>
                                                            </span>
                                                            <span>
                                                                {{$ClientStatementIsues->Client->fullname }}
                                                            </span>
                                                        </h3>
                                                    </div>
                                                    <div>
                                                        <h3>
                                                            <span>
                                                                <b>{{__('translation.status')}} : </b>
                                                            </span>
                                                            <span>
                                                                {{__('translation.' .$ClientStatementIsues->status)}}
                                                            </span>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-2 col-md-16">
                                                <div class="table-responsive">
                                                    <table class="table datatable table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>{{__('translation.No')}}</th>
                                                                <th>{{__('translation.receiver.name')}}</th>
                                                                <th>{{__('translation.order.fees.and.delvirey')}}</th>
                                                                <th>{{__('translation.delivery.service.fees')}} </th>
                                                                <th>{{__('translation.delivery.fees.shipping.vendor')}}
                                                                </th>
                                                                <th>{{__('translation.total.fees.become')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $totalBlade = 0;
                                                            $DeliveryFess = [];
                                                            $totalOfService = 0;
                                                            @endphp
                                                            @if(count($Orders) > 0)
                                                            @foreach ($Orders as $key => $item)
                                                            @php
                                                            $totalBlade += $item->total_fees;
                                                            $totalOfService += $item->total_fees - $item->delivery_fees;
                                                            if(isset($DeliveryFess[$item->service_id])){
                                                            $DeliveryFess[$item->service_id] += (int)
                                                            $item->delivery_fees;
                                                            }else {
                                                            $DeliveryFess[$item->service_id] = (int)
                                                            $item->delivery_fees;
                                                            }
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $item->id }}</td>
                                                                <td>{{ $item->receiver_name }}</td>
                                                                <td>{{ $item->total_fees}}
                                                                </td>
                                                                <td>{{ $item->service_id == 1 ? $item->delivery_fees : "
                                                                    - "}}</td>
                                                                <td>{{ $item->service_id == 2 ? $item->delivery_fees : "
                                                                    - "}}</td>
                                                                <td>{{ $item->total_fees - $item->delivery_fees }}</td>
                                                            </tr>
                                                            @endforeach
                                                            @else
                                                            <tr class="text-center">
                                                                <td colspan="10">{{__('translation.table.empty')}}</td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-center">{{__('translation.total.fees')}}
                                                                </th>
                                                                {{-- $DeliveryFess[$item->service_id] --}}
                                                                <th>{{ $totalBlade }}</th>
                                                                <th>{{$DeliveryFess[1] ?? ' '}}</th>
                                                                <th>{{$DeliveryFess[2] ?? ' '}}</th>
                                                                <th>{{ $totalOfService}}</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label
                                                                for=""><b>{{__('translation.order.fees.and.delvirey')}}</b></label>
                                                            <input type="text" readonly value="{{$totalBlade}}"
                                                                class="form-control" name="" id=""
                                                                aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label
                                                                for=""><b>{{__('translation.totol.delivery.fees')}}</b></label>
                                                            <input type="text" readonly
                                                                value="{{ $DeliveryFess[1] ?? '0'}}"
                                                                class="form-control" name="" id=""
                                                                aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label
                                                                for=""><b>{{__('translation.total.shiping.delivery.fees')}}</b></label>
                                                            <input type="text" readonly
                                                                value="{{$DeliveryFess[2] ?? '0'}}" class="form-control"
                                                                name="" id="" aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label
                                                                for=""><b>{{__('translation.total.fees.become')}}</b></label>
                                                            <input type="text" readonly value="{{$totalOfService}}"
                                                                class="form-control" name="" id=""
                                                                aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label
                                                                for=""><b>{{__('translation.total.delivery.service.fees')}}</b></label>
                                                            <input type="text" readonly
                                                                value="{{$DeliveryFess[1] ?? '-'}}" class="form-control"
                                                                name="" id="" aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label
                                                                for=""><b>{{__('translation.total.delivery.fees.shipping.vendor')}}</b></label>
                                                            <input type="text" readonly
                                                                value="{{$DeliveryFess[2] ?? '-'}}" class="form-control"
                                                                name="" id="" aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for=""><b>{{__('translation.total_fo_servie')}}</b></label>
                                                            <input type="text" disabled
                                                                value="{{($DeliveryFess[1]  ?? 0)+ ($DeliveryFess[2] ?? 0  )}}"
                                                                class="form-control" name="" id=""
                                                                aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                                <div class="tab-pane " id="tab42" aria-labelledby="base-tab42">
                                    <p>
                                    <form action="{{route('UploadFiles' , $id)}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">{{__('translation.add.file')}}</label>
                                            <input type="file" class="form-control" name="file" id="" accept="image/*"
                                                onchange="this.form.submit()" aria-describedby="helpId" placeholder="">
                                        </div>
                                    </form>
                                    <hr>
                                    <div>
                                        @foreach ($ClientStatementIsues->Photos as $item )
                                        <div class="d-flex justify-content-between align-items-center m-1">
                                            <div class="col-md-3">
                                                <img src="{{$item->photo}}" width="70px" height="70px" alt="" />
                                            </div>
                                            <div>
                                                <a target="_blank" href="{{ route('showFile' , $item->id)}}"
                                                    class="btn btn-sm btn-outline-info">
                                                    <span>
                                                        <svg style="width:15px;height:15px" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C12.36,19.5 12.72,19.5 13.08,19.45C13.03,19.13 13,18.82 13,18.5C13,17.94 13.08,17.38 13.24,16.84C12.83,16.94 12.42,17 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12C17,12.29 16.97,12.59 16.92,12.88C17.58,12.63 18.29,12.5 19,12.5C20.17,12.5 21.31,12.84 22.29,13.5C22.56,13 22.8,12.5 23,12C21.27,7.61 17,4.5 12,4.5M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M18,14.5V17.5H15V19.5H18V22.5H20V19.5H23V17.5H20V14.5H18Z" />
                                                        </svg>
                                                    </span>
                                                </a>
                                                <a href="{{route('downloadImage', $item->id)}}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <span>
                                                        <svg style="width:15px;height:15px" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z" />
                                                        </svg>
                                                    </span>
                                                </a>
                                                <a href="{{route(" DeletImage2" , $item->id)}}" class="btn btn-sm
                                                    btn-outline-danger">
                                                    <span>
                                                        <svg style="width:14px;height:14px" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M20.37,8.91L19.37,10.64L7.24,3.64L8.24,1.91L11.28,3.66L12.64,3.29L16.97,5.79L17.34,7.16L20.37,8.91M6,19V7H11.07L18,11V19A2,2 0 0,1 16,21H8A2,2 0 0,1 6,19Z" />
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </section>
    <!--/ Zero configuration table -->
</div>
</div>
@endsection
