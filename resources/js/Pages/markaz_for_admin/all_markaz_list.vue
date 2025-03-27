<template>
    <AuthenticatedLayout>
        <div class="p-6 bg-[#f8f9fa] min-h-screen mx-5 mt-5">
            <div class=" mx-auto">
                <!-- Header Section -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">

                        সকল মারকাযের তালিকা
                    </h1>

                </div>

                <!-- Search Panel -->
                <div class="bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
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

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- মাদ্রাসার নাম/কোড -->
                            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                                <label class="text-xl font-semibold text-gray-700 mb-2 flex items-center gap-2">

                                    মাদ্রাসার নাম/কোড
                                </label>
                                <input v-model="filters.madrasahName" type="text" placeholder="মাদ্রাসার নাম লিখুন"
                                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                            </div>

                            <!-- মাদ্রাসার ধরন -->
                            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                                <label class="text-xl  font-semibold text-gray-700 mb-2 flex items-center gap-2">

                                    মাদ্রাসার ধরন
                                </label>
                                <select v-model="filters.type"
                                    class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                                    <option value="">সকল</option>
                                    <option value="ছাত্র">ছাত্র</option>
                                    <option value="ছাত্রী">ছাত্রী</option>
                                </select>
                            </div>

                            <!-- মাদরাসার স্তর -->
                            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                                <label class="text-xl font-semibold text-gray-700 mb-2 flex items-center gap-2">

                                    মাদরাসার স্তর
                                </label>
                                <select v-model="filters.level" class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
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

                            <!-- মাদরাসার ধরন নির্বাচন -->
                            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                                <label class="text-xl  font-semibold text-gray-700 mb-2 flex items-center gap-2">

                                    মারকাযের ধরন নির্বাচন
                                </label>
                             <!-- মারকাযের ধরন নির্বাচন -->
<select v-model="filters.status" class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
    <option value="">সকল</option>
    <option value="darsiyat">দরসিয়াত</option>
    <option value="hifzul_quran">হিফজুল কুরআন</option>
    <option value="ilmul_qiraat">ইলমুল কিরাআত</option>
    <option value="all">সকল মারকাজ</option>
</select>

                            </div>

                            <!-- বিভাগ -->
                            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
    <label class="text-xl font-semibold text-gray-700 mb-2">বিভাগ</label>
    <select v-model="filters.division" @change="handleDivisionChange" class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f]">
      <option value="">সকল</option>
      <option v-for="division in divisions" :key="division.id" :value="division.id">
        {{ division.Division }}
      </option>
    </select>
  </div>

                            <!-- জেলা -->
                            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
    <label class="text-xl font-semibold text-gray-700 mb-2">জেলা</label>
    <select v-model="filters.district" @change="handleDistrictChange" class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f]">
      <option value="">সকল</option>
      <option v-for="district in districts" :key="district.DesID" :value="district.DesID">
        {{ district.District }}
      </option>
    </select>
  </div>

                            <!-- থানা/উপজেলা -->
                            <div class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
    <label class="text-xl font-semibold text-gray-700 mb-2">থানা/উপজেলা</label>
    <select v-model="filters.thana" class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f]">
      <option value="">সকল</option>
      <option v-for="thana in thanas" :key="thana.Thana_ID" :value="thana.Thana_ID">
        {{ thana.Thana }}
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
                           মারকাযের তালিকা
                        </h2>
                        <div class="text-white">মোট উপাত্ত: {{ applications.data?.length || 0 }}</div>

                    </div>

                    <div class="p-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th v-for="header in tableHeaders" :key="header.id"
                                        class="px-6 py-3 bg-gray-50 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">
                                        {{ header.label }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
    <tr v-for="(application, index) in applications.data" :key="application.id"
        class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ index + 1 }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">


            <!-- <Link
  :href="route('markaz_for_admin.madrasha_list_underMarkaz')"
  class="inline-flex items-center justify-center p-1 rounded-sm bg-blue-50 text-blue-700 hover:bg-blue-100 transition-all duration-200"
  title="View Details"
>
{{ application.name }}
</Link> -->

<Link
  :href="route('markaz_for_admin.madrasha_list_underMarkaz', application.id)"
  class="inline-flex items-center justify-center p-1 rounded-sm bg-blue-50 text-blue-700 hover:bg-blue-100 transition-all duration-200"
  title="View Details"
>
  {{ application.name }}
</Link>


        </td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ application.Elhaq_no }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ application.MType }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ application.markaz_serial }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ application.id }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ application.mobile_no }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ application.division_name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ application.district_name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900">{{ application.thana_name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-md text-gray-500">
            <div class="flex gap-2">
                <button @click="viewApplication(application)"
                    class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-eye"></i>
                </button>
                <button @click="editApplication(application)"
                    class="text-green-600 hover:text-green-800 flex items-center gap-2">
                    <i class="fas fa-envelope"></i>
                </button>
            </div>
        </td>
    </tr>
</tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
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
import { ref, reactive, onMounted, computed } from 'vue';

import axios from 'axios';
import { Link } from '@inertiajs/vue3';

// State Management
const applications = ref({
    data: [],
    current_page: 1,
    last_page: 1,
    total: 0,
    from: 0,
    to: 0
});

const loading = ref(false);
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




