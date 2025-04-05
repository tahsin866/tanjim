<template>
   <AuthenticatedLayout>
    <div class="p-6 bg-[#f8f9fa] min-h-screen mx-5 mt-5">

<!-- Header -->
<div class="bg-[#2d6a4f] text-white p-4 rounded-sm shadow-md mb-4">
  <h1 class="text-2xl font-semibold text-center">
    {{ students.length > 0 ? students[0].current_madrasha : '' }} : ছাত্র তালিকা
  </h1>
</div>

<!-- Search Filters -->
<div class="bg-white shadow-lg rounded-md p-6 mb-6 border border-gray-100">
  <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">ছাত্র তথ্য অনুসন্ধান</h2>
  
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">স্ট্যাটাস</label>
      <div class="relative">
        <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
          <option>সিলেক্ট করুন</option>
          <option>অনুমোদন</option>
          <option>বোর্ড দাখিল</option>
          <option>স্থগিত</option>
        </select>
      
      </div>
    </div>
    
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">মারহালা</label>
      <div class="relative">
        <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
          <option>সিলেক্ট করুন</option>
          <option>ফযিলত</option>
          <option>সানাবিয়া উলইয়া</option>
          <option>সানাবিয়া</option>
          <option>মুতাওয়াসসিতা</option>
          <option>ইবতেদাইয়া</option>
          <option>হিফজুল কোরআন</option>
          <option>ইলমুল কিরাআত</option>
        </select>
   
      </div>
    </div>
    
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">রেজিস্ট্রেশন নাম্বার</label>
      <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="রেজিস্ট্রেশন নাম্বার লিখুন" />
    </div>
    
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">রোল নাম্বার</label>
      <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="রোল নাম্বার লিখুন" />
    </div>
  </div>
  
  <div class="mt-6 flex justify-end">
    <button class="bg-[#2d6a4f] text-white px-5 py-2 rounded-md hover:bg-[#1b4332] transition-colors duration-300 flex items-center shadow-md">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
      সার্চ করুন
    </button>
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
        <td class="p-2 text-center">{{student.current_class }}</td>

        <td class="p-2 text-center">{{ student.id  }}</td>
        <td class="p-2 text-center">{{ student.Date_of_birth }}</td>
        <td class="p-2 text-center">{{  student.father_name_bn  }}</td>
        <td class="p-2 text-center">{{  student.mother_name_bn  }}</td>
        <td class="p-2 text-center">
  <span 
    :class="{
      'bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium': student.status === 'বোর্ড দাখিল',
      'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium': student.status === 'অনুমোদন',
      'bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium': student.status === 'বোর্ড ফেরত',
      'bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium': student.status === 'পেন্ডিং',
      'bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-medium': !student.status
    }"
  >
    {{ student.status || 'অনির্ধারিত' }}
  </span>
</td>
        <td class="p-2 text-center">
          <Link
  :href="route('nibondon_for_admin.student_detiles_For_nibondon', student.id)"
  class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:outline-none focus:border-emerald-700 focus:ring focus:ring-emerald-200 active:bg-emerald-700 transition ease-in-out duration-150"
>
  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
  </svg>
  বিস্তারিত দেখুন
</Link>
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
