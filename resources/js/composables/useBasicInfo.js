import { ref, computed, watch, onMounted, nextTick } from 'vue';
import axios from 'axios';

export function useBasicInfo(props) {
    // Data from API
    const divisions = ref([]);
    const districts = ref([]);
    const thanas = ref([]);
    const loading = ref(false);
    const isInitializing = ref(true);

    // Date picker reactive data
    const selectedDay = ref('');
    const selectedMonth = ref('');
    const selectedYear = ref('');

    // Generate year range (from 1950 to current year)
    const yearRange = computed(() => {
        const currentYear = new Date().getFullYear();
        const years = [];
        for (let year = currentYear; year >= 1950; year--) {
            years.push(year);
        }
        return years;
    });

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
        else if (props.form.phoneNumber.length !== 11) errors.phoneNumber = 'ফোন নম্বর অবশ্যই ১১ সংখ্যার হতে হবে';
        else if (!/^[0-9]+$/.test(props.form.phoneNumber)) errors.phoneNumber = 'ফোন নম্বরে শুধুমাত্র সংখ্যা থাকবে';
        if (!props.form.dateOfBirth) errors.dateOfBirth = 'জন্মতারিখ প্রয়োজন';
        if (!props.form.address) errors.address = 'ঠিকানা প্রয়োজন';
        if (!props.form.division) errors.division = 'বিভাগ নির্বাচন করুন';
        if (!props.form.district) errors.district = 'জেলা নির্বাচন করুন';
        if (!props.form.thana) errors.thana = 'থানা নির্বাচন করুন';
        if (!props.form.classmate1) errors.classmate1 = 'সহপাঠী ১ এর নাম প্রয়োজন';
        if (!props.form.classmate2) errors.classmate2 = 'সহপাঠী ২ এর নাম প্রয়োজন';
        if (!props.form.classmate3) errors.classmate3 = 'সহপাঠী ৩ এর নাম প্রয়োজন';

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

    // Update date of birth from dropdowns
    const updateDateOfBirth = () => {
        if (selectedDay.value && selectedMonth.value && selectedYear.value) {
            const day = selectedDay.value.toString().padStart(2, '0');
            const month = selectedMonth.value.toString().padStart(2, '0');
            const year = selectedYear.value;
            props.form.dateOfBirth = `${year}-${month}-${day}`;
        } else {
            props.form.dateOfBirth = '';
        }
    };

    // Initialize date picker from existing dateOfBirth
    const initializeDatePicker = () => {
        if (props.form.dateOfBirth) {
            const dateObj = new Date(props.form.dateOfBirth);
            selectedDay.value = dateObj.getDate();
            selectedMonth.value = dateObj.getMonth() + 1; // getMonth() returns 0-11
            selectedYear.value = dateObj.getFullYear();
        }
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

    // Initialize the composable
    const initialize = async () => {
        await fetchDivisions();

        // Load saved form data
        loadFormData();

        // Initialize date picker from existing dateOfBirth
        initializeDatePicker();

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

    // Watch for changes in dateOfBirth to update date picker
    watch(() => props.form.dateOfBirth, () => {
        if (!isInitializing.value) {
            initializeDatePicker();
        }
    });

    // Watch date picker fields to update form
    watch([selectedDay, selectedMonth, selectedYear], () => {
        if (!isInitializing.value) {
            updateDateOfBirth();
        }
    });

    return {
        // Data
        divisions,
        districts,
        thanas,
        loading,
        selectedDay,
        selectedMonth,
        selectedYear,
        
        // Computed
        yearRange,
        availableDistricts,
        availableThanas,
        fieldValidation,
        
        // Methods
        getFieldErrorClass,
        getSelectErrorClass,
        getTextareaErrorClass,
        updateDateOfBirth,
        initialize
    };
}
