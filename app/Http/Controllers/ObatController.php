<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Obat;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $satuan = Satuan::select('id', 'satuan')->get();
        $kategori = Kategori::select('id', 'kategori')->get();
        $data = Obat::join()->get();
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

        return view('owner.ObatHome', compact('satuan', 'kategori'));
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
            'nama' => 'required|string',
            'kode' => 'required|string',
            'dosis' => 'required|string',
            'indikasi' => 'required|string',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
        ];

        $message = [
            'nama.required' => 'Kolom nama tidak boleh kosong!',
            'kode.required' => 'Kolom kode tidak boleh kosong!',
            'dosis.required' => 'Kolom dosis tidak boleh kosong!',
            'indikasi.required' => 'Kolom indikasi ridak boleh kosong!',
            'kategori_id.required' => 'Kolom kategori tidak boleh kosong!',
            'satuan_id.required' => 'Kolom satuan tidak boleh kosong!',
        ];

        $validasi = Validator::make($request->all(), $rules, $message);
        if ($validasi->fails()) {
            return response()->json(['message' => $validasi->errors()->first()], 422);
        }

        $supplier = Obat::create($request->all());
        if ($supplier) {
            return response()->json(['message' => 'Data Berhasil Disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data Gagal Disimpan'], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = Obat::find($request->id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'nama' => 'required|string',
            'kode' => 'required|string',
            'dosis' => 'required|string',
            'indikasi' => 'required|string',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
        ];

        $message = [
            'nama.required' => 'Kolom nama tidak boleh kosong!',
            'kode.required' => 'Kolom kode tidak boleh kosong!',
            'dosis.required' => 'Kolom dosis tidak boleh kosong!',
            'indikasi.required' => 'Kolom indikasi ridak boleh kosong!',
            'kategori_id.required' => 'Kolom kategori tidak boleh kosong!',
            'satuan_id.required' => 'Kolom satuan tidak boleh kosong!',
        ];

        $validasi = Validator::make($request->all(), $rules, $message);
        if ($validasi->fails()) {
            return response()->json(['message' => $validasi->errors()->first()], 422);
        }

        $data = Obat::find($request->id);
        $data->update($request->all());
        if ($data) {
            return response()->json(['message' => 'Data Berhasil Diupdate']);
        } else {
            return response()->json(['message' => 'Data Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus(Request $request)
    {
        $data = Obat::find($request->id);
        $data->delete($data);
        if ($data) {
            return response()->json(['message' => 'Data Berhasil Dihapus']);
        } else {
            return response()->json(['message' => 'Data Gagal Dihapus']);
        }
    }
}
