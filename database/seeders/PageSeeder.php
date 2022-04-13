<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::create([
            'name'=>'Home',
            'slug'=>Str::slug('Home','-'),
        ]);

        Page::create([
            'name'=>'About Us',
            'slug'=>Str::slug('About Us','-'),
        ]);

        Page::create([
            'name'=>'Contact Us',
            'slug'=>Str::slug('Contact Us','-'),
        ]);
    }
}
