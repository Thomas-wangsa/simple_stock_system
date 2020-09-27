<?php

namespace App\Http\Controllers;

use App\BarangKeluar;
use Illuminate\Http\Request;
use Exception;
use App\Stock;


class BarangKeluarController extends Controller
{   
    protected $redirectTo      = 'barangkeluar.index';
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
        //
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
