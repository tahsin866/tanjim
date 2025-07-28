<script setup>
import BasicInfo from '@/Components/Auth/BasicInfo.vue';
import EducationInfo from '@/Components/Auth/EducationInfo.vue';
import FinalInfo from '@/Components/Auth/FinalInfo.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useToast } from "vue-toastification";
import { FormPersistence } from '@/Helpers/FormPersistence.js';

// PrimeVue Components
import Steps from 'primevue/steps';
import Button from 'primevue/button';
import ProgressBar from 'primevue/progressbar';
import Card from 'primevue/card';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Divider from 'primevue/divider';
import Badge from 'primevue/badge';
import Chip from 'primevue/chip';

const toast = useToast();
const currentStep = ref(1);
const validationErrors = ref({});
const hasAttemptedValidation = ref(false);

const stepItems = [
  { label: 'ব্যক্তিগত তথ্য', icon: 'pi pi-user', description: 'আপনার ব্যক্তিগত তথ্য দিন' },
  { label: 'শিক্ষাগত তথ্য', icon: 'pi pi-book', description: 'শিক্ষাগত যোগ্যতা ও বিভাগ' },
  { label: 'নিরাপত্তা ও অতিরিক্ত', icon: 'pi pi-shield', description: 'পাসওয়ার্ড ও অন্যান্য তথ্য' }
];

// ✅ Computed property for Steps activeIndex (Always correct & reactive)
const activeStepIndex = computed(() => currentStep.value - 1);

// Progress calculation
const totalSteps = 3;
const progressPercentage = computed(() => {
  return Math.round((currentStep.value / totalSteps) * 100);
});

// Step completion status
const stepCompletionStatus = computed(() => {
  const step1Complete = form.fullNameBangla && form.fullNameEnglish && form.fatherName && form.email && form.phoneNumber && form.dateOfBirth;

  // Step 2 validation - roll number শুধুমাত্র examType "জানা নেই" না হলে required
  const isRollNumberValid = !form.examType || form.examType === 'জানা নেই' || form.rollNumber;
  const step2Complete = (form.dept_takmil || form.dept_ifta || form.dept_hifz || form.dept_qirat || form.dept_other) &&
                        form.examType && isRollNumberValid && form.idType;

  const step3Complete = form.password && form.password_confirmation;

  return {
    1: step1Complete,
    2: step2Complete && step1Complete,
    3: step3Complete && step2Complete && step1Complete
  };
});

// Form completion percentage for each step
const stepCompletionPercentage = computed(() => {
  const step1Fields = ['fullNameBangla', 'fullNameEnglish', 'fatherName', 'email', 'phoneNumber', 'dateOfBirth', 'address', 'division', 'district', 'thana'];

  // Step 2 fields - rollNumber conditionally included
  let step2Fields = ['examType', 'idType'];
  if (form.examType && form.examType !== 'জানা নেই') {
    step2Fields.push('rollNumber');
  }

  const step3Fields = ['password', 'password_confirmation'];

  const getFieldsCompletion = (fields) => {
    const completed = fields.filter(field => form[field] && form[field] !== '').length;
    return Math.round((completed / fields.length) * 100);
  };

  const deptCompletion = (form.dept_takmil || form.dept_ifta || form.dept_hifz || form.dept_qirat || form.dept_other) ? 100 : 0;

  return {
    1: getFieldsCompletion(step1Fields),
    2: Math.round((getFieldsCompletion(step2Fields) + deptCompletion) / 2),
    3: getFieldsCompletion(step3Fields)
  };
});

