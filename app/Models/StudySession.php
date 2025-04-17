<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySession extends Model {
    protected $fillable = ['user_id', 'room_name', 'joined_at', 'left_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
