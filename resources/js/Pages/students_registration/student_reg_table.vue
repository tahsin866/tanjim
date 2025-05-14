<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { useConfirm } from 'primevue/useconfirm';
// import ConfirmPopup from 'primevue/confirmpopup';
import ConfirmDialog from 'primevue/confirmdialog';
// Then add this line in your setup script
const confirm = useConfirm();


import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Calendar from 'primevue/calendar';
import Tag from 'primevue/tag';
import Menu from 'primevue/menu';
import Dialog from 'primevue/dialog';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import SplitButton from 'primevue/splitbutton';



const students = ref([]);
const loading = ref(true);
const error = ref(null);
const showModal = ref(false);
const showToast = ref(false);
// let submitId = null;

onMounted(async () => {
  try {
    loading.value = true;
    const response = await axios.get('/api/students-registration');
    // Add showMenu property to each student
    students.value = response.data.map(student => ({
      ...student,
      showMenu: false
    }));
  } catch (err) {
    error.value = 'ডাটা লোড করতে সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।';
    console.error(err);
  } finally {
    loading.value = false;
  }

  // Add click outside listener to close menus
  document.addEventListener('click', closeAllMenus);
});

onUnmounted(() => {
  // Remove click outside listener
  document.removeEventListener('click', closeAllMenus);
});

const handleSearch = () => {
  // Implement search logic
}

const resetSearch = () => {
  search.value = ''
  searchMobile.value = ''
}

// Close all menus when clicking outside
function closeAllMenus(event) {
  if (!event.target.closest('.relative')) {
    students.value.forEach(student => {
      student.showMenu = false;
    });
  }
}

const openModal = (id) => {
  submitId = id;
  showModal.value = true;
};








// delete student funtion

const emit = defineEmits(['deleted'])






const showDeleteModal = ref(false)


const closeMenu = () => {
  showMenu.value = false
}


const openDeleteModal = (id) => {
  deleteId.value = id
  showDeleteModal.value = true
  closeMenu()
}










// Filter options
const marhalOptions = ref([
  { name: 'ফযীলত', value: 'ফযীলত' },
  { name: 'সানাবিয়া উলিয়া', value: 'সানাবিয়া উলিয়া' },
  { name: 'সানাবিয়া', value: 'সানাবিয়া' },
  { name: 'মুতাওয়াসসিতা', value: 'মুতাওয়াসসিতা' },
  { name: 'ইবতিদাইয়া', value: 'ইবতিদাইয়া' },
  { name: 'তাহফিজুল কুরআন', value: 'তাহফিজুল কুরআন' },
  { name: 'ইলমুত তাজবীদ ওয়াল কিরাআত', value: 'ইলমুত তাজবীদ ওয়াল কিরাআত' },
]);

const studentTypeOptions = ref([
  { name: 'নিয়মিত', value: 'নিয়মিত' },
  { name: 'অনিয়মিত', value: 'অনিয়মিত' },
  { name: 'অন্যান্য', value: 'অন্যান্য' },
  { name: 'মানউন্নয়ন', value: 'মানউন্নয়ন' }
]);

const paymentStatusOptions = ref([
  { name: 'পরিশোধিত', value: 'পরিশোধিত' },
  { name: 'অপরিশোধিত', value: 'অপরিশোধিত' }
]);

const applicationStatusOptions = ref([
  { name: 'বোর্ড দাখিল', value: 'বোর্ড দাখিল' },
  { name: 'বোর্ড ফেরত', value: 'বোর্ড ফেরত' },
  { name: 'অনুমোদন', value: 'অনুমোদন' }
]);

// Initialize filters
const filters = ref({
  global: { value: null },
  id: { value: null },
  name_bn: { value: null },
  father_name_bn: { value: null },
  current_madrasha: { value: null},
  exam_name_Bn: { value: null },
  current_class: { value: null },
  Date_of_birth: { value: null },
  student_type: { value: null },
  payment_status: { value: null },
  status: { value: null }
});

// Menu references


// Functions
const getStatusSeverity = (status) => {
  switch (status) {
    case 'বোর্ড দাখিল':
      return 'warning';
    case 'বোর্ড ফেরত':
      return 'danger';
    case 'অনুমোদন':
      return 'success';
    default:
      return null;
  }
};






const toast = useToast();
const menu = ref();
const submitId = ref(null);
const deleteId = ref(null);

const toggleMenu = (event, data) => {
  menu.value.toggle(event);
};

