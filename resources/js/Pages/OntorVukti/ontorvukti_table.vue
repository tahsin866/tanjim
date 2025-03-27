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
    image: '/public/images/find.png',
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


      <div style="font-family: 'Merriweather','SolaimanLipi',sans-serif"
     class="mb-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total Students Card -->
    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-md p-6 border border-emerald-100 hover:shadow-lg transition-all duration-300 islamic-pattern">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-emerald-600 text-sm font-semibold">মোট</span>
                </div>
                <p class="text-emerald-900 font-medium">মোট নিবন্ধিত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-xl">
                <i class="fas fa-users-class text-2xl text-emerald-600"></i>
            </div>
        </div>
    </div>

    <!-- Board Return Students Card -->
    <div class="bg-gradient-to-br from-teal-50 to-white rounded-md p-6 border border-teal-100 hover:shadow-lg transition-all duration-300 islamic-pattern">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-teal-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-teal-900 font-medium">বোর্ড ফেরত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-teal-100 p-3 rounded-xl">
                <i class="fas fa-graduation-cap text-2xl text-teal-600"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-teal-100"></div>
    </div>

    <!-- Female Students Card -->
    <div class="bg-gradient-to-br from-amber-50 to-white rounded-md p-6 border border-amber-100 hover:shadow-lg transition-all duration-300 islamic-pattern">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-amber-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-amber-900 font-medium">ছাত্রী সংখ্যা</p>
            </div>
            <div class="bg-amber-100 p-3 rounded-xl">
                <i class="fas fa-female text-2xl text-amber-600"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-amber-100"></div>
    </div>

    <!-- Year Total Card -->
    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-md p-6 border border-emerald-100 hover:shadow-lg transition-all duration-300 islamic-pattern">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-emerald-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-emerald-900 font-medium">{{ selectedYear }} সালের মোট</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-xl">
                <i class="fas fa-mosque text-2xl text-emerald-600"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-emerald-100"></div>
    </div>
</div>














    <!-- Search Card -->
 <div class="bg-white rounded-sm shadow-lg mb-6">
  <!-- Header with Islamic pattern -->
  <div class="bg-emerald-900 p-3 rounded-t-sm islamic-pattern">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
      <h3 class="text-amber-400 font-bold text-lg">
        <i class="fas fa-search-plus ml-2"></i> সার্চ উইযার্ড
      </h3>

      <h3 class="text-white text-lg text-center">
         ৪৮তম কেন্দ্রীয় পরীক্ষা: নেগরান মুমতাহিন
      </h3>

      <div class="flex justify-end gap-3">
        <Link
          :href="route('students_registration.old_stu_reg_Form')"
          class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-sm transition-colors duration-200 flex items-center gap-2"
        >
          <i class="fas fa-user-plus"></i>
          <span>নিবন্ধন করুন</span>
        </Link>

        <button class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-sm">
          <i class="fas fa-file-import mr-2"></i>
          ইম্পোর্ট করুন
        </button>
      </div>
    </div>
  </div>

  <!-- Search Form Section -->
  <div class="p-6 bg-emerald-50">
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
      <div class="relative">

        <select class="w-full pl-10 pr-4 py-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
          <option value="">মারহালা সিলেক্ট করুন</option>
          <option value="mutawassita">মুতাওয়াসসিতা</option>
          <option value="sanabia">সানাবিয়া</option>
          <option value="fazilat">ফযীলত</option>
        </select>
      </div>

      <div class="relative">

        <select class="w-full pl-10 pr-4 py-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
          <option value="">অবস্থা সিলেক্ট করুন</option>
          <option value="active">সক্রিয়</option>
          <option value="inactive">নিষ্ক্রিয়</option>
        </select>
      </div>

      <div class="relative">

        <select class="w-full pl-10 pr-4 py-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
          <option value="">আবেদনের ধরন</option>
          <option value="regular">নিয়মিত</option>
          <option value="irregular">অনিয়মিত</option>
        </select>
      </div>

      <div class="relative">

        <select class="w-full pl-10 pr-4 py-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
          <option value="">পেমেন্ট অবস্থা</option>
          <option value="paid">পরিশোধিত</option>
          <option value="unpaid">অপরিশোধিত</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
      <div class="relative">

        <select class="w-full pl-10 pr-4 py-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
          <option value="">বোর্ড দাখিল অবস্থা</option>
          <option value="submitted">দাখিল করা হয়েছে</option>
          <option value="pending">দাখিল করা হয়নি</option>
        </select>
      </div>

      <div class="relative">

        <input
          type="text"
          v-model="search"
          placeholder="কোড সার্চ করুন..."
          class="w-full pl-10 pr-4 py-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
        >
      </div>

      <div class="relative">

        <input
          type="text"
          v-model="searchMobile"
          placeholder="মোবাইল নম্বর সার্চ করুন..."
          class="w-full pl-10 pr-4 py-2 border-2 border-emerald-200 rounded-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
        >
      </div>

      <div class="flex gap-3">
        <button
          @click="handleSearch"
          class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-sm flex items-center gap-2"
        >
          <i class="fas fa-search"></i>
          সার্চ করুন
        </button>
        <button
          @click="resetSearch"
          class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-sm flex items-center gap-2"
        >
          <i class="fas fa-undo"></i>
          রিসেট
        </button>
      </div>
    </div>
  </div>
