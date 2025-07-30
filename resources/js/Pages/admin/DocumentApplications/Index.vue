<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import SplitButton from 'primevue/splitbutton';
import Paginator from 'primevue/paginator';

const props = defineProps({
    users: Object,
    divisions: Array,
    districts: Array,
    thanas: Array,
    graduationYears: Array,
    bloodGroups: Array,
    workplaces: Array,
    departments: Array,
    statusOptions: Array,
    filters: Object,
});

const page = usePage();

const items = (user) => {
    const baseItems = [
        {
            label: 'বিস্তারিত',
            icon: 'pi pi-eye',
            command: () => {
                router.get(route('admin.documents.applications.show', user.id));
            }
        }
    ];

    const currentAdmin = page.props.auth.admin;

    // Permission checking functions
    const hasPermission = (permission) => {
        if (currentAdmin?.role === 'super_admin') return true;

        let permissions = currentAdmin?.permissions;

        // Handle permissions as both array and object format
        if (typeof permissions === 'string') {
            try {
                permissions = JSON.parse(permissions);
            } catch (e) {
                permissions = [];
            }
        }

        if (Array.isArray(permissions)) {
            return permissions.includes(permission);
        } else if (permissions && typeof permissions === 'object') {
            return permissions[permission] === true;
        }

        return false;
    };

    if (user.status !== 'approved' && hasPermission('document_approve')) {
        baseItems.push({
            label: 'অনুমোদন',
            icon: 'pi pi-check',
            command: () => {
                approveApplication(user.id);
            }
        });
    }

    if (user.status !== 'rejected' && currentAdmin?.role === 'super_admin') {
        baseItems.push({
            label: 'বাতিল করুন',
            icon: 'pi pi-times',
            command: () => {
                rejectApplication(user.id);
            }
        });
    }

    if (user.status !== 'suspended' && currentAdmin?.role === 'super_admin') {
        baseItems.push({
            label: 'স্থগিত করুন',
            icon: 'pi pi-pause',
            command: () => {
                suspendApplication(user.id);
            }
        });
    }

    if (currentAdmin?.role === 'super_admin') {
        baseItems.push({
            label: 'আবেদন মুছুন',
            icon: 'pi pi-trash',
            command: () => {
                deleteApplication(user.id, user.full_name_bangla);
            }
        });
    }

    return baseItems;
};

const searchForm = useForm({
    search: props.filters.search || '',
    graduation_year: props.filters.graduation_year || '',
    division_filter: props.filters.division_filter || '',
    district_filter: props.filters.district_filter || '',
    thana_filter: props.filters.thana_filter || '',
    status_filter: props.filters.status_filter || '',
    blood_group_filter: props.filters.blood_group_filter || '',
    workplace_filter: props.filters.workplace_filter || '',
    department_filter: props.filters.department_filter || '',
});

const filteredDistricts = ref(props.districts);
const filteredThanas = ref(props.thanas);

const { bloodGroups, workplaces, departments } = props;

watch(() => searchForm.division_filter, (newDivision) => {
    if (newDivision) {
        filteredDistricts.value = props.districts.filter(d => d.division_id == newDivision);
        searchForm.district_filter = '';
        searchForm.thana_filter = '';
    } else {
        filteredDistricts.value = props.districts;
    }
    filteredThanas.value = [];
});
watch(() => searchForm.district_filter, (newDistrict) => {
    if (newDistrict) {
        filteredThanas.value = props.thanas.filter(t => t.district_id == newDistrict);
        searchForm.thana_filter = '';
    } else {
        filteredThanas.value = [];
    }
});

const applyFilters = () => {
    router.get(route('admin.documents.applications.index'), searchForm.data(), {
        preserveState: true,
        replace: true,
    });
};
const clearFilters = () => {
    searchForm.reset();
    router.get(route('admin.documents.applications.index'));
};

const approveApplication = (userId) => {
    if (confirm('আপনি কি নিশ্চিত যে এই আবেদনটি অনুমোদন করতে চান?')) {
        router.patch(route('admin.documents.applications.approve', userId), {}, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ preserveScroll: true });
            },
            onError: (errors) => {
                console.error('Approve failed:', errors);
                const errorMessage = errors.error || 'অনুমোদন দিতে সমস্যা হয়েছে।';
                alert(errorMessage);
            }
        });
    }
};

