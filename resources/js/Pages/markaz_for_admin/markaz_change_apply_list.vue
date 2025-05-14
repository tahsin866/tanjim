<template>
  <AuthenticatedLayout>
    <div class="mt-5 mx-5">
      <div class="card shadow-4 border-round-xl p-4" style="background-color: #f8f9fa; box-shadow: 0 4px 8px rgba(0, 128, 0, 0.1);">
        <div class="card-header border-round-top-xl mb-3 p-3" style="background-color: #0B4D2F; color: white;">
          <h2 class="text-xl font-bold m-0 text-center">
            <i class="pi pi-book mr-2"></i>মারকাজ পরিবর্তনের আবেদন তালিকা
          </h2>
        </div>
        <div class="flex justify-content-between align-items-center mb-4">
          <div class="p-input-icon-left">
            <i class="pi pi-search" />
            <InputText v-model="filters.global.value" placeholder="গ্লোবাল সার্চ..." class="border-green-500" />
          </div>
          <Button
            label="রিসেট ফিল্টার"
            icon="pi pi-filter-slash"
            class="p-button-success p-button-outlined mx-5"
            @click="resetFilters"
          />
        </div>
        <DataTable
          :value="markazChanges"
          :paginator="true"
          :rows="10"
          :rowsPerPageOptions="[5, 10, 20, 50]"
          dataKey="id"
          :filters="filters"
          filterDisplay="menu"
          :loading="loading"
          paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
          currentPageReportTemplate="দেখানো হচ্ছে {first} থেকে {last} মোট {totalRecords} এর মধ্যে"
          responsiveLayout="scroll"
          class="p-datatable-sm"
          stripedRows
          showGridlines
          rowHover
          style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;"
        >
          <Column field="madrasha_name" header="মাদরাসার নাম" :sortable="true" :filter="true" filterMatchMode="contains" filterField="madrasha_name">
            <template #filter="{ filterModel, filterCallback }">
              <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="p-column-filter w-full" />
            </template>
          </Column>
          <Column field="asking_madrasha" header="কাঙ্খিত মারকাযের নাম" :sortable="true" :filter="true" filterMatchMode="contains" filterField="asking_madrasha">
            <template #filter="{ filterModel, filterCallback }">
              <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="p-column-filter w-full" />
            </template>
          </Column>
          <Column field="madrasha_code" header="মাদরাসার কোড" :sortable="true" :filter="true" filterMatchMode="contains" filterField="madrasha_code">
            <template #filter="{ filterModel, filterCallback }">
              <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." class="p-column-filter w-full" />
            </template>
          </Column>
          <Column
            field="markaz_type"
            header="মারকায টাইপ"
            :sortable="true"
            :filter="true"
            filterMatchMode="equals"
            style="min-width: 12rem">
            <template #body="slotProps">
              <span
                :class="{
                  'bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full text-xs font-medium shadow-sm border border-blue-200': slotProps.data.markaz_type === 'কিরাআত',
                  'bg-green-100 text-green-800 px-3 py-1.5 rounded-full text-xs font-medium shadow-sm border border-green-200': slotProps.data.markaz_type === 'দারসিয়াত',
                  'bg-purple-100 text-purple-800 px-3 py-1.5 rounded-full text-xs font-medium shadow-sm border border-purple-200': slotProps.data.markaz_type === 'হিফজুল কোরাআন',
                  'bg-gray-100 text-gray-800 px-3 py-1.5 rounded-full text-xs font-medium shadow-sm border border-gray-200': !slotProps.data.markaz_type
                }"
              >
                <i
                  :class="{
                    'pi pi-book mr-1': slotProps.data.markaz_type === 'কিরাআত',
                    'pi pi-bookmark mr-1': slotProps.data.markaz_type === 'দারসিয়াত',
                    'pi pi-file-edit mr-1': slotProps.data.markaz_type === 'হিফজুল কোরাআন',
                    'pi pi-question-circle mr-1': !slotProps.data.markaz_type
                  }"
                ></i>
                {{ slotProps.data.markaz_type || 'অনির্ধারিত' }}
              </span>
            </template>
            <template #filter="{ filterModel }">
              <Dropdown
                v-model="filterModel.value"
                :options="markazTypes"
                placeholder="সিলেক্ট করুন"
                class="p-column-filter w-full"
                showClear
              />
            </template>
          </Column>
          <Column field="created_at" header="আবেদনের সময়" :sortable="true" :filter="true" filterMatchMode="dateIs" filterField="created_at" style="min-width: 10rem">
            <template #filter="{ filterModel, filterCallback }">
              <Calendar v-model="filterModel.value" dateFormat="dd/mm/yy" placeholder="তারিখ দিয়ে ফিল্টার করুন" @date-select="filterCallback()" class="w-full border-green-200" />
            </template>
            <template #body="slotProps">
              <span class="text-green-700">{{ formatDate(slotProps.data.created_at) }}</span>
            </template>
          </Column>
          <Column header="বিস্তারিত দেখুন" style="min-width: 8rem">
            <template #body="slotProps">
              <SplitButton
                label="বিস্তারিত দেখুন"
                icon="pi pi-cog"
                :model="getActionItems(slotProps.data)"
                style="font-family: 'Merriweather','SolaimanLipi',sans-serif;"
              />
            </template>
          </Column>
        </DataTable>
        <div class="text-center mt-3 text-green-800 text-sm">
          <i class="pi pi-info-circle mr-2"></i>মারকাজ পরিবর্তনের আবেদন সম্পর্কিত তথ্য
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import SplitButton from 'primevue/splitbutton';
import Dropdown from 'primevue/dropdown';
import Calendar from 'primevue/calendar';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';

