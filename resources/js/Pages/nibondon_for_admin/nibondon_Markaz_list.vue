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

          <!-- Results Table with PrimeVue DataTable -->
         <div class="mt-8 bg-white rounded-lg shadow-md border border-emerald-100 overflow-hidden">
  <!-- হেডার সেকশন -->
  <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 p-4 flex justify-between items-center">
    <h2 class="text-white text-xl font-bold flex items-center gap-3">
      <i class="fas fa-moon-and-star text-amber-300"></i>
      <span class="border-r-2 border-amber-300 pr-3">আবেদন তালিকা</span>

    </h2>
    <div class="bg-emerald-700 text-amber-200 px-4 py-2 rounded-full shadow-inner border border-emerald-500 flex items-center">
      <i class="fas fa-users-viewfinder mr-2"></i>
      মোট উপাত্ত: <span class="font-bold ml-1 text-white">{{ students.length || 0 }}</span>
    </div>
  </div>

  <!-- ডাটা টেবিল -->
  <div class="p-4 bg-pattern-islamic">
    <DataTable
      :value="students"
      v-model:filters="filters"
      filterDisplay="menu"
      :loading="loading"
      dataKey="id"
      paginator
      :rows="perPage"
      :rowsPerPageOptions="[10, 20, 50, 100]"
      paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
      currentPageReportTemplate="দেখানো হচ্ছে {first} থেকে {last} মোট {totalRecords} এর মধ্যে"
      responsiveLayout="stack"
      breakpoint="960px"
      class="p-datatable-sm islamic-datatable"
      :scrollable="true"
      scrollHeight="flex"
      :resizableColumns="true"
      columnResizeMode="fit"
      showGridlines
      stripedRows
      :globalFilterFields="['madrasha_Name', 'Elhaq_no', 'exam_name_Bn', 'madrasha_code', 'Mobile', 'division_name', 'district_name', 'thana_name']"
    >
      <template #header>
        <div class="flex justify-between items-center">
          <div class="flex flex-wrap items-center gap-6">
            <span class="p-input-icon-left w-64 relative">
              <i class="pi pi-search text-emerald-600" />
              <InputText
                v-model="filters['global'].value"
                placeholder="সার্চ করুন..."
                class="w-full rounded-full border-emerald-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 pl-10"
              />
              <button
                v-if="filters['global'].value"
                @click="filters['global'].value = ''"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500"
              >
                <i class="pi pi-times"></i>
              </button>
            </span>
            <!-- মাদ্রাসার ধরন -->
          </div>
          <div class="flex items-center gap-2">
            <button class="bg-amber-50 text-amber-700 p-2 rounded-md hover:bg-amber-100 transition-all duration-200">
              <i class="pi pi-file-excel"></i>
            </button>
            <button class="bg-emerald-50 text-emerald-700 p-2 rounded-md hover:bg-emerald-100 transition-all duration-200">
              <i class="pi pi-file-pdf"></i>
            </button>
            <button class="bg-blue-50 text-blue-700 p-2 rounded-md hover:bg-blue-100 transition-all duration-200">
              <i class="pi pi-print"></i>
            </button>
          </div>
        </div>
      </template>

      <Column field="id" header="ক্রমিক নং" sortable style="min-width: 5rem" headerClass="islamic-header" bodyClass="text-center">
        <template #body="{ index }">
          <div class="bg-amber-50 text-amber-800 w-8 h-8 rounded-full flex items-center justify-center mx-auto font-semibold border border-amber-200">
            {{ index + 1 }}
          </div>
        </template>
      </Column>

      <Column field="id" header="আবেদন নং" sortable style="min-width: 8rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <span class="font-medium text-emerald-800">{{ data.id }}</span>
        </template>
      </Column>

      <Column field="madrasha_Name" header="মাদ্রাসার নাম" sortable style="min-width: 12rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <Link
            :href="route('nibondon_for_admin.abandon_stu_list', { markaz_id: data.id })"
            class="inline-flex items-center justify-center px-3 py-1 rounded-md bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-all duration-200 border border-emerald-200"
            title="View Details"
          >
            <i class="fas fa-mosque text-xs mr-2 text-amber-600"></i>
            {{ data.madrasha_Name }}
          </Link>
        </template>
      </Column>

      <Column field="Elhaq_no" header="ইলহাক নং" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <div class="font-arabic">{{ data.Elhaq_no }}</div>
        </template>
      </Column>

      <Column field="exam_name_Bn" header="কেন্দ্রীয় পরীক্ষা" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-md border border-blue-200">{{ data.exam_name_Bn }}</span>
        </template>
      </Column>

      <Column field="madrasha_code" header="কোড" sortable style="min-width: 8rem" headerClass="islamic-header" bodyClass="text-center">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <span class="font-mono bg-gray-100 px-2 py-1 rounded-md text-gray-700 border border-gray-200">{{ data.madrasha_code }}</span>
        </template>
      </Column>

      <Column field="student_count" header="ছাত্র সংখ্যা" sortable style="min-width: 8rem" headerClass="islamic-header" bodyClass="text-center">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <span class="bg-amber-50 text-amber-800 px-3 py-1 rounded-full font-medium border border-amber-200">{{ data.student_count }}</span>
        </template>
      </Column>

      <Column field="Mobile" header="ফোন নম্বর" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <div class="flex items-center">
            <i class="fas fa-phone-alt text-emerald-600 mr-2"></i>
            <span>{{ data.Mobile }}</span>
          </div>
        </template>
      </Column>

      <Column field="division_name" header="বিভাগ" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel }">
          <Dropdown
            v-model="filterModel.value"
            :options="divisionOptions"
            optionLabel="Division"
            optionValue="Division"
            placeholder="বিভাগ নির্বাচন করুন"
            class="p-column-filter w-full rounded-md"
            @change="handleTableDivisionChange($event, filterModel)"
          />
        </template>
        <template #body="{ data }">
          <div class="flex items-center">
            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
            <span>{{ data.division_name }}</span>
          </div>
        </template>
      </Column>

      <Column field="district_name" header="জেলা" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel }">
          <Dropdown
            v-model="filterModel.value"
            :options="tableFilterDistricts"
            optionLabel="District"
            optionValue="District"
            placeholder="জেলা নির্বাচন করুন"
            class="p-column-filter w-full rounded-md"
            @change="handleTableDistrictChange($event, filterModel)"
          />
        </template>
        <template #body="{ data }">
          <span>{{ data.district_name }}</span>
        </template>
      </Column>

      <Column field="thana_name" header="থানা/উপজেলা" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel }">
          <Dropdown
            v-model="filterModel.value"
            :options="tableFilterThanas"
            optionLabel="Thana"
            optionValue="Thana"
            placeholder="থানা নির্বাচন করুন"
            class="p-column-filter w-full rounded-md"
          />
        </template>
        <template #body="{ data }">
          <span>{{ data.thana_name }}</span>
        </template>
      </Column>

      <Column field="board_status" header="বোর্ড স্ট্যটাস" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <span
            :class="{
              'bg-green-50 text-green-700 border-green-200': data.board_status === 'অনুমোদিত',
              'bg-yellow-50 text-yellow-700 border-yellow-200': data.board_status === 'পেন্ডিং',
              'bg-red-50 text-red-700 border-red-200': data.board_status === 'বাতিল',
              'bg-blue-50 text-blue-700 border-blue-200': data.board_status === 'প্রক্রিয়াধীন',
              'bg-gray-50 text-gray-700 border-gray-200': !data.board_status
            }"
            class="px-3 py-1 rounded-md border inline-block"
          >
            {{ data.board_status || 'অনির্ধারিত' }}
          </span>
        </template>
      </Column>

      <Column header="একশন" style="min-width: 8rem" headerClass="islamic-header" bodyClass="text-center">
        <template #body="{ data }">
          <div class="flex items-center justify-center gap-2">
            <Link
              v-if="data?.id"
              href="route('markaz-agreements.view', data.id)"
              class="inline-flex items-center justify-center p-2 rounded-md bg-amber-50 text-amber-700 hover:bg-amber-100 transition-all duration-200 border border-amber-200"
              title="View Details"
            >
              <i class="fas fa-envelope"></i>
            </Link>
            <button
              class="inline-flex items-center justify-center p-2 rounded-md bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-all duration-200 border border-emerald-200"
              title="Print"
            >
              <i class="fas fa-print"></i>
            </button>
          </div>
        </template>
      </Column>
        <template #empty>
            <div class="text-center p-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
              <img src="/images/empty-data.svg" alt="No Data" class="w-32 h-32 mx-auto mb-4 opacity-50" />
              <p class="text-gray-500 text-lg">কোন তথ্য পাওয়া যায়নি</p>
              <p class="text-gray-400 italic">আল্লাহ্‌ সবচেয়ে ভালো জানেন</p>
            </div>
          </template>

          <template #paginatorstart>
            <div class="flex items-center gap-2">
              <button class="p-2 rounded-md bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-all duration-200 border border-emerald-200">
                <i class="pi pi-refresh"></i>
              </button>
            </div>
          </template>

          <template #paginatorend>
            <div class="text-xs text-gray-500 italic">
              সর্বশেষ হালনাগাদ: {{ new Date().toLocaleString('bn-BD') }}
            </div>
          </template>

          <template #loading>
            <div class="flex flex-col items-center justify-center p-8">
              <div class="w-16 h-16 border-4 border-emerald-200 border-t-emerald-600 rounded-full animate-spin mb-4"></div>
              <p class="text-emerald-700">তথ্য লোড হচ্ছে...</p>
            </div>
          </template>
        </DataTable>
      </div>

      <!-- ফুটার -->

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

  // PrimeVue Components
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import InputText from 'primevue/inputtext';
  import Dropdown from 'primevue/dropdown';

  // Props definition
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

  // State variables
  const students = ref([]);
  const loading = ref(true);
  const perPage = ref(10);
  const divisions = ref([]);
  const districts = ref([]);
  const thanas = ref([]);

  // Table filter variables
  const tableFilterDistricts = ref([]);
  const tableFilterThanas = ref([]);
  const selectedDivision = ref(null);
  const selectedDistrict = ref(null);

  // PrimeVue DataTable filters
  const filters = ref({
    global: { value: null, matchMode: 'contains' },
    madrasha_Name: { value: null, matchMode: 'contains' },
    Elhaq_no: { value: null, matchMode: 'contains' },
    exam_name_Bn: { value: null, matchMode: 'contains' },
    madrasha_code: { value: null, matchMode: 'contains' },
    student_count: { value: null, matchMode: 'contains' },
    Mobile: { value: null, matchMode: 'contains' },
    division_name: { value: null, matchMode: 'equals' },
    district_name: { value: null, matchMode: 'equals' },
    thana_name: { value: null, matchMode: 'equals' },
    board_status: { value: null, matchMode: 'contains' }
});

