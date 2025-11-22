@extends('layouts.app')

@section('title', 'Record of Processing Activities')

@section('content')
<div class="container mx-auto p-4 sm:p-6">


{{-- SAVE BUTTON ONLY --}}
<div class="sticky top-0 z-50 bg-white shadow-md p-4 mb-6 flex justify-end">
    <button type="submit" form="progressForm" 
            class="bg-orange-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-orange-600 flex items-center transition">
        <i data-feather="save" class="w-5 h-5 mr-2"></i> Save Progress
    </button>
</div>




@if(session('success'))
    <div id="alert-success" class="fixed top-5 right-5 bg-green-500 text-white px-6 py-4 rounded shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="alert-error" class="fixed top-5 right-5 bg-red-500 text-white px-6 py-4 rounded shadow-lg z-50">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div id="alert-validation" class="fixed top-5 right-5 bg-red-600 text-white px-6 py-4 rounded shadow-lg z-50">
        Please correct the errors in the form.
    </div>
@endif


<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const success = document.getElementById('alert-success');
            if (success) success.remove();

            const error = document.getElementById('alert-error');
            if (error) error.remove();
        }, 12000); // 5000ms = 5 seconds
    });
</script>




{{-- Main Form --}}
<form id="progressForm" action="{{ route('ropa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- SECTION 1: Organisation Details --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-orange-500 flex items-center">
            <i data-feather="briefcase" class="w-5 h-5 mr-2"></i> Organisation Details
        </h2>
     
    </div>

    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-4">
        <div class="bg-indigo-600 h-2 rounded-full" id="orgProgress" style="width: 0%"></div>
    </div>


<!-- SECTION 1: Organisation Details -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">

    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-4">
        <div class="bg-indigo-600 h-2 rounded-full" id="orgProgress" style="width: 0%"></div>
    </div>

    <!-- Form Fields -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <!-- Organisation Name Dropdown -->
        <div>
            <label for="organisation_name"
                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                Organisation Name
            </label>
            <select name="organisation_name" id="organisation_name"
                class="section-org p-2 border rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">Select Organisation</option>
                <option value="Mutala Trust">Mutala Trust</option>
                <option value="Charlse River Medical Group">Charlse River Medical Group</option>
                <option value="Infectious Diseases Research Lab">Infectious Diseases Research Lab</option>
                <option value="Clinresco">Clinresco</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <!-- Custom Organisation Name -->
        <div id="otherOrgContainer" class="hidden">
            <label for="other_organisation_name"
                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                Specify Organisation Name
            </label>
            <input type="text" name="other_organisation_name" id="other_organisation_name"
                placeholder="Enter organisation name"
                class="section-org p-2 border rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>

        <!-- Department Dropdown -->
        <div>
            <label for="department"
                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                Department
            </label>
            <select name="department" id="department"
                class="section-org p-2 border rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">Select Department</option>
                <option value="IT">IT</option>
                <option value="HR">HR</option>
                <option value="Community Engagement">Community Engagement</option>
                <option value="Data & Biostatistics">Data & Biostatistics</option>
                <option value="Laboratory">Laboratory</option>
                <option value="Pharmacy">Pharmacy</option>
                <option value="Finance & Administration">Finance & Administration</option>
                <option value="Clinical Operations (ClinOps)">Clinical Operations (ClinOps)</option>
                <option value="Project Management">Project Management</option>
                <option value="Legal & Compliance">Legal & Compliance</option>
                <option value="Data Protection">Data Protection</option>
                <option value="Other">Other</option>
            </select>
        </div>


        <!-- Custom Department Name -->
        <div id="otherDeptContainer" class="hidden">
            <label for="other_department"
                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                Specify Department Name
            </label>
            <input type="text" name="other_department" id="other_department"
                placeholder="Enter department name"
                class="section-org p-2 border rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>

    </div>
</div>

<!-- SCRIPT FOR DYNAMIC FIELDS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {

        // Organisation - Show custom input when 'Other' is selected
        const orgSelect = document.getElementById("organisation_name");
        const otherOrg = document.getElementById("otherOrgContainer");

        orgSelect.addEventListener("change", function () {
            otherOrg.classList.toggle("hidden", this.value !== "Other");
        });

        // Department - Show custom input when 'Other' is selected
        const deptSelect = document.getElementById("department");
        const otherDept = document.getElementById("otherDeptContainer");

        deptSelect.addEventListener("change", function () {
            otherDept.classList.toggle("hidden", this.value !== "Other");
        });

    });
