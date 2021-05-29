<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StockObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockObatController extends Controller
{
    public function index(Request $request)
    {
        $obat = Obat::where('ready', 'N')->get();
        $data = StockObat::join()->get();
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

        return view('owner.StockObat', compact('obat', 'data'));
    }

    public function store(Request $request)
    {
        $rules = [
            'obat_id' => 'required',
            'masuk' => 'required',
            'keluar' => 'required',
            'jual' => 'required',
            'beli' => 'required',
            'expired' => 'required',
            'stock_akhir' => 'required',
            'keterangan' => 'required',
        ];

        $message = [
            'obat_id.required' => 'Obat Tidak Boleh Kosong!',
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

        $data = new StockObat();
        $data->obat_id = $request->obat_id;
        $data->masuk = $request->masuk;
        $data->keluar = $request->keluar;
        $data->jual = $request->jual;
        $data->beli = $request->beli;
        $data->expired = $request->expired;
        $data->stock = $request->stock_akhir;
        $data->keterangan = $request->keterangan;
        $data->user_id = Auth::user()->id;

        $simpan = $data->save();
        if ($simpan) {
            DB::table('obats')->where('id',$request->obat_id)->update(['ready'=> 'YES']);
            return response()->json(['message' => 'Data Berhasil Disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data Gagal Disimpan'], 422);
        }


    }

    public function getObat(Request $request)
    {
        $data = StockObat::where('obat_id', $request->id)->first();
        $null = [
            'stock' => 0
        ];

        if ($data != null) {
            return response()->json(['data'=> $data]);
        }else{
            return response()->json(['data'=> $null]);
        }

    }

}