const getDropdownItems = (data) => {
  return [
    {

      label: 'এডিট',
      icon: 'pi pi-pencil',
      command: () => router.visit(route('students_registration.student_registration_edit', data.id))
    },
    {
      label: 'বিস্তারিত দেখুন',
      icon: 'pi pi-info-circle',
      command: () => router.visit(route('students_registration.student_registraion_view', data.id))
    },
    {
      separator: true
    },
    {
      label: 'মুছে ফেলুন',
      icon: 'pi pi-trash',
      command: (event) => openDeleteConfirm(event, data.id)
    }
  ];
};

const openSubmitConfirm = (event, id) => {
  submitId.value = id;
  confirm.require({
    group: 'submitConfirm',
    header: 'বোর্ড দাখিল করুন',
    message: 'আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?',
    icon: 'pi pi-paper-plane',
    acceptClass: 'p-button-success',
    acceptIcon: 'pi pi-check',
    acceptLabel: 'সাবমিট করুন',
    rejectClass: 'p-button-text',
    rejectIcon: 'pi pi-times',
    rejectLabel: 'বাতিল করুন',
    accept: () => {
      submitApplication();
    },
    reject: () => {
      toast.add({ severity: 'info', summary: 'বাতিল করা হয়েছে', detail: 'আপনি সাবমিট বাতিল করেছেন', life: 3000 });
    }
  });
};


const openDeleteConfirm = (event, id) => {
  deleteId.value = id;
  confirm.require({
    group: 'deleteConfirm',
    header: 'সতর্কীকরণ!',
    message: 'আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান? এই কাজটি অপরিবর্তনীয়!',
    icon: 'pi pi-exclamation-triangle',
    acceptClass: 'p-button-danger',
    acceptIcon: 'pi pi-trash',
    acceptLabel: 'মুছে ফেলুন',
    rejectClass: 'p-button-text',
    rejectIcon: 'pi pi-times',
    rejectLabel: 'বাতিল করুন',
    accept: () => {
      deleteStudent();
    },
    reject: () => {
      toast.add({ severity: 'info', summary: 'বাতিল করা হয়েছে', detail: 'আপনি মুছে ফেলা বাতিল করেছেন', life: 3000 });
    }
  });
};






const submitApplication = () => {
  router.post(route('student_reg.submit', submitId.value), {}, {
    preserveScroll: true,
    onSuccess: () => {
      toast.add({ severity: 'success', summary: 'সফল', detail: 'আবেদন সফলভাবে সাবমিট করা হয়েছে', life: 3000 });
      setTimeout(() => window.location.reload(), 2000);
    },
    onError: (errors) => {
      if (errors.error) {
        toast.add({ severity: 'error', summary: 'ত্রুটি', detail: errors.error, life: 3000 });
      }
    }
  });
};

const deleteStudent = () => {
  router.delete(route('students.delete', { id: deleteId.value }), {
    preserveScroll: true,
    onSuccess: () => {
      toast.add({ severity: 'success', summary: 'সফল', detail: 'আবেদন সফলভাবে মুছে ফেলা হয়েছে', life: 3000 });
      setTimeout(() => window.location.reload(), 2000);
    },
    onError: (errors) => {
      if (errors.error) {
        toast.add({ severity: 'error', summary: 'ত্রুটি', detail: errors.error, life: 3000 });
      }
    }
  });
};



const studentStats = ref({
    totalStudents: 0,
    boardSubmittedStudents: 0,
    approvedStudents: 0,
    boardReturnedStudents: 0
});



onMounted(async () => {
    try {
        const response = await axios.get('/api/dashboard/student-stats');
        studentStats.value = response.data;
        loading.value = false;
    } catch (err) {
        error.value = 'ডাটা লোড করতে সমস্যা হয়েছে';
        loading.value = false;
        console.error(err);
    }
});





</script>


