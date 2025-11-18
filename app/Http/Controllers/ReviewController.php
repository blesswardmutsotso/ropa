<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Ropa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
 public function index()
{
    // Fetch paginated ROPAs submitted by the authenticated user
    $ropas = \App\Models\Ropa::with('reviews.user')
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate(5); // paginate 5 items per page

    // Fetch all ROPA details for looping (optional if needed separately)
    $allRopas = \App\Models\Ropa::with('reviews.user')
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('reviews.index', compact('ropas', 'allRopas'));
}




    /**
     * Show the form for creating a new review.
     */
    public function create(Ropa $ropa)
    {
        return view('reviews.create', compact('ropa'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ropa_id' => 'required|exists:ropas,id',
            'comment' => 'required|string',
            'score'   => 'required|integer|min:1|max:100',
        ]);

        Review::create([
            'ropa_id' => $request->ropa_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'score'   => $request->score,
        ]);

        return redirect()
            ->route('reviews.index')
            ->with('success', 'Review created successfully.');
    }

    /**
     * Display a single review.
     */
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing a review.
     */
    public function edit(Review $review)
    {
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'comment' => 'required|string',
            'score'   => 'required|integer|min:1|max:100',
        ]);

        $review->update([
            'comment' => $request->comment,
            'score'   => $request->score,
        ]);

        return redirect()
            ->route('reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()
            ->route('reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
