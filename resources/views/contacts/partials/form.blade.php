@php
    $c = $contact ?? null;
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

    {{-- Phone --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
        <input type="number" name="phone"
               class="block w-full rounded-md border-gray-300 shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500"
               required value="{{ old('phone', $c->phone ?? '') }}">
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email"
               class="block w-full rounded-md border-gray-300 shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500"
               value="{{ old('email', $c->email ?? '') }}">
    </div>

    {{-- Company --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
        <input type="text" name="company"
               class="block w-full rounded-md border-gray-300 shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500"
               value="{{ old('company', $c->company ?? '') }}">
    </div>

    {{-- Job Title --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
        <input type="text" name="job_title"
               class="block w-full rounded-md border-gray-300 shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500"
               value="{{ old('job_title', $c->job_title ?? '') }}">
    </div>

    {{-- Website --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
        <input type="text" name="website"
               class="block w-full rounded-md border-gray-300 shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500"
               value="{{ old('website', $c->website ?? '') }}">
    </div>

    {{-- Address --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
        <input type="text" name="address"
               class="block w-full rounded-md border-gray-300 shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500"
               value="{{ old('address', $c->address ?? '') }}">
    </div>

    {{-- Notes --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
        <textarea name="notes" rows="3"
                  class="block w-full rounded-md border-gray-300 shadow-sm
                         focus:ring-indigo-500 focus:border-indigo-500">{{ old('notes', $c->notes ?? '') }}</textarea>
    </div>

    {{-- Active Toggle --}}
    <div class="flex items-center md:col-span-2">
        <input type="hidden" name="is_active" value="0">
        <input
            type="checkbox"
            name="is_active"
            value="1"
            id="is_active"
            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            {{ old('is_active', $c->is_active ?? true) ? 'checked' : '' }}>
        <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
    </div>

</div>
