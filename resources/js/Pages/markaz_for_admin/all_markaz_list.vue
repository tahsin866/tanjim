<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-[#f8f9fa] min-h-screen mx-5 mt-5">
        <div class="mx-auto">
          <!-- Header Section -->
          <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
              সকল মারকাযের তালিকা
            </h1>
          </div>
          <!-- Search Panel -->
          <div>
            <!-- Filter Section -->
<div class="mt-8 bg-white rounded-lg shadow-md border border-emerald-100 overflow-hidden">
  <!-- ফিল্টার সেকশন -->
  <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 p-4 flex justify-between items-center border-b border-emerald-700">
    <h2 class="text-white text-xl font-bold flex items-center gap-3">
      <i class="fas fa-search text-amber-300"></i>
      <span class="border-r-2 border-amber-300 pr-3">অনুসন্ধান ফিল্টার</span>

    </h2>
    <div class="flex gap-3">
      <button @click="resetFilters" class="bg-emerald-700 hover:bg-emerald-600 text-white px-4 py-2 rounded-md flex items-center gap-2 transition-all duration-200 border border-emerald-500">
        <i class="fas fa-redo-alt"></i>
        রিসেট
      </button>
      <button @click="exportData" class="bg-amber-600 hover:bg-amber-500 text-white px-4 py-2 rounded-md flex items-center gap-2 transition-all duration-200 border border-amber-700">
        <i class="fas fa-download"></i>
        এক্সপোর্ট
      </button>
    </div>
  </div>

  <!-- ফিল্টার ফর্ম -->
  <div class="p-5 bg-pattern-islamic border-b border-emerald-100">
    <div class="flex flex-wrap items-center gap-6">
      <span class="p-input-icon-left w-64 relative">

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
      <div class="flex items-center gap-3">
        <label class="text-emerald-800 font-medium whitespace-nowrap flex items-center">

          মাদ্রাসার ধরন:
        </label>
        <select v-model="searchFilters.type"
          class="w-40 px-3 py-2 bg-white border border-emerald-200 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
          <option value="">সকল</option>
          <option value="ছাত্র">ছাত্র</option>
          <option value="ছাত্রী">ছাত্রী</option>
        </select>
      </div>

      <!-- মাদরাসার স্তর -->
      <div class="flex items-center gap-3">
        <label class="text-emerald-800 font-medium whitespace-nowrap flex items-center">

          মাদরাসার স্তর:
        </label>
        <select v-model="searchFilters.level"
          class="w-48 px-3 py-2 bg-white border border-emerald-200 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
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
      <div class="flex items-center gap-3">
        <label class="text-emerald-800 font-medium whitespace-nowrap flex items-center">

          মারকাযের ধরন:
        </label>
        <select v-model="searchFilters.status"
          class="w-44 px-3 py-2 bg-white border border-emerald-200 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
          <option value="">সকল</option>
          <option value="darsiyat">দরসিয়াত</option>
          <option value="hifzul_quran">হিফজুল কুরআন</option>
          <option value="ilmul_qiraat">ইলমুল কিরাআত</option>
          <option value="all">সকল মারকাজ</option>
        </select>
      </div>

      <button @click="search"
        class="px-5 py-2 bg-gradient-to-r from-emerald-700 to-emerald-600 text-white rounded-md hover:from-emerald-800 hover:to-emerald-700 flex items-center gap-2 shadow-md transition-all duration-200">
        <i class="fas fa-search"></i>
        অনুসন্ধান
      </button>
    </div>
  </div>

  <!-- ডাটা টেবিল হেডার -->
  <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 p-4 flex justify-between items-center border-b border-emerald-700">
    <h2 class="text-white text-xl font-bold flex items-center gap-3">
      <i class="fas fa-list text-amber-300"></i>
      মারকাযের তালিকা
    </h2>
    <div class="bg-emerald-700 text-amber-200 px-4 py-2 rounded-full shadow-inner border border-emerald-500 flex items-center">
      <i class="fas fa-users-viewfinder mr-2"></i>
      মোট উপাত্ত: <span class="font-bold ml-1 text-white">{{ applications.data?.length || 0 }}</span>
    </div>
  </div>

  <!-- ডাটা টেবিল -->
  <div class="p-4 bg-pattern-islamic">
    <DataTable
      :value="applications.data"
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
      :globalFilterFields="['name', 'Elhaq_no', 'MType', 'markaz_serial', 'id', 'mobile_no', 'division_name', 'district_name', 'thana_name']"
    >
      <Column field="id" header="ক্রমিক" sortable style="min-width: 5rem" headerClass="islamic-header" bodyClass="text-center">
        <template #body="{ index }">
          <div class="bg-amber-50 text-amber-800 w-8 h-8 rounded-full flex items-center justify-center mx-auto font-semibold border border-amber-200">
            {{ index + 1 }}
          </div>
        </template>
      </Column>

      <Column field="name" header="মারকাযের নাম" sortable style="min-width: 12rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <Link
            :href="route('markaz_for_admin.madrasha_list_underMarkaz', data.id)"
            class="inline-flex items-center justify-center px-3 py-1 rounded-md bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-all duration-200 border border-emerald-200"
            title="View Details"
          >
            <i class="fas fa-mosque text-xs mr-2 text-amber-600"></i>
            {{ data.name }}
          </Link>
        </template>
      </Column>

      <Column field="Elhaq_no" header="এলহাক নং" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <div class="font-arabic">{{ data.Elhaq_no }}</div>
        </template>
      </Column>

      <Column field="MType" header="মাদ্রাসার ধরন" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <span
            :class="{
              'bg-blue-50 text-blue-700 border-blue-200': data.MType === 'ছাত্র',
              'bg-pink-50 text-pink-700 border-pink-200': data.MType === 'ছাত্রী'
            }"
            class="px-3 py-1 rounded-md border inline-block"
          >
            {{ data.MType }}
          </span>
        </template>
      </Column>

      <Column field="markaz_serial" header="মারকাজ সিরিয়াল" sortable style="min-width: 10rem" headerClass="islamic-header" bodyClass="text-center">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <span class="font-mono bg-gray-100 px-2 py-1 rounded-md text-gray-700 border border-gray-200">{{ data.markaz_serial }}</span>
        </template>
      </Column>

      <Column field="id" header="আইডি" sortable style="min-width: 8rem" headerClass="islamic-header" bodyClass="text-center">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <span class="font-medium text-emerald-800">{{ data.id }}</span>
        </template>
      </Column>

      <Column field="mobile_no" header="মোবাইল নম্বর" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel, filterCallback }">
          <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="w-full rounded-md" />
        </template>
        <template #body="{ data }">
          <div class="flex items-center">
            <i class="fas fa-phone-alt text-emerald-600 mr-2"></i>
            <span>{{ data.mobile_no }}</span>
          </div>
        </template>
      </Column>

      <Column field="division_name" header="বিভাগ" sortable style="min-width: 10rem" headerClass="islamic-header">
        <template #filter="{ filterModel }">
          <Dropdown
            v-model="filterModel.value"
            :options="divisions"
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

      <Column header="করনীয়" style="min-width: 10rem" headerClass="islamic-header" bodyClass="text-center">
        <template #body="{ data }">
          <SplitButton
            label="বিস্তারিত"
            icon="fas fa-eye"
            size="small"
            class="p-button-sm p-button-rounded "
            @click="viewApplication(data)"
            :model="getActionOptions(data)"
          />
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



