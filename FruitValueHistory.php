<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FruitValueHistory extends Model
{
    protected $table = 'fruit_value_history';
    protected $guarded = [];
    protected $casts = ['recorded_at' => 'date'];
}
