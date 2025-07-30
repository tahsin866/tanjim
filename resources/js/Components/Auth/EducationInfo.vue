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

    if (!hasAnyDepartment) {
        errors.departments = 'অন্তত একটি বিভাগ নির্বাচন করুন';
    }
    if (props.form.dept_takmil && (!props.form.dept_takmil_year_english || !props.form.dept_takmil_year_hijri)) {
        if (!props.form.dept_takmil_year_english) errors.dept_takmil_year_english = 'তাকমিল ইংরেজি সন নির্বাচন করুন';
        if (!props.form.dept_takmil_year_hijri) errors.dept_takmil_year_hijri = 'তাকমিল হিজরি সন নির্বাচন করুন';
    }
    if (props.form.dept_ifta && (!props.form.dept_ifta_year_english || !props.form.dept_ifta_year_hijri)) {
        if (!props.form.dept_ifta_year_english) errors.dept_ifta_year_english = 'ইফতা ইংরেজি সন নির্বাচন করুন';
        if (!props.form.dept_ifta_year_hijri) errors.dept_ifta_year_hijri = 'ইফতা হিজরি সন নির্বাচন করুন';
    }
    if (props.form.dept_hifz && (!props.form.dept_hifz_year_english || !props.form.dept_hifz_year_hijri)) {
        if (!props.form.dept_hifz_year_english) errors.dept_hifz_year_english = 'হিফজ ইংরেজি সন নির্বাচন করুন';
        if (!props.form.dept_hifz_year_hijri) errors.dept_hifz_year_hijri = 'হিফজ হিজরি সন নির্বাচন করুন';
    }
    if (props.form.dept_qirat && (!props.form.dept_qirat_year_english || !props.form.dept_qirat_year_hijri)) {
        if (!props.form.dept_qirat_year_english) errors.dept_qirat_year_english = 'কিরাআত ইংরেজি সন নির্বাচন করুন';
        if (!props.form.dept_qirat_year_hijri) errors.dept_qirat_year_hijri = 'কিরাআত হিজরি সন নির্বাচন করুন';
    }
    if (props.form.dept_other && !props.form.dept_other_class) {
        errors.dept_other_class = 'অন্যান্য বিভাগের ক্লাস নির্বাচন করুন';
    }
    if (!props.form.examType) {
        errors.examType = 'আইডির ধরন নির্বাচন করুন';
    }
    if (props.form.examType && props.form.examType !== 'জানা নেই' && !props.form.rollNumber) {
        errors.rollNumber = 'রোল নাম্বার লিখুন';
    }
    if (!props.form.idType) {
        errors.idType = 'পরিচয়পত্র টাইপ নির্বাচন করুন';
    }
    if (props.form.idType === 'birth') {
        if (!props.form.birthCertificate) errors.birthCertificate = 'জন্মনিবন্ধন নম্বর লিখুন';
        if (!props.form.birthCertificatePhoto) errors.birthCertificatePhoto = 'জন্মনিবন্ধন ছবি আপলোড করুন';
    }
    if (props.form.idType === 'voter') {
        if (!props.form.voterId) errors.voterId = 'ভোটার আইডি নম্বর লিখুন';
        if (!props.form.voterIdPhoto) errors.voterIdPhoto = 'ভোটার আইডি ছবি আপলোড করুন';
    }
    // লাইভ ছবির ফিল্ড নেই (আরো নিচে অপশনে মোবাইল ক্যামেরা বাদ)
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

const saveToStorage = (key, data) => {
    try {
        localStorage.setItem(key, JSON.stringify(data));
    } catch (error) {
        console.error('Error saving to localStorage:', error);
    }
};
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

const handleEnglishYearChange = (englishYear, department) => {
    if (!isInitializing.value && englishYear) {
        syncHijriFromEnglish(englishYear, department);
        saveEducationFormData();
    }
};
const handleHijriYearChange = (hijriYear, department) => {
    if (!isInitializing.value && hijriYear) {
        syncEnglishFromHijri(hijriYear, department);
        saveEducationFormData();
    }
};

