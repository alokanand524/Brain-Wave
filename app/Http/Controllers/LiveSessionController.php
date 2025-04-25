<?php

namespace App\Http\Controllers;

use App\Events\LiveSessionUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LiveSession;

class LiveSessionController extends Controller
{
    public function start()
    {
        $session = LiveSession::updateOrCreate(
            ['user_id' => Auth::id()],
            ['is_live' => true, 'joined_at' => now()]
        );

        broadcast(new LiveSessionUpdated($session))->toOthers();

        return response()->json(['status' => 'live', 'user' => Auth::user()]);
    }

    public function end()
    {
        $session = LiveSession::where('user_id', Auth::id())->first();
        if ($session) {
            $session->update([
                'is_live' => false,
                'left_at' => now()
            ]);

            broadcast(new LiveSessionUpdated($session))->toOthers();
        }

        return response()->json(['status' => 'offline']);
    }
}
