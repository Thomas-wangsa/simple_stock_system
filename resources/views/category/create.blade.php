@extends('layouts.main')

@section('content')
<div class="container">
	<h1 class="text-center"> Add Category Page</h1>

    <div class="table-responsive">
      <!-- Button to Open the Modal -->
      <a class="btn btn-info" href="{{ route('category.index') }}">
        back
      </a>

      <div style="margin-top: 10px"> 
        <form method="POST" action="{{ route('category.store') }}">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="staff_nama"> 
                Nama Kategori :
              </label>
              <input type="text" class="form-control" name="name" required="">

            </div>

            <button type="submit" class="btn btn-block btn-dark">
              TAMBAH KATEGORI
            </button>
          </form>
        </div>

  	</div>

</div>



@endsection