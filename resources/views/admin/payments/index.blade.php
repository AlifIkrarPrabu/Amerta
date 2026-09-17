<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembayaran SPP Atlet - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Header Navbar Admin -->
    <nav class="bg-slate-900 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-wallet text-indigo-400"></i> Kelola Pembayaran SPP Atlet
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-slate-800 hover:bg-slate-700 px-3.5 py-1.5 rounded-lg text-sm transition">
                <i class="fas fa-arrow-left mr-1"></i> Dashboard Admin
            </a>
        </div>
    </nav>

    <main class="container mx-auto p-4 md:p-8 space-y-8 max-w-7xl">

        @if(session('success'))
            <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Form Input Pembayaran SPP Baru -->
            <div class="lg:col-span-4 bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
                <h2 class="text-lg font-bold text-gray-800 border-b pb-3 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-indigo-600"></i> Catat Pembayaran SPP
                </h2>

                <form action="{{ route('admin.payments.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Atlet</label>
                        <select name="athlete_id" required class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Atlet --</option>
                            @foreach($athletes as $athlete)
                                <option value="{{ $athlete->id }}">{{ $athlete->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Untuk SPP Bulan & Tahun</label>
                        <input type="month" name="bulan_tahun" required class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-indigo-500 focus:border-indigo-500" value="{{ date('Y-m') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transaksi / Bayar</label>
                        <input type="date" name="tanggal_bayar" required class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-indigo-500 focus:border-indigo-500" value="{{ date('Y-m-d') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pembayaran (Rp)</label>
                        <input type="number" name="jumlah" required placeholder="Contoh: 150000" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                        <select name="metode_pembayaran" required class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="Cash">Cash / Tunai (via Pelatih/Admin)</option>
                            <option value="Transfer">Transfer Bank</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                        <input type="text" name="catatan" placeholder="Keterangan tambahan..." class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-md transition">
                        <i class="fas fa-save mr-1"></i> Simpan Pembayaran
                    </button>
                </form>
            </div>

            <!-- Tabel Data Riwayat Pembayaran Seluruh Atlet -->
            <div class="lg:col-span-8 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <h2 class="text-lg font-bold text-gray-800">Daftar SPP Terbayar</h2>
                    
                    <form method="GET" action="{{ route('admin.payments.index') }}" class="flex items-center gap-2">
                        <input type="month" name="bulan" value="{{ $selectedMonth }}" class="border border-gray-300 rounded-lg p-2 text-sm">
                        <button type="submit" class="bg-gray-800 text-white px-3 py-2 rounded-lg text-sm font-semibold hover:bg-gray-700">
                            Filter
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-3">Nama Atlet</th>
                                <th class="px-6 py-3">Bulan SPP</th>
                                <th class="px-6 py-3">Tgl Bayar</th>
                                <th class="px-6 py-3">Nominal</th>
                                <th class="px-6 py-3">Metode</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse($payments as $pay)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $pay->athlete->name ?? 'Atlet Terhapus' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($pay->bulan_tahun . '-01')->translatedFormat('F Y') }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600">
                                    {{ \Carbon\Carbon::parse($pay->tanggal_bayar)->translatedFormat('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-emerald-600">
                                    Rp {{ number_format($pay->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    <span class="px-2 py-1 rounded font-semibold {{ $pay->metode_pembayaran === 'Cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $pay->metode_pembayaran }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.payments.destroy', $pay->id) }}" method="POST" onsubmit="return confirm('Hapus data pembayaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                    Belum ada data pembayaran pada bulan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t">
                    {{ $payments->links() }}
                </div>
            </div>

        </div>

    </main>
</body>
</html>