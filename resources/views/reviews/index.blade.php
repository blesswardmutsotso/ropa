@extends('layouts.app')

@section('content')
<div class="py-8 px-6">

    <!-- Page Title -->
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">
        Record Of Processing Activity Reviews
    </h1>

    <!-- Search and Filter -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
        <form method="GET" action="{{ route('reviews.index') }}" class="flex flex-1 gap-2">
            <input type="text" name="search" placeholder="Search by ROPA ID or Comment"
                   value="{{ request('search') }}"
                   class="w-full sm:w-64 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 dark:bg-gray-700 dark:text-gray-200"
            >
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition flex items-center gap-1">
                <i data-feather="search" class="w-4 h-4"></i>
                Search
            </button>
        </form>

        <div class="flex gap-2">
            <a href="{{ route('reviews.index', ['filter' => 'pending']) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition flex items-center gap-1">
                <i data-feather="clock" class="w-4 h-4"></i>
                Pending
            </a>

            <a href="{{ route('reviews.index', ['filter' => 'reviewed']) }}"
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center gap-1">
                <i data-feather="check-circle" class="w-4 h-4"></i>
                Reviewed
            </a>

            <a href="{{ route('reviews.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center gap-1">
                <i data-feather="refresh-cw" class="w-4 h-4"></i>
                Reset
            </a>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6">
        @if($ropas->count() > 0)
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Processing Activity
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Reviews
                        </th>

                        <!-- NEW SCORE COLUMN -->
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Score
                        </th>

                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($ropas as $ropa)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                            <!-- ROPA Info -->
                            <td class="px-4 py-4 text-gray-700 dark:text-gray-300">
                                <div class="font-semibold text-orange-600 flex items-center gap-2">
                                    <i data-feather="briefcase" class="w-4 h-4 text-orange-500"></i>
                                    {{ $ropa->ropa_create['organisation_name'] ?? 'No Organization' }}
                                </div>
                                
                                
<div class="text-xs text-sky-500 flex items-center gap-1 mt-1">
    <i data-feather="calendar" class="w-3 h-3 text-sky-500"></i>
    Submitted: {{ $ropa->created_at->format('d M Y') }}
</div>

                                <div class="text-xs text-black-600 flex items-center gap-1 mt-1">
                                    <i data-feather="info" class="w-3 h-3 text-black-500"></i>
                                    Status: {{ $ropa->status }}
                                </div>
                            </td>

                            <!-- Reviews -->
                            <td class="px-4 py-4 text-gray-700 dark:text-gray-300 max-w-md">
                                @if($ropa->reviews->count())
                                    @foreach($ropa->reviews as $review)
                                        <div class="mb-2 p-2 bg-gray-100 dark:bg-gray-700 rounded-lg flex flex-col gap-1">
                                            <div class="font-semibold text-orange-600 flex items-center gap-2">
                                                <i data-feather="user" class="w-4 h-4 text-orange-500"></i>
                                                {{ $review->user->name ?? 'Admin' }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300 flex items-start gap-2">
                                                <i data-feather="message-circle" class="w-3 h-3 mt-0.5 text-gray-500"></i>
                                                <span>{{ $review->comment }}</span>
                                            </div>
                                            <div class="text-sm font-bold flex items-center gap-2 mt-1">
                                                <i data-feather="bar-chart-2" class="w-3 h-3 text-orange-500"></i>
                                                Score: {{ $review->score }}%
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-red-500 dark:text-red-400 flex items-center gap-2 mt-1">
                                        <i data-feather="info" class="w-3 h-3 text-red-500 dark:text-red-400"></i>
                                        No reviews yet
                                    </p>
                                @endif
                            </td>

                            <!-- SCORE COLUMN -->
                            <td class="px-4 py-4 text-gray-700 dark:text-gray-300 text-center font-bold">
                                @if($ropa->reviews->count())
                                    {{ number_format($ropa->reviews->avg('score'), 1) }}%
                                @else
                                    <span class="text-yellow-600">Pending</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-4 text-center align-middle flex justify-center gap-2">

<!-- View Button -->
<a href="{{ route('reviews.show', $ropa->id) }}"
   class="bg-orange-500 text-white font-semibold px-3 py-1 rounded flex items-center gap-1 hover:bg-orange-600 transition">
    <i data-feather="eye" class="w-4 h-4"></i>
    View
</a>

                                <!-- Print Button -->
                                <a href="" target="_blank"
                                   class="bg-green-500 text-white font-semibold px-3 py-1 rounded flex items-center gap-1 hover:bg-green-600 transition">
                                    <i data-feather="printer" class="w-4 h-4"></i>
                                    Print
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $ropas->links('pagination::tailwind') }}
            </div>

        @else
            <p class="text-center text-gray-600 dark:text-gray-400 py-6 flex items-center justify-center gap-2">
                <i data-feather="info" class="w-4 h-4"></i>
                You have not submitted any ROPAs yet.
            </p>
        @endif
    </div>
</div>

<!-- Feather Icons -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
    });
</script>
@endsection
