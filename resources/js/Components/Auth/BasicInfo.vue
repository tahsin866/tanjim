<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, computed, watch, onMounted, nextTick } from 'vue';
import axios from 'axios';

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

// Data from API
const divisions = ref([]);
const districts = ref([]);
const thanas = ref([]);
const loading = ref(false);
const isInitializing = ref(true);

// Computed properties for dependent dropdowns
const availableDistricts = computed(() => {
    return districts.value;
});

const availableThanas = computed(() => {
    return thanas.value;
});

// Validation computed properties
const fieldValidation = computed(() => {
    if (!props.hasAttemptedValidation) return {};

    const errors = {};

    // Required field validation
    if (!props.form.fullNameBangla) errors.fullNameBangla = 'বাংলা নাম প্রয়োজন';
    if (!props.form.fullNameEnglish) errors.fullNameEnglish = 'ইংরেজি নাম প্রয়োজন';
    if (!props.form.fatherName) errors.fatherName = 'বাবার নাম প্রয়োজন';
    if (!props.form.email) errors.email = 'ইমেইল ঠিকানা প্রয়োজন';
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(props.form.email)) errors.email = 'সঠিক ইমেইল ঠিকানা লিখুন';
    if (!props.form.phoneNumber) errors.phoneNumber = 'ফোন নম্বর প্রয়োজন';
    if (!props.form.dateOfBirth) errors.dateOfBirth = 'জন্মতারিখ প্রয়োজন';
    if (!props.form.address) errors.address = 'ঠিকানা প্রয়োজন';
    if (!props.form.division) errors.division = 'বিভাগ নির্বাচন করুন';
    if (!props.form.district) errors.district = 'জেলা নির্বাচন করুন';
    if (!props.form.thana) errors.thana = 'থানা নির্বাচন করুন';

    return errors;
});

// Helper function to get field error class
const getFieldErrorClass = (fieldName) => {
    const hasError = fieldValidation.value[fieldName];
    const baseClass = "mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500";

    if (hasError) {
        return `${baseClass} border-red-300 focus:border-red-500 bg-red-50`;
    } else {
        return `${baseClass} border-gray-300 focus:border-indigo-500`;
    }
};

// Helper function to get select field error class
const getSelectErrorClass = (fieldName) => {
    const hasError = fieldValidation.value[fieldName];
    const baseClass = "mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500";

    if (hasError) {
        return `${baseClass} border-red-300 focus:border-red-500 bg-red-50`;
    } else {
        return `${baseClass} border-gray-300 focus:border-indigo-500`;
    }
};

// Helper function to get textarea error class
const getTextareaErrorClass = (fieldName) => {
    const hasError = fieldValidation.value[fieldName];
    const baseClass = "mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500";

    if (hasError) {
        return `${baseClass} border-red-300 focus:border-red-500 bg-red-50`;
    } else {
        return `${baseClass} border-gray-300 focus:border-indigo-500`;
    }
};

// LocalStorage keys
const STORAGE_KEYS = {
    divisions: 'basicinfo_divisions',
    districts: 'basicinfo_districts',
    thanas: 'basicinfo_thanas',
    formData: 'basicinfo_form_data'
};

// Save data to localStorage
const saveToStorage = (key, data) => {
    try {
        localStorage.setItem(key, JSON.stringify(data));
    } catch (error) {
        console.error('Error saving to localStorage:', error);
    }
};

// Load data from localStorage
const loadFromStorage = (key) => {
    try {
        const data = localStorage.getItem(key);
        return data ? JSON.parse(data) : null;
    } catch (error) {
        console.error('Error loading from localStorage:', error);
        return null;
    }
};

