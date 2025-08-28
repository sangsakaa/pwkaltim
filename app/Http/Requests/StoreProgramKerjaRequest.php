<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramKerjaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomor' => ['required', 'string', 'max:50', 'unique:program_kerjas,nomor'],
            'uraian_kegiatan' => ['required', 'string'],
            'waktu_pelaksanaan' => ['required', 'in:bulanan,triwulan,semester,tahunan'],
            'sasaran' => ['required', 'string', 'max:255'],
            'target' => ['required', 'string', 'max:255'],
            'biaya' => ['required', 'integer', 'min:0'],
            'penanggung_jawab' => ['required', 'string', 'max:255'],
        ];
    }
}
