@extends('layouts.Edum')
@push('styles')
<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 320px;
        max-width: 660px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-xl-4 col-xxl-4 col-sm-12">
        <div class="card">
            <figure class="highcharts-figure">
                <div id="container">
                </div>
            </figure>
        </div>
    </div>
    <div class="col-xl-8 col-xxl-8 col-sm-12">
        <div class="row">
            <div class="col-xl-6 col-xxl-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('translation.pending_orders')}}</h4>
                        <h3>{{$order_in_month->where('status' , 'pending')->count()}}</h3>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-animated bg-info"
                                style="width: {{getPrecent($order_in_month, 'pending')}}%"></div>
                        </div>
                        <small>{{getPrecent($order_in_month, 'pending') . '%'}}
                            {{__('translation.from_count_order_in_this_thirty_day')}}</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('translation.inprogress_order')}}</h4>
                        <h3>{{$order_in_month->where('status' , 'inPorgress')->count()}}</h3>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-animated bg-warning"
                                style="width: {{getPrecent($order_in_month, 'inPorgress')}}%"></div>
                        </div>
                        <small>{{getPrecent($order_in_month, 'inPorgress') . '%'}}
                            {{__('translation.from_count_order_in_this_thirty_day')}}</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('translation.completed_orders')}}</h4>
                        <h3>{{$order_in_month->where('status' , 'completed')->count()}}</h3>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-animated bg-red"
                                style="width: {{getPrecent($order_in_month, 'completed')}}%"></div>
                        </div>
                        <small>{{getPrecent($order_in_month, 'completed') . '%'}}
                            {{__('translation.from_count_order_in_this_thirty_day')}}</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('translation.canceled_order')}}</h4>
                        <h3>25160$</h3>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-animated bg-success" style="width: 30%"></div>
                        </div>
                        <small>{{__('translation.from_count_order_in_this_thirty_day')}}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-xxl-12 col-md-12">
        <div class="card">
            {{-- <div class="card-header w-100"> --}}
                <div class="d-flex justify-content-between pt-3 px-3">
                    <h4 class="card-title">{{__('translation.last_five_orders')}}</h4>
                    <div>
                        <form action="{{route('print.invoices')}}" method="POST" class="print_form"
                            style="display: none">
                            @csrf
                            <input type="hidden" name='ids' />
                            <button type='submit' class="btn btn-round btn-outline-info btn-sm" type="button"><i
                                    class="la la-print la-sm"></i>
                                {{__('translation.print.orders')}} </button>
                        </form>
                        </a>
                        {{--
                    </div> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive recentOrderTable">
                    <table class="table verticle-middle table-responsive-md">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="custom-control custom-checkbox">

                                        <input type="checkbox" class="custom-control-input" id="checkAll"
                                            onchange="CheckAllFun()">
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th scope="col">{{__('translation.receiver.name')}}</th>
                                <th scope="col">{{__('translation.service')}}</th>
                                <th scope="col">{{__('translation.date')}}</th>
                                <th scope="col">{{__('translation.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input order_ids"
                                            value='{{$order->id}}' onchange="AddIdToArray({{$order->id}})"
                                            id="checkbox{{$order->id}}">
                                        <label class="custom-control-label" for="checkbox{{$order->id}}"></label>
                                    </div>
                                </td>
                                <td>
                                    {{$order->receiver_name}}
                                </td>
                                <td>
                                    {{$order->service->name}}
                                </td>
                                <td>
                                    {{$order->order_date}}
                                </td>
                                <td>
                                    <div class="dropdown custom-dropdown mb-0 ">
                                        <div data-toggle="dropdown" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end"
                                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-61px, -134px, 0px);">
                                            <a class="dropdown-item" href="javascript:void(0);">Accept</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
@push('script')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    var data = @json($chart);
console.log(data);
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: "{{__('translation.order_status_pie_chart')}}"
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
      name: 'Chrome',
      y: 61.41,
      sliced: true,
      selected: true
    }, {
      name: 'Internet Explorer',
      y: 11.84
    }, {
      name: 'Firefox',
      y: 10.85
    }, {
      name: 'Edge',
      y: 4.67
    }, {
      name: 'Safari',
      y: 4.18
    }, {
      name: 'Sogou Explorer',
      y: 1.64
    }, {
      name: 'Opera',
      y: 1.6
    }, {
      name: 'QQ',
      y: 1.2
    }, {
      name: 'Other',
      y: 2.61
    }], 
    }]
});
</script>

<script>
    let  inputArray  = [];
    let AllCheked = false;
    function AddIdToArray(val){
        console.log(val);
        if(!inputArray.includes(val)){
            inputArray.push(val);
        }else{
            inputArray = inputArray.filter((el) => el != val);
            console.log(inputArray);
        }
        document.querySelector('[name="ids"]').value = inputArray;
        console.log(document.querySelector('[name="ids"]').value);
        ObservrDsiplaynone();
    }

    function CheckAllFun(){
        if(!AllCheked){
            console.log('clicked');
            let idArray = [];
            let els = document.querySelectorAll('.order_ids');
            els.forEach(element => {
            idArray.push(parseInt(element.value));
            });
            inputArray = [...idArray];
            document.querySelector('[name="ids"]').value = inputArray;
        }else{
            inputArray = [];
            document.querySelector('[name="ids"]').value = '';
        }
        console.log(inputArray);
        console.log(document.querySelector('[name="ids"]').value);
        AllCheked = !AllCheked;
        ObservrDsiplaynone();
    }
    function ObservrDsiplaynone(){
        if(inputArray.length > 0){
            document.querySelector('.print_form').style.display = 'inline-block';
        }else{
            document.querySelector('.print_form').style.display = 'none';
        }
    }
</script>