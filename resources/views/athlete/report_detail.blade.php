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
        
        <header class="bg-white shadow-sm p-4 flex justify-between items-center border-b border-gray-100 relative w-full z-20">
            <div class="flex items-center space-x-3 min-w-0">
                
                <button id="hamburgerBtn" type="button" class="lg:hidden bg-slate-900 hover:bg-slate-800 text-white p-2.5 rounded-xl shadow-md focus:outline-none transition flex items-center justify-center flex-shrink-0 w-10 h-10" aria-label="Open Sidebar">
                    <i class="fas fa-bars text-base"></i>
                </button>
                
                <h2 class="text-base lg:text-xl font-bold text-gray-800 truncate select-none">
                    Raport Bulanan
                </h2>
            </div>
            
            <div class="flex items-center space-x-2 flex-shrink-0">
                <span class="text-xs lg:text-sm text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100 font-medium max-w-[150px] lg:max-w-none truncate">
                    <i class="far fa-user text-indigo-500 mr-1.5"></i>Halo, {{ Auth::user()->name }}
                </span>
            </div>
        </header>

            <main class="flex-1 overflow-y-auto p-6 max-w-[1600px] w-full mx-auto">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center max-w-2xl mx-auto mt-12">
                    <div class="text-indigo-500 mb-4">
                        <i class="fas fa-file-invoice fa-3x"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Halaman Raport Evaluasi Bulanan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Fitur sistem ini siap diintegrasikan dengan modul tabel evaluasi perkembangan renang Anda selanjutnya tanpa menyebabkan crash sistem.
                    </p>
                </div>
            </main>
        </div>
    </div>
</body>
</html>