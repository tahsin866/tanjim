<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
const desserts = ref([
  {
    dessert: "দরসিয়াত",
    calories: "জামিয়া আরাবিয়া ইমদাদুল উলুম ফরিদাবাদ ঢাকা ১২৩৬- (W10130)",
  },
]);

const items = ref(["দারসিয়াত", "হিফজ", "ক্বিরাআত"]);
const selectedMadrasa = ref("");
</script>


<template>
    <AuthenticatedLayout>
      <div class="bg-white shadow-xl rounded-md overflow-hidden mt-8 mx-5">
        <!-- Header with Islamic Pattern -->
        <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 text-white px-6 py-4 flex items-center relative">
          <div class="absolute inset-0 opacity-10 pattern-islamic"></div>

          <h2 class="text-2xl font-bold">মারকায পরিবর্তনের ফর্ম</h2>
        </div>

        <!-- Madrasa Selection -->
        <div class="p-6 border-b ">
          <div class="bg-white p-4 rounded-sm shadow-md">
            <label class="text-emerald-800 font-semibold block mb-2">মারকাযের স্তর নির্বাচন করুন</label>
            <select
              v-model="selectedMadrasa"
              class="w-full px-4 py-3 border  rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
            >
              <option value="">মাদরাসা সিলেক্ট করুন</option>
              <option v-for="item in items" :key="item" :value="item">{{ item }}</option>
            </select>
          </div>
        </div>

        <!-- Content Section -->
        <div class="p-6">
    <table class="w-full border-collapse">
        <tbody>
            <!-- Basic Information -->
            <tr>
                <td class="border p-4 w-1/3">
                    <label class="text-emerald-800 font-semibold">মারকাযের ধরন</label>
                </td>
                <td class="border p-4 w-2/3">
                    <div class="text-gray-800">{{ desserts[0].dessert }}</div>
                </td>
            </tr>

            <tr>
                <td class="border p-4">
                    <label class="text-emerald-800 font-semibold">বর্তমান মারকায</label>
                </td>
                <td class="border p-4">
                    <div class="text-gray-800">{{ desserts[0].calories }}</div>
                </td>
            </tr>

            <tr>
                <td class="border p-4">
                    <label class="text-emerald-800 font-semibold">কাঙ্খিত মারকায</label>
                </td>
                <td class="border p-4">
                    <select
                        v-model="selectedMadrasa"
                        class="w-full px-4 py-2 border border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                        <option value="">মাদরাসা সিলেক্ট করুন</option>
                        <option v-for="item in items" :key="item" :value="item">{{ item }}</option>
                    </select>
                </td>
            </tr>

            <!-- File Upload Sections -->
            <tr>
                <td class="border p-4">
                    <label class="text-emerald-800 font-semibold">
                        <i class="fas fa-file-alt mr-2"></i>বর্তমান মারকায অনাপত্তিপত্র
                    </label>
                </td>
                <td class="border p-4">
                    <div class="relative">
                        <input
                            type="file"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            @change="handleFileChange"
                        />
                        <div class="flex items-center justify-center w-full px-4 py-3 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
                            <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
                            <span class="text-gray-600">ফাইল আপলোড করুন</span>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="border p-4">
                    <label class="text-emerald-800 font-semibold">
                        <i class="fas fa-file-signature mr-2"></i>কাঙ্খিত মারকায সম্মতিপত্র
                    </label>
                </td>
                <td class="border p-4">
                    <div class="relative">
                        <input
                            type="file"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            @change="handleFileChange"
                        />
                        <div class="flex items-center justify-center w-full px-4 py-3 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
                            <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
                            <span class="text-gray-600">ফাইল আপলোড করুন</span>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
      </div>
    </AuthenticatedLayout>
  </template>

  <style>
  .pattern-islamic {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l15 30-15 30-15-30z' fill='%23ffffff' fill-opacity='0.1'/%3E%3C/svg%3E");
    background-repeat: repeat;
  }
  </style>

