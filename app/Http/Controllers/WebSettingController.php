<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Doctrine\DBAL\Platforms\MySQL\Comparator;
use Illuminate\Http\Request;

class WebSettingController extends Controller
{
    public function index()
    {
        $contactInfo = WebSetting::where('key', 'contactInfo')->first();
        // dd($contactInfo);
        if (count((array)$contactInfo)) {
            $data['contact'] = json_decode($contactInfo->data);
        } else {
            $data['contact'] = [];
        }

        $socialLinks = WebSetting::where('key', 'socialLinks')->first();
        if (count((array)$socialLinks)) {
            $data['links'] = json_decode($socialLinks->data);
        } else {
            $data['links'] = [];
        }

        $logo = WebSetting::where('key', 'logo')->first();
        $favicon = WebSetting::where('key', 'favicon')->first();
        if (count((array)$logo)) {
            $data['logo'] = json_decode($logo->data);
        } else {
            $data['logo'] = null;
        }

        if (count((array)$favicon)) {
            $data['favicon'] = json_decode($favicon->data);
        } else {
            $data['favicon'] = null;
        }


        return view('backend.admin.websetting.index', $data);
    }
}
