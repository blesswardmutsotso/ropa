<?php

namespace App\Http\Controllers;
use App\Models\Ropa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Review;
use App\Notifications\NewRopaSubmitted;

class RopaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    return view ('ropa.index');
}

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    try {
        Log::info('ROPA store request received', [
            'user_id' => auth()->id(),
            'request_keys' => array_keys($request->all())
        ]);

        // -------------------------------------------------------
        // Validate incoming request
        // -------------------------------------------------------
        $validated = $request->validate([
            'organisation_name' => 'nullable|string|max:255',
            'other_organisation_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'other_department' => 'nullable|string|max:255',

            'processes' => 'nullable|array',
            'data_sources' => 'nullable|array',
            'data_sources_other' => 'nullable|array',
            'data_formats' => 'nullable|array',
            'data_formats_other' => 'nullable|array',
            'information_nature' => 'nullable|array',
            'personal_data_categories' => 'nullable|array',
            'personal_data_categories_other' => 'nullable|array',
            'records_count' => 'nullable|array',
            'data_volume' => 'nullable|array',
            'retention_period_years' => 'nullable|array',
            'access_estimate' => 'nullable|array',
            'retention_rationale' => 'nullable|array',

            'information_shared' => 'nullable|boolean',
            'sharing_local' => 'nullable|boolean',
            'sharing_transborder' => 'nullable|boolean',

            'local_organizations' => 'nullable|array',
            'transborder_countries' => 'nullable|array',
            'sharing_comment' => 'nullable|string',

            'access_control' => 'nullable|boolean',
            'access_measures' => 'nullable|array',
            'technical_measures' => 'nullable|array',
            'organisational_measures' => 'nullable|array',
            'lawful_basis' => 'nullable|array',
            'risk_report' => 'nullable|array',
        ]);

        // Assign user + default status
        $validated['user_id'] = auth()->id();
        $validated['status'] = Ropa::STATUS_PENDING;

        // -------------------------------------------------------
        // CREATE THE ROPA
        // -------------------------------------------------------
        $ropa = Ropa::create($validated);

        Log::info('ROPA created successfully', [
            'ropa_id' => $ropa->id,
            'user_id' => auth()->id()
        ]);

        // -------------------------------------------------------
        // CREATE EMPTY REVIEW RECORD
        // -------------------------------------------------------
        $review = Review::create([
            'ropa_id' => $ropa->id,
            'user_id' => null, // admin will fill when reviewing
            'comment' => null,
            'score' => 0,
            'section_scores' => [
        'organisation_information' => 0,
        'department_information' => 0,
        'processes' => 0,
        'data_sources' => 0,
        'data_formats' => 0,
        'information_nature' => 0,
        'personal_data_categories' => 0,
        'records_count' => 0,
        'data_volume' => 0,
        'retention_period' => 0,
        'access_estimate' => 0,
        'sharing' => 0,
        'access_control' => 0,
        'technical_measures' => 0,
        'organisational_measures' => 0,
        'lawful_basis' => 0,
        'risk_report' => 0,
    ],
            'data_processing_agreement' => false,
            'data_protection_impact_assessment' => false,
        ]);

        Log::info('Review create attempt', [
            'ropa_id' => $ropa->id,
            'review_exists' => $review->exists,
            'review_data' => $review->toArray(),
        ]);

        // -------------------------------------------------------
        // Notify admins
        // -------------------------------------------------------
        $admins = User::where('user_type', 1)->get();
        Notification::send($admins, new NewRopaSubmitted($ropa));

        // -------------------------------------------------------
        // Redirect back
        // -------------------------------------------------------
        return redirect()
            ->route('ropa.index')
            ->with('success', 'ROPA record created successfully.');

    } catch (\Throwable $e) {

        Log::error('ROPA STORE FAILED', [
            'user_id' => auth()->id(),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Something went wrong while saving the ROPA record.');
    }
}



    /**
     * Display the specified resource.
     */
    public function show(Ropa $ropa)
    {
        return response()->json([
            'message' => 'ROPA record fetched successfully',
            'data' => $ropa
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ropa $ropa)
    {
        $validated = $this->validateRopa($request);
        $ropa->update($validated);

        return response()->json([
            'message' => 'ROPA record updated successfully',
            'data' => $ropa
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ropa $ropa)
    {
        $ropa->delete();

        return response()->json([
            'message' => 'ROPA record deleted successfully'
        ]);
    }

    /**
     * Validate ROPA request data.
     */
    private function validateRopa(Request $request)
    {
        return $request->validate([
            'organisation_name' => 'nullable|string|max:255',
            'other_organisation_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'other_department' => 'nullable|string|max:255',
            'processes' => 'nullable|array',
            'data_sources' => 'nullable|array',
            'data_sources_other' => 'nullable|array',
            'data_formats' => 'nullable|array',
            'data_formats_other' => 'nullable|array',
            'information_nature' => 'nullable|array',
            'personal_data_categories' => 'nullable|array',
            'personal_data_categories_other' => 'nullable|array',
            'records_count' => 'nullable|array',
            'data_volume' => 'nullable|array',
            'retention_period_years' => 'nullable|array',
            'access_estimate' => 'nullable|array',
            'retention_rationale' => 'nullable|array',
            'information_shared' => 'nullable|boolean',
            'sharing_local' => 'nullable|boolean',
            'sharing_transborder' => 'nullable|boolean',
            'local_organizations' => 'nullable|array',
            'transborder_countries' => 'nullable|array',
            'sharing_comment' => 'nullable|string',
            'access_control' => 'nullable|boolean',
            'access_measures' => 'nullable|array',
            'technical_measures' => 'nullable|array',
            'organisational_measures' => 'nullable|array',
            'lawful_basis' => 'nullable|array',
            'risk_report' => 'nullable|array',
            'status' => 'nullable|string|in:Pending,Reviewed'
        ]);
    }
}