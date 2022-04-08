<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    public function updateContact(Request $request)
    {

        $request->validate([
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $info['phone'] = $request->phone;
        $info['email'] = $request->email;
        $info['address'] = $request->address;

        $contactInfo = WebSetting::where('key', 'contactInfo')->first();

        if (!$contactInfo) {
            try {
                if (Cache::has('webSetting')) {
                    Cache::forget('webSetting');
                }


                WebSetting::create([
                    'key' => 'contactInfo',
                    'data' => json_encode($info)
                ]);

                $data['type'] = "success";
                $data['message'] = "Setting Added Successfuly!.";
                $data['icon'] = 'mdi-check-all';
                return redirect()->back()->with($data);
            } catch (\Throwable $th) {
                $data['type'] = "danger";
                $data['message'] = "Failed to Add Setting, please try again.";
                $data['icon'] = 'mdi-block-helper';
                return redirect()->back()->with($data);
            }
        } else {
            try {
                WebSetting::where('key', 'contactInfo')->update([
                    'data' => json_encode($info)
                ]);

                if (Cache::has('webSetting')) {
                    Cache::forget('webSetting');
                }

                $data['type'] = "success";
                $data['message'] = "Setting Updated Successfuly!.";
                $data['icon'] = 'mdi-check-all';
                return redirect()->back()->with($data);
            } catch (\Throwable $th) {
                $data['type'] = "danger";
                $data['message'] = "Failed to Update Setting, please try again.";
                $data['icon'] = 'mdi-block-helper';
                return redirect()->back()->with($data);
            }
        }
    }
}
