<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable =[
        'id',
        'id_customer',
        'id_tour',
        'ticket_code',
        'ticket_img',
        'scanned_at',
        'status',
    ];
    protected $table = 'tickets';
    public $timestamps = false;
}
