<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'card_number' => 'required|string|min:8|max:19',
            'cvv' => 'required|string|min:3|max:4',
            // to match 09/12 etc. exp in card numbers
            'expiration' => ['required', 'regex:^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$']
        ];
    }
}
