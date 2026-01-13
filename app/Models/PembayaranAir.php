<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranAir extends Model
{
    protected $table = 'pembayaran_air';
    protected $fillable = [
        'bulan', 'no_pelanggan', 'stand_meter_awal', 
        'stand_meter_akhir', 'stand_meter_total', 
        'total_tagihan', 'tanggal_pembayaran', 'no_pengelola'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'no_pelanggan', 'no_pelanggan');
    }

    public function pengelola()
    {
        return $this->belongsTo(Pengelola::class, 'no_pengelola', 'no_pengelola');
    }
}