<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Contact') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">

        <div class="bg-white shadow-sm rounded-lg p-6">
            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">There were errors with your submission:</div>

                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('app-links.store') }}" method="POST">
                @csrf

                @include('app_links.partials.form')

                <div class="mt-6">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-indigo-600 text-sm font-semibold
                               rounded-md hover:bg-indigo-700 focus:ring ring-indigo-300 transition">
                        Save Contact
                    </button>
                </div>
            </form>

        </div>

    </div>
</x-app-layout>
