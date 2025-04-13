<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-gray-50 mx-5 mt-10">
        <div class="mx-auto bg-white rounded-sm shadow-lg p-8 border-2 border-emerald-600">
          <!-- Header -->
          <div class="text-center mb-8">
            <h3 class="text-2xl font-semibold text-emerald-700">পরীক্ষার সময়সূচী সংশোধন</h3>
          </div>

          <form @submit.prevent="handleSubmit" class="space-y-6">
            <!-- Date Inputs -->
            <div class="grid grid-cols-2 gap-6">
              <div class="relative">
                <label class="block text-emerald-700 mb-2 font-md font-semibold">শুরুর তারিখ</label>
                <input
                  v-model="startDate"
                  type="date"
                  class="w-full px-4 py-3 rounded-sm border-2 border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                />
              </div>
              <div class="relative">
                <label class="block text-emerald-700 mb-2 font-md font-semibold">শেষের তারিখ</label>
                <input
                  v-model="endDate"
                  type="date"
                  class="w-full px-4 py-3 rounded-sm border-2 border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                />
              </div>
            </div>

            <!-- Status Selection -->
            <div class="relative">
              <label class="block text-emerald-700 mb-2 font-md font-semibold">স্ট্যাটাস</label>
              <select
                v-model="isActive"
                class="w-full px-4 py-3 rounded-sm border-2 border-emerald-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
              >
                <option :value="1">সক্রিয়</option>
                <option :value="0">নিষ্ক্রিয়</option>
              </select>
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

  const startDate = ref('')
  const endDate = ref('')
  const isActive = ref(1)

  // Fetch schedule setup data when component mounts
  onMounted(async () => {
    try {
      const scheduleId = route().params.id
      const response = await axios.get(`/api/schedule-setups/${scheduleId}`)

      if (response.data.success) {
        const scheduleSetup = response.data.scheduleSetup
        startDate.value = scheduleSetup.start_date
        endDate.value = scheduleSetup.end_date
        isActive.value = scheduleSetup.is_active
      }
    } catch (error) {
      console.error('Error fetching schedule setup:', error)
      alert('দুঃখিত! পরীক্ষার সময়সূচী লোড করতে সমস্যা হয়েছে।')
    }
  })

  const handleSubmit = async () => {
    try {
      const scheduleId = route().params.id
      const response = await axios.put(`/api/schedule-setups/${scheduleId}`, {
        start_date: startDate.value,
        end_date: endDate.value,
        is_active: isActive.value
      })

      if (response.data.success) {
        alert(response.data.message)
      }
    } catch (error) {
      alert('দুঃখিত! কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।')
      console.error('Error updating schedule setup:', error)
    }
  }
  </script>
