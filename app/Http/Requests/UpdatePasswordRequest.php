<?php

namespace App\Http\Requests;

use App\Rules\passwordValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'oldPassword'=>[
                'required',
                new passwordValidation
            ],
            'newPassword' =>[
                'required',
                'string',
                'min:8', // At least 8 characters long
                'max:50', // At most 50 characters long
                'confirmed'
            ],
        ];
    }

    public function messages(): array
    {
        return[
            'oldPassword.required'=>'كلمة المرور القديمة مطلوبة',
            'newPassword.min'=>'يجب أن لا تقل كلمة المرور عن 8 عناصر',
            'newPassword.max'=>'يجب أن لاتزيد كلمة المرور عن 50 عنصر',
            'newPassword.confirmed' => 'كلمة المرور غير متطابقة',
            'newPassword.required' => 'كلمة المرور الجديدة مطلوبة',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
