<template>
  <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-100 dark:border-gray-800 p-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
      <i class="pi pi-users text-blue-500"></i>
      ছাত্র পরিসংখ্যান
    </h3>

    <div v-if="loading" class="text-gray-500 dark:text-gray-400">লোড হচ্ছে...</div>
    <div v-else-if="error" class="text-red-600 dark:text-red-400">{{ error }}</div>
    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-blue-50 dark:bg-blue-900 rounded p-4 flex flex-col items-center">
        <div class="text-2xl font-bold text-blue-700 dark:text-blue-200">{{ studentStats.totalStudents }}</div>
        <div class="text-sm text-gray-600 dark:text-gray-300 mt-2">মোট ছাত্র</div>
      </div>
      <div class="bg-green-50 dark:bg-green-900 rounded p-4 flex flex-col items-center">
        <div class="text-2xl font-bold text-green-700 dark:text-green-200">{{ studentStats.boardSubmittedStudents }}</div>
        <div class="text-sm text-gray-600 dark:text-gray-300 mt-2">বোর্ডে সাবমিটেড</div>
      </div>
      <div class="bg-emerald-50 dark:bg-emerald-900 rounded p-4 flex flex-col items-center">
        <div class="text-2xl font-bold text-emerald-700 dark:text-emerald-200">{{ studentStats.approvedStudents }}</div>
        <div class="text-sm text-gray-600 dark:text-gray-300 mt-2">অনুমোদিত</div>
      </div>
      <div class="bg-red-50 dark:bg-red-900 rounded p-4 flex flex-col items-center">
        <div class="text-2xl font-bold text-red-700 dark:text-red-200">{{ studentStats.boardReturnedStudents }}</div>
        <div class="text-sm text-gray-600 dark:text-gray-300 mt-2">বোর্ড ফেরত</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const studentStats = ref({
    totalStudents: 0,
    boardSubmittedStudents: 0,
    approvedStudents: 0,
    boardReturnedStudents: 0
});

const loading = ref(true);
const error = ref(null);

onMounted(async () => {
    try {
        const response = await axios.get('/api/dashboard/student-stats');
        studentStats.value = response.data;
        loading.value = false;
    } catch (err) {
        error.value = 'ডাটা লোড করতে সমস্যা হয়েছে';
        loading.value = false;
        console.error(err);
    }
});
</script>
