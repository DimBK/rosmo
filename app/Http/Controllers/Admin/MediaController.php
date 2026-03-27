<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        $media = Media::latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp,mp4|max:10240', // 10MB max
        ]);

        foreach ($request->file('files') as $file) {
            $this->mediaService->upload($file);
        }

        return redirect()->route('admin.media.index')->with('success', 'File berhasil diunggah dan dioptimasi.');
    }

    public function destroy(Media $medium) // Note $medium is the resolved model because resource is 'media' (singular medium)
    {
        // Actually resource route binds to 'medium' parameter
        $path = str_replace('storage/', 'public/', $medium->file_path);
        Storage::delete($path);
        $medium->delete();

        return redirect()->route('admin.media.index')->with('success', 'File berhasil dihapus.');
    }
}
