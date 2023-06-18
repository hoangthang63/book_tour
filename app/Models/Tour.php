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
        'id',
        'name',
        'start_at',
        'end_at',
        'price',
        'type',
        'description',
        'image',
        'slot',
        'slot_available',
        'id_company',
        'departure_place'
    ];

    protected $casts = [
        // 'start_at'       => 'datetime:Y-m-d',
        // 'end_at'         => 'datetime:Y-m-d',
    ];

    public function schedules(){
        return $this->hasMany(Schedule::class, 'id_tour', 'id');
    }

    public function company(){
        return $this->hasOne(Company::class, 'id_company', 'id');
    }
}
