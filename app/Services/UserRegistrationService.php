<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserRegistrationService
{
    public function register(array $validated, Request $request): User
    {
        $user = User::create([
            'fullNameBangla' => $validated['fullNameBangla'],
            'fullNameEnglish' => $validated['fullNameEnglish'],
            'fatherName' => $validated['fatherName'],
            'email' => $validated['email'],
            'phoneNumber' => $validated['phoneNumber'],
            'password' => Hash::make($validated['password']),
        ]);

        $this->createUserInformation($user, $validated, $request);

        return $user;
    }

    public function createUserInformation(User $user, array $validated, Request $request)
    {
        $data = [
            'user_id' => $user->id,
            'alternatePhoneNumber' => $validated['alternatePhoneNumber'] ?? null,
            'dateOfBirth' => $validated['dateOfBirth'] ?? null,
            'bloodGroup' => $validated['bloodGroup'] ?? null,
            'address' => $validated['address'] ?? null,
            'division_id' => $validated['division'] ?? null,
            'district_id' => $validated['district'] ?? null,
            'thana_id' => $validated['thana'] ?? null,
            'classmate1' => $validated['classmate1'] ?? null,
            'classmate2' => $validated['classmate2'] ?? null,
            'classmate3' => $validated['classmate3'] ?? null,
            'dept_takmil' => $validated['dept_takmil'] ?? false,
            'dept_ifta' => $validated['dept_ifta'] ?? false,
            'dept_hifz' => $validated['dept_hifz'] ?? false,
            'dept_qirat' => $validated['dept_qirat'] ?? false,
            'dept_adab' => $validated['dept_adab'] ?? false,
            'dept_other' => $validated['dept_other'] ?? false,
            'dept_takmil_year_english' => $validated['dept_takmil_year_english'] ?? null,
            'dept_takmil_year_hijri' => $validated['dept_takmil_year_hijri'] ?? null,
            'dept_ifta_year_english' => $validated['dept_ifta_year_english'] ?? null,
            'dept_ifta_year_hijri' => $validated['dept_ifta_year_hijri'] ?? null,
            'dept_hifz_year_english' => $validated['dept_hifz_year_english'] ?? null,
            'dept_hifz_year_hijri' => $validated['dept_hifz_year_hijri'] ?? null,
            'dept_qirat_year_english' => $validated['dept_qirat_year_english'] ?? null,
            'dept_qirat_year_hijri' => $validated['dept_qirat_year_hijri'] ?? null,
            'dept_adab_year_english' => $validated['dept_adab_year_english'] ?? null,
            'dept_adab_year_hijri' => $validated['dept_adab_year_hijri'] ?? null,
            'dept_other_class' => $validated['dept_other_class'] ?? null,
            'examType' => $validated['examType'] ?? null,
            'rollNumber' => $validated['rollNumber'] ?? null,
            'workplace' => $validated['workplace'] ?? null,
            'idType' => $validated['idType'] ?? null,
            'birthCertificate' => $validated['birthCertificate'] ?? null,
            'voterId' => $validated['voterId'] ?? null,
            'passport_id' => $validated['passport_id'] ?? null,
        ];

        if ($request->hasFile('birthCertificatePhoto')) {
            $data['birthCertificatePhoto'] = $request->file('birthCertificatePhoto')->store('user-documents', 'public');
        }
        if ($request->hasFile('voterIdPhoto')) {
            $data['voterIdPhoto'] = $request->file('voterIdPhoto')->store('user-documents', 'public');
        }
        if ($request->hasFile('passport_photo')) {
            $data['passport_photo'] = $request->file('passport_photo')->store('user-documents', 'public');
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('user-photos', 'public');
        }

        UserInformation::create($data);
    }
}