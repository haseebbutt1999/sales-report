@extends('adminpanel.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="row ">
            <div class="col-md-12 pl-3 pt-2" style="margin: auto;">
                <div class="card" style="width: 100%">
                    <div class="card-header" style="background: white;">
                        <div class="row ">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="col-md-12 px-3 pt-2">
                                <div class="d-flex justify-content-between align-items-center mr-2">
                                    <h5>Sales Report</h5>
                                    {{--                                    <a href=""><button class="btn-primary">Customer Sync</button></a>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="product_append">
                            <div class="row px-3" style="overflow-x:auto;">

                                <table id="datatabled" class="table   table-hover  table-class ">
                                    <thead class="border-0 ">
                                    <tr class="th-tr table-tr text-center">
                                        <th class="font-weight-bold " >Collections</th>
                                        <th class="font-weight-bold " >Begin Stock</th>
                                        <th class="font-weight-bold " >Units In</th>
                                        <th class="font-weight-bold " >Units Out</th>
                                        <th class="font-weight-bold " >Units Sales</th>
                                        <th class="font-weight-bold " >Cash Sales</th>
                                        <th class="font-weight-bold " >Credit Card Sales</th>
                                        <th class="font-weight-bold " >Bank Transfer Sales</th>
                                        <th class="font-weight-bold " >Gross Sales</th>
                                        <th class="font-weight-bold " >Total Discounts</th>
                                        <th class="font-weight-bold " >Gross Sales</th>
                                        <th class="font-weight-bold " >Shipping Sales</th>
                                        <th class="font-weight-bold " >Total Sales</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($collection_data as $key=>$collection)

                                        <tr class="td-text-center">
                                            <td scope="row">
                                                {{$collection->title}}
                                            </td>
                                            <?php
                                            $stock = 0;
                                            $unitIn = 0;
                                            $unitOut = 0;
                                            foreach($collection->Products as $product){
                                                foreach ($product->Variants as $variant){
                                                    $stock = $variant->old_inventory_quantity + $stock;
                                                    $unitIn = $variant->inventory_quantity + $unitIn;
                                                    $unitOut = ($stock - $unitIn);
                                                }
                                            }
                                            ?>
                                            <td>
                                                {{$stock}}
                                            </td>
                                            <td>
                                                {{$unitIn}}
                                            </td>
                                            <td>
                                                {{$unitOut}}
                                            </td>
                                            <?php
                                            $all_orders = \App\Order::where('shopify_shop_id', \Illuminate\Support\Facades\Auth::user()->id)->get();
                                            $unitSales = 0;
                                            $totalSales = 0;
                                            $totalDiscounts = 0;
                                            $totalSumVal =[];
                                            $val =[];
                                            $totalDiscountVal =[];

                                            foreach ($collection->products as $collection_product){
                                                foreach ($all_orders as $order_lineitem){
                                                    foreach ($order_lineitem->lineitems as $lineitem){
                                                        if($lineitem->product_id != null && $lineitem->variant_id != null){
                                                            foreach($collection_product->Variants as $collection_variant){
                                                                if($collection_variant->shopify_variant_id == $lineitem->variant_id && $collection_variant->shopify_product_id == $lineitem->product_id){
                                                                    $variant_count = \App\Variant::where('shopify_variant_id', $lineitem->variant_id)->where('shopify_product_id', $lineitem->product_id)->count();
                                                                    $unitSales = $variant_count * $lineitem->quantity;
                                                                    array_push($val, $unitSales);
                                                                    $totalSales = ($variant_count * (float)$lineitem->price) * $lineitem->quantity;
                                                                    array_push($totalSumVal, $totalSales);
                                                                    $totalDiscounts = ($variant_count * (float)$lineitem->total_discount) * $lineitem->quantity;
                                                                    array_push($totalDiscountVal, $totalDiscounts);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <td>
                                                {{array_sum($val)}}
                                            </td>
                                            <td >

                                            </td>
                                            <td >

                                            </td>
                                            <td >

                                            </td>
                                            <td >

                                            </td>
                                            <td >
                                                {{array_sum($totalDiscountVal)}}
                                            </td>
                                            <td >

                                            </td>
                                            <td >

                                            </td>

                                            <td >
                                                {{array_sum($totalSumVal)}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {!!  $collection_data->links() !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    <div class="col-lg-12 col-md-12 p-4">--}}
    {{--        <!-- start info box -->--}}
    {{--        <div class="row ">--}}
    {{--            <div class="col-md-12 pl-3 pt-2">--}}
    {{--                <div class="card" style="width: 100%">--}}
    {{--                    <div class="card-body">--}}
    {{--                        <div id="product_append">--}}
    {{--                            <div class="row px-3" style="overflow-x:auto;">--}}

    {{--                                <table id="datatabled" class="table table-borderless  table-hover  table-class ">--}}
    {{--                                    <thead class="border-0 ">--}}

    {{--                                    <tr class="th-tr table-tr text-white text-center">--}}

    {{--                                    </tr>--}}
    {{--                                    </thead>--}}
    {{--                                    <tbody>--}}


    {{--                                    </tbody>--}}
    {{--                                </table>--}}
    {{--                                {!!  $product_data->links() !!}--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection
