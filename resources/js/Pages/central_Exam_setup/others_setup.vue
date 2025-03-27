<template>
  <AuthenticatedLayout>
    <div class=" bg-gray-50 p-8 mx-5 mt-5">
      <!-- Header Section -->
      <div class="bg-white rounded-sm shadow-sm p-6 mb-6">
        <div class="flex items-center gap-3">
          <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <div>
            <h1 class="text-2xl font-bold text-emerald-800">৪৪তম কেন্দ্রীয় পরীক্ষা</h1>
            <p class="text-emerald-600">(সময়সূচি সেটাপ)</p>
          </div>
        </div>
      </div>

      <!-- Main Form Section -->
      <div class="bg-white rounded-sm shadow-sm p-6">
        <div class="grid gap-6">
    <div v-for="(item, index) in formItems" :key="index"
         :class="[
           'p-4 border rounded-sm transition-colors',
           item.isActive ? 'border-emerald-100 hover:bg-emerald-50/30' : 'border-gray-200 bg-gray-50 opacity-75'
         ]">

      <div class="flex justify-between items-center mb-3">
        <label class="text-emerald-800 flex items-center gap-2 font-semibold">
          <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          {{ item.label }}
        </label>

        <!-- Toggle Switch -->
        <div class="flex items-center">
          <span class="text-sm mr-2">{{ item.isActive ? 'Active' : 'Inactive' }}</span>
          <button
            @click="toggleStatus(index)"
            :class="[
              'relative inline-flex h-6 w-11 items-center rounded-full transition-colors',
              item.isActive ? 'bg-emerald-500' : 'bg-gray-300'
            ]"
          >
            <span
              :class="[
                'inline-block h-4 w-4 transform rounded-full bg-white transition-transform',
                item.isActive ? 'translate-x-6' : 'translate-x-1'
              ]"
            />
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label class="text-sm text-emerald-600 mb-1">শুরুর তারিখ</label>
          <input
            type="date"
            v-model="formItems[index].startDate"

            class="border border-emerald-200 rounded-sm px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed"
          />
        </div>

        <div class="flex flex-col">
          <label class="text-sm text-emerald-600 mb-1">শেষ তারিখ</label>
          <input
            type="date"
            v-model="formItems[index].endDate"

            class="border border-emerald-200 rounded-sm px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed"
          />
        </div>
      </div>
    </div>
  </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-between items-center">
          <button
            @click="resetForm"
            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-sm hover:bg-gray-200 flex items-center gap-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            রিসেট
          </button>

          <button
            @click="submitForm"
            class="px-6 py-2.5 bg-emerald-600 text-white rounded-sm hover:bg-emerald-700 flex items-center gap-2"
          >
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
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    examInfo: Object,
    schedules: Array
});

const formItems = ref([
    { label: 'নেগরান/মুমতাহিন', startDate: '', endDate: '', isActive: false },
    { label: 'মারকায আবেদন', startDate: '', endDate: '', isActive: false },
]);

// Initialize form with existing data
onMounted(() => {
    if (props.schedules) {
        props.schedules.forEach(schedule => {
            const index = formItems.value.findIndex(item => item.label === schedule.schedule_type);
            if (index !== -1) {
                formItems.value[index] = {
                    label: schedule.schedule_type,
                    startDate: schedule.start_date,
                    endDate: schedule.end_date,
                    isActive: schedule.is_active
                };
            }
        });
    }
});

const resetForm = () => {
    formItems.value = formItems.value.map(item => ({
        ...item,
        startDate: '',
        endDate: '',
        isActive: false
    }));
};

const submitForm = async () => {
    try {
        const response = await axios.post('/api/schedule-setups', {
            formItems: formItems.value
        });

        if(response.data.status === 'success') {
            // Show success message
            alert('Data saved successfully');
            // Optional: Refresh data
            window.location.reload();
        }
    } catch (error) {
        alert('Error saving data');
        console.error('Error:', error);
    }
};

const toggleStatus = (index) => {
    formItems.value[index].isActive = !formItems.value[index].isActive;
};
</script>