</script>


{{-- SECTION 2: Processing Activity --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-orange-500 flex items-center">
            <i data-feather="cpu" class="w-5 h-5 mr-2"></i> Processing Activity Details 
        </h2>
       
    </div>

    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-4">
      
    </div>

    <div id="processContainer">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 process-row">
            <input type="text" name="processes[]" placeholder="Process Name" class="section-activity p-2 border rounded-lg w-full">

            <!-- Data Sources -->
            <div class="dynamic-field">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Data Sources</label>
                
                <div class="flex flex-wrap gap-4 mb-2">
                    <label class="flex items-center gap-1">
                        <input type="checkbox" name="data_sources_checkbox[0][]" value="Employees"> Employees
                    </label>
                    <label class="flex items-center gap-1">
                        <input type="checkbox" name="data_sources_checkbox[0][]" value="Participants"> Participants
                    </label>
                    <label class="flex items-center gap-1">
                        <input type="checkbox" class="other-source-checkbox"> Other
                    </label>
                </div>

                <div class="other-sources-container mt-1"></div>
                <button type="button" class="add-other-source bg-orange-500 text-white px-2 py-1 rounded-lg mt-1 hidden">+ Add Another Source</button>

                <div class="data-sources-wrapper mt-2">
                    <div class="flex gap-2 mb-2">
                        <input type="text" name="data_sources[0][]" placeholder="Additional Data Source" class="section-activity p-2 border rounded-lg w-full">
                        <button type="button" class="bg-red-600 text-white px-2 rounded-lg remove-source">Remove</button>
                    </div>
                </div>
                <button type="button" class="bg-orange-500 text-white px-2 py-1 rounded-lg mt-1 add-source">Add Data Source</button>
            </div>

            <!-- Data Formats -->
            <div class="dynamic-field">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Data Formats</label>
                <div class="data-formats-wrapper flex flex-wrap gap-4 mb-2">
                    <label class="flex items-center gap-1"><input type="checkbox" name="data_formats[0][]" value="CSV"> CSV</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="data_formats[0][]" value="JSON"> JSON</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="data_formats[0][]" value="XML"> XML</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="data_formats[0][]" value="PDF"> PDF</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="data_formats[0][]" value="DOCX"> DOCX</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="data_formats[0][]" value="Excel"> Excel</label>
                    <label class="flex items-center gap-1">
                        <input type="checkbox" class="other-format-checkbox"> Other
                    </label>
                </div>
                <div class="other-formats-container mt-1"></div>
                <button type="button" class="add-other-format bg-orange-500 text-white px-2 py-1 rounded-lg mt-1 hidden">+ Add Another Format</button>
            </div>

            <!-- Nature of Information -->
            <input type="text" name="information_nature[]" placeholder="Nature of Information" class="section-activity p-2 border rounded-lg w-full">

            <!-- Categories of Personal Data -->
            <div class="dynamic-field">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Categories of Personal Data</label>
                <div class="personal-categories-wrapper flex flex-wrap gap-2">
                    <label class="flex items-center gap-1"><input type="checkbox" name="personal_data_categories[0][]" value="Name"> Name</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="personal_data_categories[0][]" value="Address"> Address</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="personal_data_categories[0][]" value="Email"> Email</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="personal_data_categories[0][]" value="Phone"> Phone</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="personal_data_categories[0][]" value="ID Number"> ID Number</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="personal_data_categories[0][]" value="Financial"> Financial</label>
                    <label class="flex items-center gap-1"><input type="checkbox" name="personal_data_categories[0][]" value="Health"> Health</label>
                    <label class="flex items-center gap-1">
                        <input type="checkbox" class="other-category-checkbox"> Other
                    </label>
                </div>
                <div class="other-categories-container mt-1"></div>
                <button type="button" class="add-other-category bg-orange-500 text-white px-2 py-1 rounded-lg mt-1 hidden">+ Add Another Category</button>
            </div>

            <!-- Approximate Number of Records -->
            <div>
                <label for="records_count" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Approximate Number of Records</label>
                <input type="number" name="records_count[]" placeholder="Enter number of records" class="section-activity p-2 border rounded-lg w-full" min="0">
            </div>

            <!-- Data Volume -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Data Volume</label>
                <input type="text" name="data_volume[]" placeholder="Low / Medium / High" class="section-activity p-2 border rounded-lg w-full" readonly>
            </div>

            <!-- Retention Period & People with Access -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 mb-2">
                <input type="number" name="retention_period_years[]" placeholder="Retention Period (Years)" class="section-legal p-2 border rounded-lg w-full">
                <input type="number" name="access_estimate[]" placeholder="Estimated Number of People With Access to Data" class="section-legal p-2 border rounded-lg w-full">
            </div>
            <textarea name="retention_rationale[]" placeholder="Retention Rationale" rows="2" class="section-legal p-2 border rounded-lg w-full"></textarea>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // --- Other Format Checkbox ---
    document.addEventListener('change', function(e){
        // Data Formats Other
        if(e.target.classList.contains('other-format-checkbox')){
            const container = e.target.closest('.dynamic-field').querySelector('.other-formats-container');
            const addBtn = e.target.closest('.dynamic-field').querySelector('.add-other-format');
            addBtn.classList.toggle('hidden', !e.target.checked);
            if(!e.target.checked) container.innerHTML = '';
        }

        // Personal Categories Other
        if(e.target.classList.contains('other-category-checkbox')){
            const container = e.target.closest('.dynamic-field').querySelector('.other-categories-container');
            const addBtn = e.target.closest('.dynamic-field').querySelector('.add-other-category');
            addBtn.classList.toggle('hidden', !e.target.checked);
            if(!e.target.checked) container.innerHTML = '';
        }

        // Data Sources Other
        if(e.target.classList.contains('other-source-checkbox')){
            const container = e.target.closest('.dynamic-field').querySelector('.other-sources-container');
            const addBtn = e.target.closest('.dynamic-field').querySelector('.add-other-source');
            addBtn.classList.toggle('hidden', !e.target.checked);
            if(!e.target.checked) container.innerHTML = '';
        }
    });

    // Add new Other Format dynamically
    document.querySelectorAll('.add-other-format').forEach(btn => {
        btn.addEventListener('click', function(){
            const container = this.previousElementSibling;
            const index = Array.from(document.querySelectorAll('.process-row')).indexOf(this.closest('.process-row'));
            const div = document.createElement('div');
            div.classList.add('flex','items-center','gap-2','mt-1');
            div.innerHTML = `
                <input type="text" name="data_formats_other[${index}][]" placeholder="Specify other format" class="section-activity p-2 border rounded-lg w-full">
                <button type="button" class="remove-other-format bg-red-500 text-white px-2 rounded-lg">Remove</button>
            `;
            container.appendChild(div);
        });
    });

    // Add new Other Category dynamically
    document.querySelectorAll('.add-other-category').forEach(btn => {
        btn.addEventListener('click', function(){
            const container = this.previousElementSibling;
            const index = Array.from(document.querySelectorAll('.process-row')).indexOf(this.closest('.process-row'));
            const div = document.createElement('div');
            div.classList.add('flex','items-center','gap-2','mt-1');
            div.innerHTML = `
                <input type="text" name="personal_data_categories_other[${index}][]" placeholder="Specify other category" class="section-activity p-2 border rounded-lg w-full">
                <button type="button" class="remove-other-category bg-red-500 text-white px-2 rounded-lg">Remove</button>
            `;
            container.appendChild(div);
        });
    });

    // Add new Other Source dynamically
    document.querySelectorAll('.add-other-source').forEach(btn => {
        btn.addEventListener('click', function(){
            const container = this.previousElementSibling;
            const index = Array.from(document.querySelectorAll('.process-row')).indexOf(this.closest('.process-row'));
            const div = document.createElement('div');
            div.classList.add('flex','items-center','gap-2','mt-1');
            div.innerHTML = `
                <input type="text" name="data_sources_other[${index}][]" placeholder="Specify other source" class="section-activity p-2 border rounded-lg w-full">
                <button type="button" class="remove-other-source bg-red-500 text-white px-2 rounded-lg">Remove</button>
            `;
            container.appendChild(div);
        });
    });

    // Remove dynamic elements
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-other-format')) e.target.parentElement.remove();
        if(e.target.classList.contains('remove-other-category')) e.target.parentElement.remove();
        if(e.target.classList.contains('remove-other-source')) e.target.parentElement.remove();
        if(e.target.classList.contains('remove-source')) e.target.parentElement.remove();
    });

    // Add Data Source dynamically
    document.querySelectorAll('.add-source').forEach(btn => {
        btn.addEventListener('click', function(){
            const wrapper = this.previousElementSibling;
            const index = Array.from(document.querySelectorAll('.process-row')).indexOf(this.closest('.process-row'));
            const div = document.createElement('div');
            div.classList.add('flex','gap-2','mb-2');
            div.innerHTML = `<input type="text" name="data_sources[${index}][]" placeholder="Additional Data Source" class="section-activity p-2 border rounded-lg w-full">
                             <button type="button" class="bg-red-600 text-white px-2 rounded-lg remove-source">-</button>`;
            wrapper.appendChild(div);
        });
    });

    // Update Data Volume based on number of records
    document.addEventListener('input', function(e){
        if(e.target.name === 'records_count[]'){
            const value = parseInt(e.target.value);
            let volume = '';
            if(isNaN(value)){
                volume = '';
            } else if(value < 25){
                volume = 'Low';
            } else if(value <= 100){
                volume = 'Medium';
            } else {
                volume = 'High';
            }
            e.target.closest('.process-row').querySelector('input[name="data_volume[]"]').value = volume;
        }
    });

});
</script>





