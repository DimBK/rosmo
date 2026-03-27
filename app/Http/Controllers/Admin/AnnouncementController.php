<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index() {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }
    public function create() {
        return view('admin.announcements.create');
    }
    public function store(Request $request) {
        $data = $request->validate(['title' => 'required', 'content' => 'required', 'publish_date' => 'nullable|date']);
        Announcement::create($data);
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman added!');
    }
    public function edit(Announcement $announcement) {
        return view('admin.announcements.edit', compact('announcement'));
    }
    public function update(Request $request, Announcement $announcement) {
        $data = $request->validate(['title' => 'required', 'content' => 'required', 'publish_date' => 'nullable|date']);
        $announcement->update($data);
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman updated!');
    }
    public function destroy(Announcement $announcement) {
        $announcement->delete();
        return back()->with('success', 'Pengumuman deleted!');
    }
}