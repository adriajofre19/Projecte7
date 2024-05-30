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

}
