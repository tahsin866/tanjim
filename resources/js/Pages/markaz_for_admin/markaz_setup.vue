<template>
    <AuthenticatedLayout>
     <div class="p-6 bg-[#f8f9fa] min-h-screen mx-5 mt-5">
       <div class=" mx-auto">
         <!-- Header Section -->
         <div class="mb-6">
           <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">

             মারকায আবেদন ব্যবস্থাপনা
           </h1>
           <p class="text-gray-600">কেন্দ্রীয় মাদ্রাসা আবেদন ব্যবস্থাপনা সিস্টেম</p>
         </div>

         <!-- Search Panel -->


         <!-- Results Table -->
         <div class="mt-8 bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
     <div class="bg-[#2d6a4f] p-4 flex justify-between items-center">
       <h2 class="text-white text-xl font-semibold flex items-center gap-2">
         <i class="fas fa-list"></i>
         আবেদন তালিকা
       </h2>
       <div class="text-white text-xl">
         মোট আবেদন: {{ applications.length }}
       </div>
     </div>

     <div class="p-6">
         <DataTable
   v-model:filters="tableFilters"
   :value="applications"
   paginator
   showGridlines
   :rows="10"
   dataKey="id"
   filterDisplay="menu"
   :loading="loading"
   :globalFilterFields="['number', 'madrasha_Name', 'Elhaq_no', 'madrasha_code', 'markaz_type', 'status']"
   class="p-datatable-sm"
    sortMode="multiple"
 >
   <template #header>
     <div class="flex justify-between">
       <Button type="button" icon="pi pi-filter-slash" label="ফিল্টার মুছুন" outlined @click="clearFilter()" />
       <span class="p-input-icon-left">
         <i class="pi pi-search" />
         <InputText v-model="tableFilters['global'].value" placeholder="সার্চ করুন..." />
       </span>
     </div>
   </template>

         <template #empty> কোন আবেদন পাওয়া যায়নি </template>
         <template #loading> লোড হচ্ছে... </template>

         <Column field="id" header="ক্রমিক নং" style="min-width: 5rem" sortable>
      <template #body="{ index }">
        {{ index + 1 }}
      </template>
    </Column>

    <Column field="number" header="নম্বর" style="min-width: 8rem" sortable>
      <template #filter="{ filterModel }">
        <InputText v-model="filterModel.value" type="text" placeholder="নম্বর দিয়ে খুঁজুন" class="p-inputtext-sm" />
      </template>
    </Column>

    <Column field="madrasha_Name" header="মাদ্রাসার নাম" style="min-width: 12rem" sortable>
      <template #filter="{ filterModel }">
        <InputText v-model="filterModel.value" type="text" placeholder="মাদ্রাসার নাম দিয়ে খুঁজুন" class="p-inputtext-sm" />
      </template>
    </Column>

    <Column field="Elhaq_no" header="এলহাক নং" style="min-width: 8rem" sortable>
      <template #filter="{ filterModel }">
        <InputText v-model="filterModel.value" type="text" placeholder="এলহাক নং দিয়ে খুঁজুন" class="p-inputtext-sm" />
      </template>
    </Column>

    <Column field="madrasha_code" header="মাদ্রাসা কোড" style="min-width: 8rem" sortable>
      <template #filter="{ filterModel }">
        <InputText v-model="filterModel.value" type="text" placeholder="মাদ্রাসা কোড দিয়ে খুঁজুন" class="p-inputtext-sm" />
      </template>
    </Column>

    <Column field="studentNumber" header="ছাত্র সংখ্যা" style="min-width: 8rem" sortable>
      <template #filter="{ filterModel }">
        <InputText v-model="filterModel.value" type="text" placeholder="ছাত্র সংখ্যা দিয়ে খুঁজুন" class="p-inputtext-sm" />
      </template>
    </Column>

    <Column field="markaz_type" header="আবেদনকারীর ধরন" style="min-width: 10rem" sortable>
      <template #filter="{ filterModel }">
        <Dropdown
          v-model="filterModel.value"
          :options="markazTypes"
          placeholder="ধরন নির্বাচন করুন"
          class="p-column-filter"
          showClear
        />
      </template>
    </Column>

    <Column field="madrasahNumber" header="মাদ্রাসা নম্বর" style="min-width: 8rem" sortable>
      <template #filter="{ filterModel }">
        <InputText v-model="filterModel.value" type="text" placeholder="মাদ্রাসা নম্বর দিয়ে খুঁজুন" class="p-inputtext-sm" />
      </template>
    </Column>

    <Column field="status" header="বোর্ড স্ট্যাটাস" style="min-width: 10rem" sortable>
        <template #body="{ data }">
    <Tag :severity="getStatusSeverity(data.status || '')" :value="data.status || 'অনিশ্চিত'" />
  </template>
  <template #filter="{ filterModel }">
    <Dropdown
      v-model="filterModel.value"
      :options="statusOptions"
      placeholder="স্ট্যাটাস নির্বাচন করুন"
      class="p-column-filter"
      showClear
    />
  </template>
