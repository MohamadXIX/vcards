@php
    $c = $appLink ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Name --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
        <input type="text" name="name"
               class="block w-full rounded-md border-gray-300 shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500"
               required value="{{ old('name', $c->name ?? '') }}">
        @error('name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- IOS --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">iOS App Store Link *</label>
        <input type="url" name="ios_url"
               class="block w-full rounded-md border-gray-300 shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500"
               required value="{{ old('ios_url', $c->ios_url ?? '') }}">
    </div>

    {{-- ANDROID --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Play Store Link *</label>
        <input type="url" name="android_url"
               class="block w-full rounded-md border-gray-300 shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500"
               required value="{{ old('android_url', $c->android_url ?? '') }}">
    </div>


</div>
