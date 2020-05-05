<?php

namespace App\Http\Controllers\Auth;

use App\Classes\Entity\GroupRoles\UserRoles;
use App\Classes\Helpers\Base;
use App\Classes\Helpers\Phone;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Authenticate;
use ErrorException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function customLogin(Request $request)
    {
        try {
            if (!empty($request->input('phone'))) {
                $phone = Phone::normalize($request->input('phone'));
                if (!$phone) {
                    throw new ErrorException('Введите телефон и пароль');
                }
            }
            $isAuth = Auth::attempt(['username' => $phone, 'password' => $request->input('password'), 'active' => 'Y']);
            if (!$isAuth) {
                throw new ErrorException('Ошибка авторизации');
            }
            $user = Auth::user();
            if (!isset($user)) {
                throw new ErrorException('Пользователь не найден');
            }
            if (!(new UserRoles($user))->isAdmin()) {
                throw new ErrorException('Не хватает прав доступа, обратитесь в службу поддержки.');
            }

            return redirect()->route('dashboard.index');

        } catch (ErrorException|QueryException $e) {
            return redirect()->route('login')->with([
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function authenticated(Request $request, $user)
    {
//        $userCustom = Authenticate::loginUsingId(1, true);
//        dump($userCustom);
    }
}
