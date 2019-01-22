<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
            'todo' => 'required|max:20',
            //add captcha validation
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    public function message(){

        return [

            'todo.required' => 'This field is compulsory',
            'todo.max' => 'Please enter lesser text',
        ];
    }
}
