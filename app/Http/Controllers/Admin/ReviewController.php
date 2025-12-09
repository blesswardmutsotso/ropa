<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Ropa;
use App\Models\Comment; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReviewsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * ADMIN: List all reviews
     */
    public function index(Request $request)
{
    $query = Review::with(['user', 'ropa']);

    // ---------------------
    // SEARCH
    // ---------------------
    if ($request->filled('search')) {
        $search = $request->input('search');

        $query->where(function ($qr) use ($search) {
            $qr->whereHas('user', function ($u) use ($search) {
                $u->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('ropa', function ($r) use ($search) {
                $r->where('id', $search);
            });
        });
    }

    // ---------------------
    // FILTERING
    // ---------------------
    if ($request->filled('dpa')) {
        $query->where('data_processing_agreement', $request->dpa);
    }

    if ($request->filled('dpia')) {
        $query->where('data_protection_impact_assessment', $request->dpia);
    }

    // ---------------------
    // SORTING
    // ---------------------
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'score_high':
                $query->orderBy('average_score', 'desc');
                break;
            case 'score_low':
                $query->orderBy('average_score', 'asc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
    } else {
        $query->orderBy('created_at', 'desc');
    }

    // ---------------------
    // GET RESULTS
    // ---------------------
    $reviews = $query->paginate(10)->withQueryString();

    return view('admindashboard.review.index', compact('reviews'));
}


    /**
 * ADMIN: Show a specific review
 */
public function show($id)
{
    $review = Review::with([
        'user',         // the reviewer
        'ropa',         // associated ROPA
        'comments.user' // load comments and the users who made them
    ])->findOrFail($id);

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


public function reviewRiskDashboard()
{
    $reviews = Review::all();

    $total = max($reviews->count(), 1);

    $critical = $reviews->filter(fn($r) => $r->total_score <= 50)->count();
    $high     = $reviews->filter(fn($r) => $r->total_score > 50 && $r->total_score <= 100)->count();
    $medium   = $reviews->filter(fn($r) => $r->total_score > 100 && $r->total_score <= 160)->count();
    $low      = $reviews->filter(fn($r) => $r->total_score > 160)->count();

    $criticalRisk = round(($critical / $total) * 100, 1);
    $highRisk     = round(($high / $total) * 100, 1);
    $mediumRisk   = round(($medium / $total) * 100, 1);
    $lowRisk      = round(($low / $total) * 100, 1);

    return view('admindashboard.dashboard', compact(
        'criticalRisk', 'highRisk', 'mediumRisk', 'lowRisk', 'reviews'
    ));
}




public function addComment(Request $request, Review $review)
{
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $review->comments()->create([
        'user_id' => auth()->id(),   // or null if admin is not authenticated
        'content' => $request->input('content'),
    ]);

    return redirect()->back()->with('success', 'Comment added successfully.');
}


public function deleteComment(Comment $comment)
{
    $comment->delete(); // soft delete
    return back()->with('success', 'Comment deleted successfully.');
}


}
