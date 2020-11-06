<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    public function uploadFolder(): string
    {
        return "settings";
    }

    public function heroDescription(): ?string
    {
        return Arr::get($this->data, 'hero_description');
    }

    public function heroImageUrl(): ?string
    {
        return $this->imageUrl('hero_image');
    }

    public function deleteHeroImage(): void
    {
        $imageName = Arr::get($this->data, 'hero_image');

        if ($imageName !== null) {
            Storage::delete("{$this->uploadFolder()}/{$imageName}");
        }
    }

    public function aboutDescription(): ?string
    {
        return Arr::get($this->data, 'about_description');
    }

    public function aboutImageUrl(): ?string
    {
        return $this->imageUrl('about_image');
    }

    public function imageUrl(string $column): ?string
    {
        $imageName = Arr::get($this->data, $column);

        return $imageName === null
            ? "https://ui-avatars.com/api/?name={$column}&color=7F9CF5&background=EBF4FF"
            : Storage::url("{$this->uploadFolder()}/{$imageName}"); 
    }
}
