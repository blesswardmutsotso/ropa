@extends('layouts.admin')

@section('title', ' Admin Review View')

@section('content')

<div class="container mx-auto p-4 sm:p-6">

<!-- Page Header -->
<div class="flex justify-between items-center mb-6">

<a href="{{ route('admin.reviews.index') }}"
   class="bg-green-500 px-4 py-2 rounded-lg text-white hover:bg-green-600 flex items-center">
    <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> Back
</a>

    <h2 class="text-2xl font-bold text-orange-500 flex items-center">
        <i data-feather="file-text" class="w-6 h-6 mr-2"></i> Review Details
    </h2>
</div>

<!-- Success / Error Messages -->
@if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm flex items-center gap-2">
        <i data-feather="check-circle" class="w-4 h-4"></i>
        {{ session('success') }}
    </div>
@endif

@php
    $ropa = $review->ropa;
    $sections = $ropa::sections();
    $maxScore = 10;
    $totalScore = $review->total_score;
    $averageScore = $review->average_score;

    function renderValue($value) {
        if (is_array($value)) {
            return implode(', ', array_map(fn($v) => renderValue($v), $value));
        } elseif (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        } elseif (!$value) {
            return 'N/A';
        } else {
            return $value;
        }
    }

    $icons = [
        'organisation_name' => 'briefcase',
        'department' => 'layers',
        'processes' => 'cpu',
        'data_sources' => 'database',
        'data_formats' => 'file-text',
        'information_nature' => 'info',
        'personal_data_categories' => 'user',
        'records_count' => 'list',
        'data_volume' => 'bar-chart-2',
        'retention_period_years' => 'clock',
        'access_estimate' => 'eye',
        'retention_rationale' => 'book-open',
        'information_shared' => 'share-2',
        'local_organizations' => 'home',
        'transborder_countries' => 'globe',
        'access_control' => 'lock',
        'access_measures' => 'shield',
        'technical_measures' => 'tool',
        'organisational_measures' => 'users',
        'lawful_basis' => 'file-check',
        'risk_report' => 'alert-circle',
    ];
@endphp

<!-- TOTAL SCORE -->
<div class="bg-white shadow-md rounded-lg p-5 mb-6 border-l-4 border-orange-500 flex justify-between items-center">
    <div class="text-lg font-semibold text-gray-700 flex items-center gap-2">
        <i data-feather="bar-chart-2" class="w-5 h-5 text-orange-500"></i>
        Total Score: {{ $totalScore }} / {{ count($sections)*$maxScore }}
    </div>
    <div class="text-lg font-semibold text-gray-700 flex items-center gap-2">
        <i data-feather="star" class="w-5 h-5 text-yellow-500"></i>
        Average Score: {{ number_format($averageScore ?? 0, 1) }}%
    </div>
</div>

<!-- SECTION SCORES -->
<form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" class="mb-6">
    @csrf
    @method('PUT')

    <div class="bg-white shadow-md rounded-lg p-5 mb-6">
        <h3 class="text-lg font-bold mb-4 flex items-center text-orange-600">
            <i data-feather="sliders" class="w-5 h-5 mr-2"></i> Sections & Scores
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
            @foreach ($sections as $section)
                <div class="p-3 bg-gray-100 rounded-lg flex flex-col gap-2">
                    <p class="font-semibold text-gray-700 flex items-center gap-1">
                        <i data-feather="{{ $icons[$section] ?? 'circle' }}" class="w-4 h-4 text-orange-500"></i>
                        {{ ucwords(str_replace('_', ' ', $section)) }}
                    </p>
                    <p class="text-gray-600 text-sm">{{ renderValue($ropa->{$section}) }}</p>

                    <input type="number" 
                           name="section_scores[{{ $section }}]" 
                           value="{{ $review->section_scores[$section] ?? 0 }}" 
                           min="0" max="{{ $maxScore }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                           placeholder="Score (0-{{ $maxScore }})">

                    <p class="text-sm text-gray-500 mt-1">Max Score: {{ $maxScore }}</p>
                </div>
            @endforeach
        </div>

        <button type="submit" 
                class="mt-4 bg-orange-500 text-white px-5 py-2 rounded-lg hover:bg-orange-600 transition flex items-center gap-2">
            <i data-feather="save" class="w-4 h-4"></i> Save Scores
        </button>
    </div>
</form>

<!-- COMPLIANCE — UPDATED FOR FILE UPLOAD -->
<div class="bg-white shadow-md rounded-lg p-5">
    <h3 class="text-lg font-bold mb-4 flex items-center text-orange-600">
        <i data-feather="shield" class="w-5 h-5 mr-2"></i> Compliance Documents
    </h3>

    <form action="{{ route('admin.reviews.update.compliance', $review->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-5">

            <!-- DPA -->
            <div>
                <label class="font-medium">Data Processing Agreement (DPA)</label>
                <input type="file" name="data_processing_agreement"
                       class="mt-1 block w-full border rounded p-2">

                @if ($review->data_processing_agreement)
                    <a href="{{ asset('storage/'.$review->data_processing_agreement) }}"
                       target="_blank"
                       class="text-blue-600 underline text-sm mt-1 block">
                        View Uploaded DPA
                    </a>
                @endif
            </div>

            <!-- DPIA -->
            <div>
                <label class="font-medium">Data Protection Impact Assessment (DPIA)</label>
                <input type="file" name="data_protection_impact_assessment"
                       class="mt-1 block w-full border rounded p-2">

                @if ($review->data_protection_impact_assessment)
                    <a href="{{ asset('storage/'.$review->data_protection_impact_assessment) }}"
                       target="_blank"
                       class="text-blue-600 underline text-sm mt-1 block">
                        View Uploaded DPIA
                    </a>
                @endif
            </div>

        </div>

        <button type="submit" 
                class="mt-4 bg-orange-500 text-white px-5 py-2 rounded-lg hover:bg-orange-600 transition flex items-center gap-2">
            <i data-feather="save" class="w-4 h-4"></i> Save Compliance
        </button>
    </form>
</div>

</div>

<script>
    feather.replace();
</script>

@endsection
