@extends('layouts.main')

@section('content')


<div class="container">
	<h1 class="text-center"> Category Page</h1>




    <div class="table-responsive">
      <!-- Button to Open the Modal -->
      <a class="btn btn-primary" href="{{ route('category.create') }}">
      tambah kategori
      </a>

      <table class="table table-bordered" style="margin-top: 10px">
          <thead>
            <tr class="text-center">
              <th> No </th>
              <th> Nama Kategori </th>
              <th> Di buat oleh </th>
              <th> Di ubah oleh </th>
              <th> Action </th>
            </tr>
          </thead>
          <tbody>
            @if (count($data['category']) == 0 ) 
              <td colspan="10" class="text-center"> 
                - 
              </td>
            @else
              <?php $no = 1; ?> 
              @foreach($data['category'] as $key=>$val)
              <tr class="text-center"> 
                <td> {{$no}} </td>
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
                  <a class="btn btn-warning" href="{{route('category.edit',$val->id)}}" > 
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