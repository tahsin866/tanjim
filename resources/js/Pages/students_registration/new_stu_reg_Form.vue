<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, onMounted } from 'vue'

import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    roll: String,
    reg_id: String,
    CID: String,
    modelValue: Object
});



const selectedDate = ref('')
const items = ref([])




const studentInfoForm = useForm({
    // student_id: '',      // Will be populated from pastExamForm.id
    name_bn: '',         // Will be populated from pastExamForm.Name
    name_en: '',         // New field for English name
    name_ar: '',         // New field for Arabic name
    father_name_bn: '',  // Will be populated from pastExamForm.Father
    father_name_en: '',  // New field for father's English name
    father_name_ar: '',  // New field for father's Arabic name
    mother_name_bn: '',  // Will be populated from pastExamForm.Mother
    mother_name_en: '',  // New field for mother's English name
    mother_name_ar: '',  // New field for mother's Arabic name
    BRN_no: '', // New field for birth certificate
    NID_no: '',
    past_Roll: '',            // New field for national ID
    past_reg_id: '',
    madrasha_id: '',
    class: '',
    Division: '',
    Date_of_birth: '',
    current_madrasha: '',
    current_markaz: '',
    student_type: '',
    current_class: '',
    exam_books_name: '',
    mobile_no: '',
    board_name: '',
    marhala_id: '',

    present_division_name: '',
    presernt_DID: '',
    present_district_name: '',
    present_desId: '',
    present_thana_name: '',
    present_TID: '',

    // New fields for permanent address
    parmanent_division_name: '',
    parmanent_DID: '',
    parmanent_district_name: '',
    parmanent_desId: '',
    parmanent_thana_name: '',
    parmanent_TID: '',
    student_image: '',
    markaz_id: ''
});




const submitStudentInfo = () => {
    // আগে ঠিকানার ডাটা আপডেট করুন
    updateFormData();

    console.log('Form data after update:', studentInfoForm);

    // ফাইল যোগ করুন
    if (studentPhotoFile.value) {
        studentInfoForm.student_image = studentPhotoFile.value;
    }

    if (birthCertificateFile.value) {
        studentInfoForm.NID_attach = birthCertificateFile.value;
    }

    // Get the marhala ID from your component state
    const marhalaId = currentMarhalaId.value;

    // ফর্ম সাবমিট করুন - Include marhalaId in the URL
    studentInfoForm.post(`/api/save-student-info_1/${marhalaId}`, {
        forceFormData: true,
        onSuccess: () => {
            alert('Student information saved successfully');
        },
        onError: (errors) => {
            console.error('Error saving student information:', errors);
        }
    });
};











const onSubmit = () => {
    console.log(formData.value)
}




const studentPhotoFile = ref(null);
const birthCertificateFile = ref(null);
const marksheetFile = ref(null);

// Preview URLs
const studentPhotoPreview = ref(null);
const birthCertificatePreview = ref(null);
const marksheetPreview = ref(null);

// Handle file upload
const handleFileUpload = (event, fileType) => {
    const file = event.target.files[0];
    if (!file) return;

    // Set the file reference based on type
    if (fileType === 'studentPhoto') {
        studentPhotoFile.value = file;
        createFilePreview(file, 'studentPhoto');
    } else if (fileType === 'birthCertificate') {
        birthCertificateFile.value = file;
        createFilePreview(file, 'birthCertificate');
    } else if (fileType === 'marksheet') {
        marksheetFile.value = file;
        createFilePreview(file, 'marksheet');
    }
};

// Create preview URL for the file
const createFilePreview = (file, fileType) => {
    // For images, create a preview URL
    if (file.type.startsWith('image/')) {
        const previewUrl = URL.createObjectURL(file);

        if (fileType === 'studentPhoto') {
            studentPhotoPreview.value = previewUrl;
        } else if (fileType === 'birthCertificate') {
            birthCertificatePreview.value = previewUrl;
        } else if (fileType === 'marksheet') {
            marksheetPreview.value = previewUrl;
        }
    }
    // For PDFs and other documents, we can still create a URL for download/preview
    else {
        const previewUrl = URL.createObjectURL(file);

        if (fileType === 'studentPhoto') {
            studentPhotoPreview.value = previewUrl;
        } else if (fileType === 'birthCertificate') {
            birthCertificatePreview.value = previewUrl;
        } else if (fileType === 'marksheet') {
            marksheetPreview.value = previewUrl;
        }
    }
};

