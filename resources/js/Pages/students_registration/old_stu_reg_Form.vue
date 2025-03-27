<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

// Define all reactive variables
const examName = ref('');
const marhalaName = ref('');
const students = ref([]);
const years = ref([]);
const loading = ref(false);
const currentMarhalaId = ref(null);

// Search filters
const selectedMarhala = ref('');
const selectedYear = ref('');
const rollNumber = ref('');
const registrationNumber = ref('');

// Computed property for filtered marhalas
const availableMarhalas = computed(() => {
    const allMarhalas = [
        { id: '2', name: 'ফযীলত' },
        { id: '3', name: 'সানাবিয়া উলইয়া' },
        { id: '4', name: 'সানাবিয়া' },
        { id: '5', name: 'মুতাওয়াসসিতাহ' },
        { id: '6', name: 'ইবতিদাইয়্যাহ' },
        { id: '7', name: 'হিফযুল কুরআন' },
        { id: '8', name: 'ইলমুত তাজবীদ ওয়াল ক্বিরাআত' }
    ];

    // If marhalaId is 9, only show first two options
    if (currentMarhalaId.value === '9') {
        return allMarhalas.filter(marhala => ['2', '3'].includes(marhala.id));
    }

    if (currentMarhalaId.value === '10') {
        return allMarhalas.filter(marhala => ['4', '3'].includes(marhala.id));
    }

    if (currentMarhalaId.value === '11') {
        return allMarhalas.filter(marhala => ['5', '4'].includes(marhala.id));
    }

    if (currentMarhalaId.value === '12') {
        return allMarhalas.filter(marhala => ['6', '5'].includes(marhala.id));
    }

    if (currentMarhalaId.value === '14') {
        return allMarhalas.filter(marhala => ['6', '7'].includes(marhala.id));
    }
    return allMarhalas;
});

// Only one onMounted hook
onMounted(async () => {
    const marhalaId = route().params.marhalaId;
    currentMarhalaId.value = marhalaId;

    try {
        const response = await axios.get(`/api/student-registration/${marhalaId}`);
        examName.value = response.data.examName;
        marhalaName.value = response.data.marhalaName;
        console.log("Exam name:", examName.value);
        console.log("Marhala name:", marhalaName.value);
    } catch (error) {
        console.error("Error fetching marhala info:", error);
    }

    // Fetch years from students table
    fetchYears();
});

const fetchYears = async () => {
    try {
        const response = await axios.get('/api/student-years');
        years.value = response.data;
    } catch (error) {
        console.error('Error fetching years:', error);
    }
};

const searchStudents = async () => {
    loading.value = true;
    try {
        // এখানে পরিবর্তন করা হয়েছে - marhalaId হেডারে পাঠানো হচ্ছে
        const response = await axios.get('/api/search-students', {
            params: {
                marhala: selectedMarhala.value,
                year: selectedYear.value,
                roll: rollNumber.value,
                registration: registrationNumber.value
            },
            headers: {
                'marhalaId': currentMarhalaId.value // রাউট থেকে পাওয়া marhalaId হেডারে পাঠাচ্ছি
            }
        });
        students.value = response.data;
    } catch (error) {
        if (error.response && error.response.status === 404) {
            // যদি 404 এরর আসে (রেজাল্ট না পাওয়া গেলে)
            students.value = [];
            alert('রেজাল্ট পাওয়া যায়নি');
        } else {
            console.error('Error searching students:', error);
        }
    } finally {
        loading.value = false;
    }
};

const resetSearch = () => {
    selectedMarhala.value = '';
    selectedYear.value = '';
    rollNumber.value = '';
    registrationNumber.value = '';
    students.value = [];
};





// 1. Base64 এনকোডিং ব্যবহার করে URL তৈরি
const getEditUrl = (student) => {
  if (!student) return '#';

  // Roll এবং reg_id কে একটি স্ট্রিং-এ যোগ করে Base64 এনকোড করুন
  const encodedData = btoa(`${student.Roll}:${student.reg_id}:${student.CID}`);

  return route('students_registration.old_stu_reg_edit', {
    data: encodedData
  });
};





</script>

<template>
 <AuthenticatedLayout>
    <div class="mb-8 mt-5 mx-5">
    <div class="bg-white rounded-md shadow-md">
      <!-- Header Section with Islamic Pattern -->
      <header class="bg-emerald-900 p-3 rounded-t-md islamic-pattern">
        <div class="flex justify-between items-center">
            <h2 class="flex text-2xl text-white font-medium gap-2 items-center">
                {{ examName }}: {{ marhalaName }}
            </h2>

          <div class="flex gap-4">
            <Link
  :href="route('students_registration.new_stu_reg_Form', { marhalaId: currentMarhalaId })"
  class="flex bg-emerald-600 rounded-sm text-white duration-200 gap-2 hover:bg-emerald-700 items-center px-4 py-2 transition-colors"
>
  <i class="fa-user-plus fas"></i>
  <span>নতুন ছাত্র নিবন্ধন</span>