const saveEducationFormData = () => {
    const formData = {
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
        examType: props.form.examType,
        rollNumber: props.form.rollNumber,
        workplace: props.form.workplace,
        idType: props.form.idType,
        birthCertificate: props.form.birthCertificate,
        voterId: props.form.voterId,
        photoFileName: props.form.photo?.name || null,
        birthCertificatePhotoFileName: props.form.birthCertificatePhoto?.name || null,
        voterIdPhotoFileName: props.form.voterIdPhoto?.name || null
    };
    saveToStorage(STORAGE_KEYS.educationFormData, formData);
};
const loadEducationFormData = () => {
    const savedData = loadFromStorage(STORAGE_KEYS.educationFormData);
    if (savedData) {
        Object.keys(savedData).forEach(key => {
            if (props.form.hasOwnProperty(key) && savedData[key] !== null && savedData[key] !== undefined) {
                if (!key.endsWith('FileName')) {
                    props.form[key] = savedData[key];
                }
            }
        });
    }
};

// 200KB resize utility
const resizeImageToMax200KB = async (file) => {
    // Only process images
    if (!file.type.startsWith('image/')) return file;
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = function (event) {
            const img = new window.Image();
            img.onload = function () {
                // Set initial quality and resizing
                let quality = 0.92;
                let canvas = document.createElement('canvas');
                let ctx = canvas.getContext('2d');
                let width = img.width;
                let height = img.height;
                // Downscale if too large (max 1200px)
                if (width > 1200) {
                    height *= 1200 / width;
                    width = 1200;
                }
                if (height > 1200) {
                    width *= 1200 / height;
                    height = 1200;
                }
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                function tryCompress() {
                    canvas.toBlob(async (blob) => {
                        if (blob.size <= 200 * 1024 || quality < 0.5) {
                            resolve(new File([blob], file.name, { type: file.type }));
                        } else {
                            quality -= 0.05;
                            canvas.toBlob(tryCompress, file.type, quality);
                        }
                    }, file.type, quality);
                }
                tryCompress();
            };
            img.onerror = reject;
            img.src = event.target.result;
        };
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
};

// File upload handlers with resize & 200KB max limit
const handlePhotoUpload = async (event) => {
    const file = event.target.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) {
        alert('শুধু ছবি ফাইল আপলোড করুন।');
        return;
    }
    let finalFile = file;
    if (file.size > 200 * 1024) {
        finalFile = await resizeImageToMax200KB(file);
        if (finalFile.size > 200 * 1024) {
            alert('ছবিটি ২০০ কেবি’র নিচে রাখতে হবে।');
            return;
        }
    }
    props.form.photo = finalFile;
    if (finalFile) {
        const fileInfo = {
            name: finalFile.name,
            size: finalFile.size,
            type: finalFile.type,
            lastModified: finalFile.lastModified
        };
        saveToStorage('education_photo_info', fileInfo);
    }
    if (!isInitializing.value) {
        saveEducationFormData();
    }
};

const handleIdPhotoUpload = async (event) => {
    const file = event.target.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) {
        alert('শুধু ছবি ফাইল আপলোড করুন।');
        return;
    }
    let finalFile = file;
    if (file.size > 200 * 1024) {
        finalFile = await resizeImageToMax200KB(file);
        if (finalFile.size > 200 * 1024) {
            alert('ছবিটি ২০০ কেবি’র নিচে রাখতে হবে।');
            return;
        }
    }
    if (props.form.idType === 'birth') {
        props.form.birthCertificatePhoto = finalFile;
        if (finalFile) {
            const fileInfo = {
                name: finalFile.name,
                size: finalFile.size,
                type: finalFile.type,
                lastModified: finalFile.lastModified
            };
            saveToStorage('education_birth_cert_photo_info', fileInfo);
        }
    } else if (props.form.idType === 'voter') {
        props.form.voterIdPhoto = finalFile;
        if (finalFile) {
            const fileInfo = {
                name: finalFile.name,
                size: finalFile.size,
                type: finalFile.type,
                lastModified: finalFile.lastModified
            };
            saveToStorage('education_voter_photo_info', fileInfo);
        }
    }
    if (!isInitializing.value) {
        saveEducationFormData();
    }
};

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

