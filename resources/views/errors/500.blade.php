<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terjadi Kesalahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                    500
                </div>
                <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                    Terjadi Kesalahan Server Internal.
                </div>
            </div>
            <div class="mt-4 text-gray-600">
                Maaf, saat ini kami sedang mengalami masalah teknis. Silakan coba beberapa saat lagi atau hubungi administrator.
            </div>
            <div class="mt-6">
                <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>