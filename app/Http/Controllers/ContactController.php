<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ContactController extends Controller
{
    // List all contacts
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);

        return view('contacts.index', compact('contacts'));
    }

    // Show create form
    public function create()
    {
        return view('contacts.create');
    }

    // Store new contact
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:50',
            'email'     => 'nullable|email|max:255',
            'company'   => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'website'   => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:255',
            'notes'     => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $contact = Contact::create($data);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    // Edit form
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    // Update contact (QR stays same because uuid doesn’t change)
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:50',
            'email'     => 'nullable|email|max:255',
            'company'   => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'website'   => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:255',
            'notes'     => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $contact->update($data);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    // Delete
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }

    // Show QR code (admin view)
    public function qr(Contact $contact)
    {
        $scanUrl = route('contacts.vcard', $contact->uuid);

        // We pass only the URL, and draw QR in Blade using the facade
        return view('contacts.partials.qr', compact('contact', 'scanUrl'));
    }

    // Public: generate and return vCard when QR is scanned
    public function vcard($uuid)
    {
        $contact = Contact::where('uuid', $uuid)
            ->where('is_active', true)
            ->firstOrFail();

        $vcard  = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:{$contact->name}\r\n";
        if ($contact->company || $contact->job_title) {
            $org = trim($contact->company . ($contact->job_title ? " ({$contact->job_title})" : ''));
            $vcard .= "ORG:{$org}\r\n";
        }
        $vcard .= "TEL;TYPE=CELL:{$contact->phone}\r\n";
        if ($contact->email) {
            $vcard .= "EMAIL:{$contact->email}\r\n";
        }
        if ($contact->website) {
            $vcard .= "URL:{$contact->website}\r\n";
        }
        if ($contact->address) {
            // Basic address (street only)
            $vcard .= "ADR;TYPE=WORK:;;{$contact->address};;;;\r\n";
        }
        if ($contact->notes) {
            $vcard .= "NOTE:" . str_replace(["\r\n", "\n"], "\\n", $contact->notes) . "\r\n";
        }
        $vcard .= "END:VCARD\r\n";

        return response($vcard, 200)
            ->header('Content-Type', 'text/vcard; charset=utf-8')
            ->header('Content-Disposition', 'inline; filename="contact.vcf"');
    }
}
