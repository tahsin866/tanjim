<template>
  <!-- Navbar -->
  <nav
    class="relative mx-auto mt-10 mb-9 w-[90vw] max-w-[1250px] min-w-[320px] h-20 rounded-3xl shadow-lg border transition-all duration-300 ease-in-out flex items-center bg-white/80 backdrop-blur-xl border-emerald-700/20"
    :class="{ 'shadow-xl bg-white/90': scrolled }"
    style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
  >
    <div class="relative flex items-center w-full h-20 px-4 lg:px-12">
      <!-- Logo (left, overlaps navbar) -->
      <div class="absolute left-0 z-50 flex flex-col items-center -top-7 mx-5">
        <img
          src="/images/tanjim.png"
          alt="Logo"
          class="h-24 w-24 lg:h-32 lg:w-32 rounded-full object-cover shadow-2xl border-4 border-white ring-4 ring-emerald-400/30 transition-all duration-300"
        />

      </div>
      <div class="lg:ml-36 ml-28"></div>
      <!-- Main Menu -->
      <div class="hidden lg:flex items-center gap-3 flex-1 justify-center">
        <a href="#" class="px-3 py-2 text-base font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">হোম</a>
        <a href="#" class="px-3 py-2 text-base font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">আমাদের সম্পর্কে</a>
        <a href="#" class="px-3 py-2 text-base font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">কার্যক্রমসমূহ</a>
        <a href="#" class="px-3 py-2 text-base font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">ডিজিটাল লাইব্রেরী</a>
        <a href="#" class="px-3 py-2 text-base font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">বয়ান</a>
        <a href="#" class="px-3 py-2 text-base font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">মাসিক নেয়ামত</a>
        <a href="#" class="px-3 py-2 text-base font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">জামিয়ার ওয়েবসাইট</a>
      </div>
      <!-- Hamburger (Mobile) -->
      <button class="block lg:hidden p-2 ml-2" @click="mobileMenu = true">
        <i class="pi pi-bars text-2xl text-emerald-900"></i>
      </button>
    </div>
    <!-- Mobile Logo & Text -->
    <div class="lg:hidden absolute left-4 top-16 flex flex-col items-center z-20">
      <div class="text-center mt-1">
        <h3 class="text-xs font-bold text-emerald-900 font-bangla">তানযিমে আবনায়ে ফরিদাবাদ</h3>
        <p class="text-xs text-emerald-700 font-bangla">৭০ সালানা আবনায়ে তানজিম সম্মেলন</p>
      </div>
    </div>
    <!-- Mobile Menu Sidebar -->
    <Sidebar v-model:visible="mobileMenu" position="right">
      <div class="p-4 flex flex-col gap-2">
        <a href="#" class="py-2 text- font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">হোম</a>
        <a href="#" class="py-2 text-lg font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">আমাদের সম্পর্কে</a>
        <a href="#" class="py-2 text-lg font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">কার্যক্রমসমূহ</a>
        <a href="#" class="py-2 text-lg font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">গ্যালারি</a>
        <a href="#" class="py-2 text-lg font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">আমাদের সাথে যুক্ত হন</a>
        <a href="#" class="py-2 text-lg font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">ব্লগ</a>
        <a href="#" class="py-2 text-lg font-semibold text-emerald-900 hover:text-emerald-600 transition font-bangla">যোগাযোগ</a>
        <div class="flex gap-2 mt-4">
          <button class="bg-gray-100 hover:bg-emerald-100 text-emerald-900 font-semibold px-3 py-1 rounded transition">বাং</button>
          <button class="bg-gray-100 hover:bg-emerald-100 text-emerald-900 font-semibold px-3 py-1 rounded transition">EN</button>
          <button class="bg-yellow-400/80 hover:bg-yellow-500 text-emerald-900 font-bold px-4 py-2 rounded transition flex items-center gap-1">
            <i class="pi pi-user"></i>
          </button>
        </div>
        <button class="mt-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2 rounded transition shadow font-bangla">
          দান করুন
        </button>
      </div>
    </Sidebar>
  </nav>

  <!-- HERO SECTION -->
  <section
  style=" font-family: 'SolaimanLipi', sans-serif;
   "
  class="relative min-h-[820px] flex flex-col items-center justify-center bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 pt-10 pb-24 overflow-hidden">

    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
      <img
        src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&w=1920&q=80"
        alt="Madinah Background"
        class="w-full h-full object-cover opacity-30"
      />
      <!-- Gradient overlay to maintain text readability -->
      <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/70 via-emerald-800/60 to-teal-900/70"></div>
    </div>

    <div class="relative z-20 w-full">
      <div class="container mx-auto px-4 flex flex-col items-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white text-center font-bangla leading-tight drop-shadow-xl z-30 mb-2 mt-4">
          আবনায়ে জামিয়া আরাবিয়া ফরিদাবাদ
        </h1>
        <p class="text-lg text-white/90 mt-0 mb-6 max-w-2xl text-center font-bangla drop-shadow z-30">
          জামিয়া আরাবিয়া ইমদাদুল উলূম ফরিদাবাদ এর প্রাক্তন ছাত্রদের জন্য একটি প্ল্যাটফর্ম।
        </p>
        <div class="flex flex-col sm:flex-row items-center gap-4 mb-8 z-30">
          <button
            class="bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-bold font-bangla px-8 py-3 rounded transition shadow"
          >
            তানজিম পরিচিতি
          </button>
          <button
            class="bg-transparent border-2 border-white/80 hover:bg-white/10 text-white font-bangla text-lg px-8 py-3 rounded transition shadow"
          >
            কার্যক্রমসমূহ
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Registration/Login Card (60% Outside Hero Section) -->
  <div class="relative -mt-48 z-50" style="font-family: 'SolaimanLipi', sans-serif;">
    <div class="container mx-auto px-4 max-w-5xl">
      <div class="bg-white rounded-3xl shadow-2xl border border-emerald-200/50 overflow-hidden transition-all duration-300">
        <!-- Tabs -->
        <div class="relative bg-gradient-to-br from-emerald-50 via-white to-emerald-50 p-2">
          <div class="flex bg-gradient-to-r from-gray-100 to-gray-50 rounded-2xl p-1 relative overflow-hidden shadow-inner">
            <!-- Animated background slider -->
            <div
              class="absolute top-1 bottom-1 bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-800 rounded-xl shadow-lg transition-all duration-700 ease-[cubic-bezier(0.25,0.46,0.45,0.94)]"
              :class="activeTab === 'login' ? 'left-1 w-[calc(50%-4px)]' : 'left-[calc(50%+2px)] w-[calc(50%-4px)]'"
            ></div>
            <!-- Login Tab -->
            <button
              @click="switchTab('login')"
              :class="[
                'relative z-10 flex-1 py-4 px-6 font-bangla font-bold text-lg transition-all duration-500 rounded-xl group',
                activeTab === 'login'
                  ? 'text-white shadow-lg'
                  : 'text-emerald-700 hover:text-emerald-800'
              ]"
            >
              <span class="flex items-center justify-center space-x-3">
                <div class="relative">
                  <i
                    :class="[
                      'pi pi-sign-in text-xl transition-all duration-300',
                      activeTab === 'login' ? 'animate-pulse' : 'group-hover:scale-110'
                    ]"
                  ></i>
                  <div
                    v-if="activeTab === 'login'"
                    class="absolute -inset-1 bg-white/20 rounded-full "
                  ></div>
                </div>
                <span class="transition-all duration-300">লগইন</span>
              </span>
              <div
                v-if="activeTab === 'login'"
                class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full animate-bounce border-2 border-white shadow"
              ></div>
            </button>
            <!-- Registration Tab -->
            <button
              @click="switchTab('register')"
              :class="[
                'relative z-10 flex-1 py-4 px-6 font-bangla font-bold text-lg transition-all duration-500 rounded-xl group',
                activeTab === 'register'
                  ? 'text-white shadow-lg'
                  : 'text-emerald-700 hover:text-emerald-800'
              ]"
            >
              <span class="flex items-center justify-center space-x-3">
                <div class="relative">
                  <i
                    :class="[
                      'pi pi-user-plus text-xl transition-all duration-300',
                      activeTab === 'register' ? 'animate-pulse' : 'group-hover:scale-110'
                    ]"
                  ></i>
                  <div
                    v-if="activeTab === 'register'"
                    class="absolute -inset-1 bg-white/20 rounded-full"
                  ></div>
                </div>
                <span class="transition-all duration-300">রেজিস্ট্রেশন</span>
              </span>
              <div
                v-if="activeTab === 'register'"
                class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full animate-bounce border-2 border-white shadow"
              ></div>
            </button>
          </div>
          <!-- Tab status indicators -->
          <div class="flex justify-center mt-3 space-x-2">
            <div
              :class="[
                'w-2 h-2 rounded-full transition-all duration-300',
                activeTab === 'login' ? 'bg-emerald-600 scale-125' : 'bg-gray-300'
              ]"
            ></div>
            <div
              :class="[
                'w-2 h-2 rounded-full transition-all duration-300',
                activeTab === 'register' ? 'bg-emerald-600 scale-125' : 'bg-gray-300'
              ]"
            ></div>
          </div>
        </div>
        <!-- Tab Content, white background always -->
        <div class="p-8 bg-white">
          <div class="min-h-[500px] relative">
            <!-- Login Tab -->
            <transition name="fade" mode="out-in">
              <div v-if="activeTab === 'login'" key="login" class="space-y-6 absolute inset-0">
                <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-emerald-800 font-bangla mb-2">আবনা লগইন</h3>
                <p class="text-gray-600 font-bangla">আপনার অ্যাকাউন্টে প্রবেশ করুন</p>
              </div>

              <!-- Status Message -->
              <div v-if="form.errors.suspended" class="mb-6 p-4 bg-red-50 rounded-lg border-l-4 border-red-500 text-red-700">
                <div class="flex items-center mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                  </svg>
                  <span class="font-bold font-bangla">অ্যাকাউন্ট সাসপেন্ড</span>
                </div>
                <p class="text-sm font-bangla">{{ form.errors.suspended }}</p>
              </div>

              <!-- General Login Error -->
              <div v-if="form.errors.email || form.errors.phoneNumber" class="mb-6 p-4 bg-red-50 rounded-lg border-l-4 border-red-500 text-red-700">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                  </svg>
                  <span class="font-bangla">লগইনে সমস্যা হয়েছে</span>
                </div>
              </div>

              <form @submit.prevent="submitLogin" class="space-y-4">
                <!-- Mobile Number Field -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 font-bangla mb-2">মোবাইল নম্বর</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                      </svg>
                    </div>
                    <input
                      type="text"
                      v-model="form.phoneNumber"
                      class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-bangla"
                      :class="{ 'opacity-50 cursor-not-allowed': isSuspendedAccount }"
                      placeholder="০১XXXXXXXXX"
                      required
                      :disabled="isSuspendedAccount"
                    />
                  </div>
                  <p v-if="form.errors.phoneNumber" class="mt-2 text-sm text-red-600">{{ form.errors.phoneNumber }}</p>
                </div>

                <!-- Password Field -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 font-bangla mb-2">পাসওয়ার্ড</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                      </svg>
                    </div>
                    <input
                      :type="showPassword ? 'text' : 'password'"
                      v-model="form.password"
                      class="pl-10 pr-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-bangla"
                      :class="{ 'opacity-50 cursor-not-allowed': isSuspendedAccount }"
                      placeholder="আপনার পাসওয়ার্ড লিখুন"
                      required
                      :disabled="isSuspendedAccount"
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                      <button
                        type="button"
                        @click="togglePassword"
                        class="text-emerald-600 hover:text-emerald-800 focus:outline-none"
                      >
                        <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                          <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                          <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
                </div>

                <div class="flex items-center justify-between">
                  <label class="flex items-center" :class="{ 'opacity-50 cursor-not-allowed': isSuspendedAccount }">
                    <input
                      type="checkbox"
                      v-model="form.remember"
                      class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                      :disabled="isSuspendedAccount"
                    >
                    <span class="ml-2 text-sm text-gray-600 font-bangla">মনে রাখুন</span>
                  </label>
                  <a href="/password/reset" class="text-sm text-emerald-600 hover:text-emerald-800 font-bangla">পাসওয়ার্ড ভুলে গেছেন?</a>
                </div>

                <button
                  type="submit"
                  class="w-full flex justify-center items-center py-3 px-6 border border-transparent rounded-lg shadow text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 font-bangla font-bold"
                  :class="{
                    'opacity-75 cursor-not-allowed': form.processing || isSuspendedAccount,
                    'bg-red-500 hover:bg-red-600': isSuspendedAccount
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
          </transition>
          <!-- Registration Tab -->
          <transition name="fade" mode="out-in">
            <div v-if="activeTab === 'register'" key="register" class="space-y-6 absolute inset-0">
              <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-emerald-800 font-bangla mb-2">আবনা রেজিস্ট্রেশন</h3>
                <p class="text-gray-600 font-bangla">আবনা হওয়ার জন্য নিম্নলিখিত শর্তাবলী পূরণ করতে হবে</p>
              </div>
              <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-6 border-l-4 border-emerald-500">
                <h4 class="text-lg font-bold text-emerald-800 font-bangla mb-4 flex items-center">
                  <i class="pi pi-check-circle text-emerald-600 mr-2"></i>
                  রেজিস্ট্রেশনের শর্তাবলী
                </h4>
                <div class="space-y-3">
                  <div class="flex items-start">
                    <i class="pi pi-arrow-right text-emerald-600 mt-1 mr-3 text-sm"></i>
                    <p class="text-gray-700 font-bangla">আহলে সুন্নাত ওয়াল জামাতের আকিদা ও মানহাজের অনুসারী হতে হবে</p>
                  </div>
                  <div class="flex items-start">
                    <i class="pi pi-arrow-right text-emerald-600 mt-1 mr-3 text-sm"></i>
                    <p class="text-gray-700 font-bangla">জামিয়া আরাবিয়া ইমদাদুল উলূম ফরিদাবাদ এর প্রাক্তন ছাত্র হতে হবে</p>
                  </div>
                  <div class="flex items-start">
                    <i class="pi pi-arrow-right text-emerald-600 mt-1 mr-3 text-sm"></i>
                    <p class="text-gray-700 font-bangla">জামিয়া থেকে বহিষ্কৃত বা শাস্তিপ্রাপ্ত ছাত্র হতে পারবেন না</p>
                  </div>
                  <div class="flex items-start">
                    <i class="pi pi-arrow-right text-emerald-600 mt-1 mr-3 text-sm"></i>
                    <p class="text-gray-700 font-bangla">কুরআন ও সুন্নাহ বিরোধী কোনো কার্যকলাপে জড়িত থাকা যাবে না</p>
                  </div>
                  <div class="flex items-start">
                    <i class="pi pi-arrow-right text-emerald-600 mt-1 mr-3 text-sm"></i>
                    <p class="text-gray-700 font-bangla">ইসলামী আদব-আখলাক ও শিষ্টাচার মেনে চলতে হবে</p>
                  </div>
                  <div class="flex items-start">
                    <i class="pi pi-arrow-right text-emerald-600 mt-1 mr-3 text-sm"></i>
                    <p class="text-gray-700 font-bangla">তানজিমের নিয়ম-কানুন ও সিদ্ধান্ত মেনে চলতে হবে</p>
                  </div>
                </div>
              </div>
              <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <label class="flex items-start">
                  <input
                    type="checkbox"
                    v-model="agreedToTerms"
                    class="mt-1 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                  >
                  <span class="ml-3 text-sm text-gray-800 font-bangla">
                    আমি উপরোক্ত সকল শর্তাবলী পড়েছি, বুঝেছি এবং সম্পূর্ণভাবে মেনে চলতে সম্মত আছি। আমি সত্যায়ন করছি যে, আমি উল্লেখিত সকল যোগ্যতা পূরণ করি এবং কোনো বিধিনিষেধের আওতায় পড়ি না।
                  </span>
                </label>
              </div>
              <div class="text-center">
                <button
                  :disabled="!agreedToTerms"
                  :class="[
                    'px-8 py-4 rounded-lg font-bold font-bangla text-lg transition-all duration-300 shadow',
                    agreedToTerms
                      ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white'
                      : 'bg-gray-300 text-gray-500 cursor-not-allowed'
                  ]"
                  @click="goToRegistration"
                >
                  <i class="pi pi-user-plus mr-2"></i>
                  রেজিস্ট্রেশন শুরু করুন
                </button>
                <p class="text-xs text-gray-600 font-bangla mt-3">
                  শর্তাবলী মেনে নিয়ে এগিয়ে যান
                </p>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Sidebar from 'primevue/sidebar'

const mobileMenu = ref(false)
const scrolled = ref(false)
const activeTab = ref('login')
const agreedToTerms = ref(false)
const showPassword = ref(false)

// Login form using Inertia
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
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const handleScroll = () => {
  scrolled.value = window.scrollY > 12
}
const goToRegistration = () => {
  if (agreedToTerms.value) {
    window.location.href = '/register'
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

/* Smooth tab transition with fixed height */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.4s ease-in-out;
}

.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.fade-enter-to, .fade-leave-from {
  opacity: 1;
}
</style>
