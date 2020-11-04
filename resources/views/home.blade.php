@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="text-center"> Stock Barang </h1>

    <div class="table-responsive">
      <!-- Button to Open the Modal -->      
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
            <select  id="category_select" class="form-control" name="select_category">
              <option value="">  Select Kategori </option>
              @foreach($data['category'] as $key=>$val)
              <option value="{{$val->id}}" 
              <?php if(app('request')->input('select_category') == $val->id) {echo "selected";} ?>
              > 
              {{$val->name}} 
            </option>
              @endforeach
            </select>
          </div>

          <div class="col">
            <select id="merk_select" class="form-control" name="select_merk">
              <option value="">  Select Merk </option>
            </select>  
          </div>


          <div class="col">
            <select id="models_select" class="form-control" name="select_model">
              <option value="">  Select Model </option>
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
            <input type="text" class="form-control datepicker_class" placeholder="tgl barang masuk mulai" 
            name="date_from_penjual"  value="{{app('request')->input('date_from_penjual')}}">
          </div>

          <div class="col">
            <input type="text" class="form-control datepicker_class" placeholder="tgl barang masuk akhir" 
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
            <input type="text" class="form-control datepicker_class" placeholder="tgl barang keluar mulai" 
            name="date_from_pembeli" value="{{app('request')->input('date_from_pembeli')}}">
          </div>

          <div class="col">
            <input type="text" class="form-control datepicker_class" placeholder="tgl barang keluar akhir" 
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
              <option value="500" <?php if(app('request')->input('select_limit') == 500) echo "selected" ?>> 500 </option>
              <option value="1000" <?php if(app('request')->input('select_limit') == 1000) echo "selected" ?>> 1000 </option>
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
          <button type="submit" class="btn btn-info btn-block">Filter</button>
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


      <div class="btn btn-success btn-block" id="btn_submit_barang_keluar" onclick="submit_barang_keluar()" hidden="">
      submit barang keluar
      </div>

      <div class="btn btn-danger btn-block" id="btn_submit_barang_retur" onclick="submit_barang_retur()" hidden="">
      submit barang retur
      </div>

      <div class="btn btn-warning btn-block" id="btn_submit_barang_print" onclick="submit_print()" hidden="">
      print barang
      </div>

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
              <th> Kode Barang </th>
              <th> Penjual </th>
              <th> Pembeli </th>
              <th> Action </th>
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

                <td> 
                  @if(!app('request')->input('trigger') )
                  {{ ($data['stock']->currentpage()-1) 
                  * $data['stock']->perpage() + $key + 1 }}
                  @else
                    {{$no}}
                  @endif
                </td>
                <td> 
                  {{$val->category_name}}
                </td>
                <td>
                  {{$val->merk_name}}
                </td>
                <td>
                  {{$val->models_name}}
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
                <td class="<?php if($val->status == 2) {echo "text-danger";} ?>"> 
                  {{$val->barcode}} 
                </td>
                <td> {{$val->penjual}} </td>
                <td> {{$val->pembeli}} </td>
                <td>
                    @if($val->status != 4)
                    <div class="btn-group-vertical">


                      @if($val->status == 3 && Auth::user()->role == 2)
                      <button type="button" class="btn btn-warning" 
                      onclick='rollback_retur("{{$val->id}}","{{$val->barcode}}")'>
                        Rollback retur
                      </button>
                      @endif
      
                      <button type="button" class="btn btn-danger" 
                      onclick='delete_data("{{$val->id}}","{{$val->barcode}}")'>
                        Delete
                      </button>

                    </div>
                    @endif
                </td>
                </tr>
                <?php $no++; ?>
              @endforeach
            @endif

          </tbody>
        </table>
       
  </div>
  @if(!app('request')->input('trigger') )

    <div class="float-right" style="margin-top: 12px!important"> 
      <p class="float-right">
        Showing {{($data['stock']->currentpage()-1)*$data['stock']->perpage()+1}} to {{$data['stock']->currentpage()*$data['stock']->perpage()}}
        of  {{$data['stock']->total()}} entries
      </p>
      <div class="clearfix"> </div> 
      {{ $data['stock']->appends(
          [
          'search' => Request::get('search'),
          'select_barcode' => Request::get('select_barcode'),
          'select_category' => Request::get('select_category'),
          'select_merk' => Request::get('select_merk'),
          'select_model' => Request::get('select_model'),
          'select_penjual' => Request::get('select_penjual'),
          'date_from_penjual' => Request::get('date_from_penjual'),
          'date_to_penjual' => Request::get('date_to_penjual'),

          'select_pembeli' => Request::get('select_pembeli'),
          'date_from_pembeli' => Request::get('date_from_pembeli'),
          'date_to_pembeli' => Request::get('date_to_pembeli'),
          'select_status' => Request::get('select_status'),

          'select_limit' => Request::get('select_limit'),

          ])

      ->links() }}
    </div>
    <div class="clearfix"> </div>
  @endif


</div>


<script type="text/javascript">
  
  function rollback_retur(id,name) {
    if (confirm('Apakah anda yakin ingin rollback data '+name+' ke barang keluar ?')) {
      window.location = "{{route('stock.rollback_retur')}}?id="+id;
    }
  }

  function delete_data(id,name) {
    if (confirm('Apakah anda yakin ingin menghapus data '+name+' ?')) {
      window.location = "{{route('stock.delete_stock')}}?id="+id;
    }
  }

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
            //alert(response.messages);
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
            //alert(response.messages);
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

    if (!status || status == 1) {
      $("#btn_submit_barang_keluar").attr('hidden',false);
    } else if (status == 2) {
      $("#btn_submit_barang_retur").attr('hidden',false);
    }else {
      $("#btn_submit_barang_keluar").attr('hidden',true);
      $("#btn_submit_barang_retur").attr('hidden',true);
    }

    
    $("#btn_reset_filter").attr('hidden',false);
    $("#btn_submit_barang_print").attr('hidden',false);

    if(selected_item.length < 1) {
      $("#btn_submit_barang_keluar").attr('hidden',true);
      $("#btn_submit_barang_print").attr('hidden',true);
    } 

    console.log(selected_item);
  }


  function submit_print() {
    if(selected_item.length > 0) {
      window.location = "{{ route('stock.print_stock')}}?stock="+selected_item;
    } else {
      alert("pilih barang terlebih dahulu;");
    }
  }

  function submit_barang_keluar() {

    if(selected_item.length > 0) {
      window.location = "{{ route('barangkeluar.create')}}?stock="+selected_item;
    } else {
      alert("pilih barang terlebih dahulu;");
    }
  }



  function submit_barang_retur() {

    if(selected_item.length > 0) {
      window.location = "{{ route('barangretur.create')}}?stock="+selected_item;
    } else {
      alert("pilih barang terlebih dahulu;");
    }
  }

</script>
@endsection
