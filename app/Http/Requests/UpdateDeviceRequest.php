// app/Http/Requests/UpdateDeviceRequest.php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_id'       => ['required', 'string', 'size:10', 'exists:locations,location_id'],
            'device_name'       => ['required', 'string', 'max:100'],
            'serial_number'     => ['nullable', 'string', 'max:50'],
            'installation_date' => ['nullable', 'date'],
        ];
    }
}