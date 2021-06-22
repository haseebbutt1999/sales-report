<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Lineitem;
use App\Location;
use App\Order;
use App\Product;
use App\Report;
use App\Reportitem;
use App\Tablecolumns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;


class AdminController extends Controller
{
    public function dashboard(Request $request){

//        $location_name = [];
        $start_date = '';
        $end_date = '';
        $location_select = '';
        $location_id = [];
//        $orders = Order::where('shopify_shop_id', auth::user()->id)->get();
//        if(count($orders)){
//            foreach ($orders as $order){
//                foreach ($order->lineitems as $lineitem){
//                    if(isset($lineitem->origin_location)){
////                        $locations += [ $lineitem->origin_location->origin_location_id => $lineitem->origin_location->name ];
//                        array_push($location_name,$lineitem->origin_location->name);
//                        array_push($location_id,$lineitem->origin_location->origin_location_id);
//                    }
//                }
//            }
//        }
//        $location_name = array_values(array_unique($location_name));
        $location_id = array_values(array_unique($location_id));
        $datefilter='';
        $location_name = Location::where('shopify_shop_id', Auth::user()->id)->get();

        $all_orders = \App\Order::where('shopify_shop_id', \Illuminate\Support\Facades\Auth::user()->id);
        $collection_data = Collection::where('shopify_shop_id', Auth::user()->id);
//        dd($collection_data);
        if($request->query('datefilter')) {
            $datefilter = $request->query('datefilter');
            $dates_array = explode('- ', $datefilter);

            $start_date = date('Y-m-d h:i:s', strtotime($dates_array[0]));
            $end_date = date('Y-m-d h:i:s', strtotime($dates_array[1]));

            $all_orders->whereBetween('created_at', [$start_date, $end_date]);

//            $collection_data->whereBetween('created_at', [$start_date, $end_date]);
        }elseif($request->query('location')){
            $location_select = $request->query('location');
            if($location_select != 'select_option'){
//                $all_orders->whereHas('lineitems', function($query) use ($location_select){
//                    $query->where('origin_location_id', $location_select);
//                });
                $all_orders->where('location_id',$location_select);
            }
        }

        $all_orders = $all_orders->get();
        $currency='';
        if(isset($all_orders[0]->currency)){
            $currency = $all_orders[0]->currency;
        }
        $collection_data = $collection_data->orderBy('updated_at', 'desc')->get();
//        dd($collection_data);
        $column_data = Tablecolumns::where('shopify_shop_id',Auth::user()->id)->first();

        return view('adminpanel/dashboard', compact('column_data','start_date','end_date','currency','location_name','location_id', 'collection_data', 'all_orders', 'datefilter','location_select'));


    }

    public function save_report(Request $request){
//        dd($request->all());
        //all_credit all_dis all_cash all_bank all_gross all_shipp all_totalSale
        $report_save = new Report();

        $report_save->all_credit = $request->all_credit;
        if($request->date != null){
            $report_save->date = $request->date;
        }else{
            $report_save->date = date("Y-m-d");
        }

        $report_save->all_dis = $request->all_dis;
        $report_save->all_cash = $request->all_cash;
        $report_save->all_bank = $request->all_bank;
        $report_save->all_gross = $request->all_gross;
        $report_save->all_shipp = $request->all_shipp;
        $report_save->all_net = $request->all_net;
        $report_save->all_totalSale = $request->all_totalSale;
        $report_save->report_name = $request->report_name;
        $report_save->shopify_shop_id = Auth::user()->id;
        $report_save->comision = $request->comision;
        $report_save->payment1 = $request->payment1;
        $report_save->payment2 = $request->payment2;
        $report_save->payment3 = $request->payment3;
        $report_save->payment4 = $request->payment4;
        $report_save->payment5 = $request->payment5;
        $report_save->total_cash_remaining = $request->total_cash_remaining;
        $report_save->total_cash_collected = $request->total_cash_collected;
        $report_save->note1 = $request->note1;
        $report_save->note2 = $request->note2;
        $report_save->note3 = $request->note3;
        $report_save->note4 = $request->note4;
        $report_save->note5 = $request->note5;
        $report_save->currency = $request->currency;
        $report_save->total_cash_collected_note = $request->total_cash_collected_note;

        if($report_save->save()){
            $count = count($request->collection_name);
            $val=0;
            for($val; $val<$count; $val++){
                $report_item = new Reportitem();
                $report_item->report_id = $report_save->id;
                $report_item->collection_name=$request->collection_name[$val];
                $report_item->begin_stock=$request->begin_stock[$val];
                $report_item->unitin=$request->unitin[$val];
                $report_item->unitout=$request->unitout[$val];
                $report_item->unitsale=$request->unitsale[$val];
                $report_item->credit_card_sale=$request->credit_card_sale[$val];
                $report_item->cashsale=$request->cashsale[$val];
                $report_item->bank_sale=$request->bank_sale[$val];
                $report_item->gross_sale=$request->gross_sale[$val];
                $report_item->net_sale=$request->net_sale[$val];
                $report_item->shipping_sale=$request->shipping_sale[$val];
                $report_item->total_discount=$request->total_discount[$val];
                $report_item->total_sale=$request->total_sale[$val];
                $report_item->save();
            }
        }
        return redirect()->back()->with('success', 'Successfully Save Report!!');
    }

    public function reports_index(){
        $report_data = Report::where('shopify_shop_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('adminpanel/reports', compact('report_data'));
    }
    public function report_detail($id){
        $report_data = Report::find($id);
        $report_item_data = $report_data->report_items;
        return view('adminpanel/report_detail', compact('report_data','report_item_data'));
    }

    public function report_delete($id){
        $report_data = Report::find($id);
        if($report_data != null){
            Reportitem::where('report_id', $id)->delete();
            $report_data->delete();
        }
        return redirect()->back()->with('success', 'Successfully Delete Report');

    }

    public  function settings(){
        $column_data = Tablecolumns::where('shopify_shop_id',Auth::user()->id)->first();
        return view('adminpanel/settings', compact('column_data'));
    }

    public function columns_save(Request $request){
        $table_column = Tablecolumns::where('shopify_shop_id',Auth::user()->id)->first();
        if($table_column == null){
            $table_column =  new Tablecolumns();
        }
        $table_column->shopify_shop_id = Auth::user()->id;
        $table_column->begin_stock= $request->begin_stock;
        $table_column->units_in= $request->units_in;
        $table_column->units_out= $request->units_out;
        $table_column->units_sales= $request->units_sales;
        $table_column->credit_card_sales= $request->credit_card_sales;
        $table_column->cashsales= $request->cashsales;
        $table_column->bank_transfer_sales= $request->bank_transfer_sales;
        $table_column->gross_sales= $request->gross_sales;
        $table_column->total_discounts= $request->total_discounts;
        $table_column->net_sales= $request->net_sales;
        $table_column->shipping_sales= $request->shipping_sales;
        $table_column->total_sales= $request->total_sales;
        $table_column->save();
        return redirect()->back()->with('success','Successfuly save table columns.');
    }
}
