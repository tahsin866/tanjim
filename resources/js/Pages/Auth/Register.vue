<template>
  <Head title="নিবন্ধন - দস্তরবন্দির জন্য  ব্যবস্থাপনা সিস্টেম" />

  <div
    style="font-family: 'SolaimanLipi', sans-serif;"
    class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 relative overflow-hidden min-h-screen flex items-center justify-center py-8 px-2 sm:px-4"
  >
    <div class="w-full max-w-5xl">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-emerald-700 dark:to-purple-900 rounded-full mb-4 ">
          <i class="pi pi-file-edit text-white text-2xl"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-violet-500 to-cyan-400 dark:from-emerald-400 dark:via-indigo-400 dark:to-purple-400" style="font-family: 'SolaimanLipi', sans-serif;">
          নিবন্ধন ফর্ম
        </h1>
        <p class="text-gray-600 dark:text-gray-300 text-base sm:text-lg">
          তানযীমে আবনায়ে জামিয়া ফরিদাবাদের সাথে যুক্ত থাকার জন্য আপনার তথ্য হালনাগাদ করুন।
        </p>
      </div>
      <div class="bg-white/90 dark:bg-gray-900/90 rounded-xl backdrop-blur-sm border-0">
        <div class="p-4 sm:p-8">
          <!-- Success Message -->
          <div v-if="props.success" class="mb-6">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-900 border border-green-200 dark:border-green-800 rounded-xl p-4 flex items-center gap-2">
              <i class="pi pi-check-circle text-green-600 dark:text-green-400 text-xl"></i>
              <span class="text-green-800 dark:text-green-300 font-medium">{{ props.success }}</span>
            </div>
          </div>
          <!-- Progress Section -->
          <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-base md:text-lg font-semibold text-gray-800 dark:text-white">অগ্রগতি</h3>
              <span class="px-3 py-1 rounded-full font-semibold text-xs"
                :class="progressPercentage === 100 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-blue-100 text-blue-800 dark:bg-gray-800 dark:text-blue-300'">
                {{ progressPercentage }}% সম্পন্ন
              </span>
            </div>
            <div class="w-full h-7 bg-gray-200 dark:bg-gray-800 rounded-lg overflow-hidden mb-6 flex items-center relative">
              <div
                :class="progressPercentage === 100 ? 'bg-gradient-to-r from-green-400 to-emerald-500 dark:from-green-600 dark:to-emerald-700' : 'bg-gradient-to-r from-blue-500 to-indigo-500 dark:from-blue-700 dark:to-indigo-700'"
                class="h-full transition-all duration-700"
                :style="{ width: progressPercentage + '%' }"
              ></div>
              <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white font-bold text-sm drop-shadow">
                {{ progressPercentage }}% সম্পন্ন
              </span>
            </div>
            <div class="flex flex-col xs:flex-row xs:items-center xs:justify-between gap-2 mb-2">
              <span class="text-sm text-gray-600 dark:text-gray-300">ধাপ {{ currentStep }} / {{ totalSteps }}</span>
              <span class="text-sm font-medium text-gray-800 dark:text-white">{{ stepItems[currentStep - 1].label }}</span>
            </div>
          </div>
          <!-- Step Indicator (Responsive) -->
          <div class="mb-8">
            <div class="flex justify-center overflow-x-auto space-x-2 no-scrollbar px-1">
              <template v-for="(step, index) in stepItems" :key="index">
                <div class="flex flex-col items-center min-w-[90px]">
                  <div
                    :class="[
                      'rounded-full flex items-center justify-center border-2 transition-all duration-300',
                      currentStep > index + 1 || stepCompletionStatus[index + 1]
                        ? 'bg-green-500 border-green-500 text-white shadow-lg'
                        : currentStep === index + 1
                          ? 'bg-blue-500 border-blue-500 text-white shadow-lg animate-pulse'
                          : 'bg-gray-100 border-gray-300 dark:bg-gray-800 dark:border-gray-700 text-gray-400'
                    ]"
                    :style="{
                      width: windowWidth < 400 ? '2.5rem' : windowWidth < 700 ? '2.8rem' : '3rem',
                      height: windowWidth < 400 ? '2.5rem' : windowWidth < 700 ? '2.8rem' : '3rem'
                    }"
                  >
                    <i v-if="stepCompletionStatus[index + 1] && currentStep > index + 1"
                      class="pi pi-check font-bold"
                      :style="{ fontSize: stepIconSize }"></i>
                    <i v-else :class="step.icon" :style="{ fontSize: stepIconSize }"></i>
                  </div>
                  <div class="mt-2 text-center w-full">
                    <p :class="[
                          'text-[0.93rem] md:text-base font-medium leading-tight',
                          currentStep === index + 1 ? 'text-blue-600 dark:text-blue-400' :
                          stepCompletionStatus[index + 1] ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'
                        ]"
                        style="word-break: keep-all; white-space: pre-line;">
                      {{ step.label }}
                    </p>
                    <p v-if="windowWidth > 400"
                        class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                      {{ step.description }}
                    </p>
                    <div v-if="currentStep === index + 1" class="mt-2 w-full">
                      <div class="w-14 md:w-16 bg-gray-200 dark:bg-gray-800 rounded-full h-2.5 mx-auto">
                        <div class="bg-blue-500 dark:bg-blue-700 h-2.5 rounded-full transition-all duration-300"
                              :style="{ width: stepCompletionPercentage[index + 1] + '%' }"></div>
                      </div>
                      <span class="text-xs text-blue-600 dark:text-blue-400 mt-1 block">{{ stepCompletionPercentage[index + 1] }}%</span>
                    </div>
                  </div>
                </div>
                <div v-if="index < stepItems.length - 1"
                      :class="[
                        'h-0.5 mx-1 md:mx-3 flex-1 transition-all duration-300 self-center',
                        stepCompletionStatus[index + 1] && currentStep > index + 1
                          ? 'bg-green-500 dark:bg-green-700'
                          : 'bg-gray-300 dark:bg-gray-700'
                      ]"
                      :style="{
                        minWidth: windowWidth < 400 ? '18px' : windowWidth < 700 ? '28px' : '44px'
                      }"></div>
              </template>
            </div>
          </div>
          <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>
          <!-- Step Content -->
          <div class="mt-8">
            <div class="flex justify-between items-center mb-4 text-sm flex-wrap gap-y-2">
              <div class="flex items-center text-gray-500 dark:text-gray-400">
                <i class="pi pi-save mr-2"></i>
                <span>আপনার তথ্য স্বয়ংক্রিয়ভাবে সংরক্ষিত হচ্ছে</span>
              </div>
              <div class="text-xs text-gray-400 dark:text-gray-500">
                সর্বশেষ সংরক্ষণ: এখনই
              </div>
            </div>
            <!-- Step 1: Basic Info -->
            <div v-if="currentStep === 1" class="space-y-6">
              <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-xl p-4 sm:p-6 border border-blue-100 dark:border-gray-700">
                <div class="flex items-center mb-4">
                  <div class="w-10 h-10 bg-blue-500 dark:bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                    <i class="pi pi-user text-white"></i>
                  </div>
                  <div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 dark:text-white">ব্যক্তিগত তথ্য</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base">আপনার ব্যক্তিগত তথ্য সঠিকভাবে পূরণ করুন</p>
                  </div>
                </div>
                <BasicInfo :form="form" :validation-errors="validationErrors" :has-attempted-validation="hasAttemptedValidation" />
              </div>
              <div class="flex justify-end pt-4">
                <Button label="পরবর্তী ধাপ"
                        icon="pi pi-arrow-right"
                        iconPos="right"
                        class="px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-800 border-0 shadow-lg hover:shadow-xl transition-all duration-300"
                        @click="nextStep" />
              </div>
            </div>
            <!-- Step 2: Education Info -->
            <div v-if="currentStep === 2" class="space-y-6">
              <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-900 rounded-xl p-4 sm:p-6 border border-green-100 dark:border-gray-700">
                <div class="flex items-center mb-4">
                  <div class="w-10 h-10 bg-green-500 dark:bg-green-800 rounded-lg flex items-center justify-center mr-3">
                    <i class="pi pi-book text-white"></i>
                  </div>
                  <div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 dark:text-white">শিক্ষাগত তথ্য</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base">আপনার শিক্ষাগত যোগ্যতা ও বিভাগের তথ্য দিন</p>
                  </div>
                </div>
                <EducationInfo :form="form" :validation-errors="validationErrors" :has-attempted-validation="hasAttemptedValidation" />
              </div>
              <div class="flex justify-between pt-4">
                <Button label="পূর্ববর্তী ধাপ"
                        icon="pi pi-arrow-left"
                        class="px-8 py-3 bg-gray-500 dark:bg-gray-800 border-0 shadow-lg hover:shadow-xl transition-all duration-300"
                        @click="prevStep" />
                <Button label="পরবর্তী ধাপ"
                        icon="pi pi-arrow-right"
                        iconPos="right"
                        class="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-700 dark:to-emerald-800 border-0 shadow-lg hover:shadow-xl transition-all duration-300"
                        @click="nextStep" />
              </div>
            </div>
            <!-- Step 3: Final Info -->
            <div v-if="currentStep === 3" class="space-y-6">
              <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-900 rounded-xl p-4 sm:p-6 border border-purple-100 dark:border-gray-700">
                <div class="flex items-center mb-4">
                  <div class="w-10 h-10 bg-purple-500 dark:bg-purple-800 rounded-lg flex items-center justify-center mr-3">
                    <i class="pi pi-shield text-white"></i>
                  </div>
                  <div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 dark:text-white">নিরাপত্তা ও চূড়ান্ত তথ্য</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base">পাসওয়ার্ড এবং অন্যান্য প্রয়োজনীয় তথ্য দিন</p>
                  </div>
                </div>
                <FinalInfo :form="form" :validation-errors="validationErrors" :has-attempted-validation="hasAttemptedValidation" @submit="submit" />
              </div>
              <div class="flex justify-between pt-4">
                <Button label="পূর্ববর্তী ধাপ"
                        icon="pi pi-arrow-left"
                        class="px-8 py-3 bg-gray-500 dark:bg-gray-800 border-0 shadow-lg hover:shadow-xl transition-all duration-300"
                        @click="prevStep" />
                <Button label="রেজিস্ট্রেশন করুন"
                  icon="pi pi-user-plus"
                  iconPos="right"
                  class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-700 dark:from-green-800 dark:to-emerald-900 border-0 shadow-lg hover:shadow-xl transition-all duration-300 font-bold ml-2"
                  :loading="form.processing"
                  @click.prevent="submit" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</template>

