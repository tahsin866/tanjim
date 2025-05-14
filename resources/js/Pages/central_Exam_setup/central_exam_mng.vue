<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-gray-50 min-h-screen">
        <!-- Exam List Header -->
        <div class="bg-white p-6 rounded-lg mb-6 flex justify-between items-center shadow-sm border border-gray-100">
          <h2 class="font-bold text-xl text-emerald-800 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            কেন্দ্রীয় পরীক্ষা তালিকা
          </h2>
          <Link :href="route('central_Exam_setup.central_exam_name')"
            class="bg-emerald-600 text-white px-6 py-2 rounded-sm hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            নতুন কেন্দ্রীয় পরীক্ষা
          </Link>
        </div>

        <!-- Exam Table with PrimeVue -->
        <div class="card">
            <DataTable
  :value="exams"
  :paginator="true"
  :rows="10"
  :rowsPerPageOptions="[5, 10, 20, 50]"
  paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
  currentPageReportTemplate="মোট {totalRecords} টি এন্ট্রি থেকে {first} - {last} দেখানো হচ্ছে"
  responsiveLayout="scroll"
  class="p-datatable-sm"
  :globalFilterFields="['name', 'year', 'hijri']"
  v-model:filters="filters"
  filterDisplay="menu"
>
  <template #header>
    <div class="flex justify-between flex-column sm:flex-row">
      <div>
        <span class="p-input-icon-left">
          <i class="pi pi-search" />
          <InputText v-model="filters['global'].value" placeholder="পরীক্ষার নাম দিয়ে অনুসন্ধান করুন..." />
        </span>
      </div>
      <div>
        <Button icon="pi pi-refresh" class="p-button-outlined p-button-secondary ml-2" @click="resetFilters" />
      </div>
    </div>
  </template>

  <Column field="name" header="কেন্দ্রীয় পরীক্ষার নাম" :sortable="true">
    <template #filter="{ filterModel }">
      <MultiSelect
        v-model="filters.name.value"
        :options="getUniqueValues('name')"
        @change="applyFilter"
        placeholder="পরীক্ষা নির্বাচন করুন"
        class="p-column-filter"
        :maxSelectedLabels="1"
        :showToggleAll="true"
        display="chip"
      />
    </template>
  </Column>

  <Column field="serial" header="ক্রম" :sortable="true"></Column>

  <Column field="year" header="ইয়ার" :sortable="true" :filter="true" filterMatchMode="in">
    <template #filter="{ filterModel, filterCallback }">
      <MultiSelect
        v-model="filterModel.value"
        :options="getUniqueValues('year')"
        @change="filterCallback()"
        placeholder="ইয়ার নির্বাচন করুন"
        class="p-column-filter"
        :maxSelectedLabels="1"
        :showToggleAll="true"
        display="chip"
      />
    </template>
  </Column>

  <Column field="hijri" header="হিজরি" :sortable="true" :filter="true" filterMatchMode="in">
    <template #filter="{ filterModel, filterCallback }">
      <MultiSelect
        v-model="filterModel.value"
        :options="getUniqueValues('hijri')"
        @change="filterCallback()"
        placeholder="হিজরি নির্বাচন করুন"
        class="p-column-filter"
        :maxSelectedLabels="1"
        :showToggleAll="true"
        display="chip"
      />
    </template>
  </Column>

  <Column header="করনীয়">
    <template #body="slotProps">
      <Link :href="route('central_Exam_setup.central_name_eidt', { id: slotProps.data.id })"
        class="bg-amber-500 text-white px-3 py-1.5 rounded-sm hover:bg-amber-600 transition-colors duration-200 text-sm inline-block">
        সংশোধনী
      </Link>
    </template>
  </Column>

  <Column header="নিবন্ধন সেটাপ">
    <template #body="slotProps">
      <SplitButton
        label="নিবন্ধন সেটআপ"
        icon="pi pi-cog"
        @click="navigateToNibondon(slotProps.data.id)"
        :model="[
          {
            label: 'সংশোধনী',
            icon: 'pi pi-pencil',
            command: () => navigateToExamEdit(slotProps.data.exam_setup_id)
          }
        ]"
        class="custom-split-button"
      />
    </template>
  </Column>

  <Column header="অন্তর্ভুক্তি সেটাপ">
    <template #body="slotProps">
      <SplitButton
        label="অন্তর্ভুক্তি সেটআপ"
        icon="pi pi-cog"
        @click="navigateToNibondon(slotProps.data.id)"
        :model="[
          {
            label: 'সংশোধনী',
            icon: 'pi pi-pencil',
            command: () => navigateToExamEdit(slotProps.data.exam_setup_id)
          }
        ]"
        class="custom-split-button"
      />
    </template>
  </Column>

  <Column header="অন্যান্য সেটাপ">
    <template #body="slotProps">
      <SplitButton
        label="অন্যান্য সেটআপ"
        icon="pi pi-cog"
        @click="navigateToOthersSetup"
        :model="[
          {
            label: 'সংশোধনী',
            icon: 'pi pi-pencil',
            command: () => navigateToOthersSetupEdit(slotProps.data.id)
          }
        ]"
        class="custom-split-button"
      />
    </template>
  </Column>