const form = useForm({
  // --- ব্যক্তিগত তথ্য ---
  fullNameBangla: '',
  fullNameEnglish: '',
  fatherName: '',
  email: '',                 // নতুন: ইমেইল ঠিকানা
  phoneNumber: '',
  alternatePhoneNumber: '',  // নতুন: বিকল্প ফোন নাম্বার
  dateOfBirth: '',           // নতুন: জন্মতারিখ
  bloodGroup: '',            // নতুন: ব্লাড গ্রুপ
  address: '',
  division: '',
  district: '',
  thana: '',
  classmate1: '',
  classmate2: '',
  classmate3: '',

  // --- শিক্ষাগত তথ্য ---
  dept_takmil: false,
  dept_ifta: false,
  dept_hifz: false,
  dept_qirat: false,
  dept_other: false,            // নতুন: অন্যান্য বিভাগ
  dept_takmil_year_english: '',
  dept_takmil_year_hijri: '',
  dept_ifta_year_english: '',
  dept_ifta_year_hijri: '',
  dept_hifz_year_english: '',
  dept_hifz_year_hijri: '',
  dept_qirat_year_english: '',
  dept_qirat_year_hijri: '',
  dept_other_class: '',
  examType: '',
  rollNumber: '',
  workplace: '',

  // --- পরিচয়পত্র ও ছবি ---
  idType: '',                   // 'birth' | 'voter'
  birthCertificate: '',
  voterId: '',
  birthCertificatePhoto: null,   // নতুন: জন্মনিবন্ধন ছবির ফিল্ড
  voterIdPhoto: null,           // নতুন: ভোটার আইডি ছবির ফিল্ড
  photo: null,                  // লাইভ ছবি

  // --- নিরাপত্তা তথ্য ---
  password: '',
  password_confirmation: '',
});

const props = defineProps({
  success: String,
  madrasha_name: String,
  thana: String,
  post: String,
  custom_code: String
});

