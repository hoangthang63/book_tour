<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListApp extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'logo',
        'id',
    ];
    protected $table = 'list_company';
    public $timestamps = false;

    public function getAllApp()
    {
        return ListApp::paginate(2);
    }

    public function getAll()
    {
        return ListApp::all();
    }
    public function getAppById($idApp)
    {
        return DB::table('list_company')
        ->select('name')
        ->where("list_company.id_app", "=", $idApp)
        ->first();
    }

    public function updateApp($idApp,$name,$logo)
    {
        return DB::table('list_company')
        ->where('id_app', $idApp)
        ->update([
            'name' => $name,
            'logo' => $logo,
    
    ]);
    }

    public function getFirstApp()
    {
        return ListApp::query()
        ->first();
    }

    public function getNameAndMaxStampApp($idApp)
    {
        return DB::table('list_apps')
        ->select('list_apps.name','stamp_cards.maximum_stamp_card')
        ->join('stamp_cards','stamp_cards.id_app','=','list_apps.id_app')
        ->where("list_apps.id_app", "=", $idApp)
        ->first();
    }

    
}
