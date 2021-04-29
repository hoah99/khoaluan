<?php

namespace App\Modules\CauHoiDeThi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHoiDeThi extends Model
{
    use HasFactory;

    public $table="cauhoi_dethi";

    protected $fillable = [
        'iddethi', 'idcauhoi'
    ];
}
