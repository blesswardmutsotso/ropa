<?php

namespace App\Http\Controllers;

use App\Models\Ropa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RopaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display ROPA records for the logged-in user.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');

            $ropas = Ropa::with('user')
                ->where('user_id', auth()->id())
                ->when($search, function ($query, $search) {
                    $query->whereJsonContains('ropa_create->organisation_name', $search)
                          ->orWhereJsonContains('ropa_create->department_name', $search)
                          ->orWhereJsonContains('ropa_create->other_department', $search)
                          ->orWhereJsonContains('ropa_create->status', $search);
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('ropa.index', compact('ropas'));
        } catch (\Exception $e) {
            Log::error('Error fetching ROPA records', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to load ROPA records. Please try again.');
        }
    }

    /**
     * Show the form to create a new ROPA.
     */
    public function create()
    {
        try {
            return view('ropa.create', [
                'lawfulOptions' => $this->getLawfulBasisOptions(),
                'personalDataOptions' => $this->getPersonalDataCategories(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error showing ROPA create form', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to open ROPA form. Please try again.');
        }
    }

    /**
     * Store a new ROPA record.
     */
    public function store(Request $request)
{
    try {
        // Validate fields
        $data = $this->validateRopa($request);

        // 🔹 Handle department mapping
        if (isset($data['department']) && $data['department'] === 'Other') {
            $data['department_name'] = $data['other_department'] ?? null;
        } else {
            $data['department_name'] = $data['department'] ?? null;
        }

        // 🔹 Set default status
        $data['status'] = 'Pending';

        // 🔹 Save ROPA record
        $ropa = Ropa::create([
            'user_id' => auth()->id(),
            'status' => 'Pending',
            'ropa_create' => $data,
        ]);

        Log::info('ROPA record created', [
            'user_id' => auth()->id(),
            'ropa_id' => $ropa->id
        ]);

        return redirect()->route('ropa.index')->with('success', 'ROPA record created successfully.');
        
    } catch (\Exception $e) {

        Log::error('Error creating ROPA record', [
            'message' => $e->getMessage(),
            'stack' => $e->getTraceAsString()
        ]);

        return redirect()->back()->withInput()->with('error', 'Failed to create ROPA record. Please try again.');
    }
}


    /**
     * Show the form to edit an existing ROPA record.
     */
    public function edit(Ropa $ropa)
    {
        $this->authorizeRopaOwner($ropa);

        try {
            return view('ropa.edit', [
                'ropa' => $ropa,
                'lawfulOptions' => $this->getLawfulBasisOptions(),
                'personalDataOptions' => $this->getPersonalDataCategories(),
                'ropaData' => $ropa->ropa_create ?? [],
            ]);
        } catch (\Exception $e) {
            Log::error('Error editing ROPA record', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to open ROPA edit form. Please try again.');
        }
    }

    /**
     * Update an existing ROPA record.
     */
    public function update(Request $request, Ropa $ropa)
    {
        $this->authorizeRopaOwner($ropa);

        try {
            $data = $this->validateRopa($request, true);

            $ropa->update([
                'ropa_create' => $data,
                'status' => $data['status'] ?? $ropa->status,
            ]);

            Log::info('ROPA record updated', [
                'user_id' => auth()->id(),
                'ropa_id' => $ropa->id
            ]);

            return redirect()->route('ropa.index')->with('success', 'ROPA record updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating ROPA record', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withInput()->with('error', 'Failed to update ROPA record. Please try again.');
        }
    }

    /**
     * Delete a ROPA record.
     */
    public function destroy(Ropa $ropa)
    {
        $this->authorizeRopaOwner($ropa);

        try {
            $ropa->delete();
            Log::info('ROPA record deleted', [
                'user_id' => auth()->id(),
                'ropa_id' => $ropa->id
            ]);

            return redirect()->route('ropa.index')->with('success', 'ROPA record deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting ROPA record', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to delete ROPA record. Please try again.');
        }
    }

    /**
     * Validate ROPA request data.
     */
    private function validateRopa(Request $request, bool $updating = false): array
{
    // Clean arrays before validation
    $request->merge([
        'data_sources' => array_filter($request->input('data_sources', []), fn($v) => is_string($v) && trim($v) !== ''),
        'data_formats' => array_filter($request->input('data_formats', []), fn($v) => is_string($v) && trim($v) !== ''),
        'processes' => array_filter($request->input('processes', []), fn($v) => is_string($v) && trim($v) !== ''),
    ]);

    return $request->validate([
        'organisation_name' => 'nullable|string|max:255',

        // Department handling
        'department' => 'nullable|string|max:255',
        'other_department' => 'nullable|string|max:255',

        'other_specify' => 'nullable|string|max:255',

        'information_shared' => 'nullable|boolean',
        'information_nature' => 'nullable|string',

        'outsourced_processing' => 'nullable|boolean',
        'processor' => 'nullable|string|max:255',

        'transborder_processing' => 'nullable|boolean',
        'country' => 'nullable|string|max:255',

        'lawful_basis' => 'nullable|array',
        'lawful_basis.*' => 'nullable|string|max:255',

        'retention_period_years' => 'nullable|integer|min:0',
        'retention_rationale' => 'nullable|string',

        'users_count' => 'nullable|integer|min:1',
        'access_control' => 'nullable|boolean',

        'personal_data_category' => 'nullable|array',
        'personal_data_category.*' => 'nullable|string|max:255',

        'processes' => 'nullable|array',
        'processes.*' => 'nullable|string|max:255',

        'data_sources' => 'nullable|array',
        'data_sources.*' => 'nullable|string|max:255',

        'data_formats' => 'nullable|array',
        'data_formats.*' => 'nullable|string|max:255',

        'status' => $updating ? 'nullable|string|in:Pending,Reviewed' : 'nullable',
    ]);
}


    /**
     * Ensure the logged-in user owns the ROPA record.
     */
    private function authorizeRopaOwner(Ropa $ropa)
    {
        if ($ropa->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Options for lawful basis.
     */
    private function getLawfulBasisOptions(): array
    {
        return [
            'Consent',
            'Contractual Obligation',
            'Legal Obligation',
            'Vital Interest',
            'Public Interest',
            'Legitimate Interest',
            'Where The Data Subject Has Made The Information Public',
            'Scientific Research',
        ];
    }

    /**
     * Options for personal data categories.
     */
    private function getPersonalDataCategories(): array
    {
        return [
            'Name',
            'Email',
            'Phone Number',
            'Address',
            'Date of Birth',
            'Identification Number',
            'Health Data',
            'Financial Data',
            'Employment Data',
            'Other',
        ];
    }
}
