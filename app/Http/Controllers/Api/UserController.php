<?php

namespace App\Http\Controllers\Api;
use Socialite;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //

    public function createOrGetUser($token)
    {
        try {
            //code...
            $providerUser = Socialite::driver('facebook')->userFromToken($token);
            
            $user = User::where('provider', 'facebook')
                ->where('provider_id', $providerUser->getId())
                ->first();
    
            if ($user) {
                return $user;
            } else {
    
    
                $user = new User([
                    'provider_id' => $providerUser->getId(),
                    'provider' => 'facebook',
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                ]);
    
                $user->save();
    
                return $user;
            }
        } catch (\Exception $th) {
            dd($th->getMessage());
            //throw $th;
        }
    }

    public function login(Request $request){
        $request->validate([
            'token' => 'required',
        ]);
        $user = $this->createOrGetUser($request->token);
        FacadesAuth::login($user,true);
        $message = array('message' => 'Login Successfully');
        $message['user'] = $user;
        $message['token'] =  $user->createToken('2obsKoWSyYBfFmwzvkiiuVnoUsyf9aG6')->accessToken; 
        return response()->json($message);
    }
}
