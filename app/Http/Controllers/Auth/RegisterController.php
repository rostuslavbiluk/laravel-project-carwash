<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Model\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'email', 'max:15', 'unique:users,personal_phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function customCreate(array $data)
    {
        if (!empty($data['phone'])) {
            $data['phone'] = preg_replace('~\D~', '', $data['phone']);
        }
        if (empty($data['email'])) {
            $data['email'] = \App\Classes\ClassHelper::genEmail($data['phone']);
        }
        if (!empty($data['phone']) && !empty($data['name'])) {
            $sConfimCode = \App\Classes\ClassHelper::genPassword($data['phone']);
        }
        $arParams = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            'personal_phone' => $data['phone'],
            'username' => $data['phone'], // login
            'active' => 'Y',
            'external_auth_id' => 'site',
            'confirm_code' => $sConfimCode,

            'last_name' => '',
            'second_name' => '',
            'checkword' => '',
            'personal_photo' => 0,
            'personal_gender' => '',
            'personal_birthdate' => '',
            'personal_mobile' => '',
            'personal_city' => '',

        ];
        /* confim register user on phone number */
        $arSendParams = [
            'phone' => $data['phone'],
            'confirm_code' => $sConfimCode,
        ];
        sendSmsConfim::sendConfim($arSendParams);
        $user = User::create($arParams);
        $user->roles()->sync([2]);
        return $user;
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
    }
}
