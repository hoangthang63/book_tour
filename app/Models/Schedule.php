<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedule';
    public $timestamps = false;
    protected $fillable =[
        'day',
        'id_company',
        'title',
        'description',
        'image',
        'id_tour',

    ];


    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return config('app.domain') . $value;
            }
        );
    }
}
