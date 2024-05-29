<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;

use Inertia\Inertia;

class HomeController extends Controller
{
    public function index() {

        // agafar els restaurants amb els usuaris i les reviews i de cada review agafar l'usuari
        $restaurants = Restaurant::with('user', 'reviews.user')->get();

        
        return Inertia::render('Home', [
            'restaurants' => $restaurants,
        ]);
    }

    public function addReview(Request $request, $id) {

        dd($request->all());
        dd($id);    

        dd($request->all());

        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'content' => 'required',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = new Review();
        $review->restaurant_id = $request->restaurant_id;
        $review->user_id = auth()->id();
        $review->content = $request->content;
        $review->rating = $request->rating;
        $review->save();

        return redirect()->back();

        
    }
}
