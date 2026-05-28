// app/Http/Requests/SearchMeasurementRecordRequest.php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchMeasurementRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_id'        => ['nullable', 'string', 'size:10'],
            'user_names'         => ['nullable', 'array'],
            'user_names.*'       => ['string', 'max:100'],
            'company_name_or_id' => ['nullable', 'string', 'max:200'],
        ];
    }
}