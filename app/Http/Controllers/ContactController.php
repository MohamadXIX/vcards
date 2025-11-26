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
        // The QR links directly to the physical .vcf file
        $scanUrl = url("vcf/{$contact->uuid}.vcf");
        return view('contacts.qr', compact('contact', 'scanUrl'));
    }

    // -------------------------------------------------------------
    // PUBLIC VCARD ENDPOINT (OPTIONAL)
    // -------------------------------------------------------------
    public function vcard($uuid)
    {
        $filePath = public_path("vcf/{$uuid}.vcf");

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath, [
            'Content-Type'        => 'text/vcard',
            'Content-Disposition' => 'inline; filename=contact.vcf',
        ]);
    }

    // -------------------------------------------------------------
    // GENERATE VCF FILE (ANDROID + IOS COMPATIBLE)
    // -------------------------------------------------------------
    private function generateVcfFile(Contact $contact)
    {
        $vcard  = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:{$contact->name}\r\n";
        $vcard .= "TEL;TYPE=CELL:{$contact->phone}\r\n";

        if ($contact->email) {
            $vcard .= "EMAIL:{$contact->email}\r\n";
        }
        if ($contact->company) {
            $vcard .= "ORG:{$contact->company}\r\n";
        }
        if ($contact->job_title) {
            $vcard .= "TITLE:{$contact->job_title}\r\n";
        }
        if ($contact->website) {
            $vcard .= "URL:{$contact->website}\r\n";
        }
        if ($contact->address) {
            $vcard .= "ADR:;;{$contact->address}\r\n";
        }
        if ($contact->notes) {
            $notes = str_replace(["\n", "\r\n"], "\\n", $contact->notes);
            $vcard .= "NOTE:{$notes}\r\n";
        }

        $vcard .= "END:VCARD\r\n";

        // Path: public/vcf/{uuid}.vcf
        $path = public_path("vcf/{$contact->uuid}.vcf");

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        file_put_contents($path, $vcard);

        return true;
    }
}
