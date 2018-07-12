<?php

namespace Tugger\Http\Controllers\Auth;

use Tugger\User;
use Tugger\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use PhpParser\Node\Scalar\String_;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Tugger\Jobs\SendVerificationEmail;
use Tugger\VerifyUser;
use Tugger\Mail\VerifyMail;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Illuminate\Support\Facades\Log;


class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {

        $date_of_birth = self::parseDate($data['date_of_birth']);
        $dt = Carbon::now();
        $data['date_of_birth'] = $dt->diffInYears($date_of_birth->toDateTimeString());

        error_log($data['date_of_birth']);

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
//            'date_of_birth' => 'required|min:6',
        ]);
    }


    protected function create(array $data)
    {

        $date_of_birth = self::parseDate($data['date_of_birth'])->toDateTimeString();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'date_of_birth' => $date_of_birth,
            'email_token' => base64_encode($data['email']),
        ]);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);
        Mail::to($user->email)->send(new VerifyMail($user));
        return $user;
    }

    public static function parseDate($d) {
        $dateString = $d['day'].'-'.$d['month'].'-'.$d['year'];
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $dateString);
        return $date_of_birth;
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/login')->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/login')->with('status', $status);
    }

}
