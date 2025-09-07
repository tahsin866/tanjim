<template>
  <div class="min-h-screen relative font-['Merriweather','SolaimanLipi',sans-serif]">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
      <img 
        src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&w=1920&q=80" 
        alt="Madinah Background" 
        class="h-full w-full object-cover"
      />
      <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-slate-800/85 to-indigo-900/90"></div>
    </div>

    <!-- Navbar - redesigned with glass effect -->
    <nav class="fixed top-0 left-0 right-0 z-50 px-4 py-3 relative">
      <div class="max-w-7xl mx-auto">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl px-4 py-3 flex items-center justify-between shadow-lg border border-white/10">
          <!-- Logo -->
          <div class="flex items-center space-x-3">
            <img src="/images/tanjim.png" alt="Logo" class="h-14 w-14 rounded-xl object-cover shadow-lg border border-white/30" />
            <div class="hidden md:block">
              <h2 class="text-white font-bold text-xl tracking-tight">আবনায়ে ফরিদাবাদ</h2>
            </div>
          </div>
          
          <!-- Main Menu -->
          <div class="hidden lg:flex items-center">
            <div class="bg-white/5 backdrop-blur-md rounded-full px-1.5 py-1.5 flex items-center">
              <a href="#" class="px-4 py-1.5 text-sm font-medium text-white hover:bg-indigo-500 rounded-full transition-all duration-300 font-bangla">হোম</a>
              <a href="#" class="px-4 py-1.5 text-sm font-medium text-white hover:bg-indigo-500 rounded-full transition-all duration-300 font-bangla">আমাদের সম্পর্কে</a>
              <a href="#" class="px-4 py-1.5 text-sm font-medium text-white hover:bg-indigo-500 rounded-full transition-all duration-300 font-bangla">কার্যক্রমসমূহ</a>
              <a href="#" class="px-4 py-1.5 text-sm font-medium text-white hover:bg-indigo-500 rounded-full transition-all duration-300 font-bangla">ডিজিটাল লাইব্রেরী</a>
              <a href="#" class="px-4 py-1.5 text-sm font-medium text-white hover:bg-indigo-500 rounded-full transition-all duration-300 font-bangla">বয়ান</a>
              <a href="#" class="px-4 py-1.5 text-sm font-medium text-white hover:bg-indigo-500 rounded-full transition-all duration-300 font-bangla">মাসিক নেয়ামত</a>
              <a href="#" class="px-4 py-1.5 text-sm font-medium text-white hover:bg-indigo-500 rounded-full transition-all duration-300 font-bangla">জামিয়ার ওয়েবসাইট</a>
            </div>
          </div>

          <!-- Hamburger (Mobile) -->
          <button class="lg:hidden p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all" @click="mobileMenu = true">
            <i class="pi pi-bars text-white"></i>
          </button>
        </div>
      </div>
    </nav>

    <!-- Mobile Menu Sidebar -->
    <Sidebar v-model:visible="mobileMenu" position="right" class="mobile-menu">
      <div class="p-5 bg-gradient-to-b from-slate-800 to-slate-900 h-full">
        <div class="flex items-center space-x-3 mb-8">
          <img src="/images/tanjim.png" alt="Logo" class="h-14 w-14 rounded-xl object-cover shadow-lg border border-white/30" />
          <h2 class="text-white font-bold text-xl tracking-tight">তানজিমে আবনা</h2>
        </div>
        <div class="flex flex-col space-y-2">
          <a href="#" class="py-3 px-4 text-white bg-white/5 hover:bg-indigo-600 rounded-xl transition-all duration-200 font-bangla">হোম</a>
          <a href="#" class="py-3 px-4 text-white bg-white/5 hover:bg-indigo-600 rounded-xl transition-all duration-200 font-bangla">আমাদের সম্পর্কে</a>
          <a href="#" class="py-3 px-4 text-white bg-white/5 hover:bg-indigo-600 rounded-xl transition-all duration-200 font-bangla">কার্যক্রমসমূহ</a>
          <a href="#" class="py-3 px-4 text-white bg-white/5 hover:bg-indigo-600 rounded-xl transition-all duration-200 font-bangla">ডিজিটাল লাইব্রেরী</a>
          <a href="#" class="py-3 px-4 text-white bg-white/5 hover:bg-indigo-600 rounded-xl transition-all duration-200 font-bangla">বয়ান</a>
          <a href="#" class="py-3 px-4 text-white bg-white/5 hover:bg-indigo-600 rounded-xl transition-all duration-200 font-bangla">মাসিক নেয়ামত</a>
          <a href="#" class="py-3 px-4 text-white bg-white/5 hover:bg-indigo-600 rounded-xl transition-all duration-200 font-bangla">জামিয়ার ওয়েবসাইট</a>
        </div>
      </div>
    </Sidebar>

    <!-- Content Grid with Side by Side Layout -->
    <div class="pt-24 pb-12 relative z-10">
      <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Side: Hero Content -->
        <div class="flex flex-col justify-center lg:pr-8 py-8 order-2 lg:order-1">
          <div class="inline-block mb-4 bg-indigo-900/30 px-4 py-2 rounded-full">
            <p class="text-indigo-400 font-bangla font-medium">তানযীমে আবনায়ে জামিয়া ফরিদাবাদ</p>
          </div>
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white font-bangla leading-tight mb-6">
            তানযীমে আবনায়ে<br/>
            <span class="bg-gradient-to-r from-indigo-400 mr-2 to-purple-400 bg-clip-text text-transparent">জামিয়া ফরিদাবাদ</span>
          </h1>
          <p class="text-lg text-gray-300 font-bangla mb-8 max-w-lg">
            জামিয়া আরাবিয়া ইমদাদুল উলূম ফরিদাবাদ এর প্রাক্তন ছাত্রদের জন্য একটি প্ল্যাটফর্ম।
          </p>
          
          <div class="flex flex-col sm:flex-row items-center gap-4 mb-8">
            <button class="w-full sm:w-auto bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bangla font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-lg shadow-indigo-600/30 flex items-center justify-center">
              <i class="pi pi-info-circle mr-2"></i>
              তানযীম পরিচিতি
            </button>
            <button class="w-full sm:w-auto bg-white/10 hover:bg-white/15 border border-white/20 text-white font-bangla font-bold px-8 py-4 rounded-xl transition-all duration-300 flex items-center justify-center">
              <i class="pi pi-list mr-2"></i>
              কার্যক্রমসমূহ
            </button>
          </div>

          <!-- Stats -->
          <div class="grid grid-cols-3 gap-4 mt-4">
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10">
              <p class="text-3xl font-bold text-indigo-400">১,২০০+</p>
              <p class="text-sm text-gray-400 font-bangla">নিবন্ধিত আবনা</p>
            </div>
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10">
              <p class="text-3xl font-bold text-indigo-400">৫০+</p>
              <p class="text-sm text-gray-400 font-bangla">দস্তারে ফযিলত গ্রহণকারী</p>
            </div>
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10">
              <p class="text-3xl font-bold text-indigo-400">৭০+</p>
              <p class="text-sm text-gray-400 font-bangla">বর্ষ/ব্যাচ</p>
            </div>
          </div>
        </div>

        <!-- Right Side: Authentication Card -->
        <div class="order-1 lg:order-2 flex items-center">
          <div class="w-full bg-white/10 backdrop-blur-md border border-white/20 rounded-md shadow-2xl overflow-hidden">
            <!-- Authentication Buttons -->
            <div class="p-6 flex flex-col items-center justify-center space-y-6">
              <!-- Beautiful buttons instead of tabs -->
              <div class="flex flex-col sm:flex-row w-full gap-4">
                <button 
                  @click="switchTab('login')" 
                  class="flex-1 py-4 px-6 rounded-md font-bold font-bangla transition-all duration-300 flex items-center justify-center shadow-lg"
                  :class="activeTab === 'login' 
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-indigo-600/30' 
                    : 'bg-white/20 text-white hover:bg-white/30 border border-white/30'"
                >
                  <i class="pi pi-sign-in mr-2"></i> লগইন
                </button>
                <button 
                  @click="switchTab('register')" 
                  class="flex-1 py-4 px-6 rounded-md font-bold font-bangla transition-all duration-300 flex items-center justify-center shadow-lg"
                  :class="activeTab === 'register' 
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-indigo-600/30' 
                    : 'bg-white/20 text-white hover:bg-white/30 border border-white/30'"
                >
                  <i class="pi pi-user-plus mr-2"></i> রেজিস্ট্রেশন
                </button>
              </div>

              <!-- Form Content -->
              <transition name="fade-slide" mode="out-in">
                <div :key="activeTab" class="w-full">
                  <!-- Login Content -->
                  <div v-if="activeTab === 'login'" class="space-y-6">
                    <div class="text-center">
                      <h3 class="text-2xl font-bold text-white font-bangla mb-2">আবনা লগইন</h3>
                      <p class="text-gray-300 font-bangla">আপনার অ্যাকাউন্টে প্রবেশ করুন</p>
                    </div>

                    <!-- Status Message -->
                    <div v-if="status" class="p-4 bg-green-900/40 rounded-xl border-l-4 border-green-500 text-green-200 mb-4">
                      <div class="flex items-center">
                        <i class="pi pi-check-circle mr-2"></i>
                        <span class="font-bangla">{{ status }}</span>
                      </div>
                    </div>

                    <!-- Status Message -->
                    <div v-if="form.errors.suspended" class="p-4 bg-red-900/40 rounded-xl border-l-4 border-red-500 text-red-200">
                      <div class="flex items-center mb-2">
                        <i class="pi pi-exclamation-circle mr-2"></i>
                        <span class="font-bold font-bangla">অ্যাকাউন্ট সাসপেন্ড</span>
                      </div>
                      <p class="text-sm font-bangla">{{ form.errors.suspended }}</p>
                    </div>

                    <!-- General Login Error -->
                    <div v-if="form.errors.email || form.errors.phoneNumber" class="p-4 bg-red-900/40 rounded-xl border-l-4 border-red-500 text-red-200">
                      <div class="flex items-center">
                        <i class="pi pi-exclamation-circle mr-2"></i>
                        <span class="font-bangla">লগইনে সমস্যা হয়েছে</span>
                      </div>
                    </div>

                    <form @submit.prevent="submitLogin" class="space-y-5">
                      <!-- Mobile Number Field -->
                      <div>
                        <label class="block text-sm font-medium text-white font-bangla mb-2">মোবাইল নম্বর</label>
                        <div class="relative">
                          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="pi pi-phone text-indigo-300"></i>
                          </div>
                          <input
                            type="text"
                            v-model="form.phoneNumber"
                            class="pl-11 w-full px-4 py-3.5 bg-white/10 border border-white/20 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-bangla text-white placeholder-gray-400"
                            :class="{ 'opacity-50 cursor-not-allowed': isSuspendedAccount }"
                            placeholder="০১XXXXXXXXX"
                            required
                            :disabled="isSuspendedAccount"
                          />
                        </div>
                        <p v-if="form.errors.phoneNumber" class="mt-2 text-sm text-red-400">{{ form.errors.phoneNumber }}</p>
                      </div>

                      <!-- Password Field -->
                      <div>
                        <label class="block text-sm font-medium text-white font-bangla mb-2">পাসওয়ার্ড</label>
                        <div class="relative">
                          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="pi pi-lock text-indigo-300"></i>
                          </div>
                          <input
                            :type="showPassword ? 'text' : 'password'"
                            v-model="form.password"
                            class="pl-11 pr-11 w-full px-4 py-3.5 bg-white/10 border border-white/20 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-bangla text-white placeholder-gray-400"
                            :class="{ 'opacity-50 cursor-not-allowed': isSuspendedAccount }"
                            placeholder="আপনার পাসওয়ার্ড লিখুন"
                            required
                            :disabled="isSuspendedAccount"
                          />
                          <button
                            type="button"
                            @click="togglePassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-300 hover:text-indigo-300 focus:outline-none"
                          >
                            <i :class="showPassword ? 'pi pi-eye-slash' : 'pi pi-eye'"></i>
                          </button>
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-sm text-red-400">{{ form.errors.password }}</p>
                      </div>

                      <div class="flex items-center justify-between">
                        <label class="flex items-center" :class="{ 'opacity-50 cursor-not-allowed': isSuspendedAccount }">
                          <input
                            type="checkbox"
                            v-model="form.remember"
                            class="rounded bg-white/10 border-white/30 text-indigo-600 focus:ring-indigo-500"
                            :disabled="isSuspendedAccount"
                          >
                          <span class="ml-2 text-sm text-gray-300 font-bangla">মনে রাখুন</span>
                        </label>
                        <a 
                          v-if="!isSuspendedAccount" 
                          :href="route('password.request')" 
                          class="text-sm text-indigo-300 hover:text-indigo-200 font-bangla"
                        >
                          পাসওয়ার্ড ভুলে গেছেন?
                        </a>
                      </div>

                      <button
                        type="submit"
                        class="w-full flex justify-center items-center py-3.5 px-6 rounded-md shadow text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 font-bangla font-bold"
                        :class="{
                          'opacity-75 cursor-not-allowed': form.processing || isSuspendedAccount,
                          'from-red-500 to-red-600 hover:from-red-600 hover:to-red-700': isSuspendedAccount
                        }"
                        :disabled="form.processing || isSuspendedAccount"
                      >
                        <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l-3-2.647z"></path>
                        </svg>
                        <span class="font-bangla">
                          {{ isSuspendedAccount ? 'অ্যাকাউন্ট সাসপেন্ড' : 'প্রবেশ করুন' }}
                        </span>
                      </button>
                    </form>
                  </div>

                  <!-- Registration Content -->
                  <div v-if="activeTab === 'register'" class="space-y-6">
                    <div class="text-center">
                      <h3 class="text-2xl font-bold text-white font-bangla mb-2">আবনা রেজিস্ট্রেশন</h3>
                      <p class="text-gray-300 font-bangla">আবনা হওয়ার জন্য নিম্নলিখিত শর্তাবলী পূরণ করতে হবে</p>
                    </div>

                    <div class="bg-white/10 rounded-xl p-6 border border-white/20">
                      <h4 class="text-lg font-bold text-white font-bangla mb-4 flex items-center">
                        <i class="pi pi-check-circle text-indigo-300 mr-2"></i>
                        রেজিস্ট্রেশনের শর্তাবলী
                      </h4>
                      <div class="space-y-3">
                        <div class="flex items-start">
                          <i class="pi pi-arrow-right text-indigo-300 mt-1 mr-3 text-sm"></i>
                          <p class="text-gray-200 font-bangla">আহলে সুন্নাত ওয়াল জামাতের আকিদা ও মানহাজের অনুসারী হতে হবে</p>
                        </div>
                        <div class="flex items-start">
                          <i class="pi pi-arrow-right text-indigo-300 mt-1 mr-3 text-sm"></i>
                          <p class="text-gray-200 font-bangla">জামিয়া আরাবিয়া ইমদাদুল উলূম ফরিদাবাদ এর প্রাক্তন ছাত্র হতে হবে</p>
                        </div>
                        <div class="flex items-start">
                          <i class="pi pi-arrow-right text-indigo-300 mt-1 mr-3 text-sm"></i>
                          <p class="text-gray-200 font-bangla">জামিয়া থেকে বহিষ্কৃত বা শাস্তিপ্রাপ্ত ছাত্র হতে পারবেন না</p>
                        </div>
                        <div class="flex items-start">
                          <i class="pi pi-arrow-right text-indigo-300 mt-1 mr-3 text-sm"></i>
                          <p class="text-gray-200 font-bangla">কুরআন ও সুন্নাহ বিরোধী কোনো কার্যকলাপে জড়িত থাকা যাবে না</p>
                        </div>
                        <div class="flex items-start">
                          <i class="pi pi-arrow-right text-indigo-300 mt-1 mr-3 text-sm"></i>
                          <p class="text-gray-200 font-bangla">ইসলামী আদব-আখলাক ও শিষ্টাচার মেনে চলতে হবে</p>
                        </div>
                        <div class="flex items-start">
                          <i class="pi pi-arrow-right text-indigo-300 mt-1 mr-3 text-sm"></i>
                          <p class="text-gray-200 font-bangla">তানজিমের নিয়ম-কানুন ও সিদ্ধান্ত মেনে চলতে হবে</p>
                        </div>
                      </div>
                    </div>

                    <div class="bg-white/5 border border-white/20 rounded-xl p-4">
                      <label class="flex items-start">
                        <input
                          type="checkbox"
                          v-model="agreedToTerms"
                          class="mt-1 rounded bg-white/10 border-white/30 text-indigo-600 focus:ring-indigo-500"
                        >
                        <span class="ml-3 text-sm text-gray-200 font-bangla">
                          আমি উপরোক্ত সকল শর্তাবলী পড়েছি, বুঝেছি এবং সম্পূর্ণভাবে মেনে চলতে সম্মত আছি। আমি সত্যায়ন করছি যে, আমি উল্লেখিত সকল যোগ্যতা পূরণ করি এবং কোনো বিধিনিষেধের আওতায় পড়ি না।
                        </span>
                      </label>
                    </div>

                    <div class="text-center">
                      <button
                        :disabled="!agreedToTerms"
                        :class="[
                          'px-8 py-4 rounded-md font-bold font-bangla text-lg transition-all duration-300 shadow w-full',
                          agreedToTerms
                            ? 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-lg shadow-indigo-600/30'
                            : 'bg-white/10 text-gray-400 cursor-not-allowed border border-white/10'
                        ]"
                        @click="goToRegistration"
                      >
                        <i class="pi pi-user-plus mr-2"></i>
                        রেজিস্ট্রেশন শুরু করুন
                      </button>
                      <p class="text-xs text-gray-400 font-bangla mt-3">
                        শর্তাবলী মেনে নিয়ে এগিয়ে যান
                      </p>
                    </div>
                  </div>
                </div>
              </transition>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Decorative elements -->
    <div class="absolute top-40 left-10 w-72 h-72 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
    <div class="absolute top-80 right-10 w-72 h-72 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Sidebar from 'primevue/sidebar'

