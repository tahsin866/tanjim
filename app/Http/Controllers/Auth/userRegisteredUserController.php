<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class userRegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    public function store(Request $request): RedirectResponse
    {
        // Base validation rules
        $rules = [
            'fullNameBangla' => 'required|string|max:255',
            'fullNameEnglish' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phoneNumber' => 'required|string|max:15|regex:/^01[3-9]\d{8}$/|unique:users,phoneNumber',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alternatePhoneNumber' => 'nullable|string|max:15',
            'dateOfBirth' => 'required|date',
            'bloodGroup' => 'nullable|string|max:255',
            'address' => 'required|string',
            'division' => 'required|integer',
            'district' => 'required|integer',
            'thana' => 'required|integer',
            'classmate1' => 'nullable|string|max:255',
            'classmate2' => 'nullable|string|max:255',
            'classmate3' => 'nullable|string|max:255',
            'dept_takmil' => 'boolean',
            'dept_ifta' => 'boolean',
            'dept_hifz' => 'boolean',
            'dept_qirat' => 'boolean',
            'dept_other' => 'boolean',
            'dept_takmil_year_english' => 'nullable|string|max:255',
            'dept_takmil_year_hijri' => 'nullable|string|max:255',
            'dept_ifta_year_english' => 'nullable|string|max:255',
            'dept_ifta_year_hijri' => 'nullable|string|max:255',
            'dept_hifz_year_english' => 'nullable|string|max:255',
            'dept_hifz_year_hijri' => 'nullable|string|max:255',
            'dept_qirat_year_english' => 'nullable|string|max:255',
            'dept_qirat_year_hijri' => 'nullable|string|max:255',
            'dept_other_class' => 'nullable|string|max:255',
            'examType' => 'required|string|max:255',
            'workplace' => 'nullable|string|max:255',
            'idType' => 'required|string|in:birth,voter,passport',
            'birthCertificate' => 'nullable|string|max:255',
            'voterId' => 'nullable|string|max:255',
            'passport_id' => 'nullable|string|max:100',
            'birthCertificatePhoto' => 'nullable|file|image|max:2048',
            'voterIdPhoto' => 'nullable|file|image|max:2048',
            'passport_photo' => 'nullable|file|image|max:2048',
            'photo' => 'nullable|file|image|max:2048', // not required anymore
        ];

        // Conditional validation for rollNumber
        // Only required if examType is not "জানা নেই"
        if ($request->examType && $request->examType !== 'জানা নেই') {
            $rules['rollNumber'] = 'required|string|max:255';
        } else {
            $rules['rollNumber'] = 'nullable|string|max:255';
        }

        // Conditional validation for passport_id and passport_photo
        if ($request->idType === 'passport') {
            $rules['passport_id'] = 'required|string|max:100';
            $rules['passport_photo'] = 'required|file|image|max:2048';
        }

        // Custom validation messages
        $messages = [
            'rollNumber.required' => 'রোল নাম্বার প্রয়োজন যখন পরীক্ষার ধরন "জানা নেই" নয়।',
            'examType.required' => 'পরীক্ষার ধরন নির্বাচন করুন।',
            'idType.required' => 'পরিচয়পত্রের ধরন নির্বাচন করুন।',
            'passport_id.required' => 'পাসপোর্ট নম্বর প্রয়োজন।',
            'passport_photo.required' => 'পাসপোর্টের ছবি প্রয়োজন।',
        ];

        $validatedData = $request->validate($rules, $messages);

        $user = User::create([
            'fullNameBangla' => $validatedData['fullNameBangla'],
            'fullNameEnglish' => $validatedData['fullNameEnglish'],
            'fatherName' => $validatedData['fatherName'],
            'email' => $validatedData['email'],
            'phoneNumber' => $validatedData['phoneNumber'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $this->createUserInformation($request, $user, $validatedData);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function createUserInformation(Request $request, User $user, array $validatedData)
    {
        $informationData = [
            'user_id' => $user->id,
            'alternatePhoneNumber' => $validatedData['alternatePhoneNumber'] ?? null,
            'dateOfBirth' => $validatedData['dateOfBirth'] ?? null,
            'bloodGroup' => $validatedData['bloodGroup'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'division_id' => $validatedData['division'] ?? null,
            'district_id' => $validatedData['district'] ?? null,
            'thana_id' => $validatedData['thana'] ?? null,
            'classmate1' => $validatedData['classmate1'] ?? null,
            'classmate2' => $validatedData['classmate2'] ?? null,
            'classmate3' => $validatedData['classmate3'] ?? null,
            'dept_takmil' => $validatedData['dept_takmil'] ?? false,
            'dept_ifta' => $validatedData['dept_ifta'] ?? false,
            'dept_hifz' => $validatedData['dept_hifz'] ?? false,
            'dept_qirat' => $validatedData['dept_qirat'] ?? false,
            'dept_other' => $validatedData['dept_other'] ?? false,
            'dept_takmil_year_english' => $validatedData['dept_takmil_year_english'] ?? null,
            'dept_takmil_year_hijri' => $validatedData['dept_takmil_year_hijri'] ?? null,
            'dept_ifta_year_english' => $validatedData['dept_ifta_year_english'] ?? null,
            'dept_ifta_year_hijri' => $validatedData['dept_ifta_year_hijri'] ?? null,
            'dept_hifz_year_english' => $validatedData['dept_hifz_year_english'] ?? null,
            'dept_hifz_year_hijri' => $validatedData['dept_hifz_year_hijri'] ?? null,
            'dept_qirat_year_english' => $validatedData['dept_qirat_year_english'] ?? null,
            'dept_qirat_year_hijri' => $validatedData['dept_qirat_year_hijri'] ?? null,

            'dept_other_class' => $validatedData['dept_other_class'] ?? null,
            'examType' => $validatedData['examType'] ?? null,
            'rollNumber' => $validatedData['rollNumber'] ?? null,
            'workplace' => $validatedData['workplace'] ?? null,
            'idType' => $validatedData['idType'] ?? null,
            'birthCertificate' => $validatedData['birthCertificate'] ?? null,
            'voterId' => $validatedData['voterId'] ?? null,
            'passport_id' => $validatedData['passport_id'] ?? null,
        ];

        if ($request->hasFile('birthCertificatePhoto')) {
            $informationData['birthCertificatePhoto'] = $request->file('birthCertificatePhoto')->store('user-documents', 'public');
        }

        if ($request->hasFile('voterIdPhoto')) {
            $informationData['voterIdPhoto'] = $request->file('voterIdPhoto')->store('user-documents', 'public');
        }

        if ($request->hasFile('passport_photo')) {
            $informationData['passport_photo'] = $request->file('passport_photo')->store('user-documents', 'public');
        }

        if ($request->hasFile('photo')) {
            $informationData['photo'] = $request->file('photo')->store('user-photos', 'public');
        }

        UserInformation::create($informationData);
    }
}
