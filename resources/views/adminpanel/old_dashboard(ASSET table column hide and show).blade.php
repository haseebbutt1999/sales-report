@extends('adminpanel.layout.default')
@section('content')
    {{--    @dd($all_orders)--}}
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="row">
            <div class="col-md-6">
                <form id="filter-form" class="d-flex  mb-3" method="GET" action="{{ route('dashboard') }}">
                    <select class="w-50 form-control mr-2" name="location">
                        <option selected value="select_option">Select Location</option>
                        @foreach($location_name as $key=>$location)
                            <option @if(($location_select != '') && ($location_select == $location_id[$key])) selected @endif value="{{$location_id[$key]}}">
                                {{$location}}
                            </option>
                        @endforeach
                    </select>
                    <input type="search" autocomplete="off" name="datefilter" value="{{$datefilter}}" class="datefilter w-50 mr-2" placeholder="Select date.."/>
                    <button class="btn btn-primary align-items-center  d-flex filter-button">
                        <span class="loader-span mr-2">
                            <div class="loader"></div>
                        </span>

                        Filter
                    </button>
                </form>

            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end" id="print-button-main">
                    <button class="btn btn-primary mr-2 print-report"><i class=" fa fa-print text-white" style="font-size: 20px;margin-right: 10px;cursor: pointer;" aria-hidden="true"></i>Print</button>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#save_report_modal"><i class=" fa fa-download text-white" style="font-size: 20px;margin-right: 10px;cursor: pointer;" aria-hidden="true"></i>Save Report</button>
                </div>
            </div>
        </div>
        <div class="printableArea">
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
                <div class="row ">
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
                                            <button class="btn-primary display-all-columns btn-sm" type="button">Display Table All Columns</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="product_append">
                                    <div class="row px-3" style="overflow-x:auto;">
                                        <table id="datatabled" class="table table-hover display table-class " >
                                            <thead class="border-0 ">
                                            <tr class="th-tr table-tr text-center">
                                                <th class="font-weight-bold" >Collections</th>
                                                @if(isset($column_data->begin_stock) && $column_data->begin_stock == 'show') <th class="font-weight-bold " ><div  class="custom-grid"><span>Begin Stock</span><input type="checkbox" class="hidecol ml-1" value="name" id="col_2" /></div></th>@endif
                                                <th class="font-weight-bold " ><div  class="custom-grid">Units In <input type="checkbox" class="hidecol ml-1" value="salary" id="col_3" /></div></th>
                                                <th class="font-weight-bold " ><div  class="custom-grid">Units Out <input type="checkbox" class="hidecol ml-1" value="gender" id="col_4" /></div></th>
                                                <th class="font-weight-bold " ><div  class="custom-grid">Units Sales <input type="checkbox" class="hidecol ml-1" value="gender" id="col_5" /></div></th>
                                                <th class="font-weight-bold " ><div  class="custom-grid">Cash Sales <input type="checkbox" class="hidecol ml-1" value="gender" id="col_6" /></div></th>
                                                <th class="font-weight-bold " ><div  class="custom-grid">Credit Card Sales <input type="checkbox" class="hidecol ml-1" value="gender" id="col_7" /></div></th>
                                                <th class="font-weight-bold " ><div  class="custom-grid">Bank Transfer Sales <input type="checkbox" class="hidecol ml-1" value="gender" id="col_8" /></div></th>
{{--                                                <th class="font-weight-bold " >Customizable Other Sales</div></th>--}}
                                                <th class="font-weight-bold " ><div  class="custom-grid">Gross Sales <input type="checkbox" class="hidecol ml-1" value="gender" id="col_9" /></div></th>
                                                <th class="font-weight-bold " ><div  class="custom-grid">Total Discounts <input type="checkbox" class="hidecol ml-1" value="gender" id="col_10" /></div></th>
                                                <th class="font-weight-bold " ><div  class="custom-grid">Net Sales <input type="checkbox" class="hidecol ml-1" value="gender" id="col_11" /></div></th>
                                                <th class="font-weight-bold " ><div  class="custom-grid">Shipping Sales <input type="checkbox" class="hidecol ml-1" value="gender" id="col_12" /></div></th>
                                                <th class="font-weight-bold " ><div  class="custom-grid">Total Sales <input type="checkbox" class="hidecol ml-1" value="gender" id="col_13" /></div></th>
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
                                                                                if(!count($order_shippingline)){
                                                                                    $totalShippingSales = 0 + $totalShippingSales;
                                                                                }else{
                                                                                    $totalShippingSales = ($order_shippingline[0]->price) + $totalShippingSales;
                                                                                }
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
                                                        {{--                                            @dd($order_lineitem)--}}
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

                                            @endif
                                            </tbody>
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><b>{{number_format(array_sum($all_credit),2)}}</b></td>
                                                <td><b>{{number_format(array_sum($all_cash),2)}}</b></td>
                                                <td><b>{{number_format(array_sum($all_bank),2)}}</b></td>

                                                <td><b>{{number_format(array_sum($all_gross),2)}}</b></td>
                                                <td><b>{{number_format(array_sum($all_dis),2)}}</b></td>
                                                <td><b>{{number_format(array_sum($all_net),2)}}</b></td>
                                                <td><b>{{number_format(array_sum($all_shipp),2)}}</b></td>
                                                <td><b>{{number_format(array_sum($all_totalSale),2)}}</b></td>
                                                <input type="hidden" class="cash-sale-input" name="all_credit" value="{{number_format(array_sum($all_credit),2)}}">
                                                <input type="hidden"   name="all_cash" value="{{number_format(array_sum($all_cash),2)}}">
                                                <input type="hidden"  name="all_dis" value="{{number_format(array_sum($all_dis),2)}}">
                                                <input type="hidden"  name="all_bank" value="{{number_format(array_sum($all_bank),2)}}">
                                                <input type="hidden"  name="all_gross" value="{{number_format(array_sum($all_gross),2)}}">
                                                <input type="hidden"  name="all_shipp" value="{{number_format(array_sum($all_shipp),2)}}">
                                                <input type="hidden" name="all_net" value="{{number_format(array_sum($all_net),2)}}">
                                                <input type="hidden"  class="total-sale-input" name="all_totalSale" value="{{number_format(array_sum($all_totalSale),2)}}">
                                            </tr>
                                        </table>
    {{--                                    @if(count($collection_data) && count($all_orders))--}}
    {{--                                        {!!  $collection_data->links() !!}--}}
    {{--                                    @endif--}}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <input type="hidden" class="net_sale"  name="all_net" value="{{array_sum($all_net)}}">

            <div class="w-100 bg-white mt-3">
                <div class="row " >
                    <div class="col-md-6 pl-3 pt-2 " style="margin-top: -10px;">
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
                                            <h5>Daily Cash Closing:</h5>
                                            {{--           <a href=""><button class="btn-primary">Customer Sync</button></a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="product_append">
                                    <div class="row px-3" style="overflow-x:auto;">

                                        <table id="datatabled" class="table   table-hover  table-class ">
                                            <tbody>
                                            <tr class="td-text-center ">
                                                <td>TOTAL SALE:</td>
                                                <td class="total-sale">{{number_format(array_sum($all_totalSale),2)}}</td>
                                            </tr>
                                            <tr class="td-text-center ">
                                                <td>CASH SALE:</td>
                                                <td class="cash-sale">{{number_format(array_sum($all_credit),2)}}</td>
                                            </tr>
                                            <tr class="td-text-center ">
                                                <td>COMISION %:</td>
                                                <td class="d-flex justify-content-between">
                                                    <div class="w-50"><span class="comision-result">{{((array_sum($all_net))*(1/100))}}</span>%</div>
                                                    <div class="w-50 form-group " style="text-align: right">
                                                        <input style="width: 60%;" min="0" step="any" class="comision" type="number" value="1">
                                                        <label>%</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="td-text-center ">
                                                <td style="width: 20%;">Payment 1</td>
                                                <td style="width: 80%;" class="d-flex w-100 justify-content-between payment1">
                                                    <div style="width: 15%;">
                                                        <span class="payment1-amount-result" >0</span>
                                                    </div>
                                                    <div style="width: 70%;">
                                                        <span><strong>Note:</strong></span>
                                                        <span class="payment1-note-result" ></span>
                                                    </div>
                                                    <div style="width: 15%;text-align: end;">
                                                        <button type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payment1"><i class="fa fa-pencil " style="font-size: 16px;color: white" aria-hidden="true"></i></button>
                                                    </div>
                                                    {{--        model start--}}
                                                    <div class="modal fade mt-5 modal-div" id="payment1" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-popout" role="document">
                                                            <div class="modal-content">
                                                                <div class="block card p-3 block-themed block-transparent mb-0">
                                                                    <div class="block-header bg-primary-dark">
                                                                        <div class="block-options d-flex justify-content-between">
                                                                            <h5 class="block-title">Note</h5>
                                                                            <button type="button" class="btn-block-option">
                                                                                <i class="fa fa-fw fa-times"  data-dismiss="modal" aria-label="Close"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="block-content">
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Note:</label>
                                                                            <input class='form-control payment1-note' type='text' >
                                                                        </div>
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Amount:</label>
                                                                            <input class='form-control payment1-amount' step="any" type='number' min="0" value="0" >
                                                                        </div>
                                                                        <div class="text-right mb-2">
                                                                            <button class="btn btn-primary btn-lg payment1-save-btn" type="button">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--        model end--}}
                                                </td>
                                            </tr>
                                            <tr class="td-text-center ">
                                                <td>Payment 2</td>
                                                <td class="d-flex w-100 justify-content-between payment2">
                                                    <div style="width: 15%;">
                                                        <span class="payment2-amount-result" >0</span>
                                                    </div>
                                                    <div style="width: 70%;">
                                                        <span><strong>Note:</strong></span>
                                                        <span class="payment2-note-result" ></span>
                                                    </div>
                                                    <div style="width: 15%;text-align: right">
                                                        <button type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payment2"><i class="fa fa-pencil " style="font-size: 16px;color: white" aria-hidden="true"></i></button>
                                                    </div>
                                                    {{--        model start--}}
                                                    <div class="modal fade mt-5 modal-div" id="payment2" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-popout" role="document">
                                                            <div class="modal-content">
                                                                <div class="block card p-3 block-themed block-transparent mb-0">
                                                                    <div class="block-header bg-primary-dark">
                                                                        <div class="block-options d-flex justify-content-between">
                                                                            <h5 class="block-title">Note</h5>
                                                                            <button type="button" class="btn-block-option">
                                                                                <i class="fa fa-fw fa-times"  data-dismiss="modal" aria-label="Close"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="block-content">
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Note:</label>
                                                                            <input class='form-control payment2-note' type='text' >
                                                                        </div>
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Amount:</label>
                                                                            <input class='form-control payment2-amount' step="any" type='number' min="0" value="0" >
                                                                        </div>
                                                                        <div class="text-right mb-2">
                                                                            <button class="btn btn-primary btn-lg payment2-save-btn" type="button">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--        model end--}}
                                                </td>
                                            </tr>
                                            <tr class="td-text-center ">
                                                <td>Payment 3</td>
                                                <td class="d-flex w-100 justify-content-between payment3">
                                                    <div style="width: 15%;">
                                                        <span class="payment3-amount-result" >0</span>
                                                    </div>
                                                    <div style="width: 70%;">
                                                        <span><strong>Note:</strong></span>
                                                        <span class="payment3-note-result" ></span>
                                                    </div>
                                                    <div style="width: 15%;text-align: right;">
                                                        <button type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payment3"><i class="fa fa-pencil " style="font-size: 16px;color: white" aria-hidden="true"></i></button>
                                                    </div>
                                                    {{--        model start--}}
                                                    <div class="modal fade mt-5 modal-div" id="payment3" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-popout" role="document">
                                                            <div class="modal-content">
                                                                <div class="block card p-3 block-themed block-transparent mb-0">
                                                                    <div class="block-header bg-primary-dark">
                                                                        <div class="block-options d-flex justify-content-between">
                                                                            <h5 class="block-title">Note</h5>
                                                                            <button type="button" class="btn-block-option">
                                                                                <i class="fa fa-fw fa-times"  data-dismiss="modal" aria-label="Close"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="block-content">
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Note:</label>
                                                                            <input class='form-control payment3-note' type='text' >
                                                                        </div>
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Amount:</label>
                                                                            <input class='form-control payment3-amount' step="any" type='number' min="0" value="0" >
                                                                        </div>
                                                                        <div class="text-right mb-2">
                                                                            <button class="btn btn-primary btn-lg payment3-save-btn" type="button">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--        model end--}}

                                                </td>
                                            </tr>
                                            <tr class="td-text-center ">
                                                <td>Payment 4</td>
                                                <td class="d-flex w-100 justify-content-between payment4">
                                                    <div style="width: 15%;">
                                                        <span class="payment4-amount-result" >0</span>
                                                    </div>
                                                    <div style="width: 70%;">
                                                        <span><strong>Note:</strong></span>
                                                        <span class="payment4-note-result" ></span>
                                                    </div>
                                                    <div style="width: 15%;text-align: right;">
                                                        <button type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payment4"><i class="fa fa-pencil " style="font-size: 16px;color: white" aria-hidden="true"></i></button>
                                                    </div>
                                                    {{--        model start--}}
                                                    <div class="modal fade mt-5 modal-div" id="payment4" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-popout" role="document">
                                                            <div class="modal-content">
                                                                <div class="block card p-3 block-themed block-transparent mb-0">
                                                                    <div class="block-header bg-primary-dark">
                                                                        <div class="block-options d-flex justify-content-between">
                                                                            <h5 class="block-title">Note</h5>
                                                                            <button type="button" class="btn-block-option">
                                                                                <i class="fa fa-fw fa-times"  data-dismiss="modal" aria-label="Close"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="block-content">
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Note:</label>
                                                                            <input class='form-control payment4-note' type='text' >
                                                                        </div>
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Amount:</label>
                                                                            <input class='form-control payment4-amount' step="any" type='number' min="0" value="0" >
                                                                        </div>
                                                                        <div class="text-right mb-2">
                                                                            <button class="btn btn-primary btn-lg payment4-save-btn" type="button">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--        model end--}}

                                                </td>
                                            </tr>
                                            <tr class="td-text-center ">
                                                <td>Payment 5</td>
                                                <td class="d-flex w-100 justify-content-between payment5">
                                                    <div style="width: 15%;">
                                                        <span class="payment5-amount-result" >0</span>
                                                    </div>
                                                    <div style="width: 70%;">
                                                        <span><strong>Note:</strong></span>
                                                        <span class="payment5-note-result" ></span>
                                                    </div>
                                                    <div style="width: 15%;text-align: right;">
                                                        <button type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payment5"><i class="fa fa-pencil " style="font-size: 16px;color: white" aria-hidden="true"></i></button>
                                                    </div>
                                                    {{--        model start--}}
                                                    <div class="modal fade mt-5 modal-div" id="payment5" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-popout" role="document">
                                                            <div class="modal-content">
                                                                <div class="block card p-3 block-themed block-transparent mb-0">
                                                                    <div class="block-header bg-primary-dark">
                                                                        <div class="block-options d-flex justify-content-between">
                                                                            <h5 class="block-title">Note</h5>
                                                                            <button type="button" class="btn-block-option">
                                                                                <i class="fa fa-fw fa-times"  data-dismiss="modal" aria-label="Close"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="block-content">
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Note:</label>
                                                                            <input class='form-control payment5-note' type='text' >
                                                                        </div>
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Amount:</label>
                                                                            <input class='form-control payment5-amount' step="any" type='number' min="0" value="0" >
                                                                        </div>
                                                                        <div class="text-right mb-2">
                                                                            <button class="btn btn-primary btn-lg payment5-save-btn" type="button">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--        model end--}}

                                                </td>
                                            </tr>
                                            <tr class="td-text-center ">
                                                <td>Total cash remaining $</td>
                                                <td class="total-cash-remaining"></td>
                                            </tr>
                                            <tr class="td-text-center ">
                                                <td>Total cash collected $</td>
                                                <td class="d-flex w-100 justify-content-between total-cash-collected">
                                                    <div style="width: 15%;">
                                                        <span class="total-amount-collected" >0</span>
                                                    </div>
                                                    <div style="width: 70%;">
                                                        <span><strong>Note:</strong></span>
                                                        <span class="total-amount-collected-note-result" ></span>
                                                    </div>
                                                    <div style="width: 15%;text-align: right;">
                                                        <button type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#collected-amount"><i class="fa fa-pencil " style="font-size: 16px;color: white" aria-hidden="true"></i></button>
                                                    </div>
                                                    {{--        model start--}}
                                                    <div class="modal fade mt-5 modal-div" id="collected-amount" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-popout" role="document">
                                                            <div class="modal-content">
                                                                <div class="block card p-3 block-themed block-transparent mb-0">
                                                                    <div class="block-header bg-primary-dark">
                                                                        <div class="block-options d-flex justify-content-between">
                                                                            <h5 class="block-title">Note</h5>
                                                                            <button type="button" class="btn-block-option">
                                                                                <i class="fa fa-fw fa-times"  data-dismiss="modal" aria-label="Close"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="block-content">
                                                                        <div class='form-group '>
                                                                            <label class='control-label'>Note:</label>
                                                                            <input class='form-control total-collected-amount-note' type='text' >
                                                                        </div>
                                                                        <div class="text-right mb-2">
                                                                            <button class="btn btn-primary btn-lg collected-amount-save-btn" type="button">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--        model end--}}

                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <input type="hidden" class="all-comision" name="comision" value="">
                <input type="hidden" class="all-payment1" name="payment1" value="0">
                <input type="hidden" class="all-payment2" name="payment2" value="0">
                <input type="hidden" class="all-payment3" name="payment3" value="0">
                <input type="hidden" class="all-payment4" name="payment4" value="0">
                <input type="hidden" class="all-payment5" name="payment5" value="0">
                <input type="hidden" class="all-total-cash-remaining" name="total_cash_remaining" value="0">
                <input type="hidden" class="all-total-cash-collected" name="total_cash_collected" value="0">
                <input type="hidden" class="all-note1" name="note1" value="">
                <input type="hidden" class="all-note2" name="note2" value="">
                <input type="hidden" class="all-note3" name="note3" value="">
                <input type="hidden" class="all-note4" name="note4" value="">
                <input type="hidden" class="all-note5" name="note5" value="">
                <input type="hidden" class="all-total-cash-collected-note" name="total_cash_collected_note" value="">
            </form>
        </div>

    </div>