</div>



        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { ref, reactive, onMounted, computed } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';
import SplitButton from 'primevue/splitbutton';


// Define FilterMatchMode constants
const FilterMatchMode = {
  STARTS_WITH: 'startswith',
  CONTAINS: 'contains',
  EQUALS: 'equals',
  DATE_IS: 'dateIs'
};

// Props
const props = defineProps({
  initialApplications: Object,
  initialDivisions: Array,
  initialDistricts: Array,
  initialThanas: Array,
});

// State Management
const applications = ref(props.initialApplications || {
  data: [],
  current_page: 1,
  last_page: 1,
  total: 0,
  from: 0,
  to: 0
});
const loading = ref(false);
const perPage = ref(10);
const divisions = ref(props.initialDivisions || []);
const districts = ref(props.initialDistricts || []);
const thanas = ref(props.initialThanas || []);

// For table column filters
const tableFilterDistricts = ref([]);
const tableFilterThanas = ref([]);
const selectedTableDivision = ref(null);
const selectedTableDistrict = ref(null);

// Filters
const filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.CONTAINS },
  Elhaq_no: { value: null, matchMode: FilterMatchMode.CONTAINS },
  MType: { value: null, matchMode: FilterMatchMode.CONTAINS },
  markaz_serial: { value: null, matchMode: FilterMatchMode.CONTAINS },
  id: { value: null, matchMode: FilterMatchMode.CONTAINS },
  mobile_no: { value: null, matchMode: FilterMatchMode.CONTAINS },
  division_name: { value: null, matchMode: FilterMatchMode.EQUALS },
  district_name: { value: null, matchMode: FilterMatchMode.EQUALS },
  thana_name: { value: null, matchMode: FilterMatchMode.EQUALS },
});

