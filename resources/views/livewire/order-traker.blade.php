<div>
    <div class="col-12">
        <div class="card overflow-hidden">
            <div class="card-content">
                <div class="card-body cleartfix">
                    <div class="row">
                        <div class="col-md-12">
                            <form wire:submit.prevent='AddIdToIds'>
                                <fieldset class="form-group posision-relative">
                                    <label for="">{{__('translation.add_order_by_id')}}</label>
                                    <input placeholder="{{__('translation.search.by.order.id')}}"
                                        wire:model="AddedID" type="search" class="form-control"
                                        id="search">
                                </fieldset>
                                @error('AddedID')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </form>
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
                    <div class="d-flex justify-content-between my-1">
                        <div>
                            <h5 class="mx-2">{{__('translation.orders')}}</h5>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 3px">{{__('translation.No')}}</th>
                                <th>
                                    {{__('translation.by')}}
                                </th>
                                <th>
                                    {{__('translation.status')}}
                                </th>
                                <th>
                                    {{__('translation.note')}}
                                </th>
                                <th>{{__('translation.date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($traker) > 0)
                            @foreach ($traker as $key => $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->by }}</td>
                                <td>
                                    <span class="badge {{$statusList[$order->status]}}">
                                        {{$order->status}}
                                    </span>
                                </td>
                                <td>
                                    {{-- <span class="badge {{$statusList[$order->status]}}"> --}}
                                        {{$order->Note() }}
                                    {{-- </span> --}}
                                </td>
                                <td>
                                    {{$order->date}}
                                </td>
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
                                <th>
                                    {{__('translation.by')}}
                                </th>
                                <th>
                                    {{__('translation.status')}}
                                </th>
                                <th>
                                    {{__('translation.note')}}
                                </th>
                                <th>{{__('translation.date')}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
