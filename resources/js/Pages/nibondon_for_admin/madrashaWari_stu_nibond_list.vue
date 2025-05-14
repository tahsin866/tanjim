<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-[#f8f9fa] min-h-screen mx-5 mt-5">
        <!-- Header -->
        <div class="bg-[#2d6a4f] text-white p-4 rounded-sm shadow-md mb-4">
          <h1 class="text-2xl font-semibold text-center">
            {{ students.length > 0 ? students[0].current_madrasha : '' }} : ছাত্র তালিকা
          </h1>
        </div>

        <!-- Statistics -->
        <div class="flex space-x-4 mb-6">
          <div class="bg-yellow-500 text-white p-1 rounded-sm shadow-md">মোট ছাত্র: ১০০</div>
          <div class="bg-green-500 text-white p-1 rounded-sm shadow-md">উত্তীর্ণ: ৭০</div>
          <div class="bg-red-500 text-white p-1 rounded-sm shadow-md">অনুত্তীর্ণ: ৩০</div>
        </div>

        <!-- Student Table with PrimeVue -->
    <div class="card shadow-lg rounded-lg overflow-hidden border border-gray-200">
  <DataTable
    :value="students"
    :paginator="true"
    :rows="10"
    :rowsPerPageOptions="[5, 10, 20, 50]"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
    currentPageReportTemplate="মোট {totalRecords} ছাত্রের মধ্যে {first} থেকে {last} পর্যন্ত দেখানো হচ্ছে"
    responsiveLayout="scroll"
    :globalFilterFields="['name_bn', 'current_class', 'id', 'father_name_bn', 'mother_name_bn', 'status']"
    v-model:filters="filters"
    filterDisplay="menu"
    class="p-datatable-md"
    stripedRows
    rowHover

  >
    <template #header>
      <div class="flex justify-between items-center p-3 bg-gradient-to-r from-blue-50 to-indigo-50">
        <h2 class="text-2xl font-bold text-indigo-800 flex items-center">
          <i class="pi pi-users mr-2 text-indigo-600"></i>
          ছাত্র তথ্য তালিকা
        </h2>
        <span class="p-input-icon-left p-input-icon-right">
          <i class="pi pi-search text-indigo-500" />
          <InputText
            v-model="filters['global'].value"
            placeholder="সার্চ করুন..."
            class="p-inputtext-sm rounded-full border-indigo-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
          />
          <i class="pi pi-times cursor-pointer text-gray-500 hover:text-red-500"
             v-if="filters['global'].value"
             @click="filters['global'].value = ''" />
        </span>
      </div>
    </template>

    <Column field="index" header="#" :sortable="true" headerClass="bg-indigo-50 text-indigo-800" bodyClass="text-center">
      <template #body="slotProps">
        <span class="font-semibold text-gray-700">{{ slotProps.index + 1 }}</span>
      </template>
    </Column>

    <Column field="student_image" header="ছবি" headerClass="bg-indigo-50 text-indigo-800" bodyClass="text-center py-2">
      <template #body="slotProps">
        <div class="flex justify-center">
          <img
            v-if="slotProps.data.student_image"
            :src="'/storage/' + slotProps.data.student_image"
            alt="Student"
            class="w-16 h-16 rounded-full border-2 border-indigo-200 shadow-md object-cover transition-transform hover:scale-110"
          />
          <div v-else class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300">
            <i class="pi pi-user text-gray-400 text-xl"></i>
          </div>
        </div>
      </template>
    </Column>

    <Column field="name_bn" header="নাম" :sortable="true" :filter="true" filterMatchMode="contains" headerClass="bg-indigo-50 text-indigo-800">
      <template #body="slotProps">
        <div class="font-medium text-gray-800">{{ slotProps.data.name_bn }}</div>
      </template>
      <template #filter="{ filterModel }">
        <InputText
          v-model="filterModel.value"
          type="text"
          class="p-column-filter w-full rounded-md"
          placeholder="নাম খুঁজুন"
        />
      </template>
    </Column>

    <Column field="current_class" header="শ্রেণি" :sortable="true" :filter="true" filterMatchMode="equals" headerClass="bg-indigo-50 text-indigo-800" bodyClass="text-center">
      <template #body="slotProps">
        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full font-medium">{{ slotProps.data.current_class }}</span>
      </template>
      <template #filter="{ filterModel }">
        <Dropdown
          v-model="filterModel.value"
          :options="classOptions"
          placeholder="সিলেক্ট করুন"
          class="p-column-filter w-full"
          showClear
        />
      </template>
    </Column>

    <Column field="id" header="রেজিস্ট্রেশন নাম্বার" :sortable="true" :filter="true" filterMatchMode="contains" headerClass="bg-indigo-50 text-indigo-800">
      <template #body="slotProps">
        <div class="font-mono text-gray-700">{{ slotProps.data.id }}</div>
      </template>
      <template #filter="{ filterModel }">
        <InputText
          v-model="filterModel.value"
          type="text"
          class="p-column-filter w-full rounded-md"
          placeholder="রেজিস্ট্রেশন নাম্বার"
        />
      </template>
    </Column>

    <Column field="Date_of_birth" header="জন্ম তারিখ" :sortable="true" headerClass="bg-indigo-50 text-indigo-800">
      <template #body="slotProps">
        <div class="text-gray-600">
          <i class="pi pi-calendar mr-1 text-indigo-400"></i>
          {{ slotProps.data.Date_of_birth }}
        </div>
      </template>
    </Column>

    <Column field="father_name_bn" header="পিতার নাম" :sortable="true" :filter="true" filterMatchMode="contains" headerClass="bg-indigo-50 text-indigo-800">
      <template #body="slotProps">
        <div class="text-gray-700">{{ slotProps.data.father_name_bn }}</div>
      </template>
      <template #filter="{ filterModel }">
        <InputText
          v-model="filterModel.value"
          type="text"
          class="p-column-filter w-full rounded-md"
          placeholder="পিতার নাম"
        />
      </template>
    </Column>

    <Column field="mother_name_bn" header="মাতার নাম" :sortable="true" :filter="true" filterMatchMode="contains" headerClass="bg-indigo-50 text-indigo-800">
      <template #body="slotProps">
        <div class="text-gray-700">{{ slotProps.data.mother_name_bn }}</div>
      </template>
      <template #filter="{ filterModel }">
        <InputText
          v-model="filterModel.value"
          type="text"
          class="p-column-filter w-full rounded-md"
          placeholder="মাতার নাম"
        />
      </template>
    </Column>

    <Column field="status" header="স্ট্যাটাস" :sortable="true" :filter="true" filterMatchMode="equals" headerClass="bg-indigo-50 text-indigo-800" bodyClass="text-center">
      <template #body="slotProps">
        <span
          :class="{
            'bg-yellow-100 text-yellow-800 px-3 py-1.5 rounded-full text-xs font-medium shadow-sm border border-yellow-200': slotProps.data.status === 'বোর্ড দাখিল',
            'bg-green-100 text-green-800 px-3 py-1.5 rounded-full text-xs font-medium shadow-sm border border-green-200': slotProps.data.status === 'অনুমোদন',
            'bg-red-100 text-red-800 px-3 py-1.5 rounded-full text-xs font-medium shadow-sm border border-red-200': slotProps.data.status === 'বোর্ড ফেরত',
            'bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full text-xs font-medium shadow-sm border border-blue-200': slotProps.data.status === 'পেন্ডিং',
            'bg-gray-100 text-gray-800 px-3 py-1.5 rounded-full text-xs font-medium shadow-sm border border-gray-200': !slotProps.data.status
          }"
        >
          <i
            :class="{
              'pi pi-check-circle mr-1': slotProps.data.status === 'অনুমোদন',
              'pi pi-clock mr-1': slotProps.data.status === 'পেন্ডিং',
              'pi pi-times-circle mr-1': slotProps.data.status === 'বোর্ড ফেরত',
              'pi pi-send mr-1': slotProps.data.status === 'বোর্ড দাখিল',
              
              'pi pi-question-circle mr-1': !slotProps.data.status
            }"
          ></i>
          {{ slotProps.data.status || 'অনির্ধারিত' }}
        </span>
      </template>
      <template #filter="{ filterModel }">
        <Dropdown
          v-model="filterModel.value"
          :options="statusOptions"
          placeholder="সিলেক্ট করুন"
          class="p-column-filter w-full"
          showClear
        />
      </template>
    </Column>

    <Column header="অ্যাকশন" headerClass="bg-indigo-50 text-indigo-800" bodyClass="text-center">
      <template #body="slotProps">
        <Link
          :href="route('nibondon_for_admin.student_detiles_For_nibondon', slotProps.data.id)"
          class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105 shadow-md"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
          বিস্তারিত দেখুন
        </Link>
      </template>
    </Column>

    <template #paginatorstart>
      <Button type="button" icon="pi pi-refresh" class="p-button-text" @click="refreshData" />
    </template>

    <template #paginatorend>
      <Button type="button" icon="pi pi-download" class="p-button-text" @click="exportCSV" />
    </template>

    <template #empty>
      <div class="text-center p-6">
        <i class="pi pi-search text-gray-400 text-5xl mb-3"></i>
        <p class="text-gray-500 text-xl">কোন ছাত্র তথ্য পাওয়া যায়নি</p>
      </div>
    </template>
  </DataTable>
