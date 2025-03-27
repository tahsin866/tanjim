<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'


const search = ref('')
const searchMobile = ref('')

const students = ref([
  {
    id: 12568,
    date: '05/09/2023',
    institute: 'জামিয়া আরাবিয়া ইমদাদুল উলুম ফরিদবাদ ঢাকা',
    level: 'মুতাওয়াসিসতা',
    category: 'ফযীলত',
    totalStudents: '৩০০',
    paymentStatus: 'unpaid',
    applicationStatus: 'approved',
    image: '/path-to-image.jpg',
    fatherName: 'আব্দুল করিম',
    birthDate: '1995-05-15'
  }
])

const handleSearch = () => {
  // Implement search logic
}

const resetSearch = () => {
  search.value = ''
  searchMobile.value = ''
}
</script>

<template>
<AuthenticatedLayout>
    <div class=" mx-auto p-4 mt-5">

<div style="font-family: 'Merriweather','SolaimanLipi',sans-serif;"
     class="mb-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total Students Card -->
    <div class="bg-gradient-to-br from-green-50 to-white rounded-md p-6 border border-green-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-green-600 text-sm font-semibold">মোট</span>
                </div>
                <p class="text-green-900 font-medium">মোট নিবন্ধিত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-green-100 p-3 rounded-xl">
                <!-- Mosque Icon -->
                <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4v6m-4 4h16M4 14l8-8 8 8M4 20h16"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Board Return Students Card -->
    <div class="bg-gradient-to-br from-teal-50 to-white rounded-md p-6 border border-teal-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-teal-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-teal-900 font-medium">বোর্ড ফেরত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-teal-100 p-3 rounded-xl">
                <!-- Prayer Beads Icon -->
                <svg class="w-8 h-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c.5-1.7 3.5-1.7 4 0 .5 1.7-3.5 1.7-4 0zm0 18c-.5 1.7-3.5 1.7-4 0-.5-1.7 3.5-1.7 4 0zm7-9c1.7-.5 1.7-3.5 0-4-1.7-.5-1.7 3.5 0 4zM5 12c-1.7.5-1.7-3.5 0-4 1.7-.5 1.7 3.5 0 4z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Female Students Card -->
    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-md p-6 border border-emerald-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-emerald-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-emerald-900 font-medium">ছাত্রী সংখ্যা</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-xl">
                <!-- Quran Icon -->
                <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Year Total Card -->
    <div class="bg-gradient-to-br from-green-50 to-white rounded-md p-6 border border-green-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-green-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-green-900 font-medium">{{ selectedYear }} সালের মোট</p>
            </div>
            <div class="bg-green-100 p-3 rounded-xl">
                <!-- Minaret Icon -->
                <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>
</div>















    <!-- Search Card -->
<div class="bg-white rounded-md shadow-lg mb-6">
  <div class="bg-[#1a4731] p-3 rounded-t-md"> <!-- Changed to a deep green color -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
      <h3 class="text-[#f4b942] font-bold text-lg flex items-center">
        <i class="fas fa-moon-and-star mr-2"></i> <!-- Islamic crescent moon icon -->
        সার্চ উইযার্ড
      </h3>
      <h3 class="text-white text-lg text-center flex items-center justify-center">
        <i class="fas fa-mosque mr-2"></i> <!-- Mosque icon -->
        ৪৮তম কেন্দ্রীয় পরীক্ষা: নেগরান মুমতাহিন
      </h3>
    </div>
  </div>

  <div class="p-6 bg-[#f8f9fa]"> <!-- Light background for content -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
      <select class="w-full px-4 py-2 border-2 border-emerald-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
        <option value=""><i class="fas fa-book-quran"></i> মারহালা সিলেক্ট করুন</option>
        <option value="mutawassita">মুতাওয়াসসিতা</option>
        <option value="sanabia">সানাবিয়া</option>
        <option value="fazilat">ফযীলত</option>
      </select>

      <select class="w-full px-4 py-2 border-2 border-emerald-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
        <option value=""><i class="fas fa-user-check"></i> অবস্থা সিলেক্ট করুন</option>
        <option value="active">সক্রিয়</option>
        <option value="inactive">নিষ্ক্রিয়</option>
      </select>

      <select class="w-full px-4 py-2  border-2 border-emerald-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
        <option value=""><i class="fas fa-file-alt"></i> আবেদনের ধরন</option>
        <option value="regular">নিয়মিত</option>
        <option value="irregular">অনিয়মিত</option>
      </select>

      <input
        type="text"
        v-model="search"
        placeholder="রোল নম্বর সার্চ করুন..."
        class="w-full px-4 py-2 border-2 border-emerald-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500"
      >
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
      <input
        type="text"
        v-model="searchMobile"
        placeholder="রেজিস্ট্রেশন নম্বর সার্চ করুন..."
        class="w-full px-4 py-2 border-2 border-emerald-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500"
      >

      <div class="flex gap-3">
        <button
          @click="handleSearch"
          class="px-4 py-2 bg-[#1a4731] text-white rounded-md hover:bg-[#143524] flex items-center"
        >
          <i class="fas fa-search mr-2"></i>
          সার্চ করুন
        </button>
        <button
          @click="resetSearch"
          class="px-4 py-2 bg-[#8b0000] text-white rounded-md hover:bg-[#6d0000] flex items-center"
        >
          <i class="fas fa-undo mr-2"></i>
          রিসেট
        </button>
      </div>
    </div>
  </div>
