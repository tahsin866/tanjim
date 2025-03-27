<template>
   <AuthenticatedLayout>
    <div class="p-4 bg-[#f8f9fa]">
      <!-- Form Section -->
      <div class="bg-[#1b4332] p-4 rounded-t-sm flex items-center gap-3">

        <h2 class="text-white text-xl font-arabic">নেগরান ভাতা</h2>
      </div>

      <div class=" p-6  shadow-md border-t-4 ">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
          <div v-for="(field, index) in allowanceFields" :key="index"
               class="transform transition-all duration-300 hover:scale-105">
            <label :for="field.id" class=" text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
              <i :class="field.icon" class="text-[#2d6a4f]"></i>
              {{ field.label }}
            </label>
            <div class="relative">
              <input
                v-model="formData[field.id]"
                :id="field.id"
                type="number"
                min="0"
                :placeholder="field.placeholder"
                class="mt-1 block w-full border-gray-300 rounded-sm shadow-sm focus:ring-[#2d6a4f] focus:border-[#2d6a4f] sm:text-sm"
                @input="validateInput(field.id)"
              >
              <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">৳</span>
            </div>
            <p v-if="errors[field.id]" class="mt-1 text-red-500 text-xs">{{ errors[field.id] }}</p>
          </div>
        </div>

        <div class="mt-6 flex gap-4">
          <button
            @click="submitForm"
            class="bg-[#2d6a4f] text-white px-6 py-2 rounded-sm hover:bg-[#1b4332] transition-colors duration-300 flex items-center gap-2"
            :disabled="isSubmitting"
          >
            <i class="fas fa-save"></i>
            {{ isSubmitting ? 'সংরক্ষণ করা হচ্ছে...' : 'সংরক্ষণ করুন' }}
          </button>
          <button
            @click="resetForm"
            class="border border-[#2d6a4f] text-[#2d6a4f] px-6 py-2 rounded-sm hover:bg-[#2d6a4f] hover:text-white transition-colors duration-300"
          >
            রিসেট করুন
          </button>
        </div>
      </div>

      <!-- Display Section -->
      <div class="mt-8">
        <div class="bg-[#1b4332] p-4 rounded-t-sm flex justify-between items-center">
          <div class="flex items-center gap-3">

            <h2 class="text-white text-xl font-arabic">বর্তমান ভাতা তালিকা</h2>
          </div>
          <span class="text-white text-sm">
            আপডেট: {{ lastUpdated }}
          </span>
        </div>

        <div class="bg-white p-6 rounded-b-sm shadow-md">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div v-for="(field, index) in allowanceFields" :key="index"
                 class="bg-[#f8f9fa] p-4 rounded-sm border border-gray-200">
              <p class="text-sm font-medium text-gray-700 flex items-center gap-2">
                <i :class="field.icon" class="text-[#2d6a4f]"></i>
                {{ field.label }}
              </p>
              <p class="mt-2 text-lg font-semibold text-[#2d6a4f]">
                {{ formatCurrency(formData[field.id]) }} ৳
              </p>
            </div>
          </div>

          <div class="mt-6 p-4 bg-[#e9ecef] rounded-sm">
            <p class="text-sm text-gray-600 flex items-center gap-2">
              <i class="fas fa-info-circle text-[#2d6a4f]"></i>
              মোট মাসিক ভাতা: {{ formatCurrency(calculateTotal()) }} ৳
            </p>
          </div>
        </div>
      </div>
    </div>
   </AuthenticatedLayout>
  </template>

  <script setup>
  import { ref, reactive } from 'vue';
  import { format } from 'date-fns';
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';

  const isSubmitting = ref(false);
  const lastUpdated = ref(format(new Date(), 'PPP'));
  const errors = reactive({});

  const allowanceFields = [
    {
      id: 'chiefAllowance',
      label: 'প্রধান নেগরান ভাতা',
      placeholder: 'পরিমাণ লিখুন',
      icon: 'fas fa-user-tie'
    },
    {
      id: 'assistantChiefAllowance',
      label: 'সহকারী প্রধান নেগরান ভাতা',
      placeholder: 'পরিমাণ লিখুন',
      icon: 'fas fa-user-friends'
    },
    {
      id: 'assistantAllowance',
      label: 'সহকারী নেগরান ভাতা',
      placeholder: 'পরিমাণ লিখুন',
      icon: 'fas fa-user'
    },
    {
      id: 'staffAllowance',
      label: 'নেগরান অফিস স্টাফ ভাতা',
      placeholder: 'পরিমাণ লিখুন',
      icon: 'fas fa-users'
    },
    {
      id: 'khademAllowance',
      label: 'খাদেম ভাতা',
      placeholder: 'পরিমাণ লিখুন',
      icon: 'fas fa-pray'
    }
  ];

  const formData = reactive({
    chiefAllowance: '',
    assistantChiefAllowance: '',
    assistantAllowance: '',
    staffAllowance: '',
    khademAllowance: ''
  });

  const validateInput = (fieldId) => {
    const value = formData[fieldId];
    if (value < 0) {
      errors[fieldId] = 'নেগেটিভ মান গ্রহণযোগ্য নয়';
      formData[fieldId] = '';
    } else {
      delete errors[fieldId];
    }
  };

  const calculateTotal = () => {
    return Object.values(formData).reduce((sum, value) => sum + (Number(value) || 0), 0);
  };

  const formatCurrency = (value) => {
    return new Intl.NumberFormat('bn-BD').format(value || 0);
  };

  const submitForm = async () => {
    try {
      isSubmitting.value = true;
      // Add your API call here
      await new Promise(resolve => setTimeout(resolve, 1000)); // Simulated API delay
      lastUpdated.value = format(new Date(), 'PPP');
      // Show success toast
    } catch (error) {
      // Show error toast
    } finally {
      isSubmitting.value = false;
    }
  };

  const resetForm = () => {
    Object.keys(formData).forEach(key => formData[key] = '');
  };
  </script>

  <style scoped>


  /* Add smooth transitions */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s ease;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>