// Search filters for the top filter section
const searchFilters = reactive({
  madrasahName: '',
  type: '',
  level: '',
  status: '',
  division: '',
  district: '',
  thana: ''
});



const getActionOptions = (data) => {
  return [
    {
      label: 'মেসেজিং',
      icon: 'fas fa-envelope',
      command: () => editApplication(data)
    },
    {
      label: 'স্থগিত',
      icon: 'fas fa-pause-circle',
      command: () => suspendApplication(data)
    },
    {
      label: 'এলার্ট মেসেজ',
      icon: 'fas fa-exclamation-triangle',
      command: () => sendAlertMessage(data)
    },
    {
      label: 'বাতিল',
      icon: 'fas fa-times-circle',
      command: () => cancelApplication(data)
    }
  ];
};





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
  searchFilters.district = '';
  searchFilters.thana = '';
  districts.value = [];
  thanas.value = [];
  if (searchFilters.division) {
    try {
      const response = await axios.get(`/api/districts/${searchFilters.division}`);
      districts.value = response.data;
    } catch (error) {
      console.error('Error loading districts:', error);
    }
  }
};

const handleDistrictChange = async () => {
  searchFilters.thana = '';
  thanas.value = [];
  if (searchFilters.district) {
    try {
      const response = await axios.get(`/api/thanas/${searchFilters.district}`);
      thanas.value = response.data;
    } catch (error) {
      console.error('Error loading thanas:', error);
    }
  }
};

// Table column filter handlers
const handleTableDivisionChange = async (event, filterModel) => {
  selectedTableDivision.value = event.value;
  tableFilterDistricts.value = [];
  tableFilterThanas.value = [];

  if (event.value) {
    try {
      // Find division ID from name
      const division = divisions.value.find(d => d.Division === event.value);
      if (division) {
        const response = await axios.get(`/api/districts/${division.id}`);
        tableFilterDistricts.value = response.data;
      }
    } catch (error) {
      console.error('Error loading districts for table filter:', error);
    }
  }

  filterModel.value = event.value;
};

const handleTableDistrictChange = async (event, filterModel) => {
  selectedTableDistrict.value = event.value;
  tableFilterThanas.value = [];

  if (event.value) {
    try {
      // Find district ID from name
      const district = tableFilterDistricts.value.find(d => d.District === event.value);
      if (district) {
        const response = await axios.get(`/api/thanas/${district.DesID}`);
        tableFilterThanas.value = response.data;
      }
    } catch (error) {
      console.error('Error loading thanas for table filter:', error);
    }
  }

  filterModel.value = event.value;
};