const FilterMatchMode = {
  STARTS_WITH: 'startsWith',
  CONTAINS: 'contains',
  EQUALS: 'equals',
  DATE_IS: 'dateIs'
};

// State definitions
const markazChanges = ref([]);
const loading = ref(true);

// Markaz type options
const markazTypes = ref([
  'কিরাআত',
  'দারসিয়াত',
  'হিফজুল কোরাআন'
]);

// Filter data
const filters = ref({
  global: { value: null, matchMode: 'contains' },
  madrasha_name: { value: null, matchMode: 'contains' },
  asking_madrasha: { value: null, matchMode: 'contains' },
  madrasha_code: { value: null, matchMode: 'contains' },
  markaz_type: { value: null, matchMode: 'equals' },
  created_at: { value: null, matchMode: 'dateIs' }
});

// Reset filter function
const resetFilters = () => {
  filters.value.global.value = null;
  filters.value.madrasha_name.value = null;
  filters.value.asking_madrasha.value = null;
  filters.value.madrasha_code.value = null;
  filters.value.markaz_type.value = null;
  filters.value.created_at.value = null;
};

// Date formatting
const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('bn-BD', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  }).format(date);
};

// Action button options
const getActionItems = (data) => {
  return [
    {
      label: 'অনুমোদন',
      icon: 'pi pi-check',
      command: () => handleAction('accept', data.id)
    },
    {
      label: 'ফেরত',
      icon: 'pi pi-reply',
      command: () => handleAction('return', data.id)
    },
    {
      label: 'বাতিল',
      icon: 'pi pi-times',
      command: () => handleAction('reject', data.id)
    },
    {
      label: 'স্থগিত',
      icon: 'pi pi-pause',
      command: () => handleAction('hold', data.id)
    }
  ];
};

// Action handler
const handleAction = (action, id) => {
  console.log(`Action: ${action}, ID: ${id}`);

  // API call to update the status
  axios.post(`/api/markaz-change/${id}/${action}`)
    .then(response => {
      // Handle success
      loadMarkazChanges(); // Reload data after action
    })
    .catch(error => {
      // Handle error
      console.error('Error performing action:', error);
    });
};

// Load data from database
const loadMarkazChanges = async () => {
  try {
    loading.value = true;
    const response = await axios.get('/api/markaz-changes');
    markazChanges.value = response.data;
  } catch (error) {
    console.error('Error loading markaz changes:', error);
  } finally {
    loading.value = false;
  }
};

// Lifecycle hook
onMounted(() => {
  loadMarkazChanges();
});
</script>
