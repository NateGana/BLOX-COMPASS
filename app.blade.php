<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'BLOX COMPASS')</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { theme: { extend: { colors: {
  navy: '#081B2B', ocean: '#0C2C43', deep: '#123B55', sea: '#1678B8',
  cyan2: '#38CBE0', teal2: '#49C9B0', gold: '#E9B95D', coral: '#E47A63', muted: '#A8BAC6'
} } } }
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body class="bg-navy text-slate-100 min-h-screen" x-data="{ open: false }">
<header class="fixed top-0 inset-x-0 h-16 z-40 bg-ocean/95 backdrop-blur border-b border-deep flex items-center justify-between px-4">
  <div class="flex items-center gap-3">
    <button class="lg:hidden" @click="open = !open" aria-label="Menu"><i data-lucide="menu"></i></button>
    <a href="{{ route('home') }}" class="flex items-center gap-2">
      <span class="w-9 h-9 rounded-full bg-gradient-to-br from-cyan2 to-sea flex items-center justify-center"><i data-lucide="compass" class="w-5 h-5 text-navy"></i></span>
      <span><span class="block font-extrabold tracking-wider leading-none">BLOX COMPASS</span><span class="block text-[10px] text-muted tracking-widest">BLOX FRUITS COMPANION</span></span>
    </a>
  </div>
  <form action="{{ route('fruits.index') }}" class="hidden md:block">
    <input name="q" value="{{ request('q') }}" placeholder="Search fruits..." class="bg-navy border border-deep rounded-lg px-3 py-1.5 text-sm w-64 focus:outline-none focus:border-cyan2">
  </form>
  <div class="flex items-center gap-2 text-sm">
    @auth
      <span class="text-muted">{{ auth()->user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}">@csrf<button class="px-3 py-1.5 rounded-lg border border-deep hover:border-coral">Logout</button></form>
    @else
      <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg border border-deep hover:border-cyan2">Sign In</a>
      <a href="{{ route('register') }}" class="px-3 py-1.5 rounded-lg bg-gold text-navy font-semibold">Create Account</a>
    @endauth
  </div>
</header>

<aside class="fixed top-16 bottom-0 left-0 w-60 bg-ocean border-r border-deep z-30 p-3 space-y-1 transition-transform lg:translate-x-0" :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
  @php
    $links = [
      ['home', 'Home', 'home', 'home'],
      ['fruits.index', 'Fruit Database', 'apple', 'fruits.*'],
      ['trading.index', 'Trading Hub', 'repeat', 'trading.*'],
      ['calculator', 'W/F/L Calculator', 'scale', 'calculator'],
      ['wfl.index', 'W/F/L Community', 'vote', 'wfl.*'],
    ];
  @endphp
  @foreach ($links as [$route, $label, $icon, $match])
    <a href="{{ route($route) }}" title="{{ $label }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:translate-x-1 hover:bg-deep {{ request()->routeIs($match) ? 'bg-deep text-cyan2' : 'text-muted' }}">
      <i data-lucide="{{ $icon }}" class="w-5 h-5"></i><span>{{ $label }}</span>
    </a>
  @endforeach
</aside>

<main class="pt-20 px-4 pb-12 lg:pl-64 lg:pr-6">
  @if (session('status'))<div class="mb-4 p-3 rounded-lg bg-teal2/20 border border-teal2 text-teal2">{{ session('status') }}</div>@endif
  @if ($errors->any())<div class="mb-4 p-3 rounded-lg bg-coral/20 border border-coral text-coral">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
  @yield('content')
  <p class="mt-12 text-xs text-muted">Independent fan-made platform. Not affiliated with Roblox or the Blox Fruits developers.</p>
</main>
<script>lucide.createIcons();</script>
@stack('scripts')
</body>
</html>
