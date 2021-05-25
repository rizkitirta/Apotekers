<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Supplier::all();
        if ($request->ajax()) {
            return datatables()->of($data)
            ->addColumn('aksi', function($data) {
                $button = '<button class="edit btn btn-primary btn-sm" id="'.$data->id.'" name="edit" ><i class="fas fa-edit"></i></button>';
                $button .= '<button class="hapus btn btn-danger btn-sm mt-1" id="'.$data->id.'" name="hapus"><i class="fas fa-trash-alt"></i></button>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }

        return view('owner.SupplierHome');

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
        $request->validate([
            'nama' => 'required|string',
            'telp' => 'required|string',
            'email' => 'required|email',
            'rekening' => 'required|string',
            'alamat' => 'required',
        ]);

        $supplier = Supplier::create($request->all());
        if ($supplier) {
            return response()->json(['message' => 'Data Berhasil Disimpan'], 200);
        }else {
            return response()->json(['message' => 'Data Gagal Disimpan'], 400);
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
        $data = Supplier::find($request->id);
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
        $request->validate([
            'nama' => 'required|string',
            'telp' => 'required|string',
            'email' => 'required|email',
            'rekening' => 'required|string',
            'alamat' => 'required',
        ]);

        $data = Supplier::find($request->id);
        $data->update($request->all());
        if ($data) {
            return response()->json(['message' => 'Data Berhasil Diupdate']);
        }else {
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
        $data = Supplier::find($request->id);
        $data->delete($data);
        if ($data) {
            return response()->json(['message' => 'Data Berhasil Dihapus']);
        }else {
            return response()->json(['message' => 'Data Gagal Dihapus']);
        }
    }
}
