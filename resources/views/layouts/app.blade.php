<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Page Title -->
    <title>@yield('title', 'WhatsApp Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- Optional: For Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    <!-- Sidebar -->
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gray-800 text-gray-200 p-4 flex flex-col items-center">
            <!-- Logo -->
            <!-- Logo -->
<div class="mb-6">
    <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-24 h-24 rounded-full shadow-lg">
</div>

            
            <ul class="w-full">
                <li class="mb-2">
    <a href="{{ route('dashboard') }}" class="flex items-center py-2 px-3 rounded hover:bg-indigo-600">
        <i data-feather="home" class="w-5 h-5 mr-2"></i> Dashboard
    </a>
</li>

<li class="mb-2">
    <a href="{{ route('ropa.index') }}" class="flex items-center py-2 px-3 rounded hover:bg-indigo-600">
        <i data-feather="file-text" class="w-5 h-5 mr-2"></i> ROPA Register
    </a>
</li>


<li class="mb-2">
    <a href="" class="flex items-center py-2 px-3 rounded hover:bg-indigo-600 hover:text-white">
        <i data-feather="alert-circle" class="w-5 h-5 mr-2"></i> Risk Assessment
    </a>
</li>

<li class="mb-2">
    <a href="" class="flex items-center py-2 px-3 rounded hover:bg-indigo-600">
        <i data-feather="check-square" class="w-5 h-5 mr-2"></i> Reviews
    </a>
</li>

<li class="mb-2">
    <a href="{{ route('admin') }}" class="flex items-center py-2 px-3 rounded hover:bg-indigo-600">
        <i data-feather="settings" class="w-5 h-5 mr-2"></i> Admin
    </a>
</li>


            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <script>
        feather.replace()
    </script>
</body>
</html>
