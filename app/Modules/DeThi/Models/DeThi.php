<?php

namespace App\Modules\DeThi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeThi extends Model
{
    use HasFactory;

    public $table = "dethi";

    protected $fillable = [
        'tieude', 'socauhoi', 'thoigian', 'matkhau', 'ghichu', 'trangthai', 'idmonthi', 'idgiangvien', 'idlop'
    ];

    public function cauhoi(){
        return $this->hasMany('App\Modules\CauHoi\Models\CauHoi');
    }

}
