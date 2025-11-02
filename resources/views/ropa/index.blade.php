@extends('layouts.app')

@section('title', 'ROPA Records')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6 text-indigo-700 flex items-center">
        <i data-feather="file-text" class="w-6 h-6 mr-2"></i> ROPA Records
    </h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 flex items-center">
            <i data-feather="check-circle" class="w-5 h-5 mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Add New ROPA Button -->
    <div class="flex items-center mb-4 space-x-2">
        <a href="{{ route('ropa.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center">
            <i data-feather="plus-circle" class="w-5 h-5 mr-2"></i> Add New ROPA
        </a>
    </div>

    <!-- ROPA Table -->
    <div class="overflow-x-auto">
        <table class="w-full border mt-4 text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Organisation</th>
                    <th class="border p-2">Department</th>
                    <th class="border p-2">Other Dept</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Date Submitted</th>
                    <th class="border p-2">Information Shared</th>
                    <th class="border p-2">Information Nature</th>
                    <th class="border p-2">Outsourced Processing</th>
                    <th class="border p-2">Processor</th>
                    <th class="border p-2">Transborder Processing</th>
                    <th class="border p-2">Country</th>
                    <th class="border p-2">Lawful Basis</th>
                    <th class="border p-2">Retention Period</th>
                    <th class="border p-2">Retention Rationale</th>
                    <th class="border p-2">Users Count</th>
                    <th class="border p-2">Access Control</th>
                    <th class="border p-2">Personal Data Category</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ropas as $ropa)
                    <tr>
                        <td class="border p-2">{{ $ropa->id }}</td>
                        <td class="border p-2">{{ $ropa->organisation_name ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->department_name ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->other_department ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->status ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->date_submitted ? \Carbon\Carbon::parse($ropa->date_submitted)->format('d M Y') : 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->information_shared ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->information_nature ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->outsourced_processing ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->processor ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->transborder_processing ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->country ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->lawful_basis ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->retention_period_years ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->retention_rationale ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->users_count ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->access_control ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $ropa->personal_data_category ?? 'N/A' }}</td>
                        <td class="border p-2 flex items-center space-x-2">
                            <a href="{{ route('ropa.edit', $ropa->id) }}" class="text-blue-600 flex items-center hover:text-blue-800">
                                <i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit
                            </a>
                            <form action="{{ route('ropa.destroy', $ropa->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 flex items-center hover:text-red-800"
                                        onclick="return confirm('Are you sure you want to delete this record?')">
                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="19" class="text-center text-gray-500 p-4">No ROPA records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $ropas->links() }}
    </div>
</div>

<script>
    feather.replace();
</script>
@endsection
