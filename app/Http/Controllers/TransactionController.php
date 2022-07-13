<?php

namespace App\Http\Controllers;
use App\Models\master_barang;
use App\Models\transaksi_pembelian;
use App\Models\transaksi_pembelian_barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller{

    public function store()
    {
        return view('transaction.create', [
            'products'=> master_barang::all(),
            'cart' => session("cart")
        ]);
    }

    public function index() {
        return view('transaction.history', [
            'title' => 'History Transaction',
            'active' => 'history',
            'data' => transaksi_pembelian::all()
        ]);
    }

   public function addCart(Request $request){
	
    $validatedData = $request->validate([
        'prod_id' => 'required',
        'name' => 'required',
        'price' => 'required',
        'total' => 'required|integer|min:1'
    ]);

    $cart = session('cart');
    if (!empty($cart)) {
        foreach ($cart as $ct => $val) {
            if ($val['nama_barang'] == $validatedData['name'] || $val['id'] == $validatedData['prod_id'] || $val['harga_satuan'] == $validatedData['price']) {
                $validatedData['total'] += $val['jumlah'];
            }
        }
    }

    $cart[$validatedData['prod_id']] = [
        'id' => $validatedData['prod_id'],
        'nama_barang' => $validatedData['name'],
        'harga_satuan' => $validatedData['price'],
        'jumlah' => $validatedData['total']
    ];

 session(['cart' => $cart]);

    return back();
        
    }

    public function updatetocart(Request $request)
    {
        $quantity = $request->input('quantity');
        $product_id = $request->input('product_id');

        if(Cookie::get('shopping_cart'))
        {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);

            $item_id_list = array_column($cart_data, 'jumlah');
            $prod_id_is_there = $prod_id;

            if(in_array($prod_id_is_there, $item_id_list))
            {
                foreach($cart_data as $keys => $values)
                {
                    if($cart_data[$keys]["jumlah"] == $prod_id)
                    {
                        $cart_data[$keys]["item_quantity"] =  $quantity;
                        $item_data = json_encode($cart_data);
                        $minutes = 60;
                        Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                        return response()->json(['status'=>'"'.$cart_data[$keys]["nama_barang"].'" Quantity Updated']);
                    }
                }
            }
        }
    }

    public function save($totalHarga){

    
        $cart = session('cart');
        if(empty($cart)) {
            return back()->with('failed', 'Pilih produk terlebih dahulu!');
        }

        $id_transaksi = transaksi_pembelian::add_transaction($totalHarga);
        foreach ($cart as $c => $val) {
            $id = $c;
            $jumlah = $val['jumlah'];
            $harga_satuan = $val['harga_satuan'];
            transaksi_pembelian_barang::add_transaction_product($id_transaksi, $id, $jumlah, $harga_satuan);
        }

        session()->forget('cart');

        return redirect('/history');
    }

    public function detail_transaction($id){
        return view('transaction.detail', [
            'title' => 'History Transaction',
            'active' => 'history',
            'detil' => transaksi_pembelian::firstWhere('id', $id)
        ]);
    }

    public function detailBarang($id) {
        return view('transaction.detail', [
            'title' => 'Detail Transaction',
            'active' => 'detail',
            'detail_barang' => master_barang::where('id', $id)
        ]);
    }
}