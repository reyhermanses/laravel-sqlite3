<?php

namespace App\Http\Requests;

use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostBookRequest extends FormRequest
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
            'isbn' => 'numeric|unique:books|size:13',
            'title' => 'string',
            'description' => 'string',
            'authors' => 'integer|unique:book_author',
            'published_year' => 'date_greater_than:1900'
        ];
    }

    public function messages()
    {
        return [
            'isbn.required'    => 'A isbn is required',
            'isbn.unique'      => 'The isbn has already been taken. Try another isbn.',
            'isbn.size'     => 'Max 13 characters',
            'authors.unique' => 'The authors has already exist',
            'authors.integer' => 'The authors must be integer',
            'title.regex' => 'Title must be a string',
            'description' => 'Desc must be a string',
            'authors.integer' => 'Authors must be integer',
            'published_year.date_greater_than' => 'Year between 1900 & ' . Carbon::now()->year,

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => true
        ], 422));
    }
}
