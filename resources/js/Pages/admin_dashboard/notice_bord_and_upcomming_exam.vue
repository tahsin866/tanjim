<script setup>
import { ref } from 'vue';

const notices = ref([
  {
    id: 1,
    title: 'দাওরায়ে হাদীস পরীক্ষার সময়সূচী প্রকাশিত হয়েছে',
    date: '১০ জুলাই, ২০২৩',
    priority: 'high',
    content: 'আগামী ১৫ আগস্ট থেকে দাওরায়ে হাদীস পরীক্ষা শুরু হবে। সকল মাদরাসাকে প্রস্তুতি নিতে অনুরোধ করা হচ্ছে।'
  },
  {
    id: 2,
    title: 'মারকাজ পরিদর্শন সংক্রান্ত বিজ্ঞপ্তি',
    date: '০৫ জুলাই, ২০২৩',
    priority: 'medium',
    content: 'আগামী মাসে সকল মারকাজ পরিদর্শন করা হবে। প্রয়োজনীয় ডকুমেন্ট প্রস্তুত রাখার জন্য অনুরোধ করা হচ্ছে।'
  },
  {
    id: 3,
    title: 'নতুন পাঠ্যক্রম সংক্রান্ত সভা',
    date: '০১ জুলাই, ২০২৩',
    priority: 'low',
    content: 'আগামী ২০ জুলাই সকল মাদরাসার প্রধান শিক্ষকদের উপস্থিতিতে নতুন পাঠ্যক্রম নিয়ে আলোচনা সভা অনুষ্ঠিত হবে।'
  }
]);

const upcomingExams = ref([
  {
    id: 1,
    name: 'দাওরায়ে হাদীস',
    date: '১৫ আগস্ট, ২০২৩',
    registeredStudents: '১২,৫৬৭',
    centers: '১৫৬',
    status: 'upcoming'
  },
  {
    id: 2,
    name: 'জামাত-ই-মুতাওয়াসসিতাহ',
    date: '২০ আগস্ট, ২০২৩',
    registeredStudents: '২৩,৪৫৬',
    centers: '২৩৪',
    status: 'upcoming'
  },
  {
    id: 3,
    name: 'জামাত-ই-সানাবিয়া',
    date: '২৫ আগস্ট, ২০২৩',
    registeredStudents: '৩৪,৫৬৭',
    centers: '২৮৯',
    status: 'upcoming'
  },
  {
    id: 4,
    name: 'জামাত-ই-আলিয়া',
    date: '০১ সেপ্টেম্বর, ২০২৩',
    registeredStudents: '১৮,৯৮৭',
    centers: '১৭৮',
    status: 'upcoming'
  }
]);

const selectedNotice = ref(null);

const showNoticeDetails = (notice) => {
  selectedNotice.value = notice;
};

const closeNoticeDetails = () => {
  selectedNotice.value = null;
};
</script>

<template>


</template>
