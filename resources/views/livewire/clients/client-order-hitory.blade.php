<div>
    <div class="card-content collapse show">
        <div class="card-body card-dashboard table-responsive">
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
                    @if(count($Orders) > 0)
                    @foreach ($Orders as $key => $order)
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
                                        @case('returned')
                                        badge-danger
                                        @break
                                    @default
                                @endswitch ">{{ __('translation.'.$order->status) }}</span>
                        </td>
                        <td>{{ $order->total_fees }}</td>
                        <td>
                            <a href="{{route('print.invoice', $order->id)}}"
                                class="btn btn-sm btn-icon btn-outline-warning"><i
                                    class="fa fa-print"></i>
                            </a>
                            <a href='{{route('orders.show.details', $order->id )}}'
                                    data-backdrop="static" data-keyboard="false"
                                    wire:click="edit({{ $order->id }})" class="btn btn-sm btn-outline-primary btn-icon
                                    ">
                                <i class="fa fa-eye"></i>
                            </a>
                            <button data-toggle="tooltip" data-placement="top"
                                data-original-title="{{__('translation.delete')}}"
                                wire:click="$emit('triggerOrderDelete', {{$order->id}})"
                                class="btn btn-icon btn-outline-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
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
            {{$Orders->links()}}
            {{-- <livewire:clients.clients-add-order> --}}
        </div>
    </div>
    {{-- Because she competes with no one, no one can compete with her. --}}
</div>
