@extends('layouts.app')
@section('title', 'W/F/L Calculator')
@section('content')
<h1 class="text-2xl font-bold mb-4">W/F/L Trade Calculator</h1>
<div x-data="calc(@js($fruits))" class="space-y-4">
  <div class="grid md:grid-cols-2 gap-4">
    @foreach (['offer' => 'YOU OFFER', 'receive' => 'YOU RECEIVE'] as $side => $label)
    <div class="bg-ocean border border-deep rounded-xl p-4">
      <h2 class="font-bold text-gold mb-2">{{ $label }}</h2>
      <select @change="add('{{ $side }}', $event.target.value); $event.target.value = ''" class="w-full bg-navy border border-deep rounded-lg px-3 py-2 mb-3">
        <option value="">Add fruit...</option>
        <template x-for="f in fruits" :key="f.id"><option :value="f.id" x-text="f.name + ' (' + f.value + ')'"></option></template>
      </select>
      <template x-for="(it, i) in {{ $side }}" :key="i">
        <div class="flex items-center justify-between py-1 text-sm">
          <span x-text="name(it.id)"></span>
          <span class="flex items-center gap-2">
            <input type="number" min="1" max="99" x-model.number="it.qty" @input="run()" class="w-14 bg-navy border border-deep rounded px-2 py-0.5">
            <button @click="{{ $side }}.splice(i, 1); run()" class="text-coral">✕</button>
          </span>
        </div>
      </template>
    </div>
    @endforeach
  </div>
  <div class="bg-ocean border border-deep rounded-xl p-6 text-center" x-show="res">
    <div class="text-5xl font-black" :class="{'text-teal2': res?.result === 'WIN', 'text-gold': res?.result === 'FAIR', 'text-coral': res?.result === 'LOSE'}" x-text="res?.result"></div>
    <div class="mt-2 text-sm text-muted">Offer <span x-text="res?.offer_total"></span> · Receive <span x-text="res?.receive_total"></span> · Difference <span x-text="res?.difference"></span> (<span x-text="res?.percent"></span>%)</div>
    <div class="mt-2 text-xs text-muted">Method: difference ÷ offer value. WIN above +<span x-text="res?.threshold"></span>%, LOSE below -<span x-text="res?.threshold"></span>%, otherwise FAIR.</div>
  </div>
  <p class="text-xs text-muted">Trade evaluations are estimates based on stored community data. Actual trading demand, market conditions, and player preferences may differ.</p>
</div>
@endsection
@push('scripts')
<script>
function calc(fruits) {
  return {
    fruits, offer: [], receive: [], res: null,
    name(id) { return this.fruits.find(f => f.id == id)?.name },
    add(side, id) { if (!id) return; this[side].push({ id: +id, qty: 1 }); this.run(); },
    async run() {
      if (!this.offer.length && !this.receive.length) { this.res = null; return; }
      const r = await fetch('{{ route('calculator.evaluate') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
        body: JSON.stringify({ offer: this.offer, receive: this.receive })
      });
      this.res = await r.json();
    }
  };
}
</script>
@endpush
