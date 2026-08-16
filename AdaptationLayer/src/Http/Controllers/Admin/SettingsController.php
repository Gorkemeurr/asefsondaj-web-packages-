<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use AsefSondaj\AdaptationLayer\Models\AsefSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        $items = AsefSetting::orderBy('sort')->orderBy('id')->get();
        return view('asef-adaptation::admin.settings.index', compact('items'));
    }

    public function update(Request $req)
    {
        $values = $req->input('settings', []);
        if (! is_array($values)) {
            return redirect()->route('admin.asef.settings.index')->with('error', 'Geçersiz veri.');
        }

        foreach ($values as $key => $value) {
            $s = AsefSetting::where('key', $key)->first();
            if ($s) {
                $s->value = is_string($value) ? trim($value) : $value;
                $s->save();
            }
        }

        return redirect()->route('admin.asef.settings.index')->with('success', 'Ayarlar kaydedildi.');
    }
}
