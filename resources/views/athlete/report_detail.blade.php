<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport Bulanan Atlet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="min-h-screen flex flex-col lg:flex-row bg-gray-100">
    
    @include('partials.sidebar-athlete')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Header -->
        <header class="bg-white shadow-sm p-4 flex justify-between items-center border-b border-gray-100 relative w-full z-20">
            <div class="flex items-center space-x-3 min-w-0">
                <button id="hamburgerBtn" type="button" class="lg:hidden bg-slate-900 hover:bg-slate-800 text-white p-2.5 rounded-xl shadow-md focus:outline-none transition flex items-center justify-center flex-shrink-0 w-10 h-10" aria-label="Open Sidebar">
                    <i class="fas fa-bars text-base"></i>
                </button>
                
                <h2 class="text-base lg:text-xl font-bold text-gray-800 truncate select-none">
                    Raport Bulanan Atlet
                </h2>
            </div>
            
            <div class="flex items-center space-x-2 flex-shrink-0">
                <span class="text-xs lg:text-sm text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100 font-medium max-w-[150px] lg:max-w-none truncate">
                    <i class="far fa-user text-indigo-500 mr-1.5"></i>Halo, {{ Auth::user()->name }}
                </span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8 max-w-[1200px] w-full mx-auto space-y-6">
            
            <!-- Filter Periode Bulan -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Evaluasi Perkembangan</h3>
                    <p class="text-xs text-gray-500">Pilih periode bulan untuk melihat catatan evaluasi dari pelatih.</p>
                </div>
                
                <form method="GET" action="{{ route('athlete.report_detail') }}" class="flex items-center gap-2">
                    <input type="month" name="bulan" value="{{ $selectedMonth }}" class="border border-gray-300 rounded-xl p-2.5 text-sm font-semibold text-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition flex items-center gap-2">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>

            <!-- Card Hasil Evaluasi -->
            @if($report)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-indigo-600 p-6 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <span class="text-xs font-semibold bg-indigo-500/50 px-3 py-1 rounded-full uppercase tracking-wider text-indigo-100">
                                Periode Evaluasi
                            </span>
                            <h4 class="text-2xl font-bold mt-1">
                                {{ \Carbon\Carbon::parse($report->bulan_tahun)->translatedFormat('F Y') }}
                            </h4>
                        </div>
                        <div class="flex items-center gap-3 bg-indigo-700/50 p-2.5 rounded-xl border border-indigo-400/30">
                            <div class="w-10 h-10 rounded-full bg-white text-indigo-600 font-bold flex items-center justify-center text-sm uppercase">
                                {{ substr($report->coach->name ?? 'P', 0, 2) }}
                            </div>
                            <div class="text-left">
                                <p class="text-[10px] text-indigo-200 uppercase font-medium">Pelatih / Coach</p>
                                <p class="text-sm font-bold text-white">{{ $report->coach->name ?? 'Pelatih' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-8 space-y-4">
                        <h5 class="text-sm font-bold uppercase tracking-wider text-gray-400 flex items-center gap-2">
                            <i class="fas fa-comment-dots text-indigo-500"></i> Catatan & Evaluasi Pelatih
                        </h5>
                        <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-6 text-gray-700 leading-relaxed font-normal whitespace-pre-line text-base">
                            {{ $report->catatan_evaluasi }}
                        </div>
                        <p class="text-xs text-gray-400 italic text-right">
                            *Diperbarui pada {{ \Carbon\Carbon::parse($report->updated_at)->translatedFormat('d F Y, H:i') }} WIB
                        </p>
                    </div>
                </div>
            @else
                <!-- Tampilan Jika Evaluasi Belum Tersedia -->
                <div class="bg-white p-12 rounded-2xl shadow-sm border border-gray-100 text-center max-w-xl mx-auto my-8 space-y-4">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto text-2xl">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">Evaluasi Belum Tersedia</h4>
                        <p class="text-gray-500 text-sm mt-1">
                            Belum ada catatan evaluasi dari pelatih untuk bulan <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}</span>. Silakan pilih periode bulan lain atau hubungi pelatih Anda.
                        </p>
                    </div>
                </div>
            @endif

        </main>
    </div>
</div>

</body>
</html>