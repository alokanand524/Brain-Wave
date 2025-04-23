<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveSession;

class LiveSessionController extends Controller
{
    public function start(Request $request)
    {
        $user = auth()->user();

        // Mark the user as live in DB
        $session = LiveSession::updateOrCreate(
            ['user_id' => $user->id],
            [
                'is_live' => true,
                'joined_at' => now(),
                'left_at' => null,
            ]
        );

        return response()->json(['status' => 'started']);
    }

    public function stop()
    {
        $user = auth()->user();

        LiveSession::where('user_id', $user->id)->update([
            'is_live' => false,
            'left_at' => now(),
        ]);

        return response()->json(['message' => 'Live stopped']);
    }
}
