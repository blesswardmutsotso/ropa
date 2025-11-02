@extends('layouts.admin')

@section('title', 'Review Management')

@section('content')
<div class="container mx-auto p-4 sm:p-6">
    <!-- Page Header -->
    <h2 class="text-2xl font-bold mb-6 text-indigo-700 flex items-center">
        <i data-feather="message-square" class="w-6 h-6 mr-2"></i> Processing Activities Review Management
    </h2>

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm sm:text-base">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm sm:text-base">
            {{ session('error') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <!-- Total Reviews -->
        <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 border-l-4 border-indigo-600">
            <div class="p-2 sm:p-3 bg-indigo-100 rounded-full">
                <i data-feather="file-text" class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600"></i>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-semibold text-gray-500 uppercase">Total Reviews</h3>
                <p class="text-lg sm:text-xl font-bold text-gray-800">{{ \App\Models\Review::count() }}</p>
            </div>
        </div>

        <!-- Pending Reviews -->
        <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 border-l-4 border-yellow-500">
            <div class="p-2 sm:p-3 bg-yellow-100 rounded-full">
                <i data-feather="clock" class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500"></i>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-semibold text-gray-500 uppercase">Pending Reviews</h3>
                <p class="text-lg sm:text-xl font-bold text-gray-800">{{ \App\Models\Review::where('review_status','Pending')->count() }}</p>
            </div>
        </div>

        <!-- Approved Reviews -->
        <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 border-l-4 border-green-600">
            <div class="p-2 sm:p-3 bg-green-100 rounded-full">
                <i data-feather="check-circle" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600"></i>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-semibold text-gray-500 uppercase">Approved Reviews</h3>
                <p class="text-lg sm:text-xl font-bold text-gray-800">{{ \App\Models\Review::where('review_status','Approved')->count() }}</p>
            </div>
        </div>

        <!-- High Risk Reviews -->
        <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 border-l-4 border-red-500">
            <div class="p-2 sm:p-3 bg-red-100 rounded-full">
                <i data-feather="alert-triangle" class="w-5 h-5 sm:w-6 sm:h-6 text-red-500"></i>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-semibold text-gray-500 uppercase">High Risk Reviews</h3>
                <p class="text-lg sm:text-xl font-bold text-gray-800">{{ \App\Models\Review::where('review_status','High Risk')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('reviews.index') }}" class="mb-6 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Search by ROPA, Reviewer, or Status..." 
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm sm:text-base"
        >
        <button 
            type="submit" 
            class="flex items-center justify-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm sm:text-base"
        >
            <i data-feather="search" class="w-4 h-4 mr-1"></i> Search
        </button>
    </form>

    <!-- Reviews Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full table-auto border-collapse text-sm sm:text-base">
            <thead class="bg-indigo-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">ROPA</th>
                    <th class="py-3 px-4 text-left">Reviewer</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Risk Score</th>
                    <th class="py-3 px-4 text-left">Remarks</th>
                    <th class="py-3 px-4 text-left">Reviewed At</th>
                    <th class="py-3 px-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 font-semibold">{{ $review->ropa->organisation_name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $review->reviewed_by ?? '—' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ 
                                $review->review_status == 'Approved' ? 'bg-green-100 text-green-800' :
                                ($review->review_status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $review->review_status ?? 'Pending' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">{{ $review->risk_score ?? '—' }}</td>
                        <td class="py-3 px-4">{{ Str::limit($review->remarks, 50) }}</td>
                        <td class="py-3 px-4 whitespace-nowrap text-gray-600">{{ $review->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-center flex justify-center space-x-2">
                            <a href="{{ route('reviews.show', $review->id) }}" class="text-blue-600 hover:text-blue-800">
                                <i data-feather="eye"></i>
                            </a>
                            <a href="{{ route('reviews.edit', $review->id) }}" class="text-yellow-600 hover:text-yellow-800">
                                <i data-feather="edit"></i>
                            </a>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" 
                                  onsubmit="return confirm('Delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-500">No reviews found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $reviews->links() }}
    </div>
</div>

<script>
    feather.replace();
</script>
@endsection
