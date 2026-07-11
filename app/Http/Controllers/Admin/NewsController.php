<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Tag;
use App\Models\NewsPhoto;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }
    public function index(Request $request) {
        $query = News::latest();
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $news = $query->get();
        return view('admin.news.index', compact('news'));
    }

    public function toggleStatus(News $news) {
        $news->update(['status' => !$news->status]);
        return back()->with('success', 'Status berita berhasil diperbarui!');
    }
    public function create() {
        $tags = Tag::all();
        return view('admin.news.create', compact('tags'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required', 
            'content' => 'required', 
            'publish_date' => 'nullable|date', 
            'status' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        // Programmatic validation for gallery photos format, size, and count
        if ($request->hasFile('gallery')) {
            $files = $request->file('gallery');
            if (count($files) > 10) {
                return back()->withErrors(['gallery' => 'Maksimal 10 foto yang dapat diunggah.'])->withInput();
            }
            foreach ($files as $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                $allowed = ['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg', 'bmp', 'heic', 'heif', 'hevc', 'raw', 'tiff'];
                if (!in_array($ext, $allowed)) {
                    return back()->withErrors(['gallery' => 'Format file galeri harus berupa png, jpg, jpeg, webp, gif, svg, bmp, heic, heif, atau hevc.'])->withInput();
                }
                if ($file->getSize() > 2048 * 1024) {
                    return back()->withErrors(['gallery' => 'Ukuran maksimal file galeri adalah 2MB per file.'])->withInput();
                }
            }
        }

        $data['show_toc'] = $request->has('show_toc');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news = News::create($data);
        $this->syncTags($news, $request->tags);

        // Upload gallery photos using MediaService (which handles compression)
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $media = $this->mediaService->upload($file, 'news_gallery');
                $news->photos()->create([
                    'path' => str_replace('storage/', '', $media->file_path),
                ]);
            }
        }

        $this->syncToGalleryAlbum($news);

        return redirect()->route('admin.news.index')->with('success', 'Berita added!');
    }
    public function edit(News $news) {
        $tags = Tag::all();
        return view('admin.news.edit', compact('news', 'tags'));
    }
    public function update(Request $request, News $news) {
        $data = $request->validate([
            'title' => 'required', 
            'content' => 'required', 
            'publish_date' => 'nullable|date', 
            'status' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);

        // Process deletion of photos first
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = NewsPhoto::find($photoId);
                if ($photo) {
                    $dbPath = 'storage/' . $photo->path;
                    $media = \App\Models\Media::where('file_path', $dbPath)->first();
                    if ($media) {
                        Storage::delete(str_replace('storage/', 'public/', $media->file_path));
                        $media->delete();
                    } else {
                        Storage::disk('public')->delete($photo->path);
                    }
                    \App\Models\GalleryPhoto::where('image_path', $dbPath)->delete();
                    $photo->delete();
                }
            }
        }

        // Validate total count of current + new uploads <= 10
        $currentCount = $news->photos()->count();
        $newFiles = $request->file('gallery') ?? [];
        if (count($newFiles) > 0) {
            if ($currentCount + count($newFiles) > 10) {
                return back()->withErrors(['gallery' => 'Total foto galeri berita tidak boleh melebihi 10 foto.'])->withInput();
            }
            foreach ($newFiles as $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                $allowed = ['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg', 'bmp', 'heic', 'heif', 'hevc', 'raw', 'tiff'];
                if (!in_array($ext, $allowed)) {
                    return back()->withErrors(['gallery' => 'Format file galeri harus berupa png, jpg, jpeg, webp, gif, svg, bmp, heic, heif, atau hevc.'])->withInput();
                }
                if ($file->getSize() > 2048 * 1024) {
                    return back()->withErrors(['gallery' => 'Ukuran maksimal file galeri adalah 2MB per file.'])->withInput();
                }
            }
        }

        $data['show_toc'] = $request->has('show_toc');

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);
        $this->syncTags($news, $request->tags);

        // Upload new photos
        if (count($newFiles) > 0) {
            foreach ($newFiles as $file) {
                $media = $this->mediaService->upload($file, 'news_gallery');
                $news->photos()->create([
                    'path' => str_replace('storage/', '', $media->file_path),
                ]);
            }
        }

        $this->syncToGalleryAlbum($news);

        return redirect()->route('admin.news.index')->with('success', 'Berita updated!');
    }
    public function destroy(News $news) {
        // Delete gallery photos from storage and database
        foreach ($news->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }
        
        // Also delete Synced Gallery Album if it exists
        $gallery = \App\Models\Gallery::where('title', $news->title)->first();
        if ($gallery) {
            foreach ($gallery->photos as $p) {
                Storage::delete(str_replace('storage/', 'public/', $p->image_path));
                $p->delete();
            }
            if ($gallery->image_path && !str_contains($gallery->image_path, 'assets/')) {
                Storage::delete(str_replace('storage/', 'public/', $gallery->image_path));
            }
            $gallery->delete();
        }

        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->tags()->detach();
        $news->delete();
        return back()->with('success', 'Berita deleted!');
    }
    private function syncTags(News $news, $tagInput) {
        $tagIds = [];
        if (is_array($tagInput)) {
            foreach ($tagInput as $tagStr) {
                if (is_numeric($tagStr)) {
                    $tagIds[] = $tagStr;
                } else {
                    $tag = Tag::firstOrCreate(['name' => filter_var(trim($tagStr), FILTER_SANITIZE_STRING)]);
                    $tagIds[] = $tag->id;
                }
            }
        }
        $news->tags()->sync($tagIds);
    }
    private function syncToGalleryAlbum(News $news) {
        if ($news->status) {
            $gallery = \App\Models\Gallery::firstOrCreate(
                ['title' => $news->title],
                [
                    'sort_order' => \App\Models\Gallery::max('sort_order') + 1 ?: 1,
                    'image_path' => $news->image ? 'storage/' . $news->image : 'assets/img/blog/blog-hero-1.webp',
                ]
            );

            if ($news->image && $gallery->image_path !== 'storage/' . $news->image) {
                $gallery->update(['image_path' => 'storage/' . $news->image]);
            }

            foreach ($news->photos as $photo) {
                $photoPath = 'storage/' . $photo->path;
                $exists = \App\Models\GalleryPhoto::where('gallery_id', $gallery->id)
                    ->where('image_path', $photoPath)
                    ->exists();

                if (!$exists) {
                    \App\Models\GalleryPhoto::create([
                        'gallery_id' => $gallery->id,
                        'image_path' => $photoPath,
                        'sort_order' => 0,
                    ]);
                }
            }
        }
    }
}