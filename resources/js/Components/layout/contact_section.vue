<template>
    <section
         style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
    class="py-16 bg-gradient-to-r from-emerald-50 to-emerald-100">
      <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- Result Search Panel -->
        <div class="bg-white p-8 rounded-md shadow-md hover:shadow-lg transition-shadow duration-300 flex items-center border-r-4 border-emerald-600">
          <div class="w-16 h-16 mr-6 flex-shrink-0">
            <svg class="w-full h-full text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19.5 3h-15A1.5 1.5 0 003 4.5v15A1.5 1.5 0 004.5 21h15a1.5 1.5 0 001.5-1.5v-15A1.5 1.5 0 0019.5 3zm-7 15.75a.75.75 0 110-1.5.75.75 0 010 1.5zm1-4.5v1.5h-2v-1.5a3 3 0 113-3h-1.5a1.5 1.5 0 10-1.5 1.5v1.5z"/>
            </svg>
          </div>
          <div>
            <h3 class="text-2xl font-bold text-emerald-800 mb-2">ফলাফল অনুসন্ধান</h3>
            <p class="text-gray-600 mb-4">৪৭ তম কেন্দ্রীয় পরীক্ষার সকল মারহালার ফলাফল দেখুন</p>
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-md transition-colors duration-300 font-medium">
              ফলাফল দেখুন
              <span class="inline-block ml-2">→</span>
            </button>
          </div>
        </div>

        <!-- Student Portal Panel -->
        <div class="bg-white p-8 rounded-md shadow-md hover:shadow-lg transition-shadow duration-300 flex items-center border-r-4 border-emerald-600">
          <div class="w-16 h-16 mr-6 flex-shrink-0">
            <svg class="w-full h-full text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 14l9-5-9-5-9 5 9 5z"/>
              <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
          </div>
          <div>
            <h3 class="text-2xl font-bold text-emerald-800 mb-2">তালিবুল ইলম পোর্টাল</h3>
            <p class="text-gray-600 mb-4">শিক্ষার্থীর প্রোফাইল ব্যবস্থাপনা ও সনদ প্রাপ্তির আবেদন</p>
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-md transition-colors duration-300 font-medium">
              প্রবেশ করুন
              <span class="inline-block ml-2">→</span>
            </button>
          </div>
        </div>

      </div>
    </section>
  </template>