</div>


    <!-- Data Table -->
   <div class="bg-white rounded-sm shadow-lg">
  <!-- Header with Islamic pattern -->
  <div class="bg-emerald-900 p-3 rounded-t-sm islamic-pattern">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
      <h3 class="text-amber-300 font-bold text-lg">
        <i class="fas fa-users-class ml-2"></i> মোট অন্তর্ভুক্তি ছাত্র সংখ্যা
      </h3>

      <h3 class="text-amber-300 text-lg text-center">
    ৪৮তম কেন্দ্রীয় পরীক্ষা: মুতাওয়াসসিতা
      </h3>

      <div class="flex justify-end gap-3">
        <button class="inline-flex items-center px-4 py-1 bg-amber-500 text-white rounded-sm hover:bg-amber-600">
          <i class="fas fa-file-pdf mr-2"></i>
          PDF ডাউনলোড
        </button>
        <button class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-sm hover:bg-emerald-700">
          <i class="fas fa-paper-plane mr-2"></i>
          বোর্ড দাখিল
        </button>
      </div>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-emerald-50">
        <tr>
          <th class="px-6 py-3 text-right text-sm font-medium text-emerald-800 uppercase">
           ক্রমিক নং
          </th>
          <th class="px-6 py-3 text-right text-sm font-medium text-emerald-800 uppercase">
           ছবি
          </th>
          <th class="px-6 py-3 text-right text-sm font-medium text-emerald-800 uppercase">
        পিতার নাম
          </th>
          <th class="px-6 py-3 text-right text-sm font-medium text-emerald-800 uppercase">
          মাদরাসার নাম
          </th>
          <th class="px-6 py-3 text-right text-sm font-medium text-emerald-800 uppercase">
            জন্ম-তারিখ
          </th>
          <th class="px-6 py-3 text-right text-sm font-medium text-emerald-800 uppercase">
         আবেদনের ধরন
          </th>
          <th class="px-6 py-3 text-right text-sm font-medium text-emerald-800 uppercase">
             পেমেন্ট স্ট্যাটাস
          </th>
          <th class="px-6 py-3 text-right text-sm font-medium text-emerald-800 uppercase">
           আবেদন অবস্থা
          </th>
          <th class="px-6 py-3 text-right text-sm font-medium text-emerald-800 uppercase">
            করনীয়
          </th>
        </tr>
      </thead>

      <tbody class="bg-white divide-y divide-emerald-100 ">
        <tr v-for="student in students" :key="student.id">
          <td class="px-6 py-4">{{ student.id }}</td>
          <td class="px-6 py-4">
            <img :src="student.image" class="h-10 w-10 rounded-full border-2 border-emerald-200" />
          </td>
          <td class="px-6 py-4">{{ student.fatherName }}</td>
          <td class="px-6 py-4">{{ student.institute }}</td>
          <td class="px-6 py-4">{{ student.birthDate }}</td>
          <td class="px-6 py-4">{{ student.level }}</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 text-xs rounded-full"
                  :class="student.paymentStatus === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'">
              <i :class="student.paymentStatus === 'paid' ? 'fas fa-check-circle' : 'fas fa-times-circle'"></i>
              {{ student.paymentStatus === 'paid' ? 'পেমেন্ট সম্পন্ন' : 'পেমেন্ট হয়নি' }}
            </span>
          </td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 text-xs bg-emerald-100 text-emerald-800 rounded-full">
              <i class="fas fa-check-circle mr-1"></i>
              আবেদন মন্জুর হয়েছে
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="flex gap-2">
              <button class="p-2 bg-emerald-100 text-emerald-600 rounded hover:bg-emerald-200">
                <i class="fas fa-paper-plane"></i>
              </button>
              <Link
  :href="route('students_registration.stu_reg_view')"
  class="p-2 bg-amber-100 text-amber-600 rounded hover:bg-amber-200 inline-flex items-center transition-colors duration-200"
>
  <i class="fas fa-pencil-alt"></i>
</Link>

              <button class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200">
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
