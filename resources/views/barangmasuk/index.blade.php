@extends('layouts.app')

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
            </tr>
          </thead>
          <tbody>
            
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

          <form method="POST" action="">
          {{ csrf_field() }}
            <div class="form-group">
              <label for="staff_nama"> 
                Tanggal Pembelian :
              </label>
              <input type="text" class="form-control datepicker_class" value="" required="">

            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Payment Detail :
              </label>
              <input class="form-control" type="text" id="payment_detail" name="payment_detail"
              placeholder="eg : Giro no BRI-XXX, BCA-XXX">
            </div>

            <button type="submit" class="btn btn-block btn-danger">
              UPDATE INVOICE STATUS
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
@endsection

