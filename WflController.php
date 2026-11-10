<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Models\WflPost;
use App\Services\TradeCalculator;
use Illuminate\Http\Request;

class WflController extends Controller
{
    public function index()
    {
        return view('wfl.index', ['posts' => WflPost::with('user')->withCount('votes')->latest()->get()]);
    }

    public function create()
    {
        return view('wfl.create', ['fruits' => Fruit::orderBy('name')->get()]);
    }

    public function store(Request $request, TradeCalculator $calc)
    {
        $data = $request->validate([
            'title' => 'required|max:100',
            'offer' => 'required|array|min:1',
            'offer.*' => 'integer|exists:fruits,id',
            'receive' => 'required|array|min:1',
            'receive.*' => 'integer|exists:fruits,id',
        ]);
        $offer = array_map(fn ($id) => ['id' => (int) $id, 'qty' => 1], $data['offer']);
        $receive = array_map(fn ($id) => ['id' => (int) $id, 'qty' => 1], $data['receive']);
        $post = WflPost::create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
            'offer' => $offer,
            'receive' => $receive,
            'offer_total' => $calc->total($offer),
            'receive_total' => $calc->total($receive),
        ]);
        return redirect()->route('wfl.show', $post);
    }

    public function show(WflPost $post)
    {
        $names = Fruit::pluck('name', 'id');
        return view('wfl.show', [
            'post' => $post->load('user'),
            'tally' => $post->tally(),
            'names' => $names,
            'myVote' => auth()->check() ? $post->votes()->where('user_id', auth()->id())->value('vote') : null,
        ]);
    }

    public function vote(Request $request, WflPost $post)
    {
        $data = $request->validate(['vote' => 'required|in:WIN,FAIR,LOSE']);
        $vote = $post->votes()->firstOrCreate(['user_id' => $request->user()->id], ['vote' => $data['vote']]);
        if (!$vote->wasRecentlyCreated) {
            return back()->withErrors(['vote' => 'You have already voted on this post.']);
        }
        return back()->with('status', 'Vote recorded.');
    }
}
