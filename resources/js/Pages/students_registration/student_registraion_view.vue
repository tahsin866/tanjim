<template>
    <AuthenticatedLayout>
        <div class=" flex flex-col  p-4 md:p-6 ">
    <!-- Main Card -->
    <div class="bg-white shadow-xl rounded-lg overflow-hidden  border border-emerald-200">
      <!-- Header with Islamic Pattern -->
      <div class="bg-emerald-700 text-white p-6 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pattern-islamic"></div>
        <div class="relative z-10">
          <div class="flex justify-center">
            <img src="/logo-befaq.png" alt="বেফাক লোগো" class="h-16 mb-2" />
          </div>
          <h1 class="text-3xl font-bold text-center mb-2 ">
            দাওরায়ে হাদীস পরীক্ষার নিবন্ধন
          </h1>
          <p class="text-center text-emerald-100 text-lg">১৪৪৬ হিজরী</p>
          <div class="flex justify-center mt-3">
            <div class="h-1 w-24 bg-emerald-300 rounded"></div>
          </div>
        </div>
      </div>

      <!-- Content -->
      <div class="p-6">
        <!-- Registration Info -->
        <div class="bg-emerald-50 p-3 rounded-md text-sm text-emerald-800 mb-6 flex justify-between items-center">
          <div>
            <span class="font-semibold">রেজিস্ট্রেশন ফর্মের ক্রমিক নং:</span> ৫
          </div>
          <div>
            <span class="font-semibold">রেফারেন্স নম্বর:</span> ০০২০৮৩৫৭৪
          </div>
          <div>
            <span class="font-semibold">নিবন্ধন নং:</span> ৪৬০২০৩৩০৫৭
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Left Column - Photo and Application Type -->
          <div class="md:col-span-1">
            <!-- Photo Section -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm mb-6">
              <div class="aspect-[3/4] bg-gray-100 rounded-md flex flex-col items-center justify-center border border-dashed border-gray-300 mb-2">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg> -->
                  <img
    v-if="student.student_image"
    :src="'/storage/' + student.student_image"
    alt="Student"
    class="w-200 h-200 rounded-sm mx-auto object-cover"
  />
                <p class="text-gray-500 text-sm mt-2">কোনো ছবি নেই</p>
              </div>
              <p class="text-xs text-center text-gray-500 italic">* ছাত্রীদের ক্ষেত্রে ছবি প্রযোজ্য নয়</p>
            </div>

            <!-- Application Type Section -->
            <div class="bg-emerald-50 p-4 rounded-lg border-r-4 border-emerald-600 mb-6">
              <h2 class="text-lg font-bold text-emerald-800 mb-3 flex items-center">
                <span class="inline-block w-7 h-7 bg-emerald-700 text-white rounded-full mr-2 flex items-center justify-center text-xs">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </span>
                আবেদনের ধরন
              </h2>
              <div class="space-y-2">
                <div>
                  <span class="text-emerald-700 font-semibold block">পরীক্ষার নাম:</span>
                  <span class="text-gray-700">দাওরায়ে হাদীস</span>
                </div>
                <div>
                  <span class="text-emerald-700 font-semibold block">পরীক্ষার্থীর ধরন:</span>
                  <span class="text-gray-700">নিয়মিত</span>
                </div>
                <div>
                  <span class="text-emerald-700 font-semibold block">পরীক্ষার সন:</span>
                  <span class="text-gray-700">১৪৪৬ হিজরী</span>
                </div>
              </div>
            </div>

            <!-- Board Info -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
              <h2 class="text-lg font-bold text-emerald-800 mb-3 flex items-center">
                <span class="inline-block w-7 h-7 bg-emerald-700 text-white rounded-full mr-2 flex items-center justify-center text-xs">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </span>
                বোর্ড তথ্য
              </h2>
              <div class="space-y-2">
                <div>
                  <span class="text-emerald-700 font-semibold block">নিবন্ধনের বোর্ড:</span>
                  <span class="text-gray-700">বেফাকুল মাদারিসিল আরাবিয়া বাংলাদেশ</span>
                </div>
                <div>
                  <span class="text-emerald-700 font-semibold block">অন্তর্ভুক্তিকরন মাদরাসা:</span>
                  <span class="text-gray-700">৪০১৪২ - বেগম লুৎফুন্নেছা মহিলা মাদরাসা, মনুয়া, ভেদরগঞ্জ, শরীয়তপুর</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column - Previous Exam and Personal Info -->
          <div class="md:col-span-2">
            <!-- Previous Exam Info Section -->
            <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm mb-6">
              <h2 class="text-xl font-bold text-emerald-800 mb-4 flex items-center">
                <span class="inline-block w-8 h-8 bg-emerald-700 text-white rounded-full mr-2 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </span>
                বিগত পরীক্ষার তথ্য
              </h2>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4">
                <div class="flex items-start">
      <span class="text-emerald-700 font-semibold w-32">পরীক্ষার নাম:</span>
  <span class="text-gray-700">{{ student.exam_name_Bn }}</span>
    </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">পরীক্ষার্থী নাম:</span>
                  <span class="text-gray-700">{{ student.name_bn }}</span>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">লিঙ্গ:</span>
                  <span class="text-gray-700">ছাত্রী</span>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">পিতার নাম:</span>
                  <span class="text-gray-700">{{ student.father_name_bn }}</span>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">রোল নং:</span>
                  <span class="text-gray-700">{{ student.past_Roll}}</span>
                </div>
                 <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">রেজিস্ট্রেসন নং:</span>
                  <span class="text-gray-700">{{ student.past_reg_id}}</span>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">পাশের সন:</span>
                  <span class="text-gray-700">{{ student.passing_year}}</span>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">প্রাপ্ত বিভাগ:</span>
                  <span class="text-gray-700">{{ student.division}}</span>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">মাদরাসা:</span>
                  <span class="text-gray-700">{{ student.madrasha_name}}</span>
                </div>
                 <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">মারকায:</span>
                  <span class="text-gray-700">{{ student.madrasha_name}}</span>
                </div>
                <div class="flex items-start col-span-2">
                  <span class="text-emerald-700 font-semibold w-32">বোর্ড:</span>
                  <span class="text-gray-700">বেফাকুল মাদারিসিল আরাবিয়া বাংলাদেশ</span>
                </div>
              </div>
            </div>

            <!-- Personal Info Section -->
            <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
              <h2 class="text-xl font-bold text-emerald-800 mb-4 flex items-center">
                <span class=" w-8 h-8 bg-emerald-700 text-white rounded-full mr-2 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </span>
                আবেদনকারীর তথ্য
              </h2>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4">
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">নাম:</span>
                  <div>
                    <span class="text-gray-700 block">{{ student.name_bn}}</span>
                    <span class="text-gray-500 text-xs">{{ student.name_en}}</span>
                    <span class="text-gray-500 text-xs block ">{{ student.name_ar}}</span>
                  </div>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">পিতার নাম:</span>
                  <div>
                    <span class="text-gray-700 block">{{ student.father_name_bn}}</span>
                    <span class="text-gray-700 block">{{ student.father_name_en}}</span>
                    <span class="text-gray-500 text-xs">{{ student.father_name_ar}}</span>

                  </div>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">মাতার নাম:</span>
                  <div>
                    <span class="text-gray-700 block">{{ student.mother_name_bn}}</span>
                    <span class="text-gray-500 text-xs">{{ student.mother_name_en}}</span>
                    <span class="text-gray-500 text-xs block ">{{ student.mother_name_ar}}</span>
                  </div>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">জন্ম তারিখ:</span>
                  <span class="text-gray-700">{{ student.Date_of_birth}}</span>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">জাতীয়তা:</span>
                  <div>
                    <span class="text-gray-700 block">বাংলাদেশী</span>
                    <span class="text-gray-500 text-xs">Bangladeshi</span>
                    <span class="text-gray-500 text-xs block font-[Noto_Naskh_Arabic]">بنغلاديشي</span>
                  </div>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">পরিচয়পত্র:</span>
                  <div>
                    <span class="text-gray-700 block">জন্মসনদ</span>
                    <span class="text-gray-700 block text-sm">{{ student.NID_no}}</span>
                    <button
                      @click="showIdModal = true"
                      class="mt-1 text-xs text-emerald-600 hover:text-emerald-800 flex items-center"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                      পরিচয়পত্রের স্ক্যান কপি দেখুন
                    </button>
                  </div>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">ফোন নম্বর:</span>
                  <span class="text-gray-700">01766839308</span>
                </div>
                <div class="flex items-start">
                  <span class="text-emerald-700 font-semibold w-32">ইমেইল এড্রেস:</span>
                  <span class="text-gray-500 italic">প্রদান করা হয়নি</span>
                </div>
                <div class="flex items-start col-span-2">
                  <span class="text-emerald-700 font-semibold w-32">স্থায়ী ঠিকানা:</span>
                  <span class="text-gray-700">হাজী মোহাম্মদ খোরশেদ আকন কান্দি, পালেরচর হাট, জাজিরা, শরীয়তপুর</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer with Verification -->
        <div class="mt-8 flex flex-col md:flex-row justify-between items-center">
          <div class="text-gray-500 text-sm mb-4 md:mb-0">
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              <span>যাচাইকৃত তথ্য</span>
            </div>
            <p class="mt-1">রেজিস্ট্রেশন আইডি: DAWRAH-1446-2586</p>
          </div>
          <div class="flex space-x-3">
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
              ডাউনলোড
            </button>
            <button class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700 transition flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              প্রিন্ট করুন
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Islamic Quote -->
    <div class="mt-6 text-center text-emerald-800 max-w-2xl">
      <p class="italic">"যে ব্যক্তি জ্ঞান অর্জনের জন্য পথ চলে, আল্লাহ তার জন্য জান্নাতের পথ সহজ করে দেন।"</p>
      <p class="text-sm mt-1">- সহীহ মুসলিম</p>
    </div>

    <!-- ID Document Modal -->
    <div v-if="showIdModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-emerald-700 text-white px-4 py-3 flex justify-between items-center">
          <h3 class="font-bold">পরিচয়পত্রের বিবরণ</h3>
          <button @click="showIdModal = false" class="text-white hover:text-emerald-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(90vh-4rem)]">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- ID Document Image -->
            <div class="bg-gray-100 rounded-lg p-2 flex items-center justify-center">
              <img src="/sample-birth-certificate.jpg" alt="জন্মসনদ" class="max-w-full h-auto rounded border border-gray-300" />
            </div>

            <!-- ID Document Details -->
            <div>
              <h4 class="text-lg font-bold text-emerald-800 mb-4">জন্মসনদ বিবরণ</h4>

              <div class="space-y-3">
                <div>
                  <span class="text-emerald-700 font-semibold block">নাম:</span>
                  <span class="text-gray-700">শিখা আক্তার</span>
                </div>
                <div>
                  <span class="text-emerald-700 font-semibold block">পিতার নাম:</span>
                  <span class="text-gray-700">হাবিবুর রহমান খান</span>
                </div>
                <div>
                  <span class="text-emerald-700 font-semibold block">মাতার নাম:</span>
                  <span class="text-gray-700">হাসিদা বেগম</span>
                </div>
                <div>
                  <span class="text-emerald-700 font-semibold block">জন্ম তারিখ:</span>
                  <span class="text-gray-700">২০ অক্টোবর ২০০৬</span>
                </div>
                <div>
                  <span class="text-emerald-700 font-semibold block">জন্মসনদ নম্বর:</span>
                  <span class="text-gray-700">২০০৬৮৬১৯৪৭৩১০১৩৯৪</span>
                </div>
                <div>
                  <span class="text-emerald-700 font-semibold block">নিবন্ধন নম্বর:</span>
                  <span class="text-gray-700">৪৬০২০৩৩০৫৭</span>
                </div>
                <div>
                  <span class="text-emerald-700 font-semibold block">ইস্যু তারিখ:</span>
                  <span class="text-gray-700">১২ জানুয়ারি ২০১০</span>
                </div>
              </div>

              <div class="mt-6 flex justify-end">
                <button @click="showIdModal = false" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                  বন্ধ করুন
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';


const props = defineProps({
  student: Object
});
// State for modal
const showIdModal = ref(false);
  // No additional script needed for this view component
  </script>

  <style>
  /* Islamic pattern background - you would need to include this or use a background image */
  .pattern-islamic {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }

  /* Add font imports for Amiri and Noto Naskh Arabic if needed */
  @import url('https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Noto+Naskh+Arabic:wght@400;500;600;700&display=swap');
  </style>
