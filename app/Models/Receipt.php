<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'receipt';
    public $timestamps = false;
    protected $fillable =[
        'id',
        'id_tour',
        'id_customer',
        'created_at',
        'status',

    ];

    public function tour(){
        return $this->belongsTo(Tour::class, 'id_tour', 'id');
    }
    public function getRatio($params)
    {
        return DB::table('receipt')
        ->join('tour', 'tour.id', '=', 'receipt.id_tour')
        ->whereIn('receipt.id_tour', $params)
        ->sum('receipt.amount');
    }
}
