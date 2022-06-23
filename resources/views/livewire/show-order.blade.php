<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.orders.management')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
                <div class="btn-group">
                    <button data-toggle="modal" data-target="#AddArea" class="btn btn-round btn-info" type="button"><i
                            class="la la-plus la-sm"></i>
                        {{__('translation.add')}}</button>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <fieldset class="form-group posision-relative">
                                                <label for="">{{__('translation.search')}}</label>
                                                <input placeholder="{{__('translation.search.by.order.id')}}"
                                                    wire:model="searchTerm" type="search" class="form-control"
                                                    id="search">
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-4">
                                            <fieldset class="form-group">
                                                <label for="">{{__('translation.from')}}</label>
                                                <input wire:model="from_date" placeholder="{{__('translation.from')}}"
                                                    type="date" class="form-control" id="date">
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-4">
                                            <fieldset class="form-group">
                                                <label for="">{{__('translation.to')}}</label>
                                                <input wire:model="to_date" placeholder="{{__('translation.to')}}"
                                                    type="date" class="form-control" id="date">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    @include('includes.dashboard.notifications')

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 3px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.order.date')}}</th>
                                                <th>{{__('translation.service')}}</th>
                                                <th>{{__('translation.client')}}</th>
                                                <th>{{__('translation.representative')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->order_date }}</td>
                                                <td>{{ $order->service->name }}</td>
                                                <td>{{ $order->client->fullname }}</td>
                                                <td>{{ $order->representative ? $order->representative->fullname : '-'
                                                    }}
                                                </td>
                                                <td><span class="badge @switch($order->status)
                                                            @case('pending')
                                                                badge-warning
                                                                @break
                                                            @case('pickup')
                                                                badge-secondary
                                                                @break
                                                            @case('inProgress')
                                                                badge-primary
                                                                @break
                                                            @case('delivered')
                                                                badge-info
                                                                @break
                                                            @case('completed')
                                                                badge-success
                                                                @break
                                                            @case('canceled')
                                                                badge-danger
                                                                @break
                                                            @default
                                                        @endswitch ">{{ __('translation.'.$order->status) }}</span>
                                                </td>
                                                <td>{{ $order->total_fees }}</td>
                                                <td>
                                                    <a href="{{route('print.invoice', $order->id)}}"
                                                        class="btn btn-sm btn-icon btn-warning"><i
                                                            class="la la-print"></i></a>
                                                    <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}}
                                                        href="{{ route('orders.show.details' , $order->id) }}"
                                                        class="btn btn-sm btn-icon
                                                        btn-info"><i class="la la-info"></i></a>
                                                    <button data-toggle="modal" data-target="#updateModal"
                                                        data-backdrop="static" data-keyboard="false"
                                                        wire:click="edit({{ $order->id }})" class="btn btn-sm btn-icon
                                                        btn-primary"><i class="la la-edit"></i></button>
                                                    <button data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{__('translation.delete')}}"
                                                        wire:click="$emit('triggerOrderDelete', {{$order->id}})"
                                                        class="btn btn-icon btn-danger btn-sm"><i
                                                            class="la la-trash"></i></button>
                                                </td>
                                            </tr>
                                            <div wire:ignore.self class="modal animated bounceInDown fade text-left"
                                                id="showModal{{$order->id}}" role="dialog"
                                                aria-labelledby="myModalLabel35" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h3 class="modal-title white" id="myModalLabel35">
                                                                {{__('translation.order.show')}} ({{$order->id}})
                                                            </h3>
                                                            <button type="button" wire:click.prevent="cancel()"
                                                                class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        {{-- <div class="modal-body"> --}}
                                                            <div class="row">
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
                                                                    <h4 class="form-section"><i
                                                                            class="la la-pencil-square-o"></i>
                                                                        {{__('translation.area.info')}}
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.sender.name')}} : </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->sender_name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
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
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.sender.area')}} : </b>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{$order->senderArea->name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.sender.sub.area')}} :
                                                                            </b>

                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{$order->senderSubArea->name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.sender.address')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->sender_address}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
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
                                                                <div class="col-md-2">
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
                                                                <div class="col-md-2">
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
                                                                <div class="col-md-2">
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
                                                                <div class="col-md-3">
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
                                                                <div class="col-md-12">
                                                                    <h4 class="form-section"><i
                                                                            class="la la-pencil-square-o"></i>
                                                                        {{__('translation.management.info')}}
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-3">
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
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <b>{{__('translation.status')}} : </b>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            {{__('translation.'.$order->status)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
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
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.order.fees')}} : </b>

                                                                        </div>
                                                                        <div class="col-4">

                                                                            {{$order->order_fees}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-5">
                                                                            <b>{{__('translation.total.fees')}} : </b>

                                                                        </div>
                                                                        <div class="col-7">
                                                                            {{$order->total_fees}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
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
                                                                <div class="col-md-2">
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
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.delivery.date')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->delivery_date ?
                                                                            $order->delivery_date : "-"}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.police.file')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            @if ($order->police_file)
                                                                            <a
                                                                                href="{{asset('uploads/'.$order->police_file)}}">
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
                                                        <div class="modal-footer">
                                                            <input wire:click.prevent="cancel()" type="reset"
                                                                class="btn btn-outline-secondary btn-lg"
                                                                data-dismiss="modal"
                                                                value="{{__('translation.cancel')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="10">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="width: 3px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.order.date')}}</th>
                                                <th>{{__('translation.service')}}</th>
                                                <th>{{__('translation.client')}}</th>
                                                <th>{{__('translation.representative')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! $data->links() !!}
            </section>
        </div>
    </div>


    <div wire:ignore.self class="modal fade text-left animated bounceInDown" id="AddArea" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info ">
                    <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.order.add')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="store()">
                    <div class="modal-body">
                        <div class="row">

                            <div class="row col-md-6">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{__('translation.service')}}</label>
                                        <select wire:model.defer="service_id" class="select2 servicesSelect form-control "
                                        style="width:100%">
                                            <option value="">----</option>
                                            @foreach ($services->where('is_active', 1) as $service)
                                            <option value="{{$service->id}}">{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('service_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{__('translation.client')}}</label>
                                        <select wire:model.defer="client_id" class="select2 clientSelect2 form-control "
                                            style="width:100%">
                                            <option value="">----</option>
                                            @foreach ($clients as $client)
                                            <option value="{{$client->id}}">{{$client->fullname}}</option>
                                            @endforeach
                                        </select>
                                        @error('client_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-6 p-0 m-0">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">{{__('translation.representative')}}</label>
                                        <select wire:model.defer="representative_id"
                                            class="select2 representativeSelect2 form-control " style="width:100%">
                                            <option value="">----</option>
                                            @foreach ($representatives as $representative)
                                            <option value="{{$representative->id}}">{{$representative->fullname}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('representative_id') <span class="text-danger error">{{ $message
                                            }}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-group floating-label-form-group">
                                        <label for="email">{{__('translation.order.fees')}}</label>
                                        <input  type="text"
                                            wire:model.defer="order_fees" class="form-control" placeholder="">
                                        @error('order_fees') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label for="title">{{__('translation.police.file')}}</label>
                                        <input id="police_file" type="file" wire:model.defer="police_file"
                                            class="form-control" placeholder="">
                                        @error('police_file') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4 class="form-section"><i class="la la-map-marker"></i>
                                    {{__('translation.area.info')}}
                                </h4>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.sender.name')}}</label>
                                    <input type="text" wire:model.defer="sender_name" class="form-control"
                                        placeholder="">
                                    @error('sender_name') <span class="text-danger error">{{ $message }}</span>@enderror
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.sender.phone.no')}}</label>
                                    <input type="text" wire:model.defer="sender_phone" class="form-control"
                                        placeholder="">
                                    @error('sender_phone') <span class="text-danger error">
                                        {{ $message }}</span>@enderror
                                </fieldset>
                            </div>
                            {{-- @dd($SenderSubArea) --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{-- @if ($service_id)
                                    @dd($areas)
                                    @endif --}}
                                    <label for="title">{{__('translation.sender.area')}}</label>
                                    <select wire:model.defer="sender_area_id" wire:change='HandelCahnge()'
                                        class="select2 senderAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($SendingArea as $area)
                                        <option {{$sender_area_id==$area->id ? 'selected' : ''}}
                                            value="{{$area->id}}">
                                            {{$area->name}} - ({{$area->sub_areas_count}})</option>
                                        @endforeach
                                    </select>
                                    @error('sender_area_id') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{__('translation.sender.sub.area')}}</label>
                                    <select wire:model.defer="sender_sub_area_id"
                                        class="select2 senderSubAreaSelect2 form-control" style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($SenderSubArea as $area)
                                        <option {{$sender_sub_area_id==$area->id ? 'selected' : ''}}
                                            value="{{$area->id}}">
                                            {{$area->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('sender_sub_area_id') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.sender.address')}}</label>
                                    <input type="text" wire:model.defer="sender_address" class="form-control"
                                        placeholder="">
                                    @error('sender_address') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                            </fieldset>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.receiver.name')}}</label>
                                    <input type="text" wire:model.defer="receiver_name" class="form-control"
                                        placeholder="">
                                    @error('receiver_name') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.receiver.phone.no')}}</label>
                                    <input type="text" wire:model.defer="receiver_phone_no" class="form-control"
                                        placeholder="">
                                    @error('receiver_phone_no') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{__('translation.receiver.area')}}</label>
                                    <select   wire:model.defer="receiver_area_id"
                                        class="select2 receiverAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($ResevingArea as $area)
                                        <option {{$receiver_area_id==$area->id ? 'selected' : ''}}
                                            value="{{$area->id}}">
                                            {{$area->name}} - ({{$area->sub_areas_count}})</option>
                                        @endforeach
                                    </select>
                                    @error('receiver_area_id') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>
                            {{-- @dd($ResevierSubArea); --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{__('translation.receiver.sub.area')}}</label>
                                    <select wire:model.defer="receiver_sub_area_id"
                                        class="select2 receiverSubAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($ResevierSubArea as $area)
                                        <option {{$receiver_sub_area_id==$area->id ? 'selected' : ''}}
                                            value="{{$area->id}}">{{$area->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('receiver_sub_area_id') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.receiver.address')}}</label>
                                    <input type="text" wire:model.defer="receiver_address" class="form-control"
                                        placeholder="">
                                    @error('receiver_address') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div>
                            {{-- <div class="col-md-3">
                                <fieldset class="form-group mt-3">
                                    <input type="checkbox" wire:model.defer="is_payment_on_delivery" class=""
                                        placeholder="">
                                    <label for="title">{{__('translation.payment.on.delivery')}}</label>
                                    @error('is_payment_on_delivery') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div> --}}
                        </div>



                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                            value="{{__('translation.cancel')}}">
                        <input type="submit" class="btn btn-outline-info btn-lg" value="{{__('translation.add')}}">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal animated bounceInDown fade text-left" id="updateModal" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.order.edit')}} ({{$order_id}})
                    </h3>
                    <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="update()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">{{__('translation.service')}}</label>
                                    <select wire:model="service_id" class="select2 servicesSelect form-control"
                                    style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($services as $service)
                                        <option {{$service_id==$service->id ? 'selected' : ''}}
                                            value="{{$service->id}}">
                                            {{$service->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('service_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">{{__('translation.client')}}</label>
                                    <select wire:model.defer="client_id" class="select2 clientSelect2 form-control "
                                        style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($clients as $client)
                                        <option {{$client_id==$client->id ? 'selected' : ''}} value="{{$client->id}}">
                                            {{$client->fullname}}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4 class="form-section"><i class="la la-map-marker"></i>
                                    {{__('translation.area.info')}}
                                </h4>
                            </div>

                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.sender.name')}}</label>
                                    <input type="text" wire:model.defer="sender_name" class="form-control"
                                        placeholder="">
                                    @error('sender_name') <span class="text-danger error">{{ $message }}</span>@enderror
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.sender.phone.no')}}</label>
                                    <input type="text" wire:model.defer="sender_phone" class="form-control"
                                        placeholder="">
                                    @error('sender_phone') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{__('translation.sender.area')}}</label>
                                    <select wire:model.defer="sender_area_id"
                                        class="select2 senderAreaSelect2 form-control" style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($SendingArea as $area)
                                        <option {{$sender_area_id==$area->id ? 'selected' : ''}} value="{{$area->id}}">
                                            {{$area->name}} - ({{getSubAreaCountByAreaId($area->id)}})</option>
                                        @endforeach
                                    </select>
                                    @error('sender_area_id') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{__('translation.sender.sub.area')}}</label>
                                    <select wire:model.defer="sender_sub_area_id"
                                        class="select2 senderSubAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($sub_areas as $area)
                                        <option {{$sender_sub_area_id==$area->id ? 'selected' : ''}}
                                            value="{{$area->id}}">
                                            {{$area->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('sender_sub_area_id') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.sender.address')}}</label>
                                    <input type="text" wire:model.defer="sender_address" class="form-control"
                                        placeholder="">
                                    @error('sender_address') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.receiver.name')}}</label>
                                    <input type="text" wire:model.defer="receiver_name" class="form-control"
                                        placeholder="">
                                    @error('receiver_name') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.receiver.phone.no')}}</label>
                                    <input type="text" wire:model.defer="receiver_phone_no" class="form-control"
                                        placeholder="">
                                    @error('receiver_phone_no') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div>

                            <div class="col-md-2">
                                {{-- @dd($ResevingArea) --}}
                                <div class="form-group">
                                    <label for="title">{{__('translation.receiver.area')}}</label>
                                    <select wire:model.defer="receiver_area_id"
                                        class="select2 receiverAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($ResevingArea as $area)
                                        <option {{$receiver_area_id==$area->id ? 'selected' : ''}}
                                            value="{{$area->id}}">
                                            {{$area->name}} - ({{getSubAreaCountByAreaId($area->id)}})</option>
                                        @endforeach
                                    </select>
                                    @error('receiver_area_id') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{__('translation.receiver.sub.area')}}</label>
                                    <select wire:model.defer="receiver_sub_area_id"
                                        class="select2 receiverSubAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($sub_areas as $area)
                                        <option {{$receiver_sub_area_id==$area->id ? 'selected' : ''}}
                                            value="{{$area->id}}">
                                            {{$area->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('receiver_sub_area_id') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.receiver.address')}}</label>
                                    <input type="text" wire:model.defer="receiver_address" class="form-control"
                                        placeholder="">
                                    @error('receiver_address') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <h4 class="form-section"><i class="la la-pencil-square-o"></i>
                                    {{__('translation.management.info')}}
                                </h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">{{__('translation.representative')}}</label>
                                    <select wire:model.defer="representative_id"
                                        class="select2 representativeSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($representatives as $representative)
                                        <option {{$representative_id==$representative->id ? 'selected' : ''}}
                                            value="{{$representative->id}}">{{$representative->fullname}}</option>
                                        @endforeach
                                    </select>
                                    @error('representative_id') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{__('translation.order.fees')}}</label>
                                    <input type="text"
                                        wire:model.defer="order_fees" class="form-control" placeholder="">
                                    @error('order_fees') <span class="text-danger error">{{ $message }}</span>@enderror
                                </fieldset>
                            </div>

                            <div class="col-md-4">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="title">{{__('translation.police.file')}}</label>
                                    <input type="file" wire:model.defer="police_file" class="form-control"
                                        placeholder="">
                                    @error('police_file') <span class="text-danger error">{{ $message }}</span>@enderror
                                </fieldset>
                            </div>
                            {{-- <div class="col-md-3">
                                <fieldset class="form-group mt-3">
                                    <input type="checkbox" wire:model.defer="is_payment_on_delivery" class=""
                                        placeholder="">
                                    <label for="title">{{__('translation.payment.on.delivery')}}</label>
                                    @error('is_payment_on_delivery') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input wire:click.prevent="cancel()" type="reset" class="btn btn-outline-secondary btn-lg"
                            data-dismiss="modal" value="{{__('translation.cancel')}}">
                        <input type="submit" class="btn btn-outline-info btn-lg" value="{{__('translation.edit')}}">
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
</div>


@push('scripts')
<script type="text/javascript">
    //delete order
document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('triggerOrderDelete', order_id => {
        console.log('tregered!');
        Swal.fire({
            title: '{{__('translation.delete.confirmation.message')}}',
            text: '{{__('translation.delete.confirmation.text')}}',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: '{{__('translation.delete')}}'
        }).then((result) => {
            //if user clicks on delete
            if (result.value) {
                // calling destroy method to delete
                Livewire.emit('orderDelete', order_id)
                // success response
                // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
            } else {
                Swal.fire({
                title: '{{__('translation.operation.canceled')}}',
                icon: 'success'
                });
            }
        });
    });



    window.livewire.on('stored', () => {
        $('#AddArea').modal('hide');
    });


    window.livewire.on('updated', () => {
        $('#updateModal').modal('hide');
    });

    window.Livewire.on('select2', function(){
        $('.select2').select2();
    });

    function showPass($num){
        $('.iconLeft3').attr('type', 'text');
    }


    $('.servicesSelect').select2();
    $('.servicesSelect').on('change', function (e) {
        console.log('jksa altignai osamn');
        @this.set('service_id', e.target.value);
    });



    $('.clientSelect2').select2();
        $('.clientSelect2').on('change', function (e) {
        @this.set('client_id', e.target.value);
        });
        // receiverAreaSelect2
        $('.receiverAreaSelect2').select2();
        $('.receiverAreaSelect2').on('change', function (e) {
        @this.set('receiver_area_id', e.target.value);
        });

        // Sending area -------------------------
        // $('.receiverAreaSelect2').select2();
        // $('.receiverAreaSelect2').on('change', function (e) {
        // @this.set('receiver_area_id', e.target.value);
        // });
        // sending are ---------------------
        // receiverSubAreaSelect2
        $('.receiverSubAreaSelect2').select2();
        $('.receiverSubAreaSelect2').on('change', function (e) {
        @this.set('receiver_sub_area_id', e.target.value);
        });
        // senderAreaSelect2
        $('.senderAreaSelect2').select2();
        $('.senderAreaSelect2').on('change', function (e) {
        @this.set('sender_area_id', e.target.value);
             console.log(e.target.value);
        });
        // senderSubAreaSelect2
        $('.senderSubAreaSelect2').select2();
        $('.senderSubAreaSelect2').on('change', function (e) {
        @this.set('sender_sub_area_id', e.target.value);
        });
        // representativeSelect2
        $('.representativeSelect2').select2();
        $('.representativeSelect2').on('change', function (e) {
        @this.set('representative_id', e.target.value);
        });
})



    // TO CHANGE SELECT2 CLIENT_ID VALUE
    // $(document).ready(function() {
    //     // clientSelect2

    // });
</script>
@endpush