// Save form data to localStorage
const saveFormData = () => {
    const formData = {
        division: props.form.division,
        district: props.form.district,
        thana: props.form.thana,
        fullNameBangla: props.form.fullNameBangla,
        fullNameEnglish: props.form.fullNameEnglish,
        fatherName: props.form.fatherName,
        email: props.form.email,
        phoneNumber: props.form.phoneNumber,
        alternatePhoneNumber: props.form.alternatePhoneNumber,
        dateOfBirth: props.form.dateOfBirth,
        bloodGroup: props.form.bloodGroup,
        address: props.form.address,
        classmate1: props.form.classmate1,
        classmate2: props.form.classmate2,
        classmate3: props.form.classmate3
    };
    saveToStorage(STORAGE_KEYS.formData, formData);
};

// Load form data from localStorage
const loadFormData = () => {
    const savedData = loadFromStorage(STORAGE_KEYS.formData);
    if (savedData) {
        Object.keys(savedData).forEach(key => {
            if (props.form.hasOwnProperty(key) && savedData[key]) {
                props.form[key] = savedData[key];
            }
        });
    }
};

// API Methods
const fetchDivisions = async () => {
    // Try to load from localStorage first
    const cachedDivisions = loadFromStorage(STORAGE_KEYS.divisions);
    if (cachedDivisions && cachedDivisions.length > 0) {
        divisions.value = cachedDivisions;
        return;
    }

    try {
        loading.value = true;
        const response = await axios.get('/api/divisions');
        divisions.value = response.data;
        saveToStorage(STORAGE_KEYS.divisions, response.data);
    } catch (error) {
        console.error('Error fetching divisions:', error);
    } finally {
        loading.value = false;
    }
};

const fetchDistricts = async (divisionId) => {
    if (!divisionId) {
        districts.value = [];
        return;
    }

    // Try to load from localStorage first
    const cacheKey = `${STORAGE_KEYS.districts}_${divisionId}`;
    const cachedDistricts = loadFromStorage(cacheKey);
    if (cachedDistricts && cachedDistricts.length > 0) {
        districts.value = cachedDistricts;
        return;
    }

    try {
        loading.value = true;
        const response = await axios.get(`/api/districts/${divisionId}`);
        districts.value = response.data;
        saveToStorage(cacheKey, response.data);
    } catch (error) {
        console.error('Error fetching districts:', error);
        districts.value = [];
    } finally {
        loading.value = false;
    }
};

const fetchThanas = async (districtId) => {
    if (!districtId) {
        thanas.value = [];
        return;
    }

    // Try to load from localStorage first
    const cacheKey = `${STORAGE_KEYS.thanas}_${districtId}`;
    const cachedThanas = loadFromStorage(cacheKey);
    if (cachedThanas && cachedThanas.length > 0) {
        thanas.value = cachedThanas;
        return;
    }

    try {
        loading.value = true;
        const response = await axios.get(`/api/thanas/${districtId}`);
        thanas.value = response.data;
        saveToStorage(cacheKey, response.data);
    } catch (error) {
        console.error('Error fetching thanas:', error);
        thanas.value = [];
    } finally {
        loading.value = false;
    }
};

// Watch for division changes to reset district and thana
watch(() => props.form.division, (newDivision) => {
    if (!isInitializing.value) {
        props.form.district = '';
        props.form.thana = '';
        districts.value = [];
        thanas.value = [];
    }

    if (newDivision) {
        fetchDistricts(newDivision);
    }

    if (!isInitializing.value) {
        saveFormData();
    }
});

// Watch for district changes to reset thana
watch(() => props.form.district, (newDistrict) => {
    if (!isInitializing.value) {
        props.form.thana = '';
        thanas.value = [];
    }

    if (newDistrict) {
        fetchThanas(newDistrict);
    }

    if (!isInitializing.value) {
        saveFormData();
    }
});

// Watch all form fields for changes to save to localStorage
watch(() => props.form, () => {
    if (!isInitializing.value) {
        saveFormData();
    }
}, { deep: true });

// Load divisions and restore form data on component mount
onMounted(async () => {
    await fetchDivisions();

    // Load saved form data
    loadFormData();

    // If division is saved, load districts
    if (props.form.division) {
        await fetchDistricts(props.form.division);
    }

    // If district is saved, load thanas
    if (props.form.district) {
        await fetchThanas(props.form.district);
    }

    // Wait for next tick then mark initialization as complete
    await nextTick();
    isInitializing.value = false;
});
</script>

