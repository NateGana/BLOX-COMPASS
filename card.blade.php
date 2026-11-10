@php
  $colors = ['Common' => 'text-slate-300', 'Uncommon' => 'text-teal2', 'Rare' => 'text-cyan2', 'Legendary' => 'text-gold', 'Mythical' => 'text-coral'];
@endphp
<a href="{{ route('fruits.show', $fruit) }}" class="block bg-ocean border border-deep rounded-xl p-4 hover:border-cyan2 hover:-translate-y-1 transition shadow-lg">
  <div class="h-20 rounded-lg bg-gradient-to-br from-deep to-navy flex items-center justify-center mb-3"><i data-lucide="apple" class="w-10 h-10 text-cyan2"></i></div>
  <div class="font-bold">{{ $fruit->name }}</div>
  <div class="text-xs {{ $colors[$fruit->rarity] ?? 'text-muted' }}">{{ $fruit->rarity }} · {{ $fruit->type }}</div>
  <div class="mt-2 text-sm">Value: <span class="text-gold font-semibold">{{ number_format($fruit->value) }}</span></div>
  <div class="text-xs text-muted">Demand: {{ $fruit->demand }}</div>
  @if ($fruit->data_status === 'demo')<span class="inline-block mt-2 text-[10px] px-2 py-0.5 rounded bg-coral/20 text-coral">DEMO DATA</span>@endif
</a>
