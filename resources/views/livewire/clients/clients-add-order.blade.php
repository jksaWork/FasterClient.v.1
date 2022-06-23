<div>
    <div class="card card-primary">
        <div class="card-header">
            {{__('translation.add.order')}}
        </div>
        <form wire:submit.prevent="store()">
            <div class="modal-body m-3">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br/>
                @endforeach
                <div class="col-md-6 col-sm-12">
                    <h4 class="form-section"><i class="la la-map-marker"></i>
                        {{__('translation.service.info')}}
                    </h4>
                </div>
                <div class="row">
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
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">{{__('translation.order.fees')}}</label>
                            <input  type="text"
                                wire:model.defer="order_fees" class="form-control" placeholder="">
                            @error('order_fees') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h4 class="form-section"><i class="la la-map-marker"></i>
                        {{__('translation.sender.data')}}
                    </h4>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">{{__('translation.sender.name')}}</label>
                            <input type="text" wire:model.defer="sender_name" class="form-control"
                                placeholder="">
                            @error('sender_name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">{{__('translation.sender.phone.no')}}</label>
                            <input type="text" wire:model.defer="sender_phone" class="form-control"
                                placeholder="">
                            @error('sender_phone') <span class="text-danger error">{{ $message
                                }}</span>@enderror
                        </fieldset>
                    </div>
                    <div class="col-md-4 col-sm-12">
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
                    <div class="col-md-4 col-sm-12">
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
                    <div class="col-md-4 col-sm-12">
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">{{__('translation.sender.address')}}</label>
                            <input type="text" wire:model.defer="sender_address" class="form-control"
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
                                <input type="text" wire:model.defer="receiver_name" class="form-control"
                                    placeholder="">
                                @error('receiver_name') <span class="text-danger error">{{ $message
                                    }}</span>@enderror
                            </fieldset>
                        </div>
                    <div class="col-md-6 col-sm-12">
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">{{__('translation.receiver.phone.no')}}</label>
                            <input type="text" wire:model.defer="receiver_phone_no" class="form-control"
                                placeholder="">
                            @error('receiver_phone_no') <span class="text-danger error">{{ $message
                                }}</span>@enderror
                        </fieldset>
                    </div>
                    <div class="col-md-4 col-sm-12">
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

                    <div class="col-md-4 col-sm-12">
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
                    <div class="col-md-4 col-sm-12">
                        <fieldset class=form-group floating-label-form-group">
                            <label for="email">{{__('translation.receiver.address')}}</label>
                            <input type="text" wire:model.defer="receiver_address" class="form-control"
                                placeholder="">
                            @error('receiver_address') <span class="text-danger error">{{ $message
                                }}</span>@enderror
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="card-footer">
            <div class="px-2">
                <input type="reset" class="btn btn-secondary btn-sm btn-lg" data-dismiss="modal"
                value="{{__('translation.cancel')}}">
                <input type="submit" class="btn btn-info btn-sm btn-lg" value="{{__('translation.add')}}">
            </div>
            </div>
        </form>
    </div>
</div>
