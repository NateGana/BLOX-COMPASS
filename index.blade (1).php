@extends('layouts.app')
@section('title', 'Trading Hub')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-bold">Trading Hub</h1>
  <a href="{{ auth()->check() ? route('trading.create') : route('login') }}" class="px-4 py-2 rounded-lg bg-gold text-navy font-semibold">Create Post</a>
</div>
<form class="flex flex-wrap gap-2 mb-5">
  <input name="q" value="{{ request('q') }}" placeholder="Search fruit" class="bg-ocean border border-deep rounded-lg px-3 py-2">
  <select name="type" class="bg-ocean border border-deep rounded-lg px-3 py-2"><option value="">All types</option>@foreach ($types as $t)<option @selected(request('type') === $t)>{{ $t }}</option>@endforeach</select>
  <button class="px-4 py-2 rounded-lg border border-cyan2 text-cyan2">Filter</button>
</form>
<div class="grid md:grid-cols-2 gap-4">
  @forelse ($posts as $p) @include('trading.card', ['post' => $p]) @empty <p class="text-muted">No open posts.</p> @endforelse
</div>
@endsection
