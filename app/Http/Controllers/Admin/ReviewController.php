<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Ropa;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReviewsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * ADMIN: List all reviews
     */
    public function index()
    {
        $reviews = Review::with(['user', 'ropa'])
            ->latest()
            ->paginate(10);

        return view('admindashboard.review.index', compact('reviews'));
    }

    /**
 * ADMIN: Show a specific review
 */
public function show($id)
{
    $review = Review::with(['user', 'ropa'])->findOrFail($id);

    // Ensure section_scores is always an array
    $review->section_scores = is_array($review->section_scores)
        ? $review->section_scores
        : [];

    // Auto-assign reviewer if none is set
    if (!$review->user_id && auth()->check()) {
        $review->user_id = auth()->id();
        $review->save();
    }

    return view('admindashboard.review.show', compact('review'));
}


    /**
     * ADMIN: Edit/update section scores
     */
    public function update(Request $request, $id)
{
    $review = Review::findOrFail($id);

    // Make sure section_scores is always an array (even if empty)
    $validated = $request->validate([
        'section_scores'     => 'nullable|array',
        'section_scores.*'   => 'nullable|numeric|min:0|max:10',
    ]);

    // Ensure blank inputs become 0
    $scores = collect($validated['section_scores'] ?? [])
        ->map(fn($score) => is_numeric($score) ? (int)$score : 0)
        ->toArray();

    $review->section_scores = $scores;
    $review->save();

    return redirect()
        ->route('admin.reviews.show', $review->id)
        ->with('success', 'Section scores updated successfully.');
}


    /**
     * ADMIN: Update compliance checkboxes (DPA / DPIA)
     */
    public function updateCompliance(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $review->update([
            'data_processing_agreement' => $request->has('data_processing_agreement'),
            'data_protection_impact_assessment' => $request->has('data_protection_impact_assessment'),
        ]);

        return redirect()
            ->route('admin.reviews.show', $review->id)
            ->with('success', 'Compliance fields updated.');
    }


    /**
     * ADMIN: Delete a review
     */
    public function destroy($id)
    {
        Review::findOrFail($id)->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }



    public function export()
{
    return Excel::download(new ReviewsExport, 'reviews.xlsx');
}


}
