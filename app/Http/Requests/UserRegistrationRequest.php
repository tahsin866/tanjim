<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow anyone to register
    }

    public function rules(): array
    {
        $rules = [
            'fullNameBangla' => 'required|string|max:255',
            'fullNameEnglish' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phoneNumber' => 'required|string|digits:11|unique:users,phoneNumber',
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'alternatePhoneNumber' => 'nullable|string|max:15',
            'dateOfBirth' => 'required|date',
            'bloodGroup' => 'nullable|string|max:255',
            'address' => 'required|string',
            'division' => 'required|integer',
            'district' => 'required|integer',
            'thana' => 'required|integer',
            'classmate1' => 'required|string|max:255',
            'classmate2' => 'required|string|max:255',
            'classmate3' => 'required|string|max:255',
            'dept_takmil' => 'boolean',
            'dept_ifta' => 'boolean',
            'dept_hifz' => 'boolean',
            'dept_qirat' => 'boolean',
            'dept_adab' => 'boolean',
            'dept_other' => 'boolean',
            'dept_takmil_year_english' => 'nullable|string|max:255',
            'dept_takmil_year_hijri' => 'nullable|string|max:255',
            'dept_ifta_year_english' => 'nullable|string|max:255',
            'dept_ifta_year_hijri' => 'nullable|string|max:255',
            'dept_hifz_year_english' => 'nullable|string|max:255',
            'dept_hifz_year_hijri' => 'nullable|string|max:255',
            'dept_qirat_year_english' => 'nullable|string|max:255',
            'dept_qirat_year_hijri' => 'nullable|string|max:255',
            'dept_adab_year_english' => 'nullable|string|max:255',
            'dept_adab_year_hijri' => 'nullable|string|max:255',
            'dept_other_class' => 'nullable|string|max:255',
            'examType' => 'required|string|max:255',
            'workplace' => 'nullable|string|max:255',
            'idType' => 'required|string|in:birth,voter,passport',
            'birthCertificate' => 'nullable|string|size:17|numeric',
            'voterId' => [
                'nullable',
                'string',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($value && (strlen($value) != 10 && strlen($value) != 17)) {
                        $fail('ভোটার আইডি অবশ্যই ১০ অথবা ১৭ সংখ্যার হতে হবে।');
                    }
                },
            ],
            'passport_id' => 'nullable|string|max:100',
            'birthCertificatePhoto' => 'nullable|file|image|max:2048',
            'voterIdPhoto' => 'nullable|file|image|max:2048',
            'passport_photo' => 'nullable|file|image|max:2048',
            'photo' => 'nullable|file|image|max:2048',
        ];

        // Conditional Validation
        if ($this->examType && $this->examType !== 'জানা নেই') {
            $rules['rollNumber'] = 'required|string|max:255';
        } else {
            $rules['rollNumber'] = 'nullable|string|max:255';
        }

        if ($this->idType === 'passport') {
            $rules['passport_id'] = 'required|string|max:100';
            $rules['passport_photo'] = 'required|file|image|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'rollNumber.required' => 'রোল নাম্বার প্রয়োজন যখন পরীক্ষার ধরন "জানা নেই" নয়।',
            'examType.required' => 'পরীক্ষার ধরন নির্বাচন করুন।',
            'idType.required' => 'পরিচয়পত্রের ধরন নির্বাচন করুন।',
            'passport_id.required' => 'পাসপোর্ট নম্বর প্রয়োজন।',
            'passport_photo.required' => 'পাসপোর্টের ছবি প্রয়োজন।',
            'phoneNumber.digits' => 'ফোন নম্বর অবশ্যই ১১ সংখ্যার হতে হবে।',
            'birthCertificate.numeric' => 'জন্মনিবন্ধন নম্বরে শুধু সংখ্যা থাকবে।',
            'birthCertificate.size' => 'জন্মনিবন্ধন নম্বর অবশ্যই ১৭ সংখ্যার হতে হবে।',
            'voterId.numeric' => 'ভোটার আইডি নম্বরে শুধু সংখ্যা থাকবে।',
        ];
    }
}