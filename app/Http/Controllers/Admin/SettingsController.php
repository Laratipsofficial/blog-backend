<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UploadFile;
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

            $imageName = (new UploadFile)
                ->setFile($request->file('hero_image'))
                ->setUploadPath($this->settings->uploadFolder())
                ->execute();

            $data['hero_image'] = $imageName;
        }

        $mergedData = array_merge($this->settings->data, $data);

        $this->settings->data = $mergedData;
        $this->settings->save();

        return redirect()->back();
    }
}
