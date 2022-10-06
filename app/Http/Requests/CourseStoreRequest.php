<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CourseStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string|nullable',
            'status' => 'required|in:Published,Pending',
            'is_premium' => 'required|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
            'status.required' => 'Status is required',
            'is_premium.required' => 'Is premium is required',
        ];
    }

}