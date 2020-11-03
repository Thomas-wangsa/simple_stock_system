<!-- The Modal -->
<div class="modal fade" id="modal_add_support_barang">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h4 class="text-center"> Tambah Barang </h4> 

        <br/> 

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


        <div class="table-responsive">
          <table class="table table-bordered" style="margin-top: 10px">
          <thead>
            <tr>
              <th> No </th>
              <th>Model</th> 
              <th>Status</th>
              <th>Kode Barang</th>
              <th>Action</th>   
            </tr>
          </thead>
          <tbody id="tbody_tambah_barang">
          </tbody>
        </table>

        </div>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<script type="text/javascript">

  var current_param = "{{ app('request')->input('stock') }}";

  function tambah_barang_modal(new_param) {
      
      var selected_item = current_param + "," + new_param
      window.location = "{{ route('barangkeluar.create')}}?stock="+selected_item;
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
      $("#tbody_tambah_barang").empty();
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
      $('#models_select').find('option').remove();
      $("#tbody_tambah_barang").empty();
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


    $('#models_select').on('change', function() {
      $("#tbody_tambah_barang").empty();
      if(this.value == undefined || this.value == "") {
        return;
      }

      data_raw =  {
        models_id:this.value,
        current_stock:current_param
      };
      $.ajax({
        type : "POST",
        url: " {{ route('ajax.get_stock_from_models_id') }}",
        contentType: "application/json",
        data : JSON.stringify(data_raw),
        success: function(result) {
          console.log(result);
          response = JSON.parse(result);
          if(response.error == true) {
            alert(response.messages);
          } else {
            append_tag = "";
            $.each(response.data, function( index, value ) {

              status = "-";
              if(value.status == 1) {
                status = "available";
              } else if (value.status == 2) {
                status = "sold";
              } else if (value.status == 3) {
                status = "retur";
              } else if (value.status == 4) {
                status = "non-active";
              }

              append_tag += "<tr>";
              append_tag += "<td>" + (index+1) + "</td>";
              append_tag += "<td>" + value.model_name + "</td>";
              append_tag += "<td>" + status + "</td>";
              append_tag += "<td>" + value.barcode + "</td>";

              append_tag += "<td>";
              append_tag += "<button class='btn btn-block btn-warning' onclick='tambah_barang_modal("+value.id+")' >";
              append_tag += "tambah barang";
              append_tag += "</button>";
              append_tag += "</td>";

              append_tag += "</tr>";
            });
            $("#tbody_tambah_barang").html(append_tag);
          }
        },  
        error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
        }
      }); 
    });




  });
</script>