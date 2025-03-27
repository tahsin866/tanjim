<template>
    <section
       style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"

    class="py-16 bg-gradient-to-r from-emerald-50 to-teal-50">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Statistics Card -->
          <div class="bg-white rounded-md shadow-xl p-8 transform hover:scale-[1.02] transition-transform duration-300">
            <div class="flex items-center mb-6">
              <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-800">পরিসংখ্যান</h3>
            </div>

            <div class="grid grid-cols-2 gap-6">
              <div v-for="stat in stats"
                   :key="stat.title"
                   class="bg-gradient-to-br from-emerald-50 to-teal-50 p-6 rounded-md border border-emerald-100 transform hover:translate-y-[-4px] transition-all duration-300">
                <h4 class="text-lg font-semibold text-gray-700 mb-2">{{ stat.title }}</h4>
                <p class="text-2xl font-bold text-emerald-600">{{ stat.value }}</p>
              </div>
            </div>
          </div>

          <!-- Madrasa Signup Card -->
          <div class="bg-white rounded-md shadow-xl p-8 flex flex-col justify-center transform hover:scale-[1.02] transition-transform duration-300">
            <div class="flex items-center mb-6">
              <div class="w-16 h-16 bg-emerald-100 rounded-md flex items-center justify-center mr-4">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-800">মাদরাসা সাইন-আপ</h3>
            </div>

            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
              মাদরাসার যাবতীয় অনলাইন কার্যক্রম সম্পাদনের জন্য একাউন্ট তৈরি করুন
            </p>

            <Link

:href="route('madrasha')"
            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-8 rounded-md transition-colors duration-300 flex items-center justify-center group">
              সাইন-আপ করুন
              <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </Link >
          </div>
        </div>
      </div>
    </section>
  </template>

  <script setup>
import { Link } from '@inertiajs/vue3';


  const stats = [
    { title: 'পরীক্ষার্থীর সংখ্যা', value: '৫৩,৫৪৩ জন' },
    { title: 'মারকায সংখ্যা', value: '৩,০০০' },
    { title: 'নেগরান সংখ্যা', value: '৫৩,৫৪৩ জন' },
    { title: 'মুমতাহিন সংখ্যা', value: '৫৩,৫৪৩ জন' },
  ];
  </script>
