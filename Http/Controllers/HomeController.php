<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Auth\AuthenticationException;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * HomeController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function welcome()
    {
        try {
            return redirect('dashboard');
        } catch (AuthenticationException $ex) {
            return redirect('login');
        }
    }
}
