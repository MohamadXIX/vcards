<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            QR Code for {{ $contact->name }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">

        <div class="bg-white shadow-sm rounded-lg p-6">

            <p class="text-gray-700 mb-4">
                Scan this QR code to add the contact to your phone.
            </p>

            <div class="flex justify-center py-6">
                {!! QrCode::size(250)->margin(1)->generate($scanUrl) !!}
            </div>

            <div class="mt-4 text-sm text-gray-600 break-all">
                <strong>URL:</strong> {{ $scanUrl }}
            </div>

            <div class="mt-6">
                <a href="{{ route('contacts.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800
                          rounded-md hover:bg-gray-300 transition text-sm">
                    Back to Contacts
                </a>
            </div>

        </div>

    </div>
</x-app-layout>
