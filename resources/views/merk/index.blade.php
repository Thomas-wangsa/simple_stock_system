@extends('layouts.main')

@section('content')


<div class="container">
	<h1 class="text-center"> Merk Page </h1>

    <div class="table-responsive">
      <!-- Button to Open the Modal -->
      <a class="btn btn-info" href="{{ route('admin.index') }}">
      kembali ke menu admin
      </a>

      <a class="btn btn-dark" href="{{ route('merk.create') }}">
      tambah merk
      </a>

      <table class="table table-bordered" style="margin-top: 10px">
          <thead>
            <tr class="text-center">
              <th> No </th>
              <th> Nama Kategori </th>
              <th> Nama Merk </th>
              <th> Di buat oleh </th>
              <th> Di ubah oleh </th>
              <th> Action </th>
            </tr>
          </thead>
          <tbody>
            @if (count($data['merk']) == 0 ) 
              <td colspan="10" class="text-center"> 
                - 
              </td>
            @else
              <?php $no = 1; ?> 
              @foreach($data['merk'] as $key=>$val)
              <tr class="text-center"> 
                <td> {{$no}} </td>
                <td> {{$val->category_name}} </td>
                <td> {{$val->name}} </td>
                <td> 
                  {{$val->created_by_name}} 
                  <br/>
                  {{$val->created_at}}
                </td>

                <td> 
                  {{$val->updated_by_name}}
                  <br/>
                  {{$val->updated_at}} 
                </td>
                <td> 
                  <a class="btn btn-warning" href="{{route('merk.edit',$val->id)}}" > 
                    edit data
                  </a>
                </td>
              </tr>
              <?php $no++; ?>
              @endforeach
            @endif
          </tbody>
        </table>
  	</div>

</div>



@endsection