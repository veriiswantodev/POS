<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Supplier;

class PembelianController extends Controller
{
    public function index(){
        $supplier = Supplier::orderBy('nama')->get();

        return view('pembelian.index', compact('supplier'));
    }

    public function create($id){
        $pembelian = new Pembelian();
        $pembelian->id_suplier = $id;
        $pembelian->total_item = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon = 0;
        $pembelian->bayar = 0;

        session(['id_pembelian' => $pembelian->id_pembelian]);
        session(['id_suplier' => $pembelian->id_suplier]);

        return redirect()->route('pembelian_detail.index');
    }
}
