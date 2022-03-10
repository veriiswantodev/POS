<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Produk;
use App\Models\Supplier;
use App\Models\PembelianDetail;

class PembelianDetailController extends Controller
{
    public function index(){
        $id_pembelian = session('id_pembelian');
        $produk = Produk::orderBy('kode_produk', 'desc')->get();
        $supplier = Supplier::find(session('id_suplier'));

        if (! $supplier) {
            abort(404);
        }

        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier'));
    }

    public function store(Request $request){
        $produk = Produk::where('id_produk', $request->id_produk)->first();

        dd ($request->id_pembelian);

        if(! $produk){
            return response()->json('Data Gagal Disimpan', 400);
        }

        $detail = new PembelianDetail();
        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $request->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->subtotal = $produk->harga_beli;
        $detail->save();

        return response()->json('Data Berhasil Disimpan', 200);
    }
}
