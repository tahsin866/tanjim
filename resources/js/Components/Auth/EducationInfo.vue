<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import MultiSelectWorkplace from '@/Components/Auth/MultiSelectWorkplace.vue';
import { onMounted } from 'vue';
import { useEducationInfo } from '@/composables/useEducationInfo';

// Props
const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    validationErrors: {
        type: Object,
        default: () => ({})
    },
    hasAttemptedValidation: {
        type: Boolean,
        default: false
    }
});

// Use the EducationInfo composable
const {
    sessionYears,
    loading,
    error,
    workplaceArray,
    englishYearOptions,
    hijriYearOptions,
    fieldValidation,
    getFieldErrorClass,
    getFileErrorClass,
    handleEnglishYearChange,
    handleHijriYearChange,
    handlePhotoUpload,
    handleIdPhotoUpload,
    getUploadedFileName,
    initialize
} = useEducationInfo(props);

// Initialize on mount
onMounted(async () => {
    await initialize();
});
</script>
<template>
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6 border-b pb-2">শিক্ষাগত তথ্য</h3>

        <!-- বিভাগ সেকশন -->
        <div class="mb-6">
            <InputLabel class="text-lg font-medium mb-3 dark:text-white"
                value="শিক্ষা বিভাগ (একাধিক নির্বাচন করা যাবে)" />

            <!-- Loading indicator -->
            <div v-if="loading"
                class="mb-4 p-3 bg-blue-50 dark:bg-gray-800 border border-blue-200 dark:border-gray-700 rounded-md">
                <div class="flex items-center text-blue-700 dark:text-blue-300">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    সন তথ্য লোড হচ্ছে...
                </div>
            </div>

            <!-- Error message -->
            <div v-else-if="error"
                class="mb-4 p-3 bg-red-50 dark:bg-gray-800 border border-red-200 dark:border-red-700 rounded-md">
                <div class="flex items-center text-red-700 dark:text-red-300">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ error }}
                </div>
            </div>


     <!-- হিফজ -->
            <div class="border rounded-lg p-4 mb-4 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center mb-3">
                    <input id="hifz" v-model="form.dept_hifz" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800" />
                    <label for="hifz" class="text-sm font-medium text-gray-700 dark:text-gray-200">হিফজ</label>
                </div>
                <div v-if="form.dept_hifz" class="grid grid-cols-2 gap-4 ml-6">
                    <div>
                        <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (ইংরেজি)" />
                        <select v-model="form.dept_hifz_year_english"
                            @change="handleEnglishYearChange(form.dept_hifz_year_english, 'hifz')"
                            :class="[getFieldErrorClass('dept_hifz_year_english'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                            :disabled="loading">
                            <option value="">সন নির্বাচন করুন</option>
                            <option v-for="year in englishYearOptions" :key="year.value" :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_hifz_year_english" />
                    </div>
                    <div>
                        <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (হিজরি)" />
                        <select v-model="form.dept_hifz_year_hijri"
                            @change="handleHijriYearChange(form.dept_hifz_year_hijri, 'hifz')"
                            :class="[getFieldErrorClass('dept_hifz_year_hijri'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                            :disabled="loading">
                            <option value="">হিজরি সন নির্বাচন করুন</option>
                            <option v-for="year in hijriYearOptions" :key="year.value" :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_hifz_year_hijri" />
                    </div>
                </div>
            </div>

            <!-- তাকমিল -->
            <div class="border rounded-lg p-4 mb-4 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center mb-3">
                    <input id="takamil" v-model="form.dept_takmil" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800" />
                    <label for="takamil" class="text-sm font-medium text-gray-700 dark:text-gray-200">তাকমিল</label>
                </div>
                <div v-if="form.dept_takmil" class="ml-6">
                    <!-- Helpful hint -->
                    <div
                        class="mb-3 p-2 bg-blue-50 dark:bg-gray-800 border border-blue-200 dark:border-gray-700 rounded text-xs text-blue-700 dark:text-blue-300">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        টিপস: ইংরেজি সন নির্বাচন করলে হিজরি সন স্বয়ংক্রিয়ভাবে আপডেট হবে এবং বিপরীতভাবেও।
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (ইংরেজি)" />
                            <select v-model="form.dept_takmil_year_english"
                                @change="handleEnglishYearChange(form.dept_takmil_year_english, 'takmil')"
                                :class="[getFieldErrorClass('dept_takmil_year_english'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                                :disabled="loading">
                                <option value="">সন নির্বাচন করুন</option>
                                <option v-for="year in englishYearOptions" :key="year.value" :value="year.value">
                                    {{ year.label }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="fieldValidation.dept_takmil_year_english" />
                        </div>
                        <div>
                            <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (হিজরি)" />
                            <select v-model="form.dept_takmil_year_hijri"
                                @change="handleHijriYearChange(form.dept_takmil_year_hijri, 'takmil')"
                                :class="[getFieldErrorClass('dept_takmil_year_hijri'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                                :disabled="loading">
                                <option value="">হিজরি সন নির্বাচন করুন</option>
                                <option v-for="year in hijriYearOptions" :key="year.value" :value="year.value">
                                    {{ year.label }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="fieldValidation.dept_takmil_year_hijri" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- ইফতা -->
            <div class="border rounded-lg p-4 mb-4 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center mb-3">
                    <input id="ifta" v-model="form.dept_ifta" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800" />
                    <label for="ifta" class="text-sm font-medium text-gray-700 dark:text-gray-200">ইফতা</label>
                </div>
                <div v-if="form.dept_ifta" class="grid grid-cols-2 gap-4 ml-6">
                    <div>
                        <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (ইংরেজি)" />
                        <select v-model="form.dept_ifta_year_english"
                            @change="handleEnglishYearChange(form.dept_ifta_year_english, 'ifta')"
                            :class="[getFieldErrorClass('dept_ifta_year_english'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                            :disabled="loading">
                            <option value="">সন নির্বাচন করুন</option>
                            <option v-for="year in englishYearOptions" :key="year.value" :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_ifta_year_english" />
                    </div>
                    <div>
                        <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (হিজরি)" />
                        <select v-model="form.dept_ifta_year_hijri"
                            @change="handleHijriYearChange(form.dept_ifta_year_hijri, 'ifta')"
                            :class="[getFieldErrorClass('dept_ifta_year_hijri'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                            :disabled="loading">
                            <option value="">হিজরি সন নির্বাচন করুন</option>
                            <option v-for="year in hijriYearOptions" :key="year.value" :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_ifta_year_hijri" />
                    </div>
                </div>
            </div>

       

            <!-- কিরাআত -->
            <div class="border rounded-lg p-4 mb-4 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center mb-3">
                    <input id="qirat" v-model="form.dept_qirat" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800" />
                    <label for="qirat" class="text-sm font-medium text-gray-700 dark:text-gray-200">কিরাআত</label>
                </div>
                <div v-if="form.dept_qirat" class="grid grid-cols-2 gap-4 ml-6">
                    <div>
                        <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (ইংরেজি)" />
                        <select v-model="form.dept_qirat_year_english"
                            @change="handleEnglishYearChange(form.dept_qirat_year_english, 'qirat')"
                            :class="[getFieldErrorClass('dept_qirat_year_english'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                            :disabled="loading">
                            <option value="">সন নির্বাচন করুন</option>
                            <option v-for="year in englishYearOptions" :key="year.value" :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_qirat_year_english" />
                    </div>
                    <div>
                        <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (হিজরি)" />
                        <select v-model="form.dept_qirat_year_hijri"
                            @change="handleHijriYearChange(form.dept_qirat_year_hijri, 'qirat')"
                            :class="[getFieldErrorClass('dept_qirat_year_hijri'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                            :disabled="loading">
                            <option value="">হিজরি সন নির্বাচন করুন</option>
                            <option v-for="year in hijriYearOptions" :key="year.value" :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_qirat_year_hijri" />
                    </div>
                </div>
            </div>

            <!-- আদব -->
            <div class="border rounded-lg p-4 mb-4 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center mb-3">
                    <input id="adab" v-model="form.dept_adab" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800" />
                    <label for="adab" class="text-sm font-medium text-gray-700 dark:text-gray-200">আদব</label>
                </div>
                <div v-if="form.dept_adab" class="grid grid-cols-2 gap-4 ml-6">
                    <div>
                        <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (ইংরেজি)" />
                        <select v-model="form.dept_adab_year_english"
                            @change="handleEnglishYearChange(form.dept_adab_year_english, 'adab')"
                            :class="[getFieldErrorClass('dept_adab_year_english'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                            :disabled="loading">
                            <option value="">সন নির্বাচন করুন</option>
                            <option v-for="year in englishYearOptions" :key="year.value" :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_adab_year_english" />
                    </div>
                    <div>
                        <InputLabel class="text-sm font-medium dark:text-gray-200" value="ফারাগাতের সন (হিজরি)" />
                        <select v-model="form.dept_adab_year_hijri"
                            @change="handleHijriYearChange(form.dept_adab_year_hijri, 'adab')"
                            :class="[getFieldErrorClass('dept_adab_year_hijri'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                            :disabled="loading">
                            <option value="">হিজরি সন নির্বাচন করুন</option>
                            <option v-for="year in hijriYearOptions" :key="year.value" :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_adab_year_hijri" />
                    </div>
                </div>
            </div>

            <!-- অন্যান্য বিভাগ (শুধু কোন ক্লাসে পড়েন) -->
            <div class="border rounded-lg p-4 mb-4 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center mb-3">
                    <input id="other" v-model="form.dept_other" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800" />
                    <label for="other" class="text-sm font-medium text-gray-700 dark:text-gray-200">অন্যান্য</label>
                </div>
                <div v-if="form.dept_other" class="ml-6">
                    <InputLabel class="text-sm font-medium dark:text-gray-200" value="কোন সেকশনে পড়েন?" />
                    <select v-model="form.dept_other_class"
                        :class="[getFieldErrorClass('dept_other_class'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                        required>
                        <option value="">নির্বাচন করুন</option>
                        <option value="জামিয়ার উস্তাদ">জামিয়ার উস্তাদ</option>
                        <option value="জামিয়ার কৃতসন্তান">জামিয়ার কৃতসন্তান</option>
                        <option value="বিদেশী মেহমান">বিদেশী মেহমান</option>
                        <option value="এজাযী হিতাকঙ্খী">এজাযী হিতাকঙ্খী</option>
                        <option value="মরণোত্তর">মরণোত্তর</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.dept_other_class" />
                </div>
            </div>

            <!-- Department validation error -->
            <div v-if="fieldValidation.departments"
                class="mt-4 p-3 bg-red-50 dark:bg-gray-800 border border-red-200 dark:border-red-700 rounded-md">
                <div class="flex items-center text-red-700 dark:text-red-300">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ fieldValidation.departments }}
                </div>
            </div>
        </div>

        <!-- পরীক্ষার ধরন -->
        <div class="mb-6">
            <InputLabel for="examType" class="text-lg font-medium dark:text-white" value="আইডির ধরন" />
            <select id="examType" v-model="form.examType"
                :class="[getFieldErrorClass('examType'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                required>
              
                <option value="দাখিলা">ফরিদাবাদের দাখিলা (জামাতের জিম্মাদার/নোটিশ বোর্ড থেকে আপনার বর্ষের PDF ফাইল দেখে নিন)</option>
                <option value="হাইয়ার">হাইয়ার (রোল নম্বর)</option>
                <option value="বেফাক">বেফাক (রোল নম্বর)</option>
                <option value="জানা নেই">জানা নেই (এক্ষেত্রে আপনার নিবন্ধন প্রক্রিয়া বিলম্বিত/স্থগিত হবে।)</option>
            </select>
            <InputError class="mt-2" :message="fieldValidation.examType" />
        </div>

        <!-- রোল নাম্বার (শুধুমাত্র examType সিলেক্ট করা হলে এবং "জানা নেই" না হলে দেখাবে) -->
        <div v-if="form.examType && form.examType !== 'জানা নেই'" class="mb-6">
            <InputLabel for="rollNumber" class="text-lg font-medium dark:text-white" value="রোল নাম্বার" />
            <input id="rollNumber" type="text"
                :class="[getFieldErrorClass('rollNumber'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                v-model="form.rollNumber" placeholder="রোল নাম্বার প্রবেশ করুন" required />
            <InputError class="mt-2" :message="fieldValidation.rollNumber" />
        </div>

        <!-- কর্মস্থল/পেশা (মাল্টিপল সিলেকশন) -->
        <div class="mb-6">
            <InputLabel for="workplace" class="text-lg font-medium dark:text-white" value="কর্মস্থল/পেশা (একাধিক নির্বাচন করা যাবে)" />
            <MultiSelectWorkplace v-model="workplaceArray" />
            <InputError class="mt-2" :message="fieldValidation.workplace" />
        </div>

        <!-- পরিচয়পত্র টাইপ নির্বাচন (জন্মসনদ/ভোটার আইডি) -->
        <div class="mb-6">
            <InputLabel for="idType" class="text-lg font-medium dark:text-white" value="পরিচয়পত্র টাইপ" />
            <select id="idType" v-model="form.idType"
                :class="[getFieldErrorClass('idType'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                required>
                <option value="">নির্বাচন করুন</option>
                <option value="birth">জন্মসনদ</option>
                <option value="voter">ভোটার আইডি</option>
                <option value="passport">পাসপোর্ট</option>
            </select>
            <InputError class="mt-2" :message="fieldValidation.idType" />
        </div>

        <!-- জন্মনিবন্ধন নম্বর ও ছবি -->
        <div v-if="form.idType === 'birth'" class="mb-6">
            <InputLabel for="birthCertificate" class="text-lg font-medium dark:text-white" value="জন্মনিবন্ধন নম্বর" />
            <input id="birthCertificate" type="text"
                :class="[getFieldErrorClass('birthCertificate'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                v-model="form.birthCertificate" placeholder="জন্মনিবন্ধন নম্বর লিখুন (১৭ সংখ্যা)" 
                pattern="[0-9]{17}" minlength="17" maxlength="17" />
            <InputError class="mt-2" :message="fieldValidation.birthCertificate" />
            <!-- জন্মনিবন্ধন ছবির আপলোড -->
            <div class="mt-3">
                <InputLabel for="birthCertificatePhoto" class="text-lg font-medium dark:text-white"
                    value="জন্মনিবন্ধন কার্ড/সার্টিফিকেটের ছবি (২০০ কেবি'র নিচে)" />
                
                <!-- Styled Upload Button -->
                <div class="relative">
                    <input id="birthCertificatePhoto" type="file" accept="image/*" @change="handleIdPhotoUpload"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                    <div :class="[
                        'flex items-center justify-center w-full h-20 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300',
                        getFileErrorClass('birthCertificatePhoto') ? 'border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30' :
                        'border-indigo-300 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 hover:border-indigo-400 dark:hover:border-indigo-600'
                    ]">
                        <div class="flex flex-col items-center">
                            <!-- Upload Icon -->
                            <svg class="w-8 h-8 text-indigo-500 dark:text-indigo-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                জন্মনিবন্ধন ছবি আপলোড করুন
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                ক্লিক করুন অথবা ফাইল টেনে আনুন
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
                </div>
                
                <!-- Success Message -->
                <div v-if="getUploadedFileName('birth_cert_photo')"
                    class="mt-2 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                    <div class="flex items-center text-sm text-green-700 dark:text-green-300">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">সফলভাবে আপলোড হয়েছে:</span>
                        <span class="ml-1">{{ getUploadedFileName('birth_cert_photo') }}</span>
                    </div>
                </div>
                <InputError class="mt-2" :message="fieldValidation.birthCertificatePhoto" />
            </div>
        </div>
        <!-- ভোটার আইডি নম্বর ও ছবি -->
        <div v-if="form.idType === 'voter'" class="mb-6">
            <InputLabel for="voterId" class="text-lg font-medium dark:text-white" value="ভোটার আইডি নম্বর" />
            <input id="voterId" type="text"
                :class="[getFieldErrorClass('voterId'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                v-model="form.voterId" placeholder="ভোটার আইডি নম্বর লিখুন (১০ বা ১৭ সংখ্যা)" />
            <InputError class="mt-2" :message="fieldValidation.voterId" />
            <div class="mt-3">
                <InputLabel for="voterIdPhoto" class="text-lg font-medium dark:text-white"
                    value="ভোটার আইডি কার্ডের ছবি (২০০ কেবি'র নিচে)" />
                
                <!-- Styled Upload Button -->
                <div class="relative">
                    <input id="voterIdPhoto" type="file" accept="image/*" @change="handleIdPhotoUpload"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                    <div :class="[
                        'flex items-center justify-center w-full h-20 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300',
                        getFileErrorClass('voterIdPhoto') ? 'border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30' :
                        'border-purple-300 dark:border-purple-700 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 hover:border-purple-400 dark:hover:border-purple-600'
                    ]">
                        <div class="flex flex-col items-center">
                            <!-- Vote Card Icon -->
                            <svg class="w-8 h-8 text-purple-500 dark:text-purple-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            <span class="text-sm font-medium text-purple-600 dark:text-purple-400">
                                ভোটার আইডি ছবি আপলোড করুন
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                ক্লিক করুন অথবা ফাইল টেনে আনুন
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
                </div>
                
                <!-- Success Message -->
                <div v-if="getUploadedFileName('voter_photo')"
                    class="mt-2 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                    <div class="flex items-center text-sm text-green-700 dark:text-green-300">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">সফলভাবে আপলোড হয়েছে:</span>
                        <span class="ml-1">{{ getUploadedFileName('voter_photo') }}</span>
                    </div>
                </div>
                <InputError class="mt-2" :message="fieldValidation.voterIdPhoto" />
            </div>
        </div>

        <!-- পাসপোর্ট নম্বর ও ছবি -->
        <div v-if="form.idType === 'passport'" class="mb-6">
            <InputLabel for="passport_id" class="text-lg font-medium dark:text-white" value="পাসপোর্ট নম্বর" />
            <input id="passport_id" type="text"
                :class="[getFieldErrorClass('passport_id'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                v-model="form.passport_id" placeholder="পাসপোর্ট নম্বর লিখুন" />
            <InputError class="mt-2" :message="fieldValidation.passport_id" />
            <div class="mt-3">
                <InputLabel for="passport_photo" class="text-lg font-medium dark:text-white"
                    value="পাসপোর্টের ছবি (২০০ কেবি'র নিচে)" />
                
                <!-- Styled Upload Button -->
                <div class="relative">
                    <input id="passport_photo" type="file" accept="image/*" @change="handleIdPhotoUpload"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                    <div :class="[
                        'flex items-center justify-center w-full h-20 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300',
                        getFileErrorClass('passport_photo') ? 'border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30' :
                        'border-blue-300 dark:border-blue-700 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:border-blue-400 dark:hover:border-blue-600'
                    ]">
                        <div class="flex flex-col items-center">
                            <!-- Passport Icon -->
                            <svg class="w-8 h-8 text-blue-500 dark:text-blue-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                পাসপোর্ট ছবি আপলোড করুন
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                ক্লিক করুন অথবা ফাইল টেনে আনুন
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
                </div>
                
                <!-- Success Message -->
                <div v-if="getUploadedFileName('passport_photo')"
                    class="mt-2 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                    <div class="flex items-center text-sm text-green-700 dark:text-green-300">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">সফলভাবে আপলোড হয়েছে:</span>
                        <span class="ml-1">{{ getUploadedFileName('passport_photo') }}</span>
                    </div>
                </div>
                <InputError class="mt-2" :message="fieldValidation.passport_photo" />
            </div>
        </div>

        <!-- ছবি আপলোড -->
        <div v-if="form.idType && form.idType !== 'জানা নেই'" class="mb-6">
            <InputLabel for="photo" class="text-lg font-medium dark:text-white"
                value="ছবি আপলোড করুন (২০০ কেবি'র নিচে)" />
            
            <!-- Styled Upload Button -->
            <div class="relative">
                <input id="photo" type="file" accept="image/*" @change="handlePhotoUpload"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                <div :class="[
                    'flex items-center justify-center w-full h-20 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300',
                    getFileErrorClass('photo') ? 'border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30' :
                    'border-green-300 dark:border-green-700 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 hover:border-green-400 dark:hover:border-green-600'
                ]">
                    <div class="flex flex-col items-center">
                        <!-- User Photo Icon -->
                        <svg class="w-8 h-8 text-green-500 dark:text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">
                            আপনার ছবি আপলোড করুন
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            ক্লিক করুন অথবা ফাইল টেনে আনুন
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
            </div>
            
            <!-- Success Message -->
            <div v-if="getUploadedFileName('photo')"
                class="mt-2 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                <div class="flex items-center text-sm text-green-700 dark:text-green-300">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">সফলভাবে আপলোড হয়েছে:</span>
                    <span class="ml-1">{{ getUploadedFileName('photo') }}</span>
                </div>
            </div>

            <InputError class="mt-2" :message="fieldValidation.photo" />
        </div>
    </div>
</template>
