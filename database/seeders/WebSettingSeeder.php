<?php

namespace Database\Seeders;

use App\Models\WebSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebSettingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataLogo = ["logo"=>"logo.png"];
        $dataFavicon = ["favicon"=>"favicon.png"];
        $dataContact = ["phone"=>"(323) 833 - 8565","email"=>"info@cms.com","address"=>"P.O. Box # 9768 Silicon Valley Califonia"];
        $dataSocialLinks = ["facebook"=>null,"instagaram"=>null,"twitter"=>null,"linkedin"=>null,"google"=>null];
        $dataSmtp = ["host"=>"smtp.gmail.com","port"=>"587","username"=>"ethanpatrik175@gmail.com","password"=>"eyJpdiI6IkZUZ2dWSnYxYUJkQVhGQ0tBN3RUVHc9PSIsInZhbHVlIjoiakZ1K25CZHBJMHovV3poNjJPYVNCejltaTdJZmxCMWU3bHVtZUNkbHhQVT0iLCJtYWMiOiJhN2RjYWIxOWFhMjE1YjY4YmI0MDMzMGYyZTMyMjc3ZDMzNjFhZGI3YzM1YjEzZTZkYzJkYTgxZDE2N2VhMTZiIiwidGFnIjoiIn0=","encryption"=>"tls","from_name"=>"CMS"];


        WebSetting::create([
            'key'=>'logo',
            'data'=>json_encode($dataLogo)
        ]);


        WebSetting::create([
            'key'=>'favicon',
            'data'=>json_encode($dataFavicon)
        ]);


        WebSetting::create([
            'key'=>'contactInfo',
            'data'=>json_encode($dataContact)
        ]);

        WebSetting::create([
            'key'=>'socialLinks',
            'data'=>json_encode($dataSocialLinks)
        ]);

        WebSetting::create([
            'key'=>'smtp',
            'data'=>json_encode($dataSmtp)
        ]);
    }

}
