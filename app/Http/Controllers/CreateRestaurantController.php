<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Restaurant;

use Inertia\Inertia;

class CreateRestaurantController extends Controller
{
    public function create()
    {
        return Inertia::render('CreateRestaurant');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
        ]);

        Restaurant::create([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return redirect('/dashboard');
    }
}
