<div>
    <div class="content-wrapper">
        <div class="content-header row HiddenInPrint">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.clients')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('client.transaction') }}
                    </div>
                </div>
            </div>

        </div>
        @if(count($clients) > 0)
        <div class="content-body ">
            <section id="configuration">
                <div class="row">
                    @foreach ($clients as $item)
                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix HiddenInPrint">
                                    <div class="row  align-center ">
                                        <div class="col-md-6 inprintOnly p-2">
                                            <div class="imgContinaer">
                                                <h1> <b>{{__('translation.name.of.company')}}</b> : {{
                                                    $OrganizationProfile->name}} </h1>
                                            </div>
                                        </div>
                                        <div class="col-md-6  p-2 text-right inprintOnly">
                                            <div class="imgContinaer text-right inprintOnly">
                                                <img src="{{asset('uploads/' . $OrganizationProfile->logo)}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-1">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="d-flex align-itmes-center">
                                                <input type="checkbox" class="switch"
                                                    wire:model="checked_orders.{{$item->id}}" class="form-control"
                                                    id="check_box_sercvies" placeholder="" value="{{$item->id}}">
                                                <span>
                                                    {{$item->fullname }}
                                                </span>
                                            </h3>
                                            <div>
                                                <a href="#" wire:click.prevent="ExportIssueToClient({{$item->id}})"
                                                    class="btn btn-sm btn-primary">
                                                    {{__('translation.issue')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table datatable table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('translation.No')}}</th>
                                                <th>{{__('translation.receiver.name')}}</th>
                                                <th>{{__('translation.order.fees.and.delvirey')}}</th>
                                                <th>{{__('translation.delivery.service.fees')}} </th>
                                                <th>{{__('translation.delivery.fees.shipping.vendor')}}</th>
                                                <th>{{__('translation.total.fees.become')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $totalBlade = 0;
                                            $DeliveryFess = [];
                                            $totalOfService = 0;
                                            @endphp
                                            @if(count($item->Orders) > 0)
                                            @foreach ($item->Orders as $key => $item)

                                            @php
                                            $totalBlade += $item->total_fees;
                                            $totalOfService += $item->total_fees - $item->delivery_fees;
                                            if(isset($DeliveryFess[$item->service_id])){
                                            $DeliveryFess[$item->service_id] += (int) $item->delivery_fees;
                                            }else {
                                            $DeliveryFess[$item->service_id] = (int) $item->delivery_fees;
                                            }
                                            @endphp
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->receiver_name }}</td>
                                                <td>{{ $item->total_fees}}
                                                </td>
                                                <td>{{ $item->service_id == 1 ? $item->delivery_fees : " - "}}</td>
                                                <td>{{ $item->service_id == 2 ? $item->delivery_fees : " - "}}</td>
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
                                    <div class="row mt-5">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label
                                                    for=""><b>{{__('translation.order.fees.and.delvirey')}}</b></label>
                                                <input type="text" readonly value="{{$totalBlade}}" class="form-control"
                                                    name="" id="" aria-describedby="helpId" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for=""><b>{{__('translation.totol.delivery.fees')}}</b></label>
                                                <input type="text" readonly value="{{ $DeliveryFess[1] ?? '0'}}"
                                                    class="form-control" name="" id="" aria-describedby="helpId"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label
                                                    for=""><b>{{__('translation.total.shiping.delivery.fees')}}</b></label>
                                                <input type="text" readonly value="{{$DeliveryFess[2] ?? '0'}}"
                                                    class="form-control" name="" id="" aria-describedby="helpId"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for=""><b>{{__('translation.total.fees.become')}}</b></label>
                                                <input type="text" readonly value="{{$totalOfService}}"
                                                    class="form-control" name="" id="" aria-describedby="helpId"
                                                    placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label
                                                    for=""><b>{{__('translation.total.delivery.service.fees')}}</b></label>
                                                <input type="text" readonly value="{{$DeliveryFess[1] ?? '-'}}"
                                                    class="form-control" name="" id="" aria-describedby="helpId"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label
                                                    for=""><b>{{__('translation.total.delivery.fees.shipping.vendor')}}</b></label>
                                                <input type="text" readonly value="{{$DeliveryFess[2] ?? '-'}}"
                                                    class="form-control" name="" id="" aria-describedby="helpId"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""><b>{{__('translation.total_fo_servie')}}</b></label>
                                                <input type="text" disabled
                                                    value="{{($DeliveryFess[1]  ?? 0)+ ($DeliveryFess[2] ?? 0  )}}"
                                                    class="form-control" name="" id="" aria-describedby="helpId"
                                                    placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- {!! $data->links() !!} --}}
            </section>
        </div>
        <button class="btn btn-primary" wire:click='ExportIssueToClientWithCheckBoxs()'>
            {{__('translation.issue')}}
        </button>
        @else
        <div class="d-flex align-items-center justify-content-center ">
            <div>
                <svg style="width:240px;height:240px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M20 17H22V15H20V17M20 7V13H22V7H20M11 9H16.5L11 3.5V9M4 2H12L18 8V20C18 21.11 17.11 22 16 22H4C2.89 22 2 21.1 2 20V4C2 2.89 2.89 2 4 2M13 18V16H4V18H13M16 14V12H4V14H16Z" />
                </svg>
                <h3>{{__('translation.no_order_need_issue')}} !!</h3>
            </div>
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    //reinitiate select2 on every request
    window.livewire.on("select2", function(){
    $('.select2').select2();
    $('.datatable').DataTable( {
            dom: 'B',
            buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print',
            ]
            $('.select2').select2();
            // change select2 value
            $('.select2').on('change', function (e) {
            @this.set('client_id', e.target.value);
            });
        } );
    })
</script>
@endpush
