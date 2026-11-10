<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradingPost extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
