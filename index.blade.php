@extends('layouts.app')
@section('title', 'Fruit Database')
@section('content')
<h1 class="text-2xl font-bold mb-4">Fruit Database</h1>
<form class="flex flex-wrap gap-2 mb-5">
  <input name="q" value="{{ request('q') }}" placeholder="Fruit name" class="bg-ocean border border-deep rounded-lg px-3 py-2">
  <select name="rarity" class="bg-ocean border border-deep rounded-lg px-3 py-2"><option value="">All rarities</option>@foreach ($rarities as $r)<option @selected(request('rarity') === $r)>{{ $r }}</option>@endforeach</select>
  <select name="type" class="bg-ocean border border-deep rounded-lg px-3 py-2"><option value="">All types</option>@foreach ($types as $t)<option @selected(request('type') === $t)>{{ $t }}</option>@endforeach</select>
  <select name="sort" class="bg-ocean border border-deep rounded-lg px-3 py-2">
    <option value="name" @selected(request('sort') === 'name')>Name</option>
    <option value="high" @selected(request('sort') === 'high')>Highest value</option>
    <option value="low" @selected(request('sort') === 'low')>Lowest value</option>
    <option value="new" @selected(request('sort') === 'new')>Recently updated</option>
  </select>
  <button class="px-4 py-2 rounded-lg bg-gold text-navy font-semibold">Filter</button>
</form>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
  @forelse ($fruits as $f) @include('fruits.card', ['fruit' => $f]) @empty <p class="text-muted col-span-full">No fruits found.</p> @endforelse
</div>
@endsection
