<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi_pembelian_barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function products() {
        return $this->belongsTo(master_barang::class);
    }

    public function transaction_products() {
        return $this->belongsTo(transaksi_pembelian::class, 'transaksi_pembelian_id');
    }

    static function add_transaction_product($id_transaksi, $id, $jumlah, $harga_satuan) {
        transaksi_pembelian_barang::create([
            'transaksi_pembelian_id' => $id_transaksi,
            'master_barangs_id' => $id,
            'jumlah' => $jumlah,
            'harga_satuan' => $harga_satuan
        ]);
    }
}