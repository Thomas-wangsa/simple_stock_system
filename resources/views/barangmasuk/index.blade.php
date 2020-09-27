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
                <td> <button class="btn btn-primary" onclick="alert('on progress')">check data</button></td>
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
              <select class="form-control" name="kategori" required="">
                <option value="1"> AC </option>
              </select>
            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Merk : 
              </label>
              <select class="form-control" name="merk" required="">
                <option value="1"> Sharp </option>
                <option value="2"> Daikin </option>
              </select>
            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Model : 
              </label>
              <select class="form-control" name="model" required="">
                <option value="1"> R32 </option>
                <option value="2"> R410 </option>
              </select>
            </div>

            <div class="form-group">
              <label for="staff_nama"> 
                Penjual :
              </label>
              <input type="text" class="form-control" name="penjual" required="">

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
@endsection

