<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class StockObat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'obat_id',
        'user_id',
        'masuk',
        'keluar',
        'jual',
        'beli',
        'expired',
        'stock',
        'keterangan',
    ];

    public static function join()
    {
        $data = DB::table('stock_obats')
            ->join('obats', 'stock_obats.obat_id', 'obats.id')
            ->join('users', 'stock_obats.user_id', 'users.id')
            ->select('stock_obats.*', 'obats.nama as namaObat', 'users.name as userName','obats.id as obatId');

        return $data;
    }

    public static function store(Request $request) {
        dd($request->all());
    }
}
