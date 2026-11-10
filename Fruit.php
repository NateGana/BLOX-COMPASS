<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fruit extends Model
{
    protected $guarded = [];

    public function history()
    {
        return $this->hasMany(FruitValueHistory::class)->orderBy('recorded_at');
    }

    public function suggestions()
    {
        return $this->hasMany(ValueSuggestion::class);
    }
}