// Remove file
const removeFile = (fileType) => {
    if (fileType === 'studentPhoto') {
        if (studentPhotoPreview.value) {
            URL.revokeObjectURL(studentPhotoPreview.value);
        }
        studentPhotoFile.value = null;
        studentPhotoPreview.value = null;
    } else if (fileType === 'birthCertificate') {
        if (birthCertificatePreview.value) {
            URL.revokeObjectURL(birthCertificatePreview.value);
        }
        birthCertificateFile.value = null;
        birthCertificatePreview.value = null;
    } else if (fileType === 'marksheet') {
        if (marksheetPreview.value) {
            URL.revokeObjectURL(marksheetPreview.value);
        }
        marksheetFile.value = null;
        marksheetPreview.value = null;
    }
};




// Expose files for form submission
defineExpose({
    getFiles: () => ({
        studentPhoto: studentPhotoFile.value,
        birthCertificate: birthCertificateFile.value,
        marksheet: marksheetFile.value
    })
});








const emit = defineEmits(['update:modelValue']);

const divisions = ref([]);
const presentDistricts = ref([]);
const presentThanas = ref([]);
const districts = ref([]);
const thanas = ref([]);

// Separate refs for present and permanent address data
const presentFilters = ref({
    division: '',
    district: '',
    Thana: ''
});

const permanentFilters = ref({
    division: '',
    district: '',
    Thana: ''
});

// Initialize filters from props if they exist
const initializeFilters = () => {
    if (props.modelValue && props.modelValue.presernt_DID) {
        presentFilters.value.division = props.modelValue.presernt_DID;
    }
    if (props.modelValue && props.modelValue.present_des_id) {
        presentFilters.value.district = props.modelValue.present_des_id;
    }
    if (props.modelValue && props.modelValue.present_TID) {
        presentFilters.value.Thana = props.modelValue.present_TID;
    }

    if (props.modelValue && props.modelValue.parmanent_DID) {
        permanentFilters.value.division = props.modelValue.parmanent_DID;
    }
    if (props.modelValue && props.modelValue.parmanent_desId) {
        permanentFilters.value.district = props.modelValue.parmanent_desId;
    }
    if (props.modelValue && props.modelValue.parmanent_TID) {
        permanentFilters.value.Thana = props.modelValue.parmanent_TID;
    }
};

// Watch for changes in props.modelValue to initialize filters
watch(() => props.modelValue, (newValue) => {
    if (newValue) {
        initializeFilters();
    }
}, { immediate: true });

// Watch for changes in presentFilters and update the form
watch(presentFilters, async (newValues) => {
    if (!props.modelValue) return;

    const updatedValue = { ...props.modelValue };

    // Update division
    if (newValues.division) {
        const selectedDivision = divisions.value.find(d => d.id == newValues.division);
        if (selectedDivision) {
            updatedValue.present_division_name = selectedDivision.Division_U;
            updatedValue.presernt_DID = selectedDivision.id;
        }
    }

    // Update district
    if (newValues.district) {
        const selectedDistrict = presentDistricts.value.find(d => d.DesID == newValues.district);
        if (selectedDistrict) {
            updatedValue.present_district_name = selectedDistrict.District_U;
            updatedValue.present_des_id = selectedDistrict.DesID;
        }
    }

    // Update thana
    if (newValues.Thana) {
        const selectedThana = presentThanas.value.find(t => t.Thana_ID == newValues.Thana);
        if (selectedThana) {
            updatedValue.present_thana_name = selectedThana.Thana_U;
            updatedValue.present_TID = selectedThana.Thana_ID;
        }
    }

    emit('update:modelValue', updatedValue);
}, { deep: true });


