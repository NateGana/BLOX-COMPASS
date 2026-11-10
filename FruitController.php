<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use Illuminate\Http\Request;

class FruitController extends Controller
{
    public function index(Request $request)
    {
        $query = Fruit::query();
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $sort = $request->get('sort', 'name');
        match ($sort) {
            'high' => $query->orderByDesc('value'),
            'low' => $query->orderBy('value'),
            'new' => $query->orderByDesc('updated_at'),
            default => $query->orderBy('name'),
        };
        return view('fruits.index', [
            'fruits' => $query->get(),
            'rarities' => Fruit::distinct()->pluck('rarity'),
            'types' => Fruit::distinct()->pluck('type'),
        ]);
    }

    public function show(Fruit $fruit)
    {
        return view('fruits.show', ['fruit' => $fruit->load('history')]);
    }

    public function suggest(Request $request, Fruit $fruit)
    {
        $data = $request->validate([
            'suggested_value' => 'required|integer|min:0',
            'demand' => 'required|in:Low,Medium,High',
            'explanation' => 'required|string|max:1000',
        ]);
        $fruit->suggestions()->create($data + ['user_id' => $request->user()->id]);
        return back()->with('status', 'Suggestion submitted for administrator review.');
    }
}
