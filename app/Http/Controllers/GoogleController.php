<?php

namespace App\Http\Controllers;

use Exception;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user(); // <-- stateless added
    
            // dd($googleUser);
    
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(24)),
                'profile_image' => $googleUser->getAvatar(),
            ]);
    
            Auth::login($user);
    
            return redirect()->route('studyRoom');
    
        } catch(Exception $e) {
            return response($e->getMessage());
        }
    }


  
        // public function send(Request $request)
        // {
        //     $request->validate([
        //         'email' => 'required|email'
        //     ]);

        //     $user = User::where('email', $request->email)->first();

        //     if (!$user) {
        //         // Optionally auto-create user
        //         $user = User::create([
        //             'email' => $request->email,
        //             'name' => 'User_' . Str::random(6), // default name
        //         ]);
        //     }

        //     $token = Str::random(64);
        //     $user->magic_login_token = hash('sha256', $token);
        //     $user->magic_login_expires_at = Carbon::now()->addMinutes(15);
        //     $user->save();

        //     $link = route('magic.login.verify', $token);

        //     // Send Email
        //     Mail::raw("Click the link to login: $link", function ($message) use ($user) {
        //         $message->to($user->email)
        //                 ->subject('Your Magic Login Link');
        //     });

        //     return back()->with('status', 'Login link has been sent to your email.');
        // }


        // public function send(Request $request)
        // {
        //     $request->validate([
        //         'email' => 'required|email'
        //     ]);
        
        //     $user = User::where('email', $request->email)->first();
        
        //     if (!$user) {
        //         $namePart = explode('@', $request->email)[0];
        //         $formattedName = ucwords(preg_replace('/[^a-zA-Z]/', ' ', $namePart));
        
        //         $user = User::create([
        //             'email' => $request->email,
        //             'name' => $formattedName,
        //         ]);
        //     }
        
        //     $token = Str::random(64);
        //     $user->magic_login_token = hash('sha256', $token);
        //     $user->magic_login_expires_at = Carbon::now()->addMinutes(15);
        //     $user->save();
        
        //     $link = route('magic.login.verify', $token);
        
        //     // Mail::raw("Click the link to login: $link", function ($message) use ($user) {
        //     //     $message->to($user->email)
        //     //             ->subject('Your Magic Login Link');
        //     // });

        //     Mail::html("<p>Click the link to login: <a href='$link'>$link</a></p>", function ($message) use ($user) {
        //         $message->to($user->email)
        //                 ->subject('Your Magic Login Link');
        //     });
            
        //     //  mail::to($user->email)     
        //     return back()->with('status', 'Login link has been sent to your email.');
        // }


        // public function verify($token)
        // {
        //     $hashedToken = hash('sha256', $token);

        //     $user = User::where('magic_login_token', $hashedToken)
        //                 ->where('magic_login_expires_at', '>', now())
        //                 ->first();

        //     if (!$user) {
        //         return redirect()->route('magic.login')->withErrors(['token' => 'Invalid or expired token.']);
        //     }

        //     // Optional: Mark email as verified
        //     $user->is_email_verified = true;
        //     $user->email_verified_at = now();
        //     $user->magic_login_token = null;
        //     $user->magic_login_expires_at = null;
        //     $user->save();

        //     Auth::login($user);

        //     return redirect('/dashboard')->with('success', 'Logged in successfully!');
        // }
    

    
}
