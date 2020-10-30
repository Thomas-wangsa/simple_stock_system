@extends('layouts.main')

@section('content')
<div class="container">
	<h1 class="text-center"> Admin Page</h1>




    <div class="table-responsive">
      <!-- Button to Open the Modal -->
      <a class="btn btn-success" href="{{ route('category.index') }}">
      List Kategori
      </a>

      <a class="btn btn-dark" href="{{ route('merk.index') }}">
      List Merk
      </a>

      <a class="btn btn-danger" href="{{ route('models.index') }}">
      List Model
      </a>

      <table class="table table-bordered" style="margin-top: 10px">
          <thead>
            <tr>
              <th> No </th>
              <th>Tgl Masuk</th>
              <th>Jumlah barang</th>
              <th>Kategori</th>
              <th>Merk</th>
              <th>Model</th>
              <th>Penjual</th>
              <th>Created At</th>
              <th> Info </th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
  	</div>

</div>



@endsection