const validateStep = () => {
  validationErrors.value = {};
  hasAttemptedValidation.value = true;

  if (currentStep.value === 1) {
    // ব্যক্তিগত তথ্য ভ্যালিডেশন
    if (!form.fullNameBangla) validationErrors.value.fullNameBangla = 'বাংলা নাম প্রয়োজন';
    if (!form.fullNameEnglish) validationErrors.value.fullNameEnglish = 'ইংরেজি নাম প্রয়োজন';
    if (!form.fatherName) validationErrors.value.fatherName = 'বাবার নাম প্রয়োজন';
    if (!form.email) validationErrors.value.email = 'ইমেইল ঠিকানা প্রয়োজন';
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) validationErrors.value.email = 'সঠিক ইমেইল ঠিকানা লিখুন';
    if (!form.phoneNumber) validationErrors.value.phoneNumber = 'ফোন নম্বর প্রয়োজন';
    if (!form.dateOfBirth) validationErrors.value.dateOfBirth = 'জন্মতারিখ প্রয়োজন';
    if (!form.address) validationErrors.value.address = 'ঠিকানা প্রয়োজন';
    if (!form.division) validationErrors.value.division = 'বিভাগ নির্বাচন করুন';
    if (!form.district) validationErrors.value.district = 'জেলা নির্বাচন করুন';
    if (!form.thana) validationErrors.value.thana = 'থানা নির্বাচন করুন';

    return Object.keys(validationErrors.value).length === 0;
  }
  if (currentStep.value === 2) {
    // শিক্ষাগত তথ্য ভ্যালিডেশন
    // অন্তত একটি বিভাগ, বিভাগ অনুযায়ী বর্ষ, অন্যান্য ফিল্ড, জন্মনিবন্ধন/ভোটার আইডি ও ছবি
    const hasAnyDepartment =
      form.dept_takmil ||
      form.dept_ifta ||
      form.dept_hifz ||
      form.dept_qirat ||
      form.dept_other;

    const hasRequiredYears =
      (!form.dept_takmil || (form.dept_takmil_year_english && form.dept_takmil_year_hijri)) &&
      (!form.dept_ifta || (form.dept_ifta_year_english && form.dept_ifta_year_hijri)) &&
      (!form.dept_hifz || (form.dept_hifz_year_english && form.dept_hifz_year_hijri)) &&
      (!form.dept_qirat || (form.dept_qirat_year_english && form.dept_qirat_year_hijri)) &&
      (!form.dept_other || form.dept_other_class);

    const hasAnyId =
      (form.idType === 'birth' && form.birthCertificate && form.birthCertificatePhoto) ||
      (form.idType === 'voter' && form.voterId && form.voterIdPhoto);

    // Roll number validation - শুধুমাত্র examType "জানা নেই" না হলে required
    const isRollNumberValid = !form.examType || form.examType === 'জানা নেই' || form.rollNumber;

    // পরীক্ষার ধরন ভ্যালিডেশন
    if (!form.examType) {
      validationErrors.value.examType = 'পরীক্ষার ধরন নির্বাচন করুন';
    }

    // Roll number validation error message
    if (form.examType && form.examType !== 'জানা নেই' && !form.rollNumber) {
      validationErrors.value.rollNumber = 'রোল নাম্বার লিখুন';
    }

    // পরিচয়পত্রের ধরন ভ্যালিডেশন
    if (!form.idType) {
      validationErrors.value.idType = 'পরিচয়পত্রের ধরন নির্বাচন করুন';
    }

    // অন্তত একটি বিভাগ চেক
    if (!hasAnyDepartment) {
      validationErrors.value.departments = 'অন্তত একটি বিভাগ নির্বাচন করুন';
    }

    // জন্মনিবন্ধন ভ্যালিডেশন
    if (form.idType === 'birth') {
      if (!form.birthCertificate) validationErrors.value.birthCertificate = 'জন্মনিবন্ধন নম্বর লিখুন';
      if (!form.birthCertificatePhoto) validationErrors.value.birthCertificatePhoto = 'জন্মনিবন্ধন ছবি আপলোড করুন';
    }

    // ভোটার আইডি ভ্যালিডেশন
    if (form.idType === 'voter') {
      if (!form.voterId) validationErrors.value.voterId = 'ভোটার আইডি নম্বর লিখুন';
      if (!form.voterIdPhoto) validationErrors.value.voterIdPhoto = 'ভোটার আইডি ছবি আপলোড করুন';
    }

    // ছবি ভ্যালিডেশন - "জানা নেই" ছাড়া সব ক্ষেত্রে
    if (form.idType !== 'জানা নেই' && !form.photo) {
      validationErrors.value.photo = 'লাইভ ছবি আপলোড করুন';
    }

    return Object.keys(validationErrors.value).length === 0;
  }
  if (currentStep.value === 3) {
    // পাসওয়ার্ড ভ্যালিডেশন
    if (!form.password) {
      validationErrors.value.password = 'পাসওয়ার্ড প্রয়োজন';
    } else if (form.password.length < 8) {
      validationErrors.value.password = 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষর হতে হবে';
    }

    if (!form.password_confirmation) {
      validationErrors.value.password_confirmation = 'পাসওয়ার্ড নিশ্চিতকরণ প্রয়োজন';
    } else if (form.password !== form.password_confirmation) {
      validationErrors.value.password_confirmation = 'পাসওয়ার্ড মিলছে না';
    }

    return Object.keys(validationErrors.value).length === 0;
  }
  return true;
};

const nextStep = () => {
  if (validateStep()) {
    setTimeout(() => {
      currentStep.value++;
    }, 100);
  } else {
    // Show specific error messages
    const errorList = Object.values(validationErrors.value);
    const errorMessage = errorList.length > 0 ? errorList.join(', ') : 'অনুগ্রহ করে সব তথ্য পূরণ করুন।';

    toast.error(errorMessage, {
      position: "top-center",
      timeout: 4000,
      closeOnClick: true,
      pauseOnFocusLoss: true,
      pauseOnHover: true,
      draggable: true,
      draggablePercent: 0.6,
      showCloseButtonOnHover: false,
      hideProgressBar: false,
      closeButton: "button",
      icon: true,
      rtl: false
    });
  }
};

const prevStep = () => {
  setTimeout(() => {
    currentStep.value--;
  }, 100);
};

