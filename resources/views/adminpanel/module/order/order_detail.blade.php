@extends('adminpanel.admin-module.layout.default')
@section('content')
{{--@dd($package_data)--}}
    <div class="container" >
{{--        @dd(json_decode($order_data))--}}
        <div style="width: 100%">
            <div class="row pt-4 mx-1">
                <div class="col-md-12 card card-border-radius pt-4 pb-1">
                    <div class="d-flex custom-top-div align-items-center">
{{--                        @dd($order_data->fulfillment_status)--}}
                        <div class="custom-left-arrow-div " ><a style="text-decoration: none; color: black;" href="{{route('orders')}}"><i class="fas fa-arrow-left custom-left-arrow-icon" ></i></a></div>
                        <div><h4>{{$order_data->shopify_order_name}}</h4></div>
                        @if($order_data->financial_status == "paid")
                            <div><span class="badge badge-pill badge-success py-2 px-4">Paid</span></div>
                        @elseif($order_data->financial_status == 'partially paid')
                            <div><span class="badge badge-pill badge-primary py-2 px-4">Partially Paid</span></div>
                        @elseif($order_data->financial_status == 'pending')
                            <div><span class="badge badge-pill badge-warning py-2 px-4">Pending</span></div>
                        @elseif($order_data->financial_status == 'authorized')
                            <div><span class="badge badge-pill badge-info py-2 px-4">Authorized</span></div>
                        @else
                            <div><span class="badge badge-pill badge-info py-2 px-4">{{$order_data->financial_status}}</span></div>
                        @endif

                        @if($order_data->fulfillment_status == null)
                            <div><span class="badge badge-pill badge-danger py-2 px-4">Unfulfilled</span></div>
                        @else
                            <div><span class="badge badge-pill badge-warning py-2 px-4">{{$order_data->fulfillment_status}}</span></div>
                        @endif

                        </div>
                    <div class="ml-5 pl-3">
                        <div><p>{{ \Carbon\Carbon::parse($order_data->created_at)->format('F d, Y ')}} at {{ \Carbon\Carbon::parse($order_data->created_at)->format('g:i A')}}  from Online Store</p></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-md-8 col-sm-12">
{{--                    First Left Card--}}
                    <div class="card card-border-radius mt-3">
                        <div class="card-body">
                            @if($order_data->fulfillment_status == null)
                                <div><h5>Unfulfilled</h5></div>
                            @else
                                <div><h5 class="card-title">{{$order_data->fulfillment_status}}</h5></div>
                            @endif

