<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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

    public function updateSocial(Request $request)
    {


        $info['facebook'] = $request->facebook;
        $info['instagram'] = $request->instagram;
        $info['twitter'] = $request->twitter;
        $info['linkedin'] = $request->linkedin;
        $info['google'] = $request->google;

        $socialLinks = WebSetting::where('key', 'socialLinks')->first();

        if (!$socialLinks) {
            try {
                if (Cache::has('webSetting')) {
                    Cache::forget('webSetting');
                }


                WebSetting::create([
                    'key' => 'socialLinks',
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
                WebSetting::where('key', 'socialLinks')->update([
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

    public function logoFavicon(Request $request)
    {
        if (isset($request->logo)) {
            return $this->addLogoFavicon('logo', $request);
        } else if (isset($request->favicon)) {
            return $this->addLogoFavicon('favicon', $request);
        } else {
            return redirect()->back();
        }
    }

    public function addLogoFavicon($userInput, $request)
    {
        $request->validate([
            $userInput => 'required|mimes:jpeg,jpg,bmp,png,ico|max:1024'
        ], [$userInput . '.required' => 'Please upload valid image for ' . $userInput]);

        $logoOrFavicon = WebSetting::where('key', $userInput)->first();
        $logoOrFaviconImage = $request->file($userInput);

        if (!$logoOrFavicon) {
            $logoOrFavicon->update([
                'key' => $userInput
            ]);
            if ($logoOrFaviconImage->move('assets/images/', $logoOrFaviconImage->getClientOriginalName())) {
                $logoOrFavicon->update([
                    'data' => json_encode([$userInput => $logoOrFaviconImage->getClientOriginalName()])
                ]);



                try {
                    if (Cache::has('webSetting')) {
                        Cache::forget('webSetting');
                    }

                    $data['type'] = "success";
                    $data['message'] = Str::ucfirst($userInput) . " Added Successfuly!.";
                    $data['icon'] = 'mdi-check-all';
                } catch (\Throwable $th) {
                    $data['type'] = "danger";
                    $data['message'] = "Failed to Add " . Str::ucfirst($userInput) . ", please try again.";
                    $data['icon'] = 'mdi-block-helper';
                }


                return redirect()->back()->with($data);
            } else {
                $data['type'] = "danger";
                $data['message'] = "Failed to upload image, please try again.";
                $data['icon'] = 'mdi-block-helper';

                return redirect()->back()->with($data);
            }
        } else {

            if ($logoOrFaviconImage->move('assets/images/', $logoOrFaviconImage->getClientOriginalName())) {


                try {
                    WebSetting::where('key', $userInput)->update([
                        'data' => json_encode([$userInput => $logoOrFaviconImage->getClientOriginalName()])
                    ]);
                    if (Cache::has('webSetting')) {
                        Cache::forget('webSetting');
                    }

                    $data['type'] = "success";
                    $data['message'] = Str::ucfirst($userInput) . " Updated Successfuly!.";
                    $data['icon'] = 'mdi-check-all';
                } catch (\Throwable $th) {
                    $data['type'] = "danger";
                    $data['message'] = "Failed to Update " . Str::ucfirst($userInput) . ", please try again.";
                    $data['icon'] = 'mdi-block-helper';
                }


                return redirect()->back()->with($data);
            } else {
                $data['type'] = "danger";
                $data['message'] = "Failed to upload image, please try again.";
                $data['icon'] = 'mdi-block-helper';

                return redirect()->route('web.settings')->with($data);
            }
        }
    }
}
