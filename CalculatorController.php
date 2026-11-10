<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Services\TradeCalculator;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('wfl.calculator', ['fruits' => Fruit::orderBy('name')->get(['id', 'name', 'value'])]);
    }

    public function evaluate(Request $request, TradeCalculator $calc)
    {
        $data = $request->validate([
            'offer' => 'array',
            'offer.*.id' => 'integer|exists:fruits,id',
            'offer.*.qty' => 'integer|min:1|max:99',
            'receive' => 'array',
            'receive.*.id' => 'integer|exists:fruits,id',
            'receive.*.qty' => 'integer|min:1|max:99',
        ]);
        return response()->json($calc->evaluate($data['offer'] ?? [], $data['receive'] ?? []));
    }
}
