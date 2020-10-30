<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Faker\Factory as Faker;

class AdminController extends Controller
{   

     protected $faker;
    protected $redirectTo      = 'admin.index';

    public function __construct()
    {      

        $this->middleware('auth');
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
            "users" => User::paginate(20),
        ];
        # return view('layouts.test', ['data' => $data]);

        return view('admin.index', ['data' => $data]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = User::find($id);


        return view('admin.edit', ['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        try {
            $data = User::find($id);
            $data->name = $request->name;
            $data->email = $request->email;

            if($request->role) {
                $data->role = $request->role;
            }

            if($request->password) {
                $data->password = bcrypt($request->password);
            }

            $data->save();
            $request->session()->flash('alert-success', $data->name.' has been updated');
            return redirect()->route($this->redirectTo);
        }
        catch(Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
            return redirect()->route($this->redirectTo);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
