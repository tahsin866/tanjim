<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-gray-50 mx-5 mt-10">
        <div class="mx-auto bg-white rounded-sm shadow-lg p-8 border-2 border-emerald-600">
          <!-- Header with Islamic Pattern -->
          <div class="text-center mb-8">
            <h3 class="text-2xl font-semibold text-emerald-700">কেন্দ্রীয় পরীক্ষা সেটাপ সংশোধন</h3>
          </div>
          <form @submit.prevent="handleSubmit" class="space-y-6">
            <!-- Exam Name Input -->
            <div class="relative">
              <label class="block text-emerald-700 mb-2 font-md font-semibold">পরীক্ষার নাম</label>
              <input
                v-model="examName"
                type="text"
                class="w-full font-md font-semibold px-4 py-3 rounded-sm border-2 border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                placeholder="পরীক্ষার নাম লিখুন"
              />
            </div>
            <!-- Year Inputs Grid -->
            <div class="grid md:grid-cols-3 gap-6">
              <!-- Arabic Year -->
              <div class="relative">
                <label class="block text-emerald-700 mb-2 font-md font-semibold">আরবি সন লিখুন (হিজরি)</label>
                <input
                  v-model="arabicYear"
                  type="text"
                  class="w-full px-4 py-3 rounded-sm border-2 border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                />
              </div>
              <!-- Bangla Year -->
              <div class="relative">
                <label class="block text-emerald-700 mb-2 font-md font-semibold">বাংলা সন লিখুন (বঙ্গাব্দ)</label>
                <input
                  v-model="banglaYear"
                  type="text"
                  class="w-full px-4 py-3 rounded-sm border-2 border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                />
              </div>
              <!-- English Year -->
              <div class="relative">
                <label class="block text-emerald-700 mb-2 font-md font-semibold">ইংরেজি সন লিখুন (ঈসাব্দ)</label>
                <input
                  v-model="englishYear"
                  type="text"
                  class="w-full px-4 py-3 rounded-sm border-2 border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                />
              </div>
            </div>
            <button
              type="submit"
              class="w-full bg-emerald-600 text-white py-3 rounded-sm hover:bg-emerald-700 transition-colors font-semibold"
            >
              আপডেট করুন
            </button>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const examName = ref('')
const arabicYear = ref('')
const banglaYear = ref('')
const englishYear = ref('')

// Fetch exam setup data when component mounts
onMounted(async () => {
  try {
    const examId = route().params.id
    const response = await axios.get(`/api/exam-setups/${examId}`)

    if (response.data.success) {
      const examSetup = response.data.examSetup
      examName.value = examSetup.exam_name
      arabicYear.value = examSetup.arabic_year
      banglaYear.value = examSetup.bangla_year
      englishYear.value = examSetup.english_year
    }
  } catch (error) {
    console.error('Error fetching exam setup:', error)
    alert('দুঃখিত! পরীক্ষা সেটাপ লোড করতে সমস্যা হয়েছে।')
  }
})

const handleSubmit = async () => {
  try {
    const examId = route().params.id
    const response = await axios.put(`/api/exam-setups/${examId}`, {
      exam_name: examName.value,
      arabic_year: arabicYear.value,
      bangla_year: banglaYear.value,
      english_year: englishYear.value
    })

    if (response.data.success) {
      alert(response.data.message)
    }
  } catch (error) {
    alert('দুঃখিত! কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।')
    console.error('Error updating exam setup:', error)
  }
}
</script>
