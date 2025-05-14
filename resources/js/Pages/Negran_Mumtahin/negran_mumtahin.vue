<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Tag from 'primevue/tag';
import Dialog from 'primevue/dialog';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import SplitButton from 'primevue/splitbutton';
import ConfirmDialog from 'primevue/confirmdialog';
import { useConfirm } from "primevue/useconfirm";
import axios from 'axios';

const toast = useToast();
const confirm = useConfirm();

const getActionItems = (rowData) => {
  return [
    {
      label: 'বিস্তারিত',
      icon: 'pi pi-eye',
      command: () => {
        toast.add({ severity: 'info', summary: 'বিস্তারিত', detail: 'আবেদন বিস্তারিত দেখা হচ্ছে', life: 3000 });
        // viewDetails(rowData) function call
      }
    },
    {
      label: 'সম্পাদনা',
      icon: 'pi pi-pencil',
      command: () => {
        // আইডি পাস করা হচ্ছে
      router.visit(route('Negran_Mumtahin.neg-mumtahin-eidt', { id: rowData.id }));
      }
    },
    {
      separator: true
    },
    {
      label: 'মুছুন',
      icon: 'pi pi-trash',
      command: () => {
        confirm.require({
          message: 'আপনি কি নিশ্চিত যে আপনি এই আবেদনটি মুছতে চান?',
          header: 'নিশ্চিতকরণ',
          icon: 'pi pi-exclamation-triangle',
          acceptLabel: 'হ্যাঁ',
          rejectLabel: 'না',
          accept: () => deleteApplication(rowData),
        });
      }
    }
  ];
};

// Add this function to handle the delete operation
const deleteApplication = (rowData) => {
  axios.delete(route('Negran_Mumtahin.delete', { id: rowData.id }))
    .then(response => {
      toast.add({
        severity: 'success',
        summary: 'সফল',
        detail: 'আবেদন সফলভাবে মুছে ফেলা হয়েছে',
        life: 3000
      });

      // Refresh the data table or remove the item from the current list
      // If you're using a state variable for your data, you can filter out the deleted item
      applications.value = applications.value.filter(app => app.id !== rowData.id);
    })
    .catch(error => {
      console.error('Delete error:', error);
      toast.add({
        severity: 'error',
        summary: 'ব্যর্থ',
        detail: 'আবেদন মুছতে ব্যর্থ হয়েছে',
        life: 3000
      });
    });
};

const submitToBoard = (data) => {
  toast.add({ severity: 'success', summary: 'সফল', detail: 'বোর্ডে দাখিল করা হয়েছে', life: 3000 });
  // Implement board submission logic here
};

const exportOptions = ref([
  {
    label: 'বোর্ড দাখিল',
    icon: 'ri-send-plane-line',
    command: () => submitToBoard()
  },
  {
    label: 'CSV ডাউনলোড',
    icon: 'ri-file-excel-line',
    command: () => exportCSV()
  },
  {
    label: 'এক্সেল ডাউনলোড',
    icon: 'ri-file-excel-2-line',
    command: () => exportExcel()
  },
  {
    label: 'বাতিল',
    icon: 'ri-close-circle-line',
    command: () => cancelApplications()
  }
]);

const applications = ref([]);
const loading = ref(true);
const openModal = ref(false);
const searchMobile = ref('');
const searchCode = ref('');

// FilterMatchMode ডিফাইন
const FilterMatchMode = {
  STARTS_WITH: 'startsWith',
  CONTAINS: 'contains',
  EQUALS: 'equals',
  DATE_IS: 'dateIs'
};

const filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  mobile: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  birth_date: { value: null, matchMode: FilterMatchMode.EQUALS },
  application_type: { value: null, matchMode: FilterMatchMode.EQUALS },
  status: { value: null, matchMode: FilterMatchMode.EQUALS }
});

onMounted(async () => {
  try {
    const response = await fetch('/api/neg-mumtahin-applications');
    applications.value = await response.json();
  } catch (error) {
    console.error('Error fetching applications:', error);
  } finally {
    loading.value = false;
  }
});

