<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { onMounted } from 'vue';
import { useBasicInfo } from '@/composables/useBasicInfo';

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

// Use the BasicInfo composable
const {
    divisions,
    districts,
    thanas,
    loading,
    selectedDay,
    selectedMonth,
    selectedYear,
    yearRange,
    availableDistricts,
    availableThanas,
    fieldValidation,
    getFieldErrorClass,
    getSelectErrorClass,
    getTextareaErrorClass,
    updateDateOfBirth,
    initialize
} = useBasicInfo(props);

// Initialize on mount
onMounted(async () => {
    await initialize();
});
</script>

<template>
    <div class="mb-16 animate-fade-in">
        <!-- Stylish header with icon and subtitle -->
      

        <!-- Form Sections -->
        <div class="space-y-8">
            <!-- Section 1: Basic Personal Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="bg-gray-50 dark:bg-gray-750 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        মূল পরিচয়
                    </h3>
                </div>
                <div class="p-6">
                    <!-- Names -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="relative group">
                            <InputLabel for="fullNameBangla" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="পূর্ণ নাম (বাংলা)*" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    id="fullNameBangla"
                                    type="text"
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow font-bangla dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    :class="[fieldValidation.fullNameBangla ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                    v-model="form.fullNameBangla"
                                    placeholder="বাংলায় পূর্ণ নাম লিখুন"
                                    required
                                />
                            </div>
                            <InputError class="mt-2" :message="fieldValidation.fullNameBangla" />
                        </div>
                        
                        <div class="relative group">
                            <InputLabel for="fullNameEnglish" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="পূর্ণ নাম (ইংরেজি)*" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    id="fullNameEnglish"
                                    type="text"
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    :class="[fieldValidation.fullNameEnglish ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                    v-model="form.fullNameEnglish"
                                    placeholder="Full Name in English"
                                    required
                                />
                            </div>
                            <InputError class="mt-2" :message="fieldValidation.fullNameEnglish" />
                        </div>
                    </div>

                    <!-- Father's name -->
                    <div class="relative group mb-6">
                        <InputLabel for="fatherName" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="পিতার নাম*" />
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                            </div>
                            <input
                                id="fatherName"
                                type="text"
                                class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow font-bangla dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                :class="[fieldValidation.fatherName ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                v-model="form.fatherName"
                                placeholder="পিতার নাম লিখুন"
                                required
                            />
                        </div>
                        <InputError class="mt-2" :message="fieldValidation.fatherName" />
                    </div>
                </div>
            </div>

            <!-- Section 2: Contact Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="bg-gray-50 dark:bg-gray-750 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        যোগাযোগের তথ্য
                    </h3>
                </div>
                <div class="p-6">
                    <!-- Email & Phone -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="relative group">
                            <InputLabel for="email" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="ইমেইল ঠিকানা*" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input
                                    id="email"
                                    type="email"
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow font-bangla dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    :class="[fieldValidation.email ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                    v-model="form.email"
                                    placeholder="ইমেইল ঠিকানা লিখুন"
                                    required
                                />
                            </div>
                            <InputError class="mt-2" :message="fieldValidation.email" />
                        </div>
                        
                        <div class="relative group">
                            <InputLabel for="phoneNumber" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="ফোন নাম্বার*" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <input
                                    id="phoneNumber"
                                    type="tel"
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow font-bangla dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    :class="[fieldValidation.phoneNumber ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                    v-model="form.phoneNumber"
                                    placeholder="মোবাইল নাম্বার লিখুন"
                                    required
                                />
                            </div>
                            <InputError class="mt-2" :message="fieldValidation.phoneNumber" />
                        </div>
                    </div>

                    <!-- Alternative Phone -->
                    <div class="relative group">
                        <InputLabel for="alternatePhoneNumber" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="বিকল্প ফোন নাম্বার/হোয়াটসঅ্যাপ/বিদেশি নাম্বার" />
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <input
                                id="alternatePhoneNumber"
                                type="tel"
                                class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow font-bangla dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                v-model="form.alternatePhoneNumber"
                                placeholder="বিকল্প ফোন নাম্বার (যদি থাকে)"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.alternatePhoneNumber" />
                    </div>
                </div>
            </div>

            <!-- Section 3: Personal Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="bg-gray-50 dark:bg-gray-750 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        ব্যক্তিগত বিবরণ
                    </h3>
                </div>
                <div class="p-6">
                    <!-- DOB & Blood Group -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <InputLabel for="dateOfBirth" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center mb-1.5" value="জন্মতারিখ*">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </InputLabel>

                            <!-- Mobile-friendly date picker with styled dropdowns -->
                            <div class="grid grid-cols-3 gap-3">
                                <div class="relative">
                                    <select
                                        v-model="selectedDay"
                                        @change="updateDateOfBirth"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 appearance-none pl-4 pr-8 py-2.5 font-bangla transition-shadow dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        :class="[fieldValidation.dateOfBirth ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                        required
                                    >
                                        <option value="">দিন</option>
                                        <option v-for="day in 31" :key="day" :value="day">{{ day }}</option>
                                    </select>
                                 
                                </div>

                                <div class="relative">
                                    <select
                                        v-model="selectedMonth"
                                        @change="updateDateOfBirth"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 appearance-none pl-4 pr-8 py-2.5 font-bangla transition-shadow dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        :class="[fieldValidation.dateOfBirth ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                        required
                                    >
                                        <option value="">মাস</option>
                                        <option value="1">জানুয়ারি</option>
                                        <option value="2">ফেব্রুয়ারি</option>
                                        <option value="3">মার্চ</option>
                                        <option value="4">এপ্রিল</option>
                                        <option value="5">মে</option>
                                        <option value="6">জুন</option>
                                        <option value="7">জুলাই</option>
                                        <option value="8">আগস্ট</option>
                                        <option value="9">সেপ্টেম্বর</option>
                                        <option value="10">অক্টোবর</option>
                                        <option value="11">নভেম্বর</option>
                                        <option value="12">ডিসেম্বর</option>
                                    </select>
                                  
                                </div>

                                <div class="relative">
                                    <select
                                        v-model="selectedYear"
                                        @change="updateDateOfBirth"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 appearance-none pl-4 pr-8 py-2.5 font-bangla transition-shadow dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        :class="[fieldValidation.dateOfBirth ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                        required
                                    >
                                        <option value="">বছর</option>
                                        <option v-for="year in yearRange" :key="year" :value="year">{{ year }}</option>
                                    </select>
                                 
                                </div>
                            </div>

                            <InputError class="mt-2" :message="fieldValidation.dateOfBirth" />
                        </div>
                        
                        <div>
                            <InputLabel for="bloodGroup" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center mb-1.5" value="ব্লাড গ্রুপ">
                         
                            </InputLabel>
                            <div class="relative">
                                <select
                                    id="bloodGroup"
                                    v-model="form.bloodGroup"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 appearance-none pl-4 pr-8 py-2.5 font-bangla transition-shadow dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                    <option value="">ব্লাড গ্রুপ নির্বাচন করুন</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="unknown">জানা নেই</option>
                                </select>
                             
                            </div>
                            <InputError class="mt-2" :message="form.errors.bloodGroup" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Address Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="bg-gray-50 dark:bg-gray-750 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                   
                        ঠিকানা
                    </h3>
                </div>
                <div class="p-6">
                    <!-- Detail Address -->
                    <div class="relative group mb-6">
                        <InputLabel for="address" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="বিস্তারিত ঠিকানা*" />
                        <div class="mt-1 relative">
                            <textarea
                                id="address"
                                v-model="form.address"
                                placeholder="গ্রাম/মহল্লা, ওয়ার্ড নং, ইত্যাদি"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow font-bangla dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                :class="[fieldValidation.address ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                rows="3"
                                required
                            ></textarea>
                        </div>
                        <InputError class="mt-2" :message="fieldValidation.address" />
                    </div>

                    <!-- Division, District, Thana -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        <div>
                            <InputLabel for="division" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center mb-1.5" value="বিভাগ*" />
                            <div class="relative">
                                <select
                                    id="division"
                                    v-model="form.division"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 appearance-none pl-4 pr-8 py-2.5 font-bangla transition-shadow dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    :class="[fieldValidation.division ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                    required
                                    :disabled="loading"
                                >
                                    <option value="">বিভাগ নির্বাচন করুন</option>
                                    <option v-for="division in divisions" :key="division.id" :value="division.id">
                                        {{ division.Division }}
                                    </option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg v-if="loading" class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l-3-2.647z"></path>
                                    </svg>
                            
                                </div>
                            </div>
                            <InputError class="mt-2" :message="fieldValidation.division" />
                        </div>

                        <div>
                            <InputLabel for="district" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center mb-1.5" value="জেলা*" />
                            <div class="relative">
                                <select
                                    id="district"
                                    v-model="form.district"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 appearance-none pl-4 pr-8 py-2.5 font-bangla transition-shadow dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    :class="[fieldValidation.district ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                    :disabled="!form.division || loading"
                                    required
                                >
                                    <option value="">জেলা নির্বাচন করুন</option>
                                    <option v-for="district in availableDistricts" :key="district.DesID" :value="district.DesID">
                                        {{ district.District }}
                                    </option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg v-if="loading" class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l-3-2.647z"></path>
                                    </svg>
                                  
                                </div>
                            </div>
                            <InputError class="mt-2" :message="fieldValidation.district" />
                        </div>

                        <div>
                            <InputLabel for="thana" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center mb-1.5" value="থানা/উপজেলা*" />
                            <div class="relative">
                                <select
                                    id="thana"
                                    v-model="form.thana"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 appearance-none pl-4 pr-8 py-2.5 font-bangla transition-shadow dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    :class="[fieldValidation.thana ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '']"
                                    :disabled="!form.district || loading"
                                    required
                                >
                                    <option value="">থানা নির্বাচন করুন</option>
                                    <option v-for="thana in availableThanas" :key="thana.Thana_ID" :value="thana.Thana_ID">
                                        {{ thana.Thana }}
                                    </option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg v-if="loading" class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l-3-2.647z"></path>
                                    </svg>
                            
                                </div>
                            </div>
                            <InputError class="mt-2" :message="fieldValidation.thana" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 5: Classmates Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="bg-gray-50 dark:bg-gray-750 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        সাথী ভাইয়ের তথ্য
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6 border border-blue-100 dark:border-blue-800/30">
                        <p class="text-blue-700 dark:text-blue-300 text-sm font-bangla flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
 জামাতের পরিচিত/প্রসিদ্ধ ৩জন সাথী ভাইয়ের নাম (বাধ্যতামুলক)
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative group">
                            <InputLabel for="classmate1" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="প্রথম সাথী ভাইয়ের নাম*" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    id="classmate1"
                                    type="text"
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow font-bangla dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    v-model="form.classmate1"
                                    placeholder="প্রথম সাথী ভাইয়ের নাম লিখুন"
                                />
                            </div>
                        </div>

                        <div class="relative group">
                            <InputLabel for="classmate2" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="দ্বিতীয় সাথী ভাইয়ের নাম*" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    id="classmate2"
                                    type="text"
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow font-bangla dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    v-model="form.classmate2"
                                    placeholder="দ্বিতীয় সাথী ভাইয়ের নাম লিখুন"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="relative group">
                            <InputLabel for="classmate3" class="text-base font-medium text-gray-700 dark:text-gray-300 flex items-center" value="তৃতীয় সাথী ভাইয়ের নাম*" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    id="classmate3"
                                    type="text"
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-shadow font-bangla dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    v-model="form.classmate3"
                                    placeholder="তৃতীয় সাথী ভাইয়ের নাম লিখুন"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.font-bangla {
    font-family: 'SolaimanLipi', 'Noto Sans Bengali', sans-serif;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

/* Custom style for group focus effects */
.group:focus-within .group-focus-within\:text-blue-500 {
    color: #3b82f6;
}

/* Dark mode styling for certain backgrounds */
.dark .dark\:bg-gray-750 {
    background-color: rgba(31, 41, 55, 0.5);
}
</style>