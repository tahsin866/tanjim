<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, onMounted } from 'vue'
import { createToaster } from "@meforma/vue-toaster";
import { Link, useForm } from '@inertiajs/vue3';

import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';
import Calendar from 'primevue/calendar';
import Button from 'primevue/button';
import Dropdown from 'primevue/dropdown';
import Card from 'primevue/card';
import FileUpload from 'primevue/fileupload';





const boardOptions = [
  { name: 'বেফাকুল মাদারিসিল আরাবিয়া বাংলাদেশ', value: 'বেফাকুল মাদারিসিল আরাবিয়া বাংলাদেশ' },
  { name: 'বেফাকুল মাদারিসিল কওমিয়া গওহরডাঙ্গা বাংলাদেশ', value: 'বেফাকুল মাদারিসিল কওমিয়া গওহরডাঙ্গা বাংলাদেশ' },
  { name: 'আযাদ দ্বীনি এদারায়ে তালীম বাংলাদেশ', value: 'আযাদ দ্বীনি এদারায়ে তালীম বাংলাদেশ' },
  { name: 'তানযীমুল মাদারিসিদ দ্বীনিয়া বাংলাদেশ', value: 'তানযীমুল মাদারিসিদ দ্বীনিয়া বাংলাদেশ' },
  { name: 'জাতীয় দ্বীনি মাদরাসা শিক্ষাবোর্ড বাংলাদেশ', value: 'জাতীয় দ্বীনি মাদরাসা শিক্ষাবোর্ড বাংলাদেশ' },
  { name: 'আঞ্জুমানে ইত্তেহাদুল মাদারিস বাংলাদেশ', value: 'আঞ্জুমানে ইত্তেহাদুল মাদারিস বাংলাদেশ' }
];




const props = defineProps({
    roll: String,
    reg_id: String,
    CID: String,
    modelValue: Object
});

