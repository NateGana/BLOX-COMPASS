@extends('layouts.app')
@section('title', 'W/F/L Community')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-bold">W/F/L Community</h1>
  <a href="{{ auth()->check() ? route('wfl.create') : route('login') }}" class="px-4 py-2 rounded-lg bg-gold text-navy font-semibold">New W/F/L Post</a>
</div>
<div class="grid md:grid-cols-2 gap-4">
  @forelse ($posts as $p)
    <a href="{{ route('wfl.show', $p) }}" class="block bg-ocean border border-deep rounded-xl p-4 hover:border-cyan2">
      <div class="font-bold">{{ $p->title }}</div>
      <div class="text-xs text-muted">by {{ $p->user->name }} · {{ $p->created_at->diffForHumans() }} · {{ $p->votes_count }} votes</div>
    </a>
  @empty <p class="text-muted">No W/F/L posts yet.</p> @endforelse
</div>
@endsection
