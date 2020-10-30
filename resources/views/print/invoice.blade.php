<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body{
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:#333;
            text-align:left;
            font-size:18px;
            margin:0;
        }
        .container{
            margin:0 auto;
            margin-top:35px;
            padding:40px;
            width:750px;
            height:auto;
            background-color:#fff;
        }
        caption{
            font-size:28px;
            margin-bottom:15px;
        }
        table{
            border:1px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            width:740px;
        }
        td, tr, th{
            padding:12px;
            border:1px solid #333;
            width:185px;
        }
        th{
            background-color: #f0f0f0;
        }
        h4, p{
            margin:0px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <caption>
                Kwitansi
            </caption>
            <thead>
                <tr>
                    <th colspan="2"> 
                        Nomor Kwitansi <strong> {{$data['barang_keluar']->id}}</strong>
                    </th>
                    <th colspan="1"> Garansi : 
                        <strong> {{$data['barang_keluar']->durasi_garansi}} bulan </strong>
                    </th>
                    <th colspan="2"> {{$data['barang_keluar']->tgl_penjualan}} </th>
                </tr>
                <tr>
                    <td colspan="5">
                        <h4>Pelanggan: </h4>
                        <p> {{$data['barang_keluar']->pembeli}} <br>
                        {{$data['barang_keluar']->no_hp_pembeli}} <br>
                        </p>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="2">Barcode</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
                @foreach($data['stock'] as $key=>$val) 
                <tr>
                    <td colspan="2"> {{$val->barcode}} </td>
                    <td> 1 </td>
                    <td> {{$val->harga_jual}} </td>
                    <td>{{$val->harga_jual}}</td>
                </tr>
                @endforeach
                
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <td colspan="2">Rp. {{$data['barang_keluar']->total_harga}} </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
