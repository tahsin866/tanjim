<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch, onMounted, nextTick, computed } from 'vue';
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

const isInitializing = ref(true);
const sessionYears = ref([]);
const loading = ref(true);
const error = ref(null);

// LocalStorage keys for education info
const STORAGE_KEYS = {
    educationFormData: 'education_form_data',
    uploadedFiles: 'education_uploaded_files',
    sessionYears: 'session_years_data'
};

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

// Validation computed properties
const fieldValidation = computed(() => {
    if (!props.hasAttemptedValidation) return {};

    const errors = {};
    const hasAnyDepartment = props.form.dept_takmil || props.form.dept_ifta || props.form.dept_hifz || props.form.dept_qirat || props.form.dept_other;

    // Department validation
    if (!hasAnyDepartment) {
        errors.departments = 'অন্তত একটি বিভাগ নির্বাচন করুন';
    }

    // Takmil year validation
    if (props.form.dept_takmil && (!props.form.dept_takmil_year_english || !props.form.dept_takmil_year_hijri)) {
        if (!props.form.dept_takmil_year_english) errors.dept_takmil_year_english = 'তাকমিল ইংরেজি সন নির্বাচন করুন';
        if (!props.form.dept_takmil_year_hijri) errors.dept_takmil_year_hijri = 'তাকমিল হিজরি সন নির্বাচন করুন';
    }

    // Ifta year validation
    if (props.form.dept_ifta && (!props.form.dept_ifta_year_english || !props.form.dept_ifta_year_hijri)) {
        if (!props.form.dept_ifta_year_english) errors.dept_ifta_year_english = 'ইফতা ইংরেজি সন নির্বাচন করুন';
        if (!props.form.dept_ifta_year_hijri) errors.dept_ifta_year_hijri = 'ইফতা হিজরি সন নির্বাচন করুন';
    }

    // Hifz year validation
    if (props.form.dept_hifz && (!props.form.dept_hifz_year_english || !props.form.dept_hifz_year_hijri)) {
        if (!props.form.dept_hifz_year_english) errors.dept_hifz_year_english = 'হিফজ ইংরেজি সন নির্বাচন করুন';
        if (!props.form.dept_hifz_year_hijri) errors.dept_hifz_year_hijri = 'হিফজ হিজরি সন নির্বাচন করুন';
    }

    // Qirat year validation
    if (props.form.dept_qirat && (!props.form.dept_qirat_year_english || !props.form.dept_qirat_year_hijri)) {
        if (!props.form.dept_qirat_year_english) errors.dept_qirat_year_english = 'কিরাআত ইংরেজি সন নির্বাচন করুন';
        if (!props.form.dept_qirat_year_hijri) errors.dept_qirat_year_hijri = 'কিরাআত হিজরি সন নির্বাচন করুন';
    }

    // Other department validation
    if (props.form.dept_other && !props.form.dept_other_class) {
        errors.dept_other_class = 'অন্যান্য বিভাগের ক্লাস নির্বাচন করুন';
    }

    // Exam type validation - "জানা নেই" হলে validation pass করবে
    if (!props.form.examType) {
        errors.examType = 'আইডির ধরন নির্বাচন করুন';
    }

    // Roll number validation - শুধুমাত্র examType selected এবং "জানা নেই" না হলে required
    if (props.form.examType && props.form.examType !== 'জানা নেই' && !props.form.rollNumber) {
        errors.rollNumber = 'রোল নাম্বার লিখুন';
    }

    // ID type validation
    if (!props.form.idType) {
        errors.idType = 'পরিচয়পত্র টাইপ নির্বাচন করুন';
    }

    // Birth certificate validation - শুধুমাত্র যখন 'birth' সিলেক্ট করা হয়
    if (props.form.idType === 'birth') {
        if (!props.form.birthCertificate) errors.birthCertificate = 'জন্মনিবন্ধন নম্বর লিখুন';
        if (!props.form.birthCertificatePhoto) errors.birthCertificatePhoto = 'জন্মনিবন্ধন ছবি আপলোড করুন';
    }

    // Voter ID validation - শুধুমাত্র যখন 'voter' সিলেক্ট করা হয়
    if (props.form.idType === 'voter') {
        if (!props.form.voterId) errors.voterId = 'ভোটার আইডি নম্বর লিখুন';
        if (!props.form.voterIdPhoto) errors.voterIdPhoto = 'ভোটার আইডি ছবি আপলোড করুন';
    }

    // Photo validation - শুধুমাত্র যখন idType 'জানা নেই' না হয়
    if (props.form.idType !== 'জানা নেই' && !props.form.photo) {
        errors.photo = 'লাইভ ছবি আপলোড করুন';
    }

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

// Helper function to get file input error class
const getFileErrorClass = (fieldName) => {
    const hasError = fieldValidation.value[fieldName];
    const baseClass = "mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 rounded-md shadow-sm focus:ring-indigo-500";

    if (hasError) {
        return `${baseClass} border-red-300 focus:border-red-500 bg-red-50`;
    } else {
        return `${baseClass} border-gray-300 focus:border-indigo-500`;
    }
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

// Fetch session years from API
const fetchSessionYears = async () => {
    // Try to load from localStorage first
    const cachedYears = loadFromStorage(STORAGE_KEYS.sessionYears);
    if (cachedYears && cachedYears.length > 0) {
        sessionYears.value = cachedYears;
        loading.value = false;
        return;
    }

    try {
        loading.value = true;
        error.value = null;
        const response = await axios.get('/test-years/all');
        if (response.data.success) {
            sessionYears.value = response.data.data;
            saveToStorage(STORAGE_KEYS.sessionYears, response.data.data);
        } else {
            error.value = 'সন তথ্য লোড করতে সমস্যা হয়েছে';
        }
    } catch (error) {
        console.error('Error fetching session years:', error);
        error.value = 'সন তথ্য লোড করতে সমস্যা হয়েছে। পেজ রিফ্রেশ করে আবার চেষ্টা করুন।';
    } finally {
        loading.value = false;
    }
};

// Year synchronization functions
const syncHijriFromEnglish = (englishYear, department) => {
    const yearData = sessionYears.value.find(year => year.english_year == englishYear);
    if (yearData) {
        props.form[`dept_${department}_year_hijri`] = yearData.hijri_year;
    }
};

const syncEnglishFromHijri = (hijriYear, department) => {
    const yearData = sessionYears.value.find(year => year.hijri_year === hijriYear);
    if (yearData) {
        props.form[`dept_${department}_year_english`] = yearData.english_year;
    }
};

// Handle English year change
const handleEnglishYearChange = (englishYear, department) => {
    if (!isInitializing.value && englishYear) {
        syncHijriFromEnglish(englishYear, department);
        saveEducationFormData();
    }
};

// Handle Hijri year change
const handleHijriYearChange = (hijriYear, department) => {
    if (!isInitializing.value && hijriYear) {
        syncEnglishFromHijri(hijriYear, department);
        saveEducationFormData();
    }
};

// Save form data to localStorage
const saveEducationFormData = () => {
    const formData = {
        // Department selections
        dept_takmil: props.form.dept_takmil,
        dept_takmil_year_english: props.form.dept_takmil_year_english,
        dept_takmil_year_hijri: props.form.dept_takmil_year_hijri,
        dept_ifta: props.form.dept_ifta,
        dept_ifta_year_english: props.form.dept_ifta_year_english,
        dept_ifta_year_hijri: props.form.dept_ifta_year_hijri,
        dept_hifz: props.form.dept_hifz,
        dept_hifz_year_english: props.form.dept_hifz_year_english,
        dept_hifz_year_hijri: props.form.dept_hifz_year_hijri,
        dept_qirat: props.form.dept_qirat,
        dept_qirat_year_english: props.form.dept_qirat_year_english,
        dept_qirat_year_hijri: props.form.dept_qirat_year_hijri,
        dept_other: props.form.dept_other,
        dept_other_class: props.form.dept_other_class,

        // Additional fields
        examType: props.form.examType,
        rollNumber: props.form.rollNumber,
        workplace: props.form.workplace,

        // ID information
        idType: props.form.idType,
        birthCertificate: props.form.birthCertificate,
        voterId: props.form.voterId,

        // File names (for reference)
        photoFileName: props.form.photo?.name || null,
        birthCertificatePhotoFileName: props.form.birthCertificatePhoto?.name || null,
        voterIdPhotoFileName: props.form.voterIdPhoto?.name || null
    };
    saveToStorage(STORAGE_KEYS.educationFormData, formData);
};

// Load form data from localStorage
const loadEducationFormData = () => {
    const savedData = loadFromStorage(STORAGE_KEYS.educationFormData);
    if (savedData) {
        Object.keys(savedData).forEach(key => {
            if (props.form.hasOwnProperty(key) && savedData[key] !== null && savedData[key] !== undefined) {
                // Skip file name fields as we can't restore actual files
                if (!key.endsWith('FileName')) {
                    props.form[key] = savedData[key];
                }
            }
        });
    }
};

// File upload handlers with persistence
const handlePhotoUpload = (event) => {
    const file = event.target.files[0];
    props.form.photo = file;

    if (file) {
        // Save file info to localStorage (filename for reference)
        const fileInfo = {
            name: file.name,
            size: file.size,
            type: file.type,
            lastModified: file.lastModified
        };
        saveToStorage('education_photo_info', fileInfo);
    }

    if (!isInitializing.value) {
        saveEducationFormData();
    }
};

// ✅ জন্ম/ভোটার ফটো আপলোড হ্যান্ডলার
const handleIdPhotoUpload = (event) => {
    const file = event.target.files[0];

    if (props.form.idType === 'birth') {
        props.form.birthCertificatePhoto = file;
        if (file) {
            const fileInfo = {
                name: file.name,
                size: file.size,
                type: file.type,
                lastModified: file.lastModified
            };
            saveToStorage('education_birth_cert_photo_info', fileInfo);
        }
    } else if (props.form.idType === 'voter') {
        props.form.voterIdPhoto = file;
        if (file) {
            const fileInfo = {
                name: file.name,
                size: file.size,
                type: file.type,
                lastModified: file.lastModified
            };
            saveToStorage('education_voter_photo_info', fileInfo);
        }
    }

    if (!isInitializing.value) {
        saveEducationFormData();
    }
};

// Display uploaded file names from localStorage
const getUploadedFileName = (fileType) => {
    const fileInfo = loadFromStorage(`education_${fileType}_info`);
    return fileInfo ? fileInfo.name : null;
};

// Watch all form fields for changes to save to localStorage
watch(() => props.form, () => {
    if (!isInitializing.value) {
        saveEducationFormData();
    }
}, { deep: true });

// Watch examType to clear rollNumber when "জানা নেই" is selected
watch(() => props.form.examType, (newValue) => {
    if (newValue === 'জানা নেই') {
        props.form.rollNumber = '';
    }
});

// Watch idType to clear ID-related fields when "জানা নেই" is selected
watch(() => props.form.idType, (newValue) => {
    if (newValue === 'জানা নেই') {
        props.form.birthCertificate = '';
        props.form.birthCertificatePhoto = null;
        props.form.voterId = '';
        props.form.voterIdPhoto = null;
        props.form.photo = null;
    }
});

// Initialize component
onMounted(async () => {
    // Fetch session years data first
    await fetchSessionYears();

    // Load saved form data
    loadEducationFormData();

    // Wait for next tick then mark initialization as complete
    await nextTick();
    isInitializing.value = false;
});
</script>

<template>
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">শিক্ষাগত তথ্য</h3>

        <!-- বিভাগ সেকশন -->
        <div class="mb-6">
            <InputLabel class="text-lg font-medium mb-3" value="শিক্ষা বিভাগ (একাধিক নির্বাচন করা যাবে)" />

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

            <!-- Error message -->
            <div v-else-if="error" class="mb-4 p-3 bg-red-50 border border-red-200 rounded-md">
                <div class="flex items-center text-red-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ error }}
                </div>
            </div>

            <!-- তাকমিল -->
            <div class="border rounded-lg p-4 mb-4">
                <div class="flex items-center mb-3">
                    <input id="takamil" v-model="form.dept_takmil" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                    <label for="takamil" class="text-sm font-medium text-gray-700">তাকমিল</label>
                </div>
                <div v-if="form.dept_takmil" class="ml-6">
                    <!-- Helpful hint -->
                    <div class="mb-3 p-2 bg-blue-50 border border-blue-200 rounded text-xs text-blue-700">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        টিপস: ইংরেজি সন নির্বাচন করলে হিজরি সন স্বয়ংক্রিয়ভাবে আপডেট হবে এবং বিপরীতভাবেও।
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel class="text-sm font-medium" value="ফারাগাতের সন (ইংরেজি)" />
                            <select
                                v-model="form.dept_takmil_year_english"
                                @change="handleEnglishYearChange(form.dept_takmil_year_english, 'takmil')"
                                :class="getFieldErrorClass('dept_takmil_year_english')"
                                :disabled="loading">
                                <option value="">সন নির্বাচন করুন</option>
                                <option
                                    v-for="year in englishYearOptions"
                                    :key="year.value"
                                    :value="year.value">
                                    {{ year.label }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="fieldValidation.dept_takmil_year_english" />
                        </div>
                        <div>
                            <InputLabel class="text-sm font-medium" value="ফারাগাতের সন (হিজরি)" />
                            <select
                                v-model="form.dept_takmil_year_hijri"
                                @change="handleHijriYearChange(form.dept_takmil_year_hijri, 'takmil')"
                                :class="getFieldErrorClass('dept_takmil_year_hijri')"
                                :disabled="loading">
                                <option value="">হিজরি সন নির্বাচন করুন</option>
                                <option
                                    v-for="year in hijriYearOptions"
                                    :key="year.value"
                                    :value="year.value">
                                    {{ year.label }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="fieldValidation.dept_takmil_year_hijri" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- ইফতা -->
            <div class="border rounded-lg p-4 mb-4">
                <div class="flex items-center mb-3">
                    <input id="ifta" v-model="form.dept_ifta" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                    <label for="ifta" class="text-sm font-medium text-gray-700">ইফতা</label>
                </div>
                <div v-if="form.dept_ifta" class="grid grid-cols-2 gap-4 ml-6">
                    <div>
                        <InputLabel class="text-sm font-medium" value="ফারাগাতের সন (ইংরেজি)" />
                        <select
                            v-model="form.dept_ifta_year_english"
                            @change="handleEnglishYearChange(form.dept_ifta_year_english, 'ifta')"
                            :class="getFieldErrorClass('dept_ifta_year_english')"
                            :disabled="loading">
                            <option value="">সন নির্বাচন করুন</option>
                            <option
                                v-for="year in englishYearOptions"
                                :key="year.value"
                                :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_ifta_year_english" />
                    </div>
                    <div>
                        <InputLabel class="text-sm font-medium" value="ফারাগাতের সন (হিজরি)" />
                        <select
                            v-model="form.dept_ifta_year_hijri"
                            @change="handleHijriYearChange(form.dept_ifta_year_hijri, 'ifta')"
                            :class="getFieldErrorClass('dept_ifta_year_hijri')"
                            :disabled="loading">
                            <option value="">হিজরি সন নির্বাচন করুন</option>
                            <option
                                v-for="year in hijriYearOptions"
                                :key="year.value"
                                :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_ifta_year_hijri" />
                    </div>
                </div>
            </div>

            <!-- হিফজ -->
            <div class="border rounded-lg p-4 mb-4">
                <div class="flex items-center mb-3">
                    <input id="hifz" v-model="form.dept_hifz" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                    <label for="hifz" class="text-sm font-medium text-gray-700">হিফজ</label>
                </div>
                <div v-if="form.dept_hifz" class="grid grid-cols-2 gap-4 ml-6">
                    <div>
                        <InputLabel class="text-sm font-medium" value="ফারাগাতের সন (ইংরেজি)" />
                        <select
                            v-model="form.dept_hifz_year_english"
                            @change="handleEnglishYearChange(form.dept_hifz_year_english, 'hifz')"
                            :class="getFieldErrorClass('dept_hifz_year_english')"
                            :disabled="loading">
                            <option value="">সন নির্বাচন করুন</option>
                            <option
                                v-for="year in englishYearOptions"
                                :key="year.value"
                                :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_hifz_year_english" />
                    </div>
                    <div>
                        <InputLabel class="text-sm font-medium" value="ফারাগাতের সন (হিজরি)" />
                        <select
                            v-model="form.dept_hifz_year_hijri"
                            @change="handleHijriYearChange(form.dept_hifz_year_hijri, 'hifz')"
                            :class="getFieldErrorClass('dept_hifz_year_hijri')"
                            :disabled="loading">
                            <option value="">হিজরি সন নির্বাচন করুন</option>
                            <option
                                v-for="year in hijriYearOptions"
                                :key="year.value"
                                :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_hifz_year_hijri" />
                    </div>
                </div>
            </div>

            <!-- কিরাআত -->
            <div class="border rounded-lg p-4 mb-4">
                <div class="flex items-center mb-3">
                    <input id="qirat" v-model="form.dept_qirat" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                    <label for="qirat" class="text-sm font-medium text-gray-700">কিরাআত</label>
                </div>
                <div v-if="form.dept_qirat" class="grid grid-cols-2 gap-4 ml-6">
                    <div>
                        <InputLabel class="text-sm font-medium" value="ফারাগাতের সন (ইংরেজি)" />
                        <select
                            v-model="form.dept_qirat_year_english"
                            @change="handleEnglishYearChange(form.dept_qirat_year_english, 'qirat')"
                            :class="getFieldErrorClass('dept_qirat_year_english')"
                            :disabled="loading">
                            <option value="">সন নির্বাচন করুন</option>
                            <option
                                v-for="year in englishYearOptions"
                                :key="year.value"
                                :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_qirat_year_english" />
                    </div>
                    <div>
                        <InputLabel class="text-sm font-medium" value="ফারাগাতের সন (হিজরি)" />
                        <select
                            v-model="form.dept_qirat_year_hijri"
                            @change="handleHijriYearChange(form.dept_qirat_year_hijri, 'qirat')"
                            :class="getFieldErrorClass('dept_qirat_year_hijri')"
                            :disabled="loading">
                            <option value="">হিজরি সন নির্বাচন করুন</option>
                            <option
                                v-for="year in hijriYearOptions"
                                :key="year.value"
                                :value="year.value">
                                {{ year.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="fieldValidation.dept_qirat_year_hijri" />
                    </div>
                </div>
            </div>

            <!-- ✅ নতুন: অন্যান্য বিভাগ (শুধু কোন ক্লাসে পড়েন) -->
            <div class="border rounded-lg p-4 mb-4">
                <div class="flex items-center mb-3">
                    <input id="other" v-model="form.dept_other" type="checkbox"
                        class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                    <label for="other" class="text-sm font-medium text-gray-700">অন্যান্য</label>
                </div>
                <!-- এই অংশটি আপডেট করা হয়েছে -->
                <div v-if="form.dept_other" class="ml-6">
                    <InputLabel class="text-sm font-medium" value="কোন সেকশনে পড়েন?" />
                    <select
                        v-model="form.dept_other_class"
                        :class="getFieldErrorClass('dept_other_class')"
                        required
                    >
                        <option value="">নির্বাচন করুন</option>
                        <option value="উলুমুল হাদিস">উলুমুল হাদিস</option>
                        <option value="ইফতা">ইফতা</option>
                        <option value="আদব">আদব</option>
                        <option value="তাকমিল (দাওরা)">তাকমিল (দাওরা)</option>
                        <option value="ফযিলত (মেশাকাত)">ফযিলত (মেশাকাত)</option>
                        <option value="জালালাইন">জালালাইন</option>
                        <option value="হেদায়া">হেদায়া</option>
                        <option value="শরহে বেকায়া">শরহে বেকায়া</option>
                        <option value="কাফিয়া">কাফিয়া</option>
                        <option value="হেদায়াতুন্নাহু">হেদায়াতুন্নাহু</option>
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
            <div v-if="fieldValidation.departments" class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
                <div class="flex items-center text-red-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ fieldValidation.departments }}
                </div>
            </div>
        </div>

        <!-- পরীক্ষার ধরন -->
        <div class="mb-6">
            <InputLabel for="examType" class="text-lg font-medium" value="আইডির ধরন" />
            <select id="examType" v-model="form.examType"
                :class="getFieldErrorClass('examType')"
                required>
                <option value="">আইডি</option>
                <option value="দাখিলা">দাখিলা</option>
                <option value="হাইয়ার">হাইয়ার</option>
                <option value="বেফাক">বেফাক</option>
                <option value="জানা নেই">জানা নেই</option>
            </select>
            <InputError class="mt-2" :message="fieldValidation.examType" />
        </div>

        <!-- রোল নাম্বার (শুধুমাত্র examType সিলেক্ট করা হলে এবং "জানা নেই" না হলে দেখাবে) -->
        <div v-if="form.examType && form.examType !== 'জানা নেই'" class="mb-6">
            <InputLabel for="rollNumber" class="text-lg font-medium" value="রোল নাম্বার" />
            <input id="rollNumber" type="text"
                :class="getFieldErrorClass('rollNumber')"
                v-model="form.rollNumber"
                placeholder="রোল নাম্বার প্রবেশ করুন"
                required />
            <InputError class="mt-2" :message="fieldValidation.rollNumber" />
        </div>

        <!-- কর্মস্থল/পেশা (ড্রপডাউন) -->
        <div class="mb-6">
            <InputLabel for="workplace" class="text-lg font-medium" value="কর্মস্থল/পেশা" />
            <select id="workplace" v-model="form.workplace"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">নির্বাচন করুন</option>
                <option value="ইমাম">শাইখুল হাদিস</option>
                <option value="প্রধান মুফতি">প্রধান মুফতি</option>
                <option value="মুঈনে মুফতি">মুঈনে মুফতি</option>
                <option value="মুফতি">মুফতি</option>
                <option value="মুফতি">আদীব</option>
                <option value="মুফতি">মাদরাসা শিক্ষক</option>
                <option value="ইমাম">ইমাম</option>
                <option value="খতিব">খতিব</option>
                <option value="মুয়াজ্জিন">মুয়াজ্জিন</option>
                <option value="মসজিদের খাদেম">মসজিদের খাদেম</option>
                <option value="মুহতামিম">মুহতামিম</option>
                <option value="ব্যবসায়ী">ব্যবসায়ী</option>
                <option value="প্রবাসি">প্রবাসি</option>
                <option value="চাকুরিজীবি">চাকুরিজীবি</option>
                    <option value="চাকুরিজীবি">বক্তা</option>
                <option value="অন্যান্য">অন্যান্য</option>
            </select>
            <InputError class="mt-2" :message="form.errors.workplace" />
        </div>

        <!-- ✅ নতুন: পরিচয়পত্র টাইপ নির্বাচন (জন্মসনদ/ভোটার আইডি) -->
        <div class="mb-6">
            <InputLabel for="idType" class="text-lg font-medium" value="পরিচয়পত্র টাইপ" />
            <select id="idType" v-model="form.idType"
                :class="getFieldErrorClass('idType')"
                required>
                <option value="">নির্বাচন করুন</option>
                <option value="birth">জন্মসনদ</option>
                <option value="voter">ভোটার আইডি</option>
                <!-- <option value="জানা নেই">জানা নেই</option> -->
            </select>
            <InputError class="mt-2" :message="fieldValidation.idType" />
        </div>

        <!-- "জানা নেই" সিলেক্ট করা হলে একটি বার্তা দেখানো -->
        <div v-if="form.idType === 'জানা নেই'" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
            <div class="flex items-center text-blue-700">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-medium">পরিচয়পত্রের তথ্য জানা নেই</p>
                    <p class="text-sm">আপনার পরিচয়পত্রের তথ্য জানা না থাকলে কোনো সমস্যা নেই। পরবর্তীতে আপডেট করতে পারবেন।</p>
                </div>
            </div>
        </div>

        <!-- জন্মনিবন্ধন নম্বর ও ছবি -->
        <div v-if="form.idType === 'birth'" class="mb-6">
            <InputLabel for="birthCertificate" class="text-lg font-medium" value="জন্মনিবন্ধন নম্বর" />
            <input id="birthCertificate" type="text" :class="getFieldErrorClass('birthCertificate')" v-model="form.birthCertificate"
                placeholder="জন্মনিবন্ধন নম্বর লিখুন" />
            <InputError class="mt-2" :message="fieldValidation.birthCertificate" />
            <!-- ✅ জন্মনিবন্ধন ছবির আপলোড -->
            <div class="mt-3">
                <InputLabel for="birthCertificatePhoto" class="text-lg font-medium"
                    value="জন্মনিবন্ধন কার্ড/সার্টিফিকেটের ছবি" />
                <input id="birthCertificatePhoto" type="file" accept="image/*" @change="handleIdPhotoUpload"
                    :class="getFileErrorClass('birthCertificatePhoto')" />

                <!-- Previously uploaded file indicator -->
                <div v-if="getUploadedFileName('birth_cert_photo')" class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                    <div class="flex items-center text-sm text-green-700">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        পূর্বে আপলোড করা ফাইল: {{ getUploadedFileName('birth_cert_photo') }}
                    </div>
                </div>

                <InputError class="mt-2" :message="fieldValidation.birthCertificatePhoto" />
            </div>
        </div>
        <!-- ভোটার আইডি নম্বর ও ছবি -->
        <div v-if="form.idType === 'voter'" class="mb-6">
            <InputLabel for="voterId" class="text-lg font-medium" value="ভোটার আইডি নম্বর" />
            <input id="voterId" type="text" :class="getFieldErrorClass('voterId')" v-model="form.voterId"
                placeholder="ভোটার আইডি নম্বর লিখুন" />
            <InputError class="mt-2" :message="fieldValidation.voterId" />
            <div class="mt-3">
                <InputLabel for="voterIdPhoto" class="text-lg font-medium" value="ভোটার আইডি কার্ডের ছবি" />
                <input id="voterIdPhoto" type="file" accept="image/*" @change="handleIdPhotoUpload"
                    :class="getFileErrorClass('voterIdPhoto')" />

                <!-- Previously uploaded file indicator -->
                <div v-if="getUploadedFileName('voter_photo')" class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                    <div class="flex items-center text-sm text-green-700">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        পূর্বে আপলোড করা ফাইল: {{ getUploadedFileName('voter_photo') }}
                    </div>
                </div>

                <InputError class="mt-2" :message="fieldValidation.voterIdPhoto" />
            </div>
        </div>

        <!-- লাইভ ছবি আপলোড (শুধুমাত্র যখন idType 'জানা নেই' না হয়) -->
        <div v-if="form.idType && form.idType !== 'জানা নেই'" class="mb-6">
            <InputLabel for="photo" class="text-lg font-medium" value="লাইভ ছবি আপলোড" />
            <input id="photo" type="file" accept="image/*" capture="user" @change="handlePhotoUpload"
                :class="getFileErrorClass('photo')" />

            <!-- Previously uploaded file indicator -->
            <div v-if="getUploadedFileName('photo')" class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                <div class="flex items-center text-sm text-green-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    পূর্বে আপলোড করা ফাইল: {{ getUploadedFileName('photo') }}
                </div>
            </div>

            <p class="text-xs text-gray-500 mt-1">মোবাইল ক্যামেরা দিয়ে সরাসরি ছবি তুলুন</p>
            <InputError class="mt-2" :message="fieldValidation.photo" />
        </div>
    </div>
</template>
