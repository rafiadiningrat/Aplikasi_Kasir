@extends('layouts.master')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Transaksi Baru</h1>

    <div class="row mx-auto">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    Tambah Produk
                </div>
                <div class="card-body">
                    <form action="/addCart" method="POST">
                        @csrf
                    <label for="prod_id">ID Barang</label>
                    <select class="select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="prod_id" id="prod_id">
                        <option value=""></option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->id }}</option>
                        @endforeach
                    </select>
                    <label for="name">Nama Barang</label><br>
                        <input style="width: 100%; background-color:#F2F2F2" type="text" id="name" name="name" readonly value=""><br>
                        <label for="price">Harga Barang</label><br>
                        <input style="width: 100%; background-color:#F2F2F2" type="text" id="price" name="price" value="" readonly>
                        <label for="total">Jumlah Barang</label><br>
                        <input style="width: 100%;" type="text" id="total" name="total" value="">
                        <input style="background-color:#6666ff" type="submit" name="submit" value="Tambah Keranjang" class="mt-2">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    Informasi Produk
                </div>
                @php
                $totalHarga = 0;
            @endphp
        <table class="table shopping-summery table-striped" style="margin-top: 20px;">
            <thead>
                <tr class="main-hading">
                    <th>ID PRODUK</th>
                    <th>NAMA PRODUK</th>
                    <th class="text-center" width="130px">JUMLAH</th>
                    <th class="text-center">HARGA SATUAN</th>
                    <th class="text-center">TOTAL HARGA</th> 
                    <th class="text-center"><i class="bi bi-trash-fill"></i></th>
                </tr>
            </thead>
            <tbody>
                @if (empty($cart) || count($cart) == 0)
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada produk</td>
                    </tr>
                @else
                @foreach ($cart as $ct => $val)
                <tr class="cartpage">
                    <td>{{ $val['id'] }}</td>
                    <td>{{ $val['nama_barang'] }}</td>
                    {{-- <td></td> --}}
                    <td class="cart-product-quantity" width="130px"><div class="input-group quantity">
                        <input type="hidden" class="product_id" value="{{ $val['jumlah'] }}">
                        <div class="input-group-prepend decrement-btn changeQuantity" style="cursor: pointer">
                            <span class="input-group-text">-</span>
                        </div>
                        <input type="text" class="qty-input form-control" maxlength="2" max="10" value="{{ $val['jumlah'] }}">
                        <div class="input-group-append increment-btn changeQuantity" style="cursor: pointer">
                            <span class="input-group-text">+</span>
                        </div>
                    </div>
                </td>
                    <td>Rp. <?php echo number_format($val['harga_satuan'], 2, ',', '.'); ?></td>
                    {{-- <td></td> --}}
                    <td>Rp. <?php echo number_format($val['harga_satuan'] * $val['jumlah'], 2, ',', '.'); ?></td>
                    {{-- <td class="text-center">
                        <a href="/delete/{{ $val['id_produk'] }}"
                            class="badge bg-danger text-white text-center"><i class="bi bi-x-circle"></i></a>
                    </td> --}}
                </tr>
                @php
                    $totalHarga += $val['harga_satuan'] * $val['jumlah'];
                @endphp
            @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">TOTAL HARGA</td>
                    <td>
                        @if (empty($cart) || count($cart) == 0)
                Rp. 0
            @else
                Rp. <?php echo number_format($totalHarga, 2, ',', '.'); ?>
            @endif
                    </td>
                </tr>
            </tfoot>
        </table>
            <div class="d-flex  mb-4">
                <a href="/save/{{$totalHarga}}" class="btn btn-warning ml-4"> simpan </a>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('change', '#prod_id',function () {
			var p_id=$(this).val();
			var a=$(this).parent();
			console.log(p_id);
			var op="";
			$.ajax({
				type:'GET',
				url:'/findProductId',
				data:{'id':p_id},
				dataType:'json',//return data will be json
				success:function(data){
                    console.log(data);
                $('#name').val(data.nama_barang);
                $('#price').val(data.harga_satuan);

					// here price is coloumn name in products table data.coln name


				},
				error:function(){

				}
			});


		});

        $('.increment-btn').click(function (e) {
            e.preventDefault();
            var incre_value = $(this).parents('.quantity').find('.qty-input').val();
            var value = parseInt(incre_value, 10);
            value = isNaN(value) ? 0 : value;
            if(value<10){
                value++;
                $(this).parents('.quantity').find('.qty-input').val(value);
            }

        });

        $('.decrement-btn').click(function (e) {
            e.preventDefault();
            var decre_value = $(this).parents('.quantity').find('.qty-input').val();
            var value = parseInt(decre_value, 10);
            value = isNaN(value) ? 0 : value;
            if(value>1){
                value--;
                $(this).parents('.quantity').find('.qty-input').val(value);
            }
        });

        $('.changeQuantity').click(function (e) {
            e.preventDefault();

            var quantity= $(this).closest(".cartpage").find('.qty-input').val();
            var product_id = $(this).closest(".cartpage").find('.product_id').val();

            data = {
                'quantity':quantity,
                'product_id':product_id
            };

            $.ajax({
                url: '/update-to-cart',
                type: 'POST',
                data: data,
                success: function (response) {
                    window.location.reload();
                    alertify.set('notifier','position','top-right');
                    alertify.success(response.status);
                }
            });
        });

	});
</script>


@endsection
