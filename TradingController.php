<?php

namespace App\Http\Controllers;

use App\Models\TradingPost;
use Illuminate\Http\Request;

class TradingController extends Controller
{
    public const TYPES = ['Trading', 'Offering', 'Looking For', 'Upgrade', 'Downgrade', 'Multiple Fruit Trade'];

    public function index(Request $request)
    {
        $query = TradingPost::with('user')->where('status', 'open');
        if ($request->filled('type')) {
            $query->where('post_type', $request->type);
        }
        if ($request->filled('q')) {
            $query->where(fn ($q) => $q->where('offered', 'like', '%' . $request->q . '%')->orWhere('wanted', 'like', '%' . $request->q . '%'));
        }
        return view('trading.index', ['posts' => $query->latest()->get(), 'types' => self::TYPES]);
    }

    public function create()
    {
        return view('trading.create', ['types' => self::TYPES]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:100',
            'post_type' => 'required|in:' . implode(',', self::TYPES),
            'offered' => 'required|max:255',
            'wanted' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ]);
        TradingPost::create($data + ['user_id' => $request->user()->id]);
        return redirect()->route('trading.index')->with('status', 'Trading post published.');
    }

    public function close(Request $request, TradingPost $post)
    {
        abort_unless($post->user_id === $request->user()->id, 403);
        $post->update(['status' => 'closed']);
        return back()->with('status', 'Post closed.');
    }

    public function destroy(Request $request, TradingPost $post)
    {
        abort_unless($post->user_id === $request->user()->id, 403);
        $post->delete();
        return back()->with('status', 'Post deleted.');
    }
}
