<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token']);

        // Handle file uploads if any in settings (like hero_image, og_image, favicon)
        // For simplicity, users can upload to Media Library and paste the URL, 
        // OR we can handle direct file uploads here.
        // Let's handle direct file uploads for convenience:
        foreach (['hero_image', 'favicon', 'og_image'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                // Simple upload for settings
                $path = $file->store('public/settings');
                $data[$fileKey] = str_replace('public/', 'storage/', $path);
            }
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) continue; // skip arrays if any
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