const submit = () => {
  if (validateStep()) {
    form.post(route('register'), {
      onSuccess: () => {
        // Clear all form data from localStorage after successful submission
        FormPersistence.clearAllFormData();
        FormPersistence.saveSuccessMessage('নিবন্ধন সফল হয়েছে! স্বাগতম।');

        toast.success('নিবন্ধন সফল হয়েছে! স্বাগতম।', {
          position: "top-center",
          timeout: 5000,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 0.6,
          showCloseButtonOnHover: false,
          hideProgressBar: false,
          closeButton: "button",
          icon: true,
          rtl: false
        });
        form.reset();
      },
      onError: (errors) => {
        console.error('Registration errors:', errors);
        const errorMessages = Object.values(errors).flat();
        toast.error(errorMessages[0] || 'নিবন্ধন ব্যর্থ হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।', {
          position: "top-center",
          timeout: 6000,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 0.6,
          showCloseButtonOnHover: false,
          hideProgressBar: false,
          closeButton: "button",
          icon: true,
          rtl: false
        });
      }
    });
  }
};

const handleKeyboard = (event) => {
  if (event.altKey && event.key === 'ArrowRight' && currentStep.value < totalSteps) {
    event.preventDefault();
    nextStep();
  }
  if (event.altKey && event.key === 'ArrowLeft' && currentStep.value > 1) {
    event.preventDefault();
    prevStep();
  }
  if (event.altKey && event.key === 'Enter' && currentStep.value === totalSteps) {
    event.preventDefault();
    submit();
  }
};

onMounted(() => {
  document.addEventListener('keydown', handleKeyboard);
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeyboard);
});
</script>

