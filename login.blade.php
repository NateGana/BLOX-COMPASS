@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto bg-ocean border border-deep rounded-xl p-6 space-y-4">
  @csrf
  <h1 class="text-2xl font-bold">Sign In</h1>
  <input name="email" type="email" value="{{ old('email') }}" placeholder="Email" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <input name="password" type="password" placeholder="Password" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <label class="flex items-center gap-2 text-sm text-muted"><input type="checkbox" name="remember"> Remember me</label>
  <button class="w-full py-2 rounded-lg bg-gold text-navy font-bold">Sign In</button>
</form>
@endsection
