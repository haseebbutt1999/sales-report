@extends('adminpanel.layout.default')
@section('content')
{{--    @dd($report_item_data)--}}
    <div class="col-lg-12 col-md-12 p-4">
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
                                    <div class="d-flex pt-2 bg-primary px-3 " style="margin-top: -8px; border-radius: 10px;color: white">
                                        <label class="mr-2"><b>Date:</b></label>
                                        <p><b>{{$report_data->date}}</b></p>
                                    </div>
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

                                    @if($report_data != null && count($report_item_data))
                                        @foreach($report_item_data as $key=>$report_item)
                                            <tr class="td-text-center report-row-{{$key}}">
                                                <td scope="row">
                                                    {{$report_item->collection_name}}

                                                </td>

                                                <td class="stock-{{$key}}">
                                                    {{$report_item->begin_stock}}
                                                </td>
                                                <td class="unitin-{{$key}}">
                                                    {{$report_item->unitin}}
                                                </td>
                                                <td class="unitout-{{$key}}">
                                                    {{$report_item->unitout}}
                                                </td>

                                                <td class="unitsale-{{$key}}">
                                                    {{$report_item->unitsale}}
                                                </td>
                                                <td  class="credit-card-sale-{{$key}}">
                                                    {{$report_item->credit_card_sale}}
                                                </td>
                                                <td class="cash-sale-{{$key}}">
                                                    {{$report_item->cashsale}}
                                                </td>
                                                <td class="bank-sale-{{$key}}">

                                                    {{$report_item->bank_sale}}
                                                </td>
                                                <td class="">

                                                </td>
                                                <td class="gross-sale-{{$key}}">
                                                    {{$report_item->gross_sale}}

                                                </td>
                                                <td class="total-discount-{{$key}}">
                                                    {{$report_item->total_discount}}
                                                </td>
                                                <td class="net-sale-{{$key}}">
                                                    {{$report_item->net_sale}}
                                                </td>

                                                <td class="total-shipping-{{$key}}">
                                                    {{$report_item->shipping_sale}}
                                                </td>

                                                <td class="total-sale-{{$key}}">
                                                    {{$report_item->total_sale}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td><b>Total</b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>{{$report_data->all_credit}}</b></td>
                                            <td><b>{{$report_data->all_cash}}</b></td>
                                            <td><b>{{$report_data->all_bank}}</b></td>
                                            <td><b></b></td>
                                            <td><b>{{$report_data->all_gross}}</b></td>
                                            <td><b>{{$report_data->all_dis}}</b></td>
                                            <td><b>{{$report_data->all_net}}</b></td>
                                            <td><b>{{$report_data->all_shipp}}</b></td>
                                            <td><b>{{$report_data->all_totalSale}}</b></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
