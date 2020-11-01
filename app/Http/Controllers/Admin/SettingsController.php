<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingsResource;

class SettingsController extends Controller
{
    private $settings;

    public function __construct()
    {
        $this->settings = Setting::find(1) ?? new Setting();
    }

    public function create(Request $request)
    {
        return Inertia::render('Settings/Create', [
            'settings' => new SettingsResource($this->settings),
        ]);
    }

    public function saveHero(Request $request)
    {
        $request->validate([
            'hero_description' => ['required', 'string'],
            'hero_image' => ['nullable', 'image']
        ]);

        $data['hero_description'] = $request->get('hero_description');

        if ($request->file('hero_image')) {
            $this->settings->deleteHeroImage();

            $imageName = (string) Str::of($request->file('hero_image')->getClientOriginalName())
                ->beforeLast('.')
                ->slug()
                ->append('.')
                ->append($request->file('hero_image')->getClientOriginalExtension());

            $data['hero_image'] = $imageName;

            $request->file('hero_image')->storeAs($this->settings->uploadFolder(), $imageName);
        }

        $this->settings->data = $data;
        $this->settings->save();

        return redirect()->back();
    }
}
