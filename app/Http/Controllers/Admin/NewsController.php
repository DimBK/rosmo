<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index() {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
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
        
        $data['show_toc'] = $request->has('show_toc');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news = News::create($data);
        $this->syncTags($news, $request->tags);
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

        $data['show_toc'] = $request->has('show_toc');

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);
        $this->syncTags($news, $request->tags);
        return redirect()->route('admin.news.index')->with('success', 'Berita updated!');
    }
    public function destroy(News $news) {
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
}