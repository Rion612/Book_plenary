<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseWithHttpStatus;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ResetPassFormRequest extends FormRequest
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
            'token'=>'required',
            'password'=>[
                'required',
                'min:6',
                'max:30',
                'confirmed'
            ],
        ];
    }
    protected function failedValidation(ValidationValidator $validator)
    {
        throw new HttpResponseException($this->apiResponse('Reset password failed',null, null, Response::HTTP_UNPROCESSABLE_ENTITY, false, $validator->errors()));
    }
}
