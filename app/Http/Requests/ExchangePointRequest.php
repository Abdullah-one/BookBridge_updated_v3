<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExchangePointRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:accounts,email|max:256',
            'userName' =>'required|max:40',
            'maxPackages' => 'required|Numeric|max_digits:3',
            'locationDescription' => 'max:100',
            'location' => 'required|max:100|url',
            'residentialQuarter_id' => 'required|exists:residential_quarters,id',
            'password' => [
                'required',
                'string',
                'min:8', // At least 8 characters long
                'max:50', // At most 50 characters long
                'confirmed'
            ],
            'phoneNumber' => ['required', 'regex:/^(77|78|73|70|71)[0-9]{7}$/']
        ];
    }

        public function messages(): array
    {
        return[
            'userName.max'=>'اسم المستخدم يجب أن لا يتعدى 40 رمز',
            'userName.required'=>'اسم المستخدم مطلوب',
            'maxPackages.required'=>'العدد الأقصى لحزم الكتب مطلوب',
            'maxPackages.Numeric'=>'العدد الأقصى لحزم الكتب يجب أن يكون رقم',
            'maxPackages.max_digits'=>'العدد الأقصى لحزم الكتب يجب أن يكون من ثلاثة خانات',
            'locationDescription.max'=>'وصف الموقع يجب أن لا يتعدى 100 رمز',
            'location.max'=>'الموقع الجغرافي يجب أن لا يتعدى 40 رمز',
            'location.required'=>'الموقع الجغرافي مطلوب',
            'residentialQuarter_id.required'=>'الحي مطلوب',
            'residentialQuarter_id.exists'=>'الحي غير صحيح',
            'email.required'=>'الايميل مطلوب',
            'email.email'=>'الايميل مكتوب بطريقة غير صحيحة',
            'email.unique' => 'يوجد حساب بهذا الايميل',
            'email.max' => 'البريد الإلكتروني طويلا جدا',
            'password.required'=>'كلمة المرور مطلوبة',
            'password.min'=>'يجب أن لا تقل كلمة المرور عن 8 عناصر',
            'password.max'=>'يجب أن لاتزيد كلمة المرور عن 50 عنصر',
            'password.confirmed' => 'كلمة المرور غير متطابقة',
            'phoneNumber.required' => 'رقم الجوال مطلوب',
            'phoneNumber.regex' => 'رقم الجوال يجب أن يتكون من 9 عناصر وأن يكون رقم صحيح',
            'location.url'=>'الموقع الجغرافي يجب أن يكون رابطا صحيحا'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}
