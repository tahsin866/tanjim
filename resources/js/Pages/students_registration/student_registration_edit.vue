<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, onMounted } from 'vue'
import { router } from '@inertiajs/vue3';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    student: Object,
    marhalas: Array,
    errors: Object
  });

  // Create form with student data
  const form = useForm({
    name_bn: props.student.name_bn,
    name_en: props.student.name_en,
    name_ar: props.student.name_ar,
    father_name_bn: props.student.father_name_bn,
    father_name_en: props.student.father_name_en,
    father_name_ar: props.student.father_name_ar,
    mother_name_bn: props.student.mother_name_bn,
    mother_name_en: props.student.mother_name_en,
    mother_name_ar: props.student.mother_name_ar,
    board_name: props.student.board_name,


    present_division_name: props.student.present_division_name,
  present_district_name: props.student.present_district_name,
  present_thana_name: props.student.present_thana_name,
  presernt_DID: props.student.presernt_DID,
  present_desId: props.student.present_desId,
  present_TID: props.student.present_TID,

  parmanent_division_name: props.student.parmanent_division_name,
  parmanent_district_name: props.student.parmanent_district_name,
  parmanent_thana_name: props.student.parmanent_thana_name,
  parmanent_DID: props.student.parmanent_DID,
  parmanent_desId: props.student.parmanent_desId,
  parmanent_TID: props.student.parmanent_TID,


    BRN_no: props.student.BRN_no,
    NID_no: props.student.NID_no,
    mobile_no: props.student.mobile_no,
    Date_of_birth: props.student.Date_of_birth,
    student_type: props.student.student_type || 'নিয়মিত',
    marhala_id: props.student.marhala_id,
    student_image: null,
    NID_attach: null,
    _method: 'PUT', // Add this to ensure PUT method is used
  });

  // Handle file uploads
  const handleStudentImageUpload = (event) => {
    form.student_image = event.target.files[0];
  };

  const handleNIDAttachUpload = (event) => {
    form.NID_attach = event.target.files[0];
  };

//   Submit form
//   const updateStudent = () => {
//     form.submit('put', route('students_registration.student_registration_update', props.student.id), {
//       preserveScroll: true,
//       onSuccess: () => {
//         // Show success message or redirect
//         router.visit(route('back'));
//       },
//     });
//   };

// Submit form
// Submit form
const updateStudent = () => {
  // ফাইলগুলো ফর্মে যোগ করুন
  if (studentPhotoFile.value) {
    form.student_image = studentPhotoFile.value;
  }

  if (birthCertificateFile.value) {
    form.NID_attach = birthCertificateFile.value;
  }

  form.processing = true; // এটি যোগ করুন

  form.submit('post', route('students_registration.student_registration_update', props.student.id), {
    preserveScroll: true,
    forceFormData: true, // এটি যোগ করুন
    onSuccess: () => {
      // Show success message or redirect
      window.location.reload();
    },
  });
};













  // Go back to previous page
//   const goBack = () => {
//     router.visit(route('students_registration.index'));
//   };





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

// বিভাগর/জেলা/থানা

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
  Thana: '' // 'T' uppercase করে দিন
});

const permanentFilters = ref({
  division: '',
  district: '',
  Thana: '' // 'T' uppercase করে দিন
});

// Initialize filters from props if they exist
const initializeFilters = () => {
  // বর্তমান ঠিকানার জন্য
  if (props.student && props.student.presernt_DID) {
    presentFilters.value.division = props.student.presernt_DID;
    // এখানে কনসোল লগ যোগ করুন

  }

  if (props.student && props.student.present_desId) {
    presentFilters.value.district = props.student.present_desId;

  }

  if (props.student && props.student.present_TID) {
    presentFilters.value.Thana = props.student.present_TID;

  }

  // স্থায়ী ঠিকানার জন্য
  if (props.student && props.student.parmanent_DID) {
    permanentFilters.value.division = props.student.parmanent_DID;

  }

  if (props.student && props.student.parmanent_desId) {
    permanentFilters.value.district = props.student.parmanent_desId;

  }

  if (props.student && props.student.parmanent_TID) {
    permanentFilters.value.Thana = props.student.parmanent_TID;

  }
};


// Watch for changes in props.modelValue to initialize filters
// Watch for changes in props.student to initialize filters
watch(() => props.student, (newValue) => {
  if (newValue) {
    initializeFilters();
  }
}, { immediate: true });


