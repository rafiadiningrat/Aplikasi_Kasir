@extends('layouts.master')

@section('content')

<h1 class="h3 mb-4 text-gray-1000">Detail Transaksi Pembelian</h1>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header text-align-center">
                Transaksi
            </div>
            <div class="card-body">
                <table cellpadding="1" class="table table-bordered">
                    <tr>
                        <th width="200px">ID Transaksi</th>
                        <td>{{$detil->id}}</td>
                        {{-- <td></td> --}}
                    </tr>
                    <tr>
                        <th>Waktu Transaksi</th>
                        <td>{{$detil->created_at}}</td>
                        {{-- <td></td> --}}
                    </tr>
                    <tr>
                        <th>Detail Produk</th>
                        <td><table cellpadding="1" class="table table-bordered">
                            <tr>
                                <th width="200px">ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Sub Total</th>
                            </tr>
                            @foreach($detil->transactions as $barangs)
                            @php
$sasa= \App\Models\master_barang::where('id', $barangs->master_barangs_id)->first()
                            @endphp
                            <tr>
                            <td>{{$barangs->master_barangs_id }}</td>
                            <td>{{$sasa->nama_barang }}</td>
                            <td>{{$barangs->jumlah }}</td>
                            <td>Rp. <?php echo number_format($barangs['harga_satuan'], 2, ',', '.'); ?></td>
                            <td>Rp. <?php echo number_format($barangs['harga_satuan'] * $barangs['jumlah'], 2, ',', '.'); ?></td>
                            </tr>
                            @endforeach
                        </table></td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td>Rp. <?php echo number_format($detil->total_harga, 2, ',', '.'); ?></td>
                    </tr>
                </table>
                <div>
                    <a href="/history" class="btn btn-danger">kembali ke riwayat</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

