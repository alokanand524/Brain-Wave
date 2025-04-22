<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveSession;
use Illuminate\Support\Facades\Auth;

class LiveSessionController extends Controller
{
    public function start()
    {
        $user = Auth::user();

        $session = LiveSession::updateOrCreate(
            ['user_id' => $user->id],
            [
                'is_live' => true,
                'joined_at' => now(),
                'left_at' => null, // clear previous end if any
            ]
        );

        return response()->json(['status' => 'live_started', 'session_id' => $session->id]);
    }
    public function end()
    {
        $user = Auth::user();

        $session = LiveSession::where('user_id', $user->id)->first();
        if ($session) {
            $session->is_live = false;
            $session->left_at = now();
            $session->save();
        }

        return response()->json(['status' => 'live_ended']);
    }
}
