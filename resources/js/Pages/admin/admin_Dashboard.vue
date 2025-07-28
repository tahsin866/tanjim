<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import dashboard_card from '../dashboard-component/dashboard_card.vue';
import MonthlyTrendChart from '../dashboard-component/MonthlyTrendChart.vue';
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

const stats = ref([]);
const yearlyStats = ref([]);
const departmentStats = ref({});
const recentActivities = ref([]);
const monthlyTrend = ref([]);
const paymentStats = ref({});
const notices = ref([]);
const loading = ref(true);
const selectedYear = ref(new Date().getFullYear());

const filteredYearlyStats = computed(() => {
    if (!selectedYear.value) return yearlyStats.value;
    return yearlyStats.value.filter(stat => stat.year == selectedYear.value);
});

const availableYears = computed(() => {
    return [...new Set(yearlyStats.value.map(stat => stat.year))].sort((a, b) => b - a);
});

onMounted(async () => {
    await fetchDashboardData();
    await fetchNotices();
});

const fetchDashboardData = async () => {
    try {
        const res = await axios.get('/api/admin/dashboard-stats', {
            params: { year: selectedYear.value }
        });
        const data = res.data;
        stats.value = data.stats;
        yearlyStats.value = data.yearlyStats;
        departmentStats.value = data.departmentStats;
        recentActivities.value = data.recentActivities;
        monthlyTrend.value = data.monthlyTrend;
        paymentStats.value = data.paymentStats;
    } catch (e) {
        console.error('Dashboard data fetch error:', e);
        alert('ড্যাশবোর্ড তথ্য আনতে সমস্যা হয়েছে।');
    } finally {
        loading.value = false;
    }
};

const fetchNotices = async () => {
    try {
        const res = await axios.get('/api/admin/notices');
        notices.value = res.data.notices;
    } catch (e) {
        console.error('Notices fetch error:', e);
    }
};

const onYearChange = () => {
    loading.value = true;
    fetchDashboardData();
};

const goToUserDetails = (userId) => {
    router.get(route('admin.documents.applications.show', userId));
};

const approveUser = async (userId) => {
    if (confirm('এই ব্যবহারকারীকে অনুমোদন দিতে চান?')) {
        try {
            await router.patch(route('admin.documents.applications.approve', userId));
            await fetchDashboardData(); // Refresh data
        } catch (e) {
            console.error('Approval error:', e);
        }
    }
};

