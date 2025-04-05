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
    <!-- Header -->
    <div class="bg-[#2d6a4f] p-4 flex justify-between items-center">
        <h2 class="text-white text-lg font-semibold flex items-center gap-2">
            <i class="fas fa-search"></i>
            অনুসন্ধান ফিল্টার
        </h2>
        <div class="flex gap-2">
            <button @click="resetFilters"
                class="text-white hover:text-[#90caf9] flex items-center gap-1">
                <i class="fas fa-redo-alt"></i>
                রিসেট
            </button>
            <button @click="exportData" class="text-white hover:text-[#90caf9] flex items-center gap-1">
                <i class="fas fa-download"></i>
                এক্সপোর্ট
            </button>
        </div>
    </div>
    
    <!-- Filter Body -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- মাদ্রাসার নাম/ইলহাক নম্বর -->
            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                <label class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-school text-[#2d6a4f]"></i>
                    মাদরাসার নাম/ইলহাক নম্বর
                </label>
                <input
                    type="text"
                    v-model="filters.madrasahName"
                    placeholder="মাদরাসার নাম বা ইলহাক নম্বর লিখুন"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]"
                />
            </div>
            
            <!-- মাদ্রাসার ধরন -->
            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                <label class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-users text-[#2d6a4f]"></i>
                    মাদ্রাসার ধরন
                </label>
                <select 
                    v-model="filters.type"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]"
                >
                    <option value="">সকল</option>
                    <option value="ছাত্র">ছাত্র</option>
                    <option value="ছাত্রী">ছাত্রী</option>
                </select>
            </div>
            
            <!-- মাদরাসার স্তর -->
            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                <label class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-layer-group text-[#2d6a4f]"></i>
                    মাদরাসার স্তর
                </label>
                <select 
                    v-model="filters.level" 
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]"
                >
                    <option value="">সকল</option>
                    <option value="takmil">তাকমিল</option>
                    <option value="fazilat">ফযিলত</option>
                    <option value="sanabiya_uliya">সানাবিয়া উলইয়া</option>
                    <option value="sanabiya">সানাবিয়া</option>
                    <option value="mutawassita">মুতাওয়াসসিতা</option>
                    <option value="ibtedaiya">ইবতেদাইয়া</option>
                    <option value="hifzul_quran">হিফজুল কোরআন</option>
                    <option value="ilmul_qiraat">ইলমুল কিরাআত</option>
                </select>
            </div>
            
            <!-- মারকাযের ধরন নির্বাচন -->
            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                <label class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-mosque text-[#2d6a4f]"></i>
                    মারকাযের ধরন নির্বাচন
                </label>
                <select 
                    v-model="filters.status" 
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]"
                >
                    <option value="">সকল</option>
                    <option value="darsiyat">দরসিয়াত</option>
                    <option value="hifzul_quran">হিফজুল কুরআন</option>
                    <option value="ilmul_qiraat">ইলমুল কিরাআত</option>
                    <option value="all">সকল মারকাজ</option>
                </select>
            </div>
            
            <!-- বিভাগ -->
            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                <label class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-map-marked-alt text-[#2d6a4f]"></i>
                    বিভাগ
                </label>
                <select
                    v-model="filters.division"
                    @change="handleDivisionChange"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]"
                >
                    <option value="">সকল বিভাগ</option>
                    <option v-for="division in divisions" :key="division.id" :value="division.id">
                        {{ division.Division }}
                    </option>
                </select>
            </div>
            
            <!-- জেলা -->
            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                <label class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-city text-[#2d6a4f]"></i>
                    জেলা
                </label>
                <select
                    v-model="filters.district"
                    @change="handleDistrictChange"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]"
                    :disabled="!filters.division"
                >
                    <option value="">সকল জেলা</option>
                    <option v-for="district in districts" :key="district.DesID" :value="district.DesID">
                        {{ district.District }}
                    </option>
                </select>
            </div>
            
            <!-- থানা/উপজেলা -->
            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                <label class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-map-pin text-[#2d6a4f]"></i>
                    থানা/উপজেলা
                </label>
                <select
                    v-model="filters.thana"
                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]"
                    :disabled="!filters.district"
                >
                    <option value="">সকল থানা</option>
                    <option v-for="thana in thanas" :key="thana.Thana_ID" :value="thana.Thana_ID">
                        {{ thana.Thana }}
                    </option>
                </select>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end space-x-3">
            <button
                @click="resetFilters"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-sm border border-gray-300 hover:bg-gray-200 transition-colors flex items-center gap-2"
            >
                <i class="fas fa-redo-alt"></i>
                রিসেট
            </button>
            <button
                @click="search"
                class="px-4 py-2 bg-[#2d6a4f] text-white rounded-sm hover:bg-[#1b4332] transition-colors flex items-center gap-2"
            >
                <i class="fas fa-search"></i>
                অনুসন্ধান
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
        <th class="px-6 py-3 bg-gray-50 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">বিভাগ</th>
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
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ student?.Mobile}}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ student?.division_name}}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ student?.district_name}}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ student?.thana_name}}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm">
          <div class="flex items-center gap-3">
            <Link
              v-if="student?.id"
              href="route('markaz-agreements.view', student.id)"
              class="inline-flex items-center justify-center p-1 rounded-sm bg-blue-50 text-blue-700 hover:bg-blue-100 transition-all duration-200"
              title="View Details"
            >
            <i class="fas fa-envelope text-lg mr-1"></i>
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

          <div class="flex flex-col items-center gap-6 mt-4 mb-5 font-bangla">
                        <!-- Top Controls -->
                        <div
                            class="flex items-center justify-between w-full max-w-3xl bg-[#f8f9fa] p-4 rounded-lg shadow-sm border border-emerald-100">
                            <div class="flex items-center gap-3">
                                <label class="text-sm font-medium text-emerald-800">প্রতি পেজে:</label>
                                <select v-model="perPage" @change="handlePerPageChange"
                                    class="border-2 border-emerald-200 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                                    <option value="10">১০</option>
                                    <option value="20">২০</option>
                                    <option value="50">৫০</option>
                                    <option value="100">১০০</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-3">
                                <label class="text-sm font-medium text-emerald-800">পেজে যান:</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" v-model="jumpToPage" min="1" :max="applications.last_page"
                                        class="border-2 border-emerald-200 rounded-md w-24 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                                    <button @click="handleJumpToPage"
                                        class="bg-emerald-600 text-white px-4 py-1.5 rounded-md text-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors duration-200">
                                        যান
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Results Info -->
                        <div
                            class="text-sm font-medium text-emerald-800 bg-emerald-50 px-6 py-3 rounded-lg border border-emerald-200">
                            মোট <span class="text-emerald-600 font-bold">{{ applications.total }}</span> টির মধ্যে
                            <span class="text-emerald-600 font-bold">{{ applications.from }}-{{ applications.to
                                }}</span> দেখাচ্ছে
                        </div>

                        <!-- Pagination -->
                        <nav class="flex items-center gap-1.5 bg-white p-2 rounded-lg shadow-sm">
                            <button @click="handlePageChange(1)" class="pagination-btn rounded-l-md"
                                :class="{ 'opacity-50 cursor-not-allowed': applications.current_page === 1 }">
                                <i class="fas fa-angle-double-left"></i>
                            </button>

                            <button @click="handlePageChange(applications.current_page - 1)" class="pagination-btn"
                                :class="{ 'opacity-50 cursor-not-allowed': applications.current_page === 1 }">
                                <i class="fas fa-angle-left"></i>
                            </button>

                            <button v-for="page in displayedPages" :key="page" @click="handlePageChange(page)"
                                class="relative inline-flex items-center px-4 py-2 border-2 border-emerald-200 text-sm font-medium transition-all duration-200 hover:bg-emerald-50"
                                :class="applications.current_page === page ? 'bg-emerald-600 text-white border-emerald-600 hover:bg-emerald-700' : 'text-emerald-800'">
                                {{ page }}
                            </button>

                            <button @click="handlePageChange(applications.current_page + 1)" class="pagination-btn"
                                :class="{ 'opacity-50 cursor-not-allowed': applications.current_page === applications.last_page }">
                                <i class="fas fa-angle-right"></i>
                            </button>

                            <button @click="handlePageChange(applications.last_page)"
                                class="pagination-btn rounded-r-md"
                                :class="{ 'opacity-50 cursor-not-allowed': applications.current_page === applications.last_page }">
                                <i class="fas fa-angle-double-right"></i>
                            </button>
                        </nav>
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

