<script setup>
import { ref } from 'vue';

const examCenters = ref([
  {
    id: 1,
    name: 'দারুল উলুম মাদরাসা কেন্দ্র',
    location: 'ঢাকা',
    capacity: '৫০০',
    assignedStudents: '৪৮৫',
    status: 'active'
  },
  {
    id: 2,
    name: 'জামিয়া ইসলামিয়া কেন্দ্র',
    location: 'চট্টগ্রাম',
    capacity: '৪৫০',
    assignedStudents: '৪২০',
    status: 'active'
  },
  {
    id: 3,
    name: 'মাদরাসা আল-আরাবিয়া কেন্দ্র',
    location: 'সিলেট',
    capacity: '৩৫০',
    assignedStudents: '৩৪০',
    status: 'active'
  },
  {
    id: 4,
    name: 'নূরানী মাদরাসা কেন্দ্র',
    location: 'রাজশাহী',
    capacity: '৪০০',
    assignedStudents: '৩৮০',
    status: 'active'
  },
  {
    id: 5,
    name: 'হাফেজিয়া মাদরাসা কেন্দ্র',
    location: 'খুলনা',
    capacity: '৩০০',
    assignedStudents: '২৮৫',
    status: 'active'
  }
]);

const centerSummary = ref({
  totalCenters: '৩৪৫',
  totalCapacity: '১,৫০,০০০',
  assignedStudents: '১,৪৫,৬৭৮',
  remainingCapacity: '৪,৩২২'
});

const selectedCenter = ref(null);

const showCenterDetails = (center) => {
  selectedCenter.value = center;
};

const closeCenterDetails = () => {
  selectedCenter.value = null;
};
</script>

<template>

</template>
