<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFilesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file_path' => 'required|string|max:255',
            'file_type' => 'required|string|max:50',
            'hash' => 'required|string|max:64',
            'size' => 'required|integer|min:0',
            'date_created' => 'required|date',
            'employee_id' => 'required|exists:employee,employee_id',
        ];
    }
}
