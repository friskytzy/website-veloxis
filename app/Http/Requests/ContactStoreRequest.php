<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'subject' => ['required', 'string', 'max:255', 'min:5'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'honeypot' => ['sometimes', 'string', 'max:0'], // Spam protection
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check for spam indicators
            $message = $this->input('message', '');
            $name = $this->input('name', '');
            
            // Check for suspicious patterns
            if (preg_match('/\b(buy|sell|loan|credit|casino|viagra|cialis)\b/i', $message)) {
                $validator->errors()->add('message', 'Pesan mengandung konten yang tidak diizinkan.');
            }
            
            // Check for excessive links
            if (substr_count($message, 'http') > 3) {
                $validator->errors()->add('message', 'Pesan mengandung terlalu banyak link.');
            }
            
            // Check for suspicious name patterns
            if (preg_match('/\b(mr\.|mrs\.|dr\.|prof\.)\b/i', $name)) {
                $validator->errors()->add('name', 'Format nama tidak valid.');
            }
        });
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 2 karakter.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'subject.min' => 'Subjek minimal 5 karakter.',
            'subject.max' => 'Subjek maksimal 255 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal 10 karakter.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'email',
            'phone' => 'nomor telepon',
            'subject' => 'subjek',
            'message' => 'pesan',
        ];
    }
}
