<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuTamuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15|regex:/^08\d+$/',
            'alamat' => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'nama.required' => 'Kolom Nama harus diisi.',
            'nama.string' => 'Kolom Nama harus berupa teks.',
            'nama.max' => 'Kolom Nama maksimal :max karakter.',

            'no_hp.string' => 'Kolom Nomor HP harus berupa teks.',
            'no_hp.max' => 'Kolom Nomor HP maksimal :max karakter.',
            'no_hp.regex' => 'Kolom Nomor HP harus diawali dengan 08 dan hanya boleh mengandung angka.',

            'alamat.string' => 'Kolom Alamat harus berupa teks.',
            'alamat.max' => 'Kolom Alamat maksimal :max karakter.',

            'keperluan.string' => 'Kolom Keperluan harus berupa teks.',
            'keperluan.max' => 'Kolom Keperluan maksimal :max karakter.',
        ];
    }
}
