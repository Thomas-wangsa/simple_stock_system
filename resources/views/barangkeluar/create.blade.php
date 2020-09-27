@extends('layouts.main')

@section('content')
<div class="container">
  
  <h1 class="text-center"> Barang Keluar </h1>
  <div class="table-responsive">
      <!-- Button to Open the Modal -->


      <form method="POST"  action="{{ route('barangkeluar.store') }}">
          {{ csrf_field() }}
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
            No Pembeli :
          </label>
          <input type="text" class="form-control" name="no_pembeli" required="">
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
          <input class="form-control" type="number" name="jumlah_barang" value="{{$data['total_harga']}}" readonly="">
        </div>


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
                    <input class="form-control" type="number" id="row_{{$val->id}}" >
                  </td>
                  <td> 
                    <div class="btn btn-success" onclick="update_harga('row_{{$val->id}}')"> set harga </div>
                  </td>
                </tr>
                <?php $no++; ?> 
                @endforeach
              @endif
            </tbody>
          </table>
        </form>
  </div>

</div>

<script type="text/javascript">
  
  function update_harga(argument) {
    var new_price = $("#"+argument). val();
    if(new_price < 1) {
      alert("set harga salah;");
      return;
    }
  }

</script>
@endsection