const rejectApplication = (userId) => {
    if (confirm('আপনি কি নিশ্চিত যে এই আবেদনটি বাতিল করতে চান?')) {
        router.patch(route('admin.documents.applications.reject', userId), {}, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ preserveScroll: true });
            },
            onError: (errors) => {
                console.error('Reject failed:', errors);
                const errorMessage = errors.error || 'বাতিল করতে সমস্যা হয়েছে।';
                alert(errorMessage);
            }
        });
    }
};

const suspendApplication = (userId) => {
    if (confirm('আপনি কি নিশ্চিত যে এই আবেদনটি স্থগিত করতে চান?')) {
        router.patch(route('admin.documents.applications.suspend', userId), {}, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ preserveScroll: true });
            },
            onError: (errors) => {
                console.error('Suspend failed:', errors);
                const errorMessage = errors.error || 'স্থগিত করতে সমস্যা হয়েছে।';
                alert(errorMessage);
            }
        });
    }
};

const deleteApplication = (userId, userName) => {
    if (confirm(`আপনি কি নিশ্চিত যে "${userName}" এর আবেদনটি স্থায়ীভাবে মুছে ফেলতে চান?\n\nএটি একটি বিপজ্জনক কাজ এবং এটি পূর্বাবস্থায় ফেরানো যাবে না।`)) {
        router.delete(route('admin.documents.applications.delete', userId), {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ preserveScroll: true });
            },
            onError: (errors) => {
                console.error('Delete failed:', errors);
                const errorMessage = errors.error || 'আবেদন মুছতে সমস্যা হয়েছে।';
                alert(errorMessage);
            }
        });
    }
};

const getStatusText = (status) => {
    const statusMap = {
        'approved': 'অনুমোদিত',
        'rejected': 'বাতিল',
        'pending': 'অপেক্ষমান',
        'suspended': 'স্থগিত'
    };
    return statusMap[status] || status;
};

const getStatusBadgeClass = (status) => {
    const classMap = {
        'approved': 'bg-green-100 text-green-800 border border-green-400 dark:bg-green-900 dark:text-green-200 dark:border-green-700',
        'rejected': 'bg-red-100 text-red-800 border border-red-400 dark:bg-red-900 dark:text-red-200 dark:border-red-700',
        'pending': 'bg-yellow-100 text-yellow-800 border border-yellow-400 dark:bg-yellow-900 dark:text-yellow-200 dark:border-yellow-700',
        'suspended': 'bg-gray-100 text-gray-800 border border-gray-400 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-500'
    };
    return classMap[status] || 'bg-gray-100 text-gray-800 border border-gray-400 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-500';
};

const onPage = (event) => {
    const params = {
        ...searchForm.data(),
        per_page: event.rows,
        page: event.page + 1
    };
    Object.keys(params).forEach(key => {
        if (params[key] === '' || params[key] === null || params[key] === undefined) {
            delete params[key];
        }
    });
    router.get(route('admin.documents.applications.index'), params, {
        preserveState: true,
        replace: true,
    });
};

const highlightMatch = (text, query) => {
    if (!query) return text;
    const re = new RegExp(`(${query})`, 'gi');
    return text?.toString().replace(re, '<mark>$1</mark>');
};
</script>