{{--                                                            @dd(json_decode($order_data->line_items) )--}}
                            @foreach(json_decode($order_data->line_items) as $key=>$line_item)
{{--                                @dd($line_item)--}}
                                <div class="custom align-items-center" style="">
                                    <div class="mr-3 custom-div-child1">
{{--                                        @dd($line_item->image)--}}
                                        @if(isset($line_item->image))
                                            <img src="{{$line_item->image}}" width="50px" hight="50px" alt="product-image">
                                        @else
                                            <img src="{{asset('assets\images\random_product.jpg')}}" width="50px" hight="50px" alt="product-image">
                                        @endif

                                    </div>
                                    <div style="position: relative;" class="mr-3 custom-div-child2">
                                        <p>{{$line_item->title}}</p>
                                    </div>
                                    <div class="mx-2 custom-div-child3">
                                        <p>${{$line_item->price}} × {{$line_item->quantity}}</p>
                                    </div>
                                    <div class="ml-3 custom-div-child4">
                                        <p>${{$line_item->price * $line_item->quantity}}</p>
                                    </div>
                                </div>
                                <div id="order_append">
{{--                                    @dd($order_product_package)--}}
                                    @if($order_product_package !== null && $product_id_data !==null)
                                    <div style="width: 80%;margin-left:auto;margin-right:auto; margin-top: -15px;" class="row">
                                        <div class="px-2" style="width: 50%;">
                                            <div >
{{--                                                @dd($line_item->product_id)--}}
{{--@dd()--}}

                                                    @if(isset($order_product_package[$line_item->product_id]) && $order_product_package[$line_item->product_id] !== null)
                                                    <label style="display: inline-block" for="package">Package:</label>
                                                    <p style="display: inline-block" id="package" class="package-data-show">{{$order_product_package[$line_item->product_id]->title}}</p>
                                                    @endif
{{--                                                @endforeach--}}
                                            </div>
                                        </div>
                                        <div class="px-2" style="width: 50%;">
                                            <div >
                                                @if(isset($order_product_mailbox[$line_item->product_id]) && $order_product_mailbox[$line_item->product_id] !== null)
                                                    <label style="display: inline-block" for="package">Mailbox:</label>
                                                    <p style="display: inline-block" id="mailbox" class="mailbox-data-show">{{$order_product_mailbox[$line_item->product_id]->title}}</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                        <div style="width: 80%;margin-left:auto;margin-right:auto;" class="row">
                                            <button style=" margin-left: 10px;" data-toggle="collapse" class="btn  btn-sm btn-primary" data-target="#myform{{$key}}" type="button">Change</button>
                                        </div>
                                        <div id="myform{{$key}}" class="collapse change-select mt-3">

                                            <form id="ChangeForm" class="ChangeForm" action="{{Route('change_package_mailbox')}}" method="post" onsubmit="ChangeFunction(this)">
                                                @csrf
                                                <?php
                                                    $product_id = \App\Product::where('shopify_product_id', $line_item->product_id)->first();
//                                                    dd($product_id->shopify_product_id);
                                                ?>

