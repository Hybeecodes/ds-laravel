<?php

namespace App\Http\Controllers;

use App\Events\Auth\UserActivationEmail;
use App\Exceptions\EntityNotCreatedException;
use App\Exceptions\ValidationFailedException;
use App\Mail\ConfirmAccount;
use App\Validators\AuthAccountCreationValidator;
use App\Validators\AuthAccountLoginValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Avatar;
use Illuminate\Support\Facades\Mail;
use Storage;
use App\Notifications\SignupActivate;

class AuthController extends Controller
{
    // create user
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request){
        try{
            AuthAccountCreationValidator::run($request->post());
            $postData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'activation_token' => str_random(60)
            ];
            $user = User::newUser($postData);
            $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
            Storage::put('avatars/'.$user->id.'avatar.png', (string)$avatar);
            // event
            event(new UserActivationEmail($user));
            return response()->json([
                'message' => 'Successfully created user'
            ], 201);
        }catch(ValidationFailedException $exception){
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }catch (EntityNotCreatedException $exception){
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    // login user and create token

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        try{
            // validate request data
            AuthAccountLoginValidator::run($request->post());
            $credentials = request(['email', 'password']);
            $credentials['active'] = 1;
            $credentials['deleted_at'] = null;

            if(!Auth::attempt($credentials)){
                return response()->json(['message'=> 'Unauthorized'], 401);
            }
            $user = $request->user();
            $tokenResult = $user->createToken('nhbbGRBUSvTEe1ylaxCf4lgyE2ntpt48vY5NBWN5');
            $token = $tokenResult->token;

            // extend token expiry if remember me is checked
            if($request->remember_me){
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]);
        }catch(ValidationFailedException $exception){
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

    }
    //logout user (Revoke token)
    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    // get authenticated user
    public function user(Request $request){
        return response()->json($request->user());
    }

    public function signupActivate($token)
{
    $user = User::where('activation_token', $token)->first();
    if (!$user) {
        return response()->json([
            'message' => 'This activation token is invalid.'
        ], 404);
    }
    $user->active = true;
    $user->email_verified_at = Carbon::now();
    $user->activation_token = '';
    $user->save();
    return $user;
}
}
