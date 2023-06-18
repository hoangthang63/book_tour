<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


}
