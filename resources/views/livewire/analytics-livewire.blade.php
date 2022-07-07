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

    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
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
<div>
    <div class='mx-1'>
        <div class="card col-xl-12 py-3">
            <div class="card-content">
                <div class="col-md-12 row p-0 m-0">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('translation.start_date')}}</label>
                            <input type="date" class="form-control" name="start_date" wire:model='StartDate' id=""
                                aria-describedby="helpId" placeholder="">
                            @error('start_date')
                            <small id="helpId" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('translation.end_date')}}</label>
                            <input type="date" class="form-control" name="end_date" wire:model='endDate' id=""
                                aria-describedby="helpId" placeholder="">
                            @error('end_date')
                            <small id="helpId" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-6 col-xxl-6 col-sm-12">
            <div class="card">
                @if(count($orders) > 0)
                <figure class="highcharts-figure">
                    <div id="container">
                    </div>
                </figure>
                @else
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class='text-center'>
                        <span class="mb-5">
                            <svg style="width:40px;height:40px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M5 5H7V11H5V5M10 5H8V11H10V5M5 19H7V13H5V19M10 13H8V19H10V17H15V15H10V13M2 21H4V3H2V21M20 3V7H13V5H11V11H13V9H20V15H18V13H16V19H18V17H20V21H22V3H20Z" />
                            </svg>
                        </span>
                        <div>
                            <h3>
                                {{__('translation.no_chart_Data_right_now')}}
                            </h3>
                        </div>
                    </div>
                </div>
                @endif


            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                @if(count($DailyOrders) > 0)
                <canvas id="myChart" width="600" height="400"></canvas>
                @else
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class='text-center'>
                        <span class="mb-5">
                            <svg style="width:40px;height:40px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M5 5H7V11H5V5M10 5H8V11H10V5M5 19H7V13H5V19M10 13H8V19H10V17H15V15H10V13M2 21H4V3H2V21M20 3V7H13V5H11V11H13V9H20V15H18V13H16V19H18V17H20V21H22V3H20Z" />
                            </svg>
                        </span>
                        <div>
                            <h3>
                                {{__('translation.no_chart_Data_right_now')}}
                            </h3>
                        </div>
                    </div>
                </div>
                @endif


            </div>
        </div>
        <div class="col-xl-12">
            <figure class="highcharts-figure-lines">
                <div id="container-lines"></div>
                <p class="highcharts-description">
                </p>
            </figure>
        </div>
    </div>
</div>
@push('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const   data1 = @json($DailyOrders);
    LineOrder(data1);
        function LineOrder(data1){
            console.log(data1);
            const labels = data1.map(item => item.label);
            const CartData = {
                labels: labels,
                datasets: [{
                label: '{{__('translation.order_weekly_chart_for_last_tow_month')}}',
                backgroundColor: 'rgb(20, 59, 100)',
                borderColor:'rgb(20, 59, 100)' ,
                data: data1.map(item => item.Data),
                }]
            };

                const config = {
                type: 'line',
                data: CartData,
                options: {
                    lineTension:.5,
                }
                };

                const myChart = new Chart(
                document.getElementById('myChart'),
                config
                );
                window.myChart = myChart;
        }
</script>
<script>
    var data = @json($orders);

    PieChart(data);
function PieChart(data){

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
        data: data
    }]
});
}

// lines chart
areaJson  = @json($areaChart);
area = @json($area);
console.log(areaJson);
console.log(area);
LinesCharts(areaJson);

function LinesCharts(areaJson){
console.log(areaJson);
// labales = object.Keys(areaJson);
labales = Object.keys(areaJson);
console.log
console.log(labales);
let series = [];
area.forEach(element => {
 let   areaJsonMapReuslt = Object.values(areaJson).map(function(innerarray){
        // console.log(innerarray , 'innerarray            ---------------');
        let inArrayMapResult;
        for (let index = 0; index < area.length; index++) {
            try {
            const ele = innerarray[index];
            if(index == 1){
                console.log(ele , 'element of array -------------------');
            }
                inArrayMapResultitem = ele.sendid == element.id ? ele.c : 0;
                inArrayMapResult = inArrayMapResultitem;
            } catch (error) {
                // inArrayMapResult.push(0);
            }
        }
        return inArrayMapResult;
    });
    console.log(areaJsonMapReuslt , 'area_json_map_resutl');
    const sericechild =   {
        'data' : areaJsonMapReuslt,
        'name' : element.name,
    }
    series.push(sericechild);
    // console.log(sericechild);
});
console.log(series , 'sercie -------------------------------------------------');

// console.log(labales ,  '======================')
series2 = [{
    name: 'Tokyo',
    data: [49.9]
  }, {
    name: 'New York',
    data: [83.6, 78.8]
  }];
  console.log(series2);
Highcharts.chart('container-lines', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Static of Orders In Month',
  },
  subtitle: {
    text: 'Source: WorldClimate.com'
  },
  xAxis: {
    categories: labales,
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Rainfall (mm)'
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    }
  },
  series: series,
});
}

</script>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('updatedCharts', function(val , val2){
            // alert('jksaaltigani');
            console.log(val, val2);
            window.myChart?.destroy();
            PieChart(val2);
            // console.log(val, val2);
            LineOrder(val);
            LinesCharts();
        });
    });
</script>
@endpush
