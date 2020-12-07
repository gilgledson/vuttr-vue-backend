<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ToolStorageRequest extends FormRequest
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
            'name' => 'required',
            'link' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'O Nome é um campo obrigatório!',
            'link.required' => 'O Link é um campo obrigatório!'
        ];
    }
    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            response()->json(['error' =>  $validator->errors()->first()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

}
