<template>
    <nav class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-emerald-950 fixed top-0 w-full z-50 shadow-lg"
         style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">

          <!-- Logo and Brand -->
          <div class="flex items-center">
            <div class="h-12 w-12 rounded-full bg-emerald-800 flex items-center justify-center mr-3">
              <img src="/public/images/find.png" alt="Logo" class="h-8 w-8"/>
            </div>
            <div class="flex flex-col">
              <!-- <span class="text-white ">بسم الله الرحمن الرحيم</span> -->
              <span class="text-emerald-400 text-xl font-bold">WEMS</span>
            </div>
          </div>

          <!-- Navigation Links -->
          <div class="hidden lg:flex items-center space-x-1">
            <a href="#" class="text-white text-lg hover:bg-emerald-800 px-4 py-2 rounded-md transition-colors duration-200 flex items-center">

              বেফাক ইয়ারপি
            </a>
            <a :href="route('login')" class="text-white text-lg hover:bg-emerald-800 px-4 py-2 rounded-md transition-colors duration-200 flex items-center">

              মাদরাসা পেনেল
            </a>
            <a href="#" class="text-white text-lg hover:bg-emerald-800 px-4 py-2 rounded-md transition-colors duration-200 flex items-center">

              শিক্ষক পেনেল
            </a>
            <a href="#" class="text-white text-lg hover:bg-emerald-800 px-4 py-2 rounded-md transition-colors duration-200 flex items-center">

              ছাত্র-ছাত্রী পেনেল
            </a>
            <a href="#" class="text-white text-lg hover:bg-emerald-800 px-4 py-2 rounded-md transition-colors duration-200 flex items-center">

              ওয়েব সাইট
            </a>

            <!-- Auth Links -->
            <div class="ml-4 flex items-center space-x-2">
              <template v-if="$page.props.auth.user">
                <Link :href="route('dashboard')"
                      class="bg-emerald-700 text-white hover:bg-emerald-600 px-6 py-2 rounded-sm transition-colors duration-200">
                  Dashboard
                </Link>
              </template>
              <template v-else>
                <Link :href="route('admin.login')"
                      class="bg-emerald-700 text-white hover:bg-emerald-600 px-6 py-2 rounded-sm transition-colors duration-200">
                  Login
                </Link>
                    <!-- <Link :href="route('madrasha')"
                        class="border-2 border-emerald-600 text-emerald-100 hover:bg-emerald-700 px-6 py-2 rounded-sm transition-colors duration-200">
                    Register
                    </Link> -->
              </template>
            </div>
          </div>

          <!-- Mobile Menu Button -->
          <div class="lg:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="text-white hover:text-emerald-400 focus:outline-none transition-colors duration-200">
              <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-show="mobileMenuOpen"
           class="lg:hidden bg-emerald-900 border-t border-emerald-800"
           v-motion
           :initial="{ opacity: 0, y: -20 }"
           :enter="{ opacity: 1, y: 0 }">
        <div class="px-4 py-3 space-y-2">
          <a href="#" class="text-white block px-4 py-2 rounded-md hover:bg-emerald-800 transition-colors duration-200">
            বেফাক ইয়ারপি
          </a>
          <a href="#" class="text-white block px-4 py-2 rounded-md hover:bg-emerald-800 transition-colors duration-200">
            মাদরাসা পেনেল
          </a>
          <a href="#" class="text-white block px-4 py-2 rounded-md hover:bg-emerald-800 transition-colors duration-200">
            শিক্ষক পেনেল
          </a>
          <a href="#" class="text-white block px-4 py-2 rounded-md hover:bg-emerald-800 transition-colors duration-200">
            ছাত্র-ছাত্রী পেনেল
          </a>
          <a href="#" class="text-white block px-4 py-2 rounded-md hover:bg-emerald-800 transition-colors duration-200">
            ওয়েব সাইট
          </a>
        </div>
      </div>
    </nav>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { Link } from '@inertiajs/vue3'

  const mobileMenuOpen = ref(false)
  </script>
