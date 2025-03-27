<template>
   <AuthenticatedLayout>
    <div class="p-6 bg-gray-50 mx-5 mt-5">
      <div class=" mx-auto bg-white rounded-sm shadow-lg p-8 border-2 border-emerald-600">
        <!-- Header with Islamic Pattern -->
        <div class="text-center mb-8">

          <h3 class="text-2xl font-semibold text-emerald-700">কেন্দ্রীয় পরীক্ষা সেটাপ</h3>
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
            <!-- Gregorian Year -->
            <div class="relative">
                <label class="block text-emerald-700 mb-2 font-md font-semibold">আরবি সন লিখুন (হিজরি)</label>
              <input
                v-model="gregorianYear"
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

            <!-- Hijri Year -->
            <div class="relative">
                <label class="block text-emerald-700 mb-2 font-md font-semibold">ইংরেজি সন লিখুন (ঈসাব্দ)</label>

              <input
                v-model="hijriYear"
                type="text"
                class="w-full px-4 py-3 rounded-sm border-2 border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"

              />
            </div>
          </div>


          <button
            type="submit"
            class="w-full bg-emerald-600 text-white py-3 rounded-sm hover:bg-emerald-700 transition-colors font-semibold"
          >
          সেভ করুন
          </button>
        </form>
      </div>
    </div>
   </AuthenticatedLayout>
  </template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
import { ref } from 'vue'
import axios from 'axios'

const examName = ref('')
const gregorianYear = ref('')
const banglaYear = ref('')
const hijriYear = ref('')

const handleSubmit = async () => {
  try {
    const response = await axios.post('/api/exam-setups', {
      exam_name: examName.value,
      arabic_year: gregorianYear.value,
      bangla_year: banglaYear.value,
      english_year: hijriYear.value
    })

    if (response.status === 201) {
      // Clear form
      examName.value = ''
      gregorianYear.value = ''
      banglaYear.value = ''
      hijriYear.value = ''

      // Show success message
      alert('পরীক্ষা সেটাপ সফলভাবে সংরক্ষণ করা হয়েছে!')
    }
  } catch (error) {
    alert('দুঃখিত! কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।')
    console.error('Error:', error)
  }
}
</script>

  <style>
  /* Custom font for Arabic text */
  @import url('https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;700&display=swap');


  </style>