const getStatusBadgeClass = (status) => {
    const classes = {
        'approved': 'bg-green-100 text-green-800',
        'pending': 'bg-yellow-100 text-yellow-800',
        'rejected': 'bg-red-100 text-red-800',
        'suspended': 'bg-gray-100 text-gray-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusText = (status) => {
    const statusTexts = {
        'approved': 'অনুমোদিত',
        'pending': 'অপেক্ষমান',
        'rejected': 'বাতিল',
        'suspended': 'স্থগিত'
    };
    return statusTexts[status] || status;
};

const getNoticeTypeClass = (type) => {
    const classes = {
        'important': 'border-l-4 border-red-500 bg-red-50',
        'info': 'border-l-4 border-blue-500 bg-blue-50',
        'general': 'border-l-4 border-gray-500 bg-gray-50'
    };
    return classes[type] || 'border-l-4 border-gray-500 bg-gray-50';
};
</script>

<template>
   <AuthenticatedLayout>
     <div class="py-6  mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold leading-tight text-gray-800 flex items-center gap-3">
                <i class="pi pi-chart-bar text-blue-500 text-2xl"></i>
                প্রশাসনিক ড্যাশবোর্ড
            </h2>
            <p class="text-gray-600 mt-2">সামগ্রিক পরিসংখ্যান এবং কার্যক্রম পর্যবেক্ষণ</p>
        </div>

        <div v-if="loading" class="text-center py-10 text-gray-400">
            <i class="pi pi-spin pi-spinner text-3xl mb-4"></i>
            <p>লোড হচ্ছে...</p>
        </div>

        <div v-else>
            <!-- Main Stats Cards -->
            <dashboard_card :stats="stats" />

            <!-- Year Filter and Revenue Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 mt-5">
                <!-- Yearly Revenue Stats -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="pi pi-chart-line text-blue-500"></i>
                            বছর অনুযায়ী রেজিস্ট্রেশন ও আয়
                        </h3>
                        <select v-model="selectedYear" @change="onYearChange"
                                class="rounded border border-gray-300 px-3 py-1 text-sm focus:ring-2 focus:ring-blue-400">
                            <option value="">সব বছর</option>
                            <option v-for="year in availableYears" :key="year" :value="year">{{ year }}</option>
                        </select>
                    </div>

                    <!-- Table View -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">বছর</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">মোট নিবন্ধন</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">অনুমোদিত</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">অনুমোদনের হার</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">আনুমানিক আয় (৳)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="stat in filteredYearlyStats" :key="stat.year"
                                    class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ stat.year }} সাল</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <div class="text-sm text-gray-900 font-semibold">{{ stat.total_registrations }}</div>
                                        <div class="text-xs text-gray-500">জন</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <div class="text-sm text-green-600 font-semibold">{{ stat.approved_count }}</div>
                                        <div class="text-xs text-gray-500">জন</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <div class="text-sm font-semibold"
                                             :class="(stat.approved_count / stat.total_registrations * 100) > 70 ? 'text-green-600' : 'text-yellow-600'">
                                            {{ Math.round((stat.approved_count / stat.total_registrations) * 100) }}%
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                            <div class="bg-green-600 h-1.5 rounded-full"
                                                 :style="`width: ${(stat.approved_count / stat.total_registrations) * 100}%`"></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-right">
                                        <div class="text-sm font-bold text-blue-600">৳{{ stat.estimated_revenue.toLocaleString() }}</div>
                                        <div class="text-xs text-gray-500">আনুমানিক</div>
                                    </td>
                                </tr>
                                <tr v-if="!filteredYearlyStats.length">
                                    <td colspan="5" class="text-center py-4 text-gray-500">
                                        <i class="pi pi-info-circle mr-2"></i>
                                        কোনো ডেটা পাওয়া যায়নি
                                    </td>
                                </tr>
                            </tbody>
                            <!-- Summary Row -->
                            <tfoot v-if="filteredYearlyStats.length" class="bg-blue-50">
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">সর্বমোট</td>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-blue-600">
                                        {{ filteredYearlyStats.reduce((sum, stat) => sum + stat.total_registrations, 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-green-600">
                                        {{ filteredYearlyStats.reduce((sum, stat) => sum + stat.approved_count, 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-gray-700">
                                        {{ Math.round((filteredYearlyStats.reduce((sum, stat) => sum + stat.approved_count, 0) /
                                           filteredYearlyStats.reduce((sum, stat) => sum + stat.total_registrations, 0)) * 100) }}%
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-bold text-blue-600">
                                        ৳{{ filteredYearlyStats.reduce((sum, stat) => sum + stat.estimated_revenue, 0).toLocaleString() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>                <!-- Payment Overview -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="pi pi-credit-card text-green-500"></i>
                        পেমেন্ট সংক্রান্ত তথ্য
                    </h3>
                    <div class="space-y-4">
                        <div class="p-4 bg-green-50 rounded-lg">
                            <p class="text-sm text-gray-600">পেমেন্ট সম্পন্ন</p>
                            <p class="text-2xl font-bold text-green-600">{{ paymentStats.paid || 0 }}</p>
                        </div>
                        <div class="p-4 bg-red-50 rounded-lg">
                            <p class="text-sm text-gray-600">পেমেন্ট বাকি</p>
                            <p class="text-2xl font-bold text-red-600">{{ paymentStats.unpaid || 0 }}</p>
                        </div>
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <p class="text-sm text-gray-600">মোট আয়</p>
                            <p class="text-2xl font-bold text-blue-600">৳{{ paymentStats.revenue || 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Stats -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="pi pi-building text-purple-500"></i>
                    বিভাগ অনুযায়ী পরিসংখ্যান
                </h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <i class="pi pi-book text-blue-500 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">তাকমিল</p>
                        <p class="text-xl font-bold text-blue-600">{{ departmentStats.takmil_count || 0 }}</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <i class="pi pi-graduation-cap text-green-500 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">ইফতা</p>
                        <p class="text-xl font-bold text-green-600">{{ departmentStats.ifta_count || 0 }}</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <i class="pi pi-bookmark text-purple-500 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">হিফজ</p>
                        <p class="text-xl font-bold text-purple-600">{{ departmentStats.hifz_count || 0 }}</p>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-lg">
                        <i class="pi pi-volume-up text-orange-500 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">কিরাআত</p>
                        <p class="text-xl font-bold text-orange-600">{{ departmentStats.qirat_count || 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Monthly Trend Chart -->
            <MonthlyTrendChart :data="monthlyTrend" />

            <!-- Recent Activities and Notices -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 mt-5">
                <!-- Recent Activities Table -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="pi pi-clock text-blue-500"></i>
                        সাম্প্রতিক কার্যক্রম ও দ্রুত অনুমোদন
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">নাম</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">রোল</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">পেশা</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">কার্যক্রম</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">স্ট্যাটাস</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">সময়</th>
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="activity in recentActivities.slice(0, 10)" :key="activity.id"
                                    class="hover:bg-gray-50 transition-colors">
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ activity.name }}</div>
                                        <div class="text-xs text-gray-500">{{ activity.father_name }}</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-700">
                                        {{ activity.roll_number }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-700">
                                        {{ activity.workplace }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <span :class="activity.activity_type === 'registration' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'"
                                              class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                            {{ activity.activity_text }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <span :class="getStatusBadgeClass(activity.status)"
                                              class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                            {{ getStatusText(activity.status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500">
                                        {{ new Date(activity.activity_time).toLocaleDateString('bn-BD') }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <button @click="goToUserDetails(activity.id)"
                                                    class="bg-blue-500 text-white text-xs px-2 py-1 rounded hover:bg-blue-600 transition"
                                                    title="বিস্তারিত দেখুন">
                                                <i class="pi pi-eye"></i>
                                            </button>
                                            <button v-if="activity.status === 'pending'" @click="approveUser(activity.id)"
                                                    class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600 transition"
                                                    title="অনুমোদন দিন">
                                                <i class="pi pi-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="!recentActivities.length">
                                    <td colspan="7" class="text-center py-4 text-gray-500">
                                        <i class="pi pi-info-circle mr-2"></i>
                                        কোনো সাম্প্রতিক কার্যক্রম নেই
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>                <!-- Notice Board -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="pi pi-megaphone text-orange-500"></i>
                        নোটিস বোর্ড
                    </h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        <div v-for="notice in notices.slice(0, 3)" :key="notice.id"
                             :class="getNoticeTypeClass(notice.type)"
                             class="p-3 rounded-lg">
                            <h4 class="font-medium text-gray-800 mb-1">{{ notice.title }}</h4>
                            <p class="text-sm text-gray-600 mb-2">{{ notice.content.substring(0, 100) }}...</p>
                            <p class="text-xs text-gray-500">{{ new Date(notice.created_at).toLocaleDateString('bn-BD') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Updates Section আর থাকবে না, উপরে table এ combined করা হয়েছে -->
        </div>
     </div>
   </AuthenticatedLayout>
</template>
