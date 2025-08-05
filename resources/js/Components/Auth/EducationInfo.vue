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
                        <option value="উলুমুল হাদিস">উলুমুল হাদিস</option>
                        <option value="ইফতা">ইফতা</option>
                        <option value="আদব">আদব</option>
                        <option value="তাকমিল (দাওরা)">তাকমিল (দাওরা)</option>
                        <option value="ফযিলত (মেশাকাত)">ফযিলত (মেশাকাত)</option>
                        <option value="জালালাইন">জালালাইন</option>
                        <option value="হেদায়া">হেদায়া</option>
                        <option value="শরহে বেকায়া">শরহে বেকায়া</option>
                        <option value="কাফিয়া">কাফিয়া</option>
                        <option value="হেদায়াতুন্নাহু">হেদায়াতুন্নাহু</option>
                        <option value="নাহুমির">নাহুমির</option>
                        <option value="মিযান">মিযান</option>
                        <option value="খুসুসী">খুসুসী</option>
                        <option value="তাইসীর">তাইসীর</option>
                        <option value="হিফজ">হিফজ</option>
                        <option value="কিরআত">কিরআত</option>
                        <option value="অন্যান্য">অন্যান্য</option>
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
            </select>
            <InputError class="mt-2" :message="fieldValidation.idType" />
        </div>

        <!-- জন্মনিবন্ধন নম্বর ও ছবি -->
        <div v-if="form.idType === 'birth'" class="mb-6">
            <InputLabel for="birthCertificate" class="text-lg font-medium dark:text-white" value="জন্মনিবন্ধন নম্বর" />
            <input id="birthCertificate" type="text"
                :class="[getFieldErrorClass('birthCertificate'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']"
                v-model="form.birthCertificate" placeholder="জন্মনিবন্ধন নম্বর লিখুন" />
            <InputError class="mt-2" :message="fieldValidation.birthCertificate" />
            <!-- জন্মনিবন্ধন ছবির আপলোড -->
            <div class="mt-3">
                <InputLabel for="birthCertificatePhoto" class="text-lg font-medium dark:text-white"
                    value="জন্মনিবন্ধন কার্ড/সার্টিফিকেটের ছবি (২০০ কেবি'র নিচে)" />
                <input id="birthCertificatePhoto" type="file" accept="image/*" @change="handleIdPhotoUpload"
                    :class="[getFileErrorClass('birthCertificatePhoto'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']" />

                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
                </div>
                <div v-if="getUploadedFileName('birth_cert_photo')"
                    class="mt-2 p-2 bg-green-50 dark:bg-gray-800 border border-green-200 dark:border-green-700 rounded-md">
                    <div class="flex items-center text-sm text-green-700 dark:text-green-300">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        পূর্বে আপলোড করা ফাইল: {{ getUploadedFileName('birth_cert_photo') }}
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
                v-model="form.voterId" placeholder="ভোটার আইডি নম্বর লিখুন" />
            <InputError class="mt-2" :message="fieldValidation.voterId" />
            <div class="mt-3">
                <InputLabel for="voterIdPhoto" class="text-lg font-medium dark:text-white"
                    value="ভোটার আইডি কার্ডের ছবি (২০০ কেবি'র নিচে)" />
                <input id="voterIdPhoto" type="file" accept="image/*" @change="handleIdPhotoUpload"
                    :class="[getFileErrorClass('voterIdPhoto'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']" />

                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
                </div>
                <div v-if="getUploadedFileName('voter_photo')"
                    class="mt-2 p-2 bg-green-50 dark:bg-gray-800 border border-green-200 dark:border-green-700 rounded-md">
                    <div class="flex items-center text-sm text-green-700 dark:text-green-300">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        পূর্বে আপলোড করা ফাইল: {{ getUploadedFileName('voter_photo') }}
                    </div>
                </div>
                <InputError class="mt-2" :message="fieldValidation.voterIdPhoto" />
            </div>
        </div>

        <!-- ছবি আপলোড -->
        <div v-if="form.idType && form.idType !== 'জানা নেই'" class="mb-6">
            <InputLabel for="photo" class="text-lg font-medium dark:text-white"
                value="ছবি আপলোড করুন (২০০ কেবি'র নিচে)" />
            <input id="photo" type="file" accept="image/*" @change="handlePhotoUpload"
                :class="[getFileErrorClass('photo'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']" />

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
            </div>
            <div v-if="getUploadedFileName('photo')"
                class="mt-2 p-2 bg-green-50 dark:bg-gray-800 border border-green-200 dark:border-green-700 rounded-md">
                <div class="flex items-center text-sm text-green-700 dark:text-green-300">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    পূর্বে আপলোড করা ফাইল: {{ getUploadedFileName('photo') }}
                </div>
            </div>
            <InputError class="mt-2" :message="fieldValidation.photo" />
        </div>
    </div>
</template>
