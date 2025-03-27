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
              <label class="block text-emerald-800 font-semibold mb-2">মারহালা নাম (বাংলা)</label>
              <input type="text" v-model="formData.marhalaNameBn" class="w-full px-2 py-1.5  border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
            </div>
            <div>
              <label class="block text-emerald-800 font-semibold mb-2">মারহালা নাম (ইংরেজি)</label>
              <input type="text" v-model="formData.marhalaNameEn" class="w-full px-2 py-1.5 border border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
            </div>
            <div>
              <label class="block text-emerald-800 font-semibold mb-2">মারহালা নাম (আরবি)</label>
              <input type="text" v-model="formData.marhalaNameAr" class="w-full px-2 py-1.5 border border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
            </div>

            <div class="col-span-5">
              <button type="button" @click="addNewRow" class="bg-emerald-500 text-white px-4 py-2 rounded-sm hover:bg-emerald-600">
                <i class="fas fa-plus mr-2"></i> নতুন সাবজেক্ট যোগ করুন
              </button>
            </div>
          </div>

          <!-- Subjects Table -->
          <div class="overflow-x-auto">
            <table class="w-full border-collapse">
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
                <tr v-for="(subject, index) in subjects" :key="index" class="hover:bg-emerald-50">
                  <td class="border p-2">
                    <input type="text" v-model="subject.code" class="w-full px-2 py-1 border rounded">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="subject.nameBangla" class="w-full px-2 py-1 border rounded">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="subject.nameEnglish" class="w-full px-2 py-1 border rounded">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="subject.nameArabic" class="w-full px-2 py-1 border rounded">
                  </td>
                  <td class="border p-2">
                    <div class="flex justify-center gap-4">
                      <label class="inline-flex items-center">
                        <input type="radio" v-model="subject.status" value="SRtype_1" class="text-emerald-600">
                        <span class="ml-1">ছাত্র</span>
                      </label>
                      <label class="inline-flex items-center">
                        <input type="radio" v-model="subject.status" value="SRtype_0" class="text-emerald-600">
                        <span class="ml-1">ছাত্রী</span>
                      </label>
                      <label class="inline-flex items-center">
                        <input type="radio" v-model="subject.status" value="Both" class="text-emerald-600">
                        <span class="ml-1">উভয়</span>
                      </label>
                    </div>
                  </td>
                  <td class="border p-2">
                    <button type="button" @click="removeRow(index)"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="flex justify-end mt-6">
            <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-md hover:bg-emerald-700 transition-colors duration-200 font-semibold shadow-md">
              সংরক্ষণ করুন
            </button>
          </div>
        </form>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
  import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
  const formData = ref({
    marhalaNameBn: '',
    marhalaNameEn: '',
    marhalaNameAr: '',
})

//   const subjects = ref([
//     {
//       code: '',
//       nameBangla: '',
//       nameEnglish: '',
//       nameArabic: '',
//       status: 'active'
//     }
//   ])

const subjects = ref([])

const addNewRow = () => {
    subjects.value.push({
        code: '',
        nameBangla: '',
        nameEnglish: '',
        nameArabic: '',
        status: 'both'
    })
}




  const removeRow = (index) => {
    subjects.value.splice(index, 1)
  }

  const handleSubmit = () => {
    router.post(route('marhalas.store'), {
        ...formData.value,
        subjects: subjects.value
    })
}
    // Add your submission logic here

  </script>

  <style scoped>
  .arabic-font {
    font-family: 'Amiri', 'Scheherazade New', serif;
  }
  </style>