@endsection
@section('js_after')
    {{--    datepicker js--}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/js/jquery.PrintArea.js')}}"></script>
    <script>

        $(document).ready(function() {
            var payment1=0,payment2=0,payment3=0,payment4=0,payment5 =0;

            $("button .loader-span").find(".loader").css('display', 'none')
            $(".payment1-save-btn").click(function(){

                var payment1_note = $('.payment1-note').val();
                var payment1_amount = $('.payment1-amount').val();

                var payment1 = $('.payment1').find('.payment1-note-result').text(payment1_note)
                $('.payment1').find('.payment1-amount-result').text(payment1_amount)
                $('.all-payment1').val(payment1_amount)
                $('.all-note1').val(payment1_note)

                jQuery.noConflict();
                $('.modal-div').modal("hide")

            });
            $(".payment2-save-btn").click(function(){
                var payment2_note = $('.payment2-note').val();
                var payment2_amount = $('.payment2-amount').val();

                var payment2 = $('.payment2').find('.payment2-note-result').text(payment2_note)
                $('.payment2').find('.payment2-amount-result').text(payment2_amount)
                $('.all-payment2').val(payment2_amount)
                $('.all-note2').val(payment2_note)

                jQuery.noConflict();
                $('.modal-div').modal("hide")

            });
            $(".payment3-save-btn").click(function(){
                var payment3_note = $('.payment3-note').val();
                var payment3_amount = $('.payment3-amount').val();

               var payment3 = $('.payment3').find('.payment3-note-result').text(payment3_note)
                $('.payment3').find('.payment3-amount-result').text(payment3_amount)
                $('.all-payment3').val(payment3_amount)
                $('.all-note3').val(payment3_note)

                jQuery.noConflict();
                $('.modal-div').modal("hide")

            });
            $(".payment4-save-btn").click(function(){
                var payment4_note = $('.payment4-note').val();
                var payment4_amount = $('.payment4-amount').val();

                var payment4 = $('.payment4').find('.payment4-note-result').text(payment4_note)
                $('.payment4').find('.payment4-amount-result').text(payment4_amount)
                $('.all-payment4').val(payment4_amount)
                $('.all-note4').val(payment4_note)

                jQuery.noConflict();
                $('.modal-div').modal("hide")

            });
            $(".payment5-save-btn").click(function(){
                var payment5_note = $('.payment5-note').val();
                var payment5_amount = $('.payment5-amount').val();

                var payment5 = $('.payment5').find('.payment5-note-result').text(payment5_note)
                $('.payment5').find('.payment5-amount-result').text(payment5_amount)
                $('.all-payment5').val(payment5_amount)
                $('.all-note5').val(payment5_note)

                jQuery.noConflict();
                $('.modal-div').modal("hide")

            });

            $(".collected-amount-save-btn").click(function(){
                var collected_amount_note_result = $('.total-collected-amount-note').val();

                var colected_cash_note = $('.total-cash-collected').find('.total-amount-collected-note-result').text(collected_amount_note_result)
                $('.all-total-cash-collected-note').val(collected_amount_note_result)
                jQuery.noConflict();
                $('.modal-div').modal("hide")

            });

            $("#filter-form").submit(function () {
                $("button .loader-span").find(".loader").css('display', 'block')
            });

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

            var comision = $('.comision-result').text();
            $('.all-comision').val(comision);
            var cash_sale = $('.cash-sale').text();
            var total_cash_remaining = (cash_sale - comision).toFixed(2)

            $('.total-cash-remaining').text(total_cash_remaining);
            $('.total-amount-collected').text(total_cash_remaining);

            $('input.comision').on('input',function(e){
                var net_sale = $('.net_sale').val();
                var comision = (($(this).val() / 100) * net_sale).toFixed(2) ;
                $('.all-comision').val(comision);
                var comision_result = $('.comision-result').text(comision)
                var total_cash_remaining = (cash_sale - comision).toFixed(2)
                $('.all-total-cash-remaining').val(total_cash_remaining)
                $('.all-total-cash-collected').val(total_cash_remaining)
                $('.total-cash-remaining').text(total_cash_remaining);
                $('.total-amount-collected').text(total_cash_remaining);
            });

            // $(".loader-span").find(".spinner-border").css('display', 'none')
            $(".hidecol").click(function(){

                var id = this.id;
                var splitid = id.split("_");
                var colno = splitid[1];
                var checked = true;

                // Checking Checkbox state
                if($(this).is(":checked")){
                    checked = true;
                }else{
                    checked = false;
                }
                setTimeout(function(){
                    if(checked){
                        $('#datatabled td:nth-child('+colno+')').hide();
                        $('#datatabled th:nth-child('+colno+')').hide();
                    } else{
                        $('#datatabled td:nth-child('+colno+')').show();
                        $('#datatabled th:nth-child('+colno+')').show();
                    }

                }, 100);

            });
            $(".display-all-columns").click(function(){
                $('#datatabled td,th').show();
                $('#datatabled th input').prop("checked", false);
            });

            $('#datatabled').DataTable( {
                "order": [[ 3, "desc" ]]
            } );
        });

    </script>
@endsection
