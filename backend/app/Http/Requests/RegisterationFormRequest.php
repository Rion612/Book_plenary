<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponseWithHttpStatus;

class RegisterationFormRequest extends FormRequest
{
    use ApiResponseWithHttpStatus;
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:6',
                'max:30',
                'confirmed'
            ],
        ];
    }




    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse('Registration errrors',null, null, Response::HTTP_UNPROCESSABLE_ENTITY, false, $validator->errors()));
    }

}