// Watch for changes in permanentFilters and update the form
watch(permanentFilters, async (newValues) => {
    if (!props.modelValue) return;

    const updatedValue = { ...props.modelValue };

    // Update division
    if (newValues.division) {
        const selectedDivision = divisions.value.find(d => d.id == newValues.division);
        if (selectedDivision) {
            updatedValue.parmanent_division_name = selectedDivision.Division_U;
            updatedValue.parmanent_DID = selectedDivision.id;
        }
    }

    // Update district
    if (newValues.district) {
        const selectedDistrict = districts.value.find(d => d.DesID == newValues.district);
        if (selectedDistrict) {
            updatedValue.parmanent_district_name = selectedDistrict.District_U;
            updatedValue.parmanent_desId = selectedDistrict.DesID;
        }
    }

    // Update thana
    if (newValues.Thana) {
        const selectedThana = thanas.value.find(t => t.Thana_ID == newValues.Thana);
        if (selectedThana) {
            updatedValue.parmanent_thana_name = selectedThana.Thana_U;
            updatedValue.parmanent_TID = selectedThana.Thana_ID;
        }
    }

    emit('update:modelValue', updatedValue);
}, { deep: true });

onMounted(async () => {
    await loadDivisions();
    initializeFilters();

    // If we have saved values, load the related districts and thanas
    if (presentFilters.value.division) {
        await presentHandleDivisionChange();

        if (presentFilters.value.district) {
            await presentHandleDistrictChange();
        }
    }

    if (permanentFilters.value.division) {
        await handleDivisionChange();

        if (permanentFilters.value.district) {
            await handleDistrictChange();
        }
    }

    const marhalaId = route().params.marhalaId;
    currentMarhalaId.value = marhalaId;

    try {
        const response = await axios.get(`/api/student-registration/${marhalaId}`);
        examName.value = response.data.examName;
        marhalaName.value = response.data.marhalaName;

        // এই লাইন যোগ করুন - studentInfoForm এ মারহালার নাম সেট করুন
        studentInfoForm.current_class = response.data.marhalaName;
        studentInfoForm.marhala_id = marhalaId;

    } catch (error) {
        console.error("Error fetching marhala info:", error);
    }
});



const loadDivisions = async () => {
    try {
        const response = await axios.get('/api/divisions');
        divisions.value = response.data;
        return true;
    } catch (error) {
        console.error('Error loading divisions:', error);
        return false;
    }
};

// Present address handlers
const presentHandleDivisionChange = async () => {
    presentFilters.value.district = '';
    presentFilters.value.Thana = '';
    presentDistricts.value = [];
    presentThanas.value = [];

    if (!presentFilters.value.division) {
        return;
    }

    try {
        const response = await axios.get(`/api/districts/${presentFilters.value.division}`);
        presentDistricts.value = response.data;
    } catch (error) {
        console.error('Error loading districts:', error);
    }
};

const presentHandleDistrictChange = async () => {
    presentFilters.value.Thana = '';
    presentThanas.value = [];

    if (!presentFilters.value.district) {
        return;
    }

    try {
        const response = await axios.get(`/api/thanas/${presentFilters.value.district}`);
        presentThanas.value = response.data;
    } catch (error) {
        console.error('Error loading thanas:', error);
    }
};

// const presentHandleDistrictChange = async () => {
//     presentFilters.value.Thana = '';
//     presentThanas.value = [];

//     if (!presentFilters.value.district) {
//         return;
//     }

//     try {
//         const response = await axios.get(`/api/thanas/${presentFilters.value.district}`);
//         presentThanas.value = response.data;
//     } catch (error) {
//         console.error('Error loading thanas:', error);
//     }
// };

// Permanent address handlers
const handleDivisionChange = async () => {
    permanentFilters.value.district = '';
    permanentFilters.value.Thana = '';
    districts.value = [];
    thanas.value = [];

    if (!permanentFilters.value.division) {
        return;
    }

    try {
        const response = await axios.get(`/api/districts/${permanentFilters.value.division}`);
        districts.value = response.data;
    } catch (error) {
        console.error('Error loading districts:', error);
    }
};

