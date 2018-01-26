<?php

namespace App\Http\Controllers;

use App\Dto\UserEntityTo;
use App\Service\UserService;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var BcryptHasher
     */
    protected $hash;

    /**
     * ProfileController constructor.
     *
     * @param UserService  $userService
     * @param BcryptHasher $hash
     */
    public function __construct(UserService $userService, BcryptHasher $hash)
    {
        $this->userService = $userService;
        $this->hash        = $hash;
    }

    public function index()
    {
        $user = $this->userService->getCurrent();

        return view('app/profile/index')->with('user', $user);
    }

    public function updatePassword(Request $request)
    {
        $user = $this->userService->getCurrent();

        $this->validatePassword($request, $user);

        $this->userService->updatePassword($user, $request->post('password'));

        flash()->success('Your password has been changed')->important();

        return redirect()->back();
    }

    protected function validatePassword(Request $request, UserEntityTo $user)
    {
        $request->validate(
            [
                'current_password' => 'required|current_password',
                'password'         => 'required|min:6|confirmed',
            ]
        );
    }
}
