<?php

namespace App\Http\Controllers;

use App\Models\Penjulan;
use App\Models\StockObat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjulanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $obat = StockObat::join()->get();
        $data = Penjulan::all();
        if ($request->ajax()) {
            return DataTables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = '<button class="edit btn btn-primary btn-sm" id="' . $data->id . '" name="edit" ><i class="fas fa-edit"></i></button>';
                    $button .= '<button class="hapus btn btn-danger btn-sm ml-1" id="' . $data->id . '" name="hapus"><i class="fas fa-trash-alt"></i></button>';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('owner.Penjualan', compact('obat'));
    }


    public function getObat(Request $request)
    {
        $data = StockObat::find($request->id)->first();
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
            'no_resep' => 'required',
            'pengirim' => 'required',

            'obat_id' => 'required',
            'kwintansi' => 'required',
            'tanggal' => 'required',
            'qty' => 'required',
            'beli' => 'required',
            'expired' => 'required',
            'stock_akhir' => 'required',
            'keterangan' => 'required',
        ];

        $message = [
            'obat_id.required' => 'Kolom obat Tidak Boleh Kosong!',
            'masuk.required' => 'Kolom stok masuk Tidak Boleh Kosong!',
            'keluar.required' => 'Kolom stok keluar Tidak Boleh Kosong!',
            'jual.required' => 'Kolom harga jual Tidak Boleh Kosong!',
            'beli.required' => 'Kolom harga beli Tidak Boleh Kosong!',
            'expired.required' => 'Kolom expired Tidak Boleh Kosong!',
            'stock_akhir.required' => 'Kolom stock akhir Tidak Boleh Kosong!',
            'keterangan.required' => 'Kolom Keterangan Tidak Boleh Kosong!',
        ];

        $validasi = Validator::make($request->all(), $rules, $message);
        if ($validasi->fails()) {
            return response()->json(['message' => $validasi->errors()->first()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjulan  $penjulan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjulan $penjulan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjulan  $penjulan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjulan $penjulan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjulan  $penjulan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjulan $penjulan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjulan  $penjulan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjulan $penjulan)
    {
        //
    }
}
