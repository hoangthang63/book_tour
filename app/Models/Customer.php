<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    // protected function address(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value){
    //             return $this->decryptData($value);
    //         }
    //     );
    // }

    // private function decryptData($data) {
    //     $iv = str_repeat("0", openssl_cipher_iv_length(config('app.ciper')));
    //     $option = 0;
    //     return openssl_decrypt($data, config('app.ciper'), config('app.secret_key'), $option, $iv);
    // }
}
