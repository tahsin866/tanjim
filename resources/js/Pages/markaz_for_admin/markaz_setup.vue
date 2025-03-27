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
        <div class="bg-white rounded-sm shadow-sm border border-gray-100 overflow-hidden">
          <div class="bg-[#2d6a4f] p-4 flex justify-between items-center">
            <h2 class="text-white text-lg font-semibold flex items-center gap-2">
              <i class="fas fa-search"></i>
              অনুসন্ধান ফিল্টার
            </h2>
            <div class="flex gap-2">
              <button @click="resetFilters" class="text-white hover:text-[#90caf9] flex items-center gap-1">
                <i class="fas fa-redo-alt"></i>
                রিসেট
              </button>
              <button @click="exportData" class="text-white hover:text-[#90caf9] flex items-center gap-1">
                <i class="fas fa-download"></i>
                এক্সপোর্ট
              </button>
            </div>
          </div>

          <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
              <div v-for="(field, index) in filterFields" :key="index"
                   class="bg-gray-50 p-4 rounded-sm hover:shadow-md transition-all duration-300">
                <label :for="field.id" class=" text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                  <i :class="field.icon" class="text-[#2d6a4f]"></i>
                  {{ field.label }}
                </label>
                <select v-if="field.type === 'select'"
                        v-model="filters[field.id]"
                        :id="field.id"
                        class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
                  <option value="">সকল</option>
                  <option v-for="option in field.options" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
                <input v-else
                       v-model="filters[field.id]"
                       :id="field.id"
                       :type="field.type"
                       :placeholder="field.placeholder"
                       class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f] focus:border-[#2d6a4f]">
              </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
              <button @click="search"
                      class="px-6 py-2 bg-[#2d6a4f] text-white rounded-sm hover:bg-[#1b4332] flex items-center gap-2">
                <i class="fas fa-search"></i>
                অনুসন্ধান করুন
              </button>
            </div>
          </div>
        </div>

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

          <div class="p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th v-for="header in tableHeaders" :key="header.id"
                        class="px-6 py-3 bg-gray-50 text-left text-xl font-semibold text-gray-500 uppercase tracking-wider">
                        {{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(application, index) in applications" :key="index"
                    class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-900">{{ index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-900">{{ application.number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-900">{{ application.madrasha_Name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-900">{{ application.Elhaq_no }}</td>

                    <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-900">{{ application.madrasha_code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-900">{{ application.studentNumber }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-900">{{ application.markaz_type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-900">{{ application.madrasahNumber }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xl">
    <span
        :class="{
            'bg-yellow-300 text-black px-3 py-1 rounded': application.status === 'বোর্ড দাখিল',
         'bg-red-100 text-red-700 px-3 py-1 rounded': application.status === 'বোর্ড ফেরত',
            'bg-green-600 text-white px-3 py-1 rounded': application.status === 'অনুমোদন'
        }"
    >
        {{ application.status }}
    </span>
</td>

                    <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-500">
                        <div class="flex gap-2">
                            <button @click="router.get(route('AdminMarkaz.view', application.id))"
        class="text-blue-600 hover:text-blue-800">
    <i class="fas fa-eye"></i>
</button>


                            <button @click="deleteApplication(application)"
                                    class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

          <!-- Pagination -->
          <div class="bg-gray-50 px-6 py-4 flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
              <button class="btn-pagination">Previous</button>
              <button class="btn-pagination">Next</button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing
                  <span class="font-medium">1</span>
                  to
                  <span class="font-medium">10</span>
                  of
                  <span class="font-medium">{{ applications.length }}</span>
                  results
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                  <!-- Add pagination buttons here -->
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { ref, reactive,onMounted } from 'vue';
import axios from 'axios';
import { Link , router } from '@inertiajs/vue3';
  const filterFields = [
    {
      id: 'madrasahName',
      label: 'মাদ্রাসার নাম/কোড',
      type: 'text',
      placeholder: 'মাদ্রাসার নাম লিখুন',

    },
    {
      id: 'type',
      label: 'মাদ্রাসার ধরন',
      type: 'select',

      options: [
        { value: 'dakhil', label: 'দাখিল' },
        { value: 'alim', label: 'আলিম' }
      ]
    },
    {
      id: 'status',
      label: 'কেন্দ্রীয় পরীক্ষা নির্বাচন করুন',
      type: 'select',

      options: [
        { value: 'pending', label: 'অপেক্ষমান' },
        { value: 'approved', label: 'অনুমোদিত' }
      ]
    },
    // Add other filter fields...
    {
      id: 'status',
      label: 'আবেদনের ধরন নির্বাচন',
      type: 'select',

      options: [
        { value: 'pending', label: 'অপেক্ষমান' },
        { value: 'approved', label: 'অনুমোদিত' }
      ]
    },
    {
      id: 'status',
      label: 'অবস্থা',
      type: 'select',

      options: [
        { value: 'pending', label: 'অপেক্ষমান' },
        { value: 'approved', label: 'অনুমোদিত' }
      ]
    },
    {
      id: 'status',
      label: 'বিভাগ',
      type: 'select',

      options: [
        { value: 'pending', label: 'অপেক্ষমান' },
        { value: 'approved', label: 'অনুমোদিত' }
      ]
    },
    {
      id: 'status',
      label: 'জেলা',
      type: 'select',

      options: [
        { value: 'pending', label: 'অপেক্ষমান' },
        { value: 'approved', label: 'অনুমোদিত' }
      ]
    },
    {
      id: 'status',
      label: 'থানা/উপজেলা',
      type: 'select',

      options: [
        { value: 'pending', label: 'অপেক্ষমান' },
        { value: 'approved', label: 'অনুমোদিত' }
      ]
    },
  ];

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

  // Sample applications data
const applications = ref([]);

//   const getStatusClass = (status) => {
//     return {
//       'px-2 py-1 text-xs font-medium rounded-full': true,
//       'bg-yellow-100 text-yellow-800': status === 'pending',
//       'bg-green-100 text-green-800': status === 'approved',
//       'bg-red-100 text-red-800': status === 'rejected'
//     };
//   };

  const fetchApplications = async () => {
    try {
        const response = await axios.get('/api/markaz-agreements');
        applications.value = response.data;
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};




onMounted(fetchApplications);

const getStatusClass = (status) => {
    return status === 'বোর্ড দাখিল' ? 'text-green-600' : 'text-yellow-600';
};

const viewApplication = (application) => {
    alert(`Viewing application: ${application.name}`);
};

const editApplication = (application) => {
    alert(`Editing application: ${application.name}`);
};

const deleteApplication = (application) => {
    if (confirm(`Are you sure you want to delete ${application.name}?`)) {
        applications.value = applications.value.filter(app => app.id !== application.id);
    }
};



  const search = () => {
    // Implement search logic
  };

  const resetFilters = () => {
    Object.keys(filters).forEach(key => filters[key] = '');
  };





  const exportData = () => {
    // Implement export logic
  };

//   const viewApplication = (application) => {
//     // Implement view logic
//   };

//   const editApplication = (application) => {
//     // Implement edit logic
//   };

//   const deleteApplication = (application) => {
//     // Implement delete logic
//   };
  </script>

  <style scoped>

  </style>
