<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
// import { Chart } from 'chart.js/auto';

import dashboard_card from './dashboard-component/dashboard_card.vue';
import Notice_bord_and_upcomming_exam from './dashboard-component/notice_bord_and_upcomming_exam.vue';
import Registrasion_update_dashboard from './dashboard-component/registrasion_update_dashboard.vue';

// Enhanced statistics data


// Enhanced exam schedule


// Recent activities
const activities = ref([
    {
        id: 1,
        type: 'exam_created',
        description: 'New exam schedule published for Computer Science',
        time: '2 hours ago',
        icon: '🆕'
    },
    // Add more activities...
]);
const selectedDaura = ref('1446'); // Default value
const madrasaCode = ref('');

const search = () => {
  // Perform search logic here using selectedDaura and madrasaCode
  console.log('Searching for:', selectedDaura.value, madrasaCode.value);
  // You would typically make an API call or filter data here.
};

</script>

<template>
    <Head title="WEMS" />

    <AuthenticatedLayout>
    <div class="py-6">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">










                <!-- Statistics Cards -->
                <dashboard_card />

                <!-- Main Content Grid -->
                <Notice_bord_and_upcomming_exam />
                <!-- Recent Activities -->
                <div class=" bg-[#F8F9FA] mt-5  mb-5">
    <!-- Header Section -->
    <Registrasion_update_dashboard />
  </div>








            </div>
        </div>

    </AuthenticatedLayout>
</template>


<style scoped>
/* .btn-primary {
    @apply px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200;
}

.btn-secondary {
    @apply px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200;
} */
</style>
