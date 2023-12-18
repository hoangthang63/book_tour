<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'departure_place',
        'reviews',
        'linkHotel',
    ];

    protected $casts = [
        'start_at'       => 'date',
        'end_at'         => 'date',
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        // return (int) \Carbon\Carbon::parse($date)->timestamp;
        return $date->format('d-m');
    }

    public function schedules(){
        return $this->hasMany(Schedule::class, 'id_tour', 'id');
    }

    public function company(){
        return $this->hasOne(Company::class, 'id_company', 'id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return config('app.domain') . $value;
            }
        );
    }
}
