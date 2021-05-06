<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Lineitem;
use App\Order;
use App\Product;
use App\Report;
use App\Reportitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;


class AdminController extends Controller
{
    public function dashboard(Request $request){

//        $collection = Collection::where('shopify_collection_id', 261771460791)->first();
////        dd($collection->products);
//        foreach($collection->products as $prod){
//            dd($prod->lineitem->order);
//        }

//        $order = Lineitem::where('shopify_lineitem_id', 9632423477431)->first();
////        dd($order);
//        dd($order->order);
        $datefilter='';
        if($request->query('datefilter')) {
            $datefilter = $request->query('datefilter');
            $dates_array = explode('- ', $datefilter);

            $start_date = date('Y-m-d h:i:s', strtotime($dates_array[0]));
            $end_date = date('Y-m-d h:i:s', strtotime($dates_array[1]));
            $all_orders = \App\Order::where('shopify_shop_id', \Illuminate\Support\Facades\Auth::user()->id)->whereBetween('created_at', [$start_date, $end_date])->get();
            $collection_data = Collection::where('shopify_shop_id', Auth::user()->id)->orderBy('created_at', 'desc')->whereBetween('created_at', [$start_date, $end_date])->paginate(12);
        }else{
            $all_orders = \App\Order::where('shopify_shop_id', \Illuminate\Support\Facades\Auth::user()->id)->get();
            $collection_data = Collection::where('shopify_shop_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(12);
        }

        return view('adminpanel/dashboard', compact('collection_data', 'all_orders', 'datefilter'));


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
        $report_data = Report::where('shopify_shop_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(12);
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
}
