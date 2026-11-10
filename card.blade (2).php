<div class="bg-ocean border border-deep rounded-xl p-4">
  <div class="flex justify-between text-xs text-muted"><span>{{ $post->user->name }}</span><span>{{ $post->created_at->diffForHumans() }}</span></div>
  <div class="font-bold mt-1">{{ $post->title }} <span class="text-[10px] ml-1 px-2 py-0.5 rounded bg-sea/30 text-cyan2">{{ $post->post_type }}</span></div>
  <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
    <div><div class="text-xs text-muted">Offering</div>{{ $post->offered }}</div>
    <div><div class="text-xs text-muted">Wanted</div>{{ $post->wanted }}</div>
  </div>
  @if ($post->description)<p class="text-sm text-slate-300 mt-2">{{ $post->description }}</p>@endif
  @auth
    @if ($post->user_id === auth()->id())
      <div class="flex gap-2 mt-3">
        <form method="POST" action="{{ route('trading.close', $post) }}">@csrf @method('PATCH')<button class="text-xs px-3 py-1 rounded border border-deep hover:border-gold">Close</button></form>
        <form method="POST" action="{{ route('trading.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">@csrf @method('DELETE')<button class="text-xs px-3 py-1 rounded border border-deep hover:border-coral">Delete</button></form>
      </div>
    @endif
  @endauth
</div>
