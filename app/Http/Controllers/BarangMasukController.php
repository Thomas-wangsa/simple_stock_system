<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\BarangMasuk;
use App\Stock;
use App\Category;
use App\Models;
use App\Merk;

use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Exception;

class BarangMasukController extends Controller
{   
    protected $faker;
    protected $redirectTo      = 'barangmasuk.index';

    public function __construct(){
        $this->faker    = Faker::create();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $data = [
            "barangmasuk" => BarangMasuk::all(),
            "category" =>  Category::all(),

        ];
        # return view('layouts.test', ['data' => $data]);

        return view('barangmasuk.index', ['data' => $data]);
        # return view('barangmasuk/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            if ($request->jumlah_barang < 1) {
                throw new Exception('Please input the quantity;');
            }

            if ($request->jumlah_barang > 2000) {
                throw new Exception('Quantity lebih dari limit, please contact the administrator;');
            }

            $uuid = $this->faker->uuid;
            DB::transaction(function () use ($request, $uuid) {
                $data = new BarangMasuk;

                $data->tgl_pembelian = $request->tgl_pembelian;
                $data->jumlah_barang = $request->jumlah_barang;
                $data->category_id = $request->kategori;
                $data->merk_id = $request->merk;
                $data->models_id = $request->model;
                $data->penjual = $request->penjual;
                $data->uuid = $uuid;
                $data->created_by = Auth::user()->id;
                $data->updated_by = Auth::user()->id;


                $data_category = Category::find($request->kategori)->name;
                $data_merk = Merk::find($request->merk)->name;
                $data_models = Models::find($request->model)->name;


                $full_each_data = array();
                for ($x = 1; $x <= $data->jumlah_barang; $x++) {
                    $now = now();

                    $barcode = substr($data_category,0,2).substr($data_merk,0,2).substr($data_models,0,2)."_".$x."_".substr($this->faker->uuid,0,7);

                    $each_data = array();
                    $each_data["category_id"] = $request->kategori;
                    $each_data["merk_id"] = $request->merk;
                    $each_data["models_id"] = $request->model;
                    $each_data["status"] = 1;
                    $each_data["penjual"] = $request->penjual;
                    $each_data["tgl_pembelian"] = $request->tgl_pembelian;
                    $each_data["uuid_barang_masuk"] = $data->uuid;
                    $each_data["uuid"] = $this->faker->uuid;
                    $each_data["barcode"] = $barcode;
                    $each_data["created_at"] = now();
                    $each_data["updated_at"] = now();
                    $each_data["created_by"] = Auth::user()->id;
                    $each_data["updated_by"] = Auth::user()->id;

                    array_push($full_each_data, $each_data);
                    # $full_each_data.append($each_data);

                } 


                $data->save();
                Stock::insert($full_each_data);

                
            });
            $request->session()->flash('alert-success', "data ".$request->tgl_pembelian.' has been created');
            return redirect()->route($this->redirectTo,"search=on&uuid=".$uuid);

        }
        catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        //
    }
}