watch(() => props.form.examType, (newValue) => {
    if (newValue === 'জানা নেই') {
        props.form.rollNumber = '';
    }
});
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
    await fetchSessionYears();
    loadEducationFormData();
    await nextTick();
    isInitializing.value = false;
});
</script>

<template>
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6 border-b pb-2">শিক্ষাগত তথ্য</h3>

        <!-- বিভাগ সেকশন -->
        <!-- ... (বাকিটা অপরিবর্তিত) ... -->

        <!-- জন্মনিবন্ধন নম্বর ও ছবি -->
        <div v-if="form.idType === 'birth'" class="mb-6">
            <InputLabel for="birthCertificate" class="text-lg font-medium dark:text-white" value="জন্মনিবন্ধন নম্বর" />
            <input id="birthCertificate" type="text" :class="[getFieldErrorClass('birthCertificate'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']" v-model="form.birthCertificate"
                placeholder="জন্মনিবন্ধন নম্বর লিখুন" />
            <InputError class="mt-2" :message="fieldValidation.birthCertificate" />
            <!-- ✅ জন্মনিবন্ধন ছবির আপলোড -->
            <div class="mt-3">
                <InputLabel for="birthCertificatePhoto" class="text-lg font-medium dark:text-white"
                    value="জন্মনিবন্ধন কার্ড/সার্টিফিকেটের ছবি (২০০ কেবি’র নিচে)" />
                <input id="birthCertificatePhoto" type="file" accept="image/*" @change="handleIdPhotoUpload"
                    :class="[getFileErrorClass('birthCertificatePhoto'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']" />

                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
                </div>
                <div v-if="getUploadedFileName('birth_cert_photo')" class="mt-2 p-2 bg-green-50 dark:bg-gray-800 border border-green-200 dark:border-green-700 rounded-md">
                    <div class="flex items-center text-sm text-green-700 dark:text-green-300">
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
            <InputLabel for="voterId" class="text-lg font-medium dark:text-white" value="ভোটার আইডি নম্বর" />
            <input id="voterId" type="text" :class="[getFieldErrorClass('voterId'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']" v-model="form.voterId"
                placeholder="ভোটার আইডি নম্বর লিখুন" />
            <InputError class="mt-2" :message="fieldValidation.voterId" />
            <div class="mt-3">
                <InputLabel for="voterIdPhoto" class="text-lg font-medium dark:text-white" value="ভোটার আইডি কার্ডের ছবি (২০০ কেবি’র নিচে)" />
                <input id="voterIdPhoto" type="file" accept="image/*" @change="handleIdPhotoUpload"
                    :class="[getFileErrorClass('voterIdPhoto'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']" />

                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
                </div>
                <div v-if="getUploadedFileName('voter_photo')" class="mt-2 p-2 bg-green-50 dark:bg-gray-800 border border-green-200 dark:border-green-700 rounded-md">
                    <div class="flex items-center text-sm text-green-700 dark:text-green-300">
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
        <!-- লাইভ ক্যামেরা অপশন বাদ -->
        <div v-if="form.idType && form.idType !== 'জানা নেই'" class="mb-6">
            <InputLabel for="photo" class="text-lg font-medium dark:text-white" value="ছবি আপলোড করুন (২০০ কেবি’র নিচে)" />
            <input id="photo" type="file" accept="image/*" @change="handlePhotoUpload"
                :class="[getFileErrorClass('photo'), 'dark:bg-gray-800 dark:text-white dark:border-gray-700']" />

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                সর্বাধিক ফাইল সাইজ: ২০০ কেবি। বড় ছবি অটো-কমপ্রেস হবে।
            </div>
            <div v-if="getUploadedFileName('photo')" class="mt-2 p-2 bg-green-50 dark:bg-gray-800 border border-green-200 dark:border-green-700 rounded-md">
                <div class="flex items-center text-sm text-green-700 dark:text-green-300">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    পূর্বে আপলোড করা ফাইল: {{ getUploadedFileName('photo') }}
                </div>
            </div>
            <InputError class="mt-2" :message="fieldValidation.photo" />
        </div>
    </div>
</template>