// Watch for changes in presentFilters and update the form
// Watch for changes in presentFilters and update the form
// Watch for changes in presentFilters and update the form
watch(presentFilters, async (newValues) => {
  // Update division
  if (newValues.division) {
    const selectedDivision = divisions.value.find(d => d.id == newValues.division);
    if (selectedDivision) {
      form.present_division_name = selectedDivision.Division;
      form.presernt_DID = selectedDivision.id;
    }
  }

  // Update district
  if (newValues.district) {
    const selectedDistrict = presentDistricts.value.find(d => d.DesID == newValues.district);
    if (selectedDistrict) {
      form.present_district_name = selectedDistrict.District;
      form.present_desId = selectedDistrict.DesID;
    }
  }

  // Update thana
  if (newValues.Thana) {
    const selectedThana = presentThanas.value.find(t => t.Thana_ID == newValues.Thana);
    if (selectedThana) {
      form.present_thana_name = selectedThana.Thana;
      form.present_TID = selectedThana.Thana_ID;
    }
  }
}, { deep: true });



// Watch for changes in permanentFilters and update the form
// Watch for changes in permanentFilters and update the form
watch(permanentFilters, async (newValues) => {
  // Update division
  if (newValues.division) {
    const selectedDivision = divisions.value.find(d => d.id == newValues.division);
    if (selectedDivision) {
      form.parmanent_division_name = selectedDivision.Division;
      form.parmanent_DID = selectedDivision.id;
    }
  }

  // Update district
  if (newValues.district) {
    const selectedDistrict = districts.value.find(d => d.DesID == newValues.district);
    if (selectedDistrict) {
      form.parmanent_district_name = selectedDistrict.District;
      form.parmanent_desId = selectedDistrict.DesID;
    }
  }

  // Update thana
  if (newValues.Thana) {
    const selectedThana = thanas.value.find(t => t.Thana_ID == newValues.Thana);
    if (selectedThana) {
      form.parmanent_thana_name = selectedThana.Thana;
      form.parmanent_TID = selectedThana.Thana_ID;
    }
  }
}, { deep: true });


