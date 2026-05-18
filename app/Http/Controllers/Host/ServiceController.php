<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();

        return view('host.services.index', compact('services'));
    }

    public function create()
    {
        return view('host.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        Service::create($validated);

        return redirect()
            ->route('host.services.index')
            ->with('success', 'Service đã được tạo.');
    }

    public function edit(Service $service)
    {
        return view('host.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $service->update($validated);

        return redirect()
            ->route('host.services.index')
            ->with('success', 'Service đã được cập nhật.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', 'Service đã được xóa.');
    }
}