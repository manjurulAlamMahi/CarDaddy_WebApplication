<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Traits\apiresponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    use ApiResponse;

    public function get(Request $request)
    {
        $reviews = Review::where('reviewable_id', $request->reviewable_id)
            ->where('reviewable_type', $request->reviewable_type)
            ->where('status', $request->status)
            ->with('user')
            ->get();

        return response()->json($reviews);

        return $this->success($reviews, 'successfully', 201);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'reviewable_id'   => 'required|integer',
                'reviewable_type' => 'required|string',
                'rating'          => 'required|integer|min:1|max:5',
                'comment'         => 'nullable|string',
            ]);

            $reviewable_type = match ($request->reviewable_type) {
                'vehicle'     => Vehicle::class,
            };


            $review = Review::create([
                'user_id'         => Auth::id(),
                'reviewable_id'   => $request->reviewable_id,
                'reviewable_type' => $reviewable_type,
                'rating'          => $request->rating,
                'comment'         => $request->comment,
            ]);

            return $this->success($review, 'review added successfully', 201);
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 400);
        }
    }
}
