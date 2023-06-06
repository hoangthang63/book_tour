<?php

namespace App\Http\Requests\Coupon;

use App\Rules\StampNeedRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'image' => [
                'mimes:jpg,gif,png',
            ],
            'name' => [
                'required',
                'max:255',
            ],
            'note' => [
                'required',
                'max:255',
            ],
            'detail' => [
                'required',
            ],
            'number_of_stamp_needed' => [
                'required',
                new StampNeedRule(),

            ],
            
        ];
    }
}
