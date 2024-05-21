<?php

namespace App\Http\Requests\BookDonation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class addBookPackageDonationRequest extends FormRequest
{
    /**
     * Determine if the User is authorized to make this request.
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
//    public function rules(): array
//    {
//        return [
//            'description'=>'max:1000',
//            'images' => 'array|size:6',
//            'images.*' => 'image|max:2048', // Max size of each image is 2MB (2048 KB)
//        ];
//    }
//
//    public function messages(): array
//    {
//        return[
//            'description.max'=>'يجب أن لا يتعدى النص 1000 حرف',
//            'images.size'=>'عدد الصور يجب أن لا يتعدى 6 صور',
//            'images.array' => 'Images must be an array.',
//            'images.*.image' => 'يجب أن يكون الملف المرفوع صورة',
//            'images.*.max' => ' يجب أن لا يتعدى حجم الصورة 2 ميقا',
//        ];
//    }
//    protected function failedValidation(Validator $validator)
//    {
//        return response()->json(['status'=>'fail','message'=>$validator->errors()['images']]);
//    }
    public function rules(): array
    {
        return [
            'images' => 'array',
        ];
    }

    public function messages(): array
    {
        return[

            'images.array' => 'Images must be an array.',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        return response()->json(['status'=>'fail','message'=>'يجب أن تمرر الصور كمصفوفة']);
    }

}
