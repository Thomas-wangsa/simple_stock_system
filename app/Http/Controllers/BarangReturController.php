<?php

namespace App\Http\Controllers;

use App\BarangRetur;
use Illuminate\Http\Request;
use App\Stock;

class BarangReturController extends Controller
{   
    protected $redirectTo      = 'home';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

           


            $result = Stock::whereIn('id', $stock_array)
            ->where('status', 2)
            ->update(['status' => 3]);

            $request->session()->flash('alert-success', 'barang retur sukses!');
            return redirect()->route($this->redirectTo);
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
     * @param  \App\BarangRetur  $barangRetur
     * @return \Illuminate\Http\Response
     */
    public function show(BarangRetur $barangRetur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BarangRetur  $barangRetur
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangRetur $barangRetur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BarangRetur  $barangRetur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangRetur $barangRetur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BarangRetur  $barangRetur
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangRetur $barangRetur)
    {
        //
    }
}
