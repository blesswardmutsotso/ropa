@extends('layouts.app')

@section('title', 'View Record of Processing Activities')

@section('content')
<div class="mb-4">
    <a href="{{ route('reviews.index') }}" 
       class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow">
       <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Back
    </a>
</div>

<div class="container mx-auto p-4 sm:p-6">

    {{-- Organisation Details --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-orange-500 mb-4 flex items-center">
            <i data-feather="briefcase" class="w-5 h-5 mr-2"></i> Organisation Details
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <strong>Organisation Name:</strong> 
                {{ $ropa->ropa_create['organisation_name'] ?? '-' }}
            </div>
            <div>
                <strong>Department:</strong> 
                {{ $ropa->ropa_create['department'] ?? '-' }}
            </div>
        </div>
    </div>

    {{-- Processing Activity --}}
    @if(count($ropa->processes))
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-orange-500 mb-4 flex items-center">
            <i data-feather="cpu" class="w-5 h-5 mr-2"></i> Processing Activity
        </h2>

        @foreach($ropa->processes as $process)
        <div class="mb-4 p-4 border rounded-lg">
            <strong>Process Name:</strong> {{ $process['name'] ?? '-' }}<br>
            <strong>Nature of Information:</strong> {{ $process['information_nature'] ?? '-' }}<br>
            <strong>Approx. Records:</strong> {{ $process['records_count'] ?? '-' }}<br>
            <strong>Data Volume:</strong> {{ $process['data_volume'] ?? '-' }}<br>

            <strong>Data Sources:</strong>
            @if(!empty($process['data_sources']))
                <ul class="list-disc ml-5">
                    @foreach($process['data_sources'] as $source)
                        <li>{{ $source }}</li>
                    @endforeach
                </ul>
            @else
                <span>-</span>
            @endif

            <strong>Data Formats:</strong>
            @if(!empty($process['data_formats']))
                <ul class="list-disc ml-5">
                    @foreach($process['data_formats'] as $format)
                        <li>{{ $format }}</li>
                    @endforeach
                </ul>
            @else
                <span>-</span>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Data Sharing & Outsourcing --}}
    @if($ropa->information_shared)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-orange-500 mb-4 flex items-center">
            <i data-feather="share-2" class="w-5 h-5 mr-2"></i> Data Sharing & Outsourcing
        </h2>

        <div><strong>Information Shared:</strong> {{ $ropa->information_shared ? 'Yes' : 'No' }}</div>

        @if($ropa->sharing_local && count($ropa->localOrganizations))
        <div class="mt-2">
            <strong>Local Organizations:</strong>
            <ul class="list-disc ml-5">
                @foreach($ropa->localOrganizations as $org)
                    <li>{{ $org }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if($ropa->sharing_transborder && count($ropa->transborderCountries))
        <div class="mt-2">
            <strong>Transborder Countries:</strong>
            <ul class="list-disc ml-5">
                @foreach($ropa->transborderCountries as $country)
                    <li>{{ $country }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mt-2"><strong>Description:</strong> {{ $ropa->sharingDescription ?? '-' }}</div>
        <div class="mt-2"><strong>Estimated Days:</strong> {{ $ropa->sharingDays ?? '-' }}</div>
        <div class="mt-2"><strong>Comments:</strong> {{ $ropa->sharingComment ?? '-' }}</div>
    </div>
    @endif

    {{-- SOPs --}}
    @if(count($ropa->sops))
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-orange-500 mb-4 flex items-center">
            <i data-feather="upload" class="w-5 h-5 mr-2"></i> SOPs & Supporting Documents
        </h2>

        @foreach($ropa->sops as $sop)
        <div class="mb-4 p-4 border rounded-lg">
            <div><strong>Name:</strong> {{ $sop['name'] ?? '-' }}</div>
            <div><strong>Version:</strong> {{ $sop['version'] ?? '-' }}</div>
            <div><strong>Owner:</strong> {{ $sop['owner'] ?? '-' }}</div>
            <div><strong>Date of Issue:</strong> {{ $sop['date'] ?? '-' }}</div>
            @if(!empty($sop['sop_file']))
                <div><strong>SOP File:</strong> <a href="{{ asset('storage/'.$sop['sop_file']) }}" target="_blank" class="text-blue-500 underline">View File</a></div>
            @endif
            @if(!empty($sop['supporting_documents']))
                <div><strong>Supporting Documents:</strong> <a href="{{ asset('storage/'.$sop['supporting_documents']) }}" target="_blank" class="text-blue-500 underline">View File</a></div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Risks --}}
    @if(count($ropa->risks))
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-orange-500 mb-4 flex items-center">
            <i data-feather="alert-triangle" class="w-5 h-5 mr-2"></i> Risk Reporting & Mitigation
        </h2>

        @foreach($ropa->risks as $risk)
        <div class="mb-4 p-4 border rounded-lg">
            <div><strong>Risk Report:</strong> {{ $risk['report'] ?? '-' }}</div>
            <div><strong>Mitigation Strategy:</strong> {{ $risk['mitigation'] ?? '-' }}</div>
        </div>
        @endforeach
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        feather.replace({ 'aria-hidden': 'true' });
    });
</script>
@endsection
