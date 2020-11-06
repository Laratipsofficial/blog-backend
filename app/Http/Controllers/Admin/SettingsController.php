<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UploadFile;
use Inertia\Inertia;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAboutRequest;
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

        $this->save($data);

        return redirect()->back();
    }

    public function saveAbout(SaveAboutRequest $request)
    {
        $data['about_description'] = $request->get('about_description');

        if ($request->file('about_image')) {
            $this->settings->deleteHeroImage();

            $imageName = (new UploadFile)
                ->setFile($request->file('about_image'))
                ->setUploadPath($this->settings->uploadFolder())
                ->execute();

            $data['about_image'] = $imageName;
        }

        $this->save($data);

        return redirect()->back();
    }

    private function save(array $data): void
    {
        $this->settings->data = array_merge($this->settings->data, $data);
        $this->settings->save();
    }
}
