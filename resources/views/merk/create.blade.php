@extends('layouts.main')

@section('content')
<div class="container">
	<h1 class="text-center"> Add Merk Page</h1>

    <div class="table-responsive">
      <!-- Button to Open the Modal -->
      <a class="btn btn-info" href="{{ route('merk.index') }}">
        back
      </a>

      <div style="margin-top: 10px"> 
        <form method="POST" action="{{ route('merk.store') }}">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="staff_nama"> 
                Pilih Kategori :
              </label>
              <select class="form-control" name="category" required="">
                <option value=""> pilih kategori </option>
                @foreach($data['category'] as $key=>$val)
                <option value="{{$val->id}}"> {{$val->name}} </option>
                @endforeach
              </select>

            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Nama Merk :
              </label>
              <input type="text" class="form-control" name="name" required="">
            </div>

            <button type="submit" class="btn btn-block btn-dark">
              TAMBAH Merk
            </button>
          </form>
        </div>

  	</div>

</div>



@endsection