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
                    <table class="min-w-full bg-white shadow rounded">
            <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">QR</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($links as $link)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $link->name }}</td>

                    <td class="px-4 py-2">
                        {!! QrCode::size(120)->generate(url('/qr/'.$link->slug)) !!}
                    </td>

                    <td class="px-4 py-2">
                        <a href="{{ route('app-links.edit', $link) }}"
                           class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</a>

                        <form action="{{ route('app-links.destroy', $link) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>
                        </form>

                        <a href="{{ url('/qr/'.$link->slug) }}"
                           class="px-2 py-1 bg-gray-700 text-white rounded" target="_blank">
                            Test Redirect
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $links->links() }}</div>
            </div>
        </div>

    </div>
</x-app-layout>
