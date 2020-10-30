@extends('layouts.main')

@section('content')
<div class="container">
	<h1 class="text-center"> Edit Models Page</h1>

    <div class="table-responsive">
      <!-- Button to Open the Modal -->
      <a class="btn btn-info" href="{{ route('models.index') }}">
        back
      </a>

      <div style="margin-top: 20px"> 
        <form method="POST" action="{{ route('models.update',$data['model']->id) }}">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">

            <input type="hidden" name="model_id" value="{{$data['model']->id}}">

            <div class="form-group">
              <label for="staff_nama"> 
                Pilih Kategori :
              </label>
              <select class="form-control" name="kategori" disabled="">
                <option value=""> pilih kategori </option>
                <option value="{{$data['category']->id}}" selected=""> 
                  {{$data['category']->name}}
                </option>
              </select>

            </div>

            
            <div class="form-group">
              <label for="staff_nama"> 
                Pilih Merk :
              </label>
              <select class="form-control" name="merk" disabled="">
                <option value=""> pilih merk </option>
                <option value="{{$data['merk']->id}}" selected=""> 
                  {{$data['merk']->name}}
                </option>
              </select>

            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Nama Model :
              </label>
              <input type="text" class="form-control" name="name" 
              value="{{$data['model']->name}}" required="">
            </div>

            <button type="submit" class="btn btn-block btn-warning">
              EDIT MODEL
            </button>
          </form>
        </div>

  	</div>

</div>



@endsection