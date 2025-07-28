<template>



</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const studentStats = ref({
    totalStudents: 0,
    boardSubmittedStudents: 0,
    approvedStudents: 0,
    boardReturnedStudents: 0
});

const loading = ref(true);
const error = ref(null);

onMounted(async () => {
    try {
        const response = await axios.get('/api/dashboard/student-stats');
        studentStats.value = response.data;
        loading.value = false;
    } catch (err) {
        error.value = 'ডাটা লোড করতে সমস্যা হয়েছে';
        loading.value = false;
        console.error(err);
    }
});
</script>
