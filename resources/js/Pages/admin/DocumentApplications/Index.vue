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
  <AuthenticatedLayout style="font-family: 'SolaimanLipi', sans-serif;">
    <div class="min-h-screen bg-gray-100 py-6 px-3">
      <div class=" mx-auto">
        <!-- Card -->
        <div class="rounded-xl shadow-lg border bg-white">
          <!-- Card Header -->
          <div class="rounded-t-xl px-6 py-4 bg-blue-600 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg flex items-center gap-2">
              <i class="pi pi-file-edit"></i>
              দস্তরবন্দি আবেদন তালিকা
            </h3>
            <span class="bg-white text-blue-600 font-bold rounded px-4 py-1 shadow">
              মোট: {{ users.total }} আবেদন
            </span>
          </div>
          <!-- Filter/Search Bar -->
          <div class="border-b px-6 py-4 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
              <input type="text" v-model="searchForm.search" placeholder="নাম/আইডি..." class="rounded border-gray-300 px-3 py-2 bg-white shadow-sm focus:ring-2 focus:ring-blue-200 text-sm" @keyup.enter="applyFilters">

              <select v-model="searchForm.graduation_year" class="rounded border-gray-300 px-3 py-2 bg-white shadow-sm text-sm">
                <option value="">সব বছর</option>
                <option v-for="year in graduationYears" :key="year" :value="year">{{ year }}</option>
              </select>

              <select v-model="searchForm.status_filter" class="rounded border-gray-300 px-3 py-2 bg-white shadow-sm text-sm">
                <option value="">সব স্ট্যাটাস</option>
                <option v-for="status in statusOptions" :key="status.value" :value="status.value">{{ status.label }}</option>
              </select>

              <select v-model="searchForm.division_filter" class="rounded border-gray-300 px-3 py-2 bg-white shadow-sm text-sm">
                <option value="">সব বিভাগ</option>
                <option v-for="division in divisions" :key="division.id" :value="division.id">{{ division.division_name_bangla }}</option>
              </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
              <select v-model="searchForm.district_filter" :disabled="!searchForm.division_filter" class="rounded border-gray-300 px-3 py-2 bg-white shadow-sm text-sm">
                <option value="">সব জেলা</option>
                <option v-for="district in filteredDistricts" :key="district.id" :value="district.id">{{ district.district_name_bangla }}</option>
              </select>
              <select v-model="searchForm.thana_filter" :disabled="!searchForm.district_filter" class="rounded border-gray-300 px-3 py-2 bg-white shadow-sm text-sm">
                <option value="">সব থানা</option>
                <option v-for="thana in filteredThanas" :key="thana.id" :value="thana.id">{{ thana.thana_name_bangla }}</option>
              </select>
              <select v-model="searchForm.blood_group_filter" class="rounded border-gray-300 px-3 py-2 bg-white shadow-sm text-sm">
                <option value="">সব গ্রুপ</option>
                <option v-for="bloodGroup in bloodGroups" :key="bloodGroup" :value="bloodGroup">{{ bloodGroup }}</option>
              </select>
              <select v-model="searchForm.workplace_filter" class="rounded border-gray-300 px-3 py-2 bg-white shadow-sm text-sm">
                <option value="">সব পেশা</option>
                <option v-for="workplace in workplaces" :key="workplace" :value="workplace">{{ workplace }}</option>
              </select>
            </div>
            <div class="flex gap-2 mt-4">
              <button @click="applyFilters" class="px-6 py-2 bg-blue-600 text-white rounded font-semibold shadow hover:bg-blue-700 flex items-center gap-1">
                <i class="pi pi-search"></i> খুঁজুন
              </button>
              <button @click="clearFilters" class="px-6 py-2 bg-gray-200 text-gray-700 rounded font-semibold shadow hover:bg-gray-300 flex items-center gap-1">
                <i class="pi pi-times"></i> রিসেট
              </button>
            </div>
          </div>
          <!-- Data Table -->
          <div class="overflow-x-auto px-4 py-4">
            <table class="min-w-full table-auto border rounded-lg shadow-sm">
              <thead class="bg-blue-50">
                <tr>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">ছবি</th>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">নাম</th>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">রেজিস্ট্রেশন আইডি</th>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">পিতার নাম</th>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">জন্মতারিখ</th>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">জেলা</th>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">থানা</th>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">শিক্ষাগত বিভাগ</th>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">স্ট্যাটাস</th>
                  <th class="px-4 py-2 text-left font-medium text-gray-600 whitespace-nowrap">পেমেন্ট স্ট্যাটাস</th>
                  <th class="px-4 py-2 text-right font-medium text-gray-600 whitespace-nowrap">কার্যক্রম</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-100">
                <tr v-for="user in users.data.filter(u => u.status !== 'approved')" :key="user.id" class="hover:bg-blue-50 transition">
                  <td class="px-4 py-3">
                    <div class="flex items-center justify-center">
                      <img v-if="user.photo"
                        :src="`/storage/${user.photo}`"
                        :alt="user.full_name_bangla"
                        class="h-10 w-10 rounded-full object-cover border border-gray-300"
                        @error="$event.target.style.display='none'; $event.target.nextElementSibling.style.display='flex';">
                      <div v-else class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center border border-gray-300">
                        <i class="pi pi-user text-gray-400 text-lg"></i>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap">
                    <span v-html="highlightMatch(user.full_name_bangla, searchForm.search)" />
                  </td>
                  <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                    <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ user.id }}</span>
                  </td>
                  <td class="px-4 py-3 text-gray-600 whitespace-nowrap" v-html="highlightMatch(user.father_name, searchForm.search)" />
                  <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ user.date_of_birth || 'N/A' }}</td>
                  <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ user.district_name || 'N/A' }}</td>
                  <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ user.thana_name || 'N/A' }}</td>
                  <td class="px-4 py-3 whitespace-nowrap">
                    <div class="flex flex-wrap gap-1">
                      <span v-if="user.dept_takmil" class="px-2 py-1 rounded bg-blue-600 text-white text-xs font-semibold">তাকমিল ({{ user.dept_takmil_year_english }})</span>
                      <span v-if="user.dept_ifta" class="px-2 py-1 rounded bg-green-600 text-white text-xs font-semibold">ইফতা ({{ user.dept_ifta_year_english }})</span>
                      <span v-if="user.dept_hifz" class="px-2 py-1 rounded bg-purple-600 text-white text-xs font-semibold">হিফজ ({{ user.dept_hifz_year_english }})</span>
                      <span v-if="user.dept_qirat" class="px-2 py-1 rounded bg-yellow-400 text-gray-900 text-xs font-semibold">কিরাআত ({{ user.dept_qirat_year_english }})</span>
                    </div>
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold"
                      :class="getStatusBadgeClass(user.status)">
                      {{ getStatusText(user.status) }}
                    </span>
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">পেন্ডিং</span>
                  </td>
                  <td class="px-4 py-3 text-right whitespace-nowrap">
                    <SplitButton :model="items(user)" label="" icon="pi pi-ellipsis-v" class=" text-white rounded py-1 px-2  transition" />
                  </td>
                </tr>
                <tr v-if="!users.data.filter(u => u.status !== 'approved').length">
                  <td colspan="11" class="px-4 py-8 text-center text-gray-500"><i class="pi pi-info-circle mr-1"></i> কোনো আবেদন পাওয়া যায়নি</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Paginator -->
          <div class="flex justify-between items-center px-6 py-4 border-t bg-gray-50 rounded-b-xl">
            <div class="text-gray-600 text-sm">
              <span>মোট <span class="font-bold text-gray-800">{{ users.total }}</span> আবেদন</span>
              <span v-if="users.total > 0" class="ml-2">| পৃষ্ঠা <span class="font-bold text-gray-800">{{ users.current_page }}</span> / {{ users.last_page }}</span>
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
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<style>
.adminlte-content-wrapper {
  background: #ecf0f5;
  min-height: 100vh;
}
.adminlte-card {
  border-radius: 0.7rem;
  box-shadow: 0 3px 16px rgba(44,62,80,.10);
  margin-bottom: 2rem;
}
.adminlte-card-header {
  border-radius: 0.7rem 0.7rem 0 0;
  border-bottom: 1px solid #dee2e6;
  box-shadow: 0 2px 6px rgba(44,62,80,.09);
}
.adminlte-card-body {
  border-radius: 0 0 0.7rem 0.7rem;
  background: #fff;
}
.adminlte-searchbar {
  border-radius: 0.5rem;
  background: #f8fafc;
}
.adminlte-table-wrapper {
  border-radius: 0.5rem;
  background: #fff;
  overflow-x: auto;
}
.adminlte-table th, .adminlte-table td {
  vertical-align: middle !important;
  text-align: center;
}
.adminlte-table th {
  font-size: 1rem;
  font-weight: 500;
}
.adminlte-table tbody tr:hover {
  background: #eaf5ff;
  transition: background 0.12s;
}
.adminlte-avatar {
  background: #f4f6f9;
  box-shadow: 0 1px 3px rgba(44,62,80,.10);
}
.bg-purple {
  background-color: #6f42c1 !important;
  color: #fff !important;
}
.badge {
  border-radius: 0.5em !important;
  font-size: 0.97em !important;
  padding: 0.45em 0.8em !important;
}
.badge-pill {
  border-radius: 1em !important;
}
.fs-6 { font-size: 1rem !important; }
.gap-1 { gap: 0.25rem !important; }
.gap-2 { gap: 0.5rem !important; }
.bg-warning-subtle {
  background: #fff9db !important;
}
.text-warning-emphasis {
  color: #f59e42 !important;
}
.adminlte-paginator {
  border-top: 1px solid #dee2e6;
  padding-top: 1rem;
}
</style>