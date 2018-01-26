<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resource\EmptyResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('app/auth/login');
    }

    protected function authenticated(Request $request, $user)
    {
        $resource = new EmptyResource();
        $resource->withMessage(trans('auth.success'));
        $resource->withRedirect(\Session::pull('url.intended', $this->redirectPath()));

        return $resource;
    }

    public function redirectPath()
    {
        return route($this->redirectTo);
    }

}
