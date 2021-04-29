<?php

namespace App\Modules\Lop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    use HasFactory;

    public $table = "lop";

    protected $fillable = [
        'malop', 'tenlop', 'idbomon'
    ];
}