// Search filters for the top filter section
const searchFilters = ref({
  madrasahName: '',
  type: '',
  level: '',
  status: '',
  division: '',
  district: '',
  thana: ''
});

// Computed properties
const divisionOptions = computed(() => {
  return divisions.value.map(div => ({ Division: div.Division, id: div.id }));
});

// Fetch data on component mount
onMounted(() => {
  fetchStudents();
  loadDivisions();
});

// Data fetching functions
const fetchStudents = async () => {
  try {
    loading.value = true;
    const response = await axios.get('/api/markaz-students');
    students.value = response.data;
  } catch (error) {
    console.error('ডাটা লোড করতে সমস্যা হয়েছে:', error);
  } finally {
    loading.value = false;
  }
};

const loadDivisions = async () => {
  try {
    const response = await axios.get('/api/divisions');
    divisions.value = response.data;
  } catch (error) {
    console.error('Error loading divisions:', error);
  }
};

// Filter handling functions
const handleTableDivisionChange = async (event, filterModel) => {
  const divisionName = event.value;
  const division = divisions.value.find(d => d.Division === divisionName);

  if (division) {
    try {
      const response = await axios.get(`/api/districts/${division.id}`);
      tableFilterDistricts.value = response.data;
      // Reset district and thana filters
      filters.value.district_name.value = null;
      filters.value.thana_name.value = null;
      tableFilterThanas.value = [];
    } catch (error) {
      console.error('Error loading districts:', error);
    }
  } else {
    tableFilterDistricts.value = [];
    tableFilterThanas.value = [];
  }
};

