<template>
    <AuthenticatedLayout>
      <div class="mx-5 mt-5 p-8 bg-white rounded-sm shadow-md">
        <div class="text-center mb-8">
          <h3 class="text-xl font-bold text-gray-800">মারহালা সাবজেক্ট ইনফরমেশন</h3>
        </div>

        <form @submit.prevent="handleSubmit">
          <!-- Marhala Info -->
          <div class="grid grid-cols-5 gap-4 mb-6">
            <div>
              <label class="block text-emerald-800 text-xl font-semibold mb-2">মারহালা নাম (বাংলা)</label>
              <input type="text" v-model="form.marhalaNameBn" class="w-full px-2 py-1.5 border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
            </div>
            <div>
              <label class="block text-emerald-800 text-xl font-semibold mb-2">মারহালা নাম (ইংরেজি)</label>
              <input type="text" v-model="form.marhalaNameEn" class="w-full px-2 py-1.5 border border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
            </div>
            <div>
              <label class="block text-emerald-800 text-xl font-semibold mb-2">মারহালা নাম (আরবি)</label>
              <input type="text" v-model="form.marhalaNameAr" class="w-full px-2 py-1.5 border border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
            </div>

            <div class="col-span-5">
              <button type="button" @click="addNewRow" class="bg-emerald-500 text-white px-4 py-2  text-xl rounded-sm hover:bg-emerald-600">
                <i class="fas fa-plus mr-2"></i> নতুন সাবজেক্ট যোগ করুন
              </button>
            </div>
          </div>

          <!-- Subjects Table -->
          <div class="overflow-x-auto">
            <table class="w-full border-collapse text-xl">
              <thead>
                <tr class="bg-emerald-50">
                  <th class="border p-2 text-emerald-800">সাবজেক্ট কোড</th>
                  <th class="border p-2 text-emerald-800">কিতাব নাম (বাংলা)</th>
                  <th class="border p-2 text-emerald-800">কিতাব নাম (ইংরেজি)</th>
                  <th class="border p-2 text-emerald-800">কিতাব নাম (আরবি)</th>
                  <th class="border p-2 text-emerald-800">স্ট্যাটাস</th>
                  <th class="border p-2 text-emerald-800">অ্যাকশন</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(subject, index) in form.subjects" :key="index" class="hover:bg-emerald-50 ">
                  <td class="border p-2">
                    <input type="text" v-model="subject.code" class="w-full px-2 py-1 border rounded text-xl">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="subject.nameBangla" class="w-full px-2 py-1 border rounded text-xl">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="subject.nameEnglish" class="w-full px-2 py-1 border rounded text-xl">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="subject.nameArabic" class="w-full px-2 py-1 border rounded text-xl">
                  </td>
                  <td class="border p-2">
                    <div class="flex justify-center gap-4">
                      <label class="inline-flex items-center">
                        <input type="radio" v-model="subject.status" value="SRtype_1" class="text-emerald-600 text-xl">
                        <span class="ml-1">ছাত্র</span>
                      </label>
                      <label class="inline-flex items-center">
                        <input type="radio" v-model="subject.status" value="SRtype_0" class="text-emerald-600 text-xl">
                        <span class="ml-1">ছাত্রী</span>
                      </label>
                      <label class="inline-flex items-center">
                        <input type="radio" v-model="subject.status" value="Both" class="text-emerald-600 text-xl">
                        <span class="ml-1">উভয়</span>
                      </label>
                    </div>
                  </td>
                  <td class="border p-2">
                    <button type="button" @click="removeRow(index)" class="bg-red-500 text-white px-3 py-1 text-xl rounded hover:bg-red-600">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="flex justify-end mt-6">
            <button type="submit" class="bg-emerald-600 text-white px-6 py-2 text-xl rounded-md hover:bg-emerald-700 transition-colors duration-200 font-semibold shadow-md">
              সংশোধন করুন
            </button>
          </div>
        </form>
      </div>
    </AuthenticatedLayout>
  </template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    marhala: {
        type: Object,
        required: true
    }
})

const marhalaId = props.marhala.id
// URL থেকে id নেওয়া

const form = ref({
    marhalaNameBn: props.marhala.marhala_name_bn,
    marhalaNameEn: props.marhala.marhala_name_en,
    marhalaNameAr: props.marhala.marhala_name_ar,
    subjects: props.marhala.subjects.map(subject => ({
        code: subject.subject_code,
        nameBangla: subject.name_bangla,
        nameEnglish: subject.name_english,
        nameArabic: subject.name_arabic,
        status: subject.status || 'Both'
    }))
})

// নতুন সারি যোগ করা
const addNewRow = () => {
    form.value.subjects.push({
        code: '',
        nameBangla: '',
        nameEnglish: '',
        nameArabic: '',
        status: 'Both'
    })
}

// সারি রিমুভ করা
const removeRow = (index) => {
    form.value.subjects.splice(index, 1)
}


// ফর্ম সাবমিট
const handleSubmit = () => {
    router.put(`/marhalas/${marhalaId}`, form.value)
}
</script>

  <style scoped>
  .arabic-font {
      font-family: 'Amiri', 'Scheherazade New', serif;
  }
  </style>
