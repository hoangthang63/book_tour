<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProcessRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number_user' => [
                'bail',
                'required',
                'regex:/(0)[0-9]{9}/',
                'max:10',
            ]
        ];
    }

    public function messages()
    {
        return [
            'regex' => 'Phone number must start with 0 and is followed by 9 numbers',
            'max' => 'Phone number must start with 0 and is followed by 9 numbers',
        ];
    }
}
