<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // public function register(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email',
    //         'password' => 'required|min:2|confirmed',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation Error',
    //             'errors' => $validator->errors()
    //         ], 400);
    //     }

    //     $user = new User();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = Hash::make($request->password);
    //     $user->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Register Success 🎉',
    //         'user' => $user,
    //     ]);
    // }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:2|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Store data in cache
        $token = Str::random(64);
        $cachedData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        cache::put('pending_register_' . $token, $cachedData, now()->addMinutes(15));

        // Generate link
        $link = route('magic.register.verify', $token);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->magic_login_token = $token;
        $user->magic_login_expires_at = now()->addMinutes(15);
        $user->save();

        // Send email
        Mail::html("<p>Click the link to complete your registration: <a href='$link'>$link</a></p>", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Complete Your BrainWave Registration');
        });

        return redirect('/studyRoom');
    }

    public function verifyMagicRegister($token)
    {
        $data = Cache::get('pending_register_' . $token);

        if (!$data) {
            return redirect('/')->with('error', 'Invalid or expired registration link.');
        }


        $user = User::where('magic_login_token', $token)->first();

        // dd($user);
        if (!$user) {
            return redirect('/')->with('error', 'User not found or token invalid.');
        }


        $user->is_email_verified = 1;
        $user->email_verified_at = now();
        $user->magic_login_token = null;
        $user->magic_login_expires_at = null;
        $user->save();

        Cache::forget('pending_register_' . $token);

        Auth::login($user);

        // return redirect('/studyRoom')->with('status', 'Registration successful! You are now logged in 🎉');
        return redirect()->route('studyRoom');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid credentials!.',
            ]);
        }

        if (!$user->is_email_verified) {
            return back()->withErrors([
                'email' => 'Your registration is not completed. Please verify your email first.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('studyRoom');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }


    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //         // 'profile_image' => $googleUser->getAvatar(),
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         return redirect()->route('studyRoom');
    //     }

    //     return back()->withErrors([
    //         'email' => 'Invalid credentials.',
    //     ]);
    // }


    // app/Http/Controllers/ProfileController.php
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only('name', 'mobile', 'date_of_birth', 'gender'));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updateImage(Request $request)
    {
        if ($request->hasFile('profile_image')) {
            $filename = time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('uploads'), $filename);

            $user = Auth::user();
            $user->profile_image = '/uploads/' . $filename;
            $user->save();
        }

        return back()->with('success', 'Profile image updated!');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // public function logReg()
    // {
    //     return view('loginRegister');
    // }

}
