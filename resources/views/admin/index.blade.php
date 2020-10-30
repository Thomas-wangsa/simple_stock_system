@extends('layouts.main')

@section('content')

<style type="text/css">
  table tr th, table tr td {text-align: center}

</style>
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

      <div style="margin-top: 20px">
        <table class="table table-striped table-bordered">
            <thead>
              <tr class="info"> 
                <th> No </th>
                <th> User Name </th>
                <th> Email </th>
                <th> Role </th>
                <th> Action </th>
              </tr>
            </thead>
            <tbody>
              @foreach($data['users'] as $key=>$val)
              <tr>
                <td> 
                  {{ ($data['users']->currentpage()-1) 
                  * $data['users']->perpage() + $key + 1 }} 
                </td>
                <td>
                  {{$val->name}}
                </td>
                <td>
                  {{$val->email}}
                </td>
                <td>
                  @if($val->role == 2) 
                    super admin
                  @else
                    staff
                  @endif
                </td>
                <td>
                  @if($val->role != 2)
                  <div class="btn btn-danger">
                    Set Auth Rule  {{$val->name}}
                  </div>
                  @endif

                  <a class="btn btn-warning" href="{{route('admin.edit',$val->id)}}">
                    Edit {{$val->name}}
                  </a>
                </td>

              </tr>
              @endforeach
            </tbody>
        </table>
        <div class="float-right" style="margin-top: -15px!important"> 
          {{ $data['users']->links() }}
        </div>
        <div class="clearfix"> </div>
      </div>
  	</div>

</div>



@endsection