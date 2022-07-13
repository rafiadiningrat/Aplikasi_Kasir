@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
                <div class="">
                    <a class="btn btn-success btn-circle btn-sm" href="#" role="button">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Harga Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->nama_barang }}</td>
                                <td>{{ $product->harga_satuan }}</td>
                                {{-- <td class="d-flex justify-content-center">
                                    <a class="btn btn-warning btn-circle btn-sm" href="{{ route('product.edit', $product->id) }}" role="button">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('product.destroy', $product->id) }}}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger ml-1 btn-circle btn-sm"
                                            onclick="return confirm('Yakin mau dihapus?');"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td> --}}
                            </tr>
                            @empty
                            <tr>
                                <td>Tidak ada data yang ditemukan</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection