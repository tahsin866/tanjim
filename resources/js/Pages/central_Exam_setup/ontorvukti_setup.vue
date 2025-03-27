<template>
 <AuthenticatedLayout>
    <div class="p-6 bg-emerald-50  mx-5 mt-5">
      <!-- Header -->
      <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
          </svg>
          <h1 class="text-2xl font-bold text-emerald-800">পরীক্ষা সেটআপ ম্যানেজমেন্ট</h1>
        </div>

        <div class="flex gap-3">
          <button class="px-4 py-2 bg-white text-emerald-700 rounded-sm hover:bg-emerald-100 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            এক্সেল ডাউনলোড
          </button>
        </div>
      </div>

      <!-- Main Table -->
      <div class="bg-white rounded-sm shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-gray-700">
            <thead class="bg-emerald-100 text-emerald-800 font-semibold text-center">
                <tr>
                    <th class="py-3 px-4">ক্রমিক</th>
                    <th class="py-3 px-4">পরীক্ষা (বিষয়)</th>
                    <th class="py-3 px-4">ফরম পূরণ সময়কাল</th>
                    <th class="py-3 px-4">ফি</th>
                    <th class="py-3 px-4">বিলম্ব ফরম পূরণ সময়কাল</th>
                    <th class="py-3 px-4">ফি</th>
                    <th class="py-3 px-4">স্ট্যাটাস</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 text-center">
                <tr v-for="(exam, index) in exams" :key="index" class="hover:bg-emerald-50">
                    <td class="py-3 px-4">{{ index + 1 }}</td>
                    <td class="py-3 px-4 font-medium text-emerald-800">{{ exam.name }}</td>

                    <!-- ফরম পূরণ সময়কাল (এক লাইনে রাখার জন্য flex) -->
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-center gap-2">
                            <input type="date" v-model="exam.startDate"
                                class="w-40 border border-emerald-300 rounded-sm px-2 py-1 focus:ring focus:ring-emerald-400">
                            <span class="text-gray-500">-</span>
                            <input type="date" v-model="exam.endDate"
                                class="w-40 border border-emerald-300 rounded-sm px-2 py-1 focus:ring focus:ring-emerald-400">
                        </div>
                    </td>

                    <td class="py-3 px-4">
                        <input type="number" v-model="exam.fee1"
                            class="w-40 border border-emerald-300 rounded-sm px-2 py-1 focus:ring focus:ring-emerald-400">
                    </td>

                    <!-- বিলম্ব ফরম পূরণ সময়কাল (এক লাইনে রাখার জন্য flex) -->
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-center gap-2">
                            <input type="date" v-model="exam.startDate2"
                                class="w-40 border border-emerald-300 rounded-sm px-2 py-1 focus:ring focus:ring-emerald-400">
                            <span class="text-gray-500">-</span>
                            <input type="date" v-model="exam.endDate2"
                                class="w-40 border border-emerald-300 rounded-sm px-2 py-1 focus:ring focus:ring-emerald-400">
                        </div>
                    </td>

                    <td class="py-3 px-4">
                        <input type="number" v-model="exam.fee2"
                            class="w-40 border border-emerald-300 rounded-sm px-2 py-1 focus:ring focus:ring-emerald-400">
                    </td>

                    <td class="py-3 px-4">
                        <select v-model="exam.status"
                            class=" w-40 border border-emerald-300 rounded-sm px-2 py-1 focus:ring focus:ring-emerald-400">
                            <option value="Active">সক্রিয়</option>
                            <option value="Inactive">নিষ্ক্রিয়</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer Actions -->
    <div class="p-4 border-t border-gray-200 flex justify-between items-center bg-gray-50">
        <button @click="resetForm"
            class="px-5 py-2 bg-gray-200 text-gray-700 rounded-sm hover:bg-gray-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            রিসেট
        </button>

        <button @click="submitForm"
            class="px-5 py-2 bg-emerald-600 text-white rounded-sm hover:bg-emerald-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            সংরক্ষণ করুন
        </button>
    </div>
</div>

    </div>
 </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { ref } from 'vue'

  const exams = ref([
    {
      name: 'ফযিলত',
      startDate: '2025-03-01',
      endDate: '2025-03-01',
      fee1: 12.00,
      startDate2: '',
      endDate2: '',
      fee2: 0.00,
      status: 'Active'
    },
    {
      name: 'সানাবিয়া উলইয়া',
      startDate: '2025-03-01',
      endDate: '2025-03-01',
      fee1: 0.00,
      startDate2: '',
      endDate2: '',
      fee2: 0.00,
      status: 'Active'
    },
    // Add other exam objects...
  ])

  const submitForm = () => {
    console.log('Form submitted:', exams.value)
  }

  const resetForm = () => {
    exams.value = exams.value.map(exam => ({
      ...exam,
      startDate: '',
      endDate: '',
      fee1: 0,
      startDate2: '',
      endDate2: '',
      fee2: 0,
      status: 'Active'
    }))
  }
  </script>
