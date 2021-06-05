<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function join()
    {
        $data = DB::table('penjualans')
            ->join('obats', 'penjualans.item_id', 'obats.id')
            ->join('users', 'penjualans.user_id', 'users.id')
            ->join('pasiens', 'penjualans.consumer_id', 'pasiens.id')
            ->join('stock_obats', 'penjualans.item_id', 'stock_obats.obat_id')
            ->select(
                'penjualans.*',
                'obats.nama as nama_obat',
                'users.name as user_name',
                'pasiens.nama_pasien as consumer',
                'stock_obats.jual as jual '
            );

        return $data;
    }
}
