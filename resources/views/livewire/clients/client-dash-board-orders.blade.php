<div class="col-xl-12 col-lg-12 col-xxl-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{__('translation.last_five_orders')}}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive recentOrderTable">
                <table class="table verticle-middle table-responsive-md">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
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
                                    <input type="checkbox" class="custom-control-input"  wire:change="AddIdTOOrderIds({{$order->id}})" id="checkbox{{$order->id}}">
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
