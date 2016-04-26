<?php

namespace Statamic\Addons\Todo\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AddItem extends FormRequest {

    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'title' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'You must provide a title'
        ];
    }
}