<script setup>
// Step navigation and submit functions for template
function nextStep() {
  if (validateStep()) {
    setTimeout(() => {
      currentStep.value++;
    }, 100);
  } else {
    const errorList = Object.values(validationErrors.value);
    const errorMessage = errorList.length > 0 ? errorList.join(', ') : 'অনুগ্রহ করে সব তথ্য পূরণ করুন।';
    toast.error(errorMessage, { position: "top-center", timeout: 4000 });
  }
}

function prevStep() {
  setTimeout(() => {
    currentStep.value--;
  }, 100);
}

function submit() {
  if (validateStep()) {
    form.post(route('register'), {
      onSuccess: () => {
        FormPersistence.clearAllFormData();
        FormPersistence.saveSuccessMessage('নিবন্ধন সফল হয়েছে! স্বাগতম।');
        toast.success('নিবন্ধন সফল হয়েছে! স্বাগতম।', { position: "top-center", timeout: 5000 });
        form.reset();
      },
      onError: (errors) => {
        const errorMessages = Object.values(errors).flat();
        toast.error(errorMessages[0] || 'নিবন্ধন ব্যর্থ হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।', { position: "top-center", timeout: 6000 });
      }
    });
  }
}
// Expose step handlers to template
defineExpose({ nextStep, prevStep, submit });
import BasicInfo from '@/Components/Auth/BasicInfo.vue';
import EducationInfo from '@/Components/Auth/EducationInfo.vue';
import FinalInfo from '@/Components/Auth/FinalInfo.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useToast } from "vue-toastification";
import { FormPersistence } from '@/Helpers/FormPersistence.js';
import Button from 'primevue/button';
import { useStep } from '@/Pages/Auth/composables/useStep.js';
import { useValidation } from '@/Pages/Auth/composables/useValidation.js';
import { useKeyboard } from '@/Pages/Auth/composables/useKeyboard.js';