</Column>

<div class="card">
    <Toast />
    <Column header="করণীয়" style="min-width: 10rem">
  <template #body="{ data }">
    <div class="flex gap-2">
      <SplitButton
        label="Action"
        icon="pi pi-cog"
        @click="viewApplication(data.id)"
        :model="getActionItems(data)"
        class="p-button-sm"
      />
    </div>
  </template>
</Column>

  </div>
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
import axios from 'axios';
import { Link, router } from '@inertiajs/vue3';
import { useConfirm } from 'primevue/useconfirm';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Tag from 'primevue/tag'; // Tag কম্পোনেন্ট ইম্পোর্ট করা হয়েছে

import SplitButton from 'primevue/splitbutton';







 const confirm = useConfirm();
 const toast = useToast();


 const FilterMatchMode = {
   STARTS_WITH: 'startsWith',
   CONTAINS: 'contains',
   EQUALS: 'equals',
   DATE_IS: 'dateIs'
 };

 // Original filter fields from your code




 const getActionItems = (data) => {
  return [
    {
      label: 'View',
      icon: 'pi pi-eye',
      command: () => {
        viewApplication(data.id);
      }
    },
    {
      label: 'Delete',
      icon: 'pi pi-trash',
      command: () => {
        confirmDelete(data);
      }
    },
    {
      separator: true
    },
    {
      label: 'Update',
      icon: 'pi pi-refresh',
      command: () => {
        toast.add({ severity: 'success', summary: 'Updated', detail: 'Data Updated', life: 3000 });
      }
    },
    {
      label: 'Quit',
      icon: 'pi pi-sign-out',
      command: () => {
        window.location.href = 'https://vuejs.org/';
      }
    }
  ];
};

