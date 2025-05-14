<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            // Anda bisa menambahkan kustomisasi Tailwind di sini jika perlu
            // contoh: colors: { clifford: '#da373d', }
          }
        }
      }
    </script>
    <!-- Fonts (opsional, bisa ganti dengan font lain) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <!-- Ganti dengan logo Anda atau teks -->
                <h1 class="text-4xl font-bold text-gray-700">{{ config('app.name', 'Laravel') }}</h1>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            @yield('slot') {{-- Atau 'content' jika Anda menamai slotnya demikian di guest.blade.php --}}
        </div>
    </div>
</body>
</html>