<template>
<AuthenticatedLayout>
    <div class="p-4 mt-5 mx-auto">


        <div style="font-family: 'Merriweather','SolaimanLipi',sans-serif;"
     class="mb-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total Students Card -->
    <div class="bg-gradient-to-br from-green-50 to-white rounded-md p-6 border border-green-100 hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div class="space-y-4">
                            <div class="flex items-baseline space-x-2">
                                <span class="text-green-600 text-sm font-semibold">{{ studentStats.totalStudents }} জন</span>
                            </div>
                            <p class="text-green-900 font-medium">মোট নিবন্ধিত শিক্ষার্থী সংখ্যা</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4v6m-4 4h16M4 14l8-8 8 8M4 20h16"/>
                            </svg>
                        </div>
                    </div>
                </div>

    <!-- Board Return Students Card -->
    <div class="bg-gradient-to-br from-teal-50 to-white rounded-md p-6 border border-teal-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-teal-600 text-sm font-semibold"> {{ studentStats.boardReturnedStudents }}  জন</span>
                </div>
                <p class="text-teal-900 font-medium">বোর্ড ফেরত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-teal-100 p-3 rounded-xl">
                <!-- Prayer Beads Icon -->
                <svg class="w-8 h-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c.5-1.7 3.5-1.7 4 0 .5 1.7-3.5 1.7-4 0zm0 18c-.5 1.7-3.5 1.7-4 0-.5-1.7 3.5-1.7 4 0zm7-9c1.7-.5 1.7-3.5 0-4-1.7-.5-1.7 3.5 0 4zM5 12c-1.7.5-1.7-3.5 0-4 1.7-.5 1.7 3.5 0 4z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Female Students Card -->
    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-md p-6 border border-emerald-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-emerald-600 text-sm font-semibold">{{ studentStats.boardSubmittedStudents }} জন</span>
                </div>
                <p class="text-emerald-900 font-medium"> বোর্ড দাখিল শিক্ষার্থীর সংখ্যা </p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-xl">
                <!-- Quran Icon -->
                <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Year Total Card -->
    <div class="bg-gradient-to-br from-green-50 to-white rounded-md p-6 border border-green-100 hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-green-600 text-sm font-semibold"> {{ studentStats.approvedStudents }} জন</span>
                </div>
                <p class="text-green-900 font-medium">বোর্ড অনুমদিত ছাত্র সংখ্যা </p>
            </div>
            <div class="bg-green-100 p-3 rounded-xl">
                <!-- Minaret Icon -->
                <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>
</div>














