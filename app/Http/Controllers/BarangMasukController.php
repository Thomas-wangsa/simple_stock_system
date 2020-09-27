<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\BarangMasuk;
use App\Stock;

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

            if ($request->jumlah_barang > 5000) {
                throw new Exception('Quantity lebih dari limit, please contact the administrator;');
            }

            $data = new BarangMasuk;

            $data->tgl_pembelian = $request->tgl_pembelian;
            $data->jumlah_barang = $request->jumlah_barang;
            $data->kategori = $request->kategori;
            $data->merk = $request->merk;
            $data->model = $request->model;
            $data->penjual = $request->penjual;
            $data->uuid = $this->faker->uuid;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $full_each_data = array();
            for ($x = 1; $x <= $data->jumlah_barang; $x++) {
                $now = now();

                $each_data = array();
                $each_data["kategori"] = $request->kategori;
                $each_data["merk"] = $request->merk;
                $each_data["model"] = $request->model;
                $each_data["status"] = 1;
                $each_data["penjual"] = $request->penjual;
                $each_data["tgl_pembelian"] = $request->tgl_pembelian;
                $each_data["uuid_barang_masuk"] = $data->uuid;
                $each_data["uuid"] = $this->faker->uuid;
                $each_data["barcode"] = $this->faker->uuid;
                $each_data["created_at"] = now();
                $each_data["updated_at"] = now();
                $each_data["created_by"] = Auth::user()->id;
                $each_data["updated_by"] = Auth::user()->id;

                array_push($full_each_data, $each_data);
                # $full_each_data.append($each_data);

            } 


            $data->save();
            Stock::insert($full_each_data);
            $request->session()->flash('alert-success', "data ".$data->tgl_pembelian.' has been created');
            return redirect()->route($this->redirectTo,"search=on&uuid=".$data->uuid);
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
