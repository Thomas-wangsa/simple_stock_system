<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\BarangMasuk;
use App\Stock;
use App\Category;
use App\Models;
use App\Merk;
use App\UserRule;

use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Exception;

class BarangMasukController extends Controller
{   
    protected $faker;
    protected $redirectTo      = 'barangmasuk.index';
    protected $selected_rule_id_5 = "5";
    protected $selected_rule_id_6 = "6";

    public function __construct(){
        $this->faker    = Faker::create();
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        if(Auth::user()->role != 2) {
            $user_rule = UserRule::where('user_id',Auth::user()->id)
                        ->where("rule_id",$this->selected_rule_id_5)
                        ->first();
            $messages = "tidak ada akses ke menu barang masuk!";
            if($user_rule == null || $user_rule->status == 0) {
                $request->session()->flash('alert-danger', $messages);
                return redirect()->route('home');
            }
        }

        $barangmasuk = BarangMasuk::leftJoin('category','category.id','=','barangmasuk.category_id')
                        ->leftJoin('merk','merk.id','=','barangmasuk.merk_id')
                        ->leftJoin('models','models.id','=','barangmasuk.models_id')
                        ->leftJoin('users as uc','uc.id','=','barangmasuk.created_by')
                        ->leftJoin('users as up','up.id','=','barangmasuk.created_by')
                        ->orderBy('created_at', 'desc')
                        ->select(
                            'barangmasuk.*',
                            'uc.name AS created_by_name',
                            'up.name AS updated_by_name',
                            'category.name AS category_name',
                            'merk.name AS merk_name',
                            'models.name AS models_name')
                        ->paginate(20);

        $data = [
            "barangmasuk" => $barangmasuk,
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
            if(Auth::user()->role != 2) {
                $user_rule = UserRule::where('user_id',Auth::user()->id)
                            ->where("rule_id",$this->selected_rule_id_6)
                            ->first();
                $messages = "tidak ada akses ke tambah barang masuk!";
                if($user_rule == null || $user_rule->status == 0) {
                    $request->session()->flash('alert-danger', $messages);
                    return redirect()->route('home');
                }
            }

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


                


                $full_each_data = array();
                for ($x = 1; $x <= $data->jumlah_barang; $x++) {
                    $now = now();

                    $barcode = $request->prefix."-".substr($this->faker->uuid,0,7);

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
