<h1>ok</h1>
@php

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
@endphp
