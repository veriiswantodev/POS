<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Member;
use App\Models\Setting;
use App\Models\PenjualanDetail;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index(){
        $produk = Produk::orderBy('nama_produk')->get();
        $member = Member::orderBy('nama')->get();
        $diskon = Setting::first()->diskon ?? 0;

        // cek apakah ada transaksi yang aktif
        if($id_penjualan = session('id_penjualan')){
            $penjualan = Penjualan::find($id_penjualan);
            $memberSelected = Penjualan::find($id_penjualan)->member ?? new Member(); //cek apakah ada member atau tidak
            return view('penjualan_detail.index', compact('produk', 'member', 'id_penjualan', 'diskon', 'penjualan', 'memberSelected'));
        }else{
            if(auth()->user()->level){
                return redirect()->route('transaksi.baru');
            }else{
                return redirect()->route('dashboard');
            }
        }
    }

    public function data($id){
        $detail = PenjualanDetail::with('produk')
        ->where('id_penjualan', $id)
        ->get();

        $data = array();
        $total = 0;
        $total_item = 0;

        foreach($detail as $item){
            $row = array();
            $row['kode_produk'] = '<span class="bg-lime color-pallet">' .$item->produk['kode_produk']. '</span>';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_jual']  = 'Rp. ' . format_uang($item->harga_jual);
            $row['jumlah']      = '<input type="number" class="form-control form-control-sm rounded-0 quantity" data-id="'. $item->id_penjualan_detail .'" value="'. $item->jumlah .'">';
            $row['diskon']      = $item->diskon . ' %';
            $row['subtotal']    = 'Rp. ' .format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                        <button onclick="deleteData(`'. route('transaksi.destroy', $item->id_penjualan_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                    </div>
            ';
            $data[]             = $row;

            $total += $item->harga_jual * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'kode_produk' => '<div class="total hide">'. $total .'</div> <div class="total_item hide">'. $total_item .'</div>', 
            'nama_produk' => '',
            'harga_jual' => '',
            'jumlah' => '',
            'diskon' => '',
            'subtotal' => '',
            'aksi' => '',
        ];



        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);
    }
    
    public function store(Request $request){
        $produk = Produk::where('id_produk', $request->id_produk)->first();

        if(! $produk){
            return response()->json('Data Gagal Disimpan', 400);
        }

        $detail = new PenjualanDetail();
        $detail->id_penjualan = $request->id_penjualan;
        $detail->id_produk = $request->id_produk;
        $detail->harga_jual = $produk->harga_jual;
        $detail->jumlah = 1;
        $detail->diskon = 0;
        $detail->subtotal = $produk->harga_jual;
        $detail->save();

        return response()->json('Data Berhasil Disimpan', 200);
    }

    public function update(Request $request, $id){
        $detail = PenjualanDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_jual * $request->jumlah;
        $detail->update();
    }

    public function destroy($id){
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon = 0, $total, $diterima){
        $bayar = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0 ) ? $diterima - $bayar : 0;
        $data = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilan' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). 'Rupiah'),
        ];

        return response()->json($data);
    }
}
