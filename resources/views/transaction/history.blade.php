@extends('layouts.master')

@section('content')

<h1 class="h3 mb-4 text-gray-1000">Daftar Transaksi Pembelian</h1>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header text-align-center">
                Transaksi
            </div>
            <div class="card-body">
                <table class="table justify-center">
                    <thead>
                    <tr>
                        <th scope="col">ID Transaksi</th>
                        <th scope="col">Waktu transaksi</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td>Rp. <?php echo number_format($transaction->total_harga, 2, ',', '.'); ?></td>
                                <td><a href='/detail_transaction/{{ $transaction->id }}'
                                        class="btn btn-success">Detail Belanja</a></td>
                            </tr>
                    </tbody>
                        @endforeach
                </table>
                <div>
                    <a href="/transaction" class="btn btn-danger">kembali belanja</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

