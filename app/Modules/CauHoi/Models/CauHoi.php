<?php

namespace App\Modules\CauHoi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHoi extends Model
{
    use HasFactory;

    public $table = "cauhoi";

    protected $fillable = [
        'noidung', 'phuongana', 'phuonganb', 'phuonganc', 'phuongand', 'dapan', 'chuong', 'dokho', 'idmonthi'
    ];
}