<div class="bg-white rounded-sm shadow-lg mb-6">
    <!-- Header with Islamic pattern -->
    <div class="bg-emerald-900 p-3 rounded-t-sm islamic-pattern">
      <div class="grid grid-cols-1 gap-4 items-center md:grid-cols-3">
        <h3 class="text-amber-400 text-lg font-bold">
          <i class="fa-search-plus fas ml-2"></i> সার্চ উইযার্ড
        </h3>
        <h3 class="text-center text-lg text-white">
          <!-- ৪৮তম কেন্দ্রীয় পরীক্ষা: নেগরান মুমতাহিন -->
        </h3>
        <div class="flex justify-end gap-3">
          <Link
            :href="route('students_registration.student_registration')"
            class="flex bg-emerald-600 rounded-sm text-white duration-200 gap-2 hover:bg-emerald-700 items-center px-4 py-2 transition-colors"
          >
            <i class="fa-user-plus fas"></i>
            <span>নিবন্ধন করুন</span>
          </Link>
          <Button
            icon="pi pi-file-import"
            label="ইম্পোর্ট করুন"
            class="p-button-teal"
          />
        </div>
      </div>
    </div>
  </div>

  <!-- Data Table -->
  <div class="bg-white rounded-sm shadow-lg">
    <!-- Header with Islamic pattern -->
    <div class="bg-emerald-900 p-3 rounded-t-sm islamic-pattern">
      <div class="grid grid-cols-1 gap-4 items-center md:grid-cols-3">
        <h3 class="text-amber-300 text-lg font-bold">
          <i class="fa-users-class fas ml-2"></i> মোট নিবন্ধিত ছাত্র সংখ্যা
        </h3>
        <h3 class="text-amber-300 text-center text-lg">
          <!-- ৪৮তম কেন্দ্রীয় পরীক্ষা: মুতাওয়াসসিতা -->
        </h3>
        <div class="flex justify-end gap-3">
          <Button
            icon="pi pi-file-pdf"
            label="PDF ডাউনলোড"
            class="p-button-warning"
          />
          <Button
            icon="pi pi-paper-plane"
            label="বোর্ড দাখিল"
            class="p-button-success"
          />
        </div>
      </div>
    </div>

    <div class="p-4">
      <DataTable
        :value="students"
        v-model:filters="filters"
        filterDisplay="menu"
        :loading="loading"
        dataKey="id"
        paginator
        :rows="10"
        :rowsPerPageOptions="[5, 10, 25, 50,100]"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        currentPageReportTemplate="দেখানো হচ্ছে {first} থেকে {last} মোট {totalRecords} এর মধ্যে"
        responsiveLayout="stack"
        breakpoint="960px"
    class="p-datatable-sm"
    :scrollable="true"
    scrollHeight="flex"
    :resizableColumns="true"
    columnResizeMode="fit"
    showGridlines
    stripedRows
        :globalFilterFields="['id', 'name_bn', 'father_name_bn', 'current_madrasha', 'exam_name_Bn', 'current_class', 'Date_of_birth', 'student_type', 'payment_status', 'status']"
      >
        <template #header>
          <div class="flex justify-between items-center">
            <div>
              <span class="p-input-icon-left">

                <InputText v-model="filters['global'].value" placeholder="সার্চ করুন..." />
              </span>
            </div>
          </div>
        </template>

        <Column field="id" header="রেজিস্ট্রেশন নং" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." />
          </template>
        </Column>

        <Column header="ছবি" style="min-width: 12rem">
          <template #body="{ data }">
            <div class="relative mx-auto w-24 h-24 overflow-hidden border-2 border-gray-200 rounded-lg shadow-md bg-white">
              <div class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-yellow-500"></div>
              <div class="absolute top-0 right-0 w-3 h-3 border-t-2 border-r-2 border-yellow-500"></div>
              <div class="absolute bottom-0 left-0 w-3 h-3 border-b-2 border-l-2 border-yellow-500"></div>
              <div class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-yellow-500"></div>
              <div class="w-full h-full flex items-center justify-center p-1">
                <img
                  v-if="data.student_image"
                  :src="'/storage/' + data.student_image"
                  alt="Student"
                  class="w-full h-full object-cover rounded"
                />
                <div
                  v-else
                  class="w-full h-full rounded bg-gradient-to-r from-gray-100 to-gray-200 flex flex-col items-center justify-center"
                >
                  <i class="pi pi-user text-4xl text-gray-400"></i>
                  <span class="text-gray-500 text-xs mt-1">No Image</span>
                </div>
              </div>
              <div class="absolute inset-0 shadow-inner rounded-lg pointer-events-none"></div>
            </div>
          </template>
        </Column>

        <Column field="name_bn" header="নাম" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." />
          </template>
        </Column>

        <Column field="father_name_bn" header="পিতার নাম" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." />
          </template>
        </Column>

        <Column field="current_madrasha" header="মাদরাসার নাম" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." />
          </template>
        </Column>

        <Column field="exam_name_Bn" header="পরীক্ষার নাম" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="সার্চ করুন..." />
          </template>
        </Column>

        <Column field="current_class" header="মারহালা" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <Dropdown
              v-model="filterModel.value"
              @change="filterCallback()"
              :options="marhalOptions"
              placeholder="সিলেক্ট করুন"
              optionLabel="name"
              optionValue="value"
              class="p-column-filter"
            />
          </template>
        </Column>

        <Column field="Date_of_birth" header="জন্ম-তারিখ" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <Calendar v-model="filterModel.value" @date-select="filterCallback()" dateFormat="dd/mm/yy" placeholder="তারিখ সিলেক্ট করুন" />
          </template>
        </Column>

        <Column field="student_type" header="পরীক্ষার্থীর ধরন" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <Dropdown
              v-model="filterModel.value"
              @change="filterCallback()"
              :options="studentTypeOptions"
              placeholder="সিলেক্ট করুন"
              optionLabel="name"
              optionValue="value"
              class="p-column-filter"
            />
          </template>
          <template #body="{ data }">
            {{ data.student_type }}
          </template>
        </Column>

        <Column field="payment_status" header="পেমেন্ট স্ট্যাটাস" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <Dropdown
              v-model="filterModel.value"
              @change="filterCallback()"
              :options="paymentStatusOptions"
              placeholder="সিলেক্ট করুন"
              optionLabel="name"
              optionValue="value"
              class="p-column-filter"
            />
          </template>
          <template #body="{ data }">
            <Tag
              :value="data.payment_status"
              :severity="data.is_paid ? 'success' : 'danger'"
              class="text-sm"
            />
          </template>
        </Column>

        <Column field="status" header="আবেদন অবস্থা" sortable style="min-width: 12rem">
          <template #filter="{ filterModel, filterCallback }">
            <Dropdown
              v-model="filterModel.value"
              @change="filterCallback()"
              :options="applicationStatusOptions"
              placeholder="সিলেক্ট করুন"
              optionLabel="name"
              optionValue="value"
              class="p-column-filter"
            />
          </template>
          <template #body="{ data }">
            <Tag
              :value="data.status"
              :severity="getStatusSeverity(data.status)"
              class="text-sm"
            />
          </template>
        </Column>

        <Column header="করনীয়" style="min-width: 10rem">
  <template #body="{ data }">
    <div class="flex justify-center">
      <Toast />
      <SplitButton

        label="বোর্ড দাখিল"
        icon="pi pi-upload"
        @click="openSubmitConfirm($event, data.id)"
        :model="getDropdownItems(data)"
        class="p-button-sm"
      />
    </div>
  </template>
