@extends('layouts.app')
@section('title', $fruit->name)
@section('content')
<div class="grid md:grid-cols-3 gap-6">
  <div class="md:col-span-1 bg-ocean border border-deep rounded-xl p-6">
    <div class="h-40 rounded-lg bg-gradient-to-br from-deep to-navy flex items-center justify-center"><i data-lucide="apple" class="w-16 h-16 text-cyan2"></i></div>
    <h1 class="text-2xl font-black mt-4">{{ $fruit->name }}</h1>
    <p class="text-muted text-sm">{{ $fruit->rarity }} · {{ $fruit->type }}</p>
    <dl class="mt-4 text-sm space-y-1">
      <div class="flex justify-between"><dt>Estimated value</dt><dd class="text-gold font-semibold">{{ number_format($fruit->value) }}</dd></div>
      <div class="flex justify-between"><dt>Demand</dt><dd>{{ $fruit->demand }}</dd></div>
      <div class="flex justify-between"><dt>Beli price</dt><dd>{{ $fruit->beli_price ? number_format($fruit->beli_price) : 'Not recorded' }}</dd></div>
      <div class="flex justify-between"><dt>Robux price</dt><dd>{{ $fruit->robux_price ? number_format($fruit->robux_price) : 'Not recorded' }}</dd></div>
      <div class="flex justify-between"><dt>Source</dt><dd>{{ $fruit->source ?? 'None' }}</dd></div>
      <div class="flex justify-between"><dt>Last updated</dt><dd>{{ $fruit->updated_at->toFormattedDateString() }}</dd></div>
    </dl>
    @if ($fruit->data_status === 'demo')<span class="inline-block mt-3 text-xs px-2 py-1 rounded bg-coral/20 text-coral">DEMO DATA</span>@endif
  </div>
  <div class="md:col-span-2 space-y-6">
    <div class="bg-ocean border border-deep rounded-xl p-6"><h2 class="font-bold mb-2">Description</h2><p class="text-slate-300">{{ $fruit->description ?? 'No description yet.' }}</p></div>
    <div class="bg-ocean border border-deep rounded-xl p-6">
      <h2 class="font-bold mb-3">Value History</h2>
      @if ($fruit->history->count())
        <div class="flex gap-2 mb-3 text-xs">
          @foreach ([7 => '7D', 30 => '30D', 90 => '90D', 180 => '6M', 365 => '1Y', 0 => 'All'] as $days => $label)
            <button data-days="{{ $days }}" class="range px-2 py-1 rounded border border-deep hover:border-cyan2">{{ $label }}</button>
          @endforeach
        </div>
        <canvas id="chart" height="110"></canvas>
      @else
        <p class="text-muted">No recorded history for this fruit.</p>
      @endif
    </div>
    @auth
    <form method="POST" action="{{ route('fruits.suggest', $fruit) }}" class="bg-ocean border border-deep rounded-xl p-6 space-y-3">
      @csrf
      <h2 class="font-bold">Suggest a Value</h2>
      <input type="number" min="0" name="suggested_value" placeholder="Suggested value" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2">
      <select name="demand" class="w-full bg-navy border border-deep rounded-lg px-3 py-2"><option>Low</option><option>Medium</option><option>High</option></select>
      <textarea name="explanation" rows="3" placeholder="Explanation" required class="w-full bg-navy border border-deep rounded-lg px-3 py-2"></textarea>
      <p class="text-xs text-muted">Suggestions are reviewed by administrators and are not published automatically.</p>
      <button class="px-4 py-2 rounded-lg bg-gold text-navy font-semibold">Submit</button>
    </form>
    @else
      <p class="text-muted text-sm"><a class="text-cyan2" href="{{ route('login') }}">Sign in</a> to suggest a value.</p>
    @endauth
  </div>
</div>
@endsection
@push('scripts')
@if ($fruit->history->count())
<script>
const all = @json($fruit->history->map(fn ($h) => ['d' => $h->recorded_at->toDateString(), 'v' => $h->value]));
const chart = new Chart(document.getElementById('chart'), { type: 'line', data: { labels: [], datasets: [{ label: 'Value', data: [], borderColor: '#38CBE0', backgroundColor: 'rgba(56,203,224,.15)', fill: true, tension: .3 }] }, options: { plugins: { legend: { display: false } }, scales: { x: { ticks: { color: '#A8BAC6' } }, y: { ticks: { color: '#A8BAC6' } } } } });
function draw(days) {
  const cut = days ? Date.now() - days * 86400000 : 0;
  const rows = all.filter(r => new Date(r.d).getTime() >= cut);
  chart.data.labels = rows.map(r => r.d);
  chart.data.datasets[0].data = rows.map(r => r.v);
  chart.update();
}
document.querySelectorAll('.range').forEach(b => b.addEventListener('click', () => draw(+b.dataset.days)));
draw(0);
</script>
@endif
@endpush
