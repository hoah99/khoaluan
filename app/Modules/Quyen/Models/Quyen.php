<?php

namespace App\Modules\Quyen\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    use HasFactory;

    public $table = "quyen";

    protected $fillable = [
        'tenquyen'
    ];
}
