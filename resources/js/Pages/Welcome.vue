<template>
    <div>
      <!-- Notice Popup Modal -->
      <div v-if="showNoticeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div 
        
        style="font-family: 'SolaimanLipi', sans-serif;"
        class="bg-white rounded-lg p-8 max-w-md mx-4 shadow-2xl">
          <div class="text-center">
            <div class="mb-4">
              <svg class="mx-auto h-12 w-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">গুরুত্বপূর্ণ বিজ্ঞপ্তি</h3>
            <p class="text-gray-700 text-sm mb-6 leading-relaxed">
              পরীক্ষামূলকভাবে আবনায়ে জামিয়া আরাবিয়া ফরিদাবাদের তথ্য হালনাগাদ করা হচ্ছে। 
              এটি চূড়ান্ত নিবন্ধন নয়। পরীক্ষামূলকভাবে তথ্য হালনাগাদ শেষ হলে চূড়ান্তভাবে নিবন্ধনের জন্য ঘোষণা দেওয়া হবে।
            </p>
            <button 
              @click="closeNoticeModal" 
              class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200"
            >
              বুঝেছি
            </button>
          </div>
        </div>
      </div>

      <!-- Navbar -->
      <Navbar />

      <!-- Features Section -->
      <featureSection />

      <!-- Contact Section -->
      <contact_section />

      <!-- FAQ and Video Section -->
      <FAQVideoSection />

      <!-- Footer -->
      <Footer />
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import Navbar from '@/Components/layout/Navbar.vue';
  import featureSection from '@/Components/layout/featureSection.vue';
  import contact_section from '@/Components/layout/contact_section.vue';
  import FAQVideoSection from '@/Components/layout/FAQVideoSection.vue';
  import Footer from '@/Components/layout/Footer.vue';

  // Notice modal state
  const showNoticeModal = ref(false);

  // Show modal when component mounts
  onMounted(() => {
    showNoticeModal.value = true;
  });

  // Close modal function
  const closeNoticeModal = () => {
    showNoticeModal.value = false;
  };
  </script>