</div>

      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
  import { Link } from '@inertiajs/vue3'
  import { ref, onMounted } from 'vue'
  import { defineProps } from 'vue'
  import axios from 'axios'

  // PrimeVue Components
  import DataTable from 'primevue/datatable'
  import Column from 'primevue/column'
  import InputText from 'primevue/inputtext'
  import Dropdown from 'primevue/dropdown'
  import Button from 'primevue/button'


  const FilterMatchMode = {
  STARTS_WITH: 'startsWith',
  CONTAINS: 'contains',
  EQUALS: 'equals',
  DATE_IS: 'dateIs'
};


  const props = defineProps({
    students: Array,
    madrasha_id: Number
  })

  // Options for dropdowns
  const classOptions = ref([
    'ফযিলত',
    'সানাবিয়া উলইয়া',
    'সানাবিয়া',
    'মুতাওয়াসসিতা',
    'ইবতেদাইয়া',
    'হিফজুল কোরআন',
    'ইলমুল কিরাআত'
  ])

  const statusOptions = ref([
    'অনুমোদন',
    'বোর্ড দাখিল',
    'বোর্ড ফেরত',
    'পেন্ডিং',
    'স্থগিত',
    ' অনির্ধারিত'
  ])

  // Initialize filters properly
  const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
    'name_bn': { value: null, matchMode: FilterMatchMode.CONTAINS },
    'current_class': { value: null, matchMode: FilterMatchMode.EQUALS },
    'id': { value: null, matchMode: FilterMatchMode.CONTAINS },
    'father_name_bn': { value: null, matchMode: FilterMatchMode.CONTAINS },
    'mother_name_bn': { value: null, matchMode: FilterMatchMode.CONTAINS },
    'status': { value: null, matchMode: FilterMatchMode.EQUALS }
  })

  const statusClass = (status) => {
    return status === 'উত্তীর্ণ'
      ? 'bg-green-500 text-white px-2 py-1 rounded-sm text-xs'
      : 'bg-red-500 text-white px-2 py-1 rounded-sm text-xs'
  }
  </script>

  <style scoped>
  /* PrimeVue DataTable customization */
  .p-datatable .p-datatable-thead > tr > th {
    background-color: #2d6a4f !important;
    color: white !important;
    padding: 0.75rem;
    font-weight: 600;
  }

  .p-datatable .p-datatable-tbody > tr {
    background-color: #ffffff;
    border-bottom: 1px solid #f3f4f6;
  }

  .p-datatable .p-datatable-tbody > tr > td {
    padding: 0.75rem;
    text-align: center;
  }

  .p-column-filter {
    width: 100%;
  }

  .p-dropdown.p-column-filter {
    min-width: 100%;
  }

  .p-datatable .p-paginator {
    padding: 1rem;
  }

  .p-datatable .p-datatable-header {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-bottom: none;
    padding: 1rem;
    font-weight: 700;
  }

  .p-datatable .p-datatable-footer {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-top: none;
    padding: 1rem;
    font-weight: 700;
  }

  .p-datatable .p-column-header-content {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  </style>
