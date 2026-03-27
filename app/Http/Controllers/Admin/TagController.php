<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|unique:tags,name']);
        $validated['slug'] = Str::slug($validated['name']);
        Tag::create($validated);
        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil ditambahkan');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate(['name' => 'required|unique:tags,name,'.$tag->id]);
        $validated['slug'] = Str::slug($validated['name']);
        $tag->update($validated);
        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil diupdate');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag berhasil dihapus');
    }
}
