<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Obat extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'nama',
        'kode',
        'dosis',
        'indikasi',
        'kategori_id',
        'satuan_id',
    ];

    public static function join()
    {
        $data = DB::table('obats')
            ->join('kategoris', 'obats.kategori_id', 'kategoris.id')
            ->join('satuans', 'obats.satuan_id', 'satuans.id')
            ->select('obats.*', 'satuans.satuan as satuans', 'kategoris.kategori as kategoris');

        return $data;
    }
}