</DataTable>

</div>


      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
  import { ref, onMounted, reactive } from 'vue';
  import { Link, router } from '@inertiajs/vue3';
  import axios from 'axios';

  // PrimeVue components
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';
  import SplitButton from 'primevue/splitbutton';
  import MultiSelect from 'primevue/multiselect';


  const FilterMatchMode = {
  STARTS_WITH: 'startswith',
  CONTAINS: 'contains',
  EQUALS: 'equals',
  DATE_IS: 'dateIs'
};


const getUniqueValues = (field) => {
  const values = exams.value.map(exam => exam[field]);
  return [...new Set(values)].sort();
};



  const exams = ref([]);

  // Initialize filters
  const filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.IN },
  year: { value: null, matchMode: FilterMatchMode.IN },
  hijri: { value: null, matchMode: FilterMatchMode.IN }
});


  // Fetch exam setups
  const fetchExamSetups = async () => {
    try {
      const response = await axios.get('/api/exam-setups_1');
      exams.value = response.data.map(exam => ({
        id: exam.id,
        exam_setup_id: exam.id,
        name: `${exam.exam_name} ${exam.arabic_year} হিজরি/${exam.bangla_year} বঙ্গাব্দ/${exam.english_year} ইসাব্দ`,
        serial: exam.id,
        year: exam.english_year,
        hijri: exam.arabic_year,
        bangla: exam.bangla_year,
      }));
    } catch (error) {
      console.error('API Error:', error);
    }
  };

  // Reset filters
  const resetFilters = () => {
    filters.value = {
      global: { value: null, matchMode: FilterMatchMode.CONTAINS },
      name: { value: null, matchMode: FilterMatchMode.CONTAINS },
      year: { value: null, matchMode: FilterMatchMode.EQUALS }
    };
  };

  // Navigation functions for SplitButtons
  const navigateToExamEdit = (examSetupId) => {
    router.visit(route('central_Exam_setup.central_exam_edit', examSetupId));
  };

  const navigateToNibondon = (examId) => {
    router.visit(route('central_Exam_setup.nibondon_setup', examId));
  };

  const navigateToOthersSetup = () => {
    router.visit(route('central_Exam_setup.others_setup'));
  };

  const navigateToOthersSetupEdit = (examId) => {
    router.visit(route('central_Exam_setup.others_setup_edit', { id: examId }));
  };

  onMounted(() => {
    fetchExamSetups();
  });
  </script>

  <style scoped>
  /* Custom styling for PrimeVue DataTable */
  :deep(.p-datatable .p-datatable-thead > tr > th) {
    background-color: rgb(236, 253, 245); /* emerald-50 */
    color: rgb(6, 95, 70); /* emerald-800 */
    font-weight: 600;
    padding: 0.75rem 1rem;
    border-color: rgb(209, 250, 229); /* emerald-100 */
  }

  :deep(.p-datatable .p-datatable-tbody > tr) {
    transition: background-color 0.2s;
  }

  :deep(.p-datatable .p-datatable-tbody > tr:hover) {
    background-color: rgb(240, 253, 244); /* emerald-50 */
  }

  :deep(.p-datatable .p-datatable-tbody > tr > td) {
    padding: 0.75rem 1rem;
    border-color: rgb(243, 244, 246); /* gray-100 */
  }

  :deep(.p-paginator) {
    background-color: rgb(249, 250, 251); /* gray-50 */
    border-top: 1px solid rgb(243, 244, 246); /* gray-100 */
    padding: 0.5rem 1rem;
  }

  :deep(.p-splitbutton) {
    font-size: 0.875rem;
  }

  :deep(.p-splitbutton .p-button) {
    padding: 0.5rem 0.75rem;
  }

  :deep(.p-column-filter) {
    width: 100%;
  }
  </style>
