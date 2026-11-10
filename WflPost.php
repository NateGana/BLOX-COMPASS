<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WflPost extends Model
{
    protected $guarded = [];
    protected $casts = ['offer' => 'array', 'receive' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(WflVote::class);
    }

    public function tally(): array
    {
        $total = $this->votes()->count();
        $out = [];
        foreach (['WIN', 'FAIR', 'LOSE'] as $v) {
            $c = $this->votes()->where('vote', $v)->count();
            $out[$v] = ['count' => $c, 'pct' => $total ? round($c / $total * 100) : 0];
        }
        return $out;
    }
}