const handleTableDistrictChange = async (event, filterModel) => {
  const districtName = event.value;
  const district = tableFilterDistricts.value.find(d => d.District === districtName);

  if (district) {
    try {
      const response = await axios.get(`/api/thanas/${district.DesID}`);
      tableFilterThanas.value = response.data;
      // Reset thana filter
      filters.value.thana_name.value = null;
    } catch (error) {
      console.error('Error loading thanas:', error);
    }
  } else {
    tableFilterThanas.value = [];
  }
};

// Search function for the top filter section
const search = () => {
  loading.value = true;

  // Trim search term
  if (searchFilters.value.madrasahName) {
    searchFilters.value.madrasahName = searchFilters.value.madrasahName.trim();
  }

  axios.get('/api/filter-markaz-students', {
    params: searchFilters.value
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

// Reset filters
const resetFilters = () => {
  // Reset PrimeVue DataTable filters
  Object.keys(filters.value).forEach(key => {
    if (key !== 'global') {
      filters.value[key].value = null;
    } else {
      filters.value[key].value = null;
    }
  });

  // Reset search filters
  Object.keys(searchFilters.value).forEach(key => {
    searchFilters.value[key] = '';
  });

  // Reset dropdown data
  tableFilterDistricts.value = [];
  tableFilterThanas.value = [];

  // Fetch all data again
  fetchStudents();
};

// Export data function
const exportData = () => {
  // Implement export functionality here
  console.log('Exporting data...');
};

// View and edit functions
const viewApplication = (data) => {
  // Implement view functionality
  console.log('Viewing application:', data);
};

const editApplication = (data) => {
  // Implement edit functionality
  console.log('Editing application:', data);
};
</script>

<style scoped>
/* Custom styles for PrimeVue components */
:deep(.p-datatable-header) {
  background-color: white;
  border: none;
  padding: 1rem;
}

:deep(.p-datatable .p-datatable-thead > tr > th) {
  background-color: #f8f9fa;
  color: #495057;
  font-weight: 600;
  padding: 0.75rem 1rem;
}

:deep(.p-datatable .p-datatable-tbody > tr) {
  transition: background-color 0.2s;
}

:deep(.p-datatable .p-datatable-tbody > tr:hover) {
  background-color: #f1f5f9;
}

:deep(.p-dropdown) {
  width: 100%;
}

:deep(.p-column-filter) {
  width: 100%;
}

:deep(.p-paginator) {
  padding: 1rem;
  background-color: #f8f9fa;
}

:deep(.p-paginator .p-paginator-current) {
  margin-left: auto;
}

:deep(.p-datatable.p-datatable-sm .p-datatable-header) {
  padding: 0.5rem 1rem;
}

:deep(.p-datatable.p-datatable-sm .p-datatable-thead > tr > th) {
  padding: 0.5rem 1rem;
}

:deep(.p-datatable.p-datatable-sm .p-datatable-tbody > tr > td) {
  padding: 0.5rem 1rem;
}

:deep(.p-datatable.p-datatable-sm .p-datatable-tfoot > tr > td) {
  padding: 0.5rem 1rem;
}

:deep(.p-datatable.p-datatable-sm .p-datatable-footer) {
  padding: 0.5rem 1rem;
}
</style>

