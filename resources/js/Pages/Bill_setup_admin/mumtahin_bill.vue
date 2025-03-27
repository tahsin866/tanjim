<template>
    <AuthenticatedLayout>
        <div class="p-6 bg-[#f8f9fa] mx-5 mt-5">
      <!-- Header Section -->
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">

            মুমতাহিন ভাতা ব্যবস্থাপনা
          </h1>
          <p class="text-gray-600 mt-1">বিভিন্ন ধরনের মুমতাহিন ভাতা নির্ধারণ করুন</p>
        </div>
        <div class="text-sm text-gray-500">
          <i class="far fa-calendar-alt"></i>
          {{ new Date().toLocaleDateString('bn-BD') }}
        </div>
      </div>

      <!-- Main Form Section -->
      <div class="bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-[#2d6a4f] p-4 flex justify-between items-center">
          <h2 class="text-white text-lg font-semibold flex items-center gap-2">
            <i class="fas fa-edit"></i>
            ভাতা নির্ধারণ ফরম
          </h2>
          <span class="text-[#90caf9] text-sm">* সকল তথ্য বাধ্যতামূলক</span>
        </div>

        <div class="p-6">
          <!-- First Row -->
          <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
            <div v-for="(item, index) in firstRowFields" :key="index"
                 class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
              <label :for="item.id" class=" text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <i :class="item.icon" class="text-[#2d6a4f]"></i>
                {{ item.label }}
              </label>
              <div class="relative">
                <input
                  v-model="formData[item.id]"
                  :id="item.id"
                  type="number"
                  min="0"
                  :placeholder="item.placeholder"
                  class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]"
                  @input="validateInput(item.id)"
                >
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">৳</span>
              </div>
              <p v-if="errors[item.id]" class="mt-1 text-red-500 text-xs">{{ errors[item.id] }}</p>
            </div>
          </div>

          <!-- Second Row -->
          <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <div v-for="(item, index) in secondRowFields" :key="index"
                 class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
              <label :for="item.id" class=" text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <i :class="item.icon" class="text-[#2d6a4f]"></i>
                {{ item.label }}
              </label>
              <div class="relative">
                <input
                  v-model="formData[item.id]"
                  :id="item.id"
                  type="number"
                  min="0"
                  :placeholder="item.placeholder"
                  class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]"
                  @input="validateInput(item.id)"
                >
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">৳</span>
              </div>
              <p v-if="errors[item.id]" class="mt-1 text-red-500 text-xs">{{ errors[item.id] }}</p>
            </div>
          </div>

          <!-- Summary Section -->
          <div class="mt-8 bg-[#f0f9ff] p-4 rounded-lg">
            <div class="flex justify-between items-center">
              <div>
                <p class="text-sm text-[#2d6a4f]">মোট পরিমাণ</p>
                <p class="text-2xl font-bold text-[#2d6a4f]">৳ {{ formatCurrency(calculateTotal()) }}</p>
              </div>
              <div class="flex gap-3">
                <button @click="resetForm"
                        class="px-4 py-2 text-[#2d6a4f] bg-white border border-[#2d6a4f] rounded-sm hover:bg-[#f0f9ff] flex items-center gap-2">
                  <i class="fas fa-redo"></i>
                  রিসেট
                </button>
                <button @click="submitForm"
                        class="px-6 py-2 bg-[#2d6a4f] text-white rounded-sm hover:bg-[#1b4332] flex items-center gap-2"
                        :disabled="isSubmitting || hasErrors">
                  <i class="fas fa-save"></i>
                  {{ isSubmitting ? 'সংরক্ষণ হচ্ছে...' : 'সংরক্ষণ করুন' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- History Section -->
      <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="bg-[#2d6a4f] p-4 flex justify-between items-center">
          <h2 class="text-white text-lg font-semibold flex items-center gap-2">
            <i class="fas fa-history"></i>
            পূর্ববর্তী রেকর্ড
          </h2>
          <button class="text-white hover:text-[#90caf9]">
            <i class="fas fa-download"></i>
            রিপোর্ট ডাউনলোড
          </button>
        </div>

        <div class="p-6 overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase">ভাতার ধরন</th>
                <th class="px-6 py-3 bg-gray-50 text-right text-md font-semibold text-gray-500 uppercase">বর্তমান</th>
                <th class="px-6 py-3 bg-gray-50 text-right text-md font-semibold text-gray-500 uppercase">পূর্ববর্তী</th>
                <th class="px-6 py-3 bg-gray-50 text-right text-md font-semibold text-gray-500 uppercase">পরিবর্তন</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="(item, index) in [...firstRowFields, ...secondRowFields]" :key="index"
                  class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ item.label }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-[#2d6a4f]">
                  ৳ {{ formatCurrency(formData[item.id]) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">
                  ৳ {{ formatCurrency(previousData[item.id]) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right">
                  <span :class="getChangeClass(item.id)">
                    {{ calculateChange(item.id) }}%
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { ref, reactive, computed } from 'vue';

  const isSubmitting = ref(false);
  const errors = reactive({});

  const firstRowFields = [
    { id: 'field', label: 'ফযীলত', icon: 'fas fa-map-marker-alt', placeholder: 'পরিমাণ লিখুন' },
    { id: 'sanabiyaGift', label: 'সানাবিয়া উলইয়া', icon: 'fas fa-gift', placeholder: 'পরিমাণ লিখুন' },
    { id: 'sanabiyaSaniya', label: 'সানাবিয়া সানিয়া', icon: 'fas fa-book', placeholder: 'পরিমাণ লিখুন' },
    { id: 'mriyatisSis', label: 'মুতাওয়াসসিতাহ', icon: 'fas fa-user-friends', placeholder: 'পরিমাণ লিখুন' },
    { id: 'eventior', label: 'ইবতিদাইয়্যাহ', icon: 'fas fa-calendar-check', placeholder: 'পরিমাণ লিখুন' }
  ];

  const secondRowFields = [
    { id: 'hisaabField', label: 'হিফজ ও ক্বিরআত', icon: 'fas fa-calculator', placeholder: 'পরিমাণ লিখুন' },
    { id: 'hisaabReaction', label: 'হিফজ ও ক্বিরআত পরীক্ষায় অতিরিক্ত প্রতি ১ দিনের জন্য', icon: 'fas fa-chart-line', placeholder: 'পরিমাণ লিখুন' },
    { id: 'womanHisaab', label: 'মহিলা হিফজ ‍মুমতাহিন', icon: 'fas fa-female', placeholder: 'পরিমাণ লিখুন' },
    { id: 'manHisaab', label: 'পুরুষ মুমতাহিন মহিল হিফজ পরীক্ষার্থীদের জন্য', icon: 'fas fa-male', placeholder: 'পরিমাণ লিখুন' },
    { id: 'najeeraTester', label: 'নাজেরা পরীক্ষক', icon: 'fas fa-user-check', placeholder: 'পরিমাণ লিখুন' }
  ];

  const formData = reactive(
    Object.fromEntries([...firstRowFields, ...secondRowFields].map(field => [field.id, '']))
  );

  const previousData = reactive({
    field: 5000,
    sanabiyaGift: 3000,
    sanabiyaSaniya: 2500,
    mriyatisSis: 4000,
    eventior: 3500,
    hisaabField: 4500,
    hisaabReaction: 3000,
    womanHisaab: 4000,
    manHisaab: 4000,
    najeeraTester: 3500
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

  const hasErrors = computed(() => Object.keys(errors).length > 0);

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

  const getChangeClass = (fieldId) => {
    const change = calculateChange(fieldId);
    return {
      'px-2 py-1 text-xs font-medium rounded': true,
      'bg-green-100 text-green-800': change >= 0,
      'bg-red-100 text-red-800': change < 0
    };
  };

  const submitForm = async () => {
    try {
      isSubmitting.value = true;
      // Add your API call here
      await new Promise(resolve => setTimeout(resolve, 1000));
      // Show success message
    } catch (error) {
      // Handle error
    } finally {
      isSubmitting.value = false;
    }
  };

  const resetForm = () => {
    Object.keys(formData).forEach(key => formData[key] = '');
  };
  </script>
