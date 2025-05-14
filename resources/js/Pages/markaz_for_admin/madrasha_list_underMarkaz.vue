<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-[#f8f9fa] min-h-screen mx-5 mt-5">
        <div class="mx-auto">
          <!-- Header Section -->
          <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
              মারকাজ ভিত্তিক মাদরাসার তালিকা
            </h1>
          </div>

          <!-- Results Table -->
          <div class="mt-8 bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-[#2d6a4f] p-4 flex justify-between items-center">
              <h2 class="text-white text-lg font-semibold flex items-center gap-2">
                <i class="fas fa-list"></i>
                মাদরাসা তালিকা
              </h2>
              <div class="text-white">মোট উপাত্ত: {{ madrashas?.length || 0 }}</div>
            </div>
            <div class="p-4">
              <DataTable
                :value="madrashas"
                v-model:filters="filters"
                filterDisplay="menu"
                :paginator="true"
                :rows="10"
                :rowsPerPageOptions="[10, 20, 50, 100]"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                currentPageReportTemplate="দেখানো হচ্ছে {first} থেকে {last} মোট {totalRecords} এর মধ্যে"
                responsiveLayout="stack"
                breakpoint="960px"
                class="p-datatable-sm"
                showGridlines
                stripedRows
                :globalFilterFields="['name', 'Elhaq_no', 'id', 'Mobile_no']"
                dataKey="id"
              >
                <template #header>
                  <div class="flex justify-between items-center">
                    <div>
                      <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="filters['global'].value" placeholder="সার্চ করুন..." />
                      </span>
                    </div>
                  </div>
                </template>

                <Column field="id" header="ক্রমিক" sortable style="min-width: 5rem">
                  <template #body="{ index }">
                    {{ index + 1 }}
                  </template>
                </Column>

                <Column field="name" header="মাদরাসার নাম" sortable style="min-width: 12rem">
                  <template #filter="{ filterModel }">
                    <InputText
                      v-model="filterModel.value"
                      type="text"
                      class="p-column-filter"
                      placeholder="সার্চ করুন..."
                    />
                  </template>
                </Column>

                <Column field="Elhaq_no" header="এলহাক নম্বর" sortable style="min-width: 10rem">
                  <template #filter="{ filterModel }">
                    <InputText
                      v-model="filterModel.value"
                      type="text"
                      class="p-column-filter"
                      placeholder="সার্চ করুন..."
                    />
                  </template>
                </Column>

                <Column field="id" header="আইডি" sortable style="min-width: 8rem">
                  <template #filter="{ filterModel }">
                    <InputText
                      v-model="filterModel.value"
                      type="text"
                      class="p-column-filter"
                      placeholder="সার্চ করুন..."
                    />
                  </template>
                </Column>

                <Column field="Mobile_no" header="মোবাইল নম্বর" sortable style="min-width: 10rem">
                  <template #filter="{ filterModel }">
                    <InputText
                      v-model="filterModel.value"
                      type="text"
                      class="p-column-filter"
                      placeholder="সার্চ করুন..."
                    />
                  </template>
                </Column>

             <Column header="করনীয়" style="min-width: 10rem">
  <template #body="{ data }">
    <SplitButton
      label="বিস্তারিত"
      icon="fas fa-eye"
      size="small"
      class="p-button-sm p-button-text p-button-info"
      @click="viewApplication(data)"
      :model="getActionOptions(data)"
    />
  </template>
</Column>
              </DataTable>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
  import { ref, reactive, onMounted } from 'vue';

  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import InputText from 'primevue/inputtext';
import SplitButton from 'primevue/splitbutton';




  const FilterMatchMode = {
  STARTS_WITH: 'startswith',
  CONTAINS: 'contains',
  EQUALS: 'equals',
  DATE_IS: 'dateIs'
};
  // Initialize filters correctly
  const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
    'name': { value: null, matchMode: FilterMatchMode.CONTAINS },
    'Elhaq_no': { value: null, matchMode: FilterMatchMode.CONTAINS },
    'id': { value: null, matchMode: FilterMatchMode.EQUALS },
    'Mobile_no': { value: null, matchMode: FilterMatchMode.CONTAINS }
  });

  // Table Headers
  const tableHeaders = [
    { id: 1, label: "ক্রমিক" },
    { id: 2, label: "মাদরাসার নাম" },
    { id: 3, label: "এলহাক নম্বর" },
    { id: 6, label: "আইডি" },
    { id: 7, label: "মোবাইল নম্বর" },
    { id: 11, label: "অ্যাকশন" }
  ];

  // Props
  const props = defineProps({
    madrashas: {
      type: Array,
      required: true
    },
    markazId: Number
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
  </script>
