@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Main Content Container -->
<div class="container mx-auto py-6">

    <!-- Page Header with Back Button -->
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <!-- Back Button -->
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> Back
            </a>

            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-2 text-indigo-700 flex items-center">
                <i data-feather="file-text" class="w-6 h-6 mr-2"></i> Submitted ROPAs for Review
            </h2>
        </div>
    </div>

    
    <p class="text-gray-600 dark:text-gray-400 mb-4">Review and manage all submitted ROPA records.</p>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('admin.ropa.index') }}" class="mb-6 flex items-center space-x-2">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Search by Organisation, Department or Status..." 
            class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
        >
        <button type="submit" class="flex items-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            <i data-feather="search" class="w-4 h-4 mr-1"></i> Search
        </button>
    </form>

    <!-- ROPA Table -->
    @if($ropas->count() > 0)
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full border border-gray-200 text-sm text-left">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">Organisation</th>
                        <th class="py-3 px-4">Department</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date Submitted</th>
                        <th class="py-3 px-4">Processor</th>
                        <th class="py-3 px-4">Country</th>
                        <th class="py-3 px-4">Lawful Basis</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ropas as $index => $ropa)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $loop->iteration + ($ropas->currentPage() - 1) * $ropas->perPage() }}</td>
                        <td class="py-3 px-4 font-semibold text-gray-800">{{ $ropa->organisation_name }}</td>
                        <td class="py-3 px-4">{{ $ropa->department_name ?? $ropa->other_department }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $ropa->status == 'Approved' ? 'bg-green-100 text-green-700' :
                                   ($ropa->status == 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($ropa->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ $ropa->date_submitted?->format('d M Y') }}</td>
                        <td class="py-3 px-4">{{ $ropa->processor ?? '—' }}</td>
                        <td class="py-3 px-4">{{ $ropa->country ?? '—' }}</td>
                        <td class="py-3 px-4">{{ $ropa->lawful_basis ?? '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('admin.ropa.show', $ropa->id) }}"
                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-semibold">
                                <i data-feather="eye" class="w-4 h-4 mr-1"></i> Review
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $ropas->links() }}
        </div>
    @else
        <div class="text-center p-6 bg-gray-100 rounded-lg">
            <i data-feather="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3"></i>
            <p class="text-gray-600">No ROPA submissions found.</p>
        </div>
    @endif
</div>

<script>
    feather.replace();
</script>
@endsection
