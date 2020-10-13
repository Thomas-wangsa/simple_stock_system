@extends('layouts.main')

@section('content')
<div class="container">
  
  <h1 class="text-center"> Barang Keluar </h1>
  <div class="table-responsive">
      <!-- Button to Open the Modal -->


      <form method="POST"  action="{{ route('barangkeluar.store') }}">
          {{ csrf_field() }}

        <input type="text" class="" name="stock_list" value="{{ app('request')->input('stock') }}" hidden="">
        <div class="form-group">
          <label for="staff_nama"> 
            Tanggal Penjualan :
          </label>
          <input type="text" class="form-control datepicker_class" name="tgl_penjualan" required="">
        </div>

        <div class="form-group">
          <label for="staff_nama"> 
            Pembeli :
          </label>
          <input type="text" class="form-control" name="pembeli" required="">
        </div>

        <div class="form-group">
          <label for="staff_nama"> 
            No Hp Pembeli :
          </label>
          <input type="text" class="form-control" name="no_hp_pembeli" required="">
        </div>

        <div class="form-group">
          <label for="staff_nama"> 
            Garansi :
          </label>
          <input class="form-control" type="number" id="garansi"
          name="durasi_garansi" value="" required="">
        </div>

        <div class="form-group">
          <label for="staff_nama"> 
            Jumlah Barang :
          </label>
          <input class="form-control" type="number" name="jumlah_barang" value="{{count($data['stock'])}}" readonly="">
        </div>

        <div class="form-group">
          <label for="staff_nama"> 
            Total Harga :
          </label>
          <input class="form-control" type="number" id="total_harga"
          name="total_harga" value="{{$data['total_harga']}}" readonly="">
        </div>

        <button type="submit" class="btn btn-block btn-danger">
          SUBMIT BARANG KELUAR
        </button>
      </form>

      <table class="table table-bordered" style="margin-top: 10px">
          <thead>
            <tr>
              <th> No </th>
              <th>Kategori</th>
              <th>Merk</th>
              <th>Model</th> 
              <th>Status</th>
              <th>Barcode</th>
              <th>Harga Jual</th>   
              <th>Action</th>   
            </tr>
          </thead>
          <tbody>
            @if (count($data['stock']) == 0 ) 
            <td colspan="10" class="text-center"> 
              - 
            </td>
            @else
              <?php $no = 1; ?> 
              @foreach($data['stock'] as $key=>$val)
              <tr> 
                <td> {{$no}}</td>
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
                <td>
                @if($val->status == 1) 
                  Barang Masuk
                @elseif($val->status == 2) 
                  Barang Keluar
                @elseif($val->status == 3) 
                  Barang Retur
                @elseif($val->status == 4) 
                  Barang Non-Active
                @else
                  -
                @endif 
                </td>
                <td> {{$val->barcode}} </td>
                <td>
                  <input class="form-control" type="number" id="row_{{$val->uuid}}" value="{{$val->harga_jual}}">
                </td>
                <td> 
                  <div class="btn btn-success" id="btn_row_{{$val->uuid}}" onclick="update_harga('row_{{$val->uuid}}')"> set harga </div>
                </td>
              </tr>
              <?php $no++; ?> 
              @endforeach
            @endif
          </tbody>
        </table>
        
  </div>

</div>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function update_harga(argument) {
    $("#btn_"+argument).hide();
    var new_price = $("#"+argument).val();
    if(new_price < 1) {
      alert("set harga salah;");
      return;
    }
    var res = argument.split("_");

    var data = {"argument":res[1],"new_price":new_price};

    $.ajax({
      type : "POST",
      url: " {{ route('ajax.updatestockprice') }}",
      contentType: "application/json",
      data : JSON.stringify(data),
      success: function(result) {
        response = JSON.parse(result);
        console.log(result);
        if(response.error == true) {
          alert(response.messages);
        } else { 
          update_total_harga();
          $("#btn_"+argument).show();
        } 
      }
    });
  }


  function update_total_harga() {
    var stock_list = "{{ app('request')->input('stock') }}"
    var data = {"stock_list":stock_list};
    $.ajax({
      type : "POST",
      url: " {{ route('ajax.updatetotalstockprice') }}",
      contentType: "application/json",
      data : JSON.stringify(data),
      success: function(result) {
        response = JSON.parse(result);
        if(response.error == true) {
          alert(response.messages);
        } else { 
          $("#total_harga").val(response.data);
        } 
      }
    });

  }

</script>
@endsection
