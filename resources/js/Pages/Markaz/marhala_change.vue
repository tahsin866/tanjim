<template>
    <AuthenticatedLayout>
        <div class=" mx-auto space-y-6 p-6">
      <!-- First Card - Level Selection -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-emerald-100">
  <div class="bg-gradient-to-r from-emerald-800 to-emerald-900 px-6 py-3">
    <h2 class="text-xl font-bold text-white flex items-center gap-3">
      <i class="fas fa-mosque"></i>
      ইলহাক আবেদন ফরম
      <i class="fas fa-scroll ml-2"></i>
    </h2>
  </div>

  <div class="p-6 ">
    <div class="max-w-xs">
      <label class="text-lg font-medium text-emerald-800 mb-3 flex items-center gap-2">
        <i class="fas fa-star-and-crescent text-emerald-600"></i>
        মারহাল নির্বাচন করুন
      </label>

      <div class="relative">
        <select
          v-model="selectedLevel"
          class="w-full rounded-md border-emerald-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 pl-10 py-2.5 text-emerald-700 bg-white"
        >
          <option value="">নতুন সর্বোচ্চ মারহালা নির্বাচন করুন</option>
          <option v-for="item in items" :key="item.value" :value="item.value">
            {{ item.text }}
          </option>
        </select>
        <i class="fas fa-book-open absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600"></i>
      </div>
    </div>
  </div>
</div>


      <!-- Second Card - Student Numbers -->
      <div class="bg-white rounded-md shadow-lg overflow-hidden ">
  <div class="bg-gradient-to-r from-emerald-800 to-emerald-900 px-6 py-3">
    <h2 class="text-xl font-bold text-white flex items-center gap-3">
      <i class="fas fa-users"></i>
      ছাত্র সংখ্যার তথ্য
    </h2>
  </div>

  <div class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Fazilat -->
      <div class="space-y-3">
        <label class="text-lg font-medium text-emerald-800 flex items-center gap-2">
          <i class="fas fa-graduation-cap text-emerald-600"></i>
          ফযীলত
        </label>
        <div class="relative">
          <input
            v-model.number="studentCounts.fazilat"
            type="number"
            class="w-full rounded-md border-emerald-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 pl-10 py-2.5"
            placeholder="ছাত্র সংখ্যা লিখুন"
          >
          <i class="fas fa-user-graduate absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600"></i>
        </div>
      </div>

      <!-- Ibtedaiyyah -->
      <div class="space-y-3">
        <label class=" text-lg font-medium text-emerald-800 flex items-center gap-2">
          <i class="fas fa-school text-emerald-600"></i>
          ইবতেদাইয়্যাহ
        </label>
        <div class="relative">
          <input
            v-model.number="studentCounts.ibtedaiyyah"
            type="number"
            class="w-full rounded-md border-emerald-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 pl-10 py-2.5"
            placeholder="ছাত্র সংখ্যা লিখুন"
          >
          <i class="fas fa-user-graduate absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600"></i>
        </div>
      </div>

      <!-- Sanabiya Ulya -->
      <div class="space-y-3">
        <label class="text-lg font-medium text-emerald-800 flex items-center gap-2">
          <i class="fas fa-book-reader text-emerald-600"></i>
          সানাবিয়া উলইয়া
        </label>
        <div class="relative">
          <input
            v-model.number="studentCounts.sanabiyaUlya"
            type="number"
            class="w-full rounded-md border-emerald-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 pl-10 py-2.5"
            placeholder="ছাত্র সংখ্যা লিখুন"
          >
          <i class="fas fa-user-graduate absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600"></i>
        </div>
      </div>

      <!-- Hifzul Quran -->
      <div class="space-y-3">
        <label class=" text-lg font-medium text-emerald-800 flex items-center gap-2">
          <i class="fas fa-quran text-emerald-600"></i>
          হিফজুল কোরআন
        </label>
        <div class="relative">
          <input
            v-model.number="studentCounts.hifz"
            type="number"
            class="w-full rounded-md border-emerald-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 pl-10 py-2.5"
            placeholder="ছাত্র সংখ্যা লিখুন"
          >
          <i class="fas fa-user-graduate absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600"></i>
        </div>
      </div>

      <!-- Mutawassita -->
      <div class="space-y-3">
        <label class=" text-lg font-medium text-emerald-800 flex items-center gap-2">
          <i class="fas fa-book-open text-emerald-600"></i>
          মুতাওয়াসসিতা
        </label>
        <div class="relative">
          <input
            v-model.number="studentCounts.mutawassita"
            type="number"
            class="w-full rounded-md border-emerald-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 pl-10 py-2.5"
            placeholder="ছাত্র সংখ্যা লিখুন"
          >
          <i class="fas fa-user-graduate absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600"></i>
        </div>
      </div>

      <!-- Qirat -->
      <div class="space-y-3">
        <label class="text-lg font-medium text-emerald-800 flex items-center gap-2">
          <i class="fas fa-microphone-alt text-emerald-600"></i>
          ক্বিরআত
        </label>
        <div class="relative">
          <input
            v-model.number="studentCounts.qirat"
            type="number"
            class="w-full rounded-md border-emerald-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 pl-10 py-2.5"
            placeholder="ছাত্র সংখ্যা লিখুন"
          >
          <i class="fas fa-user-graduate absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600"></i>
        </div>
      </div>
    </div>

    <!-- Total Students -->
    <div class="mt-8 max-w-xs">
      <label class="text-lg font-medium text-emerald-800 flex items-center gap-2">
        <i class="fas fa-calculator text-emerald-600"></i>
        মোট ছাত্র সংখ্যা
      </label>
      <div class="relative">
        <input
          :value="totalStudents"
          type="number"
          class="w-full rounded-md border-emerald-200 bg-emerald-50 shadow-sm pl-10 py-2.5"
          disabled
        >
        <i class="fas fa-users absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600"></i>
      </div>
    </div>
  </div>
