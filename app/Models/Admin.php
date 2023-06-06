<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admins';
    public $timestamps = false;
    protected $fillable =[
        'id_app',
        'name',
        'account',
        'password',
        'role',

    ];
    public function getAdmin($q,$q2)
    {
        return Admin::query()
        ->where('account', $q)
        ->where('password', $q2)
        ->firstOrFail();
    }
    public function getAppAdminByIdApp($idApp)
    {
        return Admin::query()
        ->where('id_app', $idApp)
        ->paginate(3);
    }

    public function getAppAdmin($q,$q2)
    {
        return Admin::query()
        ->where('account', $q)
        ->where('password', $q2)
        ->first();
    }
    public function getAllAppAdmin()
    {
        return Admin::all();
    }
    public function getGroupAppAdmin($id)
    {
        return Admin::where('id_app', $id)
        ->first();
    }
    public function checkExist($id)
    {
        return Admin::where('id', $id)
        ->first();
    }
}
