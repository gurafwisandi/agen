<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPembelianModels extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'detail_pembelian';

    public function item()
    {
        return $this->belongsTo(ItemModels::class, 'id_item');
    }
}
