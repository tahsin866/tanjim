<template>
    <AuthenticatedLayout>
        <div class="p-6 bg-gray-50 min-h-screen">
            <!-- Filter Section -->
            <div class="bg-gray-50 border border-emerald-100 p-6 rounded-sm mb-6 shadow-sm">
                <h2 class="font-bold text-xl mb-6 text-emerald-800 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    ফিল্টার করুন
                </h2>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 md:col-span-6">
                        <label class="block text-emerald-700 text-sm font-medium mb-2">অনুসন্ধান করুন</label>
                        <input v-model="filters.search" type="text" placeholder="পরীক্ষার নাম দিয়ে অনুসন্ধান করুন..."
                            class="w-full border-emerald-200 rounded-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="block text-emerald-700 text-sm font-medium mb-2">কেন্দ্রীয় পরীক্ষা</label>
                        <select v-model="filters.status"
                            class="w-full border-emerald-200 rounded-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="">সকল পরীক্ষা</option>
                            <option v-for="option in examOptions" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <button @click="resetFilters"
                        class="bg-gray-100 text-gray-700 px-6 py-2 rounded-sm hover:bg-gray-200 transition-colors duration-200 flex items-center gap-2 border border-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        রিসেট
                    </button>
                    <button @click="searchExams"
                        class="bg-emerald-600 text-white px-6 py-2 rounded-sm hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        অনুসন্ধান করুন
                    </button>
                </div>
            </div>

            <!-- Exam List Header -->
            <div
                class="bg-white p-6 rounded-lg mb-6 flex justify-between items-center shadow-sm border border-gray-100">
                <h2 class="font-bold text-xl text-emerald-800 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    কেন্দ্রীয় পরীক্ষা তালিকা
                </h2>
                <Link :href="route('central_Exam_setup.central_exam_name')"
                    class="bg-emerald-600 text-white px-6 py-2 rounded-sm hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                নতুন কেন্দ্রীয় পরীক্ষা
                </Link>
            </div>

            <!-- Exam Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <!-- Responsive table container with horizontal scroll for small screens -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto text-sm md:text-base lg:text-xl">
            <thead>
                <tr class="bg-emerald-50 text-emerald-800">
                    <th class="px-2 md:px-4 lg:px-6 py-2 md:py-3 text-left font-semibold whitespace-nowrap">কেন্দ্রীয় পরীক্ষার নাম</th>
                    <th class="px-2 md:px-4 lg:px-6 py-2 md:py-3 text-left font-semibold whitespace-nowrap">ক্রম</th>
                    <th class="px-2 md:px-4 lg:px-6 py-2 md:py-3 text-left font-semibold whitespace-nowrap">ইয়ার</th>
                    <th class="px-2 md:px-4 lg:px-6 py-2 md:py-3 text-left font-semibold whitespace-nowrap">হিজরি</th>
                    <th class="px-2 md:px-4 lg:px-6 py-2 md:py-3 text-left font-semibold whitespace-nowrap">করনীয়</th>
                    <th class="px-2 md:px-4 lg:px-6 py-2 md:py-3 text-left font-semibold whitespace-nowrap">নিবন্ধন সেটাপ</th>
                    <th class="px-2 md:px-4 lg:px-6 py-2 md:py-3 text-left font-semibold whitespace-nowrap">অন্তর্ভুক্তি সেটাপ</th>
                    <th class="px-2 md:px-4 lg:px-6 py-2 md:py-3 text-left font-semibold whitespace-nowrap">অন্যান্য সেটাপ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr v-for="exam in filteredExams" :key="exam.id"
                    class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-2 md:px-4 lg:px-6 py-2 md:py-4 font-md font-semibold whitespace-nowrap">{{ exam.name }}</td>
                    <td class="px-2 md:px-4 lg:px-6 py-2 md:py-4 font-md font-semibold whitespace-nowrap">{{ exam.serial }}</td>
                    <td class="px-2 md:px-4 lg:px-6 py-2 md:py-4 font-md font-semibold whitespace-nowrap">{{ exam.year }}</td>
                    <td class="px-2 md:px-4 lg:px-6 py-2 md:py-4 font-md font-semibold whitespace-nowrap">{{ exam.hijri }}</td>
                    <td class="px-2 md:px-4 lg:px-6 py-2 md:py-4">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <Link :href="route('central_Exam_setup.central_exam_edit', exam.exam_setup_id)"
                                class="bg-amber-500 text-white px-2 md:px-3 lg:px-4 py-1 md:py-2 rounded-sm hover:bg-amber-600 transition-colors duration-200 text-xs md:text-sm lg:text-md text-center">
                                সংশোধনী
                            </Link>
                        </div>
                    </td>
                    <td class="px-2 md:px-4 lg:px-6 py-2 md:py-4">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <Link :href="route('central_Exam_setup.central_exam_edit', exam.exam_setup_id)"
                                class="bg-amber-500 text-white px-2 md:px-3 lg:px-4 py-1 md:py-2 rounded-sm hover:bg-amber-600 transition-colors duration-200 text-xs md:text-sm lg:text-md text-center">
                                সংশোধনী
                            </Link>
                            <Link :href="route('central_Exam_setup.nibondon_setup', exam.id)"
                                class="bg-emerald-500 text-white px-2 md:px-3 lg:px-4 py-1 md:py-2 rounded-sm hover:bg-emerald-600 transition-colors duration-200 text-xs md:text-sm lg:text-md text-center">
                                নিবন্ধন সেটআপ
                            </Link>
                        </div>
                    </td>
                    <td class="px-2 md:px-4 lg:px-6 py-2 md:py-4">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <Link :href="route('central_Exam_setup.central_exam_edit', exam.exam_setup_id)"
                                class="bg-amber-500 text-white px-2 md:px-3 lg:px-4 py-1 md:py-2 rounded-sm hover:bg-amber-600 transition-colors duration-200 text-xs md:text-sm lg:text-md text-center">
                                সংশোধনী
                            </Link>
                            <Link :href="route('central_Exam_setup.nibondon_setup', exam.id)"
                                class="bg-emerald-500 text-white px-2 md:px-3 lg:px-4 py-1 md:py-2 rounded-sm hover:bg-emerald-600 transition-colors duration-200 text-xs md:text-sm lg:text-md text-center">
                                অন্তর্ভুক্তি সেটআপ
                            </Link>
                        </div>
                    </td>
                    <td class="px-2 md:px-4 lg:px-6 py-2 md:py-4">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <Link :href="route('central_Exam_setup.nibondon_setup', exam.id)"
                                class="bg-emerald-500 text-white px-2 md:px-3 lg:px-4 py-1 md:py-2 rounded-sm hover:bg-emerald-600 transition-colors duration-200 text-xs md:text-sm lg:text-md text-center">
                                সংশোধনী
                            </Link>
                            <Link :href="route('central_Exam_setup.others_setup')"
                                class="bg-indigo-500 text-white px-2 md:px-3 lg:px-4 py-1 md:py-2 rounded-sm hover:bg-indigo-600 transition-colors duration-200 text-xs md:text-sm lg:text-md text-center">
                                অন্যান্য সেটআপ
                            </Link>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination - made responsive -->
    <div class="flex flex-col sm:flex-row justify-between items-center px-3 sm:px-6 py-3 sm:py-4 bg-gray-50 border-t border-gray-100">
        <span class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-0">মোট {{ filteredExams.length }} টি এন্ট্রি দেখানো হচ্ছে</span>
        <div class="flex space-x-2">
            <button
                class="px-2 sm:px-4 py-1 sm:py-2 border border-gray-300 rounded-sm bg-white text-gray-700 hover:bg-gray-50 transition-colors duration-200 text-xs sm:text-sm">←
                পূর্ববর্তী</button>
            <button
                class="px-2 sm:px-4 py-1 sm:py-2 border border-emerald-500 rounded-sm bg-emerald-500 text-white hover:bg-emerald-600 transition-colors duration-200 text-xs sm:text-sm">১</button>
            <button
                class="px-2 sm:px-4 py-1 sm:py-2 border border-gray-300 rounded-sm bg-white text-gray-700 hover:bg-gray-50 transition-colors duration-200 text-xs sm:text-sm">পরবর্তী
                →</button>
        </div>
    </div>
