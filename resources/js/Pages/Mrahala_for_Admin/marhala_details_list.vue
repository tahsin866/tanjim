<template>
    <AuthenticatedLayout>
      <div class="bg-gray-100 rounded-sm p-6 border-t-4 border-emerald-700 mx-5 mt-5">
        <div class="relative mb-6">
          <h2 class="text-xl font-semibold text-center text-emerald-800 py-3">মারহালা তথ্য</h2>
        </div>

        <DataTable :value="marhalas" stripedRows responsiveLayout="scroll" class="p-datatable-sm">
          <Column field="marhala_name_bn" header="মারহালা নাম" style="width: 25%"></Column>
          <Column field="total_subjects" header="মোট বিষয়" style="width: 15%" class="text-center"></Column>
          <Column field="male_subjects" header="পুরুষ" style="width: 15%" class="text-center"></Column>
          <Column field="female_subjects" header="মহিলা" style="width: 15%" class="text-center"></Column>
          <Column field="both_subjects" header="উভয়" style="width: 15%" class="text-center"></Column>
          <Column header="অ্যাকশন" style="width: 15%">
            <template #body="slotProps">
              <div class="flex justify-center">
                <SplitButton
                  label="নতুন যোগ করুন"
                  icon="pi pi-plus"
                  class="custom-split-button"
                  @click="navigateToSetupList(slotProps.data.id)"
                  :model="getMenuItems(slotProps.data.id)"
                />
              </div>
            </template>
          </Column>
        </DataTable>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { Link, router } from '@inertiajs/vue3';
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import SplitButton from 'primevue/splitbutton';

  const marhalas = ref([]);

  const fetchMarhalas = async () => {
    try {
      const response = await axios.get('/api/get-marhala-list');
      marhalas.value = response.data;
    } catch (error) {
      console.error('Error fetching marhalas:', error);
    }
  };

  const navigateToSetupList = (id) => {
    router.visit(route('Mrahala_for_Admin.marhala_setup_list', { id }));
  };

  const getMenuItems = (id) => {
    return [
      {
        label: 'সংশোধন করুন',
        icon: 'pi pi-pencil',
        command: () => {
          router.visit(route('Mrahala_for_Admin.marhala_edit', { marhala: id }));
        }
      }
    ];
  };

  onMounted(() => {
    fetchMarhalas();
  });
  </script>

  <style scoped>
  :deep(.p-datatable-header) {
    background-color: #047857;
    color: white;
  }

  :deep(.p-datatable-thead > tr > th) {
    background-color: #047857;
    color: white;
    text-align: center;
    padding: 0.75rem;
  }

  :deep(.p-datatable-tbody > tr) {
    text-align: center;
  }

  :deep(.p-datatable-tbody > tr > td:first-child) {
    text-align: left;
  }

  /* Custom styling for the split button to make it white */
  :deep(.custom-split-button) {
    background: white;
    border: 1px solid #ced4da;
  }

  :deep(.custom-split-button .p-splitbutton-defaultbutton),
  :deep(.custom-split-button .p-splitbutton-menubutton) {
    background: white;
    border: none;
    color: #333;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
  }

  :deep(.custom-split-button .p-splitbutton-defaultbutton:hover),
  :deep(.custom-split-button .p-splitbutton-menubutton:hover) {
    background: #f8f9fa;
    color: #333;
  }

  :deep(.custom-split-button .p-splitbutton-defaultbutton:focus),
  :deep(.custom-split-button .p-splitbutton-menubutton:focus) {
    box-shadow: none;
    border-color: #ced4da;
  }

  :deep(.custom-split-button .p-button-icon) {
    color: #333;
  }

  :deep(.p-menu) {
    background: white;
    border: 1px solid #ced4da;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  :deep(.p-menuitem-link) {
    color: #333;
  }

  :deep(.p-menuitem-link:hover) {
    background: #f8f9fa;
  }
  </style>
