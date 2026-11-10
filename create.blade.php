@extends('layouts.app')
@section('title', 'Create Trading Post')
@section('content')
<form method="POST" action="{{ route('trading.store') }}" class="max-w-xl bg-ocean border border-deep rounded-xl p-6 space-y-3">
  @csrf
  <h1 class="text-2xl font-bold">Create Trading Post</h1>
  <input name="title" value="{{ old('title') }}" placeholder="Post title" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <select name="post_type" class="w-full bg-navy border border-deep rounded-lg px-3 py-2">@foreach ($types as $t)<option>{{ $t }}</option>@endforeach</select>
  <input name="offered" value="{{ old('offered') }}" placeholder="Offering (e.g. Buddha x1)" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <input name="wanted" value="{{ old('wanted') }}" placeholder="Wanted (e.g. Dragon x1)" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <textarea name="description" rows="3" placeholder="Description (optional)" class="w-full bg-navy border border-deep rounded-lg px-3 py-2">{{ old('description') }}</textarea>
  <button class="px-4 py-2 rounded-lg bg-gold text-navy font-semibold">Publish</button>
</form>
@endsection
