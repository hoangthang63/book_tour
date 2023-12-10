<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ListApp;

class ListCompanySeeder extends Seeder
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
                'id_app' => 1,
                'name' => 'VietTravel',
                'logo' => 'https://www.vietravel.com/Content/img/vtv-logo.png',
            ],
            [
                'id_app' => 2,
                'name' => 'SeaTravel',
                'logo' => 'https://www.liblogo.com/img-logo/tr1084cd3a-travel-logo-cruise-plane-travel-logo-.png',
            ],
        ];
        

        ListApp::upsert(
            $data,
            [
                'id'
            ],
            array_keys($data[0])
        );
    }
}