{{-- SECTION 3: Data Sharing & Outsourcing (with Access Control) --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-orange-500 flex items-center">
            <i data-feather="share-2" class="w-5 h-5 mr-2"></i> Data Sharing & Outsourcing
        </h2>
      
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <select name="information_shared" id="information_shared"
                class="p-2 border rounded-lg w-full focus:ring-2 focus:ring-orange-500 hover:border-orange-500">
            <option value="">Information Shared?</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div id="infoSharingSection" class="mt-6 hidden">

        <h3 class="text-lg font-semibold mb-3 text-orange-600">Information Sharing Details</h3>

        <div class="flex gap-6 mb-4">
            <label class="flex items-center space-x-2">
                <input type="checkbox" id="local_check" name="sharing_local" value="1"
                       class="h-4 w-4 text-orange-500">
                <span>Local Sharing</span>
            </label>

            <label class="flex items-center space-x-2">
                <input type="checkbox" id="trans_check" name="sharing_transborder" value="1"
                       class="h-4 w-4 text-orange-500">
                <span>Transborder Sharing</span>
            </label>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Local --}}
            <div id="localContainer" class="col-span-1 sm:col-span-2 hidden">
                <label class="block mb-2 font-semibold">Organizations Shared With (Local)</label>
                <div id="localRepeat">
                    <div class="flex gap-2 mb-2">
                        <input type="text" name="local_organizations[]" 
                               class="p-2 border rounded-lg w-full"
                               placeholder="Enter organization">
                        <button type="button" class="removeLocal bg-red-500 text-white px-3 py-2 rounded-md hidden">-</button>
                    </div>
                </div>
                <button type="button" id="addLocal"
                        class="mt-2 bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    + Add Organization
                </button>
            </div>

            {{-- Transborder --}}
            <div id="transContainer" class="col-span-1 sm:col-span-2 hidden">
                <label class="block mb-2 font-semibold">Countries Shared With (Transborder)</label>
                <div id="transRepeat">
                    <div class="flex gap-2 mb-2">
                       <input  type="text"  name="transborder_countries[]"  class="p-2 border rounded-lg w-full"  placeholder="Enter Country"/>
                        <button type="button" class="removeTrans bg-red-500 text-white px-3 py-2 rounded-md hidden">-</button>
                    </div>
                </div>
                <button type="button" id="addTrans"
                        class="mt-2 bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    + Add Country
                </button>
            </div>

            <textarea name="sharing_comment" id="sharing_comment" placeholder="Comments..."
                      class="p-2 border rounded-lg w-full hidden col-span-1 sm:col-span-2"></textarea>

        </div>


