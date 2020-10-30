<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Category;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Exception;

class CategoryController extends Controller
{   
    protected $faker;
    protected $redirectTo      = 'category.index';

    public function __construct(){
        $this->faker    = Faker::create();
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            "category" => Category::leftJoin('users as uc','uc.id','=','category.created_by')
            ->leftJoin('users as up','up.id','=','category.created_by')
            ->select('category.*','uc.name AS created_by_name','up.name AS updated_by_name')
            ->get(),
        ];
        # return view('layouts.test', ['data' => $data]);

        return view('category.index', ['data' => $data]);
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

            ];
            # return view('layouts.test', ['data' => $data]);
            return view('category.create', ['data' => $data]);
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


            $exists = Category::where('name',$clean_name)->first();

            if($exists) {
                $request->session()->flash('alert-warning', "data is exists");
                return redirect()->route($this->redirectTo);
            }


            $data = new Category;
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category,Request $request)
    {
        try {
            $data = [
                'category' => $category

            ];
            # return view('layouts.test', ['data' => $data]);
            return view('category.edit', ['data' => $data]);
        } catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        try {

            $clean_name = strtoupper(trim($request->name,' '));

            if(len($clean_name) < 3) {
                $request->session()->flash('alert-warning', "panjang character kurang dari 3");
                return redirect()->route($this->redirectTo);
            }

            $category->name = $clean_name;
            $category->updated_by = Auth::user()->id;
            $category->save();

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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
