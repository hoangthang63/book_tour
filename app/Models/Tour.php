<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tour';

    protected $fillable = [
        'ma',
        'ten',
        'khoi_hanh',
        'ket_thuc',
        'gia',
        'loai',
        'mo_ta',
        'ma_cong_ty',
    ];

    protected $casts = [
        'start_at'       => 'datetime:Y-m-d',
        'end_at'         => 'datetime:Y-m-d',
    ];

    public function schedules(){
        return $this->hasMany(Schedule::class, 'id_tour', 'id');
    }

    public function company(){
        return $this->hasOne(Company::class, 'id_company', 'id');
    }
}