{{-- ACCESS CONTROL MANAGEMENT --}}
<div class="mt-6">
    <h3 class="text-lg font-semibold mb-3 text-orange-600 flex items-center">
        <i data-feather="users" class="w-5 h-5 mr-2"></i> Access Control Management
    </h3>

    <div class="grid grid-cols-1 gap-4">
        <select name="access_control" id="access_control" 
                class="p-2 border rounded-lg w-full">
            <option value="">Access Controlled?</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <div id="accessMeasuresSection" class="hidden">
            <label class="font-semibold mb-2 block">Access Control Measures</label>

            {{-- Dynamic “Other” textboxes --}}
            <div id="otherMeasuresContainer" class="mt-3 hidden">
                <label class="font-semibold mb-2 block">Specify Other Measures</label>

                <div id="otherRepeat">
                    <div class="flex items-center gap-2 mb-2">
                        <input type="text" name="access_measures[]" 
                               placeholder="Enter custom measure"
                               class="p-2 border rounded-lg w-full">
                        <button type="button"
                                class="removeOther hidden bg-red-500 text-white px-3 py-2 rounded-md">-</button>
                    </div>
                </div>

                <button type="button" id="addOtherMeasure"
                        class="mt-2 bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    + Add More
                </button>
            </div>

            {{-- Technical Measures --}}
            <div class="mt-4">
                <label class="font-semibold mb-2 block text-gray-700">Technical Measures</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="technical_measures[]" value="Encryption at rest & in transit">
                        <span>Encryption at rest & in transit</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="technical_measures[]" value="Role-Based Access Control (RBAC)">
                        <span>Role-Based Access Control (RBAC)</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="technical_measures[]" value="Multi-factor authentication (MFA)">
                        <span>Multi-factor authentication (MFA)</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="technical_measures[]" value="Automatic audit logs">
                        <span>Automatic audit logs</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="technical_measures[]" value="Segmented network architecture">
                        <span>Segmented network architecture</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="technical_measures[]" value="Firewalls and VPN-restricted admin access">
                        <span>Firewalls and VPN-restricted admin access</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="technical_measures[]" value="Regular vulnerability scanning and patching">
                        <span>Regular vulnerability scanning and patching</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="technical_measures[]" value="High-availability and fail-safe mechanisms">
                        <span>High-availability and fail-safe mechanisms</span>
                    </label>
                </div>
            </div>

            {{-- Organisational Measures --}}
            <div class="mt-4">
                <label class="font-semibold mb-2 block text-gray-700">Organisational Measures</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Biometric privacy notice">
                        <span>Biometric privacy notice</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Internal privacy data policy">
                        <span>Internal privacy data policy</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Administrator access governance">
                        <span>Administrator access governance</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Conduct DPIAs">
                        <span>Conduct DPIAs</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Legitimate Interest Assessment (LIA)">
                        <span>Legitimate Interest Assessment (LIA)</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Retention and disposal schedule">
                        <span>Retention and disposal schedule</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Incident response and breach reporting procedures">
                        <span>Incident response and breach reporting procedures</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Employee onboarding and privacy training">
                        <span>Employee onboarding and privacy training</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Vendor due diligence and contractual safeguards">
                        <span>Vendor due diligence and contractual safeguards</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="organisational_measures[]" value="Periodic internal audits">
                        <span>Periodic internal audits</span>
                    </label>
                </div>
            </div>

        </div>
        </div>
        </div>
    </div>
