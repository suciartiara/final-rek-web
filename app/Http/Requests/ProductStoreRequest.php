<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0'
        ];
    }
}