@extends('layouts.main')

@section('content')
<div class="container">
  
  <h1 class="text-center"> Barang Keluar </h1>
  <div class="table-responsive">
      <!-- Button to Open the Modal -->


      <table class="table table-bordered" style="margin-top: 10px">
          <thead>
            <tr>
              <th> No </th>
              <th>Tgl Keluar </th>
              <th>Jumlah barang</th>
              <th>Pembeli</th>
              <th>No Hp Pembeli</th>
              <th> Garansi</th>
              <th> Total </th>
              <th>Created At</th>
              <th> Info </th>
            </tr>
          </thead>
          <tbody>
            @if (count($data['barangkeluar']) == 0 ) 
              <td colspan="10" class="text-center"> 
                - 
              </td>
            @else
              <?php $no = 1; ?> 
              @foreach($data['barangkeluar'] as $key=>$val)
              <tr> 
                <td> {{$no}} </td>
                <td> {{$val->tgl_penjualan}} </td>
                <td> {{$val->jumlah_barang}} </td>

                <td> {{$val->pembeli}} </td>
                <td> {{$val->no_hp_pembeli}} </td>
                <td> {{$val->durasi_garansi}} </td>
                <td> {{$val->total_harga}} </td>
                <td> {{$val->created_at}} </td>
                <td> <button class="btn btn-primary" onclick="check_data('{{$val->uuid}}')">check data</button></td>
              </tr>
              <?php $no++; ?>
              @endforeach
            @endif
          </tbody>
        </table>
  </div>

</div>
@endsection

<script type="text/javascript">

  function check_data(uuid) {
   window.open("{{ route('home')}}?trigger=on&trigger_from=barang_keluar&uuid="+uuid)
  }

</script>