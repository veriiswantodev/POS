<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Pengeluaran;

class LaporanController extends Controller
{
    public function index(Request $request){
        $tgl_awal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tgl_akhir = date('Y-m-d');

        if($request->has('tgl_awal') && $request->tgl_awal != "" && $request->has('tgl_akhir') && $request->tgl_akhir != ""){
            $tgl_awal = $request->tgl_awal;
            $tgl_akhir = $request->tgl_akhir;
        }

        return view('laporan.index', compact('tgl_awal', 'tgl_akhir'));
    }

    public function data($awal, $akhir){
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $total_pendapatan = 0;

        while(strtotime($awal) <= strtotime($akhir)){
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $total_pendapatan += $pendapatan;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tgl_ID($tanggal, false);
            $row['penjualan'] = format_uang($total_penjualan);
            $row['pembelian'] = format_uang($total_pembelian);
            $row['pengeluaran'] = format_uang($total_pengeluaran);
            $row['pendapatan'] = format_uang($pendapatan);

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'penjualan' => '',
            'pembelian' => '',
            'pengeluaran' => 'Total Pendapatan',
            'pendapatan' => format_uang($total_pendapatan)
        ];

       return datatables()
            ->of($data)
            ->make(true);
    }
}