<template>
  <Head title="নিবন্ধন - দস্তাবেজ ব্যবস্থাপনা সিস্টেম" />

  <div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
      <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25px 25px, #3B82F6 2px, transparent 0), radial-gradient(circle at 75px 75px, #6366F1 2px, transparent 0); background-size: 100px 100px;"></div>
    </div>

    <div class="relative z-10 py-8 px-4 min-h-screen flex items-center justify-center">
      <div class="w-full max-w-5xl">

        <div class="text-center mb-8">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mb-4 shadow-lg">
            <i class="pi pi-file-edit text-white text-2xl"></i>
          </div>
          <h1 class="text-4xl font-bold gradient-text mb-2" style="font-family: 'SolaimanLipi', sans-serif;">
            নিবন্ধন ফর্ম
          </h1>
          <p class="text-gray-600 text-lg">৭০ সালানা দরস্তবন্দির জন্য আপনার তথ্য হালনাগাদ করুন</p>
        </div>

        <Card class="shadow-2xl border-0 bg-white/90 backdrop-blur-sm">
          <template #content>
            <div v-if="props.success" class="mb-6">
              <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <i class="pi pi-check-circle text-green-600 text-xl"></i>
                  </div>
                  <div class="ml-3">
                    <p class="text-green-800 font-medium">{{ props.success }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Progress Section -->
            <div class="mb-8">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">অগ্রগতি</h3>
                <Chip :label="`${progressPercentage}% সম্পন্ন`"
                      :class="progressPercentage === 100 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'" />
              </div>

              <!-- Custom Progress Bar - made bigger & enhanced -->
              <div class="relative">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-sm text-gray-600">ধাপ {{ currentStep }} / {{ totalSteps }}</span>
                  <span class="text-sm font-medium text-gray-800">{{ stepItems[currentStep - 1].label }}</span>
                </div>
                <ProgressBar
                  :value="progressPercentage"
                  :class="progressPercentage === 100 ? 'progress-complete' : 'progress-ongoing'"
                  class="mb-6 thick-progress"
                  style="height: 28px;"
                >
                  <template #value>
                    <span class="progress-text">{{ progressPercentage }}% সম্পন্ন</span>
                  </template>
                </ProgressBar>
              </div>
            </div>

            <!-- Enhanced Step Indicator -->
            <div class="mb-8">
              <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4 md:space-x-8">
                  <div v-for="(step, index) in stepItems" :key="index"
                       class="flex items-center">
                    <!-- Step Circle -->
                    <div class="relative">
                      <div :class="[
                        'w-12 h-12 rounded-full flex items-center justify-center border-2 transition-all duration-300',
                        currentStep > index + 1 || stepCompletionStatus[index + 1]
                          ? 'bg-green-500 border-green-500 text-white shadow-lg'
                          : currentStep === index + 1
                            ? 'bg-blue-500 border-blue-500 text-white shadow-lg animate-pulse'
                            : 'bg-gray-100 border-gray-300 text-gray-400'
                      ]">
                        <i v-if="stepCompletionStatus[index + 1] && currentStep > index + 1"
                           class="pi pi-check font-bold"></i>
                        <i v-else :class="step.icon"></i>
                      </div>

                      <!-- Step Label -->
                      <div class="absolute top-14 left-1/2 transform -translate-x-1/2 text-center min-w-max">
                        <p :class="[
                          'text-sm font-medium',
                          currentStep === index + 1 ? 'text-blue-600' :
                          stepCompletionStatus[index + 1] ? 'text-green-600' : 'text-gray-500'
                        ]">
                          {{ step.label }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">{{ step.description }}</p>

                        <!-- Mini Progress for Current Step -->
                        <div v-if="currentStep === index + 1" class="mt-2">
                          <div class="w-16 bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-300"
                                 :style="{ width: stepCompletionPercentage[index + 1] + '%' }"></div>
                          </div>
                          <span class="text-xs text-blue-600 mt-1 block">{{ stepCompletionPercentage[index + 1] }}%</span>
                        </div>
                      </div>
                    </div>

                    <!-- Connector Line -->
                    <div v-if="index < stepItems.length - 1"
                         :class="[
                           'w-16 md:w-24 h-0.5 transition-all duration-300',
                           stepCompletionStatus[index + 1] && currentStep > index + 1
                             ? 'bg-green-500'
                             : 'bg-gray-300'
                         ]"></div>
                  </div>
                </div>
              </div>
            </div>

            <Divider />

            <!-- Tab Content with Enhanced Design -->
            <div class="mt-8">
              <div class="flex justify-between items-center mb-4 text-sm">
                <div class="flex items-center text-gray-500">
                  <i class="pi pi-save mr-2"></i>
                  <span>আপনার তথ্য স্বয়ংক্রিয়ভাবে সংরক্ষিত হচ্ছে</span>
                </div>
                <div class="text-xs text-gray-400">
                  সর্বশেষ সংরক্ষণ: এখনই
                </div>
              </div>
              <!-- Step 1: Basic Info -->
              <div v-if="currentStep === 1" class="space-y-6">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                  <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                      <i class="pi pi-user text-white"></i>
                    </div>
                    <div>
                      <h3 class="text-xl font-bold text-gray-800">ব্যক্তিগত তথ্য</h3>
                      <p class="text-gray-600">আপনার ব্যক্তিগত তথ্য সঠিকভাবে পূরণ করুন</p>
                    </div>
                  </div>
                  <BasicInfo :form="form" :validation-errors="validationErrors" :has-attempted-validation="hasAttemptedValidation" />
                </div>

                <div class="flex justify-end pt-4">
                  <Button label="পরবর্তী ধাপ"
                          icon="pi pi-arrow-right"
                          iconPos="right"
                          class="px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 border-0 shadow-lg hover:shadow-xl transition-all duration-300"
                          @click="nextStep" />
                </div>
              </div>

              <!-- Step 2: Education Info -->
              <div v-if="currentStep === 2" class="space-y-6">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                  <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                      <i class="pi pi-book text-white"></i>
                    </div>
                    <div>
                      <h3 class="text-xl font-bold text-gray-800">শিক্ষাগত তথ্য</h3>
                      <p class="text-gray-600">আপনার শিক্ষাগত যোগ্যতা ও বিভাগের তথ্য দিন</p>
                    </div>
                  </div>
                  <EducationInfo :form="form" :validation-errors="validationErrors" :has-attempted-validation="hasAttemptedValidation" />
                </div>

                <div class="flex justify-between pt-4">
                  <Button label="পূর্ববর্তী ধাপ"
                          icon="pi pi-arrow-left"
                          class="px-8 py-3 bg-gray-500 border-0 shadow-lg hover:shadow-xl transition-all duration-300"
                          @click="prevStep" />
                  <Button label="পরবর্তী ধাপ"
                          icon="pi pi-arrow-right"
                          iconPos="right"
                          class="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 border-0 shadow-lg hover:shadow-xl transition-all duration-300"
                          @click="nextStep" />
                </div>
              </div>

              <!-- Step 3: Final Info -->
              <div v-if="currentStep === 3" class="space-y-6">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                  <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                      <i class="pi pi-shield text-white"></i>
                    </div>
                    <div>
                      <h3 class="text-xl font-bold text-gray-800">নিরাপত্তা ও চূড়ান্ত তথ্য</h3>
                      <p class="text-gray-600">পাসওয়ার্ড এবং অন্যান্য প্রয়োজনীয় তথ্য দিন</p>
                    </div>
                  </div>
                  <FinalInfo :form="form" :validation-errors="validationErrors" :has-attempted-validation="hasAttemptedValidation" @submit="submit" />
                </div>

                <div class="flex justify-between pt-4">
                  <Button label="পূর্ববর্তী ধাপ"
                          icon="pi pi-arrow-left"
                          class="px-8 py-3 bg-gray-500 border-0 shadow-lg hover:shadow-xl transition-all duration-300"
                          @click="prevStep" />
                  <Button label="নিবন্ধন সম্পন্ন করুন"
                          icon="pi pi-check"
                          iconPos="right"
                          class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-700 border-0 shadow-lg hover:shadow-xl transition-all duration-300 font-bold"
                          :loading="form.processing"
                          @click.prevent="submit" />
                </div>
              </div>
            </div>
          </template>
        </Card>


      </div>
    </div>
  </div>
