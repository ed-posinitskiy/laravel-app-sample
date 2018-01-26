<?php

namespace App\Validator;

use App\Service\UserService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

/**
 * Class CurrentPasswordRule
 *
 * @package App\Validator
 */
class CurrentPasswordRule implements Rule
{

    /**
     * @var BcryptHasher
     */
    protected $hasher;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var string
     */
    protected $hashed;

    /**
     * CurrentPasswordRule constructor.
     *
     * @param BcryptHasher $hasher
     * @param UserService  $userService
     * @param Translator   $translator
     */
    public function __construct(BcryptHasher $hasher, UserService $userService, Translator $translator)
    {
        $this->hasher      = $hasher;
        $this->userService = $userService;
        $this->translator  = $translator;
    }

    /**
     * @param string $hashed
     *
     * @return CurrentPasswordRule
     */
    public function withHashed($hashed)
    {
        $this->hashed = $hashed;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->hashed) {
            $this->hashed = $this->userService->getCurrent()->getOriginal()->password;
        }

        return $this->hasher->check($value, $this->hashed);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->translator->trans('validation.current_password');
    }

    /**
     * @param string    $attribute
     * @param mixed     $value
     * @param array     $parameters
     * @param Validator $validator
     *
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        $hash = head($parameters);

        if (!empty($hash)) {
            $this->withHashed($hash);
        }

        return $this->passes($attribute, $value);
    }
}