</div>

{{-- COUNTRY LIST --}}
<script src="https://cdn.jsdelivr.net/npm/countries-list@2.5.6/dist/countries.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* -------------------------------
       DATA SHARING
    --------------------------------*/
    const infoShared = document.getElementById('information_shared');
    const infoSection = document.getElementById('infoSharingSection');
    const localCheck = document.getElementById('local_check');
    const transCheck = document.getElementById('trans_check');
    const localContainer = document.getElementById('localContainer');
    const transContainer = document.getElementById('transContainer');
    const comment = document.getElementById('sharing_comment');

    infoShared.addEventListener('change', () => {
        if (infoShared.value === "1") infoSection.classList.remove('hidden');
        else {
            infoSection.classList.add('hidden');
            localCheck.checked = false;
            transCheck.checked = false;
            localContainer.classList.add('hidden');
            transContainer.classList.add('hidden');
            comment.classList.add('hidden');
        }
    });

    const updateShareVisibility = () => {
        localContainer.classList.toggle('hidden', !localCheck.checked);
        transContainer.classList.toggle('hidden', !transCheck.checked);
        comment.classList.toggle('hidden', !(localCheck.checked || transCheck.checked));
    };

    localCheck.addEventListener('change', updateShareVisibility);
    transCheck.addEventListener('change', updateShareVisibility);

    /* ADD / REMOVE LOCAL ORGS */
    document.getElementById('addLocal').addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = "flex gap-2 mb-2";
        div.innerHTML = `
            <input type="text" name="local_organizations[]" class="p-2 border rounded-lg w-full">
            <button type="button" class="removeLocal bg-red-500 text-white px-3 py-2 rounded-md">-</button>`;
        document.getElementById('localRepeat').appendChild(div);
    });

    document.getElementById('localRepeat').addEventListener('click', e => {
        if (e.target.classList.contains('removeLocal')) e.target.parentElement.remove();
    });

    /* -------------------------------
       COUNTRY LIST POPULATION
    --------------------------------*/
    const populateCountries = () => {
        document.querySelectorAll('.country-select').forEach(select => {
            select.innerHTML = '<option value="">Select Country</option>';
            for (const code in window.countries) {
                const opt = document.createElement('option');
                opt.value = window.countries[code].name;
                opt.text = window.countries[code].name;
                select.appendChild(opt);
            }
        });
    };
    populateCountries();

    document.getElementById('addTrans').addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = "flex gap-2 mb-2";
        const clone = document.querySelector('.country-select').cloneNode(true);
        clone.value = "";
        div.appendChild(clone);
        div.innerHTML += `<button type="button" class="removeTrans bg-red-500 text-white px-3 py-2 rounded-md">-</button>`;
        document.getElementById('transRepeat').appendChild(div);
        populateCountries();
    });

    document.getElementById('transRepeat').addEventListener('click', e => {
        if (e.target.classList.contains('removeTrans')) e.target.parentElement.remove();
    });

    /* -------------------------------
       ACCESS CONTROL — RADIO SYSTEM
    --------------------------------*/
    const accessControl = document.getElementById('access_control');
    const accessSection = document.getElementById('accessMeasuresSection');
    const otherRadio = document.getElementById('otherMeasureRadio');
    const otherContainer = document.getElementById('otherMeasuresContainer');
    const otherRepeat = document.getElementById('otherRepeat');

    accessControl.addEventListener('change', () => {
        if (accessControl.value === "1") accessSection.classList.remove('hidden');
        else accessSection.classList.add('hidden');
    });

    /* Show/Hide "Other" inputs */
    document.querySelectorAll('.measureRadio').forEach(radio => {
        radio.addEventListener('change', () => {
            if (otherRadio.checked) otherContainer.classList.remove('hidden');
            else otherContainer.classList.add('hidden');
        });
    });

    /* Add more "Other" fields */
    document.getElementById('addOtherMeasure').addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = "flex items-center gap-2 mb-2";
        div.innerHTML = `
            <input type="text" name="access_measures[]" class="p-2 border rounded-lg w-full">
            <button type="button" class="removeOther bg-red-500 text-white px-3 py-2 rounded-md">-</button>
        `;
        otherRepeat.appendChild(div);
    });

    /* Remove "Other" fields */
    otherRepeat.addEventListener('click', e => {
        if (e.target.classList.contains('removeOther')) e.target.parentElement.remove();
    });

    if (window.feather) feather.replace();
});
</script>



