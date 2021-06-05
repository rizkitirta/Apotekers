<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Penjualan;
use App\Models\StockObat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obat = StockObat::join()->get();
        $tanggal = Carbon::now()->format('Y-m-d');
        $now = Carbon::now();
        $thn_bulan = $now->year . $now->month;
        $cek_number = Penjualan::count();
        if ($cek_number == 0) {
            $no_urut = 1001;
            $number = 'NT' . $thn_bulan . $no_urut;
            //dd($number);
        } else {
            $get =  Penjualan::all()->last();
            $no_urut = (int)substr($get->kwitansi, -4) + 1;
            $number = 'NT' . $thn_bulan . $no_urut;
        }

        //NT202141001
        return view('owner.Penjualan', compact('obat', 'tanggal', 'number'));
    }

    public function dataTable(Request $request)
    {
        $kwitansi = $request->id;
        $data = DB::table('penjualans')->where('kwitansi', $kwitansi)
            ->join('obats', 'penjualans.item_id', 'obats.id')
            ->select('penjualans.*', 'obats.nama')
            ->latest();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = '<button class="edit btn btn-primary btn-sm" id="' . $data->id . '" name="edit" ><i class="fas fa-edit"></i></button>';
                    $button .= '<button class="hapus btn btn-danger btn-sm ml-1" id="' . $data->id . '" name="hapus"><i class="fas fa-trash-alt"></i></button>';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }


    public function getObat(Request $request)
    {
        $data = StockObat::where('obat_id', $request->id)->first();
        $null = [
            'stock' => 0
        ];

        if ($data != null) {
            return response()->json(['data' => $data]);
        } else {
            return response()->json(['data' => $null]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_pasien' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'obat_id' => 'required',
            'kwitansi' => 'required',
            'qty' => 'required',
            'total_harga' => 'required',
        ];

        $message = [
            'nama_pasien.required' => 'Nama pasien Tidak Boleh Kosong!',
            'telp.required' => 'Kolom Telpon Tidak Boleh Kosong!',
            'alamat.required' => 'Kolom alamat Tidak Boleh Kosong!',
            'obat_id.required' => 'Kolom obat Tidak Boleh Kosong!',
            'kwitansi.required' => 'Kolom  kwitansi Tidak Boleh Kosong!',
            'qty.required' => 'Kolom qty Tidak Boleh Kosong!',
            'total_harga.required' => 'Kolom Total harga Tidak Boleh Kosong!',
        ];


        $validasi = Validator::make($request->all(), $rules, $message);
        if ($validasi->fails()) {
            return response()->json(['message' => $validasi->errors()->first()], 422);
        }

        $pasien = [
            'nama_pasien' => $request->nama_pasien,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'no_resep' => $request->no_resep,
            'pengirim' => $request->pengirim,
        ];

        $consumer = Pasien::create($pasien);
        $pasien_id = $consumer->id;

        $penjualan = [
            'kwitansi' => $request->kwitansi,
            'tanggal' =>  date('Y-m-d'),
            'qty' => $request->qty,
            'harga' => $request->harga,
            'diskon' => $request->diskon,
            'sub_total' => $request->total_harga,
            'item_id' => $request->obat_id,
            'consumer_id' => $pasien_id,
            'user_id' => Auth::user()->id
        ];

        $transaksi = Penjualan::create($penjualan);
        if ($transaksi) {
            $stock = StockObat::where('obat_id', $request->obat_id)->first();
            $stock_old = $stock->stock;
            $stock_now = $stock_old - $request->qty;
            $stock->update(['stock' => $stock_now]);

            return response()->json(['message' => 'Transaksi Berhasil!'], 200);
        } else {
            return response()->json(['message' => 'Transaksi Gagal!'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjulan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjulan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjulan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjulan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjulan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjulan)
    {
        //
    }


    //Hapus Order
    public function hapusOrder(Request $request)
    {
        $id = $request->id;
        $hapusItem = Penjualan::find($id);
        $old_stock = StockObat::where('obat_id', $hapusItem->item_id)->first();
        $new_stock = $hapusItem->qty + $old_stock->stock;
        $old_stock->update(['stock' => $new_stock]);

        if ($old_stock) {
            $hapusOrder = $hapusItem->delete();
            return response()->json(['message'=>'Data berhasil dihapus!'], 200);
        } else {
            return response()->json(['message'=>'Data gagal dihapus!']);
        }
    }
}
