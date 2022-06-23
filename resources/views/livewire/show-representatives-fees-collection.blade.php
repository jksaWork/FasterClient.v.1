<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.representatives')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('representatives-fees-collection') }}
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
                                        <div wire:ignore class="col-md-12">
                                            <select wire:model="representative_id"
                                                class="select2 representativeSelect2 form-control " style="width:100%">
                                                <option value="">--{{__('translation.select.representative')}}--
                                                </option>
                                                @foreach ($representatives as $representative)
                                                <option {{$representative_id == $representative->id ? 'selected' : ''}}
                                                    value="{{$representative->id}}">
                                                    {{$representative->fullname}} ({{$representative->orders_count}})
                                                </option>
                                                @endforeach
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
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->order_date }}</td>
                                                <td>{{ $order->service->name    }}</td>
                                                <td>{{ $order->client->fullname  ?? '-'}}</td>
                                                <td>{{ $order->representative->fullname  ?? ' - '}}</td>
                                                <td>{{ $order->total_fees }}</td>
                                                <td>
                                                    <input type="checkbox" value="{{$order->client_id}}"
                                                        wire:model="checked_orders.{{$order->id}}" class="">
                                                </td>
                                            </tr>

                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="10">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4"></th>
                                                <th class="text-center">{{__('translation.total.fees')}}
                                                </th>
                                                <th>{{$total_fees}}</th>
                                                <th>
                                                    <button wire:click="collectCheckedOrders" class="btn btn-info">
                                                        {{__('translation.collect')}}
                                                    </button>
                                                </th>
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

    window.Livewire.on('select2', function(){
        $('.select2').select2();
    })
    function showPass($num){
        $('.iconLeft3').attr('type', 'text');
    }
</script>
@endpush
