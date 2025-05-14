<template>
    <AuthenticatedLayout>
      <div class="bg-[#f8f9fa] rounded-sm shadow-md p-6 border-t-4 border-emerald-600 mx-5 mt-5">
        <!-- Header with Islamic Pattern -->
        <div class="relative mb-8">
          <div class="absolute inset-0 bg-emerald-50 opacity-25 pattern-islamic"></div>
          <h2 class="text-2xl font-bold text-center text-emerald-800 py-4">মারহালা তথ্য</h2>
        </div>

        <!-- Table -->
        <div class="card">
          <DataTable
            :value="marhalas"
            responsiveLayout="scroll"
            class="p-datatable-sm custom-datatable"
            stripedRows
            :rowHover="true"
          >
            <Column field="marhala_name_bn" header="মারহালা নাম">
              <template #body="slotProps">
                <span class="font-semibold text-emerald-700">{{ slotProps.data.marhala_name_bn }}</span>
              </template>
            </Column>

            <Column field="total_subjects" header="মোট বিষয়">
              <template #body="slotProps">
                <span class="font-bold text-emerald-700">{{ slotProps.data.total_subjects }}</span>
              </template>
            </Column>

            <Column field="male_subjects" header="পুরুষ">
              <template #body="slotProps">
                <span class="font-bold text-emerald-700">{{ slotProps.data.male_subjects }}</span>
              </template>
            </Column>

            <Column field="female_subjects" header="মহিলা">
              <template #body="slotProps">
                <span class="font-bold text-emerald-700">{{ slotProps.data.female_subjects }}</span>
              </template>
            </Column>

            <Column field="both_subjects" header="উভয়">
              <template #body="slotProps">
                <span class="font-bold text-emerald-700">{{ slotProps.data.both_subjects }}</span>
              </template>
            </Column>

            <Column header="অ্যাকশন">
              <template #body="slotProps">
                <div class="flex justify-center gap-3">
                  <Link
                    :href="route('subjects_for_Admin.subject_setup', { marhala: slotProps.data.id })"
                    class="flex items-center px-3 py-1.5 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition-colors duration-200"
                  >
                    বিষয় সেটাপ করুন
                  </Link>
                </div>
              </template>
            </Column>
          </DataTable>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { Link } from '@inertiajs/vue3';

  // PrimeVue components
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';

  const marhalas = ref([]);

  const loadMarhalaStats = async () => {
    try {
      const response = await axios.get('/api/subject-marhala-counts');
      marhalas.value = response.data;
    } catch (error) {
      console.error('Error loading marhala stats:', error);
    }
  };

  onMounted(() => {
    loadMarhalaStats();
  });
  </script>

  <style scoped>
  /* Custom styling for PrimeVue DataTable */
  :deep(.custom-datatable) {
    border-collapse: collapse;
    width: 100%;
  }

  :deep(.p-datatable .p-datatable-thead > tr > th) {
    background-color: rgb(209, 250, 229); /* emerald-100 */
    border: 1px solid rgba(167, 243, 208, 0.5); /* emerald-200 with opacity */
    padding: 0.75rem;
    text-align: center;
    font-weight: bold;
  }

  :deep(.p-datatable .p-datatable-tbody > tr > td) {
    border: 1px solid rgba(167, 243, 208, 0.5); /* emerald-200 with opacity */
    padding: 0.75rem;
    text-align: center;
  }

  :deep(.p-datatable .p-datatable-tbody > tr:hover) {
    background-color: rgb(236, 253, 245); /* emerald-50 */
  }

  /* Fix header alignment */
  :deep(.p-datatable .p-datatable-thead > tr > th .p-column-title) {
    display: inline-block;
    width: 100%;
    text-align: center;
  }

  /* Ensure the table has a subtle outer border */
  :deep(.p-datatable) {
    border: 1px solid rgba(167, 243, 208, 0.5); /* emerald-200 with opacity */
    border-radius: 0.375rem;
    overflow: hidden;
  }

  /* Islamic pattern background */
  .pattern-islamic {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }
  </style>
