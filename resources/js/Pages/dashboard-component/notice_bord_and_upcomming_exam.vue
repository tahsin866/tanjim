<script setup>
import { ref, computed } from 'vue';

const upcomingExams = ref([
    {
        id: 1,
        subject: 'Advanced Mathematics',
        date: '2023-10-25',
        time: '09:00 AM',
        duration: '3 hours',
        students: 45,
        status: 'Upcoming'
    },
    // Add more exams...
]);
const showAll = ref(false);

const importantNotices = ref([
  {
    id: 1,
    status: 'new',
    date: '২০ জুলাই ২০২৩',
    title: 'বার্ষিক পরীক্ষার সময়সূচি ঘোষণা',
    summary: 'আগামী ১৫ আগস্ট থেকে শুরু হবে বার্ষিক পরীক্ষা। সকল ছাত্রদের প্রস্তুতি নেওয়ার জন্য অনুরোধ করা হলো।'
  },
  {
    id: 2,
    status: 'new',
    date: '১৮ জুলাই ২০২৩',
    title: 'ঈদুল আযহা ছুটির নোটিশ',
    summary: 'ঈদুল আযহা উপলক্ষে মাদরাসা ২০ জুলাই থেকে ২৫ জুলাই পর্যন্ত বন্ধ থাকবে।'
  },
  {
    id: 3,
    status: 'regular',
    date: '১৫ জুলাই ২০২৩',
    title: 'হিফজ বিভাগের নতুন ভর্তি শুরু',
    summary: 'হিফজ বিভাগে নতুন ছাত্র ভর্তির জন্য আবেদন গ্রহণ করা হবে। আগ্রহীরা অফিসে যোগাযোগ করুন।'
  },
  {
    id: 4,
    status: 'regular',
    date: '১২ জুলাই ২০২৩',
    title: 'মাসিক পরীক্ষার ফলাফল প্রকাশ',
    summary: 'জুন মাসের মাসিক পরীক্ষার ফলাফল প্রকাশ করা হয়েছে। ফলাফল জানতে অফিসে যোগাযোগ করুন।'
  },
  {
    id: 5,
    status: 'new',
    date: '১০ জুলাই ২০২৩',
    title: 'শীতকালীন ইউনিফর্ম বিতরণ',
    summary: 'আগামী সপ্তাহে শীতকালীন ইউনিফর্ম বিতরণ করা হবে। সকল ছাত্রদের উপস্থিত থাকার জন্য অনুরোধ করা হলো।'
  }
]);

const displayedNotices = computed(() => {
  return showAll.value ? importantNotices.value : importantNotices.value.slice(0, 2)
})

const toggleShowMore = () => {
  showAll.value = !showAll.value
}
</script>

<template>
  <!-- Upcoming Exams -->
  <div class="mb-8">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-100 dark:border-gray-800 p-6 mb-6">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
        <i class="pi pi-calendar text-blue-500"></i>
        সামনে আসা পরীক্ষা সমূহ
      </h3>
      <div v-if="upcomingExams.length">
        <ul>
          <li
            v-for="exam in upcomingExams"
            :key="exam.id"
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b last:border-0 border-gray-100 dark:border-gray-800 py-4"
          >
            <div>
              <div class="font-semibold text-gray-700 dark:text-gray-300">{{ exam.subject }}</div>
              <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ exam.date }} | {{ exam.time }} | {{ exam.duration }}
              </div>
            </div>
            <div class="mt-2 sm:mt-0 flex items-center gap-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                {{ exam.students }} জন ছাত্র
              </span>
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                {{ exam.status }}
              </span>
            </div>
          </li>
        </ul>
      </div>
      <div v-else class="text-gray-500 dark:text-gray-400">কোনো পরীক্ষা নেই</div>
    </div>
  </div>

  <!-- Important Notices -->
  <div>
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-100 dark:border-gray-800 p-6">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
        <i class="pi pi-bell text-amber-500"></i>
        গুরুত্বপূর্ণ নোটিশ
      </h3>
      <ul>
        <li
          v-for="notice in displayedNotices"
          :key="notice.id"
          class="mb-4 last:mb-0 pb-4 border-b border-gray-100 dark:border-gray-800 last:border-0"
        >
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <div>
              <div class="flex items-center gap-2">
                <span
                  v-if="notice.status === 'new'"
                  class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 mr-2"
                >নতুন</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ notice.date }}</span>
              </div>
              <div class="font-bold text-gray-800 dark:text-gray-100 mt-1">{{ notice.title }}</div>
              <div class="text-gray-600 dark:text-gray-300 text-sm mt-1">{{ notice.summary }}</div>
            </div>
          </div>
        </li>
      </ul>
      <div v-if="importantNotices.length > 2" class="mt-4 text-right">
        <button
          @click="toggleShowMore"
          class="px-4 py-2 rounded bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800 transition"
        >
          {{ showAll ? 'কম দেখুন' : 'সব দেখুন' }}
        </button>
      </div>
    </div>
  </div>
</template>