onMounted(async () => {
  await loadDivisions();

  // কনসোল লগ যোগ করুন
  console.log('Loaded divisions:', divisions.value);

  // ফিল্টার ইনিশিয়ালাইজ করুন
  initializeFilters();

  // বর্তমান ঠিকানার জন্য
  if (presentFilters.value.division) {

    await presentHandleDivisionChange();

    if (presentFilters.value.district) {

      await presentHandleDistrictChange();
    }
  }

  // স্থায়ী ঠিকানার জন্য
  if (permanentFilters.value.division) {

    await handleDivisionChange();

    if (permanentFilters.value.district) {

      await handleDistrictChange();
    }
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
// Present address handlers
const presentHandleDivisionChange = async () => {
  if (!presentFilters.value.division) {
    presentFilters.value.district = '';
    presentFilters.value.Thana = '';
    presentDistricts.value = [];
    presentThanas.value = [];
    return;
  }

  try {
    const response = await axios.get(`/api/districts/${presentFilters.value.division}`);
    presentDistricts.value = response.data;


    // যদি আগে থেকে district সেট থাকে, তাহলে সেটি বজায় রাখুন
    if (props.student && props.student.present_desId) {
      presentFilters.value.district = props.student.present_desId;
    }
  } catch (error) {

  }
};

// Permanent address handlers
const handleDivisionChange = async () => {
  if (!permanentFilters.value.division) {
    permanentFilters.value.district = '';
    permanentFilters.value.Thana = '';
    districts.value = [];
    thanas.value = [];
    return;
  }

  try {
    const response = await axios.get(`/api/districts/${permanentFilters.value.division}`);
    districts.value = response.data;


    // যদি আগে থেকে district সেট থাকে, তাহলে সেটি বজায় রাখুন
    if (props.student && props.student.parmanent_desId) {
      permanentFilters.value.district = props.student.parmanent_desId;
    }
  } catch (error) {
    console.error('Error loading districts:', error);
  }
};


const presentHandleDistrictChange = async () => {
  if (!presentFilters.value.district) {
    presentFilters.value.Thana = '';
    presentThanas.value = [];
    return;
  }

  try {
    const response = await axios.get(`/api/thanas/${presentFilters.value.district}`);
    presentThanas.value = response.data;
    console.log('Loaded present thanas:', presentThanas.value);

    // যদি আগে থেকে thana সেট থাকে, তাহলে সেটি বজায় রাখুন
    if (props.student && props.student.present_TID) {
      presentFilters.value.Thana = props.student.present_TID;
    }
  } catch (error) {
    console.error('Error loading thanas:', error);
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
                    <form @submit.prevent="updateStudent" enctype="multipart/form-data">
                        <!-- Name Fields -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">নাম
                                    (বাংলা)</label>
                                <div class="relative">
                                    <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">

                                    </span>
                                    <input v-model="form.name_bn" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl  w-full  focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">নাম
                                    (ইংরেজি)</label>
                                <div class="relative">
                                    <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">

                                    </span>
                                    <input v-model="form.name_en" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">নাম
                                    (আরবি)</label>
                                <div class="relative">
                                    <span class="flex absolute inset-y-0 items-center left-0 pl-3 pointer-events-none">

                                    </span>
                                    <input v-model="form.name_ar" type="text"
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

                                    <input v-model="form.father_name_bn" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">মাতার নাম
                                    (ইংরেজি)</label>
                                <div class="relative">

                                    <input v-model="form.father_name_en" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">মাতার নাম
                                    (আরবি)</label>
                                <div class="relative">

                                    <input v-model="form.father_name_ar" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>
                        </div>


                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">পিতার নাম
                                    (বাংলা)</label>
                                <div>

                                    <input v-model="form.mother_name_bn" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">পিতার নাম
                                    (ইংরেজি)</label>
                                <div class="relative">

                                    <input v-model="form.mother_name_en" type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>

                            <div class="relative">
                                <label class="text-gray-700 text-lg block font-arabic font-medium mb-1">পিতার নাম
                                    (আরবি)</label>
                                <div class="relative">

                                    <input v-model="form.mother_name_ar" type="text"
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
                                    <input v-model="form.Date_of_birth"   type="date"
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
                                    <input v-model="form.BRN_no"  type="text"
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
                                    <input v-model="form.NID_no"  type="text"
                                        class="border border-emerald-200 rounded-sm text-xl w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-3 py-2">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

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
                                <select v-model="form.board_name"

                                    class="bg-white border border-emerald-200 rounded-md text-emerald-800 w-full appearance-none text-xl pl-10 pr-3 py-2">
                                    <option value="">বোর্ড নির্বাচন করুন</option>
                                    <option value="বেফাকুল মাদারিসিল কওমিয়া গওহরডাঙ্গা বাংলাদেশ">বেফাকুল মাদারিসিল কওমিয়া গওহরডাঙ্গা বাংলাদেশ</option>
<option value="আযাদ দ্বীনি এদারায়ে তালীম বাংলাদেশ">আযাদ দ্বীনি এদারায়ে তালীম বাংলাদেশ</option>
<option value="তানযীমুল মাদারিসিদ দ্বীনিয়া বাংলাদেশ">তানযীমুল মাদারিসিদ দ্বীনিয়া বাংলাদেশ</option>
<option value="জাতীয় দ্বীনি মাদরাসা শিক্ষাবোর্ড বাংলাদেশ">জাতীয় দ্বীনি মাদরাসা শিক্ষাবোর্ড বাংলাদেশ</option>
<option value="আঞ্জুমানে ইত্তেহাদুল মাদারিস বাংলাদেশ">আঞ্জুমানে ইত্তেহাদুল মাদারিস বাংলাদেশ</option>
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
    class="bg-white border border-gray-200 rounded-sm w-full block focus:ring-[#2d6a4f] focus:ring-2 px-4 py-2">
    <option value="">সকল</option>
    <option v-for="thana in presentThanas" :key="thana.Thana_ID" :value="thana.Thana_ID">
        {{ thana.Thana }}
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
                                <div class="relative">
                                    <select v-model="permanentFilters.Thana"
    class="bg-white border border-gray-200 rounded-sm w-full block focus:ring-[#2d6a4f] focus:ring-2 px-4 py-2">
    <option value="">সকল</option>
    <option v-for="thana in thanas" :key="thana.Thana_ID" :value="thana.Thana_ID">
        {{ thana.Thana }}
    </option>
</select>
                                    <div class="flex absolute inset-y-0 items-center pointer-events-none px-2 right-0">
                                    </div>
                                </div>
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
                <label class="text-emerald-700 text-lg arabic-font block font-medium">
                    শিক্ষার্থীর ছবি (পাসপোর্ট সাইজ এবং নীল ব্যাকগ্রাইন্ড হতে হবে)
                </label>
                <div class="relative">
                    <div class="flex bg-emerald-50 border-2 border-dashed border-emerald-300 justify-between p-4 rounded-md duration-200 hover:border-emerald-500 items-center transition-colors">
                        <span class="text-emerald-600 arabic-font">
                            {{ studentPhotoFile ? studentPhotoFile.name : (student.student_image ? 'বর্তমান ছবি আছে' : 'ফাইল আপলোড করুন') }}
                        </span>
                        <div v-if="studentPhotoPreview || student.student_image" class="flex items-center pointer-events-auto relative space-x-2 z-10">
                            <a :href="studentPhotoPreview || ('/storage/' + student.student_image)" target="_blank" class="text-emerald-600 hover:text-emerald-800">প্রিভিউ</a>
                            <button type="button" @click.stop="removeFile('studentPhoto')" class="text-red-600 hover:text-red-800">মুছুন</button>
                        </div>
                    </div>
                    <input
                        type="file"
                        @change="handleFileUpload($event, 'studentPhoto')"
                        class="h-full w-full absolute cursor-pointer inset-0 opacity-0 z-0"
                        accept="image/*,.pdf"
                    />
                </div>
            </div>

            <!-- Birth Certificate/NID -->
            <div class="space-y-3">
                <label class="text-emerald-700 text-lg arabic-font block font-medium">জন্ম নিবন্ধন/এন আইডি সংযুক্তি করুন</label>
                <div class="relative">
                    <div class="flex bg-emerald-50 border-2 border-dashed border-emerald-300 justify-between p-4 rounded-md duration-200 hover:border-emerald-500 items-center transition-colors">
                        <span class="text-emerald-600 arabic-font">
                            {{ birthCertificateFile ? birthCertificateFile.name : (student.NID_attach ? 'বর্তমান ছবি আছে' : 'ফাইল আপলোড করুন') }}
                        </span>
                        <div v-if="birthCertificatePreview || student.NID_attach" class="flex items-center pointer-events-auto relative space-x-2 z-10">
                            <a :href="birthCertificatePreview || ('/storage/' + student.NID_attach)" target="_blank" class="text-emerald-600 hover:text-emerald-800">প্রিভিউ</a>
                            <button type="button" @click.stop="removeFile('studentPhoto')" class="text-red-600 hover:text-red-800">মুছুন</button>
                        </div>
                    </div>
                    <input type="file" @change="handleFileUpload($event, 'birthCertificate')" class="h-full w-full absolute cursor-pointer inset-0 opacity-0 z-0" accept="image/*,.pdf,.doc,.docx" />
                </div>
            </div>

            <!-- Marksheet -->
            <div class="space-y-3">
                <label class="text-emerald-700 text-lg arabic-font block font-medium">মার্কশীট সংযুক্ত করুন</label>
                <div class="relative">
                    <div class="flex bg-emerald-50 border-2 border-dashed border-emerald-300 justify-between p-4 rounded-md duration-200 hover:border-emerald-500 items-center transition-colors">
                        <span class="text-emerald-600 arabic-font">
                            {{ marksheetFile ? marksheetFile.name : 'ফাইল আপলোড করুন' }}
                        </span>
                        <div v-if="marksheetPreview" class="flex items-center pointer-events-auto relative space-x-2 z-10">
                            <a :href="marksheetPreview" target="_blank" class="text-emerald-600 hover:text-emerald-800">প্রিভিউ</a>
                            <button @click.stop="removeFile('marksheet')" class="text-red-600 hover:text-red-800">মুছুন</button>
                        </div>
                    </div>
                    <input type="file" @change="handleFileUpload($event, 'marksheet')" class="h-full w-full absolute cursor-pointer inset-0 opacity-0 z-0" accept="image/*,.pdf,.doc,.docx" />
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button @click.prevent="updateStudent" class="bg-emerald-600 rounded-md shadow-md text-white font-bold hover:bg-emerald-700 px-6 py-2">
                <i class="fa-save fas mr-2"></i> সংরক্ষণ করুন
            </button>
        </div>
    </div>
</div>

            </div>

    </AuthenticatedLayout>
</template>
