<?php

namespace App\Http\Controllers;

use App\Stock;
use App\BarangKeluar;

use Illuminate\Http\Request;
use PDF;
use Exception;
class StockController extends Controller
{   
    protected $redirectTo      = 'home';
    public function __construct(){
        $this->middleware('auth');

    }


    public function print_invoice(Request $request) {
        try {
            //dd($request);
            // $stock = $request->input('stock');

            // if(!$stock) {
            //     throw new Exception('Please select the stock item;');
            // }

            $barang_keluar = BarangKeluar::where('uuid',$request->uuid)->first();
            if($barang_keluar == null) {
                throw new Exception('barang_keluar tidak ketemu;');
            }

            $stock = Stock::where('uuid_barang_keluar',$request->uuid )->get();
            // $stock_array = explode(",", $stock);

            $data = [
                'barang_keluar' => $barang_keluar,
                'stock' => $stock,
            ];
            //dd($data);

            $pdf = PDF::loadview('print.invoice',['data' => $data])->setPaper('a4', 'landscape');
            return $pdf->stream();

            # return view('layouts.test', ['data' => $data]);
            
        } catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }




    public function print_stock(Request $request) {
        try {
            $stock = $request->input('stock');

            if(!$stock) {
                throw new Exception('Please select the stock item;');
            }


            $stock_array = explode(",", $stock);

            $data = [
                'stock' => Stock::whereIn('id', $stock_array)->select('barcode')->get(),
            ];

            $pdf = PDF::loadview('print.barcode',$data)->setPaper('a4', 'landscape');
            return $pdf->stream();

            # return view('layouts.test', ['data' => $data]);
            
        } catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }


    }

    public function delete_stock(Request $request) {
        try {
            $id = $request->id;

            $result = Stock::where('id', $id)
            ->take(1)
            ->update(['status' => 4]);

            $request->session()->flash('alert-success', 'delete sukses!');
            return redirect()->route($this->redirectTo);
            # return view('layouts.test', ['data' => $data]);
            
        } catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {

    }
}
