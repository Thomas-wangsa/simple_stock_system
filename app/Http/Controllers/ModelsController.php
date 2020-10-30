<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models;
use App\Merk;
use Illuminate\Http\Request;
use App\Category;
use Faker\Factory as Faker;
use Exception;

class ModelsController extends Controller
{   
    protected $faker;
    protected $redirectTo      = 'models.index';

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
            "model" => Models::leftJoin('merk','merk.id','=','models.merk_id')
            ->leftJoin('category','category.id','=','merk.category_id')
            ->leftJoin('users as uc','uc.id','=','category.created_by')
            ->leftJoin('users as up','up.id','=','category.created_by')
            ->select(
                'models.*',
                'uc.name AS created_by_name',
                'up.name AS updated_by_name',
                'category.name AS category_name',
                'merk.name AS merk_name')
            ->get(),
        ];
        # return view('layouts.test', ['data' => $data]);

        return view('models.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $data = [
                'category' => Category::all()
            ];
            # return view('layouts.test', ['data' => $data]);
            return view('models.create', ['data' => $data]);
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
            $clean_name = strtoupper(trim($request->name,' '));

            if(len($clean_name) < 3) {
                $request->session()->flash('alert-warning', "panjang character kurang dari 3");
                return redirect()->route($this->redirectTo);
            }

            $exists = Models::where('merk_id',$request->merk)
            ->where('name',$clean_name)->first();

            if($exists) {
                $request->session()->flash('alert-warning', "data is exists");
                return redirect()->route($this->redirectTo);
            }

            $data = new Models;
            $data->merk_id = $request->merk;
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
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function show(Models $models)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {

            $models = Models::find($request->id);

            if($models == null) {
                $request->session()->flash('alert-warning', "data is not exists");
                return redirect()->route($this->redirectTo);
            }

            $merk = Merk::find($models->merk_id);
            $category = Category::find($merk->category_id);

            $data = [
                'model' => $models,
                'category' => $category,
                'merk' => $merk
                // 'category' => Category::all()
            ];
            # return view('layouts.test', ['data' => $data]);
            return view('models.edit', ['data' => $data]);
        } catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Models $models)
    {
        try {
            $models = Models::find($request->model_id);

            if($models == null) {
                $request->session()->flash('alert-warning', "data is not exists");
                return redirect()->route($this->redirectTo);
            }

            $clean_name = strtoupper(trim($request->name,' '));

            if(len($clean_name) < 3) {
                $request->session()->flash('alert-warning', "panjang character kurang dari 3");
                return redirect()->route($this->redirectTo);
            }

            $models->name = $clean_name;
            $models->updated_by = Auth::user()->id;
            $models->save();

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
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function destroy(Models $models)
    {
        //
    }
}