<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-orange-500 flex items-center">
            <i data-feather="file-text" class="w-5 h-5 mr-2"></i>  Lawful Basis for Processing
        </h2>
       
    </div>

    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-4">
        <div class="bg-red-600 h-2 rounded-full" id="legalProgress" style="width: 0%"></div>
    </div>

    {{-- LAWFUL BASIS CHECKBOXES --}}
    <label class="font-semibold text-gray-700 dark:text-gray-300 mb-2 block">
       
    </label>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4 text-sm">

        <label class="flex items-center space-x-2">
            <input type="checkbox" name="lawful_basis[]" value="Consent" class="lawful-option section-legal">
            <span>Consent</span>
        </label>

        <label class="flex items-center space-x-2">
            <input type="checkbox" name="lawful_basis[]" value="Contractual Obligation" class="lawful-option section-legal">
            <span>Contractual Obligation</span>
        </label>

        <label class="flex items-center space-x-2">
            <input type="checkbox" name="lawful_basis[]" value="Legal Obligation" class="lawful-option section-legal">
            <span>Legal Obligation</span>
        </label>

        <label class="flex items-center space-x-2">
            <input type="checkbox" name="lawful_basis[]" value="Vital Interest" class="lawful-option section-legal">
            <span>Vital Interest</span>
        </label>

        <label class="flex items-center space-x-2">
            <input type="checkbox" name="lawful_basis[]" value="Public Interest" class="lawful-option section-legal">
            <span>Public Interest</span>
        </label>

        <label class="flex items-center space-x-2">
            <input type="checkbox" name="lawful_basis[]" value="Scientific Research" class="lawful-option section-legal">
            <span>Scientific Research</span>
        </label>

        <label class="flex items-center space-x-2">
            <input type="checkbox" name="lawful_basis[]" value="Legitimate Interest" class="lawful-option section-legal">
            <span>Legitimate Interest</span>
        </label>

        {{-- I DO NOT KNOW --}}
        <label class="flex items-center space-x-2 text-red-600 font-semibold">
            <input type="checkbox" id="lawful_idk" name="lawful_basis[]" value="I Do Not Know" class="section-legal">
            <span>I do not know</span>
        </label>
    </div>

    

