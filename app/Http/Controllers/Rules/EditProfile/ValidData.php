<?php
/**
 * Created by PhpStorm.
 * User: ilyadonskoj
 * Date: 10.07.18
 * Time: 11:44
 */

namespace Tugger\Http\Controllers\Rules\EditProfile;

use Carbon\Carbon;
use Tugger\Http\Controllers\Auth\RegisterController;
use Illuminate\Contracts\Validation\Rule;

class ValidData implements Rule
{
    public function passes($attribute, $value)
    {
        $date_of_birth = RegisterController::parseDate($value);
        $dt = Carbon::now();
        $diff = $dt->diffInYears($date_of_birth->toDateTimeString());
        return $diff == 0 ? 1 : $diff >= 6 ? 1 : 0;
    }

    public function message()
    {
        return ':attribute needs more cowbell!';
    }
}