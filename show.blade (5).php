@extends('layouts.app')
@section('title', $post->title)
@section('content')
<h1 class="text-2xl font-bold">{{ $post->title }}</h1>
<p class="text-xs text-muted mb-4">by {{ $post->user->name }} · {{ $post->created_at->toFormattedDateString() }}</p>
<div class="grid md:grid-cols-2 gap-4">
  @foreach (['offer' => 'YOU OFFER', 'receive' => 'YOU RECEIVE'] as $side => $label)
  <div class="bg-ocean border border-deep rounded-xl p-4">
    <h2 class="font-bold text-gold mb-2">{{ $label }}</h2>
    @foreach ($post->$side as $it)<div class="text-sm">{{ $names[$it['id']] ?? 'Removed fruit' }} × {{ $it['qty'] }}</div>@endforeach
    <div class="mt-2 text-xs text-muted">Total: {{ number_format($side === 'offer' ? $post->offer_total : $post->receive_total) }}</div>
  </div>
  @endforeach
</div>
<div class="bg-ocean border border-deep rounded-xl p-6 mt-4 space-y-3">
  <h2 class="font-bold">Community Vote</h2>
  @foreach ($tally as $v => $t)
    <div><div class="flex justify-between text-sm"><span>{{ $v }}</span><span>{{ $t['count'] }} · {{ $t['pct'] }}%</span></div>
    <div class="h-2 rounded bg-navy"><div class="h-2 rounded {{ $v === 'WIN' ? 'bg-teal2' : ($v === 'FAIR' ? 'bg-gold' : 'bg-coral') }}" style="width: {{ $t['pct'] }}%"></div></div></div>
  @endforeach
  @auth
    @if ($myVote)<p class="text-sm text-muted">You voted {{ $myVote }}.</p>
    @else
      <form method="POST" action="{{ route('wfl.vote', $post) }}" class="flex gap-2">@csrf
        @foreach (['WIN', 'FAIR', 'LOSE'] as $v)<button name="vote" value="{{ $v }}" class="px-4 py-2 rounded-lg border border-deep hover:border-cyan2">{{ $v }}</button>@endforeach
      </form>
    @endif
  @else
    <p class="text-sm text-muted"><a class="text-cyan2" href="{{ route('login') }}">Sign in</a> to vote.</p>
  @endauth
</div>
@endsection
