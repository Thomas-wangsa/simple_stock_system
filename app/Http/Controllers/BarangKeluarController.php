<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\UserRule;

use App\BarangKeluar;
use App\Category;

use Illuminate\Http\Request;
use Exception;
use App\Stock;
use Faker\Factory as Faker;


class BarangKeluarController extends Controller
{   
    protected $redirectTo      = 'barangkeluar.index';
    protected $redirectToCreate      = 'barangkeluar.create';
    protected $selected_rule_id_7 = "7";
    protected $selected_rule_id_8 = "8";

    public function __construct(){
        $this->faker    = Faker::create();
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Auth::user()->role != 2) {
            $user_rule = UserRule::where('user_id',Auth::user()->id)
                        ->where("rule_id",$this->selected_rule_id_7)
                        ->first();
            $messages = "tidak ada akses ke menu barang keluar!";
            if($user_rule == null || $user_rule->status == 0) {
                $request->session()->flash('alert-danger', $messages);
                return redirect()->route('home');
            }
        }
        $data = [
            "barangkeluar" => BarangKeluar::orderBy('created_at', 'desc')->paginate(20),
        ];
        # return view('layouts.test', ['data' => $data]);

        return view('barangkeluar.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   

        try {

            if(Auth::user()->role != 2) {
                $user_rule = UserRule::where('user_id',Auth::user()->id)
                            ->where("rule_id",$this->selected_rule_id_8)
                            ->first();
                $messages = "tidak ada akses ke tambah barang keluar!";
                if($user_rule == null || $user_rule->status == 0) {
                    $request->session()->flash('alert-danger', $messages);
                    return redirect()->route('home');
                }
            }

            $stock = $request->input('stock');

            if(!$stock) {
                throw new Exception('Please select the stock item;');
            }


            $stock_array = explode(",", $stock);

            $stock = Stock::leftJoin('category','category.id','=','stock.category_id')
                        ->leftJoin('merk','merk.id','=','stock.merk_id')
                        ->leftJoin('models','models.id','=','stock.models_id')
                        ->leftJoin('users as uc','uc.id','=','stock.created_by')
                        ->leftJoin('users as up','up.id','=','stock.created_by')
                        ->whereIn('stock.id', $stock_array)
                        ->where('stock.status',1)
                        ->select(
                            'stock.*',
                            'uc.name AS created_by_name',
                            'up.name AS updated_by_name',
                            'category.name AS category_name',
                            'merk.name AS merk_name',
                            'models.name AS models_name')
                        ->get();

            $data = [
                "stock" => $stock,
                "total_harga" => Stock::whereIn('id', $stock_array)->where('status',1)->sum('harga_jual'),
                "category" =>  Category::all(),
            ];
            # return view('layouts.test', ['data' => $data]);
            return view('barangkeluar.create', ['data' => $data]);
        } catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try {

            if(Auth::user()->role != 2) {
                $user_rule = UserRule::where('user_id',Auth::user()->id)
                            ->where("rule_id",$this->selected_rule_id_8)
                            ->first();
                $messages = "tidak ada akses ke tambah barang keluar!";
                if($user_rule == null || $user_rule->status == 0) {
                    $request->session()->flash('alert-danger', $messages);
                    return redirect()->route('home');
                }
            }

            
            $stock = $request->stock_list;

            if(!$stock) {
                throw new Exception('Please select the stock item;');
            }


            $stock_array_raw = explode(",", $stock);
            $stock_array = Stock::whereIn('id', $stock_array_raw)->where('status',1)->pluck('id');
            // dd($stock_array);


            # validation
            $stock_data = Stock::whereIn('id',$stock_array)->get();

            foreach ($stock_data as $key => $value) {
                if($value["harga_jual"] < 1) {
                    throw new Exception('harga stock : '.$value["barcode"]." masih kosong");
                }
            }

            $barangkeluar = new BarangKeluar;
            $barangkeluar->tgl_penjualan = $request->tgl_penjualan;
            $barangkeluar->jumlah_barang = count($stock_data);
            $barangkeluar->pembeli = $request->pembeli;
            $barangkeluar->no_hp_pembeli = $request->no_hp_pembeli;
            $barangkeluar->durasi_garansi = $request->durasi_garansi;
            $barangkeluar->total_harga = $request->total_harga;
            $barangkeluar->uuid = $this->faker->uuid;
            $barangkeluar->created_by = Auth::user()->id;
            $barangkeluar->updated_by = Auth::user()->id;


            $barangkeluar->save();
            $result = Stock::whereIn('id', $stock_array)
            ->where('status', 1)
            ->update(
                [   
                    'tgl_penjualan' => $request->tgl_penjualan,
                    'pembeli' => $request->pembeli,
                    'no_hp_pembeli' => $request->no_hp_pembeli,
                    'durasi_garansi' => $request->durasi_garansi,
                    'uuid_barang_keluar' => $barangkeluar->uuid,
                    'status' => 2
                ]
            );


            $request->session()->flash('alert-success', 'barang keluar sukses!');
            return redirect()->route($this->redirectTo);
            # dd($barangkeluar); 
            



        } catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            // return redirect()->route($this->redirectToCreate);
            return redirect()->route($this->redirectToCreate,["stock"=>$request->stock_list]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function show(BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangKeluar $barangKeluar)
    {
        //
    }
}
