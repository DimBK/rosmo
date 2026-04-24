<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryPhotoController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index(Gallery $gallery)
    {
        $photos = $gallery->photos()->orderBy('sort_order')->get();
        return view('admin.galleries.photos', compact('gallery', 'photos'));
    }

    public function store(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image_path' => 'required|image|max:10240',
            'sort_order' => 'nullable|integer',
        ]);

        $imagePath = '';
        if ($request->hasFile('image_path')) {
            $media = $this->mediaService->upload($request->file('image_path'), 'gallery_photos');
            $imagePath = $media->file_path;
        }

        $gallery->photos()->create([
            'image_path' => $imagePath,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.galleries.photos.index', $gallery)->with('success', 'Foto berhasil ditambahkan ke album.');
    }

    public function destroy(GalleryPhoto $photo)
    {
        $gallery = $photo->gallery;
        if ($photo->image_path) {
            Storage::delete(str_replace('storage/', 'public/', $photo->image_path));
        }
        $photo->delete();
        
        return redirect()->route('admin.galleries.photos.index', $gallery)->with('success', 'Foto berhasil dihapus dari album.');
    }
}