<template>
    <Head title="দস্তরবন্দি আবেদন তালিকা" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center gap-4 flex-wrap">
                <h2 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="pi pi-file-edit text-blue-500 text-lg"></i>
                    দস্তরবন্দি আবেদন তালিকা
                </h2>
                <button @click="router.reload()" class="flex items-center px-4 py-2 rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 dark:text-blue-100 dark:bg-blue-900 dark:hover:bg-blue-800 transition">
                    <i class="pi pi-refresh mr-2"></i> রিফ্রেশ
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto px-2 sm:px-6 lg:px-8">
                <div class="mb-8 rounded-lg shadow-lg bg-gradient-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 p-6 border border-blue-100 dark:border-gray-700">
                    <h3 class="mb-2 text-lg font-semibold text-blue-700 dark:text-blue-200 flex items-center gap-2">
                        <i class="pi pi-search text-blue-500"></i>
                        আবেদন খুঁজুন ও ফিল্টার করুন
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-0">
                        <div>
                            <label for="search-input" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                নাম/আইডি দিয়ে খুঁজুন
                            </label>
                            <input
                                id="search-input"
                                type="text"
                                v-model="searchForm.search"
                                placeholder="নাম অথবা রেজিস্ট্রেশন আইডি লিখুন..."
                                class="w-full rounded-lg border border-blue-200 dark:border-gray-600 bg-blue-50 dark:bg-gray-900 px-3 py-2 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:focus:border-blue-300 transition"
                                @keyup.enter="applyFilters"
                            />
                        </div>
                        <div>
                            <label for="graduation-year-select" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                পাস বছর
                            </label>
                            <select
                                id="graduation-year-select"
                                v-model="searchForm.graduation_year"
                                class="w-full rounded-lg border border-blue-200 dark:border-gray-600 bg-blue-50 dark:bg-gray-900 px-3 py-2 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:focus:border-blue-300 transition">
                                <option value="">সব বছর</option>
                                <option v-for="year in graduationYears" :key="year" :value="year">
                                    {{ year }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="status-filter-select" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                স্ট্যাটাস
                            </label>
                            <select
                                id="status-filter-select"
                                v-model="searchForm.status_filter"
                                class="w-full rounded-lg border border-blue-200 dark:border-gray-600 bg-blue-50 dark:bg-gray-900 px-3 py-2 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:focus:border-blue-300 transition">
                                <option value="">সব স্ট্যাটাস</option>
                                <option v-for="status in statusOptions" :key="status.value" :value="status.value">
                                    {{ status.label }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="division-filter-select" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                বিভাগ
                            </label>
                            <select
                                id="division-filter-select"
                                v-model="searchForm.division_filter"
                                class="w-full rounded-lg border border-blue-200 dark:border-gray-600 bg-blue-50 dark:bg-gray-900 px-3 py-2 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:focus:border-blue-300 transition">
                                <option value="">সব বিভাগ</option>
                                <option v-for="division in divisions" :key="division.id" :value="division.id">
                                    {{ division.division_name_bangla }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-3 mt-2">
                        <div>
                            <label for="district-filter-select" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                জেলা
                            </label>
                            <select
                                id="district-filter-select"
                                v-model="searchForm.district_filter"
                                class="w-full rounded-lg border border-blue-200 dark:border-gray-600 bg-blue-50 dark:bg-gray-900 px-3 py-2 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:focus:border-blue-300 transition"
                                :disabled="!searchForm.division_filter">
                                <option value="">সব জেলা</option>
                                <option v-for="district in filteredDistricts" :key="district.id" :value="district.id">
                                    {{ district.district_name_bangla }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="thana-filter-select" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                থানা
                            </label>
                            <select
                                id="thana-filter-select"
                                v-model="searchForm.thana_filter"
                                class="w-full rounded-lg border border-blue-200 dark:border-gray-600 bg-blue-50 dark:bg-gray-900 px-3 py-2 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:focus:border-blue-300 transition"
                                :disabled="!searchForm.district_filter">
                                <option value="">সব থানা</option>
                                <option v-for="thana in filteredThanas" :key="thana.id" :value="thana.id">
                                    {{ thana.thana_name_bangla }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="blood-group-filter-select" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                রক্তের গ্রুপ
                            </label>
                            <select
                                id="blood-group-filter-select"
                                v-model="searchForm.blood_group_filter"
                                class="w-full rounded-lg border border-blue-200 dark:border-gray-600 bg-blue-50 dark:bg-gray-900 px-3 py-2 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:focus:border-blue-300 transition">
                                <option value="">সব গ্রুপ</option>
                                <option v-for="bloodGroup in bloodGroups" :key="bloodGroup" :value="bloodGroup">
                                    {{ bloodGroup }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="workplace-filter-select" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                পেশা
                            </label>
                            <select
                                id="workplace-filter-select"
                                v-model="searchForm.workplace_filter"
                                class="w-full rounded-lg border border-blue-200 dark:border-gray-600 bg-blue-50 dark:bg-gray-900 px-3 py-2 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:focus:border-blue-300 transition">
                                <option value="">সব পেশা</option>
                                <option v-for="workplace in workplaces" :key="workplace" :value="workplace">
                                    {{ workplace }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="department-filter-select" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                বিভাগ
                            </label>
                            <select
                                id="department-filter-select"
                                v-model="searchForm.department_filter"
                                class="w-full rounded-lg border border-blue-200 dark:border-gray-600 bg-blue-50 dark:bg-gray-900 px-3 py-2 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:focus:border-blue-300 transition">
                                <option value="">সব বিভাগ</option>
                                <option v-for="department in departments" :key="department.value" :value="department.value">
                                    {{ department.label }}
                                </option>
                            </select>
                        </div>
                        <div class="flex md:items-end lg:items-end">
                            <div class="flex gap-2 w-full mt-6">
                                <button
                                    @click="applyFilters"
                                    class="flex-1 flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 px-4 py-2 text-sm font-medium text-white shadow transition dark:bg-blue-800 dark:hover:bg-blue-900 dark:focus:ring-blue-700">
                                    <i class="pi pi-search mr-2"></i>
                                    খুঁজুন
                                </button>
                                <button
                                    @click="clearFilters"
                                    class="flex-1 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 shadow transition hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600">
                                    <i class="pi pi-times mr-2"></i>
                                    রিসেট
                                </button>
                            </div>
                        </div>
                        <div></div>
                    </div>
                </div>
                <div class="overflow-hidden rounded-lg mt-8 bg-white dark:bg-gray-900 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-4 flex flex-col md:flex-row items-center justify-between gap-3">
                        <div class="flex flex-wrap gap-2 text-xs dark:text-gray-300">
                            <span>মোট <span class="font-semibold">{{ users.total }}</span> আবেদন</span>
                            <span v-if="users.total > 0">| পৃষ্ঠা <span class="font-semibold">{{ users.current_page }}</span> / {{ users.last_page }}</span>
                        </div>
                        <Paginator
                            :rows="users.per_page || 10"
                            :totalRecords="users.total"
                            :rowsPerPageOptions="[10, 20, 50, 100]"
                            @page="onPage"
                            :first="(users.current_page - 1) * users.per_page"
                            template="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                            :pageLinkSize="5"
                            class="p-paginator-sm"
                            showCurrentPageReport
                        />
                    </div>
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-blue-50 dark:bg-gray-800 sticky top-0 z-10">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">নাম</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">রেজিস্ট্রেশন আইডি</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">পিতার নাম</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">জন্মতারিখ</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">রক্তের গ্রুপ</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">পেশা</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">বিভাগ</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">জেলা</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">থানা</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">শিক্ষাগত বিভাগ</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">স্ট্যাটাস</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700 dark:text-blue-200">পেমেন্ট স্ট্যাটাস</th>
                                    <th class="px-4 py-3 text-right font-semibold text-blue-700 dark:text-blue-200">কার্যক্রম</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-white dark:bg-gray-900">
                                <tr v-for="user in users.data" :key="user.id" class="hover:bg-blue-50 dark:hover:bg-gray-800 transition group">
                                    <td class="whitespace-nowrap px-4 py-3 font-bold text-gray-900 dark:text-gray-100">
                                        <span v-html="highlightMatch(user.full_name_bangla, searchForm.search)"/>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200">
                                        <span class="font-mono bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-blue-600 dark:text-blue-300">{{ user.id }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200" v-html="highlightMatch(user.father_name, searchForm.search)" />
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200">{{ user.date_of_birth || 'N/A' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200">{{ user.bloodGroup || 'N/A' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200" v-html="highlightMatch(user.workplace, searchForm.search)" />
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200">{{ user.division_name || 'N/A' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200">{{ user.district_name || 'N/A' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200">{{ user.thana_name || 'N/A' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200">
                                        <div class="flex flex-wrap gap-1">
                                            <span v-if="user.dept_takmil" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 shadow">
                                                তাকমিল ({{ user.dept_takmil_year_english }})
                                            </span>
                                            <span v-if="user.dept_ifta" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 shadow">
                                                ইফতা ({{ user.dept_ifta_year_english }})
                                            </span>
                                            <span v-if="user.dept_hifz" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 shadow">
                                                হিফজ ({{ user.dept_hifz_year_english }})
                                            </span>
                                            <span v-if="user.dept_qirat" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200 shadow">
                                                কিরাআত ({{ user.dept_qirat_year_english }})
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold border"
                                            :class="getStatusBadgeClass(user.status)">
                                            {{ getStatusText(user.status) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border border-yellow-400 dark:border-yellow-700">
                                            পেন্ডিং
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-right">
                                        <SplitButton :model="items(user)" label="কার্যক্রম" icon="pi pi-bars" class="p-button-sm" />
                                    </td>
                                </tr>
                                <tr v-if="!users.data.length">
                                    <td colspan="13" class="text-center py-8 text-gray-400 dark:text-gray-500"><i class="pi pi-info-circle"></i> কোনো আবেদন পাওয়া যায়নি</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        <Paginator
                            :rows="users.per_page || 10"
                            :totalRecords="users.total"
                            :rowsPerPageOptions="[10, 20, 50, 100]"
                            @page="onPage"
                            :first="(users.current_page - 1) * users.per_page"
                            template="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                            :pageLinkSize="5"
                            class="p-paginator-sm"
                            showCurrentPageReport
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
