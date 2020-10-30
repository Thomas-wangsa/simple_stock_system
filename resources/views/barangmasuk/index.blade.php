@extends('layouts.main')

@section('content')
<div class="container">
  
  <h1 class="text-center"> Barang Masuk </h1>
  <div class="table-responsive">
      <!-- Button to Open the Modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBarangMasuk">
      tambah barang masuk
      </button>

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
            @if (count($data['barangmasuk']) == 0 ) 
              <td colspan="10" class="text-center"> 
                - 
              </td>
            @else
              <?php $no = 1; ?> 
              @foreach($data['barangmasuk'] as $key=>$val)
              <tr> 
                <td> {{$no}} </td>
                <td> {{$val->tgl_pembelian}} </td>
                <td> {{$val->jumlah_barang}} </td>
                <td> 
                  @if($val->kategori == 1) 
                    AC
                  @else
                    -
                  @endif 
                </td>
                <td>
                  @if($val->merk == 1) 
                    Sharp
                  @else
                    Daikin
                  @endif 
                </td>
                <td>
                  @if($val->model == 1) 
                    R32
                  @else
                    R410
                  @endif 
                </td>
                <td> {{$val->penjual}} </td>
                <td> {{$val->created_at}} </td>
                <td> <button class="btn btn-primary" onclick="check_data('{{$val->uuid}}')">check data</button></td>
              </tr>
              <?php $no++; ?>
              @endforeach
            @endif
          </tbody>
        </table>
  </div>



  <!-- The Modal -->
  <div class="modal fade" id="addBarangMasuk">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"> Tambah Barang Masuk </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">

            <!-- <form action="/action_page.php">
              <div class="form-group">
                <label for="email">Email address:</label>
                <input type="text" class="form-control" placeholder="Enter email" id="email">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form> -->

          <form method="POST" action="{{ route('barangmasuk.store') }}">
          {{ csrf_field() }}
            <div class="form-group">
              <label for="staff_nama"> 
                Tanggal Pembelian :
              </label>
              <input type="text" class="form-control datepicker_class" name="tgl_pembelian" required="">
            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Jumlah Barang :
              </label>
              <input class="form-control" type="number" name="jumlah_barang" required="">
            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Kategori : 
              </label>
              <select class="form-control" id="category_select" name="kategori" required="">
                <option value=""> pilih kategori </option>
                @foreach($data['category'] as $key=>$val)
                <option value="{{$val->id}}"> {{$val->name}} </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Merk : 
              </label>
              <select class="form-control" id="merk_select" name="merk" required="">
                
              </select>
            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Model : 
              </label>
              <select class="form-control" id="models_select" name="model" required="">
                
              </select>
            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Penjual :
              </label>
              <input type="text" class="form-control" name="penjual" required="">

            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Prefix Barcode :
              </label>
              <input type="text" class="form-control" name="prefix" required="">

            </div>

            <button type="submit" class="btn btn-block btn-primary">
              TAMBAH BARANG MASUK
            </button>
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
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
      $('#merk_select').find('option').remove();
      $('#models_select').find('option').remove();
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


    $('#merk_select').on('change', function() {
      $('#models_select').find('option').remove()
      if(this.value == undefined || this.value == "") {
        return;
      }

      data_raw =  {merk_id:this.value };
      $.ajax({
        type : "POST",
        url: " {{ route('ajax.get_models') }}",
        contentType: "application/json",
        data : JSON.stringify(data_raw),
        success: function(result) {
          console.log(result);
          response = JSON.parse(result);
          console.log(response);
          if(response.error == true) {
            alert(response.messages);
          } else {
            append_tag = "<option value=''> select models </option>";
            $.each(response.data, function( index, value ) {
              append_tag += "<option value='"+value.id+"'> "+value.name+" </option>";
            });
            $("#models_select").append(append_tag);
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

<script type="text/javascript">

  function check_data(uuid) {
   window.open("{{ route('home')}}?trigger=on&trigger_from=barang_masuk&uuid="+uuid)
  }
</script>



