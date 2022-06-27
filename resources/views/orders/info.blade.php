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
                                <form wire:submit.prevent="store()">
                                    <div class="modal-body m-3">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br/>
                                        @endforeach
                                        <div class="col-md-6 col-sm-12">
                                            <h4 class="form-section"><i class="la la-map-marker"></i>
                                                {{__('translation.sender.data')}}
                                            </h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="email">{{__('translation.sender.name')}}</label>
                                                    <input type="text"
                                                    disabled
                                                    value='{{$order->sender_name}}'
                                                    wire:model.defer="sender_name" class="form-control"
                                                        placeholder="">
                                                    @error('sender_name') <span class="text-danger error">{{ $message }}</span>@enderror
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="email">{{__('translation.sender.phone.no')}}</label>
                                                    <input
                                                    disabled
                                                    value='{{$order->sender_phone}}'
                                                    type="text" wire:model.defer="sender_phone" class="form-control"
                                                        placeholder="">
                                                    @error('sender_phone') <span class="text-danger error">{{ $message
                                                        }}</span>@enderror
                                                </fieldset>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="title">{{__('translation.sender.area')}}</label>
                                                    <select
                                                    disabled
                                                    value='{{$order->senderArea->name}}'
                                                    wire:model.defer="sender_area_id"

                                                        class="select2 senderAreaSelect2 form-control" style="width:100%">
                                                        <option value="" selected >{{$order->senderArea->name}}</option>

                                                    </select>
                                                    @error('sender_area_id') <span class="text-danger error">{{ $message
                                                        }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="title">{{__('translation.sender.sub.area')}}</label>
                                                    <select wire:model.defer="sender_sub_area_id"
                                                        class="select2 senderSubAreaSelect2 form-control " style="width:100%">
                                                        <option value="">{{$order->senderSubArea->name}}</option>
                                                    </select>
                                                    @error('sender_sub_area_id') <span class="text-danger error">{{ $message
                                                        }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="email">{{__('translation.sender.address')}}</label>
                                                    <input

                                                    disabled
                                                    value='{{$order->sender_address}}'type="text" wire:model.defer="sender_address" class="form-control"
                                                        placeholder="">
                                                    @error('sender_address') <span class="text-danger error">{{ $message
                                                        }}</span>@enderror
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <h4 class="form-section"><i class="la la-pencil-square-o"></i>
                                                    {{__('translation.reciverinfo.info')}}
                                                </h4>
                                            </div>
                                        </div>
                                            {{-- <div class="col-md-6 col-sm-12">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="email">{{__('translation.receiver.name')}}</label>
                                                    <input type="text" wire:model.defer="receiver_name" class="form-control"
                                                        placeholder="">
                                                    @error('receiver_name') <span class="text-danger error">{{ $message
                                                        }}</span>@enderror
                                                </fieldset>
                                            </div> --}}
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <fieldset class="form-group floating-label-form-group">
                                                        <label for="email">{{__('translation.receiver.name')}}</label>
                                                        <input type="text"
                                                        disabled
                                                    value='{{$order->receiver_name}}'
                                                        wire:model.defer="receiver_name" class="form-control"
                                                            placeholder="">
                                                        @error('receiver_name') <span class="text-danger error">{{ $message
                                                            }}</span>@enderror
                                                    </fieldset>
                                                </div>
                                            <div class="col-md-6 col-sm-12">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="email">{{__('translation.receiver.phone.no')}}</label>
                                                    <input type="text"
                                                    disabled
                                                    value='{{$order->receiver_phone_no}}'
                                                    wire:model.defer="receiver_phone_no" class="form-control"
                                                        placeholder="">
                                                    @error('receiver_phone_no') <span class="text-danger error">{{ $message
                                                        }}</span>@enderror
                                                </fieldset>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="title">{{__('translation.receiver.area')}}</label>
                                                    <select   wire:model.defer="receiver_area_id"
                                                    disabled
                                                        class="select2 receiverAreaSelect2 form-control " style="width:100%">
                                                        <option value="" selected>{{$order->receiverArea->name}}</option>

                                                    </select>
                                                    @error('receiver_area_id') <span class="text-danger error">{{ $message
                                                        }}</span>@enderror
                                                </div>
                                            </div>
                                            {{-- @dd($ResevierSubArea); --}}

                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="title">{{__('translation.receiver.sub.area')}}</label>
                                                    <select disabled wire:model.defer="receiver_sub_area_id"
                                                        class="select2 receiverSubAreaSelect2 form-control " style="width:100%">
                                                        <option value="" selected>{{$order->receiverSubArea->name}}</option>
                                                    </select>
                                                    @error('receiver_sub_area_id') <span class="text-danger error">{{ $message
                                                        }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <fieldset class=form-group floating-label-form-group">
                                                    <label for="email">{{__('translation.receiver.address')}}</label>
                                                    <input type="text"
                                                    disabled
                                                    value='{{$order->receiver_address}}'
                                                    wire:model.defer="receiver_address" class="form-control"
                                                        placeholder="">
                                                    @error('receiver_address') <span class="text-danger error">{{ $message
                                                        }}</span>@enderror
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <h4 class="form-section"><i class="la la-map-marker"></i>
                                                {{__('translation.service.info')}}
                                            </h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="title">{{__('translation.service')}}</label>
                                                    <select disabled  wire:model.defer="service_id" class="select2 servicesSelect form-control "
                                                    style="width:100%">
                                                        <option value="" selected > {{$order->service->name}}</option>
                                                    </select>
                                                    @error('service_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group floating-label-form-group">
                                                    <label for="email">{{__('translation.order.fees')}}</label>
                                                    <input  type="text"
                                                    disabled
                                                    value='{{$order->order_fees}}'
                                                        wire:model.defer="order_fees" class="form-control"
                                                        placeholder="">
                                                    @error('order_fees') <span class="text-danger error">{{ $message }}</span>@enderror
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6 row">
                                                <div class='col-md-4'>
                                                    <fieldset class="form-group floating-label-form-group">
                                                        <label for="email">{{__('translation.number_of_paces')}}</label>
                                                        <input type="text"
                                                        disabled
                                                    value='{{$order->number_of_pieces}}'
                                                        wire:model.defer="number_of_pieces" class="form-control"
                                                            placeholder="">
                                                        @error('number_of_pieces') <span class="text-danger error">{{ $message }}</span>@enderror
                                                    </fieldset>
                                                </div>
                                                <div class='col-md-4'>
                                                    <fieldset class="form-group floating-label-form-group">
                                                        <label for="email">{{__('translation.order_weight')}}</label>
                                                        <input type="text"
                                                        disabled
                                                    value='{{$order->order_weight}}'
                                                        wire:model.defer="order_weight" class="form-control"
                                                            placeholder="">
                                                        @error('order_weight') <span class="text-danger error">{{ $message }}</span>@enderror
                                                    </fieldset>
                                                </div>
                                                <div class='col-md-4'>
                                                    <fieldset class="form-group floating-label-form-group">
                                                        <label for="email">{{__('translation.order_value_in_resved')}}</label>
                                                        <input type="text"
                                                        disabled
                                                        value='{{$order->order_value}}'
                                                        wire:model.defer="order_value" class="form-control"
                                                            placeholder="">
                                                        @error('order_value') <span class="text-danger error">{{ $message }}</span>@enderror
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                    <div class="px-2">
                                        <input type="reset" class="btn btn-secondary btn-sm btn-lg" data-dismiss="modal"
                                        value="{{__('translation.back')}}">
                                    </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


@endsection
