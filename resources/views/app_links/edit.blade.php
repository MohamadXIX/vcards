<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit App Link</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">

        <div class="bg-white shadow-sm rounded-lg p-6">

            <form action="{{ route('app-links.update', $appLink) }}" method="POST">
                @csrf
                @method('PUT')

                @include('app_links.partials.form', ['appLink' => $appLink])

                <div class="mt-6">
                    <button
                        class="inline-flex items-center px-6 py-2 bg-indigo-600 text-sm font-semibold
                               rounded-md hover:bg-indigo-700 focus:ring ring-indigo-300 transition">
                        Update App Link
                    </button>
                </div>
            </form>

        </div>

    </div>
</x-app-layout>
