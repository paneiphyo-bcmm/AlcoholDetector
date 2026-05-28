// app/Http/Requests/StoreMeasurementRecordRequest.php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeasurementRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'device_id'        => ['required', 'string', 'max:20', 'exists:devices,device_id'],
            'location_id'      => ['required', 'string', 'size:10', 'exists:locations,location_id'],
            'user_id'          => ['nullable', 'string', 'size:10', 'exists:users,user_id'],
            'measurement_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'alcohol_level'    => ['required', 'numeric', 'min:0', 'max:99.99'],
        ];
    }
}