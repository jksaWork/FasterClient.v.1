<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.orders.per.month.reports')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders.month.reports') }}
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6">
                                            <select wire:model="year" class="form-control" id="year" name="year">
                                                <option>year</option>
                                                <option value="1940">1940</option>
                                                <option value="1941">1941</option>
                                                <option value="1942">1942</option>
                                                <option value="1943">1943</option>
                                                <option value="1944">1944</option>
                                                <option value="1945">1945</option>
                                                <option value="1946">1946</option>
                                                <option value="1947">1947</option>
                                                <option value="1948">1948</option>
                                                <option value="1949">1949</option>
                                                <option value="1950">1950</option>
                                                <option value="1951">1951</option>
                                                <option value="1952">1952</option>
                                                <option value="1953">1953</option>
                                                <option value="1954">1954</option>
                                                <option value="1955">1955</option>
                                                <option value="1956">1956</option>
                                                <option value="1957">1957</option>
                                                <option value="1958">1958</option>
                                                <option value="1959">1959</option>
                                                <option value="1960">1960</option>
                                                <option value="1961">1961</option>
                                                <option value="1962">1962</option>
                                                <option value="1963">1963</option>
                                                <option value="1964">1964</option>
                                                <option value="1965">1965</option>
                                                <option value="1966">1966</option>
                                                <option value="1967">1967</option>
                                                <option value="1968">1968</option>
                                                <option value="1969">1969</option>
                                                <option value="1970">1970</option>
                                                <option value="1971">1971</option>
                                                <option value="1972">1972</option>
                                                <option value="1973">1973</option>
                                                <option value="1974">1974</option>
                                                <option value="1975">1975</option>
                                                <option value="1976">1976</option>
                                                <option value="1977">1977</option>
                                                <option value="1978">1978</option>
                                                <option value="1979">1979</option>
                                                <option value="1980">1980</option>
                                                <option value="1981">1981</option>
                                                <option value="1982">1982</option>
                                                <option value="1983">1983</option>
                                                <option value="1984">1984</option>
                                                <option value="1985">1985</option>
                                                <option value="1986">1986</option>
                                                <option value="1987">1987</option>
                                                <option value="1988">1988</option>
                                                <option value="1989">1989</option>
                                                <option value="1990">1990</option>
                                                <option value="1991">1991</option>
                                                <option value="1992">1992</option>
                                                <option value="1993">1993</option>
                                                <option value="1994">1994</option>
                                                <option value="1995">1995</option>
                                                <option value="1996">1996</option>
                                                <option value="1997">1997</option>
                                                <option value="1998">1998</option>
                                                <option value="1999">1999</option>
                                                <option value="2000">2000</option>
                                                <option value="2001">2001</option>
                                                <option value="2002">2002</option>
                                                <option value="2003">2003</option>
                                                <option value="2004">2004</option>
                                                <option value="2005">2005</option>
                                                <option value="2006">2006</option>
                                                <option value="2007">2007</option>
                                                <option value="2008">2008</option>
                                                <option value="2009">2009</option>
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
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

                                    <table class="table datatable table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('translation.month')}}</th>
                                                <th>{{__('translation.total.completed')}}</th>
                                                <th>{{__('translation.total.uncompleted')}}</th>
                                                <th>{{__('translation.total.canceled')}}</th>
                                                <th>{{__('translation.total.orders.number')}}</th>
                                                <th>{{__('translation.order.fees')}}</th>
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.month.percentage')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $order)
                                            <tr class="text-center">
                                                <td style="font-weight: bold">{{ __('translation.'.$order->month) }}
                                                </td>
                                                <td>{{ $order->total_completed }}</td>
                                                <td>{{ $order->total_uncompleted }}</td>
                                                <td>{{ $order->total_canceled }}</td>
                                                <td>{{ $order->total_orders_number }}</td>
                                                <td>{{ $order->order_fees }}</td>
                                                <td>{{ $order->total_fees }}</td>
                                                <td>{{ round($order->month_percentage) }}%</td>
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
                                                <th>{{__('translation.month')}}</th>
                                                <th>{{__('translation.total.completed')}}</th>
                                                <th>{{__('translation.total.uncompleted')}}</th>
                                                <th>{{__('translation.total.canceled')}}</th>
                                                <th>{{__('translation.total.orders.number')}}</th>
                                                <th>{{__('translation.order.fees')}}</th>
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.month.percentage')}}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('.datatable').DataTable( {
    dom: 'B',
    buttons: [
    'copyHtml5',
    'excelHtml5',
    'csvHtml5',
    'pdfHtml5',
    'print',
    ]
    } );
    window.livewire.on("init", function(){
        $('.datatable').DataTable( {
        dom: 'B',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
        'print',
        ]
        } );
        })
</script>
@endpush
