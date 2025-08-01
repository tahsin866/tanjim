<template>
  <div>
    <!-- Custom Advanced Tabs (Login/Register) -->
    <div class="flex bg-gradient-to-r from-emerald-600 to-emerald-700 relative rounded-xl overflow-hidden mb-6">
      <button
        @click="tab = 'login'"
        :class="[
          'flex-1 py-4 px-6 font-bangla font-bold text-lg transition-all duration-300 relative z-10',
          tab === 'login'
            ? 'bg-white text-emerald-700 shadow-lg'
            : 'text-white hover:bg-emerald-800'
        ]"
      >
        <span class="flex items-center justify-center"><i class="pi pi-sign-in mr-2"></i> লগইন</span>
      </button>
      <button
        @click="tab = 'register'"
        :class="[
          'flex-1 py-4 px-6 font-bangla font-bold text-lg transition-all duration-300 relative z-10',
          tab === 'register'
            ? 'bg-white text-emerald-700 shadow-lg'
            : 'text-white hover:bg-emerald-800'
        ]"
      >
        <span class="flex items-center justify-center"><i class="pi pi-user-plus mr-2"></i> রেজিস্ট্রেশন</span>
      </button>
    </div>
    <transition name="fade" mode="out-in">
      <div v-if="tab === 'login'" key="login" class="space-y-6">
        <div class="text-center mb-6">
          <h3 class="text-2xl font-bold text-emerald-800 font-bangla mb-2">আবনা লগইন</h3>
          <p class="text-gray-600 font-bangla">আপনার অ্যাকাউন্টে প্রবেশ করুন</p>
        </div>
        <form class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 font-bangla mb-2">ইমেইল/ফোন</label>
            <input
              type="text"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-bangla"
              placeholder="আপনার ইমেইল বা ফোন নম্বর দিন"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 font-bangla mb-2">পাসওয়ার্ড</label>
            <input
              type="password"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-bangla"
              placeholder="পাসওয়ার্ড দিন"
            />
          </div>
          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input type="checkbox" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
              <span class="ml-2 text-sm text-gray-600 font-bangla">মনে রাখুন</span>
            </label>
            <a href="#" class="text-sm text-emerald-600 hover:text-emerald-800 font-bangla">পাসওয়ার্ড ভুলে গেছেন?</a>
          </div>
          <button
            type="submit"
            class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 font-bangla shadow-lg"
          >
            লগইন করুন
          </button>
        </form>
      </div>
      <div v-else key="register" class="space-y-6">
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
              'px-8 py-4 rounded-lg font-bold font-bangla text-lg transition-all duration-300 shadow-lg',
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
</template>

<script setup>
import { ref } from 'vue'
const tab = ref('login')
const agreedToTerms = ref(false)
const goToRegistration = () => {
  if (agreedToTerms.value) {
    window.location.href = '/register'
  }
}
</script>

<style scoped>
.font-bangla {
  font-family: 'SolaimanLipi', 'Noto Sans Bengali', 'Hind Siliguri', sans-serif;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.35s cubic-bezier(.4,0,.2,1);
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
