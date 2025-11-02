@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Top Navigation -->
<nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 flex justify-between items-center h-16">
        <!-- Left: Logo / Brand -->
        <div class="flex items-center space-x-3">
            <i data-feather="layers" class="w-6 h-6 text-indigo-600"></i>
            <span class="font-bold text-xl text-gray-800 dark:text-gray-100">Dashboard</span>
        </div>

        <!-- Right: User Dropdown -->
        <div class="relative">
            <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                <i data-feather="user" class="w-6 h-6 text-gray-600 dark:text-gray-300"></i>
                <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                <i data-feather="chevron-down" class="w-4 h-4 text-gray-600 dark:text-gray-300"></i>
            </button>

            <!-- Dropdown -->
            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 shadow-lg rounded-lg py-2 z-50">
                <a href="#" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- <script>
    feather.replace();

    // User dropdown toggle
    document.getElementById('userMenuButton').addEventListener('click', function () {
        document.getElementById('userDropdown').classList.toggle('hidden');
    });
</script> -->


<!-- Main Dashboard -->
<div class="container mx-auto py-6">
    <!-- Title -->
   <div class="mb-6">
    <h1 class="text-3xl font-bold">ROPA Dashboard</h1>
    <p class="text-gray-600 dark:text-gray-400 mt-2">Overview of data processing activities and compliance status</p>
</div>


    <!-- Stats Cards: 4 cards in one row on large screens -->
    <!-- Stats Cards: 4 cards in one row on large screens -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Card 1: Total ROPA Records -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <span class="text-lg font-semibold">Total ROPA Records</span>
            <span class="text-sm text-green-600 font-semibold">+12%</span>
        </div>
        <div class="mt-4 text-3xl font-bold text-gray-900 dark:text-gray-100">3</div>
    </div>


     <!-- Card 2: Pending Reviews -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
    <div class="flex items-center justify-between">
        <span class="text-lg font-semibold">Pending Reviews</span>
        <span class="text-sm text-red-600 font-semibold">-5%</span>
    </div>
    <div class="mt-4 text-3xl font-bold text-gray-900 dark:text-gray-100">2</div>
</div>

      <!-- Card 3: Overdue Reviews -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
    <div class="flex items-center justify-between">
        <span class="text-lg font-semibold">Overdue Reviews</span>
        <span class="text-sm text-green-600 font-semibold">+2</span>
    </div>
    <div class="mt-4 text-3xl font-bold text-gray-900 dark:text-gray-100">0</div>
</div>


        <!-- Card 4 -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <i data-feather="check-circle" class="w-7 h-7 mr-3 text-red-600"></i>
                <span class="text-lg font-semibold">Tasks Completed</span>
            </div>
            <div class="mt-4 text-3xl font-bold text-gray-900 dark:text-gray-100">87</div>
        </div>
    </div>
<!-- Two Cards Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Card 1: Distribution -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
        <h2 class="text-xl font-bold mb-4 flex items-center">
            <i data-feather="bar-chart-2" class="w-6 h-6 mr-2 text-indigo-600"></i> Distribution
        </h2>

        <div class="space-y-4">
            <!-- High Risk -->
            <div class="flex justify-between items-center">
                <div>
                    <span class="font-semibold">High Risk</span>
                </div>
                <div class="text-gray-700 dark:text-gray-300">
                    <span class="font-bold">0</span> (0% of total records)
                </div>
            </div>

            <!-- Medium Risk -->
            <div class="flex justify-between items-center">
                <div>
                    <span class="font-semibold">Medium Risk</span>
                </div>
                <div class="text-gray-700 dark:text-gray-300">
                    <span class="font-bold">1</span> (8% of total records)
                </div>
            </div>

            <!-- Low Risk -->
            <div class="flex justify-between items-center">
                <div>
                    <span class="font-semibold">Low Risk</span>
                </div>
                <div class="text-gray-700 dark:text-gray-300">
                    <span class="font-bold">2</span> (17% of total records)
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Recent Activity -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
        <h2 class="text-xl font-bold mb-4 flex items-center">
            <i data-feather="activity" class="w-6 h-6 mr-2 text-indigo-600"></i> Recent Activity
        </h2>

        <div class="space-y-4">
            <!-- Activity Item 1 -->
            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-semibold">System Access Logs</span>
                    <span class="text-sm text-gray-500 dark:text-gray-300">22/10/2025</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300">IT • Emma Wilson — <span class="font-semibold">under review</span></p>
            </div>

            <!-- Activity Item 2 -->
            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-semibold">Customer Newsletter</span>
                    <span class="text-sm text-gray-500 dark:text-gray-300">22/10/2025</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300">Marketing • Emma Wilson — <span class="font-semibold">submitted</span></p>
            </div>

            <!-- Activity Item 3 -->
            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-semibold">Employee Onboarding</span>
                    <span class="text-sm text-gray-500 dark:text-gray-300">22/10/2025</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300">Human Resources • Emma Wilson</p>
            </div>
        </div>
    </div>

</div>


<script>
    feather.replace();

    // User dropdown toggle
    document.getElementById('userMenuButton').addEventListener('click', function () {
        document.getElementById('userDropdown').classList.toggle('hidden');
    });
</script>
@endsection
