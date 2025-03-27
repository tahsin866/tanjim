<script setup>
import { ref } from 'vue';

</script>

<template>
<div style="font-family: 'Merriweather','SolaimanLipi',sans-serif;"
     class="mb-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total Students Card -->
    <div class="bg-gradient-to-br from-green-50 to-white rounded-md p-6 border border-green-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-green-600 text-sm font-semibold">মোট</span>
                </div>
                <p class="text-green-900 font-medium">মোট নিবন্ধিত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-green-100 p-3 rounded-xl">
                <!-- Mosque Icon -->
                <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4v6m-4 4h16M4 14l8-8 8 8M4 20h16"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Board Return Students Card -->
    <div class="bg-gradient-to-br from-teal-50 to-white rounded-md p-6 border border-teal-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-teal-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-teal-900 font-medium">বোর্ড ফেরত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-teal-100 p-3 rounded-xl">
                <!-- Prayer Beads Icon -->
                <svg class="w-8 h-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c.5-1.7 3.5-1.7 4 0 .5 1.7-3.5 1.7-4 0zm0 18c-.5 1.7-3.5 1.7-4 0-.5-1.7 3.5-1.7 4 0zm7-9c1.7-.5 1.7-3.5 0-4-1.7-.5-1.7 3.5 0 4zM5 12c-1.7.5-1.7-3.5 0-4 1.7-.5 1.7 3.5 0 4z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Female Students Card -->
    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-md p-6 border border-emerald-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-emerald-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-emerald-900 font-medium">ছাত্রী সংখ্যা</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-xl">
                <!-- Quran Icon -->
                <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Year Total Card -->
    <div class="bg-gradient-to-br from-green-50 to-white rounded-md p-6 border border-green-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-green-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-green-900 font-medium">{{ selectedYear }} সালের মোট</p>
            </div>
            <div class="bg-green-100 p-3 rounded-xl">
                <!-- Minaret Icon -->
                <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>
.islamic-pattern {
    background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 20.5V18H0v-2h20v-2H0v-2h20v-2H0V8h20V6H0V4h20V2H0V0h22v20h2V0h2v20h2V0h2v20h2V0h2v20h2V0h2v20h2v2H20v-1.5zM0 20h2v20H0V20zm4 0h2v20H4V20zm4 0h2v20H8V20zm4 0h2v20h-2V20zm4 0h2v20h-2V20zm4 0h2v20h-2V20zm4 0h2v20h-2V20zm4 0h2v20h-2V20zm4 0h2v20h-2V20zm4 0h2v20h-2V20z' fill='%23116D45' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
}
</style>
