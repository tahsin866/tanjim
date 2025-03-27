<template>
   <AuthenticatedLayout>
    <div class="p-6 bg-[#f8f9fa] min-h-screen mx-5 mt-5">

<!-- Header -->
<div class="bg-[#2d6a4f] text-white p-4 rounded-sm shadow-md mb-4">
  <h1 class="text-2xl font-semibold text-center">মাদ্রাসা ছাত্র তালিকা</h1>
</div>

<!-- Search Filters -->
<div class="bg-white shadow-md rounded-sm p-4 mb-6">
  <div class="grid grid-cols-4 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">বিভাগ</label>
      <select class="mt-1 block w-full border-gray-300 rounded-sm shadow-sm">
        <option>সিলেক্ট</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">শ্রেণি</label>
      <select class="mt-1 block w-full border-gray-300 rounded-sm shadow-sm">
        <option>সিলেক্ট</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">রেজিস্ট্রেশন নাম্বার</label>
      <input type="text" class="mt-1 block w-full border-gray-300 rounded-sm shadow-sm" />
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">রোল নাম্বার</label>
      <input type="text" class="mt-1 block w-full border-gray-300 rounded-sm shadow-sm" />
    </div>
  </div>

  <div class="mt-4 flex justify-end">
    <button class="bg-[#2d6a4f] text-white px-4 py-2 rounded-sm hover:bg-green-700">সার্চ করুন</button>
  </div>
</div>

<!-- Statistics -->
<div class="flex space-x-4 mb-6">
  <div class="bg-yellow-500 text-white p-1 rounded-sm shadow-md">মোট ছাত্র: ১০০</div>
  <div class="bg-green-500 text-white p-1 rounded-sm shadow-md">উত্তীর্ণ: ৭০</div>
  <div class="bg-red-500 text-white p-1 rounded-sm shadow-md">অনুত্তীর্ণ: ৩০</div>
</div>

<!-- Student Table -->
<div class="bg-white shadow-md rounded-sm overflow-hidden">
  <table class="w-full table-auto">
    <thead class="bg-[#2d6a4f] text-white">
      <tr>
        <th class="p-2">#</th>
        <th class="p-2">ছবি</th>
        <th class="p-2">নাম</th>
        <th class="p-2">শ্রেণি</th>
        <th class="p-2">রোল নাম্বার</th>
        <th class="p-2">রেজিস্ট্রেশন নাম্বার</th>
        <th class="p-2">জন্ম তারিখ</th>
        <th class="p-2">পিতার নাম</th>
        <th class="p-2">মাতার নাম</th>
        <th class="p-2">স্ট্যাটাস</th>
        <th class="p-2">অ্যাকশন</th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200 text-xl">
      <tr v-for="(student, index) in students" :key="index">
        <td class="p-2 text-center">{{ index + 1 }}</td>
        <td class="p-2 text-center">
  <img
    v-if="student.student_image"
    :src="'/storage/' + student.student_image"
    alt="Student"
    class="w-20 h-20 rounded-sm mx-auto object-cover"
  />
  <div v-else class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mx-auto">
    <span class="text-gray-500 text-xs">No Image</span>
  </div>
</td>

        <td class="p-2 text-center">{{ student.name_bn }}</td>
        <td class="p-2 text-center">{{ }}</td>
        <td class="p-2 text-center">{{}}</td>
        <td class="p-2 text-center">{{ student.id  }}</td>
        <td class="p-2 text-center">{{ student.Date_of_birth }}</td>
        <td class="p-2 text-center">{{  student.father_name_bn  }}</td>
        <td class="p-2 text-center">{{  student.mother_name_bn  }}</td>
        <td class="p-2 text-center">
          <!-- <span :class="statusClass(student.status)">{{  }}</span> -->
        </td>
        <td class="p-2 text-center">
          <Link
           :href="route('nibondon_for_admin.student_detiles_For_nibondon')"
          class="bg-yellow-500 text-white px-3 py-1 rounded-sm text-xs hover:bg-yellow-600">ডিটেইলস</Link>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<!-- Pagination -->
<div class="flex justify-center mt-4 space-x-2">
  <button class="px-3 py-1 bg-green-600 text-white rounded-md">1</button>
  <button class="px-3 py-1 bg-gray-300 rounded-md">2</button>
  <button class="px-3 py-1 bg-gray-300 rounded-md">3</button>
</div>
</div>
   </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref,onMounted } from 'vue'
import { defineProps } from 'vue';
import axios from 'axios';

const props = defineProps({
  students: Array,
  madrasha_id: Number
});



  const statusClass = (status) => {
    return status === 'উত্তীর্ণ'
      ? 'bg-green-500 text-white px-2 py-1 rounded-sm text-xs'
      : 'bg-red-500 text-white px-2 py-1 rounded-sm text-xs'
  }















  </script>

  <style scoped>
  /* Optional - Add Islamic font if needed */

  </style>
