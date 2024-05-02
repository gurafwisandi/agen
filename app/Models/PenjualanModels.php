<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenjualanModels extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'penjualan';

    public function customer()
    {
        return $this->belongsTo(CustomerModels::class, 'id_customer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