{{--                                                @dd($product_id->shopify_product_id)--}}
                                                    <input value="{{$product_id->shopify_product_id}}" hidden name="shopify_product_id">
                                                <div style="width: 80%;margin-right: auto;margin-left: auto;" class="row">
                                                    <div style="width:50%; " class="pr-2">
{{--                                                        @dd($order_product_package, $product_id->shopify_product_id)--}}
                                                        <select class="browser-default custom-select package-select" name="package_select">
                                                            <option  value="" selected>Select Package</option>

                                                            @foreach($package_data as $package)
{{--                                                                @dd($packagee)--}}
                                                                <option class="package-title" value="{{$package->id}}"
                                                                    @if(isset($order_product_package[$product_id->shopify_product_id]) && $order_product_package[$product_id->shopify_product_id] !== null && $order_product_package[$product_id->shopify_product_id]->id == $package->id) selected @endif >
                                                                    {{$package->title}}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div style="width:50%; " class="pl-2">
                                                        <select  class="browser-default  custom-select mailbox-select" name="mailbox_select">
                                                            <option  value="" selected>Select Mailbox</option>
                                                            @foreach($mailbox_data as $mailbox)
                                                                <option class="mailbox-title" value="{{$mailbox->id}}"
                                                                        @if(isset($order_product_mailbox[$product_id->shopify_product_id]) && $order_product_mailbox[$product_id->shopify_product_id] !== null && $order_product_mailbox[$product_id->shopify_product_id]->id == $mailbox->id) selected @endif >
                                                                    {{$mailbox->title}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button class="btn mt-2  btn-sm btn-primary " type="submit" id="SaveChange">Save Package</button>
                                                </div>

                                            </form>
{{--                                            @endforeach--}}
                                        </div>
                                    @else
                                        <div style="width: 80%;margin-left:auto;margin-right:auto; margin-top: -15px;" class="row">
                                            <p class="ml-2">No product found</p>
                                        </div>
                                    @endif
                                </div>
{{--                                    {{$order_product_package}}--}}
                                <div>
{{--                                    @dd($line_item->product_id)--}}
                                    <?php
                                        $product_id = $line_item->product_id;
                                        $product_data = App\Product::where('shopify_product_id', $product_id)->get();
                                    ?>
{{--                                    @dd($product_data)--}}
                                </div>
                                <?php
                                $total_items = 0;
                                foreach(json_decode($order_data->line_items) as $line_item)
                                {
                                    $total_items = $line_item->quantity + $total_items;
                                }
                                ?>

{{--                                <hr>--}}
                            @endforeach
                        </div>
                    </div>
                    {{--                   End First Left Card--}}

                    {{--                    Secound Left Card--}}
                    <div class="card card-border-radius my-3">
                        <div class="card-body">
                            @if($order_data->financial_status == "paid")
                                <div><h5 class="card-title">Paid</h5></div>
                            @elseif($order_data->financial_status == 'partially paid')
                                <div><h5 class="card-title">Partially Paid</h5></div>
                            @elseif($order_data->financial_status == 'pending')
                                <div><h5 class="card-title">Pending</h5></div>
                            @elseif($order_data->financial_status == 'authorized')
                                    <div><h5 class="card-title">Authorized</h5></div>
                            @else
                                <div><h5 class="card-title">{{$order_data->financial_status}}</h5></div>
                            @endif

                            <div class="custom2" style="">
                                <div class="mr-3 card-child-div1">
                                    <p>Subtotal</p>
                                </div>
                                <div style="  " class="mr-3 card-child-div2">
                                    <p class="card-child-p" style="">{{$total_items}} item</p>
                                </div>
                                <div class="ml-3">
                                    <p>${{$order_data->total_line_items_price}}</p>
                                </div>
                            </div>
                            @if(json_decode($order_data->discount_codes) != null)
                                <div class="custom2" style="">
                                    <div class="mr-3 card-child-div1">
                                        <p>Discount</p>
                                    </div>
                                    <div style="  " class="mr-3 card-child-div2">
                                        <p class="card-child-p" style="">
                                            @foreach(json_decode($order_data->discount_codes) as $discount_code)
                                                {{$discount_code->code}}
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="ml-3">

                                        <p>${{$order_data->total_discounts}}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="custom2 " style="">
                                <div class="mr-3 card-child-div1">
                                    <p>Shipping</p>
                                </div>
                                <div class="mr-3 card-child-div2">
                                    <p class="card-child-p">
                                        @foreach(json_decode($order_data->shipping_lines) as $shipping_line)
                                            {{$shipping_line->title}} ({{$order_data->total_weight}})
                                        @endforeach
                                    </p>
                                </div>
                                <div class="ml-3 ">
                                    <p>
                                        @foreach(json_decode($order_data->shipping_lines) as $shipping_line)
                                            ${{$shipping_line->price}}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                            @if(json_decode($order_data->total_tax) != null)
                                <div class="custom2" style="">
                                    <div class="mr-3 card-child-div1">
                                        <p>Tax</p>
                                    </div>
                                    <div class="mr-3 card-child-div2">
                                        <p class="card-child-p">
                                            @foreach(json_decode($order_data->tax_lines) as $tax_line)
                                                {{$tax_line->title}} {{$tax_line->rate*100}}%
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="ml-3">
                                        <p>
                                            @foreach(json_decode($order_data->tax_lines) as $tax_line)
                                                ${{$tax_line->price}}
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                            @endif
                            <div class="custom2" style="">
                                <div class="mr-3 card-child-div1">
                                    <h6>Total</h6>
                                </div>

                                <div class="ml-3 card-child-div2" style=" text-align: end;">
                                    <h6>${{json_decode($order_data->total_price)}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white card2-footer-radius">
                            <div class="card2-footer-button" >

                                <div style="margin-left: -22px;"><p>Paid by customer</p></div>
                                <div style="margin-right: -22px;"><p>${{json_decode($order_data->total_price)}}</p></div>

                            </div>
                        </div>
                    </div>

                    {{--                    End Secound Left Card--}}
                </section>

                <section class="col-md-4 col-sm-12">
{{--                    First Right Card--}}
                    <div class="card card-border-radius mt-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Note</h5>
                                </div>
                                <div>

                                </div>
                            </div>
                            @if(isset($order_data->note)  && $order_data->note !== null)
                                <p class="card-text">{{$order_data->note}}</p>
                            @else
                                <p class="card-text">No notes from customer</p>
                            @endif
                        </div>
                    </div>

                    {{--                    End First Right Card--}}

                    {{--                    Secound Right Card--}}
                    <div class="card card-border-radius my-3">
                        <div class="card-custom-body">
                            <div class="">
                                <div>
                                    <h6 class="card-title">Customer</h6>
                                </div>
                                <div>
                                    <?php $customer=json_decode($order_data->customer);?>

                                    @if(isset($customer->first_name)) {{$customer->first_name}} {{$customer->last_name}} @endif

                                </div>
                                <div>
                                    <p class="card-text">@if(isset($customer->orders_count)) {{$customer->orders_count}} order @endif</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-custom-body2">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">CONTACT INFORMATION</h6>
                                </div>
                                <div>

                                </div>
                            </div>
                            <div class="d-flex justify-content-between">

                                <div>
                                    @if(isset($customer->email))
                                        <p  class="card-title">{{$customer->email}}</p>
                                    @endif
                                </div>
                                <div>

                                </div>
                            </div>
                            <div class="">
                                <div>
                                    @if(isset($customer->phone))
                                        {{$customer->phone}}
                                    @else
                                        <p class="card-title">No phone number</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="card-custom-body2">
                            <div class="d-flex justify-content-between">
                                {{--                            @dd(json_decode($order_data->shipping_address))--}}
                                <div>
                                    <h6 class="card-title">SHIPPING ADDRESS</h6>
                                </div>
                                <div>

                                </div>
                            </div>
                            <?php
                                $shipping_address = json_decode($order_data->shipping_address);
                            ?>
                            <div class="d-flex justify-content-between">
                                <div style="width: 60%;">
                                    <p  class="card-title">@if(isset($shipping_address->first_name)){{$shipping_address->first_name}}@endif @if(isset($shipping_address->last_name)){{$shipping_address->last_name}}@endif<br>
                                        @if(isset($shipping_address->zip)){{$shipping_address->zip}}@endif<br>
                                        @if(isset($shipping_address->province)){{$shipping_address->province}}@endif @if(isset($shipping_address->city)){{$shipping_address->city}}@endif @if(isset($shipping_address->address1)){{$shipping_address->address1}}@endif
                                        <br>
                                        @if(isset($shipping_address->address2)){{$shipping_address->address2}}@endif
                                        <br>
                                        @if(isset($shipping_address->country)){{$shipping_address->country}}@endif
                                    </p>
                                </div>
                                <div>

                                </div>
                            </div>
                            <div class="">
                                <div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-custom-body2">
                            <div class="d-flex justify-content-between">
                                <?php
                                    $billing_address = json_decode($order_data->billing_address);
                                ?>
                                <div>
                                    <h6 class="card-title">BILLING ADDRESS</h6>
                                </div>
                            </div>
                            @if(isset($billing_address))
                                <p  class="card-title">
                                    @if(isset($billing_address->first_name)){{$billing_address->first_name}}@endif @if(isset($billing_address->last_name)){{$billing_address->last_name}}@endif <br>
                                    @if(isset($billing_address->zip)){{$billing_address->zip}}@endif<br>
                                    @if(isset($billing_address->province)){{$billing_address->province}}@endif @if(isset($billing_address->city)){{$billing_address->city}}@endif<br> @if(isset($billing_address->address1)){{$billing_address->address1}}@endif
                                    <br>
                                    @if(isset($billing_address->address2)){{$billing_address->address2}}@endif
                                    <br>
                                    @if(isset($billing_address->country)){{$billing_address->country}}@endif
                                </p>
                            @endif
                        </div>
                    </div>

                    {{--                    End Secound Right Card--}}
                </section>
            </div>
        </div>
    </div>
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
    <script>


    </script>
@endsection




