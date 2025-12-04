<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
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

        return redirect()->route('app-links.index')->with('success', 'Updated successfully!');
    }

    public function destroy(AppLink $appLink)
    {
        $appLink->delete();
        return back()->with('success', 'Deleted successfully!');
    }

    public function download($id)
    {
        $qr = AppLink::findOrFail($id);

        // The permanent redirect URL stored in the database
        $redirectUrl = url('/qr/' . $qr->slug);

        // Generate PNG QR code
        $qrPng = QrCode::format('svg')
            ->size(500)
            ->margin(2)
            ->generate($redirectUrl);

        // // Optional: You may store it if needed
        // $filename = 'qr-' . $qr->slug . '.png';
        // Storage::disk('public')->put('qrcodes/'.$filename, $qrPng);

        // Return download
        return response($qrPng)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qr-code.svg"');
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
