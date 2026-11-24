<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <span class="text-xs font-semibold text-pink-600 bg-pink-50 px-2.5 py-0.5 rounded-full border border-pink-200">Form Layanan</span>
                <h2 class="font-bold text-xl text-gray-800 leading-tight mt-1">Edit Paket / Tarif Layanan</h2>
            </div>
            <a href="{{ route('services.index') }}" class="text-xs font-semibold text-pink-600 hover:text-pink-700 bg-white border border-pink-200 px-3.5 py-2 rounded-xl transition">
                &larr; Kembali ke Daftar Layanan
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-2xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-xl shadow-sm">
                <p class="font-bold mb-1">Terjadi kesalahan input:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-pink-100">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Service</label>
                <input type="text" name="service_name" value="{{ old('service_name', $service->service_name) }}" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none transition bg-pink-50/10" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori</label>
                <select name="category" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none transition bg-white" required>
                    <option value="Reguler" {{ old('category', $service->category) === 'Reguler' ? 'selected' : '' }}>Reguler</option>
                    <option value="Express" {{ old('category', $service->category) === 'Express' ? 'selected' : '' }}>Express</option>
                    <option value="SuperKilat" {{ old('category', $service->category) === 'SuperKilat' ? 'selected' : '' }}>SuperKilat</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga per Unit (Rp)</label>
                <input type="number" name="price_per_unit" value="{{ old('price_per_unit', $service->price_per_unit) }}" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none transition bg-pink-50/10" min="1" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe Unit</label>
                <select name="unit_type" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none transition bg-white" required>
                    <option value="Kg" {{ old('unit_type', $service->unit_type) === 'Kg' ? 'selected' : '' }}>Kg</option>
                    <option value="Pcs" {{ old('unit_type', $service->unit_type) === 'Pcs' ? 'selected' : '' }}>Pcs</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none transition bg-pink-50/10" rows="3">{{ old('description', $service->description) }}</textarea>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gambar Service</label>
                @if ($service->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $service->image) }}" class="w-24 h-24 object-cover rounded-xl border border-pink-200 shadow-xs">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full border border-pink-200 rounded-xl p-2 bg-pink-50/20 text-sm">
                <span class="text-xs text-gray-500 mt-1 block">Pilih file baru jika ingin mengganti gambar.</span>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-sm transition cursor-pointer">Update Data</button>
                <a href="{{ route('services.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-semibold px-4 py-2.5 rounded-xl transition">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
