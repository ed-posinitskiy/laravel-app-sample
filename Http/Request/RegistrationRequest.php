<?php

namespace App\Http\Request;

use App\Dto\Attributes\RegistrationAttributesVo;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegistrationRequest
 *
 * @package App\Http\Request
 */
class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getAttributes(): RegistrationAttributesVo
    {
        return RegistrationAttributesVo::fromArray($this->all());
    }
}
