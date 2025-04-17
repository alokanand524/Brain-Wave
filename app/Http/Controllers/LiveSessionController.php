<?php

use App\Models\LiveSession;
use Illuminate\Support\Facades\Auth;

class LiveSessionController extends Controller
{
    public function join(Request $request)
    {
        $user = Auth::user();

        LiveSession::updateOrCreate(
            ['user_id' => $user->id],
            ['is_live' => true, 'joined_at' => now(), 'left_at' => null]
        );

        return response()->json(['status' => 'live']);
    }

    public function leave(Request $request)
    {
        $user = Auth::user();

        LiveSession::where('user_id', $user->id)
            ->update([
                'is_live' => false,
                'left_at' => now()
            ]);

        return response()->json(['status' => 'left']);
    }
}
