<?php
/**
 * Created by PhpStorm.
 * User: ilyadonskoj
 * Date: 12.07.18
 * Time: 11:13
 */

namespace Tugger\Http\Controllers;

use Illuminate\Http\Request;
use Tugger\AuthTroughExt;
use Tugger\ExternalSocset;
use Tugger\User;
use Tugger\ExtAuthCode;
use Tugger\ExtToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;


class AuthThroughExternal
{
    public function acceptAuthCode(Request $request, $extSocset)
    {
        $sc = ExternalSocset::where('service', $extSocset)->firstOrFail();
        $url = $sc->url;
        $client = new Client();
        $json1 = $client->post($url . '/api/token',
            ['form_params' => ['service_id' => 'donskoy', 'auth_code' => $request->input('auth_code')]])->getBody();
        $response = json_decode($json1);
        if ($response->status == 'ok'){
            $client = new Client();
            $json2 = $client->get($url . '/api/profile/' . $response->user_id, ['query' => ['service_id' => 'donskoy',
                'token' => $response->token]])->getBody();
            $response2 = json_decode($json2);
            if ($response2->status == 'ok'){
                if (AuthTroughExt::where('ext_user_id', $response->user_id)->exists()){
                    $user = AuthTroughExt::where('ext_user_id', $response->user_id)->firstOrFail()->user;
                }
                else{
                    if (User::where('email', $response2->email)->exists())
                        return 'email already exists';
                    $user = User::create(['nickname' => $response2->login,
                        'email' => $response2->email,
                        'password' => Hash::make('external')]);
                    AuthTroughExt::create(['token' => $response->token,
                        'service_id' => $sc->id,
                        'user_id' => $user->id,
                        'ext_user_id' => $response->user_id]);
                }
            }
            else{
                dd('error');
            }
        }
        else{
            dd('error');
        }
        Auth::login($user, true);
        return redirect()->route('id', ['id' => $user->id]);
    }

    public function apiLogin(Request $request)
    {
        return view('external/login', ['service' => $request->service_id, 'ext_url' => $request->redirect_url]);
    }

    public function redirectBack(Request $request)
    {
        if (Auth::guest())
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password], true))
                return 'no user';

        $code = str_random(60);
        ExtAuthCode::create(['user_id' => Auth::user()->id, 'service' => $request->service_id,
            'auth_code' => $code]);

        return redirect()->away($request->redirect_url . '?auth_code=' . $code);
    }

    public function returnToken(Request $request)
    {

        $code = ExtAuthCode::where('service', $request->service_id)->where('auth_code', $request->auth_code)->first();
        if ($code){
            $user = $code->user;
            $code = str_random(60);
            ExtToken::create(['user_id' => $user->id, 'service' => $request->service_id, 'token' => $code]);
            return response()->json(['status' => 'ok',
                'user_id' => $user->id,
                'token' => $code]);
        }
        return response()->json(['status' => 'error']);
    }

    public function getProfile(Request $request)
    {
        $token = ExtToken::where('service', $request->service_id)->where('token', $request->token)->first();
        if ($token){
            $user = $token->user;
            return response()->json(['status' => 'ok',
                'login' => $user->nickname,
                'email' => $user->email]);
        }
        return response()->json(['status' => 'error']);
    }
}