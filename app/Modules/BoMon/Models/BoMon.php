<?php

namespace App\Modules\BoMon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoMon extends Model
{
    use HasFactory;

    public $table = "bomon";

    protected $fillable =[
        'tenbomon'
    ];
}
