@extends('layouts.app')

@section('title', 'Edit ROPA Record')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6 text-indigo-700 flex items-center">
        <i data-feather="edit" class="w-6 h-6 mr-2"></i> Edit Record of Processing Activity
    </h2>

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
                    <li class="flex items-center">
                        <i data-feather="alert-circle" class="w-4 h-4 mr-1"></i> {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <form method="POST" action="{{ route('ropas.update', $ropa->id) }}">
            @csrf
            @method('PATCH')

            <!-- Controller / Department -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Controller / Department</label>
                <input type="text" name="controller_department" value="{{ old('controller_department', $ropa->controller_department) }}" class="form-input w-full" />
            </div>

            <!-- Processing Activity Name -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Processing Activity Name</label>
                <input type="text" name="processing_activity_name" value="{{ old('processing_activity_name', $ropa->processing_activity_name) }}" class="form-input w-full" />
            </div>

            <!-- Purpose of Processing -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Purpose of Processing</label>
                <textarea name="purpose_of_processing" rows="3" class="form-textarea w-full">{{ old('purpose_of_processing', $ropa->purpose_of_processing) }}</textarea>
            </div>

            <!-- Categories of Data Subjects -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Categories of Data Subjects</label>
                <textarea name="categories_of_data_subjects" rows="3" class="form-textarea w-full">{{ old('categories_of_data_subjects', $ropa->categories_of_data_subjects) }}</textarea>
            </div>

            <!-- Categories of Personal Data -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Categories of Personal Data</label>
                <textarea name="categories_of_personal_data" rows="3" class="form-textarea w-full">{{ old('categories_of_personal_data', $ropa->categories_of_personal_data) }}</textarea>
            </div>

            <!-- Recipients of Data -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Recipients of Data</label>
                <textarea name="recipients_of_data" rows="3" class="form-textarea w-full">{{ old('recipients_of_data', $ropa->recipients_of_data) }}</textarea>
            </div>

            <!-- Transfer to Third Countries -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Transfer to Third Countries</label>
                <input type="text" name="transfer_to_third_countries" value="{{ old('transfer_to_third_countries', $ropa->transfer_to_third_countries) }}" class="form-input w-full" />
            </div>

            <!-- Retention Period -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Retention Period</label>
                <input type="text" name="retention_period" value="{{ old('retention_period', $ropa->retention_period) }}" class="form-input w-full" />
            </div>

            <!-- Security Measures -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Security Measures</label>
                <textarea name="security_measures" rows="3" class="form-textarea w-full">{{ old('security_measures', $ropa->security_measures) }}</textarea>
            </div>

            <!-- Data Protection Officer -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Data Protection Officer</label>
                <input type="text" name="data_protection_officer" value="{{ old('data_protection_officer', $ropa->data_protection_officer) }}" class="form-input w-full" />
            </div>

            <!-- Date of Entry -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Date of Entry</label>
                <input type="date" name="date_of_entry" value="{{ old('date_of_entry', $ropa->date_of_entry ? $ropa->date_of_entry->format('Y-m-d') : '') }}" class="form-input w-full" />
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-2">
                <a href="{{ route('ropas.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 flex items-center">
                    <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> Cancel
                </a>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 flex items-center">
                    <i data-feather="save" class="w-4 h-4 mr-1"></i> Update Record
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    feather.replace();
</script>
@endsection
