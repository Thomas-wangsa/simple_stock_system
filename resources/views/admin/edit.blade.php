@extends('layouts.main')

@section('content')
	<div class="container">
		<div style="margin: 10px auto">
		    <a href="{{route('admin.index')}}">
		      <button type="button" class="btn btn-md btn-info">
		        Back
		      </button>
		    </a>
	  	</div>

	  	<form action="{{route('admin.update',$data->id)}}" method="POST">
		    {{ csrf_field() }}
		    <input type="hidden" name="_method" value="PUT">
		    <div class="form-group">
		      <label for="pwd"> Name : </label>
		      <input type="text" class="form-control" id="pwd"  name="name" maxlength="40" required=""
		      value="{{$data->name}}">
		    </div>

		    <div class="form-group">
		      <label for="pwd">Email :</label>
		      <input type="email" class="form-control" id="pwd"  name="email" required=""
		      value="{{$data->email}}">
		    </div>


		    @if(Auth::user()->role == 2) 
		    <div class="form-group">
		      <label for="sel1">Select role :</label>
		      <select class="form-control" name="role" id="sel1" required="">
		        <option value="1"
		        <?php 
		        if ($data->role == 1) echo "selected";
		        ?>
		        > staff </option>
		        <option value="2" 
		        <?php 
		        if ($data->role == 2) echo "selected";
		        ?>
		        >
		        super admin </option>
		       
		      </select>
		    </div>
		    @endif

		    <div class="form-group">
		      <label for="pwd"> Password : </label>
		      <input type="password" class="form-control" id="pwd"  name="password" maxlength="25" 
		      value="">
		    </div>

		    <div class="text-center" style="margin-top: 50px">
		      <button type="submit" class="btn btn-info btn-block">
		        <span class="glyphicon glyphicon-edit"></span> Update User
		      </button>
		    </div>
  		</form>
  	</div>
@endsection