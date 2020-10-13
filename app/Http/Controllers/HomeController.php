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

        $stock = array();
        
        if($trigger) {    
            $trigger_from = $request->input('trigger_from');
            $uuid = $request->input('uuid');
            if($trigger_from == "barang_masuk") {
                $stock = Stock::where("uuid_barang_masuk",$uuid)->get();
            } else if ($trigger_from == "barang_keluar"){
                $stock = Stock::where("uuid_barang_keluar",$uuid)->get();
            }

        } else {
            $stock = Stock::where("status",1)->get();
        }

        


        $data = ["stock" => $stock];
        return view('home', ['data' => $data]);
    }
}
