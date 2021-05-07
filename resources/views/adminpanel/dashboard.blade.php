@extends('adminpanel.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="print-class d-flex justify-content-between align-items-center">
            <form class="d-flex  mb-3" method="GET" action="{{ route('dashboard') }}">
                <input type="search" autocomplete="off" name="datefilter" value="{{$datefilter}}" class="datefilter" placeholder="Select date.."/>
                <button class="btn btn-primary ml-2">Apply</button>
            </form>
            <div class="d-flex" id="print-button-main">
                <button class="btn btn-primary mr-2 print-report"><i class=" fa fa-print text-white" style="font-size: 20px;margin-right: 10px;cursor: pointer;" aria-hidden="true"></i>Print</button>
                <button class="btn btn-primary" data-toggle="modal" data-target="#save_report_modal"><i class=" fa fa-download text-white" style="font-size: 20px;margin-right: 10px;cursor: pointer;" aria-hidden="true"></i>Save Report</button>
            </div>
        </div>
        <form action="{{ route('save-report') }}" method="post" id="report-save">
            @csrf
{{--        model start--}}
        <div class="modal fade mt-5" id="save_report_modal" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout" role="document">
                <div class="modal-content">
                    <div class="block card p-3 block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <div class="block-options d-flex justify-content-between">
                                <h5 class="block-title">Save Report</h5>
                                <button type="button" class="btn-block-option">
                                    <i class="fa fa-fw fa-times"  data-dismiss="modal" aria-label="Close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">


                                <div class='form-group '>
                                    <label class='control-label'>Report Name:</label>
                                    <input class='form-control report-name' type='text' name="report_name">
                                </div>
                                <input type="hidden" class="datefilter" name="date" value="{{$datefilter}}">
                                <div class="text-right mb-2">
                                    <button class="btn btn-primary btn-lg save-btn" type="submit">Save</button>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--        model end--}}
        <div class="row printableArea">
            <div class="col-md-12 pl-3 pt-2 " style="margin: auto;">
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
                                        <th class="font-weight-bold " >Customizable Other Sales</th>
                                        <th class="font-weight-bold " >Gross Sales</th>
                                        <th class="font-weight-bold " >Total Discounts</th>
                                        <th class="font-weight-bold " >Net Sales</th>

                                        <th class="font-weight-bold " >Shipping Sales</th>
                                        <th class="font-weight-bold " >Total Sales</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $all_dis = [];
                                    $all_shipp = [];
                                    $all_gross = [];
                                    $all_net = [];
                                    $all_totalSale = [];
                                    $all_credit = [];
                                    $all_bank = [];
                                    $all_cash = [];
                                    ?>
                                    @if(count($collection_data) && count($all_orders))
                                        @foreach($collection_data as $key=>$collection)
                                        <tr class="td-text-center report-row-{{$key}}">
                                            <td class="collection-{{$key}}" scope="row">
                                                {{$collection->title}}
                                                <input type="hidden" class="collection-name" name="collection_name[]" value="{{$collection->title}}">
                                            </td>
                                            <?php
                                            $stock = 0;
                                            $unitIn = 0;
                                            $unitOut = 0;
                                            foreach($collection->Products as $product){
                                                foreach ($product->Variants as $variant){
                                                    $stock = $variant->old_inventory_quantity + $stock;
                                                    $unitIn = ($variant->old_inventory_quantity - $variant->inventory_quantity) + $unitIn;
                                                    $unitOut = ($stock - $unitIn);
                                                }
                                            }
                                            ?>
                                            <td class="stock-{{$key}}">
                                                {{$stock}}
                                                <input type="hidden" class="begin-stock" name="begin_stock[]" value="{{$stock}}">
                                            </td>
                                            <td class="unitin-{{$key}}">
                                                {{$unitIn}}
                                                <input type="hidden" class="unitin" name="unitin[]" value="{{$unitIn}}">

                                            </td>
                                            <td class="unitout-{{$key}}">
                                                {{$unitOut}}
                                                <input type="hidden" class="unitout" name="unitout[]" value="{{$unitOut}}">
                                            </td>
                                            <?php

                                            $unitSales = 0;
                                            $grossSales = 0;
                                            $totalSales = 0;
                                            $creditSale = 0;
                                            $bankSale = 0;
                                            $cashSale = 0;
                                            $netSales = 0;

                                            $totalDiscounts = 0;
                                            $totalShippingSales = 0;
                                            $totalShippingSales=0;
                                            $shipping_push = [];
                                            $GrossSumVal =[];
                                            $totalSalesVal =[];
                                            $netSalesVal =[];
                                            $creditSaleVal =[];
                                            $bankSaleVal =[];
                                            $cashSaleVal =[];
                                            $totalShippingSalesVal =[];
                                            $val =[];
                                            $totalDiscountVal =[];

                                            foreach ($collection->products as $collection_product){
                                                dd($all_orders);
                                                foreach ($all_orders as $order_lineitem){
                                                    foreach ($order_lineitem->lineitems as $lineitem){
                                                        if($lineitem->product_id != null && $lineitem->variant_id != null){
                                                            foreach($collection_product->Variants as $collection_variant){
                                                                if($collection_variant->shopify_variant_id == $lineitem->variant_id && $collection_variant->shopify_product_id == $lineitem->product_id){
                                                                    $variant_count = \App\Variant::where('shopify_variant_id', $lineitem->variant_id)->where('shopify_product_id', $lineitem->product_id)->count();
                                                                    $unitSales = $variant_count * $lineitem->quantity;
                                                                    array_push($val, $unitSales);

                                                                    $totalDiscounts = ($variant_count * (float)$lineitem->total_discount) * $lineitem->quantity;
                                                                    array_push($totalDiscountVal, $totalDiscounts);
                                                                    array_push($all_dis, $totalDiscounts);

                                                                    $order_shippingline = json_decode($order_lineitem->shipping_lines);
//                                                                    $totalShippingSales = ((float)($order_shippingline[0]->price) + $totalShippingSales);
                                                                    $totalShippingSales = ($order_shippingline[0]->price) + $totalShippingSales;
                                                                    array_push($totalShippingSalesVal, $totalShippingSales);
                                                                    array_push($all_shipp, $totalShippingSales);

                                                                    $grossSales = (($variant_count * (float)$lineitem->price ) * $lineitem->quantity);
                                                                    array_push($GrossSumVal, $grossSales);
                                                                    array_push($all_gross, $grossSales);

                                                                    $netSales = $grossSales - $totalDiscounts;
                                                                    array_push($netSalesVal, $netSales);
                                                                    array_push($all_net, $netSales);

                                                                    $totalSales = $netSales + $totalShippingSales;
                                                                    array_push($totalSalesVal, $totalSales);
                                                                    array_push($all_totalSale, $totalSales);

                                                                   $payment_method =  json_decode($order_lineitem->payment_gateway_names);
                                                                    if(in_array("Cash on Delivery (COD)", $payment_method)){
                                                                        $cashSale = (($variant_count * (float)$lineitem->price ) * $lineitem->quantity);
                                                                        array_push($cashSaleVal, $cashSale);
                                                                        array_push($all_cash, $cashSale);
                                                                    }elseif(in_array("Bank Deposit", $payment_method)){
                                                                        $bankSale = (($variant_count * (float)$lineitem->price ) * $lineitem->quantity);
                                                                        array_push($bankSaleVal, $bankSale);
                                                                        array_push($all_bank, $bankSale);
                                                                    }else{
                                                                        $creditSale = (($variant_count * (float)$lineitem->price ) * $lineitem->quantity);
                                                                        array_push($creditSaleVal, $creditSale);
                                                                        array_push($all_credit, $creditSale);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

//                                            dd($totalSumVal);
                                            ?>

                                            <td class="unitsale-{{$key}}">
                                                {{array_sum($val)}}
                                                <input type="hidden" class="unitsale" name="unitsale[]" value="{{array_sum($val)}}">
                                            </td>
                                            <td  class="credit-card-sale-{{$key}}">
                                                {{$order_lineitem->currency." ".number_format(array_sum($creditSaleVal),2) }}
                                                <input type="hidden" class="cashsale" name="credit_card_sale[]" value="{{$order_lineitem->currency." ".number_format(array_sum($creditSaleVal),2) }}">
                                            </td>
                                            <td class="cash-sale-{{$key}}">
                                                {{$order_lineitem->currency." ".number_format(array_sum($cashSaleVal),2) }}
                                                <input type="hidden" class="credit-card-sale" name="cashsale[]" value="{{$order_lineitem->currency." ".number_format(array_sum($cashSaleVal),2) }}">
                                            </td>
                                            <td class="bank-sale-{{$key}}">

                                                {{$order_lineitem->currency." ".number_format(array_sum($bankSaleVal),2)}}
                                                <input type="hidden" class="bank-sale" name="bank_sale[]" value="{{$order_lineitem->currency." ".number_format(array_sum($bankSaleVal),2)}}">
                                            </td>
                                            <td class="">

                                            </td>
                                            <td class="gross-sale-{{$key}}">
                                                {{$order_lineitem->currency." ".number_format(array_sum($GrossSumVal),2) }}
                                                <input type="hidden" class="gross-sale" name="gross_sale[]" value="{{$order_lineitem->currency." ".number_format(array_sum($GrossSumVal),2) }}">
                                            </td>
                                            <td class="total-discount-{{$key}}">
                                                {{$order_lineitem->currency." ".number_format(array_sum($totalDiscountVal),2) }}
                                                <input type="hidden" class="total-discount" name="total_discount[]" value="{{$order_lineitem->currency." ".number_format(array_sum($totalDiscountVal),2) }}">
                                            </td>
                                            <td class="net-sale-{{$key}}">
                                                {{$order_lineitem->currency." ".number_format(array_sum($netSalesVal),2) }}
                                                <input type="hidden" class="net-sale" name="net_sale[]" value="{{$order_lineitem->currency." ".number_format(array_sum($netSalesVal),2) }}">
                                            </td>

                                            <td class="total-shipping-{{$key}}">
                                                {{$order_lineitem->currency." ".number_format(array_sum($totalShippingSalesVal),2)}}
                                                <input type="hidden" class="shipping-sale" name="shipping_sale[]" value="{{$order_lineitem->currency." ".number_format(array_sum($totalShippingSalesVal),2)}}">
                                            </td>

                                            <td class="total-sale-{{$key}}">
                                                {{$order_lineitem->currency." ".number_format(array_sum($totalSalesVal),2)}}
                                                <input type="hidden" class="total-sale" name="total_sale[]" value="{{$order_lineitem->currency." ".number_format(array_sum($totalSalesVal),2)}}">
                                            </td>
                                            <?php

                                            ?>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td><b>Total</b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>{{number_format(array_sum($all_credit),2)}}</b></td>
                                            <td><b>{{number_format(array_sum($all_cash),2)}}</b></td>
                                            <td><b>{{number_format(array_sum($all_bank),2)}}</b></td>
                                            <td><b></b></td>
                                            <td><b>{{number_format(array_sum($all_gross),2)}}</b></td>
                                            <td><b>{{number_format(array_sum($all_dis),2)}}</b></td>
                                            <td><b>{{number_format(array_sum($all_net),2)}}</b></td>
                                            <td><b>{{number_format(array_sum($all_shipp),2)}}</b></td>
                                            <td><b>{{number_format(array_sum($all_totalSale),2)}}</b></td>
                                            <input type="hidden"  name="all_credit" value="{{number_format(array_sum($all_credit),2)}}">
                                            <input type="hidden"  name="all_cash" value="{{number_format(array_sum($all_cash),2)}}">
                                            <input type="hidden"  name="all_dis" value="{{number_format(array_sum($all_dis),2)}}">
                                            <input type="hidden"  name="all_bank" value="{{number_format(array_sum($all_bank),2)}}">
                                            <input type="hidden"  name="all_gross" value="{{number_format(array_sum($all_gross),2)}}">
                                            <input type="hidden"  name="all_shipp" value="{{number_format(array_sum($all_shipp),2)}}">
                                            <input type="hidden"  name="all_net" value="{{number_format(array_sum($all_net),2)}}">
                                            <input type="hidden"  name="all_totalSale" value="{{number_format(array_sum($all_totalSale),2)}}">
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(count($collection_data) && count($all_orders))
                                    {!!  $collection_data->links() !!}
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

@endsection
@section('js_after')
    {{--    datepicker js--}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{asset('assets/js/jquery.PrintArea.js')}}"></script>
    <script>

        $(document).ready(function() {

            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $("button.print-report").click(function(){
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {mode: mode, popClose: close};
                $("div.printableArea").printArea(options);
            });
        });

    </script>
@endsection
