<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemModels extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'item';

    public function satuan()
    {
        return $this->belongsTo(SatuanModels::class, 'id_satuan');
    }
}