const toaster = createToaster({
  position: "top-right",
  duration: 3000 // 3 সেকেন্ড দেখাবে
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
    onSuccess: (page) => {
        // page.props.flash.success থেকে মেসেজ নিন
        toaster.success(page.props.flash?.success || 'ছাত্রের তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
    },
    onError: (errors) => {
        toaster.error('ছাত্রের তথ্য সংরক্ষণ করতে সমস্যা হয়েছে');
        console.error('Error saving student information:', errors);
    },
    preserveScroll: true
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
  const file = event.files[0]; // PrimeVue FileUpload provides files array
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
  <div class="flex bg-gradient-to-r rounded-t-md from-emerald-800 gap-3 items-center px-6 py-3 to-emerald-600">
    <i class="text-2xl text-white fa-user-circle fas"></i>
    <h5 class="text-white text-xl font-arabic">ব্যক্তিগত তথ্য - {{ marhalaName }}</h5>
  </div>
  <div class="p-6">
    <form class="space-y-6">
      <!-- Name Fields -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">নাম (বাংলা)</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-user text-emerald-600"></i>
            <InputText v-model="studentInfoForm.name_bn" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">নাম (ইংরেজি)</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-user text-emerald-600"></i>
            <InputText v-model="studentInfoForm.name_en" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">নাম (আরবি)</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-user text-emerald-600"></i>
            <InputText v-model="studentInfoForm.name_ar" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
      </div>

      <!-- Mother's Name Fields -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">মাতার নাম (বাংলা)</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-user-edit text-emerald-600"></i>
            <InputText v-model="studentInfoForm.mother_name_bn" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">মাতার নাম (ইংরেজি)</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-user-edit text-emerald-600"></i>
            <InputText v-model="studentInfoForm.mother_name_en" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">মাতার নাম (আরবি)</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-user-edit text-emerald-600"></i>
            <InputText v-model="studentInfoForm.mother_name_ar" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
      </div>

      <!-- Father's Name Fields -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">পিতার নাম (বাংলা)</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-user-edit text-emerald-600"></i>
            <InputText v-model="studentInfoForm.father_name_bn" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">পিতার নাম (ইংরেজি)</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-user-edit text-emerald-600"></i>
            <InputText v-model="studentInfoForm.father_name_en" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">পিতার নাম (আরবি)</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-user-edit text-emerald-600"></i>
            <InputText v-model="studentInfoForm.father_name_ar" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
      </div>

      <!-- Date and Registration Fields -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">জন্ম-তারিখ</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-calendar text-emerald-600"></i>
            <Calendar v-model="studentInfoForm.Date_of_birth" dateFormat="dd/mm/yy" class="w-full" showIcon />
          </span>
        </div>
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">জন্ম-নিবন্ধন নম্বর</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-id-card text-emerald-600"></i>
            <InputText v-model="studentInfoForm.BRN_no" class="w-full text-xl p-inputtext-lg" />
          </span>
        </div>
        <div class="field">
          <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">জাতীয় পরিচয়পত্র নম্বর</label>
          <span class="p-input-icon-left w-full">
            <i class="pi pi-id-card text-emerald-600"></i>
            <InputMask v-model="studentInfoForm.NID_no" mask="9999-9999-9999-9999" placeholder="0000-0000-0000-0000" class="w-full text-xl" />
          </span>
        </div>
      </div>



    </form>
  </div>
</div>


            <!-- Required Information Card -->
            <div class="bg-white rounded-lg shadow-md">
  <div class="bg-gradient-to-r rounded-t-md from-emerald-800 overflow-hidden px-6 py-4 relative to-emerald-600">
    <div class="bg-[url(images/islamic-pattern.png)] absolute inset-0 opacity-10"></div>
    <div class="flex gap-3 items-center relative z-10">
      <h5 class="text-white text-xl font-arabic">প্রয়োজনীয় তথ্য</h5>
    </div>
  </div>
  <div class="p-6">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
      <div class="field">
        <label class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
          পরীক্ষার্থীর ধরন
        </label>
        <InputText
          value="নিয়মিত"
          disabled
          class="bg-emerald-50 text-emerald-800 text-xl w-full"
        />
      </div>

      <div class="field">
        <label class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
          বোর্ড
        </label>
        <Dropdown
          v-model="studentInfoForm.board_name"
          :options="boardOptions"
          optionLabel="name"
          optionValue="value"
          placeholder="বোর্ড নির্বাচন করুন"
          class="w-full text-xl"
        />
      </div>
    </div>
  </div>
</div>


<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
  <!-- Present Address -->
  <Card class="border border-emerald-100">
    <template #header>
      <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 px-6 py-3 relative">
        <div class="bg-pattern absolute inset-0 opacity-10"></div>
        <div class="flex gap-3 items-center relative z-10">
          <i class="text-2xl text-white pi pi-map-marker"></i>
          <h5 class="text-white text-xl font-arabic">বর্তমান ঠিকানা</h5>
        </div>
      </div>
    </template>
    <template #content>
      <div class="grid grid-cols-1 gap-4">
        <div class="field">
          <label class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
            বিভাগ
          </label>
          <Dropdown
            v-model="presentFilters.division"
            :options="divisions"
            optionLabel="Division"
            optionValue="id"
            placeholder="সকল"
            class="w-full"
            @change="presentHandleDivisionChange"
          />
        </div>
        <div class="field">
          <label class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
            জেলা
          </label>
          <Dropdown
            v-model="presentFilters.district"
            :options="presentDistricts"
            optionLabel="District"
            optionValue="DesID"
            placeholder="সকল"
            class="w-full"
            @change="presentHandleDistrictChange"
          />
        </div>
        <div class="field">
          <label class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
            থানা/উপজেলা
          </label>
          <Dropdown
            v-model="presentFilters.Thana"
            :options="presentThanas"
            optionLabel="Thana"
            optionValue="Thana_ID"
            placeholder="সকল"
            class="w-full"
          />
        </div>
      </div>
    </template>
  </Card>

  <!-- Permanent Address -->
  <Card class="border border-emerald-100">
    <template #header>
      <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 px-6 py-3 relative">
        <div class="bg-pattern absolute inset-0 opacity-10"></div>
        <div class="flex gap-3 items-center relative z-10">
          <i class="text-2xl text-white pi pi-home"></i>
          <h5 class="text-white text-xl font-arabic">স্থায়ী ঠিকানা</h5>
        </div>
      </div>
    </template>
    <template #content>
      <div class="grid grid-cols-1 gap-4">
        <div class="field">
          <label class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
            বিভাগ
          </label>
          <Dropdown
            v-model="permanentFilters.division"
            :options="divisions"
            optionLabel="Division"
            optionValue="id"
            placeholder="সকল"
            class="w-full"
            @change="handleDivisionChange"
          />
        </div>
        <div class="field">
          <label class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
            জেলা
          </label>
          <Dropdown
            v-model="permanentFilters.district"
            :options="districts"
            optionLabel="District"
            optionValue="DesID"
            placeholder="সকল"
            class="w-full"
            @change="handleDistrictChange"
          />
        </div>
        <div class="field">
          <label class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
            থানা/উপজেলা
          </label>
          <Dropdown
            v-model="permanentFilters.Thana"
            :options="thanas"
            optionLabel="Thana"
            optionValue="Thana_ID"
            placeholder="সকল"
            class="w-full"
          />
        </div>
      </div>
    </template>
  </Card>
</div>

<!-- Attachment Card -->
<Card class="mt-6">
  <template #content>
    <h3 class="text-emerald-800 text-xl arabic-font font-bold mb-6">সংযুক্তি</h3>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
      <!-- Student Photo -->
      <div class="space-y-3">
  <label class="text-emerald-700 text-lg arabic-font block font-medium">
    ছাত্রের ছবি (পাসপোর্ট সাইজ এবং নীল ব্যাকগ্রাইন্ড হতে হবে)
  </label>
  <div class="relative">
    <FileUpload
      mode="basic"
      :customUpload="true"
      @uploader="(event) => handleFileUpload(event, 'studentPhoto')"
      accept="image/*,.pdf"
      :auto="true"
      chooseLabel="ফাইল আপলোড করুন"
      class="w-full"
    />
    <div v-if="studentPhotoFile" class="flex justify-between items-center mt-2 p-2 bg-emerald-50 border border-emerald-200 rounded">
      <span class="text-emerald-600 arabic-font">{{ studentPhotoFile.name }}</span>
      <div class="flex gap-2">
        <Button
          v-if="studentPhotoPreview"
          icon="pi pi-eye"
          class="p-button-text p-button-sm p-button-success"
          @click="() => window.open(studentPhotoPreview, '_blank')"
        />
        <Button
          icon="pi pi-trash"
          class="p-button-text p-button-sm p-button-danger"
          @click="removeFile('studentPhoto')"
        />
      </div>
    </div>
  </div>
</div>

<!-- Birth Certificate/NID -->
<div class="space-y-3">
  <label class="text-emerald-700 text-lg arabic-font block font-medium">
    জন্ম নিবন্ধন/এন আইডি সংযুক্তি করুন
  </label>
  <div class="relative">
    <FileUpload
      mode="basic"
      :customUpload="true"
      @uploader="(event) => handleFileUpload(event, 'birthCertificate')"
      accept="image/*,.pdf,.doc,.docx"
      :auto="true"
      chooseLabel="ফাইল আপলোড করুন"
      class="w-full"
    />
    <div v-if="birthCertificateFile" class="flex justify-between items-center mt-2 p-2 bg-emerald-50 border border-emerald-200 rounded">
      <span class="text-emerald-600 arabic-font">{{ birthCertificateFile.name }}</span>
      <div class="flex gap-2">
        <Button
          v-if="birthCertificatePreview"
          icon="pi pi-eye"
          class="p-button-text p-button-sm p-button-success"
          @click="() => window.open(birthCertificatePreview, '_blank')"
        />
        <Button
          icon="pi pi-trash"
          class="p-button-text p-button-sm p-button-danger"
          @click="removeFile('birthCertificate')"
        />
      </div>
    </div>
  </div>
</div>

<!-- Marksheet Upload - Conditional -->
<div v-if="studentInfoForm.board_name && studentInfoForm.board_name !== 'বেফাকুল মাদারিসিল আরাবিয়া বাংলাদেশ'" class="space-y-3">
  <label class="text-emerald-700 text-lg arabic-font block font-medium">
    মার্কশীট সংযুক্ত করুন
  </label>
  <div class="relative">
    <FileUpload
      mode="basic"
      :customUpload="true"
      @uploader="(event) => handleFileUpload(event, 'marksheet')"
      accept="image/*,.pdf,.doc,.docx"
      :auto="true"
      chooseLabel="ফাইল আপলোড করুন"
      class="w-full"
    />
    <div v-if="marksheetFile" class="flex justify-between items-center mt-2 p-2 bg-emerald-50 border border-emerald-200 rounded">
      <span class="text-emerald-600 arabic-font">{{ marksheetFile.name }}</span>
      <div class="flex gap-2">
        <Button
          v-if="marksheetPreview"
          icon="pi pi-eye"
          class="p-button-text p-button-sm p-button-success"
          @click="() => window.open(marksheetPreview, '_blank')"
        />
        <Button
          icon="pi pi-trash"
          class="p-button-text p-button-sm p-button-danger"
          @click="removeFile('marksheet')"
        />
      </div>
    </div>
  </div>
</div>
    </div>
    <div class="mt-6">
      <Button
        icon="pi pi-save"
        label="সংরক্ষণ করুন"
        class="p-button-success"
        @click="submitStudentInfo"
      />
    </div>
  </template>
</Card>

        </div>
    </AuthenticatedLayout>
</template>
