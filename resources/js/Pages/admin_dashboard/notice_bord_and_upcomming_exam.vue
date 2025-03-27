<script setup>
import { ref,computed} from 'vue';

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
const showAll = ref(false)

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
       <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Performance Chart -->
                    <div class="bg-white dark:bg-gray-800 rounded-sm shadow-lg overflow-hidden">
    <div class="p-6 border-b border-emerald-100">
      <h3 class="text-lg font-bold text-emerald-800 dark:text-emerald-200 flex items-center gap-2">

        গুরুত্বপূর্ণ নোটিশ
      </h3>
    </div>

    <div class="p-4">
      <div v-for="notice in displayedNotices" :key="notice.id"
           class="mb-4 p-4 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-all cursor-pointer">
        <div class="flex items-center gap-3">
          <div class="h-2 w-2 rounded-full" :class="notice.status === 'new' ? 'bg-red-500' : 'bg-emerald-500'"></div>
          <span class="text-xs font-medium text-emerald-600">{{ notice.date }}</span>
        </div>
        <h4 class="font-medium text-emerald-800 mt-2">{{ notice.title }}</h4>
        <p class="text-sm text-emerald-600 mt-1">{{ notice.summary }}</p>
      </div>

      <!-- Show More Button -->
      <div class="text-center mt-4" v-if="importantNotices.length > 3">
        <button
          @click="toggleShowMore"
          class="px-6 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-sm transition-all duration-200 flex items-center gap-2 mx-auto"
        >
          <span>{{ showAll ? 'কম দেখুন' : 'আরও দেখুন' }}</span>
          <i :class="showAll ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
        </button>
      </div>
    </div>
  </div>

                    <!-- Upcoming Exams -->
                    <div class="bg-white dark:bg-gray-800 rounded-md shadow-md p-6 border border-emerald-100">
                        <h3 class="text-lg font-bold text-emerald-800 dark:text-emerald-200 mb-4 flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            আসন্ন পরীক্ষাসমূহ
                        </h3>
                        <div class="space-y-4">
                            <div v-for="exam in upcomingExams"
                                 :key="exam.id"
                                 class="p-4 bg-emerald-50 dark:bg-emerald-900/30 rounded-md hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-all duration-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-emerald-800 dark:text-emerald-200">{{ exam.subject }}</h4>
                                        <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ exam.date }} at {{ exam.time }}</p>
                                        <p class="text-sm text-emerald-600 dark:text-emerald-400">সময়কাল: {{ exam.duration }}</p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800">
                                        {{ exam.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-1 gap-8 mt-5">
    <!-- Main Notice Board -->

    <!-- Recent & Important Notices -->

</div>

</template>
