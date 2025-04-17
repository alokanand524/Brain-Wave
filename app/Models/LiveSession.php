<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    protected $fillable = ['user_id', 'is_live', 'joined_at', 'left_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
