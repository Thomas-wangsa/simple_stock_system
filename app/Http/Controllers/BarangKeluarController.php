<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\BarangKeluar;
use Illuminate\Http\Request;
use Exception;
use App\Stock;
use Faker\Factory as Faker;


class BarangKeluarController extends Controller
{   
    protected $redirectTo      = 'barangkeluar.index';
    protected $redirectToCreate      = 'barangkeluar.create';

    public function __construct(){
        $this->faker    = Faker::create();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            "barangkeluar" => BarangKeluar::all(),
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
            $stock = $request->input('stock');

            if(!$stock) {
                throw new Exception('Please select the stock item;');
            }


            $stock_array = explode(",", $stock);

            $data = [
                "stock" => Stock::whereIn('id', $stock_array)->where('status',1)->get(),
                "total_harga" => Stock::whereIn('id', $stock_array)->where('status',1)->sum('harga_jual'),
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
            $stock = $request->stock_list;

            if(!$stock) {
                throw new Exception('Please select the stock item;');
            }


            $stock_array = explode(",", $stock);

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