const clearFilter = () => {
  filters.value = {
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    mobile: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    birth_date: { value: null, matchMode: FilterMatchMode.EQUALS },
    application_type: { value: null, matchMode: FilterMatchMode.EQUALS },
    status: { value: null, matchMode: FilterMatchMode.EQUALS }
  };
};

const getSeverity = (status) => {
  switch (status) {
    case 'pending':
      return 'warning';
    case 'approved':
      return 'success';
    case 'rejected':
      return 'danger';
    default:
      return 'info';
  }
};

const searchTeachers = async () => {
  if (!searchMobile.value && !searchCode.value) {
    alert('অনুগ্রহ করে মোবাইল নম্বর অথবা কোড নম্বর দিন');
    return;
  }
  try {
    const response = await axios.get('/api/search-teacher', {
      params: {
        mobile: searchMobile.value,
        code: searchCode.value
      }
    });
    // সার্চ রেজাল্ট স্টোর করুন
    localStorage.setItem('teacherSearchResults', JSON.stringify(response.data));
    // সঠিক রাউট URL-এ রিডাইরেক্ট করুন
    window.location.href = '/negran-view-detailes';
  } catch (error) {
    console.error('Error searching teachers:', error);
    alert('অনুসন্ধান করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
  }
};

const exportPDF = () => {
  // Implement PDF export functionality
  console.log('Exporting PDF');
};

// Define these functions to avoid errors with the exportOptions
const exportCSV = () => {
  console.log('Exporting CSV');
};

const exportExcel = () => {
  console.log('Exporting Excel');
};

const cancelApplications = () => {
  console.log('Cancelling applications');
};
</script>

<template>
<AuthenticatedLayout>
    <div class="container-fluid mx-auto p-5">
    <!-- Add Toast and ConfirmDialog at the top level -->
    <Toast />
    <ConfirmDialog />

    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden mb-5">
      <!-- Decorative top bar -->
      <!-- Header section -->
      <div class="p-5 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div>
            <h4 class="text-xl font-semibold text-emerald-800 flex items-center">
              <i class="ri-user-search-line mr-2 text-emerald-600"></i>
              মোট নেগরান মুমতাহিন আবেদন সংখ্যা
            </h4>
            <p class="text-gray-500 text-sm mt-1">সকল আবেদন এখানে দেখানো হয়েছে</p>
          </div>
          <div class="flex gap-3">
            <Link
              :href="route('Negran_Mumtahin.negran_mumtahin_apply')"
              class="inline-flex items-center justify-center px-4 py-2 bg-white text-emerald-700 text-xl font-medium rounded-md border border-emerald-200 shadow-sm hover:bg-gray-50 hover:-translate-y-0.5 transition-all duration-200"
            >
              <i class="ri-history-line mr-1.5"></i>
              নতুন
            </Link>
            <button
        @click="openModal = true"
        class="inline-flex items-center justify-center px-8 py-2 bg-emerald-600 text-white text-xl font-medium rounded-md shadow-sm hover:bg-emerald-700 hover:-translate-y-0.5 transition-all duration-200"
      >
        <i class="ri-add-circle-line mr-1.5"></i>
        পুরাতন
      </button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="openModal" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center p-4">
  <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden transform transition-all">
    <!-- Modal Header -->
    <div class="bg-emerald-600 text-white px-6 py-4 flex justify-between items-center">
      <h3 class="text-lg font-medium">

        নেগরান মুমতাহিন সার্চ
      </h3>
      <button @click="openModal = false" class="text-white hover:text-gray-200 focus:outline-none">
        <i class="ri-close-line text-xl"></i>
      </button>
    </div>
    <!-- Modal Body -->
    <div>
    <div class="p-6 space-y-4">
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">মোবাইল নম্বর</label>
          <input
            v-model="searchMobile"
            type="text"
            placeholder="মোবাইল নম্বর দিন"
            class="w-full p-2 border-2 border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">কোড নম্বর</label>
          <input
            v-model="searchCode"
            type="text"
            placeholder="কোড নম্বর দিন"
            class="w-full p-2 border-2 border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
          />
        </div>
        <div>
          <button
            @click="searchTeachers"
            class="w-full bg-emerald-500 text-white py-2 px-4 rounded-md hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50"
          >
            সার্চ করুন
          </button>
        </div>
      </div>
      <!-- ফলাফল দেখানোর অংশ -->
    </div>
  </div>
    <!-- Modal Footer -->
    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
      <button
        @click="openModal = false"
        class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 transition-colors duration-200"
      >
        <i class="ri-close-line mr-1.5"></i>
        বাতিল
      </button>
      <!-- <button
        @click="searchItems"
        class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-emerald-700 transition-colors duration-200"
      >
        <i class="ri-search-line mr-1.5"></i>
        সার্চ করুন
      </button> -->
    </div>
  </div>
</div>

    <!-- Action Panel -->
    <div class="container-fluid mx-auto">
      <!-- Header Section -->
      <div class="bg-white rounded-sm shadow-lg p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
  <h4 class="text-2xl font-semibold text-emerald-700">
    মোট নেগরান মুমতাহিন আবেদন সংখ্যা
  </h4>
  <div class="flex gap-4">
    <SplitButton
      label="PDF ডাউনলোড"
      icon="ri-file-pdf-line"
      severity="green"
      @click="exportPDF"
      :model="exportOptions"
    />
  </div>
</div>
        <!-- Table Section -->
        <DataTable
          v-model:filters="filters"
          :value="applications"
          paginator
          showGridlines
          :rows="10"
          dataKey="id"
          filterDisplay="menu"
          :loading="loading"
          :globalFilterFields="['name', 'mobile', 'birth_date', 'application_type', 'status']"
          class="p-datatable-sm"
        >
          <template #header>
            <div class="flex justify-between">
              <Button type="button" icon="pi pi-filter-slash" label="ফিল্টার মুছুন" outlined @click="clearFilter()" />
              <span class="p-input-icon-left">

                <InputText v-model="filters['global'].value" placeholder="সার্চ করুন..." />
              </span>
            </div>
          </template>
          <template #empty> কোন আবেদন পাওয়া যায়নি </template>
          <template #loading> লোড হচ্ছে... </template>
          <Column field="id" header="ক্রমিক নং" style="min-width: 5rem">
            <template #body="{ index }">
              {{ index + 1 }}
            </template>
          </Column>
          <Column header="ছবি" style="min-width: 6rem">
            <template #body="{ data }">
              <img v-if="data.image" :src="`/storage/${data.image}`" alt="Profile Image" class="w-10 h-10 rounded-full object-cover">
              <div v-else class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">N/A</span>
              </div>
            </template>
          </Column>
          <Column field="name" header="নাম" style="min-width: 12rem">
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" placeholder="নাম দিয়ে খুঁজুন" class="p-inputtext-sm" />
            </template>
          </Column>
          <Column field="mobile" header="মোবাইল নম্বর" style="min-width: 10rem">
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" placeholder="মোবাইল নম্বর দিয়ে খুঁজুন" class="p-inputtext-sm" />
            </template>
          </Column>
          <Column field="birth_date" header="জন্ম-তারিখ" style="min-width: 10rem">
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="date" class="p-inputtext-sm" />
            </template>
          </Column>
          <Column field="application_type" header="আবেদনের ধরন" style="min-width: 10rem">
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" placeholder="আবেদনের ধরন দিয়ে খুঁজুন" class="p-inputtext-sm" />
            </template>
          </Column>
          <Column field="status" header="আবেদন অবস্থা" style="min-width: 10rem">
            <template #body="{ data }">
              <Tag :value="data.status" :severity="getSeverity(data.status)" />
            </template>
            <template #filter="{ filterModel }">
              <InputText v-model="filterModel.value" type="text" placeholder="অবস্থা দিয়ে খুঁজুন" class="p-inputtext-sm" />
            </template>
          </Column>
          <Column header="করণীয়" style="min-width: 12rem">
            <template #body="{ data }">
              <SplitButton
                label="বোর্ড দাখিল"
                icon="pi pi-send-plane"
                severity="success"
                @click="submitToBoard(data)"
                :model="getActionItems(data)"
                class="p-button-sm"
              />
            </template>
          </Column>
        </DataTable>
      </div>
    </div>
  </div>
</AuthenticatedLayout>
</template>

<style scoped>
body {
  font-family: 'SolaimanLipi', Arial, sans-serif;
}
</style>

