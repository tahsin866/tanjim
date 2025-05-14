<template>
    <AuthenticatedLayout>
      <div class="bg-white mx-5 mt-5 dark:bg-gray-900 rounded-lg shadow-lg p-6 border border-emerald-100 dark:border-emerald-900">
        <!-- Header with Islamic pattern -->
        <div class="relative mb-6 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg p-4 overflow-hidden">
          <div class="absolute inset-0 opacity-10 islamic-pattern"></div>
          <h2 class="text-2xl text-emerald-800 dark:text-emerald-200 text-center relative z-10">
            ইউজার ম্যানেজমেন্ট সিস্টেম
          </h2>
        </div>

        <!-- Search and Add User Section -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
          <div class="flex-1">
            <div class="relative">
              <span class="p-input-icon-left w-full">

                <InputText
                  v-model="filters['global'].value"
                  placeholder="ফোন নম্বর দিয়ে সার্চ করুন"
                  class="w-full"
                />
              </span>
            </div>
          </div>
          <div>
            <Link
              :href="route('user_create_for_admin.new_user_for_admin')"
              class="w-full md:w-auto px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md transition-colors duration-200 flex items-center justify-center gap-2 shadow-md"
            >
              <i class="pi pi-plus"></i>
              নতুন ইউজার
            </Link>
          </div>
        </div>

        <!-- PrimeVue DataTable -->
        <DataTable
          :value="admins"
          :paginator="true"
          :rows="20"
          :rowsPerPageOptions="[5, 10, 20, 50]"
          paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
          currentPageReportTemplate="মোট {totalRecords} জন ইউজারের মধ্যে {first}-{last} দেখাচ্ছে"
          responsiveLayout="scroll"
          :globalFilterFields="['name', 'phone', 'email']"
          v-model:filters="filters"
          filterDisplay="menu"
          class="p-datatable-gridlines"
        >
          <Column field="profile_image" header="ছবি">
            <template #body="slotProps">
              <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-emerald-200 dark:border-emerald-700">
                <img
                  :src="slotProps.data.profile_image ? '/storage/' + slotProps.data.profile_image : 'https://randomuser.me/api/portraits/men/1.jpg'"
                  :alt="slotProps.data.name"
                  class="h-full w-full object-cover"
                />
              </div>
            </template>
          </Column>

          <Column field="name" header="নাম" :sortable="true" :filter="true" filterPlaceholder="নাম খুঁজুন">
          </Column>

          <Column field="phone" header="ফোন নম্বর" :sortable="true" :filter="true" filterPlaceholder="ফোন নম্বর খুঁজুন">
          </Column>

          <Column field="email" header="ইমেইল" :sortable="true" :filter="true" filterPlaceholder="ইমেইল খুঁজুন">
          </Column>

          <Column field="designation" header="পদবি" :sortable="true" :filter="true" filterMatchMode="equals">
            <template #body="slotProps">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                    :class="getDesignationClass(slotProps.data.designation)">
                {{ getDesignationText(slotProps.data.designation) }}
              </span>
            </template>
            <template #filter="{ filterModel }">
              <Dropdown
                v-model="filterModel.value"
                :options="designationOptions"
                optionLabel="name"
                optionValue="value"
                placeholder="পদবি বাছাই করুন"
                class="p-column-filter"
                showClear
              />
            </template>
          </Column>

          <Column header="একশন">
  <template #body="slotProps">
    <div class="flex space-x-2">
      <Toast />
      <ConfirmPopup></ConfirmPopup>
      <Dialog v-model:visible="showModal" :style="{width: '450px'}" header="এডমিন ডিলিট করুন" :modal="true">
        <div class="flex items-start">
          <i class="pi pi-exclamation-triangle mr-3 text-red-500" style="font-size: 2rem"></i>
          <div>
            <p class="text-sm text-gray-500">
              আপনি কি নিশ্চিত যে আপনি এই এডমিন ডিলিট করতে চান? এই কাজটি অপরিবর্তনীয়।
            </p>
          </div>
        </div>
        <template #footer>
          <Button label="বাতিল করুন" icon="pi pi-times" class="p-button-text" @click="showModal = false" />
          <Button label="ডিলিট করুন" icon="pi pi-check" class="p-button-danger" @click="deleteAdmin" />
        </template>
      </Dialog>
      <SplitButton
        label="সংশোধন"
        @click="editUser(slotProps.data.id)"
        :model="getActionItems(slotProps.data.id)"
        class="p-button-sm"
      />
    </div>
  </template>
</Column>
        </DataTable>

        <!-- Delete Confirmation Dialog -->

      </div>
    </AuthenticatedLayout>
  </template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

// PrimeVue Components
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Toast from 'primevue/toast';
import ConfirmPopup from 'primevue/confirmpopup';
import SplitButton from 'primevue/splitbutton';
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";

const toast = useToast();
const confirm = useConfirm();
const showModal = ref(false);
const selectedUserId = ref(null);

const editUser = (userId) => {
  router.visit(route('user_create_for_admin.admin_user_edit', userId));
};

const viewUser = (userId) => {
  // Implement view user functionality
  toast.add({ severity: 'info', summary: 'View', detail: 'Viewing user details', life: 3000 });
};

