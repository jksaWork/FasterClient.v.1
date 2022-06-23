<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.representatives')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('representatives-orders') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="row">
                                        <div wire:ignore class="col-md-6">
                                            <select wire:model="representative_id"
                                                class="select2 representativeSelect2 form-control " style="width:100%">
                                                <option value="">--{{__('translation.select.representative')}}--
                                                </option>
                                                @foreach ($representatives as $representative)
                                                <option {{$representative_id == $representative->id ? 'selected' : ''}}
                                                    value="{{$representative->id}}">
                                                    {{$representative->fullname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select wire:model="status" class=" form-control " style="width:100%">
                                                <option value="">--{{__('translation.select.order.status')}}--</option>
                                                {{-- <option value="pending">
                                                    {{__('translation.pending')}}</option> --}}
                                                <option value="pickup">
                                                    {{__('translation.pickup')}}</option>
                                                <option value="inProgress">
                                                    {{__('translation.inProgress')}}</option>
                                                <option value="delivered">
                                                    {{__('translation.delivered')}}</option>
                                                <option value="completed">
                                                    {{__('translation.completed')}}</option>
                                                <option value="returned">
                                                    {{__('translation.returned')}}</option>
                                                <option value="canceled">
                                                    {{__('translation.canceled')}}</option>
                                            </select>
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
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.order.transfer')}}</th>
                                                <th>{{__('translation.status.change')}}</th>
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
                                                <td>{{ $order->representative->fullname  ?? ' -- '}}</td>
                                                <td>{{ $order->total_fees }}</td>
                                                <td>
                                                    <span class="badge @switch($order->status)
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
                                                    {{-- {{ $order->status }}</td> --}}
                                                <td>
                                                    <select wire:model="order_transfer_data"
                                                        class="select2 orderTransferSelect2 form-control "
                                                        style="width:150px">
                                                        <option value="">{{__('translation.select.representative')}}
                                                        </option>
                                                        @foreach ($representatives as $representative)
                                                        <option @if ($representative->id == $order->representative_id)
                                                            selected
                                                            @endif
                                                            value="{{json_encode(["representative_id" => $representative->id, "order_id" => $order->id])}}">
                                                            {{$representative->fullname}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select wire:model="status_change_data"
                                                        class="form-control change-status" style="width:150px">
                                                        <option value="">{{__('translation.select.order.status')}}
                                                        </option>
                                                        <option @if ($order->status == 'pending')
                                                            selected = "true"
                                                            @endif
                                                            value="{{json_encode(['status' => 'pending', 'order_id' => $order->id])}}">
                                                            {{__('translation.pending')}}</option>
                                                        <option @if ($order->status == 'pickup')
                                                            selected = "true"
                                                            @endif
                                                            value="{{json_encode(['status' => 'pickup', 'order_id' => $order->id])}}">
                                                            {{__('translation.pickup')}}</option>
                                                        <option @if ($order->status == 'inProgress')
                                                            selected = "true"
                                                            @endif
                                                            value="{{json_encode(['status' => 'inProgress', 'order_id' => $order->id])}}">
                                                            {{__('translation.inProgress')}}</option>
                                                        <option @if ($order->status == 'delivered')
                                                            selected = "true"
                                                            @endif
                                                            value="{{json_encode(['status' => 'delivered', 'order_id' => $order->id])}}">
                                                            {{__('translation.delivered')}}</option>
                                                        <option @if ($order->status == 'completed')
                                                            selected = "true"
                                                            @endif
                                                            value="{{json_encode(['status' => 'completed', 'order_id' => $order->id])}}">
                                                            {{__('translation.completed')}}</option>
                                                        <option @if ($order->status == 'returned')
                                                            selected = "true"
                                                            @endif
                                                            value="{{json_encode(['status' => 'returned', 'order_id' => $order->id])}}">
                                                            {{__('translation.returned')}}</option>
                                                        <option @if ($order->status == 'canceled')
                                                            selected = "true"
                                                            @endif
                                                            value="{{json_encode(['status' => 'canceled', 'order_id' => $order->id])}}">
                                                            {{__('translation.canceled')}}</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button data-toggle="modal" data-target="#showModal{{$order->id}}"
                                                        class="btn btn-sm btn-icon
                                                                    btn-info"><i class="la la-info"></i></button>
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
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4 class="form-section"><i
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
                                                                            {{$order->representative->fullname ?? '-- '}}
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
                                                                            {{date('Y-m-d h:m:s',strtotime($order->order_date))}}
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

                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.representative.deserves')}}
                                                                                : </b>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{$order->representative_deserves}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-5">
                                                                            <b>{{__('translation.company.deserves')}}:
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-7">
                                                                            {{$order->company_deserves}}
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
                                                                            {{$order->delivery_date ? $order->delivery_date : "-"}}
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
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.order.transfer')}}</th>
                                                <th>{{__('translation.status.change')}}</th>
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



</div>
</div>


@push('scripts')
<script type="text/javascript">
    window.livewire.on('status_change_confirmation', (status_change_data) => {
        // console.log(e.target.value);
        Swal.fire({
        title: '{{__('translation.status.change')}}',
        text: '{{__('translation.status.change.confirmation.text')}}',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: '{{__('translation.yes')}}',
        cancelButtonText: '{{__('translation.cancel')}}'
        }).then((result) => {
        //if user clicks on delete
        if (result.value) {
        // calling destroy method to delete
        // @this.set('status_change_data', e.target.value);
        @this.emit('status_change_confirmed', status_change_data)
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
    window.livewire.on('status_change_to_pending_confirmation', (status_change_data) => {
        // console.log(e.target.value);
        Swal.fire({
        title: '{{__('translation.status.change')}}',
        text: '{{__('translation.status.change.to.pending.confirmation.text')}}',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: '{{__('translation.yes')}}',
        cancelButtonText: '{{__('translation.cancel')}}'
        }).then((result) => {
        //if user clicks on delete
        if (result.value) {
        // calling destroy method to delete
        // @this.set('status_change_data', e.target.value);
        @this.emit('status_change_confirmed', status_change_data)
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
    window.livewire.on('representative_change_confirmation', (order_transfer_data) => {
        // console.log(e.target.value);
        Swal.fire({
        title: '{{__('translation.representative.change')}}',
        text: '{{__('translation.representative.change.confirmation.text')}}',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: '{{__('translation.yes')}}',
        cancelButtonText: '{{__('translation.cancel')}}'
        }).then((result) => {
        //if user clicks on delete
        if (result.value) {
        // calling destroy method to delete
        // @this.set('status_change_data', e.target.value);
        @this.emit('representative_change_confirmed', order_transfer_data)
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
        $('#AddModal').modal('hide');
    });
    window.livewire.on('updated', () => {
        $('#updateModal').modal('hide');
    });
    // representativeSelect2
    $('.representativeSelect2').select2();
    $('.representativeSelect2').on('change', function (e) {
        @this.set('representative_id', e.target.value);
    });
    // orderTransferSelect2
    $('.orderTransferSelect2').select2({width : '200'});
    $('.orderTransferSelect2').on('change', function (e) {
        @this.set('order_transfer_data', e.target.value);
    });
    window.Livewire.on('select2', function(){
        $('.select2').select2();
        $('.orderTransferSelect2').select2({width : '200'});
        $('.orderTransferSelect2').on('change', function (e) {
            @this.set('order_transfer_data', e.target.value);
        });

    })
    function showPass($num){
        $('.iconLeft3').attr('type', 'text');
    }
</script>
@endpush
