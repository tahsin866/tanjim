<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

// Define your data
const search = ref('');
const desserts = [
  {
    dessert: 'Frozen Yogurt',
    calories: 159,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
];
</script>

<template>
<AuthenticatedLayout>
    <div class="container-fluid mx-auto p-5">
    <!-- Header Section -->
    <div class="bg-gradient-to-r mb-5 rounded-sm from-emerald-800 to-emerald-600 p-4   shadow-md">
      <div class="flex justify-between items-center">
        <div>

          <h4 class="text-xl text-yellow-400">মাদরাসার তালিকা তালিকা</h4>
        </div>


      </div>
    </div>

    <!-- Search Panel -->
    <div class="bg-white p-3 rounded-sm shadow-lg border-t-4 border-emerald-600 mb-5">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="relative">
          <input v-model="search"
                 type="text"
                 placeholder=" মাদরাসা কোড"
                 class="w-full p-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" />
        </div>

        <div class="relative">
          <input v-model="search"
                 type="text"
                 placeholder="ইলহাক নম্বর"
                 class="w-full p-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" />
        </div>
        <div class="relative">
          <input v-model="search"
                 type="text"
                 placeholder="মাদরাসার নম্বর"
                 class="w-full p-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" />
        </div>
        <div class="flex justify-end gap-4">
  <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-sm transition-colors duration-200 shadow-md flex items-center">
    <i class="fas fa-search mr-2"></i>
    সার্চ করুন
  </button>
  <button class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-sm transition-colors duration-200 shadow-md flex items-center">
    <i class="fas fa-redo-alt mr-2"></i>
    রেসেট
  </button>
</div>
      </div>
    </div>

    <!-- Action Panel -->
    <div class="container-fluid mx-auto ">
    <!-- Header Section -->
    <div class="bg-white rounded-sm shadow-lg p-6 mb-8">
      <div class="flex justify-between items-center">
        <h4 class="text-2xl font-semibold text-emerald-700">
      মোট মাদরাসার উপাত্ত :
        </h4>

        <div class="flex gap-4">
          <button class="flex items-center gap-2 px-6 py-2.5 text-white rounded-sm text-sm font-medium transition-all duration-200 shadow-md active:scale-95 bg-red-500 hover:bg-red-600">
            <span>PDF ডাউনলোড</span>
            <i class="fas fa-file-download"></i>

          </button>
        </div>
      </div>

      <!-- Table Section -->
      <div class="mt-8 overflow-hidden rounded-sm border border-emerald-100">
        <table class="w-full">
          <thead>
            <tr class="bg-emerald-50/80">
              <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-700">ক্রমিক নং</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-700">কোড</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-700">মাদরাসার নাম</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-700">মুহাতামিমের নাম</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-700">ফোন নম্বর</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-700">মাদরাসার নাম</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-700">আবেদন অবস্থা</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-emerald-700">করণীয়</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in desserts"
              :key="item.dessert"
              class="border-b border-emerald-50 hover:bg-emerald-50/50 transition-all duration-200"
            >
              <td class="px-6 py-4 text-sm text-gray-600">{{ item.id }}</td>
              <!-- Add other table cells with the same classes -->
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
</AuthenticatedLayout>
</template>

<style scoped>
/* Custom styles for Islamic vibes */
.header-background {
  background-color: #243b55;
  border-radius: 10px;
}
</style>


