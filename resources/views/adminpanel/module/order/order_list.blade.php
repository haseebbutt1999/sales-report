@extends('adminpanel.admin-module.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="row ">
            <div class="col-md-12 pl-3 pt-2">
                <div class="card" style="width: 100%">
                    <div class="card-header" style="background: white;">
                        <div class="row ">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="col-md-12 px-3 pt-2">
                                <div class="d-flex justify-content-between">
                                    <h3>Orders</h3>
                                    <form action="{{Route('order.fetch')}}" method="post">
                                        @csrf
                                        <button type="submit"   class="btn btn-sm btn-primary text-white">Sync Orders</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row px-3" style="overflow-x:auto;">
                            <table id="datatabled" class="table table-borderless  table-hover  table-class">
                                <thead class="border-0 ">

                                <tr class="th-tr table-tr text-white text-center">
                                    <th class="font-weight-bold">Order</th>
                                    <th class="font-weight-bold">Date</th>
                                    <th class="font-weight-bold">Total</th>
                                    <th class="font-weight-bold">Payment</th>
                                    <th class="font-weight-bold">Fulfillment</th>
                                    <th class="font-weight-bold">Items</th>
                                    <th class="font-weight-bold">Delivery method</th>
                                    <th class="font-weight-bold">Action</th>
                                </tr>
                                </thead>

                            <tbody>
                                    @foreach($order_data as $key=>$order)

                                    <tr class="td-text-center ">
                                        <td scope="row"><a class="td-a"  href="{{Route('order-detail', $order->id)}}">{{$order->shopify_order_name}}</a> </td>
                                        <td>{{date("g:ia ", strtotime( $order->created_at))}}</td>
                                        <td>
                                            @if($order->currency == 'USD') <span>$</span>@endif{{$order->total_price}}
                                        </td>
                                        <td>
                                            @if($order->financial_status == "paid")
                                                <div><span class="badge badge-pill badge-success py-2 px-4">Paid</span></div>
                                            @elseif($order->financial_status == 'partially paid')
                                                <div><span class="badge badge-pill badge-primary py-2 px-4">Partially Paid</span></div>
                                            @elseif($order->financial_status == 'pending')
                                                <div><span class="badge badge-pill badge-warning py-2 px-4">Pending</span></div>
                                            @elseif($order->financial_status == 'authorized')
                                                <div><span class="badge badge-pill badge-info py-2 px-4">Authorized</span></div>
                                            @else
                                                <div><span class="badge badge-pill badge-info py-2 px-4">{{$order->financial_status}}</span></div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->fulfillment_status == null)
                                                <div><span class="badge badge-pill badge-danger py-2 px-4">Unfulfilled</span></div>
                                            @else
                                                <div><span class="badge badge-pill badge-warning py-2 px-4">{{$order->fulfillment_status}}</span></div>
                                            @endif
                                        </td>
                                        <td>
                                            @if(count(json_decode($order->line_items)) == 1)
                                                {{count(json_decode($order->line_items))}} item
                                            @else
                                                {{count(json_decode($order->line_items))}} items
                                            @endif
                                                {{--                                                {{$shipping_line->title}}--}}
{{--                                            @endforeach--}}
                                        </td>
                                        <td>
                                            @foreach(json_decode($order->shipping_lines) as $shipping_line)
                                                {{$shipping_line->title}}
                                            @endforeach
                                        </td>
                                        <td style="text-align: right;"><a class="btn btn-primary text-white btn-sm text-right" href="{{Route('order-detail', $order->id)}}">View</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                {!!  $order_data->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end info box -->
    </div>
    <script type="text/javascript">
        function PackageTitle(t) {
            var package_title = t.val();
            var current_product_id=t.prev('input').val();
            // console.log(current_product_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post",
                url: 'save/product_package',
                data: {
                    package_value: t.val(),
                    current_product_id: current_product_id,
                },

                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.log(error);
                    // alert("Mailbox Not Saved");
                }
            });
        }

        function MailboxTitle(t) {
            var mailbox_title = t.val();
            var current_product_id=t.prev('input').val();
            // console.log(current_product_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post",
                url: 'save/product_mailbox',
                data: {
                    mailbox_value: t.val(),
                    current_product_id: current_product_id,
                },

                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.log(error);
                    // alert("Mailbox Not Saved");
                }
            });
        }

    </script>
@endsection
