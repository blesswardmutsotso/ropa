@extends('layouts.admin')

@section('title', 'ROPA Assessment')

@section('content')
<div class="container mx-auto p-4 sm:p-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-bold text-orange-500 flex items-center">
            <i data-feather="file-text" class="w-6 h-6 mr-2"></i> ROPA Assessments
        </h2>

        <!-- EXPORT BUTTON -->
        <a href="{{ route('admin.reviews.export.excel') }}"
           class="mt-3 sm:mt-0 bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 flex items-center gap-2">
            <i data-feather="download" class="w-4 h-4"></i>
            Export to Excel
        </a>
    </div>

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

        <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 border-l-4 border-orange-500">
            <div class="p-2 bg-orange-100 rounded-full">
                <i data-feather="file-text" class="w-6 h-6 text-orange-500"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Reviews</h3>
                <p class="text-xl font-bold text-gray-800">{{ \App\Models\Review::count() }}</p>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 border-l-4 border-blue-500">
            <div class="p-2 bg-blue-100 rounded-full">
                <i data-feather="star" class="w-6 h-6 text-blue-500"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Avg. Score</h3>
                <p class="text-xl font-bold text-gray-800">
                    {{ number_format(\App\Models\Review::avg('score') ?? 0, 1) }}
                </p>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 border-l-4 border-green-500">
            <div class="p-2 bg-green-100 rounded-full">
                <i data-feather="check-circle" class="w-6 h-6 text-green-500"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">DPA Completed</h3>
                <p class="text-xl font-bold text-gray-800">
                    {{ \App\Models\Review::where('data_processing_agreement', 1)->count() }}
                </p>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 border-l-4 border-purple-500">
            <div class="p-2 bg-purple-100 rounded-full">
                <i data-feather="shield" class="w-6 h-6 text-purple-500"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">DPIA Conducted</h3>
                <p class="text-xl font-bold text-gray-800">
                    {{ \App\Models\Review::where('data_protection_impact_assessment', 1)->count() }}
                </p>
            </div>
        </div>

    </div>

    <!-- Reviews Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full table-auto border-collapse text-sm sm:text-base">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Reviewer</th>
                    <th class="py-3 px-4 text-left">ROPA ID</th>
                    <th class="py-3 px-4 text-left">Average Score</th>
                    <th class="py-3 px-4 text-left">DPA</th>
                    <th class="py-3 px-4 text-left">DPIA</th>
                    <th class="py-3 px-4 text-left">Created</th>
                    <th class="py-3 px-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($reviews as $review)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="py-3 px-4">
                            {{ $review->user->name ?? 'Admin' }}
                        </td>

                        <td class="py-3 px-4">
                            ROPA #{{ $review->ropa->id }}
                        </td>

                        <td class="py-3 px-4 font-semibold text-blue-600">
                            {{ $review->average_score ?? '—' }}
                        </td>

                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $review->data_processing_agreement ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $review->data_processing_agreement ? 'Yes' : 'No' }}
                            </span>
                        </td>

                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $review->data_protection_impact_assessment ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $review->data_protection_impact_assessment ? 'Yes' : 'No' }}
                            </span>
                        </td>

                        <td class="py-3 px-4 text-gray-600">
                            {{ $review->created_at->format('d M Y') }}
                        </td>

                        <td class="py-3 px-4">
                            <div class="flex justify-center space-x-3">

                                <a href="{{ route('admin.reviews.show', $review->id) }}"
                                   class="text-orange-500 hover:text-orange-600 flex items-center gap-1">
                                    <i data-feather="eye" class="w-4 h-4"></i>
                                </a>

    @if($review->ropa)
    <a href="{{ route('admin.ropa.export', $review->ropa->id) }}" class="text-green-600 ...">
        <i data-feather="download" class="w-4 h-4"></i>
    </a>
@endif


                                <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}"
                                      onsubmit="return confirm('Delete this review?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600 hover:text-red-800 flex items-center">
                                        <i data-feather="trash" class="w-4 h-4"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-500">
                            No reviews found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $reviews->links() }}
    </div>

</div>

<script>
    feather.replace();
</script>

@endsection
