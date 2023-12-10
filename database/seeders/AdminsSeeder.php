<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'thang',
                'account' => 'thang',
                'role' => 0,
                'password' => Hash::make('12345678'),
                'id_app' => 1,
            ],
        ];
        

        Admin::upsert(
            $data,
            [
                'id'
            ],
            array_keys($data[0])
        );
    }
}