const save = () => {
  toast.add({ severity: 'success', summary: 'Success', detail: 'Data Saved', life: 3000 });
};









 const tableHeaders = [
   { id: 'serial', label: 'ক্রমিক নং' },
   { id: 'number', label: 'আবেদন নং' },
   { id: 'name', label: 'মাদ্রাসার নাম' },
   { id: 'class', label: 'ইলহাক নং' },
   { id: 'code', label: 'কোড' },
   { id: 'studentNumber', label: 'ছাত্র সংখ্যা' },
   { id: 'applicantType', label: 'আবেদনকারীর ধরন' },
   { id: 'madrasahNumber', label: 'মাদ্রাসা সংখ্যা' },
   { id: 'boardStatus', label: 'বোর্ড স্ট্যাটাস' },
   { id: 'actions', label: 'একশন' }
 ];

 // Original filters from your code
 const filters = reactive({
   madrasahName: '',
   type: '',
   status: '',
   applicationNumber: '',
   examSelection: '',
   applicantType: '',
   division: '',
   district: '',
   subDistrict: ''
 });

 // PrimeVue DataTable filters
 const tableFilters = ref({
   global: { value: null, matchMode: FilterMatchMode.CONTAINS },
   number: { value: null, matchMode: FilterMatchMode.CONTAINS },
   madrasha_Name: { value: null, matchMode: FilterMatchMode.CONTAINS },
   Elhaq_no: { value: null, matchMode: FilterMatchMode.CONTAINS },
   madrasha_code: { value: null, matchMode: FilterMatchMode.CONTAINS },
   studentNumber: { value: null, matchMode: FilterMatchMode.CONTAINS },
   markaz_type: { value: null, matchMode: FilterMatchMode.EQUALS },
   madrasahNumber: { value: null, matchMode: FilterMatchMode.CONTAINS },
   status: { value: null, matchMode: FilterMatchMode.EQUALS }
 });

 // Sample applications data
 const applications = ref([]);
 const loading = ref(true);

 // Options for dropdown filters
 const markazTypes = ref(['দরসিয়াত', 'হিফজ', 'কিরআত']);
 const statusOptions = ref(['বোর্ড দাখিল', 'বোর্ড ফেরত', 'অনুমোদন']);

 // Fetch applications data
 const fetchApplications = async () => {
   loading.value = true;
   try {
     const response = await axios.get('/api/markaz-agreements');
     applications.value = response.data;
   } catch (error) {
     console.error("Error fetching data:", error);
     toast.add({
       severity: 'error',
       summary: 'ত্রুটি',
       detail: 'আবেদন লোড করতে সমস্যা হয়েছে',
       life: 3000
     });
   } finally {
     loading.value = false;
   }
 };

 onMounted(fetchApplications);

 // Clear all filters
 const clearFilter = () => {
   tableFilters.value = {
     global: { value: null, matchMode: FilterMatchMode.CONTAINS },
     number: { value: null, matchMode: FilterMatchMode.CONTAINS },
     madrasha_Name: { value: null, matchMode: FilterMatchMode.CONTAINS },
     Elhaq_no: { value: null, matchMode: FilterMatchMode.CONTAINS },
     madrasha_code: { value: null, matchMode: FilterMatchMode.CONTAINS },
     studentNumber: { value: null, matchMode: FilterMatchMode.CONTAINS },
     markaz_type: { value: null, matchMode: FilterMatchMode.EQUALS },
     madrasahNumber: { value: null, matchMode: FilterMatchMode.CONTAINS },
     status: { value: null, matchMode: FilterMatchMode.EQUALS }
   };
 };

 // Get severity for status tag
 const getStatusSeverity = (status) => {
   switch (status) {
     case 'বোর্ড দাখিল':
       return 'warning';
     case 'বোর্ড ফেরত':
       return 'danger';
     case 'অনুমোদন':
       return 'success';
     default:
       return 'info';
   }
 };

 // Original functions from your code
 const getStatusClass = (status) => {
   return status === 'বোর্ড দাখিল' ? 'text-green-600' : 'text-yellow-600';
 };





 // View application details
 const viewApplication = (id) => {
   router.get(route('AdminMarkaz.view', id));
 };

 // Delete application
 const confirmDelete = (application) => {
   confirm.require({
     message: 'আপনি কি এই আবেদনটি মুছে ফেলতে চান?',
     header: 'নিশ্চিতকরণ',
     icon: 'pi pi-exclamation-triangle',
     acceptLabel: 'হ্যাঁ',
     rejectLabel: 'না',
     accept: () => {
       deleteApplication(application);
     }
   });
 };

 const deleteApplication = (application) => {
   try {
     // Here you would typically make an API call to delete the application
     // axios.delete(`/api/markaz-agreements/${application.id}`);

     // For now, just filter it out from the local array
     applications.value = applications.value.filter(app => app.id !== application.id);

     toast.add({
       severity: 'success',
       summary: 'সফল',
       detail: 'আবেদন সফলভাবে মুছে ফেলা হয়েছে',
       life: 3000
     });
   } catch (error) {
     console.error("Error deleting application:", error);
     toast.add({
       severity: 'error',
       summary: 'ত্রুটি',
       detail: 'আবেদন মুছতে সমস্যা হয়েছে',
       life: 3000
     });
   }
 };

 const editApplication = (application) => {
   // Implement edit logic
   alert(`Editing application: ${application.name}`);
 };
 </script>


   <style scoped>

   </style>
