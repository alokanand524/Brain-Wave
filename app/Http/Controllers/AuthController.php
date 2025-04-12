<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:2|confirmed',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Register Success 🎉',
            'user' => $user,
        ]);
    }
    


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            // 'profile_image' => $googleUser->getAvatar(),
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('studyRoom');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return response()->json([
    //             'status' => 'success',
    //             'user' => Auth::user()
    //         ]);
    //     }

    //     return response()->json(['status' => 'error', 'message' => 'Invalid credentials.']);
    // }




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

