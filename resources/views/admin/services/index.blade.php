<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3">
            <div>
                <span class="text-xs font-semibold text-pink-600 bg-pink-50 px-2.5 py-0.5 rounded-full border border-pink-200">Katalog Layanan</span>
                <h2 class="font-bold text-xl text-gray-800 leading-tight mt-1">Daftar Paket & Tarif Layanan</h2>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-pink-50 text-pink-700 border border-pink-200 font-semibold text-xs uppercase tracking-wider rounded-xl shadow-sm transition">
                    &larr; Dashboard Pesanan
                </a>
                <a href="{{ route('customer.index') }}" class="inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs uppercase tracking-wider rounded-xl shadow-sm transition">
                    Halaman Pelanggan
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-semibold text-xs uppercase tracking-wider rounded-xl shadow-sm transition cursor-pointer">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-5">
            <a href="{{ route('services.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm transition inline-flex items-center gap-1.5">
                <span>+</span> Tambah Service
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 p-4 rounded-xl mb-5 font-medium shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="bg-white border border-pink-100 shadow-sm rounded-2xl overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-pink-50/60 border-b border-pink-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="p-4 text-center font-bold">Gambar</th>
                        <th class="p-4 font-bold">Nama</th>
                        <th class="p-4 font-bold">Kategori</th>
                        <th class="p-4 font-bold">Harga</th>
                        <th class="p-4 text-center font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-50 text-sm">
                    @foreach($services as $service)
                    <tr class="hover:bg-pink-50/20 transition">
                        <td class="p-4 text-center">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" class="w-14 h-14 object-cover mx-auto rounded-xl border border-pink-100 shadow-xs">
                            @else
                                <div class="w-14 h-14 rounded-xl bg-pink-50 border border-pink-100 flex items-center justify-center mx-auto text-pink-300 text-[10px] font-medium">
                                    No Image
                                </div>
                            @endif
                        </td>
                        <td class="p-4 font-semibold text-gray-800">{{ $service->service_name }}</td>
                        <td class="p-4">
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-pink-100 text-pink-700 border border-pink-200">
                                {{ $service->category }}
                            </span>
                        </td>
                        <td class="p-4 font-bold text-pink-600">Rp {{ number_format($service->price_per_unit, 0, ',', '.') }} <span class="text-xs text-gray-400 font-normal">/ {{ $service->unit_type }}</span></td>
                        <td class="p-4 text-center">
                            <a href="{{ route('services.edit', $service->id) }}" class="text-pink-600 hover:text-pink-700 font-semibold mr-3 text-xs bg-pink-50 hover:bg-pink-100 border border-pink-200 px-3 py-1.5 rounded-lg transition inline-block">Edit</a>
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus data ini?')" class="text-rose-600 hover:text-rose-700 font-semibold text-xs bg-rose-50 hover:bg-rose-100 border border-rose-200 px-3 py-1.5 rounded-lg transition inline-block cursor-pointer">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-5">{{ $services->links() }}</div>
    </div>
</x-app-layout>
