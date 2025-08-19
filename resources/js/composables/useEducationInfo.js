import { ref, computed, watch, onMounted, nextTick } from 'vue';
import axios from 'axios';

export function useEducationInfo(props) {
    // Reactive data
    const isInitializing = ref(true);
    const sessionYears = ref([]);
    const loading = ref(true);
    const error = ref(null);
    const workplaceArray = ref([]);

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
        if (!workplaceArray.value || workplaceArray.value.length === 0) {
            errors.workplace = 'কর্মস্থল/পেশা নির্বাচন করুন';
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

    // LocalStorage functions
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

    // Handle workplace conversion between string and array
    const initializeWorkplace = () => {
        if (typeof props.form.workplace === 'string' && props.form.workplace) {
            workplaceArray.value = props.form.workplace.split(',').map(item => item.trim()).filter(item => item !== '');
        } else if (Array.isArray(props.form.workplace)) {
            workplaceArray.value = [...props.form.workplace];
        } else {
            workplaceArray.value = [];
        }
    };

    // Convert array back to string for form submission
    const updateWorkplaceString = () => {
        props.form.workplace = workplaceArray.value.join(', ');
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

    // Form data management
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
            workplaceArray: workplaceArray.value,
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

            // Handle workplace array restoration
            if (savedData.workplaceArray && Array.isArray(savedData.workplaceArray)) {
                workplaceArray.value = savedData.workplaceArray;
            } else if (savedData.workplace) {
                initializeWorkplace();
            }
        }
    };

    // Image resize utility
    const resizeImageToMax200KB = async (file) => {
        if (!file.type.startsWith('image/')) return file;
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = function (event) {
                const img = new window.Image();
                img.onload = function () {
                    let quality = 0.92;
                    let canvas = document.createElement('canvas');
                    let ctx = canvas.getContext('2d');
                    let width = img.width;
                    let height = img.height;
                    
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

    // File upload handlers
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
                alert("ছবিটি ২০০ কেবি'র নিচে রাখতে হবে।");
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
                alert("ছবিটি ২০০ কেবি'র নিচে রাখতে হবে।");
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
        } else if (props.form.idType === 'passport') {
            props.form.passport_photo = finalFile;
            if (finalFile) {
                const fileInfo = {
                    name: finalFile.name,
                    size: finalFile.size,
                    type: finalFile.type,
                    lastModified: finalFile.lastModified
                };
                saveToStorage('education_passport_photo_info', fileInfo);
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

    // Initialize the composable
    const initialize = async () => {
        await fetchSessionYears();
        initializeWorkplace();
        loadEducationFormData();
        await nextTick();
        isInitializing.value = false;
    };

    // Watch all form fields for changes to save to localStorage
    watch(() => props.form, () => {
        if (!isInitializing.value) {
            saveEducationFormData();
        }
    }, { deep: true });

    // Watch workplace array changes and convert to string
    watch(workplaceArray, (newValue) => {
        if (!isInitializing.value) {
            updateWorkplaceString();
            saveEducationFormData();
        }
    }, { deep: true });

    // Watch form.workplace changes from outside and update local array
    watch(() => props.form.workplace, (newValue) => {
        if (!isInitializing.value && typeof newValue === 'string') {
            const newArray = newValue ? newValue.split(',').map(item => item.trim()).filter(item => item !== '') : [];
            if (JSON.stringify(newArray) !== JSON.stringify(workplaceArray.value)) {
                workplaceArray.value = newArray;
            }
        }
    });

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

    return {
        // Data
        sessionYears,
        loading,
        error,
        workplaceArray,
        
        // Computed
        englishYearOptions,
        hijriYearOptions,
        fieldValidation,
        
        // Methods
        getFieldErrorClass,
        getFileErrorClass,
        handleEnglishYearChange,
        handleHijriYearChange,
        handlePhotoUpload,
        handleIdPhotoUpload,
        getUploadedFileName,
        initialize
    };
}
