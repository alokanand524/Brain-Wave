<?php

namespace App\Http\Controllers;

use App\Events\ReceiveAnswer;
use App\Events\WebRTCSignalEvent;
use Illuminate\Http\Request;
use App\Events\ReceiveWebRTCOffer;

class WebRTCController extends Controller
{
    // public function sendOffer(Request $request)
    // {
    //     broadcast(new ReceiveWebRTCOffer(
    //         $request->to,
    //         $request->from,
    //         $request->offer
    //     ))->toOthers();

    //     return response()->json(['status' => 'sent']);
    // }

    // public function sendAnswer(Request $request)
    // {
    //     broadcast(new ReceiveAnswer(
    //         $request->to,
    //         $request->from,
    //         $request->answer
    //     ))->toOthers();

    //     return response()->json(['status' => 'sent']);
    // }


    // public function signal(Request $request)
    // {
    //     broadcast(new WebRTCSignalEvent($request->all()))->toOthers();
    //     return response()->json(['status' => 'signal sent']);
    // }


    public function signal(Request $request)
    {
        broadcast(new WebRTCSignalEvent(
            auth()->id(),
            $request->to,
            $request->type,
            $request->sdp,
            $request->candidate
        ));
        return response()->json(['success' => true]);
    }

}
