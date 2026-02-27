<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreticketRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'creator' => 'required',
            'creator_phone' => 'required|string|regex:/^[0-9]+$/',
            'creator_email' => 'required|email',
            'recipient_phone' => 'required|string|regex:/^[0-9]+$/',
            'recipient_email' => 'required|email',
            'service' => 'required',
            'time' => 'required',
            'content' => 'required',
            'attachment.*' => 'file|max:5120'
            // 'recipient' => 'required',
            // 'supervisor' => 'required',
            // 'unit' => 'required',
            // 'order.id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'creator.required'         => 'Nama pembuat tiket wajib diisi.',
            'creator_phone.required' => 'Nomor telepon pembuat tiket wajib diisi.',
            'creator_phone.string'   => 'Nomor telepon harus berupa teks.',
            'creator_phone.regex'    => 'Nomor telepon hanya boleh berisi angka.',
            // 'creator_phone.max'      => 'Nomor telepon tidak boleh lebih dari 12 digit.',
            'creator_email.required'   => 'Alamat email pembuat tiket wajib diisi.',
            'creator_email.email'      => 'alamat email tidak valid.',
            'recipient_phone.required' => 'Nomor telepon recipient tiket wajib diisi.',
            'recipient_phone.string'   => 'Nomor telepon harus berupa teks.',
            'recipient_phone.regex'    => 'Nomor telepon hanya boleh berisi angka.',
            // 'recipient_phone.max'      => 'Nomor telepon tidak boleh lebih dari 12 digit.',
            'recipient_email.required'   => 'Alamat email recipient tiket wajib diisi.',
            'recipient_email.email'      => 'alamat email tidak valid.',
            'service.required'         => 'Layanan yang dibutuhkan wajib dipilih.',
            'time.required'            => 'Urgensi layanan wajib ditentukan.',
            'content.required'         => 'Deskripsi tiket wajib diisi.',
            'attachment.*.max'         => 'Ukuran file tidak boleh lebih dari 5 MB.',
            // 'recipient.required'     => 'Penerima tiket wajib ditentukan.',
            // 'supervisor.required'    => 'Pengawas wajib ditentukan.',
            // 'unit.required'          => 'Unit terkait wajib dipilih.',
            // 'order.id.required'      => 'ID pesanan wajib diisi.',
        ];
    }
}