const confirmDelete = (userId) => {
  adminIdToDelete.value = userId;
  showModal.value = true;
};
const deleteAdmin = () => {
  // Inertia.js ব্যবহার করে ডিলিট রিকোয়েস্ট পাঠানো
  router.delete(route('user_create_for_admin.destroy', adminIdToDelete.value), {
    onSuccess: () => {
      toast.add({
        severity: 'success',
        summary: 'সফল',
        detail: 'এডমিন সফলভাবে ডিলিট করা হয়েছে',
        life: 3000
      });
    },
    onError: () => {
      toast.add({
        severity: 'error',
        summary: 'ত্রুটি',
        detail: 'এডমিন ডিলিট করতে সমস্যা হয়েছে',
        life: 3000
      });
    }
  });
  showModal.value = false;
};

const checkHistory = (userId) => {
  // Implement check history functionality
  toast.add({ severity: 'info', summary: 'History', detail: 'Checking user history', life: 3000 });
};

const getActionItems = (userId) => {
  return [
    {
      label: 'ভিউ',
      icon: 'pi pi-eye',
      command: () => {
        viewUser(userId);
      }
    },
    {
      label: 'ডিলিট',
      icon: 'pi pi-trash',
      command: () => {
        confirmDelete(userId);
      }
    },
    {
      label: 'চেক হিস্টরি',
      icon: 'pi pi-history',
      command: () => {
        checkHistory(userId);
      }
    }
  ];
};

const FilterMatchMode = {
  STARTS_WITH: 'startswith',
  CONTAINS: 'contains',
  EQUALS: 'equals',
  DATE_IS: 'dateIs'
};

const admins = ref([]);

// Designation options for dropdown filter
const designationOptions = ref([
  { name: 'সুপার এডমিন', value: 1 },
  { name: 'সহ সুপার এডমিন', value: 2 },
  { name: 'বোর্ড এডমিন', value: 3 }
]);

// Initialize filters
const filters = ref({
  'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
  'name': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  'phone': { value: null, matchMode: FilterMatchMode.CONTAINS },
  'email': { value: null, matchMode: FilterMatchMode.CONTAINS },
  'designation': { value: null, matchMode: FilterMatchMode.EQUALS }
});

onMounted(() => {
  fetchAdmins();
});

const fetchAdmins = async () => {
  try {
    const response = await axios.get('/api/admins');
    admins.value = response.data;
  } catch (error) {
    console.error('Error fetching admins:', error);
  }
};

const getDesignationText = (designation) => {
  if (designation == 1) {
    return 'সুপার এডমিন';
  } else if (designation == 2) {
    return 'সহ সুপার এডমিন';
  } else {
    return 'বোর্ড এডমিন';
  }
};

const getDesignationClass = (designation) => {
  if (designation == 1) {
    return 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200';
  } else if (designation == 2) {
    return 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200';
  } else {
    return 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200';
  }
};

const adminIdToDelete = ref(null);
</script>

  <style>
  .font-arabic {
    font-family: 'Noto Sans Bengali', 'Hind Siliguri', sans-serif;
  }

  .islamic-pattern {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }

  /* PrimeVue DataTable customization */
  .p-datatable .p-datatable-thead > tr > th {
    background-color: #ffffff !important;
    color: #333333 !important;
    padding: 0.75rem;
    font-weight: 600;
    border-bottom: 1px solid #e5e7eb;
    border-right: 1px solid #e5e7eb;
  }

  .p-datatable .p-datatable-thead > tr > th:last-child {
    border-right: none;
  }

  .p-datatable .p-datatable-tbody > tr {
    background-color: #ffffff;
    border-bottom: 1px solid #f3f4f6;
  }

  .p-datatable .p-datatable-tbody > tr > td {
    padding: 0.75rem;
    text-align: center;
    border-right: 1px solid #f3f4f6;
  }

  .p-datatable .p-datatable-tbody > tr > td:last-child {
    border-right: none;
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

  /* Column filter styles */
  .p-column-filter {
    width: 100%;
  }

  .p-column-filter-menu-button {
    width: 2rem;
    height: 2rem;
  }

  .p-column-filter-overlay {
    min-width: 200px;
  }

  /* Dark mode support */
  .dark .p-datatable .p-datatable-thead > tr > th {
    background-color: #1f2937 !important;
    color: #e5e7eb !important;
    border-color: #374151;
  }

  .dark .p-datatable .p-datatable-tbody > tr {
    background-color: #111827;
    border-color: #374151;
  }

  .dark .p-datatable .p-datatable-tbody > tr > td {
    border-color: #374151;
    color: #e5e7eb;
  }

  .dark .p-datatable .p-paginator {
    background-color: #1f2937;
    color: #e5e7eb;
  }

  .dark .p-dropdown-panel {
    background-color: #1f2937;
    color: #e5e7eb;
  }

  .dark .p-dropdown-item {
    color: #e5e7eb;
  }

  .dark .p-dropdown-item:hover {
    background-color: #374151;
  }

  .dark .p-inputtext {
    background-color: #1f2937;
    color: #e5e7eb;
    border-color: #374151;
  }
  </style>
