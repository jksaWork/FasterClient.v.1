@extends('layouts.Edum')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-info">
            <div class="card-header">
                <div class="card-title">
                    {{__('translation.edit profile')}}
                </div>
            </div>
            <livewire:clients.profile-form>
        </div>
    </div>
    <div class="col-md-4">
    <div>
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <div class="profile-photo">
                        <img src="{{asset('uploads/images/8CYjp3C7MNIAjZ2Zt0bOSO4hTOYyObHh7LrngwnO.svg')}}" width="70" height="70" class="img-fluid rounded-circle" alt="">
                    </div>
                    <h3 class="mt-4 mb-1">{{ auth()->user()->fullname}}</h3>
                </div>
            </div>

            <div class="card-footer pt-0 pb-0 text-center">
                <div class="row">
                    <div class="col-6 pt-3 pb-3 border-right">
                        <h3 class="mb-1">{{auth()->user()->getPendingCount()}}</h3><span class='badge badge-info badge-sm'>{{ __('translation.pending_orders')}}</span>
                    </div>
                    <div class="col-6 pt-3 pb-3">
                        <h3 class="mb-1"> {{auth()->user()->Orders()->count()}} </h3><span class="badge badge-success badge-sm">{{__('translation.total_of_order_count')}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 pt-3 pb-3 border-right border-top">
                        <h3 class="mb-1">{{auth()->user()->getInProgress()}}</h3><span class='badge badge-primary badge-sm'>{{ __('translation.inprogress_order')}}</span>
                    </div>
                    <div class="col-6 pt-3 pb-3 border-top">
                        <h3 class="mb-1"> {{auth()->user()->getPickup()}} </h3><span class="badge badge-secondary badge-sm">{{__('translation.pick_up_order')}}</span>
                    </div>
                </div>
            </div>
        </div>
    <!-- /.col -->
</div>
<!-- /.row -->
</div>
</div>
</div>
    </div>
</div>
@endsection
