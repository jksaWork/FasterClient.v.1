<div>
   <form action="post" wire:submit.prevent='UpdateClient()'>
    <div class="card-body">
        <h4>
            {{__('translation.user.data')}}
        </h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.name')}}</label>
                    <input type="text" class="form-control" name='fullname' value="{{auth()->user()->fullname}}"
                        id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.address')}}</label>
                    <input type="text" class="form-control" name='fullname' value="{{auth()->user()->address}}"
                        id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.phone')}}</label>
                    <input type="text" class="form-control" name='fullname' value="{{auth()->user()->phone}}"
                        id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.email')}}</label>
                    <input type="text" class="form-control" name='fullname' value="{{auth()->user()->email}}"
                        id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.civil_registry')}}</label>
                    <input type="text" class="form-control" name='civil_registry'
                        value="{{auth()->user()->civil_registry}}" id="" aria-describedby="helpId"
                        placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.activity')}}</label>
                    <input type="text" class="form-control" name='activity' value="{{auth()->user()->activity}}"
                        id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <h4>
                {{__('translation.invoice_and_shpiing')}}
            </h4>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.name_in_invoice')}}</label>
                    <input type="text"
                    value='{{auth()->user()->name_in_invoice}}'
                    class="form-control" wire:model='name_in_invoice' name='name_in_invoice' value="{{auth()->user()->name_in_invoice}}"
                        id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.address')}}</label>
                    <input type="text" class="form-control"
                    value='{{auth()->user()->address}}'
                    wire:model='shipping_address' name='fullname' value="{{auth()->user()->address}}"
                        id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.area')}}</label>
                    <select class="form-control" value='{{auth()->user()->area_id}}' name="area_id" wire:model='area_id'>
                        @foreach ($areas as $area)
                        <option value="{{$area->id}}"> {{$area->name}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.sub_areas')}}</label>
                    <select class="form-control" value='{{auth()->user()->sub_area_id}}' wire:model='sub_area_id' name="sub_area_id" id="">
                        @foreach ($subareas as $sub)
                        <option  value="{{$sub->id}}"> {{$sub->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('translation.phone')}}</label>
                    <input type="text" class="form-control" name='fullname' value="{{auth()->user()->phone}}"
                        id="" aria-describedby="helpId" placeholder=""
                        wire:model='shipping_phone'
                        >
                </div>
            </div>
        </div>
    </div>
    @foreach ($errors->all() as $error)
    <span class="text-danger">
        {{ $error }}
    </span>
    <br/>
                @endforeach
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a class="btn btn-light" href="#" onclick="history.back()">
                {{__('translation.back')}}
            </a>
            <button class="btn btn-info">
                {{__('translation.edit')}}
            </button>
        </div>
    </div>
   </form>
</div>
