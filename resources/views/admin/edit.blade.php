@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6 text-indigo-700">Edit Profile</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 flex items-center">
            <i data-feather="check-circle" class="w-5 h-5 mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li class="flex items-center"><i data-feather="alert-circle" class="w-4 h-4 mr-1"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <form method="POST" action="{{ route('account.update') }}">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <!-- Current Password -->
            <div class="mb-4">
                <label for="current_password" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Current Password</label>
                <input type="password" name="current_password" id="current_password" placeholder="Enter current password" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200" required>
            </div>

            <!-- New Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">New Password</label>
                <input type="password" name="password" id="password" placeholder="Leave blank to keep current password" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <div class="flex justify-end space-x-2">

               <a href="{{ route('admin') }}" 
                  class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 flex items-center">
                  <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> Cancel
               </a>

                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 flex items-center">
                    <i data-feather="save" class="w-4 h-4 mr-1"></i> Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    feather.replace();
</script>
@endsection
