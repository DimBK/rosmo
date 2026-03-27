<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceRequirementController extends Controller
{
    public function index()
    {
        $services = ServiceRequirement::with('parent')->latest()->get();
        return view('admin.service_requirements.index', compact('services'));
    }

    public function create()
    {
        $parents = ServiceRequirement::whereNull('parent_id')->get();
        return view('admin.service_requirements.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'parent_id' => 'nullable|exists:service_requirements,id',
            'content' => 'required',
            'highlights' => 'nullable',
            'included' => 'nullable',
            'not_included' => 'nullable',
            'image' => 'nullable|image',
            'status' => 'boolean'
        ]);

        $data['slug'] = \Illuminate\Support\Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        ServiceRequirement::create($data);
        return redirect()->route('admin.service_requirements.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(ServiceRequirement $service_requirement)
    {
        $parents = ServiceRequirement::whereNull('parent_id')->where('id', '!=', $service_requirement->id)->get();
        return view('admin.service_requirements.edit', compact('service_requirement', 'parents'));
    }

    public function update(Request $request, ServiceRequirement $service_requirement)
    {
        $data = $request->validate([
            'title' => 'required',
            'parent_id' => 'nullable|exists:service_requirements,id',
            'content' => 'required',
            'highlights' => 'nullable',
            'included' => 'nullable',
            'not_included' => 'nullable',
            'image' => 'nullable|image',
            'status' => 'boolean'
        ]);

        $data['slug'] = \Illuminate\Support\Str::slug($data['title']);

        if ($request->hasFile('image')) {
            if ($service_requirement->image) Storage::disk('public')->delete($service_requirement->image);
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service_requirement->update($data);
        return redirect()->route('admin.service_requirements.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(ServiceRequirement $service_requirement)
    {
        if ($service_requirement->image) Storage::disk('public')->delete($service_requirement->image);
        $service_requirement->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }
}
