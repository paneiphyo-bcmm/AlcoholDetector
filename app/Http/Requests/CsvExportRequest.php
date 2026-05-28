// app/Http/Requests/CsvExportRequest.php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvExportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'target'                      => ['required', 'string', 'in:measurement_records,licenses'],
            'filter_conditions'           => ['nullable', 'array'],
            'filter_conditions.location_id'        => ['nullable', 'string'],
            'filter_conditions.user_names'         => ['nullable', 'array'],
            'filter_conditions.user_names.*'       => ['string'],
            'filter_conditions.company_name_or_id' => ['nullable', 'string'],
        ];
    }
}