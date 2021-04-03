<?php

namespace App\Modules\MonThi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonThi extends Model
{
    use HasFactory;

    public $table = "monthi";

    protected $fillable = [
        'tenmon'
    ];
}