const handleDistrictChange = async () => {
    permanentFilters.value.Thana = '';
    thanas.value = [];

    if (!permanentFilters.value.district) {
        return;
    }

    try {
        const response = await axios.get(`/api/thanas/${permanentFilters.value.district}`);
        thanas.value = response.data;
    } catch (error) {
        console.error('Error loading thanas:', error);
    }
};







const updateFormData = () => {
    // বর্তমান ঠিকানার ডাটা আপডেট
    if (presentFilters.value.division) {
        const selectedDivision = divisions.value.find(d => d.id == presentFilters.value.division);
        if (selectedDivision) {
            studentInfoForm.present_division_name = selectedDivision.Division;
            studentInfoForm.presernt_DID = selectedDivision.id;
            console.log('Updated present division:', studentInfoForm.present_division_name, studentInfoForm.presernt_DID);
        }
    }

    if (presentFilters.value.district) {
        const selectedDistrict = presentDistricts.value.find(d => d.DesID == presentFilters.value.district);
        if (selectedDistrict) {
            studentInfoForm.present_district_name = selectedDistrict.District;
            studentInfoForm.present_desId = selectedDistrict.DesID;
            console.log('Updated present district:', studentInfoForm.present_district_name, studentInfoForm.present_desId);
        }
    }

    if (presentFilters.value.Thana) {
        // এখানে Thana_ID ব্যবহার করুন, TID নয়
        const selectedThana = presentThanas.value.find(t => t.Thana_ID == presentFilters.value.Thana);
        if (selectedThana) {
            studentInfoForm.present_thana_name = selectedThana.Thana;
            studentInfoForm.present_TID = selectedThana.Thana_ID;
            console.log('Updated present thana:', studentInfoForm.present_thana_name, studentInfoForm.present_TID);
        } else {
            console.log('Thana not found with ID:', presentFilters.value.Thana);
            console.log('Available thanas:', presentThanas.value);
        }
    }

    // স্থায়ী ঠিকানার ডাটা আপডেট
    if (permanentFilters.value.division) {
        const selectedDivision = divisions.value.find(d => d.id == permanentFilters.value.division);
        if (selectedDivision) {
            studentInfoForm.parmanent_division_name = selectedDivision.Division;
            studentInfoForm.parmanent_DID = selectedDivision.id;
            console.log('Updated permanent division:', studentInfoForm.parmanent_division_name, studentInfoForm.parmanent_DID);
        }
    }

    if (permanentFilters.value.district) {
        const selectedDistrict = districts.value.find(d => d.DesID == permanentFilters.value.district);
        if (selectedDistrict) {
            studentInfoForm.parmanent_district_name = selectedDistrict.District;
            studentInfoForm.parmanent_desId = selectedDistrict.DesID;
            console.log('Updated permanent district:', studentInfoForm.parmanent_district_name, studentInfoForm.parmanent_desId);
        }
    }

    if (permanentFilters.value.Thana) {
        // এখানে Thana_ID ব্যবহার করুন, TID নয়
        const selectedThana = thanas.value.find(t => t.Thana_ID == permanentFilters.value.Thana);
        if (selectedThana) {
            studentInfoForm.parmanent_thana_name = selectedThana.Thana;
            studentInfoForm.parmanent_TID = selectedThana.Thana_ID;
            console.log('Updated permanent thana:', studentInfoForm.parmanent_thana_name, studentInfoForm.parmanent_TID);
        } else {
            console.log('Permanent thana not found with ID:', permanentFilters.value.Thana);
            console.log('Available permanent thanas:', thanas.value);
        }
    }
}





const examName = ref('');
const marhalaName = ref('');
const currentMarhalaId = ref(null);







