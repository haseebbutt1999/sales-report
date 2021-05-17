@extends('adminpanel.layout.default')
@section('content')
{{--    @dd($report_item_data)--}}
    <div class="col-lg-12 col-md-12 p-4">
        <div class="d-flex  pb-2 justify-content-end" id="print-button-main">
            <button class="btn btn-primary print-report"><i class=" fa fa-print text-white" style="font-size: 20px;margin-right: 10px;cursor: pointer;" aria-hidden="true"></i>Print</button>
        </div>
        <div class="printableArea">
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
{{--                                        <th class="font-weight-bold " >Customizable Other Sales</th>--}}
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
{{--                                                <td class="">--}}

{{--                                                </td>--}}
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
{{--                                            <td><b></b></td>--}}
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
                                            <td class="total-sale">{{$report_data->all_totalSale}}</td>
                                        </tr>
                                        <tr class="td-text-center ">
                                            <td>CASH SALE:</td>
                                            <td class="cash-sale">{{$report_data->all_credit}}</td>
                                        </tr>
                                        <tr class="td-text-center ">
                                            <td>COMISION %:</td>
                                            <td class="d-flex justify-content-between">
                                                <div class="w-50"><span class="comision-result">{{$report_data->comision}}</span></div>
                                            </td>
                                        </tr>
                                        <tr class="td-text-center ">
                                            <td style="width: 20%;">Payment 1</td>
                                            <td style="width: 80%;" class="d-flex w-100 justify-content-between payment1">
                                                <div style="width: 15%;">
                                                    <span class="payment1-amount-result" >{{$report_data->payment1}}</span>
                                                </div>
                                                <div style="width: 70%;">
                                                    <span><strong>Note:</strong></span>
                                                    <span class="payment1-note-result" >{{$report_data->note1}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="td-text-center ">
                                            <td>Payment 2</td>
                                            <td class="d-flex w-100 justify-content-between payment2">
                                                <div style="width: 15%;">
                                                    <span class="payment2-amount-result" >{{$report_data->payment2}}</span>
                                                </div>
                                                <div style="width: 70%;">
                                                    <span><strong>Note:</strong></span>
                                                    <span class="payment2-note-result" >{{$report_data->note2}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="td-text-center ">
                                            <td>Payment 3</td>
                                            <td class="d-flex w-100 justify-content-between payment3">
                                                <div style="width: 15%;">
                                                    <span class="payment3-amount-result" >{{$report_data->payment3}}</span>
                                                </div>
                                                <div style="width: 70%;">
                                                    <span><strong>Note:</strong></span>
                                                    <span class="payment3-note-result" >{{$report_data->note3}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="td-text-center ">
                                            <td>Payment 4</td>
                                            <td class="d-flex w-100 justify-content-between payment4">
                                                <div style="width: 15%;">
                                                    <span class="payment4-amount-result" >{{$report_data->payment4}}</span>
                                                </div>
                                                <div style="width: 70%;">
                                                    <span><strong>Note:</strong></span>
                                                    <span class="payment4-note-result" >{{$report_data->note4}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="td-text-center ">
                                            <td>Payment 5</td>
                                            <td class="d-flex w-100 justify-content-between payment5">
                                                <div style="width: 15%;">
                                                    <span class="payment5-amount-result" >{{$report_data->payment5}}</span>
                                                </div>
                                                <div style="width: 70%;">
                                                    <span><strong>Note:</strong></span>
                                                    <span class="payment5-note-result" >{{$report_data->note5}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="td-text-center ">
                                            <td>Total cash remaining $</td>
                                            <td class="total-cash-remaining">{{$report_data->all_credit - $report_data->comision - ($report_data->payment1 + $report_data->payment2 + $report_data->payment3 + $report_data->payment4 + $report_data->payment5)}}</td>
                                        </tr>
                                        <tr class="td-text-center ">
                                            <td>Total cash collected $</td>
                                            <td class="d-flex w-100 justify-content-between total-cash-collected">
                                                <div style="width: 15%;">
                                                    <span class="total-amount-collected" >{{$report_data->all_credit - $report_data->comision - ($report_data->payment1 + $report_data->payment2 + $report_data->payment3 + $report_data->payment4 + $report_data->payment5)}}</span>
                                                </div>
                                                <div style="width: 70%;">
                                                    <span><strong>Note:</strong></span>
                                                    <span class="total-amount-collected-note-result" >{{$report_data->total_cash_collected_note}}</span>
                                                </div>
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
        </div>
    </div>
@endsection
@section('js_after')
    {{--    datepicker js--}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{asset('assets/js/jquery.PrintArea.js')}}"></script>
    <script>

        $(document).ready(function() {
            $("button.print-report").click(function(){
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {mode: mode, popClose: close};
                $("div.printableArea").printArea(options);
            });
        });

    </script>
@endsection