// Table Headers
const tableHeaders = [
    { id: 1, label: "ক্রমিক" },
    { id: 2, label: "মাদরাসার নাম" },
    { id: 3, label: "এলহাক নম্বর" },
    { id: 4, label: "ধরন" },
    { id: 5, label: "মারকাজ সিরিয়াল" },
    { id: 6, label: "আইডি" },
    { id: 7, label: "মোবাইল নম্বর" },
    { id: 8, label: "বিভাগ" },
    { id: 9, label: "জেলা" },
    { id: 10, label: "থানা" },
    { id: 11, label: "অ্যাকশন" }
];

// Computed Properties
const displayedPages = computed(() => {
    const current = applications.value.current_page;
    const last = applications.value.last_page;
    const delta = 2;
    const range = [];
    for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
        range.push(i);
    }
    return range;
});

// API Functions
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

const fetchMadrasaData = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/api/markaz-list', {
            params: {
                page: applications.value.current_page,
                per_page: perPage.value,
                ...filters.value
            }
        });
        applications.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    } finally {
        loading.value = false;
    }
};

// Search with filters
// Search with filters
// Search with filters
const search = () => {
    applications.value.current_page = 1;
    loading.value = true;

    // সার্চ টার্ম ট্রিম করা
    if (filters.value.madrasahName) {
        filters.value.madrasahName = filters.value.madrasahName.trim();
    }

    axios.get('/api/madrashas/filter', {
        params: filters.value
    })
    .then(response => {
        const data = response.data;

        // ডাটা ম্যাপিং এবং সাজেশন লজিক
        let formattedData = data;

        // যদি সার্চ টার্ম থাকে, তাহলে সাজেশন সর্ট করা
        if (filters.value.madrasahName && formattedData.length > 0) {
            // সার্চ টার্ম লোয়ারকেস করা
            const searchTerm = filters.value.madrasahName.toLowerCase();

            // ডাটা সর্ট করা - যেগুলো সার্চ টার্মের সাথে বেশি মিলে সেগুলো আগে আসবে
            formattedData.sort((a, b) => {
                // সঠিক ফিল্ড নাম ব্যবহার করা - MName বা name যেটি আছে
                const aName = ((a.name || a.MName) || '').toLowerCase();
                const bName = ((b.name || b.MName) || '').toLowerCase();

                // এক্সাক্ট ম্যাচ আগে আসবে
                if (aName === searchTerm && bName !== searchTerm) return -1;
                if (bName === searchTerm && aName !== searchTerm) return 1;

                // শুরুতে ম্যাচ হলে দ্বিতীয় অগ্রাধিকার
                if (aName.startsWith(searchTerm) && !bName.startsWith(searchTerm)) return -1;
                if (bName.startsWith(searchTerm) && !aName.startsWith(searchTerm)) return 1;

                // কন্টেইনস ম্যাচ তৃতীয় অগ্রাধিকার
                if (aName.includes(searchTerm) && !bName.includes(searchTerm)) return -1;
                if (bName.includes(searchTerm) && !aName.includes(searchTerm)) return 1;

                // অন্যথায় আলফাবেটিক সর্ট
                return aName.localeCompare(bName);
            });
        }

        // ডাটা ম্যাপিং - সঠিক ফিল্ড নাম নিশ্চিত করা
        formattedData = formattedData.map(item => {
            // কনসোলে ডাটা স্ট্রাকচার দেখা
            console.log('Item structure:', item);

            return {
                id: item.id,
                name: item.name || item.MName, // যেকোনো একটি ফিল্ড ব্যবহার করা
                Elhaq_no: item.Elhaq_no || item.ElhaqNo, // যেকোনো একটি ফিল্ড ব্যবহার করা
                type: item.type || item.MType,
                markaz_serial: item.markaz_serial || item.CenterSL,
                mobile_no: item.mobile_no || item.Mobile || item.MobileNo,
                division_name: item.division_name,
                district_name: item.district_name,
                thana_name: item.thana_name,
                // অন্যান্য প্রয়োজনীয় ফিল্ড
            };
        });

        // ম্যানুয়ালি পেজিনেশন তৈরি
        const totalItems = formattedData.length;
        const startIndex = 0;
        const endIndex = Math.min(perPage.value, totalItems);

        applications.value = {
            data: formattedData.slice(startIndex, endIndex),
            current_page: 1,
            last_page: Math.ceil(totalItems / perPage.value) || 1,
            total: totalItems,
            from: totalItems > 0 ? 1 : 0,
            to: endIndex
        };

        // ডিবাগিং
        console.log(`Found ${totalItems} results for search: "${filters.value.madrasahName}"`);
    })
    .catch(error => {
        console.error('Error filtering madrasas:', error);
    })
    .finally(() => {
        loading.value = false;
    });
};



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

const exportData = async () => {
    try {
        const response = await axios.get('/api/export-madrasa', {
            params: filters.value,
            responseType: 'blob'
        });
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'madrasa-list.xlsx');
        document.body.appendChild(link);
        link.click();
        link.remove();
    } catch (error) {
        console.error('Error exporting data:', error);
    }
};

const viewApplication = async (application) => {
    try {
        await axios.get(`/api/madrasahs/${application.id}`);
    } catch (error) {
        console.log('Error viewing application:', error);
    }
};

const editApplication = async (application) => {
    try {
        await axios.get(`/api/madrasahs/${application.id}/edit`);
    } catch (error) {
        console.log('Error editing application:', error);
    }
};

onMounted(() => {
    loadDivisions();
    fetchMadrasaData();
});
</script>

