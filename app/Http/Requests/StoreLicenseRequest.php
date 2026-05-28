// app/Http/Requests/StoreLicenseRequest.php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLicenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id'     => ['required', 'string', 'size:10', 'exists:companies,company_id'],
            'contract_count' => ['required', 'integer', 'min:0'],
        ];
    }
}