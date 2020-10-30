@extends('layouts.main')

@section('content')
<div class="container">
	<h1 class="text-center"> Edit Merk Page</h1>

    <div class="table-responsive">
      <!-- Button to Open the Modal -->
      <a class="btn btn-info" href="{{ route('merk.index') }}">
        back
      </a>

      <div style="margin-top: 10px"> 
        <form method="POST" action="{{ route('merk.update',$data['merk']->id) }}">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group">
              <label for="staff_nama"> 
                Pilih Kategori :
              </label>
              <select class="form-control" name="category" disabled="">
                <option value=""> pilih kategori </option>
                @foreach($data['category'] as $key=>$val)
                <option value="{{$val->id}}"
                <?php if($val->id == $data["merk"]->category_id) {echo "selected";} ?>
                > 
                  {{$val->name}} 
                </option>
                @endforeach
              </select>

            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Nama Merk :
              </label>
              <input type="text" class="form-control" name="name" 
              value="{{$data['merk']->name}}" required="">
            </div>

            <button type="submit" class="btn btn-block btn-warning">
              EDIT MERK
            </button>
          </form>
        </div>

  	</div>

</div>



@endsection