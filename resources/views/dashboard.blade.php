<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3">
            <div>
                <span class="text-xs font-semibold text-pink-600 bg-pink-50 px-2.5 py-0.5 rounded-full border border-pink-200">Panel Admin</span>
                <h2 class="font-bold text-xl text-gray-800 leading-tight mt-1">
                    {{ __('Daftar Pesanan Masuk') }}
                </h2>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider shadow-sm transition">
                    Kelola Layanan
                </a>
                <a href="{{ route('customer.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-pink-50 text-pink-700 border border-pink-200 rounded-xl font-semibold text-xs uppercase tracking-wider shadow-sm transition">
                    Halaman Pelanggan &rarr;
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

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-5 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-xl shadow-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-pink-100">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-pink-50/60 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="p-4 border-b border-pink-100 font-bold"># ID</th>
                                <th class="p-4 border-b border-pink-100 font-bold">Pelanggan</th>
                                <th class="p-4 border-b border-pink-100 font-bold">Nomor WhatsApp</th>
                                <th class="p-4 border-b border-pink-100 font-bold">Rincian Pesanan</th>
                                <th class="p-4 border-b border-pink-100 font-bold">Total Harga</th>
                                <th class="p-4 border-b border-pink-100 font-bold">Status</th>
                                <th class="p-4 border-b border-pink-100 text-center font-bold">Aksi Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-pink-50 text-sm">
                            @forelse($orders as $order)
                                <tr class="hover:bg-pink-50/20 transition">
                                    <td class="p-4 font-bold text-gray-700">#{{ $order->id }}</td>
                                    <td class="p-4 font-semibold text-gray-800">{{ $order->customer_name }}</td>
                                    <td class="p-4">
                                        <span class="text-gray-600 font-mono text-xs bg-gray-50 px-2 py-1 rounded-md border border-gray-200">
                                            {{ $order->whatsapp_number }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <ul class="list-disc list-inside space-y-1 text-gray-600 text-xs">
                                            @foreach($order->orderDetails as $detail)
                                                <li>
                                                    <strong class="text-gray-800">{{ $detail->service->service_name ?? 'Layanan tidak tersedia' }}</strong>
                                                    x{{ $detail->quantity }} 
                                                    <span class="text-gray-400 font-medium">(Rp {{ number_format($detail->subtotal, 0, ',', '.') }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="p-4 font-bold text-pink-600">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                        @if($order->status === 'TransaksiMasuk')
                                            <span class="bg-amber-50 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full border border-amber-200">TRANSAKSI MASUK</span>
                                        @elseif($order->status === 'Proses')
                                            <span class="bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full border border-blue-200">PROSES</span>
                                        @else
                                            <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-full border border-emerald-200">SELESAI</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="text-xs border border-pink-200 rounded-lg p-1.5 bg-white shadow-sm font-semibold text-gray-700 focus:border-pink-500 focus:ring-1 focus:ring-pink-200 outline-none">
                                                <option value="TransaksiMasuk" {{ $order->status === 'TransaksiMasuk' ? 'selected' : '' }}>Transaksi Masuk</option>
                                                <option value="Proses" {{ $order->status === 'Proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="Selesai" {{ $order->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>  
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400">Belum ada pesanan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
