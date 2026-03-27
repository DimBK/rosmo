<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $team = TeamMember::orderBy('sort_order')->get();
        return view('admin.team_members.index', compact('team'));
    }

    public function create()
    {
        return view('admin.team_members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'photo' => 'nullable|image',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/team');
            $validated['photo'] = str_replace('public/', 'storage/', $path);
        }

        TeamMember::create($validated);

        return redirect()->route('admin.team_members.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('admin.team_members.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'photo' => 'nullable|image',
        ]);

        if ($request->hasFile('photo')) {
            if ($teamMember->photo) {
                Storage::delete(str_replace('storage/', 'public/', $teamMember->photo));
            }
            $path = $request->file('photo')->store('public/team');
            $validated['photo'] = str_replace('public/', 'storage/', $path);
        }

        $teamMember->update($validated);

        return redirect()->route('admin.team_members.index')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(TeamMember $teamMember)
    {
        if ($teamMember->photo) {
            Storage::delete(str_replace('storage/', 'public/', $teamMember->photo));
        }
        $teamMember->delete();
        return redirect()->route('admin.team_members.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