</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-5 mt-5 mx-5 space-y-6 text-xl">
            <!-- Personal Information Card -->
            <div class="bg-white rounded-sm shadow-md">
                <div
                    class="flex bg-gradient-to-r rounded-t-md from-emerald-800 gap-3 items-center px-6 py-3 to-emerald-600">
                    <i class="text-2xl text-white fa-user-circle fas"></i>
                    <h5 class="text-white text-xl font-arabic">ব্যক্তিগত তথ্য - {{ marhalaName }}</h5>
                </div>
                <div class="p-6">
                    <form class="space-y-6">
                        <!-- Name Fields -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">নাম
                                    (বাংলা)</label>
                                <div class="relative">
                                    <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">

                                    </span>
                                    <input v-model="studentInfoForm.name_bn" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl  w-full  focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">নাম
                                    (ইংরেজি)</label>
                                <div class="relative">
                                    <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">

                                    </span>
                                    <input v-model="studentInfoForm.name_en" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">নাম
                                    (আরবি)</label>
                                <div class="relative">
                                    <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">

                                    </span>
                                    <input v-model="studentInfoForm.name_ar" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>
                        </div>

                        <!-- Mother's Name Fields -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">মাতার নাম
                                    (বাংলা)</label>
                                <div>

                                    <input v-model="studentInfoForm.mother_name_bn" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">মাতার নাম
                                    (ইংরেজি)</label>
                                <div class="relative">

                                    <input v-model="studentInfoForm.mother_name_en" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">মাতার নাম
                                    (আরবি)</label>
                                <div class="relative">

                                    <input v-model="studentInfoForm.mother_name_ar" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>
                        </div>


                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">পিতার নাম
                                    (বাংলা)</label>
                                <div>

                                    <input v-model="studentInfoForm.father_name_bn" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">পিতার নাম
                                    (ইংরেজি)</label>
                                <div class="relative">

                                    <input v-model="studentInfoForm.father_name_en" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">পিতার নাম
                                    (আরবি)</label>
                                <div class="relative">

                                    <input v-model="studentInfoForm.father_name_ar" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>
                        </div>


                        <!-- Date and Registration Fields -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="relative">
                                <label
                                    class="text-gray-700 text-lg block font-arabic font-medium mb-1">জন্ম-তারিখ</label>
                                <div class="relative">
                                    <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">
                                        <i class="text-emerald-600 fa-calendar-alt fas"></i>
                                    </span>
                                    <input v-model="studentInfoForm.Date_of_birth" type="date"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">জন্ম-নিবন্ধন
                                    নম্বর</label>
                                <div class="relative">
                                    <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">
                                        <i class="text-emerald-600 fa-id-card fas"></i>
                                    </span>
                                    <input v-model="studentInfoForm.BRN_no" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">জাতীয়
                                    পরিচয়পত্র নম্বর</label>
                                <div class="relative">
                                    <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">
                                        <i class="text-emerald-600 fa-address-card fas"></i>
                                    </span>
                                    <input v-model="studentInfoForm.NID_no" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Required Information Card -->
            <div class="bg-white rounded-lg shadow-md">
                <div
                    class="bg-gradient-to-r rounded-t-md from-emerald-800 overflow-hidden px-6 py-4 relative to-emerald-600">
                    <div class="bg-[url( absolute inset-0 opacity-10" imagesslamic-pattern.png></div>
                    <div class="flex gap-3 items-center relative z-10">
                        <h5 class="text-white text-xl font-arabic">প্রয়োজনীয় তথ্য</h5>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="relative">
                            <label
                                class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                পরীক্ষার্থীর ধরন
                            </label>
                            <div class="relative">
                                <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">

                                </span>
                                <input type="text" disabled
                                    class="bg-emerald-50 border border-emerald-200 rounded-md text-emerald-800 text-xl w-full pl-10 pr-3 py-2"
                                    placeholder="নিয়মিত">
                            </div>
                        </div>

                        <div class="relative">
                            <label
                                class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                বোর্ড
                            </label>
                            <div class="relative">
                                <span class="flex absolute inset-y-0 items-center left-0 pl-3  pointer-events-none">
                                </span>
                                <select v-model="studentInfoForm.board_name"
                                    class="bg-white border border-emerald-200 rounded-md text-emerald-800 w-full appearance-none text-xl pl-10 pr-3 py-2">
                                    <option value="">বোর্ড নির্বাচন করুন</option>
                                    <option value="বেফাকুল মাদারিসিল আরাবিয়া বাংলাদেশ">বেফাকুল মাদারিসিল আরাবিয়া
                                        বাংলাদেশ</option>
                                    <option value="বেফাকুল মাদারিসিল কওমিয়া গওহরডাঙ্গা বাংলাদেশ