<template>
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6 border-b pb-2">ব্যক্তিগত তথ্য</h3>

        <!-- পূর্ণ নাম, ইংরেজি নাম -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <InputLabel for="fullNameBangla" class="text-lg font-medium dark:text-white" value="পূর্ণ নাম (বাংলা)" />
                <input
                    id="fullNameBangla"
                    type="text"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getFieldErrorClass('fullNameBangla'), 'dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                    v-model="form.fullNameBangla"
                    placeholder="বাংলায় পূর্ণ নাম লিখুন"
                    required
                />
                <InputError class="mt-2" :message="fieldValidation.fullNameBangla" />
            </div>
            <div>
                <InputLabel for="fullNameEnglish" class="text-lg font-medium dark:text-white" value="পূর্ণ নাম (ইংরেজি)" />
                <input
                    id="fullNameEnglish"
                    type="text"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getFieldErrorClass('fullNameEnglish'), 'dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                    v-model="form.fullNameEnglish"
                    placeholder="Full Name in English"
                    required
                />
                <InputError class="mt-2" :message="fieldValidation.fullNameEnglish" />
            </div>
        </div>

        <!-- পিতার নাম, ইমেইল -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <InputLabel for="fatherName" class="text-lg font-medium dark:text-white" value="পিতার নাম" />
                <input
                    id="fatherName"
                    type="text"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getFieldErrorClass('fatherName'), 'dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                    v-model="form.fatherName"
                    placeholder="পিতার নাম লিখুন"
                    required
                />
                <InputError class="mt-2" :message="fieldValidation.fatherName" />
            </div>
            <div>
                <InputLabel for="email" class="text-lg font-medium dark:text-white" value="ইমেইল ঠিকানা" />
                <input
                    id="email"
                    type="email"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getFieldErrorClass('email'), 'dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                    v-model="form.email"
                    placeholder="ইমেইল ঠিকানা লিখুন (যেমন: example@gmail.com)"
                    required
                />
                <InputError class="mt-2" :message="fieldValidation.email" />
            </div>
        </div>

        <!-- ফোন নাম্বার, বিকল্প ফোন নাম্বার -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <InputLabel for="phoneNumber" class="text-lg font-medium dark:text-white" value="ফোন নাম্বর" />
                <input
                    id="phoneNumber"
                    type="tel"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getFieldErrorClass('phoneNumber'), 'dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                    v-model="form.phoneNumber"
                    placeholder="মোবাইল নাম্বর লিখুন (যেমন: 01712345678)"
                    required
                />
                <InputError class="mt-2" :message="fieldValidation.phoneNumber" />
            </div>
            <div>
                <InputLabel for="alternatePhoneNumber" class="text-lg font-medium dark:text-white" value="বিকল্প ফোন নাম্বার" />
                <TextInput
                    id="alternatePhoneNumber"
                    type="tel"
                    class="mt-1 block w-full dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400"
                    v-model="form.alternatePhoneNumber"
                    placeholder="বিকল্প ফোন নাম্বার (যদি থাকে)"
                />
                <InputError class="mt-2" :message="form.errors.alternatePhoneNumber" />
            </div>
        </div>

        <!-- জন্মতারিখ, ব্লাড গ্রুপ -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <InputLabel for="dateOfBirth" class="text-lg font-medium dark:text-white" value="জন্মতারিখ" />
                <input
                    id="dateOfBirth"
                    type="date"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getFieldErrorClass('dateOfBirth'), 'dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                    v-model="form.dateOfBirth"
                    required
                />
                <InputError class="mt-2" :message="fieldValidation.dateOfBirth" />
            </div>
            <div>
                <InputLabel for="bloodGroup" class="text-lg font-medium dark:text-white" value="ব্লাড গ্রুপ" />
                <select
                    id="bloodGroup"
                    v-model="form.bloodGroup"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getSelectErrorClass('bloodGroup'), 'dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
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
                <InputError class="mt-2" :message="form.errors.bloodGroup" />
            </div>
        </div>

        <!-- বিস্তারিত ঠিকানা -->
        <div class="mb-6">
            <InputLabel for="address" class="text-lg font-medium dark:text-white" value="বিস্তারিত ঠিকানা" />
            <textarea
                id="address"
                v-model="form.address"
                placeholder="গ্রাম/মহল্লা, ওয়ার্ড নং, ইত্যাদি"
                :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getTextareaErrorClass('address'), 'dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                rows="3"
                required
            ></textarea>
            <InputError class="mt-2" :message="fieldValidation.address" />
        </div>

        <!-- বিভাগ, জেলা, থানা (Dependent Dropdowns) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <InputLabel for="division" class="text-lg font-medium dark:text-white" value="বিভাগ" />
                <select
                    id="division"
                    v-model="form.division"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getSelectErrorClass('division'), 'dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                    required
                    :disabled="loading"
                >
                    <option value="">বিভাগ নির্বাচন করুন</option>
                    <option v-for="division in divisions" :key="division.id" :value="division.id">
                        {{ division.Division }}
                    </option>
                </select>
                <InputError class="mt-2" :message="fieldValidation.division" />
            </div>

            <div>
                <InputLabel for="district" class="text-lg font-medium dark:text-white" value="জেলা" />
                <select
                    id="district"
                    v-model="form.district"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getSelectErrorClass('district'), 'dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                    :disabled="!form.division || loading"
                    required
                >
                    <option value="">জেলা নির্বাচন করুন</option>
                    <option v-for="district in availableDistricts" :key="district.DesID" :value="district.DesID">
                        {{ district.District }}
                    </option>
                </select>
                <InputError class="mt-2" :message="fieldValidation.district" />
            </div>

            <div>
                <InputLabel for="thana" class="text-lg font-medium dark:text-white" value="থানা/উপজেলা" />
                <select
                    id="thana"
                    v-model="form.thana"
                    :class="['block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-bangla', getSelectErrorClass('thana'), 'dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400']"
                    :disabled="!form.district || loading"
                    required
                >
                    <option value="">থানা নির্বাচন করুন</option>
                    <option v-for="thana in availableThanas" :key="thana.Thana_ID" :value="thana.Thana_ID">
                        {{ thana.Thana }}
                    </option>
                </select>
                <InputError class="mt-2" :message="fieldValidation.thana" />
            </div>
        </div>

        <!-- ✅ সাথী ভাইয়ের নামসমূহ (দুই কলামে) -->
        <div class="mb-6">
            <InputLabel class="text-lg font-medium mb-3 dark:text-white" value="নিজ জামাতে তিনজন সাথী ভাইয়ের নাম" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <TextInput
                        id="classmate1"
                        type="text"
                        class="block w-full dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400"
                        v-model="form.classmate1"
                        placeholder="প্রথম সাথী ভাইয়ের নাম"
                    />
                    <InputError class="mt-2" :message="form.errors.classmate1" />
                </div>
                <div>
                    <TextInput
                        id="classmate2"
                        type="text"
                        class="block w-full dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400"
                        v-model="form.classmate2"
                        placeholder="দ্বিতীয় সাথী ভাইয়ের নাম"
                    />
                    <InputError class="mt-2" :message="form.errors.classmate2" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div>
                    <TextInput
                        id="classmate3"
                        type="text"
                        class="block w-full dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:border-gray-600 dark:focus:border-emerald-400 dark:focus:ring-emerald-400"
                        v-model="form.classmate3"
                        placeholder="তৃতীয় সাথী ভাইয়ের নাম"
                    />
                    <InputError class="mt-2" :message="form.errors.classmate3" />
                </div>
            </div>
        </div>
    </div>
</template>
