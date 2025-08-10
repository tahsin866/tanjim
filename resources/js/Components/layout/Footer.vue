<template>
  <footer class="bg-gray-900 text-gray-300 py-16 transition-colors duration-300 font-[SolaimanLipi,sans-serif]">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-gray-700 pb-12 mb-8">

        <div class="flex flex-col items-center md:items-start text-center md:text-left">
          <a href="#" class="flex items-center mb-4">
            <span class="text-2xl font-extrabold text-teal-400">আবনায়ে জামিয়া আরাবিয়া ইমদাদুল উলুম ফরিদাবাদ</span>
          </a>
          <p class="text-sm leading-relaxed max-w-xs">
            আবনায়ে জামিয়া আরাবিয়া ইমদাদুল উলুম ফরিদাবাদ-এর প্রাক্তন ছাত্রদের জন্য একটি প্ল্যাটফর্ম।
          </p>
          <div class="mt-6 flex gap-4">
            <a href="#" aria-label="Facebook" class="text-gray-400 hover:text-teal-400 transition-colors duration-300">
              <i class="pi pi-facebook text-xl"></i>
            </a>
            <a href="#" aria-label="Twitter" class="text-gray-400 hover:text-teal-400 transition-colors duration-300">
              <i class="pi pi-twitter text-xl"></i>
            </a>
            <a href="#" aria-label="Instagram" class="text-gray-400 hover:text-teal-400 transition-colors duration-300">
              <i class="pi pi-instagram text-xl"></i>
            </a>
            <a href="#" aria-label="YouTube" class="text-gray-400 hover:text-teal-400 transition-colors duration-300">
              <i class="pi pi-youtube text-xl"></i>
            </a>
          </div>
        </div>

        <div class="text-center md:text-left">
          <h4 class="text-lg font-bold mb-4 text-white">দ্রুত লিঙ্ক</h4>
          <ul class="space-y-3 text-sm">
            <li><a href="#" class="hover:text-teal-400 transition-colors duration-300">আমাদের সম্পর্কে</a></li>
            <li><a href="#" class="hover:text-teal-400 transition-colors duration-300">নোটিশ</a></li>
            <li><a href="#" class="hover:text-teal-400 transition-colors duration-300">চ্যারিটি</a></li>
            <li><a href="#" class="hover:text-teal-400 transition-colors duration-300">ছবি গ্যালারি</a></li>
          </ul>
        </div>

        <div class="text-center md:text-left">
          <h4 class="text-lg font-bold mb-4 text-white">যোগাযোগ</h4>
          <div class="space-y-3 text-sm">
            <p class="flex items-center justify-center md:justify-start gap-2">
              <i class="pi pi-phone text-teal-400"></i>
              <a href="tel:01533386866" class="hover:text-teal-400 transition-colors">#</a>
            </p>
            <p class="flex items-center justify-center md:justify-start gap-2">
              <i class="pi pi-envelope text-teal-400"></i>
              <a href="mailto:info@abna@gmail.com" class="hover:text-teal-400 transition-colors">info@abna@gmail.com</a>
            </p>
            <p class="flex items-center justify-center md:justify-start gap-2">
              <i class="pi pi-map-marker text-teal-400"></i>
         গেন্ডারিয়া ঢাকা
            </p>
          </div>
        </div>

        <div class="text-center md:text-left">
          <h4 class="text-lg font-bold mb-4 text-white">নিউজলেটার</h4>
          <p class="text-sm mb-4">আমাদের সর্বশেষ আপডেট পেতে আপনার ইমেইল দিয়ে সাবস্ক্রাইব করুন।</p>
          <div class="flex flex-col sm:flex-row gap-2">
            <InputText type="email" placeholder="আপনার ইমেইল" class="flex-1 rounded-full px-4 py-2 border-none bg-gray-800 text-white focus:ring-2 focus:ring-teal-400" />
            <Button label="সাবস্ক্রাইব" class="rounded-full px-6 py-2 bg-teal-600 text-white font-semibold hover:bg-teal-700 transition-colors" />
          </div>
        </div>
      </div>

      <div class="flex flex-col md:flex-row justify-between items-center text-sm">
        <div class="text-center md:text-left mb-4 md:mb-0">
          &copy; {{ new Date().getFullYear() }} আবনায়ে জামিয়া ফরিদাবাদ। ২০১৯ সালের শিক্ষার্থীবৃন্দ।
        </div>
        <div class="flex flex-wrap justify-center items-center gap-4 text-center md:text-right">
          <p>
            ডিজাইন ও ডেভেলপমেন্ট:
            <span class="text-teal-400 font-bold">তাহসিন আব্দুল্লাহ</span>
          </p>
          <span class="text-gray-500 hidden md:inline">|</span>
          <p>
            কারিগরি সহায়তায়:
            <span class="text-teal-400 font-bold">আব্দুর রহমান আলজামী</span>
          </p>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;700&display=swap');

.font-bangla {
  font-family: 'Noto Sans Bengali', sans-serif !important;
}
</style>
