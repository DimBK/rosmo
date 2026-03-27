<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        $galleries = Gallery::orderBy('sort_order')->paginate(20);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'image_path' => 'required|image|max:10240',
        ]);

        if ($request->hasFile('image_path')) {
            // Upload through MediaService to get compressed image
            $media = $this->mediaService->upload($request->file('image_path'), 'gallery');
            $validated['image_path'] = $media->file_path; // Use the optimized path
        }

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'image_path' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('image_path')) {
            // Delete old file if exists
            if ($gallery->image_path) {
                Storage::delete(str_replace('storage/', 'public/', $gallery->image_path));
            }
            $media = $this->mediaService->upload($request->file('image_path'), 'gallery');
            $validated['image_path'] = $media->file_path;
        }

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image_path) {
            Storage::delete(str_replace('storage/', 'public/', $gallery->image_path));
        }
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dihapus.');
    }
}
