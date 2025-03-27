<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-[#f8f9fa] min-h-screen mx-5 mt-5">
        <div class="mx-auto">
          <!-- Header Section -->
          <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
              সকল মারকাযের নিবন্ধন তালিকা
            </h1>
            <p class="text-gray-600">কেন্দ্রীয় মাদ্রাসা আবেদন ব্যবস্থাপনা সিস্টেম</p>
          </div>

          <!-- Search Panel -->
          <div class="bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-[#2d6a4f] p-4 flex justify-between items-center">
              <h2 class="text-white text-lg font-semibold flex items-center gap-2">
                <i class="fas fa-search"></i>
                অনুসন্ধান ফিল্টার
              </h2>
              <div class="flex gap-2">
                <button @click="resetFilters" class="text-white hover:text-[#90caf9] flex items-center gap-1">
                  <i class="fas fa-redo-alt"></i>
                  রিসেট
                </button>
                <button @click="exportData" class="text-white hover:text-[#90caf9] flex items-center gap-1">
                  <i class="fas fa-download"></i>
                  এক্সপোর্ট
                </button>
              </div>
            </div>

            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Filter Field: মাদ্রাসার নাম/কোড/ইলহাক -->
                <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                  <label for="madrasahName" class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-school text-[#2d6a4f]"></i>
                    মাদ্রাসার নাম/কোড/ইলহাক
                  </label>
                  <input

                    id="madrasahName"
                    type="text"
                    placeholder="মাদ্রাসার নাম লিখুন"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                </div>

                <!-- Filter Field: মাদ্রাসার ধরন -->
                <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                  <label for="type" class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-building text-[#2d6a4f]"></i>
                    মাদ্রাসার ধরন
                  </label>
                  <select

                    id="type"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                    <option value="">সকল</option>
                    <option value="dakhil">ছাত্র</option>
                    <option value="alim">ছাত্রী</option>
                  </select>
                </div>

                <!-- Filter Field: কেন্দ্রীয় পরীক্ষা নির্বাচন করুন -->
                <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                  <label for="centralExam" class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-file-alt text-[#2d6a4f]"></i>
                    কেন্দ্রীয় পরীক্ষা নির্বাচন করুন
                  </label>
                  <select

                    id="centralExam"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                    <option value="">সকল</option>
                    <option value="takmil">তাকমিল</option>
                    <option value="fazilat">ফযিলত</option>
                    <option value="sanabiya_uliya">সানাবিয়া উলইয়া</option>
                    <option value="sanabiya">সানাবিয়া</option>
                    <option value="mutawassita">মুতাওয়াসসিতা</option>
                    <option value="ibtedaiyya">ইবতেদাইয়্যা</option>
                    <option value="hifzul_quran">হিফজুল কোরান</option>
                  </select>
                </div>

                <!-- Filter Field: মারকাযের ধরন নির্বাচন -->
                <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                  <label for="MarkazType" class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-mosque text-[#2d6a4f]"></i>
                    মারকাযের ধরন নির্বাচন
                  </label>
                  <select

                    id="MarkazType"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                    <option value="">সকল</option>
                    <option value="darsiyat">দরসিয়াত</option>
                    <option value="hifzul_quran">হিফজুল কোরান</option>
                  </select>
                </div>

                <!-- Filter Field: অবস্থা -->
                <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                  <label for="status" class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-check-circle text-[#2d6a4f]"></i>
                    অবস্থা
                  </label>
                  <select

                    id="status"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                    <option value="">সকল</option>
                    <option value="pending">অপেক্ষমান</option>
                    <option value="approved">অনুমোদিত</option>
                  </select>
                </div>

                <!-- Filter Field: বিভাগ -->
                <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                  <label for="division" class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-[#2d6a4f]"></i>
                    বিভাগ
                  </label>
                  <select

                    id="division"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                    <option value="">সকল</option>
                    <option v-for="division in divisions" :key="division.id" :value="division.id">
                      {{ division.name }}
                    </option>
                  </select>
                </div>

                <!-- Filter Field: জেলা -->
                <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                  <label for="district" class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-city text-[#2d6a4f]"></i>
                    জেলা
                  </label>
                  <select

                    id="district"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                    <option value="">সকল</option>
                    <option v-for="district in filteredDistricts" :key="district.id" :value="district.id">
                      {{ district.name }}
                    </option>
                  </select>
                </div>

                <!-- Filter Field: থানা/উপজেলা -->
                <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                  <label for="thana" class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-map text-[#2d6a4f]"></i>
                    থানা/উপজেলা
                  </label>
                  <select

                    id="thana"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                    <option value="">সকল</option>
                    <option v-for="upazila in filteredUpazilas" :key="upazila.id" :value="upazila.id">
                      {{ upazila.name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="mt-6 flex justify-end gap-3">
                <button @click="search"
                        class="px-6 py-2 bg-[#2d6a4f] text-white rounded-sm hover:bg-[#1b4332] flex items-center gap-2">
                  <i class="fas fa-search"></i>
                  অনুসন্ধান করুন
                </button>
              </div>
            </div>
          </div>

          <!-- Results Table -->
          <div class="mt-8 bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-[#2d6a4f] p-4 flex justify-between items-center">
              <h2 class="text-white text-lg font-semibold flex items-center gap-2">
                <i class="fas fa-list"></i>
                আবেদন তালিকা
              </h2>
              <div class="text-white">
                <span class="font-medium">{{ students.length }}</span>
              </div>
            </div>

            <div class="p-6 overflow-x-auto">
  <table class="min-w-full divide-y divide-gray-200">
    <thead>
      <tr>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">ক্রমিক নং</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">আবেদন নং</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">মাদ্রাসার নাম</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">ইলহাক নং</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">কেন্দ্রীয় পরীক্ষা</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">কোড</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">ছাত্র সংখ্যা</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">ফোন নম্বর</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">জেলা</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">থানা/উপজেলা</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">বোর্ড স্ট্যটাস</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">একশন</th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <tr v-for="(student, index) in students" :key="student?.id || index" class="hover:bg-gray-50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ index + 1 }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ student?.id }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm">
          <!-- {{ student?.madrasha_Name }} -->

          <Link
  :href="route('nibondon_for_admin.abandon_stu_list', { markaz_id: student.id })"
  class="inline-flex items-center justify-center p-1 rounded-sm bg-blue-50 text-blue-700 hover:bg-blue-100 transition-all duration-200"
  title="View Details"
>
  {{ student?.madrasha_Name }}
</Link>




        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
          {{ student?.Elhaq_no }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ student?.exam_name_Bn }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
          {{ student?.madrasha_code }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ student?.student_count }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm">
          <div class="flex items-center gap-3">
            <Link
              v-if="student?.id"
              href="route('markaz-agreements.view', student.id)"
              class="inline-flex items-center justify-center p-1 rounded-sm bg-blue-50 text-blue-700 hover:bg-blue-100 transition-all duration-200"
              title="View Details"
            >
              <i class="fas fa-eye text-lg"></i>
            </Link>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
          <!-- Pagination -->
          <div class="bg-gray-50 px-6 py-4 flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
              <button class="btn-pagination">Previous</button>
              <button class="btn-pagination">Next</button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing
                  <span class="font-medium">1</span>
                  to
                  <span class="font-medium">10</span>
                  of
                  <span class="font-medium">{{ students.length }}</span>
                  results
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                  <!-- Add pagination buttons here -->
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, reactive, computed, watch, onMounted } from 'vue';
import axios from 'axios';

// আগের props ডিফাইনেশন রাখুন যাতে কোন এরর না হয়
const props = defineProps({
  students: {
    type: Array,
    default: () => []
  },
  districts: {
    type: Array,
    default: () => []
  },
  upazilas: {
    type: Array,
    default: () => []
  },
  divisions: {
    type: Array,
    default: () => []
  }
});

// Axios দিয়ে ডাটা ফেচ করার জন্য
const students = ref([]);
const loading = ref(true);

onMounted(() => {
  fetchStudents();
});

const fetchStudents = async () => {
  try {
    const response = await axios.get('/api/markaz-students');
    students.value = response.data;
    loading.value = false;
  } catch (error) {
    console.error('ডাটা লোড করতে সমস্যা হয়েছে:', error);
    loading.value = false;
  }
};
</script>



<style scoped>
.btn-pagination {
  @apply relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50;
}
</style>
