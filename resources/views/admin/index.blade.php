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
                  <div class="btn btn-danger" onclick='set_rule("{{$val->id}}")'>
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

<style type="text/css">
  .disabled{
    pointer-events: none;
    background-color: gray
  }
</style>
<script type="text/javascript">
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


  function aktifkan_rule(user_id,rule_id,index) {
    data_raw =  {rule_id:rule_id,user_id:user_id};
    $.ajax({
      type : "POST",
      url: " {{ route('ajax.aktifkan_rule_user') }}",
      contentType: "application/json",
      data : JSON.stringify(data_raw),
      success: function(result) {
        console.log(result);
        response = JSON.parse(result);
        if(response.error) {
            alert(response.messages);
        } else {
          $('#id_rule_btn_'+index).attr('hidden',true);
          $('#tr_id_rule_btn_'+index).removeClass('table-danger');
          $('#tr_id_rule_btn_'+index).addClass('table-success');
          $('#td_id_rule_status_'+index).html('Yes');
        }
      },
      error: function( jqXhr, textStatus, errorThrown ){
        console.log( errorThrown );
      }
    });
  }

  function matikan_rule(user_id,rule_id,index) {
    data_raw =  {rule_id:rule_id,user_id:user_id};
    $.ajax({
      type : "POST",
      url: " {{ route('ajax.matikan_rule_user') }}",
      contentType: "application/json",
      data : JSON.stringify(data_raw),
      success: function(result) {
        console.log(result);
        response = JSON.parse(result);
        if(response.error) {
          alert(response.messages);
        } else {
          $('#id_rule_btn_'+index).attr('hidden',true);
          $('#tr_id_rule_btn_'+index).removeClass('table-success');
          $('#tr_id_rule_btn_'+index).addClass('table-danger');
          $('#td_id_rule_status_'+index).html('No');
        }
      },
      error: function( jqXhr, textStatus, errorThrown ){
        console.log( errorThrown );
      }
    });
  }

  function set_rule(id) {
    data_raw =  {id:id};
    $("#tbody_admin_modal_info").empty();

    $.ajax({
      type : "POST",
      url: " {{ route('ajax.get_user_rule') }}",
      contentType: "application/json",
      data : JSON.stringify(data_raw),
      success: function(result) {
          console.log(result);
          response = JSON.parse(result);

          if(response.error) {
            alert(response.messages);
          } else {
            append_tag = '';
            $.each(response.data, function( index, value ) {

              rule_status = "-";
              button_action = "-";
              if(value.rule_status == 1) {
                rule_status = "Yes";
                rule_class="table-success";
                button_action = '<div id="id_rule_btn_'+index+'" class="btn btn-danger"'+
                ' onclick="matikan_rule('+value.user_id+','+value.rule_id+','+index+')" '+
                '> matikan </div>'
              } else {
                rule_status = "No";
                rule_class="table-danger";
                button_action = '<div id="id_rule_btn_'+index+'" class="btn btn-success"'+
                ' onclick="aktifkan_rule('+value.user_id+','+value.rule_id+','+index+')" '+
                '> aktifkan </div>'
              }


              append_tag += '<tr id="tr_id_rule_btn_'+index+'" class="'+rule_class+'">';

              append_tag += "<td>";
              append_tag += value.rule_name;
              append_tag += "</td>";

              append_tag += '<td id="td_id_rule_status_'+index+'">';
              append_tag += rule_status;
              append_tag += "</td>";

              append_tag += "<td>";
              append_tag += button_action;
              append_tag += "</td>";

              append_tag += "</tr>";
            });
            $('#tbody_admin_modal_info').html(append_tag);
            $('#myModal').modal('show');
          }
      },
      error: function( jqXhr, textStatus, errorThrown ){
              console.log( errorThrown );
          }
    });
  }

</script>

@include('admin.modal_info')

@endsection