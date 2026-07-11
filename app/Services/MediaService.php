<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;

class MediaService
{
    public function upload(UploadedFile $file, $prefix = 'media')
    {
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid($prefix . '_') . '.' . $extension;
        $path = 'uploads/' . $filename;

        // Check if file is an image
        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp'])) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            // Resize if width > 1200 or height > 1200
            if ($image->width() > 1200 || $image->height() > 1200) {
                $image->scaleDown(width: 1200, height: 1200);
            }

            // Encode to webp for optimization to reduce size
            $encoded = $image->toWebp(quality: 80);
            $filename = uniqid($prefix . '_') . '.webp';
            $path = 'uploads/' . $filename;
            
            Storage::disk('public')->put($path, $encoded->toString());
            $fileType = 'image/webp';
            $fileSize = strlen($encoded->toString());
        } else {
            // For other files like icons (svg), videos (mp4), keep original
            Storage::disk('public')->putFileAs('uploads', $file, $filename);
            $fileType = $file->getMimeType();
            $fileSize = $file->getSize();
        }

        // Save to Database
        return Media::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => 'storage/' . $path,
            'file_type' => $fileType,
            'file_size' => explode('.', (string)($fileSize / 1024))[0], // in KB roughly
        ]);
    }
}
