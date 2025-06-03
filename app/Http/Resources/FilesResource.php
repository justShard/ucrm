<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilesResource extends JsonResource
{
   
    public function toArray(Request $request): array
    {
        return [
            'file_id' => $this->file_id,
            'file_path' => $this->file_path, 
            'file_type' => $this->file_type, 
            'size' => $this->size, 
            'date_created' => $this->date_created, 
            'hash' => $this->hash, 
            'employee_id' => $this->employee_id,
        ];
    }
}
