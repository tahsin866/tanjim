<template>
    <div class="bg-white rounded-t-lg shadow-md p-6  mx-auto">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">মারকাজ প্রাপ্তির শর্তাবলী ও নিয়মাবলী</h2>

      <div class="space-y-4 mb-8 text-gray-700">
        <!-- Terms List -->
        <div class="bg-gray-50 p-4 rounded-lg">
          <ol class="list-decimal list-inside space-y-3">
            <li>মারকায আবেদনের জন্য বেফাকের কেন্দ্রীয় পরীক্ষায় কমপক্ষে ৩ বছর অংশগ্রহণ করতে হবে।</li>
            <li>বেফাক হতে প্রকাশিত পাঠ্যবই পড়াতে হবে এবং বেফাক কর্তৃক নির্ধারিত বার্ষিক চাঁদা ও ফি পরিশোধ থাকতে হবে।</li>
            <li>বেফাক হতে প্রকাশিত পাঠ্যবই পড়াতে হবে এবং বেফাক কর্তৃক নির্ধারিত বার্ষিক চাঁদা ও ফি পরিশোধ থাকতে হবে।</li>
            <!-- Add all other terms here -->
          </ol>
        </div>

        <!-- Fee Information -->
        <div class="bg-blue-50 p-4 rounded-lg">
          <p class="font-semibold">মারকাজ মঞ্জুরির ফি: ৯,০০০/- টাকা (এককালীন)</p>
        </div>

        <!-- Agreement Section -->
        <div class="bg-gray-50 p-4 rounded-lg">
          <div class="flex items-start gap-3">
            <input
              type="checkbox"
              v-model="isAgreed"
              id="agreement"
              class="mt-1.5 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
            >
            <label for="agreement" class="text-gray-700">
              আমি অঙ্গীকার করছি যে, উপরোক্ত কোনো শর্ত পূরণ না হলে এবং আবেদন ফরমে কোনো অসম্পূর্ণ বা ভুল তথ্য প্রদান করলে; কিংবা নিবন্ধন ও অন্তর্ভুক্তি পরীক্ষার্থী প্রকৃত সংখ্যার চেয়ে বেশি দেখিয়ে থাকলে এবং মারকায-বিধি পালনে কোনোরূপ অসঙ্গতি পরিলক্ষিত হলে, বেফাক কর্তৃপক্ষের যে কোনো ফয়সালা মানতে বাধ্য থাকব।
            </label>
          </div>
        </div>
      </div>

      <!-- Next Button -->
      <div class="flex justify-end">
  <Link
    :href="route('Markaz.markaz_agreement_form')"
    :disabled="!isAgreed"
    :class="[
      'px-4 py-2 rounded-md font-semibold transition-all duration-200 flex items-center gap-2',
      isAgreed
        ? 'bg-blue-600 text-white hover:bg-blue-700'
        : 'bg-gray-300 text-gray-500 cursor-not-allowed'
    ]"
  >
    <span>পরবর্তী ধাপ</span>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>
  </Link>
</div>

    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'

  const isAgreed = ref(false)

  const handleNext = () => {
    if (isAgreed.value) {
      // Navigate to next step or emit event
      console.log('Proceeding to next step')
    }
  }
  </script>

  <style scoped>
  .list-decimal li {
    margin-bottom: 1rem;
  }
  </style>
