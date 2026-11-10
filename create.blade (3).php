@extends('layouts.app')
@section('title', 'New W/F/L Post')
@section('content')
<form method="POST" action="{{ route('wfl.store') }}" class="max-w-2xl bg-ocean border border-deep rounded-xl p-6 space-y-4">
  @csrf
  <h1 class="text-2xl font-bold">New W/F/L Post</h1>
  <input name="title" value="{{ old('title') }}" placeholder="Title" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <div class="grid md:grid-cols-2 gap-4">
    <label class="text-sm">You offer<select name="offer[]" multiple size="8" required class="w-full mt-1 bg-navy border border-deep rounded-lg px-3 py-2">@foreach ($fruits as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach</select></label>
    <label class="text-sm">You receive<select name="receive[]" multiple size="8" required class="w-full mt-1 bg-navy border border-deep rounded-lg px-3 py-2">@foreach ($fruits as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach</select></label>
  </div>
  <p class="text-xs text-muted">Hold Ctrl (or Cmd) to select multiple fruits.</p>
  <button class="px-4 py-2 rounded-lg bg-gold text-navy font-semibold">Publish</button>
</form>
@endsection
