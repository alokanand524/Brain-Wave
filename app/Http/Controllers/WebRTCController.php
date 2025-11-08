<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveSession;
use Illuminate\Support\Facades\Auth;

class WebRTCController extends Controller
{
    public function startSession(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        LiveSession::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'is_live' => true,
                'joined_at' => now(),
                'left_at' => null
            ]
        );

        return response()->json(['status' => 'success', 'message' => 'Live session started']);
    }

    public function endSession(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        LiveSession::where('user_id', Auth::id())
            ->update([
                'is_live' => false,
                'left_at' => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Live session ended']);
    }

    public function getLiveSessions()
    {
        $sessions = LiveSession::with('user')
            ->where('is_live', true)
            ->get();

        return response()->json($sessions);
    }
}