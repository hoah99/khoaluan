<?php

namespace App\Modules\GiangVien\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    use HasFactory;

    public $table = "giangvien";

    protected $fillable = [
        'hoten', 'taikhoan', 'matkhau', 'email', 'sdt'
    ];
}
