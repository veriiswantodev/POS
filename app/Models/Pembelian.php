<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';

    protected $primaryKey = 'id_pembelian';

    protected $guarded = [];

    public function suplier(){
        return $this->belongsTo(Supplier::class, 'id_suplier', 'id_suplier');
    }
}
