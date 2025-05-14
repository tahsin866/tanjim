<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { useConfirm } from 'primevue/useconfirm';
import ConfirmPopup from 'primevue/confirmpopup';

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

// const submitApplication = () => {
//   router.post(route('student_reg.submit', submitId), {}, {
//     preserveScroll: true,
//     onSuccess: () => {
//       showModal.value = false;
//       showToast.value = true;
//       setTimeout(() => window.location.reload(), 2000);
//     },
//     onError: (errors) => {
//       if (errors.error) {
//         alert(errors.error);
//       }
//     }
//   });
// };

// মেনু টগল করার ফাংশন
// const toggleMenu = (student) => {
//   // অন্য সব মেনু বন্ধ করা
//   students.value.forEach(s => {
//     if (s.id !== student.id) {
//       s.showMenu = false;
//     }
//   });

//   // বর্তমান মেনু টগল করা
//   student.showMenu = !student.showMenu;
// };

// মেনুর পজিশন নির্ধারণ করার ফাংশন
const getMenuPosition = (studentId) => {
  // DOM এলিমেন্টের পজিশন চেক করা
  const buttonElement = document.querySelector(`[data-student-id="${studentId}"]`);

  if (!buttonElement) return 'right-0';

  const rect = buttonElement.getBoundingClientRect();
  const spaceBelow = window.innerHeight - rect.bottom;
  const spaceRight = window.innerWidth - rect.right;

  // নিচে যথেষ্ট জায়গা না থাকলে উপরে দেখানো
  const verticalClass = spaceBelow < 200 ? 'bottom-full mb-2' : 'top-full mt-2';

  // ডানে যথেষ্ট জায়গা না থাকলে বামে দেখানো
  const horizontalClass = spaceRight < 200 ? 'right-full mr-2' : 'left-0';

  return `${verticalClass} ${horizontalClass}`;
};



// delete student funtion

const emit = defineEmits(['deleted'])

const closeDeleteModal = () => {
  showDeleteModal.value = false
}




const showDeleteModal = ref(false)
const showDeleteToast = ref(false)

const closeMenu = () => {
  showMenu.value = false
}

// const deleteId = ref(null)

const openDeleteModal = (id) => {
  deleteId.value = id
  showDeleteModal.value = true
  closeMenu()
}

// const deleteStudent = () => {
//     router.delete(route('students.delete', { id: deleteId.value }), {
//         onSuccess: () => {
//             showDeleteModal.value = false
//             showDeleteToast.value = true
//             setTimeout(() => {
//                 showDeleteToast.value = false
//                 window.location.reload()
//             }, 3000)
//         },
//     })
// }

const closeDeleteToast = () => {
  showDeleteToast.value = false
}




const FilterMatchMode = {
  STARTS_WITH: 'startsWith',
  CONTAINS: 'contains',
  EQUALS: 'equals',
  DATE_IS: 'dateIs'
};

// Component state
// const students = ref([]);
// const loading = ref(true);
const selectedStudentId = ref(null);
// const showModal = ref(false);
// const showDeleteModal = ref(false);


