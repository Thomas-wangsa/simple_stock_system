<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
        $trigger = $request->input('trigger');
        $search = $request->input('search');

        $stock = array();
        
        if($trigger == "on") {    
            $trigger_from = $request->input('trigger_from');
            $uuid = $request->input('uuid');
            if($trigger_from == "barang_masuk") {
                $stock = Stock::where("uuid_barang_masuk",$uuid)->get();
            } else if ($trigger_from == "barang_keluar"){
                $stock = Stock::where("uuid_barang_keluar",$uuid)->get();
            }

        } else if($search == "on") {
            $abstract_stock = new Stock;

            if ($request->input('select_barcode')) {
                $abstract_stock = $abstract_stock->where("barcode",'like',$request->input('select_barcode'));
            }

            if ($request->input('select_category')) {
                $abstract_stock = $abstract_stock->where("kategori",$request->input('select_category'));
            }


           if ($request->input('select_merk')) {
                $abstract_stock = $abstract_stock->where("merk",$request->input('select_merk'));
            }

            if ($request->input('select_model')) {
                $abstract_stock = $abstract_stock->where("model",$request->input('select_model'));
            }


            if ($request->input('select_penjual')) {
                $abstract_stock = $abstract_stock->where("penjual",'like',$request->input('select_penjual'));
            }


            if ($request->input('date_from_penjual')) {
                $abstract_stock = $abstract_stock->whereDate("tgl_pembelian",'>=',$request->input('date_from_penjual'));
            }

            if ($request->input('date_to_penjual')) {
                $abstract_stock = $abstract_stock->whereDate("tgl_pembelian",'<=',$request->input('date_to_penjual'));
            }


            if ($request->input('select_pembeli')) {
                $abstract_stock = $abstract_stock->where("pembeli",'like',$request->input('select_pembeli'));
            }


            if ($request->input('date_from_pembeli')) {
                $abstract_stock = $abstract_stock->whereDate("tgl_penjualan",'>=',$request->input('date_from_pembeli'));
            }

            if ($request->input('date_to_pembeli')) {
                $abstract_stock = $abstract_stock->whereDate("tgl_penjualan",'<=',$request->input('date_to_pembeli'));
            }


            if ($request->input('select_status')) {
                $abstract_stock = $abstract_stock->where("status",$request->input('select_status'));
            } else {
                $abstract_stock = $abstract_stock->where("status",1);
            }


            if ($request->input('select_limit')) {
                $abstract_stock = $abstract_stock->limit($request->input('select_limit'));
            }


            if ($request->input('select_order')) {
                $abstract_stock = $abstract_stock->orderBy('id',$request->input('select_order'));
            }

            $stock = $abstract_stock->get();


        } else {
            $stock = Stock::where("status",1)->get();
        }

        


        $data = ["stock" => $stock];
        return view('home', ['data' => $data]);
    }
}
