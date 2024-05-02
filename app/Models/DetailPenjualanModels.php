<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPenjualanModels extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'detail_penjualan';

    public function item()
    {
        return $this->belongsTo(ItemModels::class, 'id_item');
    }

    public function satuan()
    {
        return $this->belongsTo(SatuanModels::class, 'id_satuan');
    }
}
