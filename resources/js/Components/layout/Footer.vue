<template>
  <footer class="bg-gray-900 text-gray-300 py-16 transition-colors duration-300 font-[SolaimanLipi,sans-serif] relative">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-gray-700 pb-12 mb-8">

        <!-- Organization Info -->
        <div class="flex flex-col items-center md:items-start text-center md:text-left">
          <a href="#" class="flex items-center mb-4">
            <span class="text-2xl font-extrabold text-teal-400">তানযীমে আবনায়ে জামিয়া ফরিদাবাদ
</span>
          </a>
          <p class="text-sm leading-relaxed max-w-xs">
            জামিয়া আরাবিয়া ইমদাদুল উলুম ফরিদাবাদের প্রাক্তন ছাত্রদের সমন্বয়ে গঠিত দ্বীনী প্লাটফর্ম 

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

        <!-- Quick Links -->
        <div class="text-center md:text-left">
          <h4 class="text-lg font-bold mb-4 text-white">দ্রুত লিঙ্ক</h4>
          <ul class="space-y-3 text-sm">
            <li><a href="#" class="hover:text-teal-400 transition-colors duration-300">আমাদের সম্পর্কে</a></li>
            <li><a href="#" class="hover:text-teal-400 transition-colors duration-300">নোটিশ</a></li>
            <li><a href="#" class="hover:text-teal-400 transition-colors duration-300">চ্যারিটি</a></li>
            <li><a href="#" class="hover:text-teal-400 transition-colors duration-300">ছবি গ্যালারি</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div class="text-center md:text-left">
          <h4 class="text-lg font-bold mb-4 text-white">যোগাযোগ</h4>
          <div class="space-y-3 text-sm">
            <p class="flex items-center justify-center md:justify-start gap-2">
              <i class="pi pi-phone text-teal-400"></i>
              <a href="tel:01533386866" class="hover:text-teal-400 transition-colors">8801901518628‬, ‪+8801901518629‬, ‪+8801577191616‬
</a>
            </p>
            <p class="flex items-center justify-center md:justify-start gap-2">
              <i class="pi pi-envelope text-teal-400"></i>
              <a href="mailto:info@abna@gmail.com" class="hover:text-teal-400 transition-colors">info@abna@gmail.com</a>
            </p>
            <p class="flex items-center justify-center md:justify-start gap-2">
              <i class="pi pi-map-marker text-teal-400"></i>
           জামিয়া আরাবিয়া ইমদাদুল উলুম, ১১/১২ ফরিদাবাদ, গেন্ডারিয়া, ঢাকা-১২০৪

            </p>
          </div>
        </div>

        <!-- Newsletter -->
        <div class="text-center md:text-left">
          <h4 class="text-lg font-bold mb-4 text-white">নিউজলেটার</h4>
          <p class="text-sm mb-4">আমাদের সর্বশেষ আপডেট পেতে আপনার ইমেইল দিয়ে সাবস্ক্রাইব করুন।</p>
          <div class="flex flex-col sm:flex-row gap-2">
            <InputText type="email" placeholder="আপনার ইমেইল" class="flex-1 rounded-full px-4 py-2 border-none bg-gray-800 text-white focus:ring-2 focus:ring-teal-400" />
            <Button label="সাবস্ক্রাইব" class="rounded-full px-6 py-2 bg-teal-600 text-white font-semibold hover:bg-teal-700 transition-colors" />
          </div>
        </div>
      </div>

      <!-- Payment Banner and Policy Section -->
      <div class="flex flex-col items-center justify-center my-10">
        <div class="w-full md:w-3/4 bg-gradient-to-r from-teal-500 via-teal-400 to-teal-600 text-white rounded-xl shadow-lg p-6 flex flex-col md:flex-row items-center gap-6">
          <img src="https://cdn-icons-png.flaticon.com/512/929/929426.png" alt="Payment" class="w-16 h-16 mb-4 md:mb-0" />
          <div class="flex-1 text-center md:text-left">
            <h3 class="text-xl font-bold mb-2">রেজিস্ট্রেশন ফি এবং পেমেন্ট নীতিমালা</h3>
            <p class="text-sm mb-2">
              মনে রাখবেন, এই ওয়েবসাইটটি কোনো ব্যবসায়িক প্ল্যাটফর্ম নয়। শুধুমাত্র রেজিস্ট্রেশনের তথ্য হালনাগাদ এবং দস্তরবন্দির জন্য রেজিস্ট্রেশন ফি নির্ধারিত হয়েছে।
              এখানে কোনো ধরণের <span class="font-bold text-yellow-200">রিফান্ড পলিসি</span> নেই। অনুগ্রহ করে নিশ্চিত হয়ে পেমেন্ট সম্পন্ন করুন।
            </p>
            <div class="mt-4 flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
              <!-- <Button label="রেজিস্ট্রেশন ফি পেমেন্ট করুন" class="rounded-full px-6 py-2 bg-yellow-400 text-teal-900 font-bold hover:bg-yellow-500 transition-colors" /> -->
              <span class="text-xs text-white font-semibold py-2 px-4 rounded-full bg-teal-700">নির্ধারিত ফি: ২০০০ টাকা</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Copyright & Credits -->
      <div class="flex flex-col md:flex-row justify-between items-center text-sm">
        <div class="text-left mb-4 md:mb-0 w-full md:w-auto">
          <p class="mb-1">
            ডিজাইন ও কারিগরি সহায়তায়:
            <span class="text-teal-400 font-bold"> তাহসিন আব্দুল্লাহ এবং আব্দুর রহমান আলজামী</span>
          </p>
          <div>
            &copy; {{ new Date().getFullYear() }} আবনায়ে জামিয়া ফরিদাবাদ। ২০১৯ সালের শিক্ষার্থীবৃন্দ।
          </div>
        </div>
        <!-- If you want to keep the right side empty or add something, you can do so here -->
      </div>
  </div>
  <!-- Footer right bottom image -->
  <img src="/images/ssl.png" alt="Footer Decorative" class="hidden md:block absolute right-6 bottom-6 w-70 h-auto opacity-90 z-10" />
    <!-- Policy Links -->
    <div class="mt-8 flex flex-col md:flex-row justify-center items-center gap-4 text-sm">
      <a href="/privacy" class="text-gray-400 hover:text-teal-400 transition-colors">প্রাইভেসি পলিসি</a>
      <span class="hidden md:inline">|</span>
      <a href="/terms" class="text-gray-400 hover:text-teal-400 transition-colors">টার্মস এন্ড কন্ডিশন</a>
      <span class="hidden md:inline">|</span>
      <a href="/return-policy" class="text-gray-400 hover:text-teal-400 transition-colors">রিটার্ন পলিসি</a>
    </div>
  </footer>
</template>

<script setup>
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
</script>

<style scoped>
/* Footer right bottom image style for mobile */
.footer-image-mobile {
  position: absolute;
  right: 12px;
  bottom: 12px;
  width: 100px;
  opacity: 0.8;
  z-index: 10;
}
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;700&display=swap');

.font-bangla {
  font-family: 'Noto Sans Bengali', sans-serif !important;
}

/* Payment banner styling for a modern look */
.bg-gradient-to-r {
  background: linear-gradient(90deg, #14b8a6 0%, #2dd4bf 50%, #0891b2 100%);
}
</style>