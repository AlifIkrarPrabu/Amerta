<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi & Riwayat Pembayaran - D'AMERTA SWIM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="min-h-screen flex flex-col lg:flex-row bg-gray-100">
    
    @include('partials.sidebar-athlete')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top Bar Header -->
        <header class="bg-white shadow-sm p-4 flex justify-between items-center border-b border-gray-100 relative w-full z-20">
            <div class="flex items-center space-x-3 min-w-0">
                <button id="hamburgerBtn" type="button" class="lg:hidden bg-slate-900 hover:bg-slate-800 text-white p-2.5 rounded-xl shadow-md focus:outline-none transition flex items-center justify-center flex-shrink-0 w-10 h-10" aria-label="Open Sidebar">
                    <i class="fas fa-bars text-base"></i>
                </button>
                
                <h2 class="text-base lg:text-xl font-bold text-gray-800 truncate select-none">
                    Informasi & Riwayat Pembayaran
                </h2>
            </div>
            
            <div class="flex items-center space-x-2 flex-shrink-0">
                <span class="text-xs lg:text-sm text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100 font-medium max-w-[150px] lg:max-w-none truncate">
                    <i class="far fa-user text-indigo-500 mr-1.5"></i>Halo, {{ Auth::user()->name }}
                </span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8 max-w-[1200px] w-full mx-auto space-y-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Kolom Kiri: Card Utama Rekening & Info -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-indigo-600 p-6 text-white flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold bg-indigo-500/50 px-3 py-1 rounded-full uppercase tracking-wider text-indigo-100">
                                    Transfer Bank
                                </span>
                                <h3 class="text-xl font-bold mt-2">D'AMERTA SWIM CLUB</h3>
                            </div>
                            <div class="p-3 bg-white/10 rounded-2xl backdrop-blur-sm">
                                <i class="fas fa-university text-3xl text-indigo-100"></i>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Nama Bank -->
                            <div class="border-b border-gray-100 pb-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Bank
                                </p>
                                <p class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-building-columns text-indigo-500"></i> Bank BCA
                                </p>
                            </div>

                            <!-- Nomor Rekening + Tombol Salin -->
                            <div class="border-b border-gray-100 pb-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Nomor Rekening
                                </p>
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-xl border border-gray-200">
                                    <span id="rekeningNum" class="text-xl font-mono font-bold text-indigo-600 tracking-wider">
                                        5745815461
                                    </span>
                                    <button onclick="copyToClipboard()" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 border border-indigo-200">
                                        <i class="far fa-copy"></i>
                                        <span id="copyBtnText">Salin</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Atas Nama / Pemilik Rekening -->
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Atas Nama (A.N)
                                </p>
                                <p class="text-base font-bold text-gray-800 uppercase flex items-center gap-2">
                                    <i class="fas fa-user-check text-indigo-500"></i> ALIF IKRAR PRABU
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Petunjuk Singkat -->
                    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 text-xs text-indigo-900 flex items-start gap-3">
                        <i class="fas fa-info-circle text-indigo-500 text-base mt-0.5 shrink-0"></i>
                        <p class="leading-relaxed">
                            Silakan lakukan pembayaran iuran bulanan secara tunai ke pelatih atau via transfer bank ke rekening di atas.
                        </p>
                    </div>
                </div>

                <!-- Kolom Kanan: Tabel Riwayat Pembayaran SPP Atlet -->
                <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-receipt text-indigo-600"></i> Riwayat Pembayaran SPP
                        </h3>
                        <span class="text-xs bg-indigo-50 text-indigo-600 font-semibold px-3 py-1 rounded-full border border-indigo-100">
                            Total Lunas: {{ $payments->count() }} Bulan
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 uppercase text-[11px] font-bold border-b border-gray-100">
                                    <th class="py-3 px-4">Bulan SPP</th>
                                    <th class="py-3 px-4">Tgl Bayar</th>
                                    <th class="py-3 px-4">Jumlah</th>
                                    <th class="py-3 px-4">Metode</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($payments as $pay)
                                    <tr class="hover:bg-gray-50/80 transition">
                                        <td class="py-3 px-4 font-bold text-gray-800">
                                            {{ \Carbon\Carbon::parse($pay->bulan_tahun . '-01')->translatedFormat('F Y') }}
                                        </td>
                                        <td class="py-3 px-4 text-gray-600 text-xs">
                                            {{ \Carbon\Carbon::parse($pay->tanggal_bayar)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="py-3 px-4 font-semibold text-emerald-600">
                                            Rp {{ number_format($pay->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-xs font-medium text-gray-600">
                                            <span class="inline-flex items-center gap-1">
                                                @if($pay->metode_pembayaran === 'Cash')
                                                    <i class="fas fa-money-bill-wave text-green-500"></i> Tunai
                                                @else
                                                    <i class="fas fa-credit-card text-blue-500"></i> Transfer
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="text-[11px] bg-green-100 text-green-700 font-bold px-2.5 py-0.5 rounded-full inline-flex items-center gap-1">
                                                <i class="fas fa-check-circle"></i> Lunas
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-400">
                                            <i class="fas fa-file-invoice text-3xl mb-2 block text-gray-300"></i>
                                            Belum ada catatan riwayat pembayaran SPP.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>

<script>
    function copyToClipboard() {
        const textToCopy = document.getElementById('rekeningNum').innerText.trim();
        navigator.clipboard.writeText(textToCopy).then(() => {
            const copyBtnText = document.getElementById('copyBtnText');
            copyBtnText.innerText = 'Tersalin!';
            setTimeout(() => {
                copyBtnText.innerText = 'Salin';
            }, 2000);
        });
    }
</script>

</body>
</html>