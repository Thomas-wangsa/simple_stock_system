<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Merk;
use Illuminate\Http\Request;
use App\Category;
use Faker\Factory as Faker;
use Exception;
use App\UserRule;

class MerkController extends Controller
{   
    protected $faker;
    protected $redirectTo      = 'merk.index';
    protected $selected_rule_id_1 = "1";
    protected $selected_rule_id_2 = "2";

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
                        ->where("rule_id",$this->selected_rule_id_1)
                        ->first();
            $messages = "tidak ada akses ke menu admin!";
            if($user_rule == null || $user_rule->status == 0) {
                $request->session()->flash('alert-danger', $messages);
                return redirect()->route('home');
            }
        }

        $data = [
            "merk" => Merk::leftJoin('category','category.id','=','merk.category_id')
            ->leftJoin('users as uc','uc.id','=','merk.created_by')
            ->leftJoin('users as up','up.id','=','merk.updated_by')
            ->select(
                'merk.*',
                'uc.name AS created_by_name',
                'up.name AS updated_by_name',
                'category.name AS category_name')
            ->get(),
        ];
        # return view('layouts.test', ['data' => $data]);

        return view('merk.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        if(Auth::user()->role != 2) {
            $user_rule = UserRule::where('user_id',Auth::user()->id)
                        ->where("rule_id",$this->selected_rule_id_2)
                        ->first();
            $messages = "tidak ada akses ke setting parameter!";
            if($user_rule == null || $user_rule->status == 0) {
                $request->session()->flash('alert-danger', $messages);
                return redirect()->route('home');
            }
        }

        try {
            $data = [
                'category' => Category::all()
            ];
            # return view('layouts.test', ['data' => $data]);
            return view('merk.create', ['data' => $data]);
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
        if(Auth::user()->role != 2) {
            $user_rule = UserRule::where('user_id',Auth::user()->id)
                        ->where("rule_id",$this->selected_rule_id_2)
                        ->first();
            $messages = "tidak ada akses ke setting parameter!";
            if($user_rule == null || $user_rule->status == 0) {
                $request->session()->flash('alert-danger', $messages);
                return redirect()->route('home');
            }
        }
        try {
            $clean_name = strtoupper(trim($request->name,' '));

            if(strlen($clean_name) < 3) {
                $request->session()->flash('alert-warning', "panjang character kurang dari 3");
                return redirect()->route($this->redirectTo);
            }

            $exists = Merk::where('category_id',$request->category)
            ->where('name',$clean_name)->first();

            if($exists) {
                $request->session()->flash('alert-warning', "data is exists");
                return redirect()->route($this->redirectTo);
            }

            $data = new Merk;
            $data->category_id = $request->category;
            $data->name = $clean_name;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;
            $data->save();
            $request->session()->flash('alert-success', "data ".$request->name.' has been created');
            return redirect()->route($this->redirectTo);
        }
        catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Merk  $merk
     * @return \Illuminate\Http\Response
     */
    public function show(Merk $merk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Merk  $merk
     * @return \Illuminate\Http\Response
     */
    public function edit(Merk $merk, Request $request)
    {
        try {
            if(Auth::user()->role != 2) {
                $user_rule = UserRule::where('user_id',Auth::user()->id)
                            ->where("rule_id",$this->selected_rule_id_2)
                            ->first();
                $messages = "tidak ada akses ke setting parameter!";
                if($user_rule == null || $user_rule->status == 0) {
                    $request->session()->flash('alert-danger', $messages);
                    return redirect()->route('home');
                }
            }
            $data = [
                'merk' => $merk,
                'category' => Category::all()
            ];
            # return view('layouts.test', ['data' => $data]);
            return view('merk.edit', ['data' => $data]);
        } catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Merk  $merk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merk $merk)
    {
        try {

            if(Auth::user()->role != 2) {
                $user_rule = UserRule::where('user_id',Auth::user()->id)
                            ->where("rule_id",$this->selected_rule_id_2)
                            ->first();
                $messages = "tidak ada akses ke setting parameter!";
                if($user_rule == null || $user_rule->status == 0) {
                    $request->session()->flash('alert-danger', $messages);
                    return redirect()->route('home');
                }
            }

            $clean_name = strtoupper(trim($request->name,' '));

            if(strlen($clean_name) < 3) {
                $request->session()->flash('alert-warning', "panjang character kurang dari 3");
                return redirect()->route($this->redirectTo);
            }

            $merk->name = $clean_name;
            $merk->updated_by = Auth::user()->id;
            $merk->save();

            $request->session()->flash('alert-success', $request->name.' has been updated');
            return redirect()->route($this->redirectTo);
            # return view('layouts.test', ['data' => $data]);
        } catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Merk  $merk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merk $merk)
    {
        //
    }
}
