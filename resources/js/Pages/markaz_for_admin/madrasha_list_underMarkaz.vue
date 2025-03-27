<template>
    <AuthenticatedLayout>
        <div class="p-6 bg-[#f8f9fa] min-h-screen mx-5 mt-5">
            <div class=" mx-auto">
                <!-- Header Section -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">

                  মারকাজ ভিত্তিক মাদরাসার তালিকা
                    </h1>

                </div>

                <!-- Search Panel -->


                <!-- Results Table -->
                <div class="mt-8 bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-[#2d6a4f] p-4 flex justify-between items-center">
                        <h2 class="text-white text-lg font-semibold flex items-center gap-2">
                            <i class="fas fa-list"></i>
                            মাদরাসা তালিকা
                        </h2>
                        <!-- <div class="text-white">মোট উপাত্ত: {{ applications.data?.length || 0 }}</div> -->

                    </div>

                    <div class="p-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th v-for="header in tableHeaders" :key="header.id"
                                        class="px-6 py-3 bg-gray-50 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">
                                        {{ header.label }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
<tr v-for="(madrasha, index) in madrashas" :key="madrasha.id"
        class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ index + 1 }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ madrasha.name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ madrasha.Elhaq_no }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ madrasha.id }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ madrasha.mobile_no }}</td>

        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-500">
            <div class="flex gap-2">
                <button @click="viewApplication(madrasha)"
                    class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-eye"></i>
                </button>
                <button @click="editApplication(madrasha)"
                    class="text-green-600 hover:text-green-800 flex items-center gap-2">
                    <i class="fas fa-envelope"></i>
                </button>
            </div>
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
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { ref, reactive, onMounted, computed } from 'vue';
import axios from 'axios';

// State Management





// Table Headers
const tableHeaders = [
    { id: 1, label: "ক্রমিক" },
    { id: 2, label: "মাদরাসার নাম" },
    { id: 3, label: "এলহাক নম্বর" },

    { id: 6, label: "আইডি" },
    { id: 7, label: "মোবাইল নম্বর" },

    { id: 11, label: "অ্যাকশন" }
];

// Computed Properties

const props = defineProps({
    madrashas: Array,
    markazId: Number
});



</script>

