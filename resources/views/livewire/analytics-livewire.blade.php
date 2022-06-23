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
                <figure class="highcharts-figure">
                    <div id="container">
                    </div>
                </figure>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <canvas id="myChart" width="600" height="400"></canvas>
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
function LinesCharts(){
    
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
    categories: [
      'Jan',
      'Feb',
      'Mar',
      'Apr',
      'May',
      'Jun',
      'Jul',
      'Aug',
      'Sep',
      'Oct',
      'Nov',
      'Dec'
    ],
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
  series: [{
    name: 'Tokyo',
    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

  }, {
    name: 'New York',
    data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

  }, {
    name: 'London',
    data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

  }, {
    name: 'Berlin',
    data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

  }]
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