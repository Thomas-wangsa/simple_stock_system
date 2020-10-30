<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Category;
use App\Models;
use App\Merk;
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

                $stock = Stock::leftJoin('category','category.id','=','stock.category_id')
                        ->leftJoin('merk','merk.id','=','stock.merk_id')
                        ->leftJoin('models','models.id','=','stock.models_id')
                        ->leftJoin('users as uc','uc.id','=','stock.created_by')
                        ->leftJoin('users as up','up.id','=','stock.created_by')
                        ->where("uuid_barang_masuk",$uuid)
                        ->select(
                            'stock.*',
                            'uc.name AS created_by_name',
                            'up.name AS updated_by_name',
                            'category.name AS category_name',
                            'merk.name AS merk_name',
                            'models.name AS models_name')
                        ->get();
            } else if ($trigger_from == "barang_keluar"){
                $stock = Stock::leftJoin('category','category.id','=','stock.category_id')
                        ->leftJoin('merk','merk.id','=','stock.merk_id')
                        ->leftJoin('models','models.id','=','stock.models_id')
                        ->leftJoin('users as uc','uc.id','=','stock.created_by')
                        ->leftJoin('users as up','up.id','=','stock.created_by')
                        ->where("uuid_barang_keluar",$uuid)
                        ->select(
                            'stock.*',
                            'uc.name AS created_by_name',
                            'up.name AS updated_by_name',
                            'category.name AS category_name',
                            'merk.name AS merk_name',
                            'models.name AS models_name')
                        ->get();
            }

        } else if($search == "on") {
            $abstract_stock = new Stock;


            $abstract_stock = $abstract_stock->leftJoin('category','category.id','=','stock.category_id')
            ->leftJoin('merk','merk.id','=','stock.merk_id')
            ->leftJoin('models','models.id','=','stock.models_id')
            ->leftJoin('users as uc','uc.id','=','stock.created_by')
            ->leftJoin('users as up','up.id','=','stock.created_by');


            $clean_select_barcode = trim($request->input('select_barcode'),' ');

            if ($request->input('select_barcode')) {
                $abstract_stock = $abstract_stock->where("barcode",'like',$clean_select_barcode);
            }

            if ($request->input('select_category')) {
                $abstract_stock = $abstract_stock->where("stock.category_id",$request->input('select_category'));
            }


           if ($request->input('select_merk')) {
                $abstract_stock = $abstract_stock->where("stock.merk_id",$request->input('select_merk'));
            }

            if ($request->input('select_model')) {
                $abstract_stock = $abstract_stock->where("stock.models_id",$request->input('select_model'));
            }


            if ($request->input('select_penjual')) {
                $abstract_stock = $abstract_stock->where("penjual",'like',trim($request->input('select_penjual')));
            }


            if ($request->input('date_from_penjual')) {
                $abstract_stock = $abstract_stock->whereDate("tgl_pembelian",'>=',$request->input('date_from_penjual'));
            }

            if ($request->input('date_to_penjual')) {
                $abstract_stock = $abstract_stock->whereDate("tgl_pembelian",'<=',$request->input('date_to_penjual'));
            }


            if ($request->input('select_pembeli')) {
                $abstract_stock = $abstract_stock->where("pembeli",'like',trim($request->input('select_pembeli')));
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

            $stock = $abstract_stock
            ->select(
                'stock.*',
                'uc.name AS created_by_name',
                'up.name AS updated_by_name',
                'category.name AS category_name',
                'merk.name AS merk_name',
                'models.name AS models_name')
            ->get();

        } else {
            $stock = Stock::leftJoin('category','category.id','=','stock.category_id')
            ->leftJoin('merk','merk.id','=','stock.merk_id')
            ->leftJoin('models','models.id','=','stock.models_id')
            ->leftJoin('users as uc','uc.id','=','stock.created_by')
            ->leftJoin('users as up','up.id','=','stock.created_by')
            ->where("status",1)
            ->select(
                'stock.*',
                'uc.name AS created_by_name',
                'up.name AS updated_by_name',
                'category.name AS category_name',
                'merk.name AS merk_name',
                'models.name AS models_name')
            ->get();
        }

        


        $data = [
            "stock" => $stock,
            'category' => Category::all(),
            "merk" => Merk::all(),
            "models" => Models::all()
        ];
        return view('home', ['data' => $data]);
    }
}
