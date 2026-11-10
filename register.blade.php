@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('register') }}" class="max-w-md mx-auto bg-ocean border border-deep rounded-xl p-6 space-y-4">
  @csrf
  <h1 class="text-2xl font-bold">Create Account</h1>
  <input name="name" value="{{ old('name') }}" placeholder="Username" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <input name="email" type="email" value="{{ old('email') }}" placeholder="Email" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <input name="password" type="password" placeholder="Password (min 8)" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <input name="password_confirmation" type="password" placeholder="Confirm password" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
  <p class="text-xs text-muted">Never share your Roblox password or cookies with anyone.</p>
  <button class="w-full py-2 rounded-lg bg-gold text-navy font-bold">Create Account</button>
</form>
@endsection
