<template>
    <AuthenticatedLayout>
        <div class="p-8 bg-[#f8f9fa] min-h-screen">
            <div class="bg-white rounded-sm shadow-md border border-emerald-100">
                <!-- Header Section -->
                <div class="bg-emerald-50 p-6 rounded-t-sm border-b border-emerald-100">
                    <div class="flex items-center justify-center gap-3">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <!-- <h2 class="text-2xl font-bold text-emerald-800">{{ formattedTitle }}</h2> -->
                        {{ `${examSetup.exam_name} ${examSetup.arabic_year} হিজরি/${examSetup.bangla_year}
                        বঙ্গাব্দ/${examSetup.english_year} ইসাব্দ` }}
                    </div>
                </div>

                <!-- Table Section -->
                <div class="p-6 overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-emerald-100 text-emerald-800">
                                <th class="border border-emerald-300 p-3 font-semibold">ক্রমিক</th>
                                <th class="border border-emerald-300 p-3 font-semibold">পরীক্ষা (মারহালা)</th>
                                <th class="border border-emerald-300 p-3 font-semibold text-center" colspan="6">নিবন্ধন
                                    ফি</th>
                                <th class="border border-emerald-300 p-3 font-semibold text-center" colspan="6">বিলম্ব
                                    ফি</th>
                            </tr>
                            <tr class="bg-emerald-50 text-emerald-800">
                                <th class="border border-emerald-300 p-3" colspan="2"></th>
                                <th class="border border-emerald-300 p-3">সময় সীমা</th>
                                <th class="border border-emerald-300 p-3">নিয়মিত</th>
                                <th class="border border-emerald-300 p-3">অনিয়মিত (যেমনি)</th>
                                <th class="border border-emerald-300 p-3">অনিয়মিত (মানোন্নয়ন)</th>
                                <th class="border border-emerald-300 p-3">অনিয়মিত (অন্যান্য)</th>
                                <th class="border border-emerald-300 p-3">সময় সীমা</th>
                                <th class="border border-emerald-300 p-3">নিয়মিত</th>
                                <th class="border border-emerald-300 p-3">অনিয়মিত (যেমনি)</th>
                                <th class="border border-emerald-300 p-3">অনিয়মিত (মানোন্নয়ন)</th>
                                <th class="border border-emerald-300 p-3">অনিয়মিত (অন্যান্য)</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(examFee, index) in examFeesData" :key="index" class="hover:bg-emerald-50 transition">
                                <td class="border border-emerald-300 p-3 text-center font-medium">{{ index + 1 }}</td>
                                <td class="border border-emerald-300 p-3 font-medium text-emerald-900">
                                    {{ examFee.exam_name }}
                                </td>

                                <!-- Registration Fee Section -->
                                <td class="border border-emerald-300 p-3">
    <div class="flex items-center gap-3">
        <div class="relative">
            <label class="absolute -top-2 left-2 bg-white px-1 text-xs text-emerald-600">শুরু</label>
            <input
                type="date"
                v-model="examFeesData[index].reg_date_from"
                class="w-44 border-2 border-emerald-200 p-3 rounded focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-sm"
            >
        </div>
        <span class="whitespace-nowrap font-medium text-emerald-700">থেকে</span>
        <div class="relative">
            <label class="absolute -top-2 left-2 bg-white px-1 text-xs text-emerald-600">শেষ</label>
            <input
                type="date"
                v-model="examFeesData[index].reg_date_to"
                class="w-44 border-2 border-emerald-200 p-3 rounded focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-sm"
            >
        </div>
    </div>
</td>
                                <td class="border border-emerald-300 p-3">
                                    <input type="number" v-model="examFeesData[index].reg_regular_fee"
                                        class="w-full border border-emerald-300 p-2 rounded-sm">
                                </td>

                                <td class="border border-emerald-300 p-3">
                                    <input type="number" v-model="examFeesData[index].reg_irregular_jemni"
                                        class="w-full border border-emerald-300 p-2 rounded-sm">
                                </td>

                                <td class="border border-emerald-300 p-3">
                                    <input type="number" v-model="examFeesData[index].reg_irregular_manonnoyon"
                                        class="w-full border border-emerald-300 p-2 rounded-sm">
                                </td>

                                <td class="border border-emerald-300 p-3">
                                    <input type="number" v-model="examFeesData[index].reg_irregular_others"
                                        class="w-full border border-emerald-300 p-2 rounded-sm">
                                </td>

                                <!-- Late Fee Section -->
                                <td class="border border-emerald-300 p-3">
    <div class="flex items-center gap-3">
        <div class="relative">
            <label class="absolute -top-2 left-2 bg-white px-1 text-xs text-emerald-600">শুরু</label>
            <input
                type="date"
                v-model="examFeesData[index].late_date_from"
                class="w-44 border-2 border-emerald-200 p-3 rounded focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-sm"
            >
        </div>
        <span class="whitespace-nowrap font-medium text-emerald-700">থেকে</span>
        <div class="relative">
            <label class="absolute -top-2 left-2 bg-white px-1 text-xs text-emerald-600">শেষ</label>
            <input
                type="date"
                v-model="examFeesData[index].late_date_to"
                class="w-44 border-2 border-emerald-200 p-3 rounded focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-sm"
            >
        </div>
    </div>
</td>

                                <td class="border border-emerald-300 p-3">
                                    <input type="number" v-model="examFeesData[index].late_regular_fee"
                                        class="w-full border border-emerald-300 p-2 rounded-sm">
                                </td>

                                <td class="border border-emerald-300 p-3">
                                    <input type="number" v-model="examFeesData[index].late_irregular_jemni"
                                        class="w-full border border-emerald-300 p-2 rounded-sm">
                                </td>

                                <td class="border border-emerald-300 p-3">
                                    <input type="number" v-model="examFeesData[index].late_irregular_manonnoyon"
                                        class="w-full border border-emerald-300 p-2 rounded-sm">
                                </td>

                                <td class="border border-emerald-300 p-3">
                                    <input type="number" v-model="examFeesData[index].late_irregular_others"
                                        class="w-full border border-emerald-300 p-2 rounded-sm">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <!-- Action Buttons -->
                <div class="bg-gray-50 p-6 rounded-b-xl border-t border-gray-100 flex justify-between items-center">
                    <button class="px-4 py-2 text-gray-600 hover:text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        এক্সেল ডাউনলোড
                    </button>

                    <div class="flex gap-3">
                        <button @click="resetForm"
                            class="px-6 py-2 bg-gray-100 text-gray-700 rounded-sm hover:bg-gray-200 transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            রিসেট
                        </button>

                        <button @click="submit"
                            class="px-6 py-2 bg-emerald-600 text-white rounded-sm hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            সংরক্ষণ করুন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'

const props = defineProps({
    examFees: {
        type: Array,
        required: true
    },
    examSetup: {
        type: Object,
        required: true
    }
})

// Track exam fees data
const examFeesData = ref(props.examFees)

// Submit function to update exam fees
const submit = async () => {
    try {
        // Map through examFeesData to update each row
        const promises = examFeesData.value.map(async (examFee) => {
            const response = await axios.put(`/api/central-exam-setup/${examFee.id}`, examFee)
            return response.data
        })

        await Promise.all(promises)
        alert('পরীক্ষার ফি সফলভাবে আপডেট করা হয়েছে')
    } catch (error) {
        alert('আপডেট ব্যর্থ হয়েছে')
    }
}

// Reset form to initial data
const resetForm = () => {
    examFeesData.value = JSON.parse(JSON.stringify(props.examFees))
}
</script>


<style scoped></style>
