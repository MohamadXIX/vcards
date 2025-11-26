<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Top Bar --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-lg font-semibold text-gray-700"></h1>
            <a href="{{ route('contacts.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                      rounded-md font-semibold text-xs  uppercase tracking-widest
                      hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none
                      focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out">
                + New Contact
            </a>
        </div>

        {{-- Table Wrapper --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($contacts as $contact)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $contact->id }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $contact->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $contact->phone }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $contact->email }}</td>

                                <td class="px-4 py-3">
                                    @if($contact->is_active)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold
                                                     rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold
                                                     rounded-full bg-gray-200 text-gray-700">
                                            Disabled
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <a href="{{ route('contacts.qr', $contact) }}"
                                       class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs
                                              font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        View QR
                                    </a>
                                </td>

                                <td class="px-4 py-3 space-x-2">
                                    <a href="{{ route('contacts.edit', $contact) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-xs
                                              rounded-md hover:bg-yellow-600">
                                        Edit
                                    </a>

                                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Delete this contact?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs
                                                   rounded-md hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-gray-400 text-sm">
                                    No contacts found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
