<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPassFormRequest;
use App\Http\Requests\RegisterationFormRequest;
use App\Http\Requests\ResetPassFormRequest;
use App\Jobs\ResetPassMailJob;
use App\Jobs\SendEmailJob;
use App\Mail\ResetPassMail;
use App\Mail\SendEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ApiResponseWithHttpStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ApiResponseWithHttpStatus;

    public function  __construct()
    {
        Auth::shouldUse('users');
    }



    public function register(RegisterationFormRequest $request)
    {


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $credentials = $request->only('email', 'password');

        $token = JWTAuth::attempt($credentials);
        $encode_token = base64_encode($token);
        $url = "$request->redirect_url?access_token=$encode_token";

        $email = new SendEmail($user, $url, $token);
        dispatch(new SendEmailJob($user, $email, $url));

        $data = ['user' => Auth::user()];

        return $this->apiResponse('Registration Success', $token, $data, Response::HTTP_OK, true);
    }


    public  function login(Request $request)
    {

        $input = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($input)) {
            return $this->apiResponse('Invalid credential', null, Response::HTTP_BAD_REQUEST, false);
        }

        $data = Auth::user();

        return $this->apiResponse('Success Login', $token, $data, Response::HTTP_OK, true);
    }

    public  function logout()
    {
        if (Auth::check()) {
            $token = Auth::getToken();
            JWTAuth::setToken($token);
            JWTAuth::invalidate();
            Auth::logout();
            return $this->apiResponse('Logout Success', null, null, Response::HTTP_OK, true);
        } else {
            return $this->apiResponse('Logout Error', null, null, Response::HTTP_UNAUTHORIZED, false);
        }
    }

    public function profile()
    {
        return \response()->json(Auth::user());
    }

    public function verifyUser($token)
    {

        $currentUser = JWTAuth::setToken($token)->toUser();

        $user = User::find($currentUser->id);
        $dt = Carbon::now()->toDateTimeString();
        // return $dt;

        $user->email_verified_at = $dt;

        $user->save();

        return $user;
    }

    public function resetPassword(Request $request)
    {
        $userEmail = $request->email;
        $user = User::where('email', '=', $userEmail)->first();
        if ($user) {

            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            $encode_token = base64_encode($token);
            $url = "$request->redirect_url?access_token=$encode_token";
            $emailView = new ResetPassMail($user, $url, $token);
            dispatch(new ResetPassMailJob($user, $emailView, $url));
            return $this->apiResponse('Password reset mail sent!',null,null, Response::HTTP_OK, true,null);
        } else {
            return $this->apiResponse('This Email is not registered!',null, null, Response::HTTP_BAD_REQUEST, false,null);
        }
    }

    public function submitNewPassword(ResetPassFormRequest $request)
    {

        $updatePassword = DB::table('password_resets')
            ->where([
                'token' => $request->token
            ])
            ->first();
        if (!$updatePassword) {
            $data = null;
            return $this->apiResponse('Invalid token!',null, $data, Response::HTTP_FORBIDDEN, true,null);
        }
        User::where('email', $updatePassword->email)
            ->update(['password' => bcrypt($request->password)]);
        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();
        $user = User::where('email', '=', $updatePassword->email)->first();
        $data = null;
        return $this->apiResponse('Password successfully changed!',null, $data, Response::HTTP_OK, true,null);
    }
    public function getAllUser()
    {

        try {
            $users = User::where('is_admin',0)->get();
            return response([
                'users' => $users
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => 'Something is wrong!'
            ], 400);
        }
    }
    public function deleteUser($id)
    {
        $item = User::find($id);
        $item->delete();
        try {
            $item->delete();
            return response([
                'message' => 'User is deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => 'User is not deleted successfully!'
            ], 400);
        }
    }
}
