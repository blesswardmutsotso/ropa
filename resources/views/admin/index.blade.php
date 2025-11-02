@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<div class="container mx-auto p-4">

    <h2 class="text-2xl font-bold mb-4 flex items-center text-indigo-700">
        <i data-feather="user" class="w-6 h-6 mr-2"></i> My Account
    </h2>

    <!-- User Info Card -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <div class="flex items-center space-x-6">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" 
                 alt="User Avatar" class="w-20 h-20 rounded-full shadow">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $user->email }}</p>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Role: {{ $user->job_title ?? 'User' }}</p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex space-x-2">
        <a href="{{ route('account.edit') }}" 
   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center">
    <i data-feather="edit" class="w-5 h-5 mr-2"></i> Edit Profile Details
</a>


        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center">
                <i data-feather="log-out" class="w-5 h-5 mr-2"></i> Logout
            </button>
        </form>


<a href="{{ route('dashboard') }}" 
   class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded flex items-center shadow">
    <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Back To Dashboard
</a>



    </div>

</div>

<script>
    feather.replace();
</script>
@endsection