</div>


    <!-- Data Table -->
   <div class="bg-white rounded-md shadow-lg">
  <div class="bg-[#1a4731] p-3 rounded-t-md"> <!-- Islamic green theme -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
      <h3 class="text-[#f4b942] font-bold text-lg flex items-center">
        <i class="fas fa-users-class mr-2"></i> <!-- Students icon -->
        নিবন্ধিত ছাত্র তালিকা
      </h3>
      <h3 class="text-[#f4b942] text-lg text-center flex items-center justify-center">
        <i class="fas fa-star-and-crescent mr-2"></i> <!-- Islamic symbol -->
        ৪৮তম কেন্দ্রীয় পরীক্ষা: মুতাওয়াসসিতা
      </h3>

      <div class="flex justify-end gap-3">
        <button class="inline-flex items-center px-4 py-2 bg-[#1a4731] text-white rounded-md shadow-md hover:bg-[#143524] transition-all duration-300">
          <i class="fas fa-file-pdf mr-2"></i>
          PDF ডাউনলোড
        </button>

        <button class="inline-flex items-center px-4 py-2 bg-[#1a4731] text-white rounded-md shadow-md hover:bg-[#143524] transition-all duration-300">
          <i class="fas fa-file-excel mr-2"></i>
          এক্সেল ডাউনলোড
        </button>
      </div>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-[#f8f9fa]">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-[#1a4731] uppercase tracking-wider">
            <i class="fas fa-list-ol mr-1"></i> ক্রমিক নং
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-[#1a4731] uppercase tracking-wider">
            <i class="fas fa-image mr-1"></i> ছবি
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-[#1a4731] uppercase tracking-wider">
            <i class="fas fa-user mr-1"></i> পিতার নাম
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-[#1a4731] uppercase tracking-wider">
            <i class="fas fa-mosque mr-1"></i> মাদরাসার নাম
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-[#1a4731] uppercase tracking-wider">
            <i class="fas fa-calendar-alt mr-1"></i> জন্ম-তারিখ
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-[#1a4731] uppercase tracking-wider">
            <i class="fas fa-file-alt mr-1"></i> আবেদনের ধরন
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-[#1a4731] uppercase tracking-wider">
            <i class="fas fa-money-check-alt mr-1"></i> পেমেন্ট স্ট্যাটাস
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-[#1a4731] uppercase tracking-wider">
            <i class="fas fa-check-circle mr-1"></i> আবেদন অবস্থা
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-[#1a4731] uppercase tracking-wider">
            <i class="fas fa-cog mr-1"></i> করনীয়
          </th>
        </tr>
      </thead>

      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="student in students" :key="student.id">
          <!-- Table data cells remain the same -->
           <td></td>
             <td></td>
               <td></td>
                 <td></td>
                   <td></td>
                     <td></td>
                       <td></td>
                         <td></td>

          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex gap-2">
              <button class="p-1 bg-[#1a4731] bg-opacity-10 text-[#1a4731] rounded hover:bg-opacity-20">
                <i class="fas fa-paper-plane"></i>
              </button>
              <button class="p-1 bg-[#f4b942] bg-opacity-10 text-[#f4b942] rounded hover:bg-opacity-20">
                <i class="fas fa-download"></i>
              </button>
              <button class="p-1 bg-red-100 text-red-600 rounded hover:bg-opacity-20">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

  </div>
</AuthenticatedLayout>
</template>
