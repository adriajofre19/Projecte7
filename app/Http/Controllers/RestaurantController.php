<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;


use Inertia\Inertia;

class RestaurantController extends Controller
{
    public function index($id){
        $restaurant = Restaurant::with('user', 'reviews.user')->find($id);
        return Inertia::render('Restaurant', [
            'restaurant' => $restaurant,
        ]);
    }

    public function addReview(Request $request){

        $request->validate([
            'rating' => 'required',
            'content' => 'required',
            'restaurant_id' => 'required',
        ]);

        $review = new Review();
        $review->rating = $request->rating;
        $review->content = $request->content;
        $review->restaurant_id = $request->restaurant_id;
        $review->user_id = auth()->user()->id;
        $review->save();

        return redirect()->back();
    }

    public function edit($id){
        $restaurant = Restaurant::find($id);
        return Inertia::render('EditRestaurant', [
            'restaurant' => $restaurant,
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $restaurant = Restaurant::find($id);
        $restaurant->name = $request->name;
        $restaurant->description = $request->description;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;

        $restaurant->save();

        return redirect()->route('restaurant.index', ['id' => $id]);
    }

    public function destroy($id){
        $restaurant = Restaurant::find($id);
        $restaurant->delete();

        return redirect()->route('home');
    }
}
