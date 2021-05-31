<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Penjualan;
use App\Models\StockObat;
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
    public function index(Request $request)
    {
        $obat = StockObat::join()->get();
        $kwitansi = $request->id;
        $data = Penjualan::where('kwitansi', $kwitansi)->get();
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

        return view('owner.Penjualan', compact('obat','data'));
    }


    public function getObat(Request $request)
    {
        $data = StockObat::where('obat_id',$request->id)->first();
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
            'kwintansi' => 'required',
            'qty' => 'required',
            'total_harga' => 'required',
        ];

        $message = [
            'nama_pasien.required' => 'Nama pasien Tidak Boleh Kosong!',
            'telp.required' => 'Kolom Telpon Tidak Boleh Kosong!',
            'alamat.required' => 'Kolom alamat Tidak Boleh Kosong!',
            'obat_id.required' => 'Kolom obat Tidak Boleh Kosong!',
            'kwintasi.required' => 'Kolom  kwintasi Tidak Boleh Kosong!',
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
            'kwitansi' => $request->kwintansi,
            'tanggal' =>  date('Y-m-d'),
            'qty' => $request->qty,
            'harga' => $request->qty,
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

            return response()->json(['message' => 'Transaksi Berhasil!'],200);
        }else{
            return response()->json(['message' => 'Transaksi Gagal!'],200);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjulan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjulan)
    {
        //
    }
}
