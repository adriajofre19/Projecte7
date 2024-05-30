<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Restaurant;
use App\Models\User;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function edit($id) {

        $review = Review::find($id);
        return Inertia::render('EditReview', [
            'review' => $review,
        ]);
    }

    public function update(Request $request, $id) {

        $request->validate([
            'rating' => 'required',
            'content' => 'required',
        ]);

        $review = Review::find($id);
        $review->rating = $request->rating;
        $review->content = $request->content;
        $review->save();

        return redirect(route('home'));

    }

    public function destroy($id) {

        $review = Review::find($id);
        $review->delete();

        return redirect()->back();
    }
}