// Filter options
const marhalOptions = ref([
  { name: 'সানাবিয়া উলিয়া', value: 'সানাবিয়া উলিয়া' },
  { name: 'সানাবিয়া', value: 'সানাবিয়া' },
  { name: 'ফযীলত', value: 'ফযীলত' }
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
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  id: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  name_bn: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  father_name_bn: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  current_madrasha: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  exam_name_Bn: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  current_class: { value: null, matchMode: FilterMatchMode.EQUALS },
  Date_of_birth: { value: null, matchMode: FilterMatchMode.DATE_IS },
  student_type: { value: null, matchMode: FilterMatchMode.EQUALS },
  payment_status: { value: null, matchMode: FilterMatchMode.EQUALS },
  status: { value: null, matchMode: FilterMatchMode.EQUALS }
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

// const toggleMenu = (event, data) => {
//   menu.value.toggle(event);
//   selectedStudentId.value = data.id;
// };



// const openModal = (id) => {
//   selectedStudentId.value = id;
//   showModal.value = true;
// };

// const openDeleteModal = (id) => {
//   selectedStudentId.value = id;
//   showDeleteModal.value = true;
// };

// const submitApplication = () => {
//   // Implement your submit logic here
//   router.post(route('students_registration.submit_to_board', selectedStudentId.value), {}, {
//     onSuccess: () => {
//       showModal.value = false;
//       toast.add({ severity: 'success', summary: 'সফল', detail: 'আবেদন সফলভাবে সাবমিট হয়েছে!', life: 3000 });
//     }
//   });
// };

// const deleteStudent = () => {
//   // Implement your delete logic here
//   router.delete(route('students_registration.delete', selectedStudentId.value), {
//     onSuccess: () => {
//       showDeleteModal.value = false;
//       toast.add({ severity: 'success', summary: 'সফল', detail: 'আবেদন সফলভাবে মুছে ফেলা হয়েছে!', life: 3000 });
//     }
//   });
// };

// Load data
// onMounted(() => {
//   // Replace with your actual data fetching logic
//   router.get(route('students_registration.get_students'), {}, {
//     onSuccess: (page) => {
//       students.value = page.props.students;
//       loading.value = false;
//     }
//   });
// });








// const router = useRouter();
// const confirm = useConfirm();
const toast = useToast();
const menu = ref();
const submitId = ref(null);
const deleteId = ref(null);

const toggleMenu = (event, data) => {
  menu.value.toggle(event);
};

const getActionItems = (data) => {
  return [
    {
      label: 'বোর্ড দাখিল করুন',
      icon: 'pi pi-upload',
      command: () => openSubmitConfirm(event, data.id)
    },
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
      label: 'মুছে ফেলুন',
      icon: 'pi pi-trash',
      command: (event) => openDeleteConfirm(event, data.id)
    }
  ];
};

const openSubmitConfirm = (event, id) => {
  submitId.value = id;
  confirm.require({
    target: event.originalEvent.target,
    group: 'submitConfirm',
    message: 'আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?',
    icon: 'pi pi-paper-plane',
    acceptProps: {
      icon: 'pi pi-check',
      label: 'সাবমিট করুন',
      class: 'p-button-success'
    },
    rejectProps: {
      icon: 'pi pi-times',
      label: 'বাতিল করুন',
      outlined: true
    },
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
    target: event.originalEvent.target,
    group: 'deleteConfirm',
    message: 'আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?',
    icon: 'pi pi-exclamation-triangle',
    acceptProps: {
      icon: 'pi pi-trash',
      label: 'মুছে ফেলুন',
      class: 'p-button-danger'
    },
    rejectProps: {
      icon: 'pi pi-times',
      label: 'বাতিল করুন',
      outlined: true
    },
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
  router.delete(route('students_registration.delete', deleteId.value), {
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









</script>


<template>
<AuthenticatedLayout>
    <div class="p-4 mt-5 mx-auto">


      <div style="font-family: 'Merriweather','SolaimanLipi',sans-serif"
     class="grid grid-cols-1 gap-6 lg:grid-cols-4 mb-5 sm:grid-cols-2">

    <!-- Total Students Card -->
    <div class="bg-gradient-to-br border border-emerald-100 p-6 rounded-md duration-300 from-emerald-50 hover:shadow-lg islamic-pattern to-white transition-all">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-emerald-600 text-sm font-semibold">মোট</span>
                </div>
                <p class="text-emerald-900 font-medium">মোট নিবন্ধিত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-xl">
                <i class="text-2xl text-amber-600 fa-female fas"></i>
            </div>
        </div>
    </div>

    <!-- Board Return Students Card -->
    <div class="bg-gradient-to-br border border-teal-100 p-6 rounded-md duration-300 from-teal-50 hover:shadow-lg islamic-pattern to-white transition-all">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-sm text-teal-600 font-semibold">জন</span>
                </div>
                <p class="text-teal-900 font-medium">বোর্ড ফেরত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-teal-100 p-3 rounded-xl">
                <i class="text-2xl text-amber-600 fa-female fas"></i>
            </div>
        </div>
        <div class="border-t border-teal-100 mt-4 pt-4"></div>
    </div>

    <!-- Female Students Card -->
    <div class="bg-gradient-to-br border border-amber-100 p-6 rounded-md duration-300 from-amber-50 hover:shadow-lg islamic-pattern to-white transition-all">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-amber-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-amber-900 font-medium">নিয়মিত ছাত্র সংখ্যা</p>
            </div>
            <div class="bg-amber-100 p-3 rounded-xl">
                <i class="text-2xl text-amber-600 fa-female fas"></i>
            </div>
        </div>
        <div class="border-amber-100 border-t mt-4 pt-4"></div>
    </div>

    <!-- Year Total Card -->
    <div class="bg-gradient-to-br border border-emerald-100 p-6 rounded-md duration-300 from-emerald-50 hover:shadow-lg islamic-pattern to-white transition-all">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-emerald-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-emerald-900 font-medium">{{ selectedYear }} অনিয়মিত ছাত্র সংখ্যা</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-xl">
                <i class="text-2xl text-amber-600 fa-female fas"></i>
            </div>
        </div>
        <div class="border-emerald-100 border-t mt-4 pt-4"></div>
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
        :rowsPerPageOptions="[5, 10, 25, 50]"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        currentPageReportTemplate="দেখানো হচ্ছে {first} থেকে {last} মোট {totalRecords} এর মধ্যে"
        responsiveLayout="scroll"
        :globalFilterFields="['id', 'name_bn', 'father_name_bn', 'current_madrasha', 'exam_name_Bn', 'current_class', 'Date_of_birth', 'student_type', 'payment_status', 'status']"
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
          <Menu :model="getActionItems(data)" :popup="true" ref="menu" />
          <Button
            icon="pi pi-ellipsis-v"
            class="p-button-rounded p-button-text p-button-plain"
            @click="(event) => toggleMenu($event, data)"
          />
        </div>
      </template>
    </Column>
      </DataTable>
    </div>
  </div>

  <!-- Submit Modal -->
  <Dialog v-model:visible="showModal" modal header="বোর্ড দাখিল করুন" :style="{width: '450px'}" :closable="false">
    <div class="flex flex-column align-items-center p-4">
      <i class="pi pi-paper-plane text-4xl text-emerald-600 mb-3"></i>
      <p class="text-center">আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?</p>
    </div>
    <template #footer>
      <Button label="বাতিল করুন" icon="pi pi-times" class="p-button-text" @click="showModal = false" />
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
      <Button label="বাতিল করুন" icon="pi pi-times" class="p-button-text" @click="showDeleteModal = false" />
      <Button label="মুছে ফেলুন" icon="pi pi-trash" class="p-button-danger" @click="deleteStudent" />
    </template>
  </Dialog>

  <!-- Toast for success messages -->
  <Toast />
    <ConfirmPopup group="submitConfirm">
      <template #message="slotProps">
        <div class="flex flex-col items-center w-full gap-4 border-b border-surface-200 dark:border-surface-700 p-4 mb-4 pb-0">
          <i class="pi pi-paper-plane text-4xl text-emerald-600"></i>
          <p>আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?</p>
        </div>
      </template>
    </ConfirmPopup>

    <ConfirmPopup group="deleteConfirm">
      <template #message="slotProps">
        <div class="flex flex-col items-center w-full gap-4 border-b border-surface-200 dark:border-surface-700 p-4 mb-4 pb-0">
          <i class="pi pi-exclamation-triangle text-4xl text-red-600"></i>
          <p>আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?</p>
          <p class="text-red-600 text-center text-sm mt-2">এই কাজটি অপরিবর্তনীয়!</p>
        </div>
      </template>
    </ConfirmPopup>

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
</style>