</Link>

            <Link
            :href="route('students_registration.student_reg_table')"
            class="bg-teal-600 rounded-sm text-white hover:bg-teal-700 inline-flex items-center px-4 py-2 transition-colors">
              <i class="fa-list-ul fas mr-2"></i>
              নিবন্ধন তালিকা
            </Link>
          </div>
        </div>
      </header>

      <!-- Search Section with Islamic Design -->
      <div class="bg-emerald-50 p-6">
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
          <div class="relative">
            <i class="text-emerald-600 -translate-y-1/2 absolute fa-school fas left-3 top-1/2"></i>
            <select
              v-model="selectedMarhala"
              class="border-emerald-200 rounded-sm w-full focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2"
            >
              <option value="">মারহালা নির্বাচন করুন</option>
              <option
                v-for="marhala in availableMarhalas"
                :key="marhala.id"
                :value="marhala.id"
              >
                {{ marhala.name }}
              </option>
            </select>
          </div>

          <div class="relative">
            <i class="text-emerald-600 -translate-y-1/2 absolute fa-calendar-alt fas left-3 top-1/2"></i>
            <select
              v-model="selectedYear"
              class="border-emerald-200 rounded-sm w-full focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2"
            >
              <option value="">পাশের সন নির্বাচন করুন</option>
              <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
            </select>
          </div>

          <div class="relative">
            <i class="text-emerald-600 -translate-y-1/2 absolute fa-id-card fas left-3 top-1/2"></i>
            <input
              v-model="rollNumber"
              type="text"
              placeholder="রোল নম্বর"
              class="border-emerald-200 rounded-sm w-full focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2"
            >
          </div>

          <div class="relative">
            <i class="text-emerald-600 -translate-y-1/2 absolute fa-address-card fas left-3 top-1/2"></i>
            <input
              v-model="registrationNumber"
              type="text"
              placeholder="রেজিস্ট্রেশন নম্বর"
              class="border-emerald-200 rounded-sm w-full focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2"
            >
          </div>
        </div>

        <div class="grid grid-cols-1 gap-6 items-start md:grid-cols-4">
          <div class="flex gap-4 md:col-start-4">
            <button
              @click="searchStudents"
              class="flex bg-emerald-600 rounded-sm text-white gap-2 hover:bg-emerald-700 items-center px-4 py-2 transition-colors"
              :disabled="loading"
            >
              <i class="fa-search fas"></i>
              <span v-if="loading">অপেক্ষা করুন...</span>
              <span v-else>সার্চ করুন</span>
            </button>
            <button
              @click="resetSearch"
              class="flex bg-red-600 rounded-sm text-white gap-2 hover:bg-red-700 items-center px-4 py-2 transition-colors"
            >
              <i class="fa-undo fas"></i>
              রেসেট
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="students.length > 0" class="bg-emerald-50 border border-emerald-200 p-6 w-full mt-8">
    <table class="border-collapse w-full">
      <thead class="bg-emerald-700 text-white">
        <tr>
          <th class="p-4 text-left">ছাত্রের তথ্য</th>
          <th class="p-4 text-left">বিগত পরীক্ষার তথ্য</th>
          <th class="p-4 text-center">একশন</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="student in students" :key="student.id" class="border-b border-emerald-200">
          <td class="p-4">
            <div class="space-y-2">
              <div class="flex gap-2 items-center">
                <i class="text-emerald-700 fa-user-graduate fas"></i>
                <span class="text-xl font-semibold">{{ student.Name }}</span>
              </div>
              <p class="text-xl">পিতা - {{ student.Father }}</p>
              <p class="text-xl">মাতা - {{ student.Mother || '' }}</p>
              <p class="text-xl">জন্ম-তারিখ: {{ student.DateofBirth }}</p>
              <p class="text-xl">
                পরীক্ষার্থীর ধরন:
                <span
                  :class="{
                    'text-green-600 font-medium': student.student_type === 'নিয়মিত ',
                    'text-amber-600 font-medium': student.student_type === 'অনিয়মিত যেমনী',
                    'text-red-600 font-medium': student.student_type === 'অনিয়মিত অন্যান্য'
                  }"
                >
                  {{ student.student_type }}
                </span>
              </p>
            </div>
          </td>
          <td class="p-4">
            <div class="space-y-2">
              <p class="text-xl">ক্লাস: {{ student.Class }}</p>
              <p class="text-xl">রেজিস্ট্রেশন নং - {{ student.reg_id }}</p>
              <p class="text-xl">নিবন্ধন নং - {{ student.Roll }}</p>
              <p class="text-xl">মাদরাসার নাম: {{ student.Madrasha }}</p>
              <p class="text-xl">মারকাযের নাম: {{ student.Markaj }}</p>
              <p v-if="student.Division" class="text-xl">
                ফলাফল:
                <span
                  :class="{
                    'text-green-600 font-medium': student.Division !== 'রাসিব',
                    'text-red-600 font-medium': student.Division === 'রাসিব'
                  }"
                >
                  {{ student.Division }}
                </span>
              </p>
            </div>
          </td>
          <td class="p-4 text-center">
            <div class="flex flex-col gap-3">




<Link
    :href="getEditUrl(student)"
    class="flex bg-emerald-700 justify-center rounded-md text-white duration-200 gap-2 hover:bg-emerald-800 items-center mx-auto px-6 py-2 transition-colors">
    <i class="fa-edit fas"></i>
    সংশোধন
  </Link>



            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

    <div v-else-if="loading" class="bg-emerald-50 border border-emerald-200 p-6 text-center w-full mt-8">
      <p class="text-lg">ডাটা লোড হচ্ছে...</p>
    </div>

    <div v-else-if="rollNumber || registrationNumber || selectedMarhala || selectedYear" class="bg-emerald-50 border border-emerald-200 p-6 text-center w-full mt-8">
      <p class="text-lg">কোন ডাটা পাওয়া যায়নি</p>
    </div>
  </div>
</AuthenticatedLayout>
</template>
