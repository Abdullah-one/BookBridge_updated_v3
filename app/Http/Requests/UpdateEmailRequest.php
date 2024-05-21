<?php

namespace App\Http\Requests;

use App\Rules\passwordValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEmailRequest extends FormRequest
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
            'Password'=>[
                'required',
                new passwordValidation
            ],
            'newEmail' =>[
                'required',
                'unique:accounts,email',
                'email'
            ],
        ];
    }

    public function messages(): array
    {
        return[
            'Password.required'=>'كلمة المرور القديمة مطلوبة',
            'newEmail.required'=>'الإيميل الجديد مطلوب',
            'newEmail.unique'=>'يوجد حساب حالي بهذا الإيميل',
            'newEmail.email' => 'تأكد من كتابة الإيميل بطريقة صحيحة',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
