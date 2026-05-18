<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;

class AboutSectionController extends Controller
{
    public function index()
    {
        $sections = AboutSection::latest()->get();

        return view('host.about-sections.index', compact('sections'));
    }

    public function create()
    {
        return view('host.about-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        AboutSection::create($validated);

        return redirect()
            ->route('host.about-sections.index')
            ->with('success', 'About section đã được tạo.');
    }

    public function edit(AboutSection $about_section)
    {
        return view('host.about-sections.edit', compact('about_section'));
    }

    public function update(Request $request, AboutSection $about_section)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $about_section->update($validated);

        return redirect()
            ->route('host.about-sections.index')
            ->with('success', 'About section đã được cập nhật.');
    }

    public function destroy(AboutSection $about_section)
    {
        $about_section->delete();

        return back()->with('success', 'About section đã được xóa.');
    }
}