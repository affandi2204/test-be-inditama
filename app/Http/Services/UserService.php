<?php

namespace App\Http\Services;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\AuthResponse;
use App\Http\Resources\BaseResponse;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserService extends BaseResponse
{
    public function register(Request $request)
    {
        try {
            $input      = $request;
            $validator  = processRules($input, RegisterRequest::getRules());
            if($validator->fails()) {
                return $this->sendError($validator->errors(), 400);
            }

            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $credentials = $request->only('email', 'password');
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return $this->sendError('Unauthorized', 401);
            }

            $user = Auth::user();
            $storeToken = $this->storeToken($user->id, $token);
            $user = $storeToken;
            DB::commit();
            $response = [
                'user' => $user,
                'token' => $token,
            ];
            return $this->sendResponse(new AuthResponse($response), 'Your email has been registered.', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function login (Request $request)
    {
        try {
            $input      = $request;
            $validator  = processRules($input, LoginRequest::getRules());
            if($validator->fails()) {
                return $this->sendError($validator->errors(), 400);
            }

            $credentials = $request->only('email', 'password');
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return $this->sendError('Credential doesn`t match.', 401);
            }

            $user = Auth::user();
            $storeToken = $this->storeToken($user->id, $token);
            $user = $storeToken;

            $response = [
                'user' => $user,
                'token' => $token,
            ];
            return $this->sendResponse(new AuthResponse($response), 'Your email has been loged in.', 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function logout ()
    {
        try {
            $removeToken = $this->removeToken(Auth::user()->id);
            Auth::logout();
            return $this->sendResponse(null, 'Your email has been loged out.');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 500);
        }
    }


    public function profile ()
    {
        try {
            $user = Auth::user();
            return $this->sendResponse(new AuthResponse(['user'=>$user, 'token'=>$user->jwt_token]), 'Succcessfully get data user.');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function storeToken($id, $token)
    {
        $user = User::where('id', $id)->first();
        $user->jwt_token = $token;
        $user->login_at = new DateTime();
        $user->save();
        return $user;
    }

    public function removeToken($id)
    {
        $user = User::where('id', $id)->first();
        $user->jwt_token = null;
        $user->login_at = null;
        $user->save();
        return $user;
    }
}