// Define props for status messages (like in auth/Login.vue)
const props = defineProps({
    canResetPassword: {
        type: Boolean,
        default: true
    },
    status: String,
});

const mobileMenu = ref(false)
const scrolled = ref(false)
const activeTab = ref('login')
const agreedToTerms = ref(false)
const showPassword = ref(false)

// Login form using Inertia (same as auth/Login.vue)
const form = useForm({
    phoneNumber: '',
    password: '',
    remember: false,
});

const isSuspendedAccount = computed(() => !!form.errors.suspended);

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

const submitLogin = () => {
    // Clear any previous errors
    form.clearErrors();
    
    // Validate phone number format (basic validation)
    if (!form.phoneNumber) {
        form.setError('phoneNumber', 'মোবাইল নম্বর প্রয়োজন');
        return;
    }
    
    // Basic phone number validation for Bangladesh
    const phoneRegex = /^(01[3-9]\d{8})$/;
    if (!phoneRegex.test(form.phoneNumber.replace(/\s+/g, ''))) {
        form.setError('phoneNumber', 'সঠিক মোবাইল নম্বর লিখুন (যেমন: 01712345678)');
        return;
    }
    
    if (!form.password) {
        form.setError('password', 'পাসওয়ার্ড প্রয়োজন');
        return;
    }
    
    // Submit the form
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
        onError: (errors) => {
            // Handle specific error cases
            if (errors.suspended) {
                // Account is suspended - form will show the error automatically
                console.log('Account suspended:', errors.suspended);
            } else if (errors.phoneNumber || errors.email) {
                // Login failed - credentials don't match
                console.log('Login failed');
            }
        },
        onSuccess: () => {
            // Redirect will be handled by Laravel automatically
            console.log('Login successful');
        }
    });
};

const handleScroll = () => {
  scrolled.value = window.scrollY > 12
}

const goToRegistration = () => {
  if (agreedToTerms.value) {
    window.location.href = route('register')
  }
}

const switchTab = (tab) => {
  activeTab.value = tab
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.font-bangla {
  font-family: 'SolaimanLipi', 'Noto Sans Bengali', 'Hind Siliguri', sans-serif;
}

/* Sidebar customization */
:deep(.mobile-menu) .p-sidebar {
  background: transparent;
  box-shadow: none;
}

/* Smooth tab transitions */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

/* Blob animation */
@keyframes blob {
  0% {
    transform: scale(1) translate(0px, 0px);
  }
  33% {
    transform: scale(1.1) translate(20px, -30px);
  }
  66% {
    transform: scale(0.9) translate(-20px, 30px);
  }
  100% {
    transform: scale(1) translate(0px, 0px);
  }
}

.animate-blob {
  animation: blob 7s infinite;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}
</style>