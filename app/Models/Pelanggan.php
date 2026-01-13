<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'no_pelanggan';
    protected $fillable = ['nama_pelanggan', 'alamat_pelanggan'];

    public function pembayaranAir()
    {
        return $this->hasMany(PembayaranAir::class, 'no_pelanggan', 'no_pelanggan');
    }
}