</template>

<style scoped>
* {
  font-family: 'SolaimanLipi', 'Merriweather', sans-serif;
}

/* Custom Progress Bar Styles */
:deep(.progress-complete .p-progressbar-value),
:deep(.progress-ongoing .p-progressbar-value),
.thick-progress :deep(.p-progressbar-value) {
  /* Bigger height for the value bar */
  height: 28px !important;
  min-height: 28px !important;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 1rem;
}
:deep(.progress-complete .p-progressbar-value),
.thick-progress :deep(.p-progressbar-value) {
  background: linear-gradient(90deg, #10B981, #059669);
  border-radius: 0.375rem;
  box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
  color: #fff;
}
:deep(.progress-ongoing .p-progressbar-value),
.thick-progress :deep(.p-progressbar-value) {
  background: linear-gradient(90deg, #3B82F6, #1D4ED8);
  border-radius: 0.375rem;
  box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
  color: #fff;
}

:deep(.p-progressbar),
.thick-progress :deep(.p-progressbar) {
  height: 28px !important;
  min-height: 28px !important;
  background-color: #E5E7EB;
  border-radius: 0.375rem;
  overflow: hidden;
  position: relative;
}

/* Progress Bar Text */
.progress-text {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%,-50%);
  color: #fff;
  font-size: 1rem;
  font-weight: bold;
  letter-spacing: 0.05em;
  z-index: 2;
}

:deep(.p-progressbar-label) {
  display: none;
}

/* Enhanced Card Styles */
:deep(.p-card) {
  border-radius: 1rem;
  border: none;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
}

:deep(.p-card .p-card-content) {
  padding: 2rem;
}

/* Button Hover Effects */
:deep(.p-button) {
  transition: all 0.3s ease;
  border-radius: 0.5rem;
  font-weight: 600;
  letter-spacing: 0.025em;
}

:deep(.p-button:hover) {
  transform: translateY(-2px);
}

/* Step Circle Animation */
@keyframes pulse-ring {
  0% {
    transform: scale(0.8);
    opacity: 1;
  }
  100% {
    transform: scale(1.2);
    opacity: 0;
  }
}

.animate-pulse::before {
  content: '';
  position: absolute;
  inset: -4px;
  border-radius: 50%;
  background: linear-gradient(45deg, #3B82F6, #1D4ED8);
  animation: pulse-ring 2s infinite;
  z-index: -1;
}

/* Chip Styles */
:deep(.p-chip) {
  border-radius: 0.5rem;
  font-weight: 600;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
}

/* Form Section Hover Effects */
.bg-gradient-to-r:hover {
  transform: translateY(-2px);
  transition: all 0.3s ease;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Mini Progress Bar on Step Indicator - MADE THICKER */
.w-16.bg-gray-200 {
  height: 10px !important;
  min-height: 10px !important;
}
.bg-blue-500.h-2\.5 {
  height: 10px !important;
  min-height: 10px !important;
}

/* Success Alert Animation */
@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.bg-gradient-to-r.from-green-50 {
  animation: slideIn 0.5s ease-out;
}

/* Loading State */
:deep(.p-button-loading) {
  position: relative;
  pointer-events: none;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(45deg, #3B82F6, #1D4ED8);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(45deg, #1D4ED8, #1E40AF);
}

/* Responsive Design */
@media (max-width: 768px) {
  :deep(.p-card .p-card-content) {
    padding: 1rem;
  }

  .flex.items-center.space-x-4 {
    flex-direction: column;
    gap: 2rem;
  }

  .w-16.md\\:w-24 {
    display: none;
  }

  .thick-progress :deep(.p-progressbar) {
    height: 24px !important;
    min-height: 24px !important;
  }
  .thick-progress :deep(.p-progressbar-value) {
    height: 24px !important;
    min-height: 24px !important;
  }
  .progress-text {
    font-size: 0.95rem;
  }
}

/* Focus States */
:deep(.p-inputtext:focus) {
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  border-color: #3B82F6;
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
  .animate-pulse::before,
  .transition-all,
  .bg-gradient-to-r:hover {
    animation: none;
    transition: none;
    transform: none;
  }
}

/* Keyboard Shortcut Styles */
kbd {
  font-family: 'Courier New', monospace;
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.25rem 0.5rem;
  background-color: #ffffff;
  border: 1px solid #d1d5db;
  border-radius: 0.25rem;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  color: #374151;
}

/* Enhanced Link Hover */
a {
  position: relative;
  overflow: hidden;
}

a::before {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(90deg, #3B82F6, #1D4ED8);
  transition: width 0.3s ease;
}

a:hover::before {
  width: 100%;
}

/* Form Step Transition */
.step-enter-active, .step-leave-active {
  transition: all 0.3s ease;
}

.step-enter-from {
  opacity: 0;
  transform: translateX(30px);
}

.step-leave-to {
  opacity: 0;
  transform: translateX(-30px);
}

/* Auto-save indicator animation */
@keyframes saving {
  0%, 100% { opacity: 0.5; }
  50% { opacity: 1; }
}

.pi-save {
  animation: saving 2s infinite;
}

/* Gradient text effect */
.gradient-text {
  background: linear-gradient(45deg, #3B82F6, #8B5CF6, #06B6D4);
  background-size: 200% 200%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: gradient-shift 3s ease infinite;
}

@keyframes gradient-shift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Enhanced shadow effects */
.shadow-2xl {
  box-shadow:
    0 25px 50px -12px rgba(0, 0, 0, 0.25),
    0 0 0 1px rgba(255, 255, 255, 0.05);
}

/* Glass morphism effect */
.backdrop-blur-sm {
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}
</style>
