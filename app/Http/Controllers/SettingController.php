<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return view('setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_apotek' => 'required',
            'nama_owner' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
            'email_apotek' => 'required',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'diskon_member' => 'nullable|integer',
            'path_logo' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'path_kartu_member' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $setting = Setting::first();
        $attributes = $request->except('path_logo', 'path_kartu_member');

        if ($request->hasFile('path_logo')) {
            delete_file($setting->path_logo);
            $attributes['path_logo'] = upload_file('setting', $request->file('path_logo'), 'path_logo');
        }

        if ($request->hasFile('path_kartu_member')) {
            delete_file($setting->path_kartu_member);
            $attributes['path_kartu_member'] = upload_file('setting', $request->file('path_kartu_member'), 'path_kartu_member');
        }

        $setting->update($attributes);

        return $this->ok($setting, 'Data berhasil diperbarui');
    }
}
