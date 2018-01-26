<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Request\RegistrationRequest;
use App\Http\Response\Ajax\RedirectResponseModel;
use App\Service\RegistrationService;
use Auth;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Session;

class RegisterController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    /**
     * @var RegistrationService
     */
    protected $registrationService;

    /**
     * Create a new controller instance.
     *
     * @param RegistrationService $registrationService
     */
    public function __construct(RegistrationService $registrationService)
    {
        $this->middleware('guest');

        $this->registrationService = $registrationService;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegistrationRequest $request
     *
     * @return RedirectResponseModel
     */
    public function register(RegistrationRequest $request)
    {
        $userTo = $this->registrationService->register($request->getAttributes());

        $this->guard()->login($userTo->getOriginal());

        return RedirectResponseModel::withMessageAndUri(
            trans('auth.registered'),
            $path = Session::pull('url.intended', $this->redirectPath())
        );
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    public function redirectPath()
    {
        return route($this->redirectTo);
    }
}
