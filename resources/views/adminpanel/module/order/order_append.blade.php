<div id="order_append">
{{--                                        @dd($order_product_package->title)--}}

    @if($order_product_package !== null )
        <div style="width: 80%;margin-left:auto;margin-right:auto; margin-top: -15px;" class="row">
            <div class="px-2" style="width: 50%;">
                <div >
                    {{--                                                @dd($line_item->product_id)--}}
                    {{--@dd()--}}

                    @if(isset($order_product_package->title) && $order_product_package->title !== null)
                        <label style="display: inline-block" for="package">Package:</label>
                        <p style="display: inline-block" id="package">{{$order_product_package->title}}</p>
                    @endif
                    {{--                                                @endforeach--}}
                </div>
            </div>
            <div class="px-2" style="width: 50%;">
                <div >
                    @if(isset($order_product_mailbox->title) && $order_product_mailbox->title !== null)
                        <label style="display: inline-block" for="mailbox">Mailbox:</label>
                        <p style="display: inline-block" id="mailbox">{{$order_product_mailbox->title}}</p>
                    @endif
                </div>
            </div>
        </div>
        <div style="width: 80%;margin-left:auto;margin-right:auto;" class="row">
            <button style=" margin-left: 10px;" data-toggle="collapse" class="btn  btn-sm btn-primary" data-target="#myform" type="button">Change</button>
        </div>
        <div id="myform{{$key}}" class="collapse change-select mt-3">

            <form id="ChangeForm" class="ChangeForm" action="{{Route('change_package_mailbox')}}" method="post" onsubmit="ChangeFunction(this)">

                <?php
                $product_id = \App\Product::where('shopify_product_id', $line_item->product_id)->first();
                //                                                    dd($product_id->shopify_product_id);
                ?>

                                                                @dd($product_id->shopify_product_id)
                <input value="{{$product_id->shopify_product_id}}" hidden name="shopify_product_id">
                <div style="width: 80%;margin-right: auto;margin-left: auto;" class="row">
                    <div style="width:50%; " class="pr-2">
                                                                                @dd($order_product_package, $product_id->shopify_product_id)
                        <select class="browser-default custom-select package-select" name="package_select">
                            <option  value="" selected>Select Package</option>

                            @foreach($package_data as $package)
                                                                                                @dd($packagee)
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

        </div>
    @else
        <div style="width: 80%;margin-left:auto;margin-right:auto; margin-top: -15px;" class="row">
            <p class="ml-2">No product found</p>
        </div>
    @endif
</div>
<script>

    function ChangeFunction(element) {
        var package_select = $('.package-select').val();
        var mailbox_select = $('.mailbox-select').val();
        console.log(package_select);
        if(!(package_select ) && !(mailbox_select)){
            alert("Note: Both Services Must Be Selected ")
            console.log(package_select)
        }else if(!(package_select )){
            alert("Note: Package Service Must Be Selected ")
        }else if(!(mailbox_select )){
            alert("Note: Mailbox Service Must Be Selected ")
        }
        else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post",
                url: $(element).attr('action'),
                data: $(element).serialize(),
                success: function (response) {
                    console.log(response);
                    $("#order_append").html(response);
                    $(".mailbox-select").val("");
                    $(".package-select").val("");
                },
                error: function (error) {
                    console.log(error);
                    // alert("Mailbox Not Saved");
                }
            });
        }
    }
    $(document).ready(function(){

        // $(".change-select").hide();
        // $(".change-toogle").click(function(){
        //     $(this).parent().next().toggle(400);
        // });


        // $(".ChangeForm").on('submit',function(event) {
        //     event.preventDefault()
        //     ChangeFunction(this);
        // });

    });
</script>
