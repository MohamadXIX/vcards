<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\AppLink;
use Illuminate\Http\Request;

class AppLinkController extends Controller
{
    public function index()
    {
        $links = AppLink::latest()->paginate(10);
        return view('app_links.index', compact('links'));
    }

    public function create()
    {
        return view('app_links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'ios_url' => 'required|url',
            'android_url' => 'required|url',
        ]);

        AppLink::create([
            'name' => $request->name,
            'ios_url' => $request->ios_url,
            'android_url' => $request->android_url,
            'slug' => Str::uuid(),
        ]);

        return redirect()->route('app-links.index')->with('success', 'QR created successfully!');
    }

    public function edit(AppLink $appLink)
    {
        return view('app_links.edit', compact('appLink'));
    }

    public function update(Request $request, AppLink $appLink)
    {
        $request->validate([
            'name' => 'required',
            'ios_url' => 'required|url',
            'android_url' => 'required|url',
        ]);

        $appLink->update($request->only(['name', 'ios_url', 'android_url']));

        return back()->with('success', 'Updated successfully!');
    }

    public function destroy(AppLink $appLink)
    {
        $appLink->delete();
        return back()->with('success', 'Deleted successfully!');
    }

    // Device detection redirect
    public function redirect(AppLink $appLink)
    {
        $agent = request()->header('User-Agent');

        if (preg_match('/iPhone|iPad|iPod/i', $agent)) {
            return redirect()->away($appLink->ios_url);
        }

        if (preg_match('/Android/i', $agent)) {
            return redirect()->away($appLink->android_url);
        }

        return redirect()->away($appLink->ios_url); // fallback
    }
}
