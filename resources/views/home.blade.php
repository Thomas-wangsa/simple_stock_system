@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="text-center"> Stock Barang </h1>

    <div class="table-responsive">
      <!-- Button to Open the Modal -->


      <div class="btn btn-warning" id="btn_submit_barang_keluar" onclick="submit_barang_keluar()" >
      submit barang keluar
      </div>

      <a href="{{route('home')}}">
        <button type="button" id="btn_reset_filter"  class="btn btn-secondary">
        Reset Filter
        </button>
      </a>
      

      <table class="table table-bordered" style="margin-top: 10px">
          <thead>
            <tr>

              @if(!app('request')->input('trigger') )
              <th> </th>
              @endif
              <th> No </th>
              <th> Kategori</th>
              <th> Merk</th>
              <th> Model</th>
              <th> Status </th>
              <th> Penjual </th>
              <th> Pembeli </th>
              <th> Barcode </th>
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
                @if(!app('request')->input('trigger') )
                <td>  <input type="checkbox" onclick='handleClick("<?php echo $val->id;?>");'>&nbsp; </td>
                @endif

                <td> {{$no}} </td>
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
                <td> {{$val->penjual}} </td>
                <td> {{$val->pembeli}} </td>
                <td class="<?php if($val->status == 2) {echo "text-danger";} ?>"> 
                  {{$val->barcode}} 
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

  $("#btn_submit_barang_keluar").hide();
  $("#btn_reset_filter").hide();

  var trigger =  "{{ app('request')->input('trigger') }}"
  
  if(trigger == "on") {
    $("#btn_reset_filter").show();
  }

  var selected_item = [];

  function handleClick(id) {
    if (selected_item.includes(id)) {
      index = selected_item.indexOf(id);
      selected_item.splice(index,1);
    } else {
      selected_item.push(id);
    }
    $("#btn_submit_barang_keluar").show();
    console.log(selected_item);
  }


  function submit_barang_keluar() {

    if(selected_item.length > 0) {
      window.location = "{{ route('barangkeluar.create')}}?stock="+selected_item;
    } else {
      alert("pilih barang terlebih dahulu;");
    }
  }

</script>
@endsection
