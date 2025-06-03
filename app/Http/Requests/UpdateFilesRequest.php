<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFilesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file_path' => 'sometimes|required|string|max:255',
            'file_type' => 'sometimes|required|string|max:50',
            'hash' => 'sometimes|required|string|max:64',
            'size' => 'sometimes|required|integer|min:0',
            'date_created' => 'sometimes|required|date',
            'employee_id' => 'sometimes|required|exists:employee,employee_id',
        ];
    }
}
