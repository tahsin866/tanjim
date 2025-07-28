<template>
    <AuthenticatedLayout style="font-family: 'SolaimanLipi', sans-serif;">
        <div class="min-h-screen bg-[#f4f6f8] py-12 px-4">
            <div class=" mx-auto">
                <div class="bg-white rounded-lg shadow-md p-6 sm:p-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">শিক্ষার্থী সম্পাদনা করুন</h2>

                    <div class="p-fluid">
                        <div class="col-span-12">
                            <Fieldset legend="ব্যক্তিগত তথ্য" :toggleable="true" class="border border-gray-200 rounded-lg shadow-sm mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Photo Section -->
                                    <div class="field">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">ছবি</label>
                                        <div class="flex flex-col items-center">
                                            <div class="mb-3">
                                                <Avatar :image="photoPreview || getPhotoUrl(form.photo)"
                                                        size="xlarge"
                                                        shape="circle"
                                                        class="border-4 border-gray-200 shadow-md" />
                                            </div>
                                            <input type="file"
                                                   ref="photoInput"
                                                   @change="handlePhotoChange"
                                                   accept="image/*"
                                                   class="hidden" />
                                            <Button type="button"
                                                    @click="$refs.photoInput.click()"
                                                    class="p-button-sm p-button-outlined px-4 py-2 min-w-[160px]"
                                                    icon="pi pi-camera">
                                                ছবি পরিবর্তন করুন
                                            </Button>
                                            <small class="text-gray-500 mt-1">সর্বোচ্চ ২MB, JPG/PNG</small>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label for="fullNameBangla"
                                            class="block text-sm font-medium text-gray-700 mb-1">পুরো নাম (বাংলা)</label>
                                        <InputText id="fullNameBangla" v-model="form.fullNameBangla"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="field">
                                        <label for="fullNameEnglish"
                                            class="block text-sm font-medium text-gray-700 mb-1">পুরো নাম (ইংরেজি)</label>
                                        <InputText id="fullNameEnglish" v-model="form.fullNameEnglish"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="field">
                                        <label for="fatherName" class="block text-sm font-medium text-gray-700 mb-1">বাবার নাম</label>
                                        <InputText id="fatherName" v-model="form.fatherName"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="field">
                                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-1">ফোন নম্বর</label>
                                        <InputText id="phoneNumber" v-model="form.phoneNumber"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="field">
                                        <label for="alternatePhoneNumber" class="block text-sm font-medium text-gray-700 mb-1">বিকল্প ফোন নাম্বার</label>
                                        <InputText id="alternatePhoneNumber" v-model="form.alternatePhoneNumber"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="field">
                                        <label for="dateOfBirth" class="block text-sm font-medium text-gray-700 mb-1">জন্মতারিখ</label>
                                        <InputText id="dateOfBirth" v-model="form.dateOfBirth" type="date"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="field">
                                        <label for="bloodGroup" class="block text-sm font-medium text-gray-700 mb-1">ব্লাড গ্রুপ</label>
                                        <select id="bloodGroup" v-model="form.bloodGroup"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">ব্লাড গ্রুপ নির্বাচন করুন</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                    <div class="field md:col-span-3">
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700 mb-1">ঠিকানা</label>
                                        <InputText id="address" v-model="form.address"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>
                            </Fieldset>

                            <Fieldset legend="ঠিকানা তথ্য" :toggleable="true"
                                class="border border-gray-200 rounded-lg shadow-sm mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="field">
                                        <label for="division"
                                            class="block text-sm font-medium text-gray-700 mb-1">বিভাগ</label>
                                        <select id="division" v-model="form.division"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">বিভাগ নির্বাচন করুন</option>
                                            <option v-for="division in divisions" :key="division.id" :value="division.id">
                                                {{ division.division_name_bangla }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label for="district"
                                            class="block text-sm font-medium text-gray-700 mb-1">জেলা</label>
                                        <select id="district" v-model="form.district"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            :disabled="!form.division">
                                            <option value="">জেলা নির্বাচন করুন</option>
                                            <option v-for="district in filteredDistricts" :key="district.id"
                                                :value="district.id">
                                                {{ district.district_name_bangla }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label for="thana" class="block text-sm font-medium text-gray-700 mb-1">থানা</label>
                                        <select id="thana" v-model="form.thana"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            :disabled="!form.district">
                                            <option value="">থানা নির্বাচন করুন</option>
                                            <option v-for="thana in filteredThanas" :key="thana.id" :value="thana.id">
                                                {{ thana.thana_name_bangla }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </Fieldset>

                            <Fieldset legend="শিক্ষা বিভাগ" :toggleable="true"
                                class="border border-gray-200 rounded-lg shadow-sm mb-4">

                                <!-- Loading indicator -->
                                <div v-if="loading" class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                                    <div class="flex items-center text-blue-700">
                                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        সন তথ্য লোড হচ্ছে...
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Helpful hint -->
                                    <div class="md:col-span-2 mb-3 p-2 bg-blue-50 border border-blue-200 rounded text-xs text-blue-700">
                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        টিপস: ইংরেজি সন নির্বাচন করলে স্বয়ংক্রিয়ভাবে হিজরি সন নির্বাচিত হবে এবং বিপরীতভাবেও।
                                    </div>
                                    <!-- তাকমিল -->
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <input type="checkbox" id="dept_takmil" v-model="form.dept_takmil"
                                                class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="dept_takmil"
                                                class="text-sm font-medium text-gray-700">তাকমিল</label>
                                        </div>
                                        <div v-if="form.dept_takmil" class="grid grid-cols-2 gap-4 ml-6">
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">ইংরেজি বছর</label>
                                                <select
                                                    v-model="form.dept_takmil_year_english"
                                                    @change="handleEnglishYearChange(form.dept_takmil_year_english, 'takmil')"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    :disabled="loading">
                                                    <option value="">সন নির্বাচন করুন</option>
                                                    <option
                                                        v-for="year in englishYearOptions"
                                                        :key="year.value"
                                                        :value="year.value">
                                                        {{ year.label }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">হিজরি বছর</label>
                                                <select
                                                    v-model="form.dept_takmil_year_hijri"
                                                    @change="handleHijriYearChange(form.dept_takmil_year_hijri, 'takmil')"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    :disabled="loading">
                                                    <option value="">হিজরি সন নির্বাচন করুন</option>
                                                    <option
                                                        v-for="year in hijriYearOptions"
                                                        :key="year.value"
                                                        :value="year.value">
                                                        {{ year.label }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ইফতা -->
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <input type="checkbox" id="dept_ifta" v-model="form.dept_ifta"
                                                class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="dept_ifta" class="text-sm font-medium text-gray-700">ইফতা</label>
                                        </div>
                                        <div v-if="form.dept_ifta" class="grid grid-cols-2 gap-4 ml-6">
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">ইংরেজি বছর</label>
                                                <select
                                                    v-model="form.dept_ifta_year_english"
                                                    @change="handleEnglishYearChange(form.dept_ifta_year_english, 'ifta')"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    :disabled="loading">
                                                    <option value="">সন নির্বাচন করুন</option>
                                                    <option
                                                        v-for="year in englishYearOptions"
                                                        :key="year.value"
                                                        :value="year.value">
                                                        {{ year.label }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">হিজরি বছর</label>
                                                <select
                                                    v-model="form.dept_ifta_year_hijri"
                                                    @change="handleHijriYearChange(form.dept_ifta_year_hijri, 'ifta')"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    :disabled="loading">
                                                    <option value="">হিজরি সন নির্বাচন করুন</option>
                                                    <option
                                                        v-for="year in hijriYearOptions"
                                                        :key="year.value"
                                                        :value="year.value">
                                                        {{ year.label }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- হিফজ -->
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <input type="checkbox" id="dept_hifz" v-model="form.dept_hifz"
                                                class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="dept_hifz" class="text-sm font-medium text-gray-700">হিফজ</label>
                                        </div>
                                        <div v-if="form.dept_hifz" class="grid grid-cols-2 gap-4 ml-6">
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">ইংরেজি বছর</label>
                                                <select
                                                    v-model="form.dept_hifz_year_english"
                                                    @change="handleEnglishYearChange(form.dept_hifz_year_english, 'hifz')"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    :disabled="loading">
                                                    <option value="">সন নির্বাচন করুন</option>
                                                    <option
                                                        v-for="year in englishYearOptions"
                                                        :key="year.value"
                                                        :value="year.value">
                                                        {{ year.label }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">হিজরি বছর</label>
                                                <select
                                                    v-model="form.dept_hifz_year_hijri"
                                                    @change="handleHijriYearChange(form.dept_hifz_year_hijri, 'hifz')"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    :disabled="loading">
                                                    <option value="">হিজরি সন নির্বাচন করুন</option>
                                                    <option
                                                        v-for="year in hijriYearOptions"
                                                        :key="year.value"
                                                        :value="year.value">
                                                        {{ year.label }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- কিরাআত -->
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <input type="checkbox" id="dept_qirat" v-model="form.dept_qirat"
                                                class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="dept_qirat" class="text-sm font-medium text-gray-700">কিরাআত</label>
                                        </div>
                                        <div v-if="form.dept_qirat" class="grid grid-cols-2 gap-4 ml-6">
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">ইংরেজি বছর</label>
                                                <select
                                                    v-model="form.dept_qirat_year_english"
                                                    @change="handleEnglishYearChange(form.dept_qirat_year_english, 'qirat')"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    :disabled="loading">
                                                    <option value="">সন নির্বাচন করুন</option>
                                                    <option
                                                        v-for="year in englishYearOptions"
                                                        :key="year.value"
                                                        :value="year.value">
                                                        {{ year.label }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">হিজরি বছর</label>
                                                <select
                                                    v-model="form.dept_qirat_year_hijri"
                                                    @change="handleHijriYearChange(form.dept_qirat_year_hijri, 'qirat')"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    :disabled="loading">
                                                    <option value="">হিজরি সন নির্বাচন করুন</option>
                                                    <option
                                                        v-for="year in hijriYearOptions"
                                                        :key="year.value"
                                                        :value="year.value">
                                                        {{ year.label }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- অন্যান্য বিভাগ -->
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <input type="checkbox" id="dept_other" v-model="form.dept_other"
                                                class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="dept_other" class="text-sm font-medium text-gray-700">অন্যান্য বিভাগ</label>
                                        </div>
                                        <div v-if="form.dept_other" class="grid grid-cols-1 gap-4 ml-6">
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">ক্লাস</label>
                                                <select v-model="form.dept_other_class"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </Fieldset>

                            <Fieldset legend="পরীক্ষা ও অন্যান্য তথ্য" :toggleable="true"
                                class="border border-gray-200 rounded-lg shadow-sm mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="field">
                                        <label for="examType" class="block text-sm font-medium text-gray-700 mb-1">পরীক্ষার ধরন</label>
                                        <select id="examType" v-model="form.examType"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">পরীক্ষার ধরন নির্বাচন করুন</option>
                                            <option value="দাখিলা">দাখিলা</option>
                                            <option value="হাইয়ার">হাইয়ার</option>
                                            <option value="বেফাক">বেফাক</option>
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label for="rollNumber" class="block text-sm font-medium text-gray-700 mb-1">রোল নম্বর</label>
                                        <InputText id="rollNumber" v-model="form.rollNumber"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="field">
                                        <label for="workplace"
                                            class="block text-sm font-medium text-gray-700 mb-1">কর্মস্থল</label>
                                        <select id="workplace" v-model="form.workplace"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">নির্বাচন করুন</option>
                                            <option value="শাইখুল হাদিস">শাইখুল হাদিস</option>
                                            <option value="প্রধান মুফতি">প্রধান মুফতি</option>
                                            <option value="মুঈনে মুফতি">মুঈনে মুফতি</option>
                                            <option value="মুফতি">মুফতি</option>
                                            <option value="আদীব">আদীব</option>
                                            <option value="মাদরাসা শিক্ষক">মাদরাসা শিক্ষক</option>
                                            <option value="ইমাম">ইমাম</option>
                                            <option value="খতিব">খতিব</option>
                                            <option value="মুয়াজ্জিন">মুয়াজ্জিন</option>
                                            <option value="মসজিদের খাদেম">মসজিদের খাদেম</option>
                                            <option value="মুহতামিম">মুহতামিম</option>
                                            <option value="ব্যবসায়ী">ব্যবসায়ী</option>
                                            <option value="প্রবাসি">প্রবাসি</option>
                                            <option value="চাকুরিজীবি">চাকুরিজীবি</option>
                                            <option value="অন্যান্য">অন্যান্য</option>
                                        </select>
                                    </div>
                                    <!-- পরিচয়পত্র টাইপ -->
                                    <div class="field">
                                        <label for="idType" class="block text-sm font-medium text-gray-700 mb-1">পরিচয়পত্র টাইপ</label>
                                        <select id="idType" v-model="form.idType"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">নির্বাচন করুন</option>
                                            <option value="birth">জন্মসনদ</option>
                                            <option value="voter">ভোটার আইডি</option>
                                        </select>
                                    </div>
                                    <div class="field" v-if="form.idType === 'birth'">
                                        <label for="birthCertificate" class="block text-sm font-medium text-gray-700 mb-1">জন্ম নিবন্ধন নম্বর</label>
                                        <InputText id="birthCertificate" v-model="form.birthCertificate"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />

                                        <!-- জন্মনিবন্ধন কার্ডের ছবি -->
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">জন্মনিবন্ধন কার্ড/সার্টিফিকেটের ছবি</label>
                                            <div class="flex flex-col items-center">
                                                <!-- Current Image Display -->
                                                <div v-if="birthCertificatePreview || getBirthCertificatePhotoUrl()" class="mb-3">
                                                    <img :src="birthCertificatePreview || getBirthCertificatePhotoUrl()"
                                                         alt="জন্মনিবন্ধন কার্ড"
                                                         class="w-32 h-24 object-cover border-2 border-gray-200 rounded-lg shadow-md" />
                                                </div>
                                                <!-- Upload Button -->
                                                <input type="file"
                                                       ref="birthCertificateInput"
                                                       @change="handleBirthCertificatePhotoChange"
                                                       accept="image/*"
                                                       class="hidden" />
                                                <Button type="button"
                                                        @click="$refs.birthCertificateInput.click()"
                                                        class="p-button-sm p-button-outlined px-4 py-2 min-w-[160px]"
                                                        icon="pi pi-camera">
                                                    {{ birthCertificatePreview || getBirthCertificatePhotoUrl() ? 'ছবি পরিবর্তন করুন' : 'ছবি আপলোড করুন' }}
                                                </Button>
                                                <small class="text-gray-500 mt-1">সর্বোচ্চ ২MB, JPG/PNG</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field" v-if="form.idType === 'voter'">
                                        <label for="voterId" class="block text-sm font-medium text-gray-700 mb-1">ভোটার আইডি নম্বর</label>
                                        <InputText id="voterId" v-model="form.voterId"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />

                                        <!-- ভোটার আইডি কার্ডের ছবি -->
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">ভোটার আইডি কার্ডের ছবি</label>
                                            <div class="flex flex-col items-center">
                                                <!-- Current Image Display -->
                                                <div v-if="voterIdPreview || getVoterIdPhotoUrl()" class="mb-3">
                                                    <img :src="voterIdPreview || getVoterIdPhotoUrl()"
                                                         alt="ভোটার আইডি কার্ড"
                                                         class="w-32 h-24 object-cover border-2 border-gray-200 rounded-lg shadow-md" />
                                                </div>
                                                <!-- Upload Button -->
                                                <input type="file"
                                                       ref="voterIdInput"
                                                       @change="handleVoterIdPhotoChange"
                                                       accept="image/*"
                                                       class="hidden" />
                                                <Button type="button"
                                                        @click="$refs.voterIdInput.click()"
                                                        class="p-button-sm p-button-outlined px-4 py-2 min-w-[160px]"
                                                        icon="pi pi-camera">
                                                    {{ voterIdPreview || getVoterIdPhotoUrl() ? 'ছবি পরিবর্তন করুন' : 'ছবি আপলোড করুন' }}
                                                </Button>
                                                <small class="text-gray-500 mt-1">সর্বোচ্চ ২MB, JPG/PNG</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label for="classmate1" class="block text-sm font-medium text-gray-700 mb-1">সহপাঠী ১</label>
                                        <InputText id="classmate1" v-model="form.classmate1"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="field">
                                        <label for="classmate2" class="block text-sm font-medium text-gray-700 mb-1">সহপাঠী ২</label>
                                        <InputText id="classmate2" v-model="form.classmate2"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="field">
                                        <label for="classmate3" class="block text-sm font-medium text-gray-700 mb-1">সহপাঠী ৩</label>
                                        <InputText id="classmate3" v-model="form.classmate3"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>
                            </Fieldset>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <Button label="সংরক্ষণ করুন" icon="pi pi-check" @click="saveStudent" autofocus
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition-colors duration-200" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed, watch, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
import axios from 'axios';

import Fieldset from 'primevue/fieldset';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';

const { props } = usePage();
const toast = useToast();

const student = ref(props.student);
const divisions = ref(props.divisions || []);
const districts = ref(props.districts || []);
const thanas = ref(props.thanas || []);

const form = useForm({
    fullNameBangla: '',
    fullNameEnglish: '',
    fatherName: '',
    phoneNumber: '',
    alternatePhoneNumber: '',
    dateOfBirth: '',
    bloodGroup: '',
    address: '',
    division: '',
    district: '',
    thana: '',
    classmate1: '',
    classmate2: '',
    classmate3: '',
    dept_takmil: false,
    dept_ifta: false,
    dept_hifz: false,
    dept_qirat: false,
    dept_other: false,
    dept_other_class: '',
    dept_takmil_year_english: '',
    dept_takmil_year_hijri: '',
    dept_ifta_year_english: '',
    dept_ifta_year_hijri: '',
    dept_hifz_year_english: '',
    dept_hifz_year_hijri: '',
    dept_qirat_year_english: '',
    dept_qirat_year_hijri: '',
    examType: '',
    rollNumber: '',
    workplace: '',
    idType: '',
    birthCertificate: '',
    voterId: '',
    birthCertificatePhoto: null,
    voterIdPhoto: null,
    photo: null,
});

const photoPreview = ref(null);
const birthCertificatePreview = ref(null);
const voterIdPreview = ref(null);
const sessionYears = ref([]);
const loading = ref(false);
const isInitializing = ref(true);

// Watcher for student.value to always keep form in sync
watch(() => student.value, (newStudent) => {
    if (newStudent) {
        form.fullNameBangla = newStudent.fullNameBangla || '';
        form.fullNameEnglish = newStudent.fullNameEnglish || '';
        form.fatherName = newStudent.fatherName || '';
        form.phoneNumber = newStudent.phoneNumber || '';

        if (newStudent.information) {
            form.alternatePhoneNumber = newStudent.information.alternatePhoneNumber || '';
            form.dateOfBirth = newStudent.information.dateOfBirth || '';
            form.bloodGroup = newStudent.information.bloodGroup || '';
            form.address = newStudent.information.address || '';
            form.division = newStudent.information.division_id || '';
            form.district = newStudent.information.district_id || '';
            form.thana = newStudent.information.thana_id || '';
            form.classmate1 = newStudent.information.classmate1 || '';
            form.classmate2 = newStudent.information.classmate2 || '';
            form.classmate3 = newStudent.information.classmate3 || '';
            form.dept_takmil = newStudent.information.dept_takmil || false;
            form.dept_ifta = newStudent.information.dept_ifta || false;
            form.dept_hifz = newStudent.information.dept_hifz || false;
            form.dept_qirat = newStudent.information.dept_qirat || false;
            form.dept_other = newStudent.information.dept_other || false;
            form.dept_other_class = newStudent.information.dept_other_class || '';
            form.dept_takmil_year_english = newStudent.information.dept_takmil_year_english || '';
            form.dept_takmil_year_hijri = newStudent.information.dept_takmil_year_hijri || '';
            form.dept_ifta_year_english = newStudent.information.dept_ifta_year_english || '';
            form.dept_ifta_year_hijri = newStudent.information.dept_ifta_year_hijri || '';
            form.dept_hifz_year_english = newStudent.information.dept_hifz_year_english || '';
            form.dept_hifz_year_hijri = newStudent.information.dept_hifz_year_hijri || '';
            form.dept_qirat_year_english = newStudent.information.dept_qirat_year_english || '';
            form.dept_qirat_year_hijri = newStudent.information.dept_qirat_year_hijri || '';
            form.examType = newStudent.information.examType || '';
            form.rollNumber = newStudent.information.rollNumber || '';
            form.workplace = newStudent.information.workplace || '';
            form.idType = newStudent.information.idType || '';
            form.birthCertificate = newStudent.information.birthCertificate || '';
            form.voterId = newStudent.information.voterId || '';
            form.birthCertificatePhoto = newStudent.information.birthCertificatePhoto || null;
            form.voterIdPhoto = newStudent.information.voterIdPhoto || null;
            form.photo = newStudent.information.photo || null;
        }
    }
}, { immediate: true });

// Fetch session years
const fetchSessionYears = async () => {
    try {
        loading.value = true;
        const response = await axios.get('/test-years/all');
        if (response.data.success) {
            sessionYears.value = response.data.data;
        }
    } catch (error) {
        console.error('Error fetching session years:', error);
        toast.error('সন তথ্য লোড করতে সমস্যা হয়েছে');
    } finally {
        loading.value = false;
    }
};

// Year synchronization functions
const syncHijriFromEnglish = (englishYear, department) => {
    const yearData = sessionYears.value.find(year => year.english_year == englishYear);
    if (yearData) {
        form[`dept_${department}_year_hijri`] = yearData.hijri_year;
    }
};

const syncEnglishFromHijri = (hijriYear, department) => {
    const yearData = sessionYears.value.find(year => year.hijri_year === hijriYear);
    if (yearData) {
        form[`dept_${department}_year_english`] = yearData.english_year;
    }
};

// Handle English year change
const handleEnglishYearChange = (englishYear, department) => {
    if (!isInitializing.value && englishYear) {
        syncHijriFromEnglish(englishYear, department);
    }
};

// Handle Hijri year change
const handleHijriYearChange = (hijriYear, department) => {
    if (!isInitializing.value && hijriYear) {
        syncEnglishFromHijri(hijriYear, department);
    }
};

const filteredDistricts = computed(() =>
    districts.value.filter(d => d.division_id === form.division)
);
const filteredThanas = computed(() =>
    thanas.value.filter(t => t.district_id === form.district)
);

// Computed properties for year options
const englishYearOptions = computed(() => {
    return sessionYears.value.map(year => ({
        value: year.english_year,
        label: year.english_year.toString(),
        hijri: year.hijri_year
    }));
});

const hijriYearOptions = computed(() => {
    return sessionYears.value.map(year => ({
        value: year.hijri_year,
        label: year.hijri_year,
        english: year.english_year
    }));
});

function getPhotoUrl(photo) {
    if (!photo) {
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzciIHI9IjE4IiBmaWxsPSIjOUI5QjlCIi8+CjxwYXRoIGQ9Ik0yMCA4MEM2IDgwIDM4IDY4IDUwIDY4QzYyIDY4IDk0IDgwIDgwIDgwSDE4WiIgZmlsbD0iIzlCOUI5QiIvPgo8L3N2Zz4=';
    }
    if (typeof photo === 'string' && (photo.startsWith('http://') || photo.startsWith('https://'))) {
        return photo;
    }
    if (typeof photo === 'string' && photo.startsWith('/')) {
        return photo;
    }
    if (typeof photo === 'string') {
        return `/storage/${photo}`;
    }
    if (photo instanceof File && photoPreview.value) {
        return photoPreview.value;
    }
    return '';
}

function handlePhotoChange(e) {
    const file = e.target.files[0];
    if (file) {
        form.photo = file;
        const reader = new FileReader();
        reader.onload = (event) => {
            photoPreview.value = event.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function handleBirthCertificatePhotoChange(e) {
    const file = e.target.files[0];
    if (file) {
        form.birthCertificatePhoto = file;
        const reader = new FileReader();
        reader.onload = (event) => {
            birthCertificatePreview.value = event.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function handleVoterIdPhotoChange(e) {
    const file = e.target.files[0];
    if (file) {
        form.voterIdPhoto = file;
        const reader = new FileReader();
        reader.onload = (event) => {
            voterIdPreview.value = event.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function getBirthCertificatePhotoUrl() {
    if (!form.birthCertificatePhoto) return null;
    if (typeof form.birthCertificatePhoto === 'string' && (form.birthCertificatePhoto.startsWith('http://') || form.birthCertificatePhoto.startsWith('https://'))) {
        return form.birthCertificatePhoto;
    }
    if (typeof form.birthCertificatePhoto === 'string' && form.birthCertificatePhoto.startsWith('/')) {
        return form.birthCertificatePhoto;
    }
    if (typeof form.birthCertificatePhoto === 'string') {
        return `/storage/${form.birthCertificatePhoto}`;
    }
    return null;
}

function getVoterIdPhotoUrl() {
    if (!form.voterIdPhoto) return null;
    if (typeof form.voterIdPhoto === 'string' && (form.voterIdPhoto.startsWith('http://') || form.voterIdPhoto.startsWith('https://'))) {
        return form.voterIdPhoto;
    }
    if (typeof form.voterIdPhoto === 'string' && form.voterIdPhoto.startsWith('/')) {
        return form.voterIdPhoto;
    }
    if (typeof form.voterIdPhoto === 'string') {
        return `/storage/${form.voterIdPhoto}`;
    }
    return null;
}

function saveStudent() {
    form.put(route('student.update', student.value.id), {
        onSuccess: () => {
            toast.success('শিক্ষার্থীর তথ্য সফলভাবে আপডেট করা হয়েছে!');
        },
        onError: (errors) => {
            toast.error('শিক্ষার্থীর তথ্য আপডেট ব্যর্থ হয়েছে।');
            console.error(errors);
        },
    });
}

// Initialize component
onMounted(async () => {
    await fetchSessionYears();
    isInitializing.value = false;
});
</script>