const applications = ref({
    data: [],
    current_page: 1,
    last_page: 1,
    total: 0,
    from: 0,
    to: 0
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


// const loading = ref(false);
const perPage = ref(10);
const jumpToPage = ref('');
const divisions = ref([]);
const districts = ref([]);
const thanas = ref([]);

// Filters
const filters = ref({
    madrasahName: '',
    type: '',
    level: '',
    status: '',
    division: '',
    district: '',
    thana: ''
});



const loadDivisions = async () => {
    try {
        const response = await axios.get('/api/divisions');
        divisions.value = response.data;
    } catch (error) {
        console.error('Error loading divisions:', error);
    }
};

const handleDivisionChange = async () => {
    filters.value.district = '';
    filters.value.thana = '';
    districts.value = [];
    thanas.value = [];

    if (filters.value.division) {
        try {
            const response = await axios.get(`/api/districts/${filters.value.division}`);
            districts.value = response.data;
        } catch (error) {
            console.error('Error loading districts:', error);
        }
    }
};

const handleDistrictChange = async () => {
    filters.value.thana = '';
    thanas.value = [];

    if (filters.value.district) {
        try {
            const response = await axios.get(`/api/thanas/${filters.value.district}`);
            thanas.value = response.data;
        } catch (error) {
            console.error('Error loading thanas:', error);
        }
    }
};


// Update the search function to call the correct endpoint
const search = () => {
    loading.value = true;
    
    // Trim search term
    if (filters.value.madrasahName) {
        filters.value.madrasahName = filters.value.madrasahName.trim();
    }
    
    axios.get('/api/filter-markaz-students', {
        params: filters.value
    })
    .then(response => {
        students.value = response.data;
    })
    .catch(error => {
        console.error('Error filtering students:', error);
    })
    .finally(() => {
        loading.value = false;
    });
};

// Replace fetchStudents with this updated version
// const fetchStudents = async () => {
//   try {
//     loading.value = true;
//     const response = await axios.get('/api/markaz-students');
//     students.value = response.data;
//   } catch (error) {
//     console.error('ডাটা লোড করতে সমস্যা হয়েছে:', error);
//   } finally {
//     loading.value = false;
//   }
// };



// Event Handlers
const handlePageChange = async (page) => {
    applications.value.current_page = page;
    await fetchMadrasaData();
};

const handlePerPageChange = () => {
    applications.value.current_page = 1;
    fetchMadrasaData();
};

const handleJumpToPage = () => {
    const pageNumber = parseInt(jumpToPage.value);
    if (pageNumber && pageNumber >= 1 && pageNumber <= applications.value.last_page) {
        handlePageChange(pageNumber);
        jumpToPage.value = '';
    }
};

const resetFilters = () => {
    Object.keys(filters.value).forEach(key => {
        filters.value[key] = '';
    });
    districts.value = [];
    thanas.value = [];
    search();
};

onMounted(() => {
    loadDivisions();

});

</script>



<style scoped>
.btn-pagination {
  @apply relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50;
}
</style>
