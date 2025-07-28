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


</template>
