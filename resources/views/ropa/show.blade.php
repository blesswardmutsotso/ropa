@extends('layouts.app')

@section('title', 'View ROPA Record')

@section('content')
<div class="container mx-auto p-6">



    <!-- ================================ -->
    <!-- ROPA TABS (Top Navigation)       -->
    <!-- ================================ -->
    <div class="flex flex-wrap gap-4 mb-8 border-b pb-2">
        @php
            $tabs = [
                'Details' => route('ropa.show', $ropa->id),
                'Review' => route('ropa.review', $ropa->id),
            ];
        @endphp
        @foreach($tabs as $label => $link)
            <a href="{{ $link }}"
               class="px-4 py-2 font-semibold rounded-lg transition-colors
               {{ request()->url() === $link ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-indigo-100 hover:text-indigo-800' }}">
               {{ $label }}
            </a>
        @endforeach
    </div>

    <h1 class="text-3xl font-bold mb-6 text-orange-600">ROPA Record Details</h1>

    @php
        // Safe array/string display
        function showValue($value) {
            if (is_array($value)) {
                $flat = [];
                array_walk_recursive($value, function($v) use (&$flat) {
                    $flat[] = $v;
                });
                return $flat ? implode(', ', $flat) : '—';
            }
            return $value ?? '—';
        }

        function yesNo($value) {
            return $value ? 'Yes' : 'No';
        }

        function riskBadge($level) {
            return match($level) {
                'Critical' => 'bg-red-600 text-white',
                'High' => 'bg-orange-500 text-white',
                'Medium' => 'bg-yellow-400 text-black',
                'Low' => 'bg-green-500 text-white',
                default => 'bg-gray-300 text-black'
            };
        }
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Organisation Info -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold text-lg text-gray-800 mb-3">Organisation Information</h2>
            <p><span class="font-medium">Organisation Name:</span> {{ showValue($ropa->organisation_name) }}</p>
            <p><span class="font-medium">Other Organisation:</span> {{ showValue($ropa->other_organisation_name) }}</p>
            <p><span class="font-medium">Department:</span> {{ showValue($ropa->department) }}</p>
            <p><span class="font-medium">Other Department:</span> {{ showValue($ropa->other_department) }}</p>
        </div>

        <!-- Processing Details -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold text-lg text-gray-800 mb-3">Processing Details</h2>
            <p><span class="font-medium">Processes:</span> {{ showValue($ropa->processes) }}</p>
            <p><span class="font-medium">Data Sources:</span> {{ showValue($ropa->data_sources) }}</p>
            <p><span class="font-medium">Other Data Sources:</span> {{ showValue($ropa->data_sources_other) }}</p>
            <p><span class="font-medium">Data Formats:</span> {{ showValue($ropa->data_formats) }}</p>
            <p><span class="font-medium">Other Data Formats:</span> {{ showValue($ropa->data_formats_other) }}</p>
            <p><span class="font-medium">Nature of Information:</span> {{ showValue($ropa->information_nature) }}</p>
            <p><span class="font-medium">Personal Data Categories:</span> {{ showValue($ropa->personal_data_categories) }}</p>
            <p><span class="font-medium">Other Personal Data Categories:</span> {{ showValue($ropa->personal_data_categories_other) }}</p>
        </div>

        <!-- Data & Retention -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold text-lg text-gray-800 mb-3">Data & Retention</h2>
            <p><span class="font-medium">Estimated Records:</span> {{ showValue($ropa->records_count) }}</p>
            <p><span class="font-medium">Data Volume:</span> {{ showValue($ropa->data_volume) }}</p>
            <p><span class="font-medium">Retention (Years):</span> {{ showValue($ropa->retention_period_years) }}</p>
            <p><span class="font-medium">Retention Rationale:</span> {{ showValue($ropa->retention_rationale) }}</p>
        </div>

        <!-- Information Sharing -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold text-lg text-gray-800 mb-3">Information Sharing</h2>
            <p><span class="font-medium">Information Shared:</span> {{ yesNo($ropa->information_shared) }}</p>
            <p><span class="font-medium">Local Sharing:</span> {{ yesNo($ropa->sharing_local) }}</p>
            <p><span class="font-medium">Transborder Sharing:</span> {{ yesNo($ropa->sharing_transborder) }}</p>
            <p><span class="font-medium">Local Organizations:</span> {{ showValue($ropa->local_organizations) }}</p>
            <p><span class="font-medium">Transborder Countries:</span> {{ showValue($ropa->transborder_countries) }}</p>
            <p><span class="font-medium">Sharing Comment:</span> {{ showValue($ropa->sharing_comment) }}</p>
        </div>

        <!-- Security Measures -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold text-lg text-gray-800 mb-3">Security Measures</h2>
            <p><span class="font-medium">Access Control:</span> {{ yesNo($ropa->access_control) }}</p>
            <p><span class="font-medium">Access Measures:</span> {{ showValue($ropa->access_measures) }}</p>
            <p><span class="font-medium">Technical Measures:</span> {{ showValue($ropa->technical_measures) }}</p>
            <p><span class="font-medium">Organisational Measures:</span> {{ showValue($ropa->organisational_measures) }}</p>
        </div>

        <!-- Lawful Basis & Risk -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold text-lg text-gray-800 mb-3">Lawful Basis & Risk</h2>
            <p><span class="font-medium">Lawful Basis:</span> {{ showValue($ropa->lawful_basis) }}</p>
            <p><span class="font-medium">Risk Report:</span> {{ showValue($ropa->risk_report) }}</p>
            <p>
                <span class="font-medium">Risk Level:</span>
                <span class="px-2 py-1 rounded-full {{ riskBadge($ropa->risk_level) }}">
                    {{ $ropa->risk_level ?? '—' }}
                </span>
            </p>
        </div>

        <!-- Status & Timestamps -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold text-lg text-gray-800 mb-3">Status & Timestamps</h2>
            <p><span class="font-medium">Status:</span>
                <span class="px-2 py-1 rounded-full 
                    {{ $ropa->status === 'Reviewed' ? 'bg-green-500 text-white' : 'bg-yellow-400 text-black' }}">
                    {{ $ropa->status }}
                </span>
            </p>
            <p><span class="font-medium">Created At:</span> {{ $ropa->created_at->format('d M Y, H:i') }}</p>
            <p><span class="font-medium">Updated At:</span> {{ $ropa->updated_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    
</div>
@endsection
