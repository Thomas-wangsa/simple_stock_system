@extends('layouts.main')

@section('content')
<div class="container">
	<h1 class="text-center"> Add Merk Page</h1>

    <div class="table-responsive">
      <!-- Button to Open the Modal -->
      <a class="btn btn-info" href="{{ route('models.index') }}">
        back
      </a>

      <div style="margin-top: 10px"> 
        <form method="POST" action="{{ route('models.store') }}">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="staff_nama"> 
                Pilih Kategori :
              </label>
              <select class="form-control" id="category_select" name="category" required="">
                <option value=""> pilih kategori </option>
                @foreach($data['category'] as $key=>$val)
                <option value="{{$val->id}}"> {{$val->name}} </option>
                @endforeach
              </select>

            </div>


            <div class="form-group">
              <label for="staff_nama"> 
                Pilih Merk :
              </label>
              <select class="form-control" id="merk_select" name="merk" required="">
                
              </select>

            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Nama Model :
              </label>
              <input type="text" class="form-control" name="name" required="">
            </div>

            <button type="submit" class="btn btn-block btn-danger">
              TAMBAH Model
            </button>
          </form>
        </div>

  	</div>

</div>


<script type="text/javascript">
  
  $(document).ready(function() { 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#category_select').on('change', function() {
      $('#merk_select').find('option').remove()
      if(this.value == undefined || this.value == "") {
        return;
      }

      data_raw =  {category_id:this.value };

      

      $.ajax({
        type : "POST",
        url: " {{ route('ajax.get_merk') }}",
        contentType: "application/json",
        data : JSON.stringify(data_raw),
        success: function(result) {
          console.log(result);
          response = JSON.parse(result);
          console.log(response);
          if(response.error == true) {
            alert(response.messages);
          } else {
            append_tag = "<option value=''> select merk </option>";
            $.each(response.data, function( index, value ) {
              append_tag += "<option value='"+value.id+"'> "+value.name+" </option>";
            });
            $("#merk_select").append(append_tag);
          }
        },  
        error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
        }
      }); 
    });


  });
</script>


@endsection