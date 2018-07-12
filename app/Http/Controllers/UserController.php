<?php

namespace Tugger\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Tugger\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Tugger\Http\Controllers\Rules\EditProfile\ValidData;
use Tugger\Http\Requests;
use Auth;
use Image;
use Tugger\User;
use Carbon\Carbon;

class UserController extends Controller
{

    public function get_users() {
        return view('/pages/users')->withUsers(User::all());
    }

    public function profile($id)
    {
        $user = User::find($id);
        $auth_user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    public function update_avatar(Request $request)
    {
//        $user = User::find($id);
        $user = Auth::user();
        if ($request->hasFile('avatar')) {
            $this->validate($request, [
                'avatar' => 'image:jpg,png',
            ]);
            $avatar = $request->file('avatar');
            $filename = time() . '.' .  $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' .  $filename  ));
            $user->avatar = $filename;
            $user->save();
        }
        return view('pages/profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('pages/edit', compact('user'));
    }

    function check_updated($keys, $request, $user) {
        foreach($keys as $key) {
           if ($request->$key !== $user->$key)
               return false;
        }
        return true;
    }

    function update_if_exist($request, $user) {
//        foreach($keys as $key) {
//            if ($request->$key) {
//                switch ($key) {
//                    case 'password': $user->$key = bcrypt($request->$key); break;
//                    case 'date_of_birth': $user->$key = $date; break;
//                    default: $user->$key = $request->$key; break;
//                }
//            }
//        }
//        $user->update([
//            'name'          => $request->name,
//            'email'         => $request->email,
//            'password'      => $request->password == '' ? $user->password : $request->password,
//            'date_of_birth' => $request->date_of_birth,
//        ]);
//        if ($user->exists) {
//            return false;
//        }
        return $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => $request->password == '' ? $user->password : $request->password,
            'date_of_birth' => RegisterController::parseDate($request->date_of_birth),
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

//        $date_of_birth = RegisterController::parseDate($request->date_of_birth);

        $this->validate($request, [
            'name' => 'max:255,',
            'email' => 'email|max:255|unique:users,email,' . $user->id,
            'password' => $request->password != '' ? 'confirmed|min:6' : '',
            'date_of_birth' => [new ValidData()],
        ]);

//        $keys = ['name', 'email', 'password', 'date_of_birth'];

        $updated = $this->update_if_exist($request, $user);
//        $updated = $this->check_updated($keys, $request, $user);

//        error_log($updated);

        if ($updated)
            return redirect('edit')->with('status', 'Your profile successfully updated');

        return back();
    }

//    public function get_posts() {
//        return view('pages.post');
//    }

}
