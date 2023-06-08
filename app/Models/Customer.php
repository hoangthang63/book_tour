<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    public $timestamps = false;
    protected $fillable =[
        'name',
        'phone_number',
        'password',
        'address',
        'email',

    ];
}
