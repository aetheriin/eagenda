<div class="{{ $width ?? 'w-1/4' }} mb-4">
    <label class="block text-gray-700 font-semibold mb-1">
        Nomor Urut <span class="text-red-500">*</span>
    </label>
    <input type="text" 
           name="{{ $name ?? 'nomor_urut' }}" 
           value="{{ $value ?? '' }}" 
           readonly
           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
</div>
