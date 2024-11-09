<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'string', 'max:255'],
            'email' => ['string', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'password' => ['string', 'min:8', 'confirmed'],
            'is_admin' => Rule::in([User::ADMIN_USER, User::REGULAR_USER]),
            'verified' => Rule::in([User::VERIFIED_USER, User::UNVERIFIED_USER]),
        ];
    }
}
