<script setup>
import { ref, onMounted } from 'vue';

const registrationStats = ref({
  totalRegistered: '৭৫,৬৭৮',
  pendingApproval: '৩,৪৫৬',
  approved: '৭২,২২২',
  rejected: '৯৮৭'
});

const recentRegistrations = ref([
  {
    id: 'REG-7845',
    madrasaName: 'দারুল উলুম মাদরাসা',
    madrasaCode: 'DUM-1234',
    studentCount: '৪৫',
    date: '১০ জুলাই, ২০২৩',
    status: 'pending'
  },
  {
    id: 'REG-7844',
    madrasaName: 'জামিয়া ইসলামিয়া',
    madrasaCode: 'JIM-5678',
    studentCount: '৭৮',
    date: '০৯ জুলাই, ২০২৩',
    status: 'approved'
  },
  {
    id: 'REG-7843',
    madrasaName: 'মাদরাসা আল-আরাবিয়া',
    madrasaCode: 'MAA-9012',
    studentCount: '৬৩',
    date: '০৯ জুলাই, ২০২৩',
    status: 'approved'
  },
  {
    id: 'REG-7842',
    madrasaName: 'নূরানী মাদরাসা',
    madrasaCode: 'NUR-3456',
    studentCount: '৩২',
    date: '০৮ জুলাই, ২০২৩',
    status: 'rejected'
  },
  {
    id: 'REG-7841',
    madrasaName: 'হাফেজিয়া মাদরাসা',
    madrasaCode: 'HAF-7890',
    studentCount: '৫৫',
    date: '০৮ জুলাই, ২০২৩',
    status: 'approved'
  }
]);

const madrasaPerformance = ref([
  {
    name: 'দারুল উলুম মাদরাসা',
    code: 'DUM-1234',
    passRate: '৯৫%',
    students: '১২৫',
    trend: 'up'
  },
  {
    name: 'জামিয়া ইসলামিয়া',
    code: 'JIM-5678',
    passRate: '৯২%',
    students: '১৮৭',
    trend: 'up'
  },
  {
    name: 'মাদরাসা আল-আরাবিয়া',
    code: 'MAA-9012',
    passRate: '৮৮%',
    students: '১৫৬',
    trend: 'down'
  },
  {
    name: 'নূরানী মাদরাসা',
    code: 'NUR-3456',
    passRate: '৯০%',
    students: '১১২',
    trend: 'up'
  },
  {
    name: 'হাফেজিয়া মাদরাসা',
    code: 'HAF-7890',
    passRate: '৮৫%',
    students: '১৪৫',
    trend: 'down'
  }
]);

const selectedTab = ref('registrations');
</script>

<template>

</template>
