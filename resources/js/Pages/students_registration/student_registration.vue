<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const isDialogOpen = ref(false)
const examFees = ref([])
const examName = ref('')

const fetchExamFees = async () => {
  try {
    const response = await axios.get('/api/exam-fees')
    examFees.value = response.data.examFees
    examName.value = response.data.examName
  } catch (error) {
    console.error('Error fetching exam fees:', error)
  }
}

onMounted(() => {
  fetchExamFees()
})

const toggleDialog = () => {
  isDialogOpen.value = !isDialogOpen.value
}
</script>

<template>
<AuthenticatedLayout>
    <div class="bg-white rounded-sm shadow-lg overflow-hidden mx-5 mt-5">
  <!-- Header Section -->
  <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 p-6 rounded-t-sm shadow-lg">
    <div class="container mx-auto">
      <div class="flex justify-between items-center">
        <!-- Title -->
        <h2 class="text-white text-xl md:text-3xl font-bold">
                            {{ examName }}
                        </h2>

        <!-- Settings Button -->
        <button
          @click="toggleDialog"
          class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-md shadow-md flex items-center gap-2 transition-all duration-300"
        >
          <i class="fas fa-cog"></i>
          <span>মারকায সেটিং</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Table Section -->
  <div class="p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
            <thead class="bg-emerald-600">
  <tr class="divide-x divide-emerald-500">
    <th class="px-4 py-3 text-white text-left text-xl font-semibold border-r border-emerald-500">
      মারহালা
    </th>

    <!-- Regular Registration -->
    <th colspan="2" class="px-4 py-3 border-r border-emerald-500">
      <div class="text-white text-center font-semibold text-xl">নিয়মিত রেজিস্ট্রেশন</div>
      <div class="grid grid-cols-2 gap-2 mt-2 divide-x divide-emerald-500">
        <div class="text-white text-xl">শুরু</div>
        <div class="text-white text-xl">শেষ</div>
      </div>
    </th>

    <th class="px-4 py-3 text-white text-center text-xl font-semibold border-r border-emerald-500">
      নিয়মিত ফি
    </th>

    <!-- Late Registration -->
    <th colspan="2" class="px-4 py-3 border-r border-emerald-500">
      <div class="text-white text-center font-semibold text-xl">বিলম্ব রেজিস্ট্রেশন</div>
      <div class="grid grid-cols-2 gap-2 mt-2 divide-x divide-emerald-500">
        <div class="text-white text-xl">শুরু</div>
        <div class="text-white text-xl">শেষ</div>
      </div>
    </th>

    <th class="px-4 py-3 text-white text-center font-semibold border-r border-emerald-500 text-xl">
      বিলম্ব ফি
    </th>

    <!-- Student Count -->
    <th colspan="2" class="px-4 py-3 border-r border-emerald-500">
      <div class="text-white text-center font-semibold text-xl">ছাত্র সংখ্যা</div>
      <div class="grid grid-cols-2 gap-2 mt-2 divide-x divide-emerald-500">
        <div class="text-white text-xl">নিয়মিত</div>
        <div class="text-white text-xl">অনিয়মিত</div>
      </div>
    </th>

    <th class="px-4 py-3 text-white text-center font-semibold text-xl">
      একশন
    </th>
  </tr>
</thead>


            <tbody class="divide-y divide-gray-100 text-xl">
                <tr v-for="fee in examFees" :key="fee.id" class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 ">{{ fee.marhala_name_bn }}</td>
                            <td class="px-4 py-3 text-center">{{ fee.regularStartDate }}</td>
                            <td class="px-4 py-3 text-center">{{ fee.regularEndDate }}</td>
                            <td class="px-4 py-3 text-center font-medium">৳{{ fee.regularFee }}</td>
                            <td class="px-4 py-3 text-center">{{ fee.lateStartDate }}</td>
                            <td class="px-4 py-3 text-center">{{ fee.lateEndDate }}</td>
                            <td class="px-4 py-3 text-center font-medium">৳{{ fee.lateFee }}</td>
                            <td class="px-4 py-3 text-center">{{ fee.regularStudents }}</td>
                            <td class="px-4 py-3 text-center">{{ fee.irregularStudents }}</td>

              <td class="px-4 py-3">
                <div class="flex gap-2 justify-center ">
                    <Link
                :href="route('students_registration.old_stu_reg_Form', { marhalaId: fee.marhala_id })"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-sm text-xl transition-all duration-300"
            >
                নিবন্ধন
            </Link>
                  <Link
                    :href="route('students_registration.student_reg_table')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-sm text-xl transition-all duration-300"
                  >
                    তালিকা
                  </Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

  <!-- Settings Dialog -->
  <div v-if="isDialogOpen" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-2xl mx-4 shadow-xl p-6">
      <div class="flex justify-between items-center border-b border-emerald-200 pb-4">
        <h3 class="text-xl font-semibold text-emerald-800 flex items-center gap-2">
          <i class="fas fa-cog"></i> মারকায সেটিংস
        </h3>
        <button @click="toggleDialog" class="text-gray-500 hover:text-gray-700 transition-colors">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Dialog content here -->

      <div class="flex justify-end gap-4 pt-4 border-t border-emerald-200 mt-6">
        <button
          @click="toggleDialog"
          class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-md text-gray-700 transition-all duration-300"
        >
          বাতিল
        </button>
        <button
          class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md transition-all duration-300"
        >
          সংরক্ষণ
        </button>
      </div>
    </div>
  </div>
</div>

</AuthenticatedLayout>


</template>
