// app/Http/Requests/UpdateLocationRequest.php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_name' => ['required', 'string', 'max:100'],
            'admin_user_id' => ['required', 'string', 'size:10', 'exists:users,user_id'],
        ];
    }
}