const fetchMadrasaData = async () => {
  loading.value = true;
  try {
    const response = await axios.get('/api/markaz-list', {
      params: {
        page: applications.value.current_page,
        per_page: perPage.value,
        ...searchFilters
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
const search = () => {
  loading.value = true;
  // Trim search term
  if (searchFilters.madrasahName) {
    searchFilters.madrasahName = searchFilters.madrasahName.trim();
  }

  axios.get('/api/madrashas/filter', {
    params: searchFilters
  })
  .then(response => {
    const data = response.data;
    // Data mapping and suggestion logic
    let formattedData = data;

    // Sort suggestions if search term exists
    if (searchFilters.madrasahName && formattedData.length > 0) {
      const searchTerm = searchFilters.madrasahName.toLowerCase();

      formattedData.sort((a, b) => {
        const aName = ((a.name || a.MName) || '').toLowerCase();
        const bName = ((b.name || b.MName) || '').toLowerCase();

        // Exact match first
        if (aName === searchTerm && bName !== searchTerm) return -1;
        if (bName === searchTerm && aName !== searchTerm) return 1;

        // Starts with match second priority
        if (aName.startsWith(searchTerm) && !bName.startsWith(searchTerm)) return -1;
        if (bName.startsWith(searchTerm) && !aName.startsWith(searchTerm)) return 1;

        // Contains match third priority
        if (aName.includes(searchTerm) && !bName.includes(searchTerm)) return -1;
        if (bName.includes(searchTerm) && !aName.includes(searchTerm)) return 1;

        // Alphabetical sort otherwise
        return aName.localeCompare(bName);
      });
    }

    // Data mapping - ensure correct field names
    formattedData = formattedData.map(item => {
      return {
        id: item.id,
        name: item.name || item.MName,
        Elhaq_no: item.Elhaq_no || item.ElhaqNo,
        MType: item.type || item.MType,
        markaz_serial: item.markaz_serial || item.CenterSL,
        mobile_no: item.mobile_no || item.Mobile || item.MobileNo,
        division_name: item.division_name,
        district_name: item.district_name,
        thana_name: item.thana_name,
      };
    });

    applications.value = {
      data: formattedData,
      total: formattedData.length
    };
  })
  .catch(error => {
    console.error('Error filtering madrasas:', error);
  })
  .finally(() => {
    loading.value = false;
  });
};

const resetFilters = () => {
  Object.keys(searchFilters).forEach(key => {
    searchFilters[key] = '';
  });

  // Reset DataTable filters
  filters.value = {
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: { value: null, matchMode: FilterMatchMode.CONTAINS },
    Elhaq_no: { value: null, matchMode: FilterMatchMode.CONTAINS },
    MType: { value: null, matchMode: FilterMatchMode.CONTAINS },
    markaz_serial: { value: null, matchMode: FilterMatchMode.CONTAINS },
    id: { value: null, matchMode: FilterMatchMode.CONTAINS },
    mobile_no: { value: null, matchMode: FilterMatchMode.CONTAINS },
    division_name: { value: null, matchMode: FilterMatchMode.EQUALS },
    district_name: { value: null, matchMode: FilterMatchMode.EQUALS },
    thana_name: { value: null, matchMode: FilterMatchMode.EQUALS },
  };

  districts.value = [];
  thanas.value = [];
  tableFilterDistricts.value = [];
  tableFilterThanas.value = [];
  selectedTableDivision.value = null;
  selectedTableDistrict.value = null;

  search();
};

const exportData = async () => {
  try {
    const response = await axios.get('/api/export-madrasa', {
      params: searchFilters,
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

<style scoped>
:deep(.p-datatable .p-datatable-header) {
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  padding: 1rem;
}

:deep(.p-datatable .p-datatable-thead > tr > th) {
  background: #f8f9fa;
  color: #495057;
  font-weight: 600;
  padding: 0.75rem 1rem;
}

:deep(.p-datatable .p-datatable-tbody > tr) {
  background: #ffffff;
  color: #495057;
  transition: box-shadow 0.2s;
}

:deep(.p-datatable .p-datatable-tbody > tr:hover) {
  background: #f8f9fa;
}

:deep(.p-datatable .p-datatable-tbody > tr > td) {
  padding: 0.75rem 1rem;
  border: 1px solid #e9ecef;
}

:deep(.p-paginator) {
  padding: 1rem;
  background: #ffffff;
  border: 1px solid #e9ecef;
}

:deep(.p-dropdown) {
  width: 100%;
}

:deep(.p-column-filter) {
  width: 100%;
}


</style>