const form = useForm({
  fullNameBangla: '',
  fullNameEnglish: '',
  fatherName: '',
  email: '',
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
  dept_adab: false,
  dept_other: false,
  dept_takmil_year_english: '',
  dept_takmil_year_hijri: '',
  dept_ifta_year_english: '',
  dept_ifta_year_hijri: '',
  dept_hifz_year_english: '',
  dept_hifz_year_hijri: '',
  dept_qirat_year_english: '',
  dept_qirat_year_hijri: '',
  dept_adab_year_english: '',
  dept_adab_year_hijri: '',
  dept_other_class: '',
  examType: '',
  rollNumber: '',
  workplace: '',
  idType: '',
  birthCertificate: '',
  voterId: '',
  birthCertificatePhoto: null,
  voterIdPhoto: null,
  passport_id: '',
  passport_photo: null,
  photo: null,
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

const toast = useToast();
const {
  currentStep,
  totalSteps,
  progressPercentage,
  stepItems,
  windowWidth,
  stepIconSize,
  stepCompletionStatus,
  stepCompletionPercentage
} = useStep(form);

const {
  validationErrors,
  hasAttemptedValidation,
  validateStep
} = useValidation(form, currentStep);


// Payment Modal State and handler
const showPaymentModal = ref(false);
const isPaymentConfirmed = ref(false);

const handlePaymentSubmitModal = async () => {
  showPaymentModal.value = false;
  isPaymentConfirmed.value = false;
  await handlePaymentSubmit();
};

const handlePaymentSubmit = async () => {
  // ফর্ম ডাটা তৈরি করুন
  const formData = new FormData();
  const booleanFields = [
    'dept_takmil', 'dept_ifta', 'dept_hifz', 'dept_qirat', 'dept_adab', 'dept_other'
  ];
  Object.keys(form).forEach(key => {
    if (form[key] instanceof File && form[key] !== null) {
      formData.append(key, form[key]);
    } else if (booleanFields.includes(key)) {
      formData.append(key, form[key] ? 1 : 0);
    } else {
      formData.append(key, form[key] ?? '');
    }
  });

  try {
    const response = await axios.post('/pay-via-ajax', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    if (response.data.success && response.data.redirect_url) {
      window.location.href = response.data.redirect_url;
    } else {
      alert(response.data.message || 'Payment initiation failed');
    }
  } catch (error) {
    console.error('Payment error:', error);
    if (error.response && error.response.data && error.response.data.message) {
      alert(error.response.data.message);
    } else {
      alert('An error occurred during payment processing');
    }
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