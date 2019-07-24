<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;

class PasswordResetController extends Controller
{
    // create token password reset
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);
        $user =  User::where('email', $request->email)->first();
        if(!$user){
            return response()->json([
                'message' => 'We cannot find a user with that e-mail address'
            ], 404);
        }
        $passportReset = PasswordReset::updateOrCreate(
            ['email' => $user->email ],
            [
                'email' => $user->email,
                'token' => str_random(60)
            ]);
        if($user && $passportReset){
            $user->notify(
                new PasswordResetRequest($passportReset->token)
            );
        }
        return response()->json([
            'message' => 'We have e-mailed your password reset link'
        ]);
    }

    // Find token password reset
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if(!$passwordReset)
            return \response()->json([
                'message' => 'This password reset token invalid'
            ], 404);
        if(Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()){
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid'
            ], 404);
        }
        return response()->json($passwordReset);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.'
            ], 404);
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json($user);
    }
}
