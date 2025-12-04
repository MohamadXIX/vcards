<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('App Links') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Top Bar --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-lg font-semibold text-gray-700"></h1>
            <a href="{{ route('app-links.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                      rounded-md font-semibold text-xs  uppercase tracking-widest
                      hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none
                      focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out">
                + New QR
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
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Download</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($links as $link)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $link->id }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $link->name }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    {!! QrCode::size(120)->generate(url('/qr/'.$link->slug)) !!}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    <a href="{{ route('qr.download', $link->id) }}" class="btn btn-sm btn-primary">
                                        Download SVG
                                    </a>
                                </td>

                                <td class="px-4 py-3 space-x-2">
                                    <a href="{{ route('app-links.edit', $link) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-xs
                                              rounded-md hover:bg-yellow-600">
                                        Edit
                                    </a>

                                    <form action="{{ route('app-links.destroy', $link) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Delete this QR?')">
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
                                    No App Links found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $links->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