">বেফাকুল মাদারিসিল কওমিয়া গওহরডাঙ্গা বাংলাদেশ
                                    </option>
                                    <option value="আযাদ দ্বীনি এদারায়ে তালীম বাংলাদেশ
">আযাদ দ্বীনি এদারায়ে তালীম বাংলাদেশ
                                    </option>
                                    <option value="তানযীমুল মাদারিসিদ দ্বীনিয়া বাংলাদেশ
">তানযীমুল মাদারিসিদ দ্বীনিয়া বাংলাদেশ
                                    </option>
                                    <option value="জাতীয় দ্বীনি মাদরাসা শিক্ষাবোর্ড বাংলাদেশ
">জাতীয় দ্বীনি মাদরাসা শিক্ষাবোর্ড বাংলাদেশ
                                    </option>
                                    <option value="আঞ্জুমানে ইত্তেহাদুল মাদারিস বাংলাদেশ

">আঞ্জুমানে ইত্তেহাদুল মাদারিস বাংলাদেশ

                                    </option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="flex text-emerald-700 font-arabic font-medium gap-2 items-center mb-4">
                            <i class="text-emerald-600 fa-book fas"></i>
                            নির্বাচনি কিতাব সিলেক্ট করুন
                        </h4>
                        <div class="flex flex-wrap gap-6">
                            <label class="flex cursor-pointer group items-center space-x-2">
                                <div class="relative">
                                    <input type="checkbox"
                                        class="form-checkbox border-emerald-300 rounded-md text-emerald-600 focus:ring-emerald-500">
                                    <div
                                        class="bg-emerald-100 rounded-md absolute group-hover:opacity-20 inset-0 opacity-0 transition-opacity">
                                    </div>
                                </div>
                                <span
                                    class="text-emerald-800 font-arabic group-hover:text-emerald-600 transition-colors">হিদায়া
                                    ১ম খন্ড</span>
                            </label>

                            <label class="flex cursor-pointer group items-center space-x-2">
                                <div class="relative">
                                    <input type="checkbox"
                                        class="form-checkbox border-emerald-300 rounded-md text-emerald-600 focus:ring-emerald-500">
                                    <div
                                        class="bg-emerald-100 rounded-md absolute group-hover:opacity-20 inset-0 opacity-0 transition-opacity">
                                    </div>
                                </div>
                                <span
                                    class="text-emerald-800 font-arabic group-hover:text-emerald-600 transition-colors">হিদায়া
                                    ২য় খন্ড</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Card -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Present Address -->
                <div class="bg-white border border-emerald-100 rounded-md shadow">
                    <div
                        class="bg-gradient-to-r rounded-t-md from-emerald-800 overflow-hidden px-6 py-3 relative to-emerald-600">
                        <div class="bg-pattern absolute inset-0 opacity-10"></div>
                        <div class="flex gap-3 items-center relative z-10">
                            <i class="text-2xl text-white fa-map-marker-alt fas"></i>
                            <h5 class="text-white text-xl font-arabic">বর্তমান ঠিকানা</h5>
                        </div>
                    </div>

                    <div class="bg-opacity-5 bg-white p-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="relative">
                                <label
                                    class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                    বিভাগ
                                </label>
                                <div class="relative">
                                    <select v-model="presentFilters.division" @change="presentHandleDivisionChange"
                                        class="bg-white border border-gray-200 rounded-sm w-full block focus:ring-[#2d6a4f] focus:ring-2 px-4 py-2">
                                        <option value="">সকল</option>
                                        <option v-for="division in divisions" :key="division.id" :value="division.id">
                                            {{ division.Division }}
                                        </option>
                                    </select>
                                    <div class="flex absolute inset-y-0 items-center pointer-events-none px-2 right-0">
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <label
                                    class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                    জেলা
                                </label>
                                <div class="relative">
                                    <select v-model="presentFilters.district" @change="presentHandleDistrictChange"
                                        class="bg-white border border-gray-200 rounded-sm w-full block focus:ring-[#2d6a4f] focus:ring-2 px-4 py-2">
                                        <option value="">সকল</option>
                                        <option v-for="district in presentDistricts" :key="district.DesID"
                                            :value="district.DesID">
                                            {{ district.District }}
                                        </option>
                                    </select>
                                    <div class="flex absolute inset-y-0 items-center pointer-events-none px-2 right-0">
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <label
                                    class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                    থানা/উপজেলা
                                </label>
                                <div class="relative">
                                    <select v-model="presentFilters.Thana"
                                        class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f]">
                                        <option value="">সকল</option>
                                        <option v-for="Thana in presentThanas" :key="Thana.Thana_ID"
                                            :value="Thana.Thana_ID">
                                            {{ Thana.Thana }}
                                        </option>
                                    </select>


                                    <div class="flex absolute inset-y-0 items-center pointer-events-none px-2 right-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permanent Address -->
                <div class="bg-white border border-emerald-100 rounded-md shadow">
                    <div
                        class="bg-gradient-to-r rounded-t-md from-emerald-800 overflow-hidden px-6 py-3 relative to-emerald-600">
                        <div class="bg-pattern absolute inset-0 opacity-10"></div>
                        <div class="flex gap-3 items-center relative z-10">
                            <i class="text-2xl text-white fa-home fas"></i>
                            <h5 class="text-white text-xl font-arabic">স্থায়ী ঠিকানা</h5>
                        </div>
                    </div>

                    <div class="bg-opacity-5 bg-white p-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="relative">
                                <label
                                    class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                    বিভাগ
                                </label>
                                <div class="relative">
                                    <select v-model="permanentFilters.division" @change="handleDivisionChange"
                                        class="bg-white border border-gray-200 rounded-sm w-full block focus:ring-[#2d6a4f] focus:ring-2 px-4 py-2">
                                        <option value="">সকল</option>
                                        <option v-for="division in divisions" :key="division.id" :value="division.id">
                                            {{ division.Division }}
                                        </option>
                                    </select>
                                    <div class="flex absolute inset-y-0 items-center pointer-events-none px-2 right-0">
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <label
                                    class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                    জেলা
                                </label>
                                <div class="relative">
                                    <select v-model="permanentFilters.district" @change="handleDistrictChange"
                                        class="bg-white border border-gray-200 rounded-sm w-full block focus:ring-[#2d6a4f] focus:ring-2 px-4 py-2">
                                        <option value="">সকল</option>
                                        <option v-for="district in districts" :key="district.DesID"
                                            :value="district.DesID">
                                            {{ district.District }}
                                        </option>
                                    </select>
                                    <div class="flex absolute inset-y-0 items-center pointer-events-none px-2 right-0">
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <label
                                    class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                    থানা/উপজেলা
                                </label>


                                <select v-model="permanentFilters.Thana"
                                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f]">
                                    <option value="">সকল</option>
                                    <option v-for="Thana in thanas" :key="Thana.Thana_ID" :value="Thana.Thana_ID">
                                        {{ Thana.Thana }}
                                    </option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Attachment Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="bg-white border border-emerald-200 p-6 rounded-md shadow-md">
                    <h3 class="text-emerald-800 text-xl arabic-font font-bold mb-6">সংযুক্তি</h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <!-- Student Photo -->
                        <div class="space-y-3">
                            <label class="text-emerald-700 text-lg arabic-font block font-medium">ছাত্রের ছবি (পাসপোর্ট
                                সাইজ এবং নীল ব্যাকগ্রাইন্ড হতে হবে)</label>
                            <div class="relative">
                                <div
                                    class="flex bg-emerald-50 border-2 border-dashed border-emerald-300 justify-between p-4 rounded-md duration-200 hover:border-emerald-500 items-center transition-colors">
                                    <span class="text-emerald-600 arabic-font">
                                        {{ studentPhotoFile ? studentPhotoFile.name : 'ফাইল আপলোড করুন' }}
                                    </span>
                                    <div v-if="studentPhotoPreview"
                                        class="flex items-center pointer-events-auto relative space-x-2 z-10">
                                        <a :href="studentPhotoPreview" target="_blank"
                                            class="text-emerald-600 hover:text-emerald-800">প্রিভিউ</a>
                                        <button @click.stop="removeFile('studentPhoto')"
                                            class="text-red-600 hover:text-red-800">মুছুন</button>
                                    </div>
                                </div>
                                <input type="file" @change="handleFileUpload($event, 'studentPhoto')"
                                    class="h-full w-full absolute cursor-pointer inset-0 opacity-0 z-0"
                                    accept="image/*,.pdf" />
                            </div>
                        </div>

                        <!-- Birth Certificate/NID -->
                        <div class="space-y-3">
                            <label class="text-emerald-700 text-lg arabic-font block font-medium">জন্ম নিবন্ধন/এন আইডি
                                সংযুক্তি করুন</label>
                            <div class="relative">
                                <div
                                    class="flex bg-emerald-50 border-2 border-dashed border-emerald-300 justify-between p-4 rounded-md duration-200 hover:border-emerald-500 items-center transition-colors">
                                    <span class="text-emerald-600 arabic-font">
                                        {{ birthCertificateFile ? birthCertificateFile.name : 'ফাইল আপলোড করুন' }}
                                    </span>
                                    <div v-if="birthCertificatePreview"
                                        class="flex items-center pointer-events-auto relative space-x-2 z-10">
                                        <a :href="birthCertificatePreview" target="_blank"
                                            class="text-emerald-600 hover:text-emerald-800">প্রিভিউ</a>
                                        <button @click.stop="removeFile('birthCertificate')"
                                            class="text-red-600 hover:text-red-800">মুছুন</button>
                                    </div>
                                </div>
                                <input type="file" @change="handleFileUpload($event, 'birthCertificate')"
                                    class="h-full w-full absolute cursor-pointer inset-0 opacity-0 z-0"
                                    accept="image/*,.pdf,.doc,.docx" />
                            </div>
                        </div>

                        <!-- Marksheet -->
                        <div class="space-y-3">
                            <label class="text-emerald-700 text-lg arabic-font block font-medium">মার্কশীট সংযুক্ত
                                করুন</label>
                            <div class="relative">
                                <div
                                    class="flex bg-emerald-50 border-2 border-dashed border-emerald-300 justify-between p-4 rounded-md duration-200 hover:border-emerald-500 items-center transition-colors">
                                    <span class="text-emerald-600 arabic-font">
                                        {{ marksheetFile ? marksheetFile.name : 'ফাইল আপলোড করুন' }}
                                    </span>
                                    <div v-if="marksheetPreview"
                                        class="flex items-center pointer-events-auto relative space-x-2 z-10">
                                        <a :href="marksheetPreview" target="_blank"
                                            class="text-emerald-600 hover:text-emerald-800">প্রিভিউ</a>
                                        <button @click.stop="removeFile('marksheet')"
                                            class="text-red-600 hover:text-red-800">মুছুন</button>
                                    </div>
                                </div>
                                <input type="file" @change="handleFileUpload($event, 'marksheet')"
                                    class="h-full w-full absolute cursor-pointer inset-0 opacity-0 z-0"
                                    accept="image/*,.pdf,.doc,.docx" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <button @click.prevent="submitStudentInfo"
                                class="bg-emerald-600 rounded-md shadow-md text-white font-bold hover:bg-emerald-700 px-6 py-2">
                                <i class="fa-save fas mr-2"></i> সংরক্ষণ করুন
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
