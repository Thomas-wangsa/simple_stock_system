@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="text-center"> Stock Barang </h1>

    <div class="table-responsive">
      <!-- Button to Open the Modal -->


      <div class="btn btn-warning btn-block" id="btn_submit_barang_keluar" onclick="submit_barang_keluar()" hidden="">
      submit barang keluar
      </div>

      <div class="btn btn-danger btn-block" id="btn_submit_barang_retur" onclick="submit_barang_keluar()" hidden="">
      submit barang retur
      </div>


      <div class="clearfix" style="margin-bottom: 10px"> </div>
      
      @if(!app('request')->input('trigger') )
      <form action="{{route('home')}}">
        <input type="hidden" name="search" value="on">
        <div class="row">
          
          <div class="col">
            <input type="text" class="form-control" placeholder="Enter barcode" 
            name="select_barcode" value="{{app('request')->input('select_barcode')}}">
          </div>
          
        </div>

        <br/>

        <div class="row">
          <div class="col">
            <select class="form-control" name="select_category">
              <option value="">  Select Kategori </option>
              <option value="1" <?php if(app('request')->input('select_category') == 1) echo "selected" ?> > AC </option>
            </select>
          </div>

          <div class="col">
            <select class="form-control" name="select_merk">
              <option value="">  Select Merk </option>
              <option value="1" <?php if(app('request')->input('select_merk') == 1) echo "selected" ?> > Sharp </option>
              <option value="2" <?php if(app('request')->input('select_merk') == 2) echo "selected" ?> > Daikin </option>
            </select>
          </div>


          <div class="col">
            <select class="form-control" name="select_model">
              <option value="">  Select Model </option>
              <option value="1" <?php if(app('request')->input('select_model') == 1) echo "selected" ?> > R32 </option>
              <option value="2" <?php if(app('request')->input('select_model') == 2) echo "selected" ?>> R410 </option>
            </select>
          </div>
        </div>

        <br/>


        <div class="row">
          <div class="col">
            <input type="text" class="form-control" id="email" placeholder="Nama Penjual" 
            name="select_penjual" value="{{app('request')->input('select_penjual')}}">
          </div>

          <div class="col">
            <input type="text" class="form-control datepicker_class" placeholder="dari tanggal" 
            name="date_from_penjual"  value="{{app('request')->input('date_from_penjual')}}">
          </div>

          <div class="col">
            <input type="text" class="form-control datepicker_class" placeholder="ke tanggal" 
            name="date_to_penjual" value="{{app('request')->input('date_to_penjual')}}">
          </div>

        </div>

        <br/>

        <div class="row">
          <div class="col">
            <input type="text" class="form-control" id="email" placeholder="Nama Pembeli" 
            name="select_pembeli" value="{{app('request')->input('select_pembeli')}}">
          </div>

          <div class="col">
            <input type="text" class="form-control datepicker_class" placeholder="dari tanggal" 
            name="date_from_pembeli" value="{{app('request')->input('date_from_pembeli')}}">
          </div>

          <div class="col">
            <input type="text" class="form-control datepicker_class" placeholder="ke tanggal" 
            name="date_to_pembeli" value="{{app('request')->input('date_to_pembeli')}}">
          </div>

        </div>

        <br/>


        <div class="row">
          <div class="col">
            <select class="form-control" name="select_status">
              <option value="">  Select Status </option>
              <option value="1" <?php if(app('request')->input('select_status') == 1) echo "selected" ?>> Barang Masuk </option>
              <option value="2" <?php if(app('request')->input('select_status') == 2) echo "selected" ?>> Barang Keluar </option>
              <option value="3" <?php if(app('request')->input('select_status') == 3) echo "selected" ?>> Barang Retur </option>
              <option value="4" <?php if(app('request')->input('select_status') == 4 ) echo "selected" ?>> Barang Non-Active </option>
            </select>
          </div>

          <div class="col">
            <select class="form-control" name="select_limit">
              <option value="">  Select Limit </option>
              <option value="20" <?php if(app('request')->input('select_limit') == 20) echo "selected" ?>> 20 </option>
              <option value="50" <?php if(app('request')->input('select_limit') == 50) echo "selected" ?>> 50 </option>
              <option value="100" <?php if(app('request')->input('select_limit') == 100) echo "selected" ?>> 100 </option>
              <option value="200" <?php if(app('request')->input('select_limit') == 200) echo "selected" ?>> 200 </option>
            </select>
          </div>

          <div class="col">
            <select class="form-control" name="select_order">
              <option value="">  Select ORDER </option>
              <option value="asc" <?php if(app('request')->input('select_order') == "asc") echo "selected" ?>> oldest </option>
              <option value="desc" <?php if(app('request')->input('select_order') == "desc") echo "selected" ?>> newest </option>
            </select>
          </div>

        </div>

        <br/>

        <div class="row" >
          <button type="submit" class="btn btn-primary btn-block">Filter</button>
        </div>
      </form>
      @endif

      <div class="clearfix" style="margin-bottom: 10px"> </div>

      <a href="{{route('home')}}">
        <button type="button" id="btn_reset_filter"  class="btn btn-secondary btn-block" hidden="">
        Reset Filter
        </button>
      </a>

      <div class="clearfix" style="margin-bottom: 10px"> </div>

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
                    available
                  @elseif($val->status == 2) 
                    sold
                  @elseif($val->status == 3) 
                    retur
                  @elseif($val->status == 4) 
                    Non-Active
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


  var trigger =  "{{ app('request')->input('trigger') }}"
  var search =  "{{ app('request')->input('search') }}"
  
  if(trigger == "on" || search == "on" )  {
    $("#btn_reset_filter").attr('hidden',false);
  }

  var selected_item = [];

  function handleClick(id) {
    if (selected_item.includes(id)) {
      index = selected_item.indexOf(id);
      selected_item.splice(index,1);
    } else {
      selected_item.push(id);
    }


    var status =  "{{ app('request')->input('select_status') }}"

    if (status == null || status == 1) {
      $("#btn_submit_barang_keluar").attr('hidden',false);
    } else if (status == 2) {
      $("#btn_submit_barang_retur").attr('hidden',false);
    }else {
      $("#btn_submit_barang_keluar").attr('hidden',true);
      $("#btn_submit_barang_retur").attr('hidden',true);
    }

    
    $("#btn_reset_filter").attr('hidden',false);

    if(selected_item.length < 1) {
      $("#btn_submit_barang_keluar").attr('hidden',true);
    }

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