</Column>

      </DataTable>
    </div>
  </div>

  <!-- Submit Modal -->
  <Dialog v-model:visible="showModal" modal header="বোর্ড দাখিল করুন" :style="{width: '450px'}" :closable="false">
    <div

    class="flex flex-column align-items-center p-4">
      <i class="pi pi-paper-plane text-4xl text-emerald-600 mb-3"></i>
      <p class="text-center">আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?</p>
    </div>
    <template

    #footer>
      <Button

      label="বাতিল করুন" icon="pi pi-times"

       class="p-button-text" @click="showModal = false" />
      <Button label="সাবমিট করুন" icon="pi pi-check" class="p-button-success" @click="submitApplication" />
    </template>
  </Dialog>

  <!-- Delete Modal -->
  <Dialog v-model:visible="showDeleteModal" modal header="সতর্কীকরণ!" :style="{width: '450px'}" :closable="false">
    <div class="flex flex-column align-items-center p-4">
      <i class="pi pi-exclamation-triangle text-4xl text-red-600 mb-3"></i>
      <p class="text-center">আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?</p>
      <p class="text-red-600 text-center text-sm mt-2">এই কাজটি অপরিবর্তনীয়!</p>
    </div>
    <template #footer>
      <Button label="বাতিল করুন" icon="pi pi-times"  class="p-button-text" @click="showDeleteModal = false" />
      <Button label="মুছে ফেলুন" icon="pi pi-trash" class="p-button-danger" @click="deleteStudent" />
    </template>
  </Dialog>

  <!-- Toast for success messages -->
  <Toast />
 <ConfirmDialog group="submitConfirm">
      <template #message="slotProps">
        <div
style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
        class="flex flex-col items-center w-full gap-4 border-b border-surface-200 dark:border-surface-700 p-4 mb-4 pb-0">
          <i class="pi pi-paper-plane text-4xl text-emerald-600"></i>
          <p
          style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
          >আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?</p>
        </div>
      </template>
    </ConfirmDialog>

<ConfirmDialog group="deleteConfirm">
      <template #message="slotProps">
        <div class="flex flex-col items-center w-full gap-4 border-b border-surface-200 dark:border-surface-700 p-4 mb-4 pb-0">
          <i class="pi pi-exclamation-triangle text-4xl text-red-600"></i>
          <p
              style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
          >আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?</p>
          <p
    style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
          class="text-red-600 text-center text-sm mt-2">এই কাজটি অপরিবর্তনীয়!</p>
        </div>
      </template>
    </ConfirmDialog>

  </div>
</AuthenticatedLayout>
</template>
<style scoped>
/* You can add any custom styles here */

/* PrimeVue customizations */
:deep(.p-datatable .p-datatable-header) {
  background-color: #f0fdf4;
  border-top-left-radius: 0.25rem;
  border-top-right-radius: 0.25rem;
}

:deep(.p-datatable .p-datatable-thead > tr > th) {
  background-color: #f0fdf4;
  color: #065f46;
  font-weight: 600;
}

:deep(.p-button-success) {
  background-color: #059669;
  border-color: #059669;
}

:deep(.p-button-success:hover) {
  background-color: #047857;
  border-color: #047857;
}

:deep(.p-button-warning) {
  background-color: #f59e0b;
  border-color: #f59e0b;
}

:deep(.p-button-warning:hover) {
  background-color: #d97706;
  border-color: #d97706;
}

:deep(.p-button-teal) {
  background-color: #0d9488;
  border-color: #0d9488;
}

:deep(.p-button-teal:hover) {
  background-color: #0f766e;
  border-color: #0f766e;
}







:deep(.p-datatable-wrapper) {
  overflow-x: auto;
  max-width: 100%;
}

:deep(.p-datatable) {
  font-size: 0.9rem;
}

:deep(.p-datatable .p-datatable-tbody > tr > td) {
  padding: 0.5rem 0.5rem;
}

:deep(.p-datatable .p-datatable-thead > tr > th) {
  padding: 0.5rem 0.5rem;
}

:deep(.p-column-filter) {
  width: 100%;
}

/* মোবাইল ভিউতে স্ট্যাক লেআউট সাজানো */
@media screen and (max-width: 960px) {
  :deep(.p-datatable.p-datatable-sm .p-datatable-tbody > tr > td) {
    padding: 0.3rem 0.5rem;
  }

  :deep(.p-datatable-responsive-stack .p-datatable-tbody > tr > td .p-column-title) {
    font-weight: 600;
  }
}
</style>
