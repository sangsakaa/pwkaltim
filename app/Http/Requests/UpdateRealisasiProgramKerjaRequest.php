<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRealisasiProgramKerjaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'realisasi_kegiatan' => 'nullable|string',
            'realisasi_target' => 'nullable|string',
            'progress' => 'required|integer|min:0|max:100',
            'anggaran_realisasi' => 'nullable|numeric',
            'tanggal_selesai' => 'nullable|date',
        ];
    }
}
