@extends('adminpanel.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <div class="row ">
            <div class="col-md-12 col-lg-12 ">
                <div class="card">
                    <form action="{{route('columns-save')}}" method="post">
                        @csrf
                        <div class="card-header d-flex justify-content-between align-items-center bg-white pb-1">
                            <h5>Table Column</h5>
                            <div class="form-group">
                                <input type="submit" class="btn btn-lg btn-primary" value="Save">
                            </div>
                        </div>
                        <div class="card-body">
                            {{--                        @dd($user_shop_data)--}}
                            {{--                        {{route('user-country-save')}}--}}
                            {{--                            @dd($countries_shop_pref)--}}
                            <input hidden type="number" name="user_id" value="{{auth()->user()->id}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="card ">
                                            <div class="card-header bg-primary text-white">
                                                <h5>Table Columns Hide/Show</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Begin Stock</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->begin_stock) && $column_data->begin_stock == 'show') checked @endif value="show"  name="begin_stock" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Units In</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->units_in) && $column_data->units_in == 'show') checked @endif value="show"  name="units_in" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Units Out</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->units_out) && $column_data->units_out == 'show') checked @endif value="show"  name="units_out" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Units Sales</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->units_sales) && $column_data->units_sales == 'show') checked @endif value="show"  name="units_sales" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Cash Sales</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->cashsales) && $column_data->cashsales == 'show') checked @endif value="show"  name="cashsales" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Credit Card Sales</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->credit_card_sales) && $column_data->credit_card_sales == 'show') checked @endif value="show"  name="credit_card_sales" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Bank Transfer Sales</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->bank_transfer_sales) && $column_data->bank_transfer_sales == 'show') checked @endif value="show"  name="bank_transfer_sales" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Gross Sales</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->gross_sales) && $column_data->gross_sales == 'show') checked @endif value="show"  name="gross_sales" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Total Discounts</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->total_discounts) && $column_data->total_discounts == 'show') checked @endif value="show"  name="total_discounts" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Shipping Sales</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->shipping_sales) && $column_data->shipping_sales == 'show') checked @endif value="show"  name="shipping_sales" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Net Sales</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->net_sales) && $column_data->net_sales == 'show') checked @endif value="show"  name="net_sales" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>Total Sales</div>
                                                        <label class="switch">
                                                            <input @if(isset($column_data->total_sales) && $column_data->total_sales == 'show') checked @endif value="show"  name="total_sales" type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>


                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js_after')

    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
