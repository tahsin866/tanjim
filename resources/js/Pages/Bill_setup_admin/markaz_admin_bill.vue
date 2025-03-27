<template>
    <AuthenticatedLayout>
        <div class="p-6 bg-gray-50 mx-5 mt-5">
      <!-- Header Section -->
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">

          মারকায এডমিন ভাতা ব্যবস্থাপনা
        </h1>
        <p class="text-gray-600">সকল মারকায এডমিন ও খাদেমদের ভাতা নির্ধারণ করুন</p>
      </div>

      <!-- Input Form Section -->
      <div class="bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-emerald-600 p-4">
          <h2 class="text-white text-lg font-semibold flex items-center gap-2">
            <i class="fas fa-edit"></i>
            ভাতা নির্ধারণ ফরম
          </h2>
        </div>

        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div v-for="(field, index) in allowanceFields" :key="index"
                 class="bg-gray-50 p-3 rounded-sm border border-gray-100 hover:border-emerald-200 transition-all duration-300">
              <label :for="field.id" class="block text-sm font-medium text-gray-700 mb-2">
                {{ field.label }}
              </label>
              <div class="relative">
                <input
                  v-model="formData[field.id]"
                  :id="field.id"
                  type="number"
                  min="0"
                  :placeholder="field.placeholder"
                  class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  @input="validateAndCalculate(field.id)"
                >
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">৳</span>
              </div>
              <p v-if="errors[field.id]" class="mt-1 text-red-500 text-xs">{{ errors[field.id] }}</p>
            </div>
          </div>

          <!-- Total Calculation -->
          <div class="mt-6 bg-emerald-50 p-4 rounded-sm">
            <div class="flex justify-between items-center">
              <div>
                <p class="text-sm text-emerald-700">মোট মাসিক ভাতা</p>
                <p class="text-2xl font-bold text-emerald-600">৳ {{ formatCurrency(calculateTotal()) }}</p>
              </div>
              <div class="flex gap-3">
                <button @click="resetForm"
                        class="px-4 py-2 text-emerald-600 bg-white border border-emerald-200 rounded-sm hover:bg-emerald-50">
                  <i class="fas fa-redo mr-2"></i>রিসেট
                </button>
                <button @click="submitForm"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-sm hover:bg-emerald-700 flex items-center gap-2"
                        :disabled="isSubmitting">
                  <i class="fas fa-save"></i>
                  {{ isSubmitting ? 'সংরক্ষণ হচ্ছে...' : 'সংরক্ষণ করুন' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Display Section -->
      <div class="mt-8 bg-white rounded-sm shadow-sm border border-gray-100">
        <div class="bg-emerald-600 p-4 flex justify-between items-center">
          <h2 class="text-white text-lg font-semibold flex items-center gap-2">
            <i class="fas fa-list-alt"></i>
            বর্তমান ভাতা তালিকা
          </h2>
          <span class="text-emerald-100 text-sm">
            সর্বশেষ আপডেট: {{ lastUpdated }}
          </span>
        </div>

        <div class="p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    পদবী
                  </th>
                  <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    বর্তমান ভাতা
                  </th>
                  <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    পূর্ববর্তী ভাতা
                  </th>
                  <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    পরিবর্তন
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(field, index) in allowanceFields" :key="index"
                    class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ field.label }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-emerald-600 font-medium">
                    ৳ {{ formatCurrency(formData[field.id]) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">
                    ৳ {{ formatCurrency(previousData[field.id]) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right">
                    <span :class="[
                      'px-2 py-1 text-xs font-medium rounded',
                      calculateChange(field.id) > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                    ]">
                      {{ calculateChange(field.id) }}%
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
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
      label: 'মাদরাসা সংখ্যা ২-৫ টি',
      placeholder: 'পরিমাণ লিখুন'
    },
    {
      id: 'assistantChiefAllowance',
      label: 'মাদরাসা সংখ্যা ৬-১০ টি',
      placeholder: 'পরিমাণ লিখুন'
    },
    {
      id: 'assistantAllowance',
      label: 'মাদরাসা সংখ্যা ১১-১৫ টি',
      placeholder: 'পরিমাণ লিখুন'
    },
    {
      id: 'staffAllowance',
      label: 'মাদরাসা সংখ্যা ১৬-২০ টি',
      placeholder: 'পরিমাণ লিখুন'
    },
    {
      id: 'khademAllowance',
      label: 'মাদরাসা সংখ্যা ২১-২৫ টি',
      placeholder: 'পরিমাণ লিখুন'
    },
    {
      id: 'khademAllowance',
      label: 'মাদরাসা সংখ্যা ২৬-৩০ টি',
      placeholder: 'পরিমাণ লিখুন'
    },
    {
      id: 'khademAllowance',
      label: 'মাদরাসা সংখ্যা ৩১-৫০ টি',
      placeholder: 'পরিমাণ লিখুন'
    },
    {
      id: 'khademAllowance',
      label: 'মাদরাসা সংখ্যা ৫০ টির বেশি হলে',
      placeholder: 'পরিমাণ লিখুন'
    }
  ];

  const formData = reactive({
    chiefAllowance: '',
    assistantChiefAllowance: '',
    assistantAllowance: '',
    staffAllowance: '',
    khademAllowance: ''
  });

  // Sample previous data for comparison
  const previousData = {
    chiefAllowance: 5000,
    assistantChiefAllowance: 4000,
    assistantAllowance: 3000,
    staffAllowance: 2500,
    khademAllowance: 2000
  };

  const validateAndCalculate = (fieldId) => {
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

  const calculateChange = (fieldId) => {
    const current = Number(formData[fieldId]) || 0;
    const previous = previousData[fieldId];
    if (!previous) return 0;
    return Math.round(((current - previous) / previous) * 100);
  };

  const submitForm = async () => {
    try {
      isSubmitting.value = true;
      await new Promise(resolve => setTimeout(resolve, 1000));
      lastUpdated.value = format(new Date(), 'PPP');
      // Add your API call here
    } catch (error) {
      console.error(error);
    } finally {
      isSubmitting.value = false;
    }
  };

  const resetForm = () => {
    Object.keys(formData).forEach(key => formData[key] = '');
  };
  </script>
