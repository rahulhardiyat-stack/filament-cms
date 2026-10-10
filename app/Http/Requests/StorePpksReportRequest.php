<?php

namespace App\Http\Requests;

use App\Models\PpksReport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePpksReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reporter_role' => ['required', Rule::in(array_keys(PpksReport::ROLES))],
            'incident_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'location' => ['required', 'string', 'max:500'],
            'reported_person' => ['nullable', 'string', 'max:500'],
            'chronology' => ['required', 'string', 'min:20', 'max:10000'],
            'contact' => ['required', 'string', 'max:255'],
            'support_needed' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
            'evidence' => ['nullable', 'array', 'max:3'],
            'evidence.*' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'evidence.max' => 'Bukti maksimal 3 gambar.',
            'evidence.*.image' => 'Bukti harus berupa gambar.',
            'evidence.*.mimes' => 'Format bukti harus JPG, PNG, atau WebP.',
            'evidence.*.max' => 'Ukuran setiap gambar maksimal 2 MB.',
        ];
    }
}
