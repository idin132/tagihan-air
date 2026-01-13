<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengelola extends Model
{
    protected $table = 'pengelola';
    protected $primaryKey = 'no_pengelola';
    protected $fillable = ['nama_pengelola'];

    public function pembayaranAir()
    {
        return $this->hasMany(PembayaranAir::class, 'no_pengelola', 'no_pengelola');
    }
}