</div>

      <!-- Third Card - File Uploads -->
      <div class="bg-white rounded-md shadow-lg overflow-hidden">
  <div class="bg-gradient-to-r from-[#0B4D2F] to-[#116D45] px-6 py-3"> <!-- Islamic green gradient -->
    <h2 class="text-xl font-bold text-white flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
      </svg>
      প্রয়োজনীয় ডকুমেন্টস
    </h2>
  </div>

  <div class="p-6 bg-[#F8F9FA]">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <div class="space-y-2">
        <label class="text-xl font-medium text-gray-700 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#116D45]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          মুহতামিমের পত্র
        </label>

        <div class="flex items-center justify-center w-full">
          <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-[#116D45] border-dashed rounded-lg cursor-pointer bg-white hover:bg-green-50 transition-colors duration-200">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
              <svg class="w-8 h-8 mb-4 text-[#116D45]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
              </svg>
              <p class="mb-2 text-sm text-gray-600"><span class="font-semibold">ফাইল আপলোড করুন</span></p>
            </div>
            <input type="file" class="hidden" @change="handleFileUpload($event, 'muhtamim')" />
          </label>
        </div>
      </div>

      <div class="space-y-2">
        <label class="text-xl font-medium text-gray-700 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#116D45]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
          কমিটি রেজুলেশন ফটোকপি
        </label>

        <div class="flex items-center justify-center w-full">
          <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-[#116D45] border-dashed rounded-lg cursor-pointer bg-white hover:bg-green-50 transition-colors duration-200">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
              <svg class="w-8 h-8 mb-4 text-[#116D45]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
              </svg>
              <p class="mb-2 text-sm text-gray-600"><span class="font-semibold">ফাইল আপলোড করুন</span></p>
            </div>
            <input type="file" class="hidden" @change="handleFileUpload($event, 'committee')" />
          </label>
        </div>
      </div>
    </div>

    <div class="mt-8 flex justify-end">
      <button
        @click="submitForm"
        class="px-6 py-2 bg-[#116D45] text-white rounded-lg hover:bg-[#0B4D2F] transition-colors duration-200 flex items-center gap-2"
      >
        <span>সাবমিট করুন</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>
  </div>
</div>

    </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, computed } from 'vue'

  const selectedLevel = ref('')
  const items = [
    { value: 'level1', text: 'Level 1' },
    { value: 'level2', text: 'Level 2' },
    { value: 'level3', text: 'Level 3' },
  ]

  const studentCounts = ref({
    fazilat: 0,
    ibtedaiyyah: 0,
    sanabiyaUlya: 0,
    hifz: 0,
    mutawassita: 0,
    qirat: 0
  })

  const totalStudents = computed(() => {
    return Object.values(studentCounts.value).reduce((sum, count) => sum + (count || 0), 0)
  })

  const handleFileUpload = (event, type) => {
    const file = event.target.files[0]
    // Handle file upload logic here
  }

  const submitForm = () => {
    // Handle form submission
  }
  </script>