</div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
import { ref, onMounted, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import axios from 'axios'

const exams = ref([])
const filters = ref({

    search: ''
})

// Fetch exam setups
const fetchExamSetups = async () => {
    try {
        const response = await axios.get('/api/exam-setups_1')
        exams.value = response.data.map(exam => ({
            id: exam.id,
            exam_setup_id: exam.id,  // Added this line
            name: `${exam.exam_name} ${exam.arabic_year} হিজরি/${exam.bangla_year} বঙ্গাব্দ/${exam.english_year} ইসাব্দ`,
            serial: exam.id,
            year: exam.english_year,
            hijri: exam.arabic_year,
            bangla: exam.bangla_year,
        }))
    } catch (error) {
        console.error('API Error:', error)
    }
}

// Computed property for filtered exams
const filteredExams = computed(() => {
    return exams.value.filter(exam => {
        const matchesSearch = exam.name.toLowerCase().includes(filters.value.search.toLowerCase())
        const matchesStatus = !filters.value.status || exam.status === filters.value.status
        return matchesSearch && matchesStatus
    })
})

// Reset filters
const resetFilters = () => {
    filters.value = {
        status: '',
        search: ''
    }
}

// Search exams
const searchExams = () => {
    fetchExamSetups()
}

// Get unique exam names for dropdown
const examOptions = computed(() => {
    const uniqueExams = [...new Set(exams.value.map(exam => exam.name))]
    return uniqueExams.map(name => ({
        value: name,
        label: name
    }))
})

onMounted(() => {
    fetchExamSetups()
})
</script>
