@extends('layouts.app')
@section('content')
<section class="rounded-2xl p-8 md:p-14 bg-gradient-to-br from-sea via-deep to-navy border border-deep">
  <p class="text-gold tracking-widest text-xs font-semibold">EXPLORE. TRADE. BUILD. BECOME THE STRONGEST.</p>
  <h1 class="text-4xl md:text-6xl font-black mt-3">BECOME THE STRONGEST.</h1>
  <p class="mt-3 text-slate-200 max-w-xl">Discover fruits, master your abilities, explore every sea, and become a legendary pirate.</p>
  <div class="mt-6 flex flex-wrap gap-3">
    <a href="{{ route('fruits.index') }}" class="px-5 py-2.5 rounded-lg bg-gold text-navy font-bold">EXPLORE FRUITS</a>
    <a href="{{ route('trading.index') }}" class="px-5 py-2.5 rounded-lg border border-cyan2 text-cyan2 font-bold">EXPLORE TRADING</a>
    <a href="{{ route('calculator') }}" class="px-5 py-2.5 rounded-lg border border-teal2 text-teal2 font-bold">W/F/L CALCULATOR</a>
  </div>
</section>

<section class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
  @foreach ($stats as $label => $n)
    <div class="bg-ocean border border-deep rounded-xl p-4"><div class="text-3xl font-black text-cyan2">{{ $n }}</div><div class="text-xs text-muted mt-1">{{ $label }}</div></div>
  @endforeach
</section>

<h2 class="text-xl font-bold mt-8 mb-3">Featured Fruits</h2>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
  @foreach ($featured as $f) @include('fruits.card', ['fruit' => $f]) @endforeach
</div>

<h2 class="text-xl font-bold mt-8 mb-3">Latest Trading Posts</h2>
<div class="grid md:grid-cols-2 gap-4">
  @forelse ($posts as $p) @include('trading.card', ['post' => $p])
  @empty <p class="text-muted">No trading posts yet.</p> @endforelse
</div>
@endsection
