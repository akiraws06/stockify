<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SettingController extends Controller
{
    function tampil()
    {
        $setting = Setting::first();
        return view('setting.tampil', compact('setting'));
    }

    function edit($id)
    {
        $setting = Setting::find($id);
        return view('setting.edit', compact('setting'));
    }

    function update(Request $request, $id)
    {
        $setting = Setting::find($id);
        $activityMessage = []; // Array untuk menyimpan pesan aktivitas

        if ($request->has('name')) {
            $setting->name = $request->name; // Update nama jika ada
            $activityMessage[] = 'nama'; // Tambahkan pesan
        }
        if ($request->hasFile('logo')) {
            $imagePath = $request->file('logo')->store('images/setting', 'public');
            $setting->logo = $imagePath; // Update image path
            $activityMessage[] = 'logo'; // Tambahkan pesan
        }

        $setting->save();

        // Gabungkan pesan aktivitas
        if (count($activityMessage) > 0) {
            $activity = 'User telah merubah ' . implode(' dan ', $activityMessage) . ' aplikasi';
        } else {
            $activity = 'Tidak ada perubahan yang dilakukan'; // Pesan default jika tidak ada perubahan
        }

        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => $activity,
        ]);
        return redirect()->route('setting.tampil');
    }

}
