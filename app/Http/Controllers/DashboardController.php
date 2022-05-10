<?php

namespace App\Http\Controllers;

use App\Models\{
    Kategori,
    Produk,
    Supplier,
    Member,
    Penjualan,
    Pembelian,
    Pengeluaran
};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $kategori = Kategori::count();
        $produk = Produk::count();
        $suplier = Supplier::count();
        $member = Member::count();

        $tgl_awal = date('Y-m-01');
        $tgl_akhir = date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan = array();

        while(strtotime($tgl_awal) <= strtotime($tgl_akhir)){
            $data_tanggal[] = (int) substr($tgl_awal, 8, 2);

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tgl_awal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tgl_awal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tgl_awal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan[] += $pendapatan;

            $tgl_awal = date('Y-m-d', strtotime("+1 day", strtotime($tgl_awal)));
        }

        if(auth()->user()->level == 1){
            return view('admin.dashboard', compact('kategori', 'produk', 'suplier', 'member', 'tgl_awal', 'tgl_akhir', 'data_tanggal', 'data_pendapatan'));
        } else {
            return view('kasir.dashboard');
        }
    }
}
