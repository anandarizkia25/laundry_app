<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Express</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        softpink: {
                            50: '#fff5f7',
                            100: '#ffeef2',
                            200: '#ffd6e0',
                            300: '#fbb5c6',
                            400: '#f68ba6',
                            500: '#ed5f86',
                            600: '#db3f6b',
                            700: '#b82950',
                            800: '#992544',
                            900: '#80233d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-rose-50/40 text-gray-800 p-4 sm:p-6 font-sans min-h-screen">
    <div class="max-w-5xl mx-auto">
        <!-- Top Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mb-6 pb-4 border-b border-pink-100 bg-white/70 backdrop-blur-sm px-5 py-3 rounded-2xl shadow-sm">
            <a href="/" class="text-xs font-semibold text-pink-600 hover:text-pink-700 transition flex items-center gap-1.5">
                <span>&larr;</span> Halaman Utama
            </a>
            <div>
                @auth
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                            {{ Auth::user()->name }}
                            @if(Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                                <span class="text-[11px] bg-pink-100 text-pink-700 font-bold px-2.5 py-0.5 rounded-full border border-pink-200">Admin</span>
                            @else
                                <span class="text-[11px] bg-rose-100 text-rose-700 font-bold px-2.5 py-0.5 rounded-full border border-rose-200">Pelanggan</span>
                            @endif
                        </span>

                        @can('admin')
                            <a href="{{ route('dashboard') }}" class="rounded-xl bg-pink-500 px-3.5 py-1.5 text-xs font-semibold text-white transition hover:bg-pink-600 shadow-sm">
                                Dashboard Admin
                            </a>
                        @endcan

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="rounded-xl bg-gray-800 px-3.5 py-1.5 text-xs font-semibold text-white transition hover:bg-gray-700 cursor-pointer shadow-sm">
                                Keluar (Log Out)
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="rounded-xl bg-pink-500 px-4 py-1.5 text-xs font-semibold text-white transition hover:bg-pink-600 shadow-sm">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="rounded-xl bg-white px-4 py-1.5 text-xs font-semibold text-pink-600 border border-pink-200 transition hover:bg-pink-50 shadow-sm">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Header Title -->
        <div class="text-center mb-8">
            <span class="inline-block px-3 py-1 bg-pink-100 text-pink-700 text-xs font-semibold rounded-full mb-2 tracking-wide uppercase">Layanan Laundry Cepat & Bersih</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 tracking-tight">Laundry <span class="text-pink-500">Express</span></h1>
            <p class="text-gray-500 text-sm mt-1.5">Pilih layanan laundry yang Anda butuhkan dengan mudah & praktis</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-2xl mb-6 text-center font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-2xl mb-6 text-center font-semibold shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-2xl mb-6 font-semibold shadow-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Filter Categories -->
        <div class="flex flex-wrap justify-center gap-2.5 mb-8">
            <button type="button" onclick="filterCategory('all', this)" class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-pink-500 text-white shadow-sm border border-pink-500">Semua Layanan</button>
            <button type="button" onclick="filterCategory('Reguler', this)" class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-pink-50 hover:text-pink-600 border border-pink-200 shadow-sm">Reguler</button>
            <button type="button" onclick="filterCategory('Express', this)" class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-pink-50 hover:text-pink-600 border border-pink-200 shadow-sm">Express</button>
            <button type="button" onclick="filterCategory('SuperKilat', this)" class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-pink-50 hover:text-pink-600 border border-pink-200 shadow-sm">SuperKilat</button>
        </div>

        <!-- Order Form -->
        <form id="orderForm" action="{{ route('customer.checkout') }}" method="POST">
            @csrf

            <!-- Form Customer Info -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-pink-100 mb-8">
                <h2 class="text-base font-bold text-gray-800 mb-4 pb-2 border-b border-pink-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-xs font-bold">1</span>
                    Informasi Pelanggan
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" id="customer_name" name="customer_name" required placeholder="Masukkan nama pelanggan" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none transition bg-pink-50/20">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor WhatsApp</label>
                        <input type="text" id="whatsapp_number" name="whatsapp_number" required placeholder="Contoh: 081234567890" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none transition bg-pink-50/20">
                    </div>
                </div>
            </div>

            <!-- List Services -->
            <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-xs font-bold">2</span>
                Pilih Layanan
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($services as $service)
                    <div class="service-card bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden flex flex-col justify-between hover:shadow-md transition group" data-category="{{ $service->category ?? 'Reguler' }}">
                        <div>
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}" class="w-full h-44 object-cover">
                            @else
                                <div class="w-full h-32 bg-pink-50/60 flex items-center justify-center text-pink-300 text-xs font-medium border-b border-pink-100">
                                    Laundry Express
                                </div>
                            @endif

                            <div class="p-5">
                                <div class="flex justify-between items-center mb-2.5 gap-2">
                                    <span class="text-xs bg-pink-100 text-pink-700 font-semibold px-2.5 py-0.5 rounded-full border border-pink-200">
                                        {{ $service->category ?? 'Reguler' }}
                                    </span>
                                    <span class="font-bold text-pink-600 text-sm">
                                        Rp {{ number_format($service->price_per_unit, 0, ',', '.') }} / {{ $service->unit_type }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-gray-800 text-base item-name group-hover:text-pink-600 transition">{{ $service->service_name }}</h3>
                                @if($service->description)
                                    <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">{{ $service->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="p-4 bg-pink-50/30 border-t border-pink-100">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Jumlah ({{ $service->unit_type }})</label>
                            <input type="hidden" name="items[{{ $service->id }}][service_id]" value="{{ $service->id }}">
                            <input type="number" name="items[{{ $service->id }}][quantity]" min="0" value="0" data-name="{{ $service->service_name }}" data-price="{{ $service->price_per_unit }}" class="item-qty w-full border border-pink-200 rounded-xl px-3 py-1.5 text-center font-bold text-gray-700 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none bg-white transition">
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10 text-gray-500 bg-white rounded-2xl border border-pink-100">
                        Belum ada paket layanan yang tersedia.
                    </div>
                @endforelse
            </div>

            <!-- Submit Button -->
            <div class="mt-8 text-right">
                <button type="button" onclick="showConfirmationModal()" class="bg-pink-500 hover:bg-pink-600 text-white font-bold px-8 py-3 rounded-2xl shadow-sm hover:shadow transition cursor-pointer">
                    Pesan Sekarang &rarr;
                </button>
            </div>

            <!-- Confirmation Modal -->
            <div id="confirmModal" class="fixed inset-0 bg-black/40 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-pink-100 transform transition-all">
                    <h3 class="text-lg font-bold text-gray-800 border-b border-pink-100 pb-3 mb-4 flex items-center justify-between">
                        <span>Konfirmasi Pesanan</span>
                        <span class="text-xs font-normal text-pink-600 bg-pink-50 px-2.5 py-0.5 rounded-full border border-pink-200">Periksa Ulang</span>
                    </h3>
                    <div class="space-y-2 text-sm text-gray-600 mb-4 bg-pink-50/40 p-3.5 rounded-xl border border-pink-100">
                        <div class="flex justify-between"><span class="text-gray-500">Nama:</span> <span id="modalName" class="text-gray-900 font-bold"></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">WhatsApp:</span> <span id="modalWhatsApp" class="text-gray-900 font-bold"></span></div>
                    </div>
                    <div class="border-t border-b border-pink-100 py-3 mb-4 max-h-48 overflow-y-auto">
                        <p class="font-semibold text-xs text-pink-500 uppercase tracking-wider mb-2">Rincian Item</p>
                        <ul id="modalItemList" class="space-y-2 text-sm"></ul>
                    </div>
                    <div class="flex justify-between items-center text-base font-bold text-gray-800 mb-6 bg-pink-50/60 p-3.5 rounded-xl border border-pink-200">
                        <span>Total Pembayaran:</span>
                        <span id="modalTotalPrice" class="text-pink-600 text-lg">Rp 0</span>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeConfirmationModal()" class="w-1/2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="w-1/2 bg-pink-500 hover:bg-pink-600 text-white font-bold py-2.5 rounded-xl shadow-sm hover:shadow transition cursor-pointer">Ya, Kirim Pesanan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function filterCategory(category, element) {
            document.querySelectorAll('.btn-category').forEach(btn => {
                btn.className = 'btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-pink-50 hover:text-pink-600 border border-pink-200 shadow-sm';
            });

            element.className = 'btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-pink-500 text-white shadow-sm border border-pink-500';

            document.querySelectorAll('.service-card').forEach(card => {
                const matches = category === 'all' || card.getAttribute('data-category') === category;
                card.style.display = matches ? 'flex' : 'none';
            });
        }

        function formatCurrency(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function showConfirmationModal() {
            const name = document.getElementById('customer_name').value.trim();
            const whatsapp = document.getElementById('whatsapp_number').value.trim();

            if (!name || !whatsapp) {
                alert('Nama dan nomor WhatsApp wajib diisi.');
                return;
            }

            const items = [];
            let total = 0;

            document.querySelectorAll('.item-qty').forEach(input => {
                const qty = Number(input.value || 0);
                if (qty > 0) {
                    const nameText = input.dataset.name;
                    const price = Number(input.dataset.price || 0);
                    const subtotal = qty * price;
                    items.push({ name: nameText, qty, subtotal });
                    total += subtotal;
                }
            });

            if (items.length === 0) {
                alert('Pilih minimal satu layanan sebelum checkout.');
                return;
            }

            document.getElementById('modalName').textContent = name;
            document.getElementById('modalWhatsApp').textContent = whatsapp;

            const list = document.getElementById('modalItemList');
            list.innerHTML = items.map(item => `
                <li class="flex justify-between gap-3 text-gray-700">
                    <span>${item.name} x ${item.qty}</span>
                    <span class="font-semibold text-pink-600">${formatCurrency(item.subtotal)}</span>
                </li>
            `).join('');

            document.getElementById('modalTotalPrice').textContent = formatCurrency(total);
            document.getElementById('confirmModal').classList.remove('hidden');
            document.getElementById('confirmModal').classList.add('flex');
        }

        function closeConfirmationModal() {
            document.getElementById('confirmModal').classList.add('hidden');
            document.getElementById('confirmModal').classList.remove('flex');
        }
    </script>
</body>
</html>