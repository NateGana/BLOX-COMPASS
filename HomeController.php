<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Models\TradingPost;
use App\Models\User;
use App\Models\WflPost;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'stats' => [
                'Registered Players' => User::count(),
                'Fruits in Database' => Fruit::count(),
                'Active Trading Posts' => TradingPost::where('status', 'open')->count(),
                'W/F/L Posts' => WflPost::count(),
            ],
            'featured' => Fruit::orderByDesc('value')->take(4)->get(),
            'posts' => TradingPost::with('user')->latest()->take(4)->get(),
        ]);
    }
}