{{-- SCRIPT FOR CHECKBOX LOGIC --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const idkCheckbox = document.getElementById('lawful_idk');
    const otherCheckboxes = document.querySelectorAll('.lawful-option');

    // When "I do not know" is checked → uncheck others
    idkCheckbox.addEventListener('change', function () {
        if (this.checked) {
            otherCheckboxes.forEach(cb => cb.checked = false);
        }
    });

    // When any other checkbox is selected → uncheck "I do not know"
    otherCheckboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            if (this.checked) {
                idkCheckbox.checked = false;
            }
        });
    });

});
</script>






        {{-- SECTION 8: Risk Reporting & Mitigation --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-orange-500 flex items-center">
                    <i data-feather="alert-triangle" class="w-5 h-5 mr-2"></i> Process Risk Reporting 
                </h2>
                
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-4">
                <div class="bg-red-700 h-2 rounded-full" id="riskProgress" style="width: 0%"></div>
            </div>

<div class="w-full mb-4">
    <textarea name="risk_report[]" placeholder="Risk Reporting" rows="4" class="section-risk p-2 border rounded-lg w-full"></textarea>
</div>

{{-- Feather Icons --}}
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        feather.replace({ 'aria-hidden': 'true' });

        const orgSelect = document.getElementById('organisation_name');
        const deptSelect = document.getElementById('department');
        const otherOrgContainer = document.getElementById('otherOrgContainer');
        const otherDeptContainer = document.getElementById('otherDeptContainer');

        // Show/hide "Other Organisation" field
        orgSelect.addEventListener('change', () => {
            if (orgSelect.value === 'Other') {
                otherOrgContainer.classList.remove('hidden');
            } else {
                otherOrgContainer.classList.add('hidden');
                document.getElementById('other_organisation_name').value = '';
            }
        });

        // Show/hide "Other Department" field
        deptSelect.addEventListener('change', () => {
            if (deptSelect.value === 'Other') {
                otherDeptContainer.classList.remove('hidden');
            } else {
                otherDeptContainer.classList.add('hidden');
                document.getElementById('other_department').value = '';
            }
        });
    });

    // Progress tracker
    function updateSectionProgress(sectionClass, progressId, labelId) {
        const fields = document.querySelectorAll(`.${sectionClass}`);
        const filled = Array.from(fields).filter(f => f.value.trim() !== "").length;
        const percent = fields.length ? Math.round((filled / fields.length) * 100) : 0;
        if(document.getElementById(progressId)) {
            document.getElementById(progressId).style.width = percent + '%';
        }
        if(document.getElementById(labelId)) {
            document.getElementById(labelId).textContent = percent + '%';
        }
        return percent;
    }

    function updateOverallProgress() {
        const sections = [
            'section-org','section-activity','section-share','section-legal',
            'section-access','section-submit','section-risk'
        ];
        const total = sections.length;
        let sum = 0;
        sections.forEach(sec => sum += updateSectionProgress(sec, 'temp', 'temp'));
        const overall = Math.round(sum / total);
        document.getElementById('overallProgress').style.width = overall + '%';
        document.getElementById('overallProgressLabel').textContent = overall + '%';

        updateSectionProgress('section-risk', 'riskProgress', 'riskProgressLabel');
    }

    document.querySelectorAll('.section-org, .section-activity, .section-share, .section-legal, .section-access, .section-submit, .section-risk')
        .forEach(input => input.addEventListener('input', updateOverallProgress));

    updateOverallProgress();
</script>



<div class="flex justify-end mt-6">
    <button type="submit" form="progressForm" 
        class="bg-orange-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 flex items-center">
        <i data-feather="check" class="w-5 h-5 mr-2"></i> Submit
    </button>
</div>

</form>

@endsection
