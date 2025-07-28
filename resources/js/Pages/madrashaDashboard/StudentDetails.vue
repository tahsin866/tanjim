<template>
  <AuthenticatedLayout style="font-family: 'SolaimanLipi', sans-serif;">
    <div class="min-h-screen bg-[#f4f6f8] py-10 px-2 sm:px-8">
      <div class=" mx-auto">

        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col sm:flex-row items-center gap-8 mb-10">
          <Avatar :image="getPhotoUrl(student.photo)" size="xlarge" shape="circle" class="border-4 border-gray-200 shadow-md" />
          <div class="flex-1 flex flex-col gap-2">
            <h2 class="text-3xl font-bold text-gray-800">{{ student.fullNameBangla || 'নাম নেই' }}</h2>
            <p class="text-gray-600 text-lg">{{ student.fullNameEnglish || 'No English Name' }}</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
              <p class="text-gray-500">ফোন: <span class="font-medium">{{ student.phoneNumber || 'নেই' }}</span></p>
              <p class="text-gray-500">বাবার নাম: <span class="font-medium">{{ student.fatherName || 'নেই' }}</span></p>
              <!-- <p class="text-gray-500">ইউজার আইডি: <span class="font-medium text-blue-600">#{{ student.id }}</span></p> -->
              <p class="text-gray-500">
                স্ট্যাটাস:
                <span :class="student.status === 'approved' ? 'text-green-600 font-medium' : student.status === 'rejected' ? 'text-red-600 font-medium' : 'text-orange-600 font-medium'">
                  {{ student.status === 'approved' ? 'অনুমোদিত' : student.status === 'rejected' ? 'প্রত্যাখ্যাত' : 'বিচারাধীন' }}
                </span>
              </p>
            </div>
          </div>
          <div class="flex flex-col gap-2">
            <Button label="এডিট" class="p-button-sm bg-indigo-600 text-white" icon="pi pi-pencil" @click="goToEditPage" />
            <Button label="প্রিন্ট" class="p-button-sm bg-gray-200 text-gray-700" icon="pi pi-print" @click="printDetails" />
          </div>
        </div>

        <!-- Quick Summary -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-md p-6 mb-8 text-white">
          <div class="text-xl font-semibold mb-4">তথ্য সারাংশ</div>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
              <div class="text-2xl font-bold">{{ getSelectedDepartmentsCount() }}</div>
              <div class="text-sm opacity-90">নির্বাচিত বিভাগ</div>
            </div>
            <div class="text-center">
              <div class="text-2xl font-bold">{{ getUploadedFilesCount() }}</div>
              <div class="text-sm opacity-90">আপলোড ফাইল</div>
            </div>
            <div class="text-center">
              <div class="text-2xl font-bold">{{ getClassmatesCount() }}</div>
              <div class="text-sm opacity-90">সহপাঠী তথ্য</div>
            </div>
            <div class="text-center">
              <div class="text-2xl font-bold">{{ getCompletionPercentage() }}%</div>
              <div class="text-sm opacity-90">সম্পূর্ণতা</div>
            </div>
          </div>
        </div>

        <!-- Personal & Address Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
          <div class="bg-white rounded-lg shadow p-6">
            <div class="text-xl font-semibold text-indigo-700 mb-4 border-b pb-2">ব্যক্তিগত তথ্য</div>
            <div class="grid grid-cols-2 gap-x-2 gap-y-4">
              <div class="font-medium text-gray-600">ইমেইল:</div>
              <div>{{ student.email || 'নেই' }}</div>
              <div class="font-medium text-gray-600">বিকল্প ফোন:</div>
              <div>{{ student.alternatePhoneNumber || 'নেই' }}</div>
              <div class="font-medium text-gray-600">জন্মতারিখ:</div>
              <div>{{ student.dateOfBirth || 'নেই' }}</div>
              <div class="font-medium text-gray-600">ব্লাড গ্রুপ:</div>
              <div>{{ student.bloodGroup || 'নেই' }}</div>
              <div class="font-medium text-gray-600">ঠিকানা:</div>
              <div>{{ student.address || 'নেই' }}</div>
            </div>
          </div>
          <div class="bg-white rounded-lg shadow p-6">
            <div class="text-xl font-semibold text-indigo-700 mb-4 border-b pb-2">ঠিকানা</div>
            <div class="grid grid-cols-2 gap-x-2 gap-y-4">
              <div class="font-medium text-gray-600">বিভাগ:</div>
      <div>{{ student.division_name_bangla || 'নির্বাচিত হয়নি' }}</div>
      <div class="font-medium text-gray-600">জেলা:</div>
<div>{{ student.district_name_bangla || 'নির্বাচিত হয়নি' }}</div>
<div class="font-medium text-gray-600">থানা:</div>
<div>{{ student.thana_name_bangla || 'নির্বাচিত হয়নি' }}</div>
            </div>
          </div>
        </div>

        <!-- Academic Info -->
                <!-- Academic Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
          <div class="text-xl font-semibold text-indigo-700 mb-4 border-b pb-2">শিক্ষা বিভাগ</div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <template v-for="dept in departments" :key="dept.key">
              <div v-if="student[dept.flag]" class="border rounded-md bg-gray-50 p-4">
                <div class="text-lg font-bold text-indigo-600 mb-3">{{ dept.title }}</div>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="font-medium text-gray-600">ইংরেজি বছর:</span>
                    <span>{{ student[dept.english] || 'নির্বাচিত হয়নি' }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="font-medium text-gray-600">হিজরি বছর:</span>
                    <span>{{ student[dept.hijri] || 'নির্বাচিত হয়নি' }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="font-medium text-gray-600">নির্বাচিত:</span>
                    <span class="text-green-600 font-medium">✓ হ্যাঁ</span>
                  </div>
                </div>
              </div>
            </template>
            <div v-if="student.dept_other" class="border rounded-md bg-gray-50 p-4 col-span-2">
              <div class="text-lg font-bold text-indigo-600 mb-3">অন্যান্য বিভাগ</div>
              <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="flex justify-between">
                  <span class="font-medium text-gray-600">বিভাগের নাম:</span>
                  <span>{{ student.dept_other_name || 'নির্বাচিত হয়নি' }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="font-medium text-gray-600">ক্লাস:</span>
                  <span>{{ student.dept_other_class || 'নির্বাচিত হয়নি' }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="font-medium text-gray-600">নির্বাচিত:</span>
                  <span class="text-green-600 font-medium">✓ হ্যাঁ</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Show unselected departments -->
          <div class="mt-6">
            <div class="text-md font-medium text-gray-600 mb-3">নির্বাচিত নয়:</div>
            <div class="flex flex-wrap gap-2">
              <template v-for="dept in departments" :key="'unselected-' + dept.key">
                <span v-if="!student[dept.flag]" class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-sm">
                  {{ dept.title }}
                </span>
              </template>
              <span v-if="!student.dept_other" class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-sm">
                অন্যান্য বিভাগ
              </span>
            </div>
          </div>
        </div>

        <!-- Exam Info -->
        <!-- Exam Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
          <div class="text-xl font-semibold text-indigo-700 mb-4 border-b pb-2">পরীক্ষা ও অন্যান্য তথ্য</div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
            <div class="font-medium text-gray-600">পরীক্ষার ধরন:</div>
            <div>{{ student.examType || 'নেই' }}</div>
            <div class="font-medium text-gray-600">রোল নম্বর:</div>
            <div>{{ student.rollNumber || 'নেই' }}</div>
            <div class="font-medium text-gray-600">কর্মস্থল:</div>
            <div>{{ student.workplace || 'নেই' }}</div>
            <div class="font-medium text-gray-600">পরিচয়পত্র টাইপ:</div>
            <div>{{ getIdType(student.idType) }}</div>
            <template v-if="student.idType === 'birth'">
              <div class="font-medium text-gray-600">জন্ম নিবন্ধন নম্বর:</div>
              <div>{{ student.birthCertificate || 'নেই' }}</div>
            </template>
            <template v-else-if="student.idType === 'voter'">
              <div class="font-medium text-gray-600">ভোটার আইডি নম্বর:</div>
              <div>{{ student.voterId || 'নেই' }}</div>
            </template>
            <div class="font-medium text-gray-600">সহপাঠী ১:</div>
            <div>{{ student.classmate1 || 'নেই' }}</div>
            <div class="font-medium text-gray-600">সহপাঠী ২:</div>
            <div>{{ student.classmate2 || 'নেই' }}</div>
            <div class="font-medium text-gray-600">সহপাঠী ৩:</div>
            <div>{{ student.classmate3 || 'নেই' }}</div>
          </div>
        </div>

        <!-- File Upload Information -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
          <div class="text-xl font-semibold text-indigo-700 mb-4 border-b pb-2">আপলোডকৃত ফাইল সমূহ</div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Profile Photo -->
            <div class="border rounded-lg p-4 bg-gray-50">
              <div class="text-lg font-medium text-gray-700 mb-2 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                </svg>
                প্রোফাইল ছবি
              </div>
              <div class="text-sm">
                <div class="flex justify-between mb-1">
                  <span class="text-gray-600">স্ট্যাটাস:</span>
                  <span :class="student.photo ? 'text-green-600' : 'text-red-600'">
                    {{ student.photo ? '✓ আপলোড করা হয়েছে' : '✗ আপলোড করা হয়নি' }}
                  </span>
                </div>
                <div v-if="student.photo" class="mt-3">
                  <div class="mb-2">
                    <img :src="getPhotoUrl(student.photo)" alt="প্রোফাইল ছবি"
                         @click="showImageModal(getPhotoUrl(student.photo), 'প্রোফাইল ছবি')"
                         class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200 mx-auto cursor-pointer hover:border-blue-400 transition-colors">
                  </div>
                  <div class="text-xs text-gray-500 text-center">{{ student.photo }}</div>
                </div>
              </div>
            </div>

            <!-- Birth Certificate Photo -->
            <div v-if="student.idType === 'birth'" class="border rounded-lg p-4 bg-gray-50">
              <div class="text-lg font-medium text-gray-700 mb-2 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd" />
                </svg>
                জন্ম সনদের ছবি
              </div>
              <div class="text-sm">
                <div class="flex justify-between mb-1">
                  <span class="text-gray-600">স্ট্যাটাস:</span>
                  <span :class="student.birthCertificatePhoto ? 'text-green-600' : 'text-red-600'">
                    {{ student.birthCertificatePhoto ? '✓ আপলোড করা হয়েছে' : '✗ আপলোড করা হয়নি' }}
                  </span>
                </div>
                <div v-if="student.birthCertificatePhoto" class="mt-3">
                  <div class="mb-2">
                    <img :src="getPhotoUrl(student.birthCertificatePhoto)" alt="জন্ম সনদের ছবি"
                         @click="showImageModal(getPhotoUrl(student.birthCertificatePhoto), 'জন্ম সনদের ছবি')"
                         class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200 mx-auto cursor-pointer hover:border-green-400 transition-colors">
                  </div>
                  <div class="text-xs text-gray-500 text-center">{{ student.birthCertificatePhoto }}</div>
                </div>
              </div>
            </div>

            <!-- Voter ID Photo -->
            <div v-if="student.idType === 'voter'" class="border rounded-lg p-4 bg-gray-50">
              <div class="text-lg font-medium text-gray-700 mb-2 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd" />
                </svg>
                ভোটার আইডি ছবি
              </div>
              <div class="text-sm">
                <div class="flex justify-between mb-1">
                  <span class="text-gray-600">স্ট্যাটাস:</span>
                  <span :class="student.voterIdPhoto ? 'text-green-600' : 'text-red-600'">
                    {{ student.voterIdPhoto ? '✓ আপলোড করা হয়েছে' : '✗ আপলোড করা হয়নি' }}
                  </span>
                </div>
                <div v-if="student.voterIdPhoto" class="mt-3">
                  <div class="mb-2">
                    <img :src="getPhotoUrl(student.voterIdPhoto)" alt="ভোটার আইডি ছবি"
                         @click="showImageModal(getPhotoUrl(student.voterIdPhoto), 'ভোটার আইডি ছবি')"
                         class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200 mx-auto cursor-pointer hover:border-purple-400 transition-colors">
                  </div>
                  <div class="text-xs text-gray-500 text-center">{{ student.voterIdPhoto }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>        <!-- Status and Created Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
          <div class="text-xl font-semibold text-indigo-700 mb-4 border-b pb-2">স্ট্যাটাস ও সময়ের তথ্য</div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
            <div class="font-medium text-gray-600">আবেদনের স্ট্যাটাস:</div>
            <div>
              <span :class="student.status === 'approved' ? 'text-green-600 bg-green-100 px-2 py-1 rounded text-sm' : 'text-orange-600 bg-orange-100 px-2 py-1 rounded text-sm'">
                {{ student.status === 'approved' ? 'অনুমোদিত' : student.status === 'rejected' ? 'প্রত্যাখ্যাত' : 'বিচারাধীন' }}
              </span>
            </div>

            <div class="font-medium text-gray-600">আবেদনের তারিখ:</div>
            <div>{{ student.created_at ? new Date(student.created_at).toLocaleString('bn-BD', {
              year: 'numeric', month: 'long', day: 'numeric',
              hour: '2-digit', minute: '2-digit'
            }) : 'নেই' }}</div>

            <div class="font-medium text-gray-600">তথ্য সংরক্ষণের তারিখ:</div>
            <div>{{ student.info_created_at ? new Date(student.info_created_at).toLocaleString('bn-BD', {
              year: 'numeric', month: 'long', day: 'numeric',
              hour: '2-digit', minute: '2-digit'
            }) : 'নেই' }}</div>

            <template v-if="student.approved_at">
              <div class="font-medium text-gray-600">অনুমোদনের তারিখ:</div>
              <div>{{ new Date(student.approved_at).toLocaleString('bn-BD', {
                year: 'numeric', month: 'long', day: 'numeric',
                hour: '2-digit', minute: '2-digit'
              }) }}</div>
            </template>

            <template v-if="student.approved_by_name">
              <div class="font-medium text-gray-600">অনুমোদনকারী:</div>
              <div>{{ student.approved_by_name }}</div>
            </template>

            <div class="font-medium text-gray-600">সর্বশেষ আপডেট:</div>
            <div>{{ student.updated_at ? new Date(student.updated_at).toLocaleString('bn-BD', {
              year: 'numeric', month: 'long', day: 'numeric',
              hour: '2-digit', minute: '2-digit'
            }) : 'নেই' }}</div>

            <div class="font-medium text-gray-600">তথ্য শেষ আপডেট:</div>
            <div>{{ student.info_updated_at ? new Date(student.info_updated_at).toLocaleString('bn-BD', {
              year: 'numeric', month: 'long', day: 'numeric',
              hour: '2-digit', minute: '2-digit'
            }) : 'নেই' }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Image Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" @click="closeModal">
      <div class="relative max-w-4xl max-h-full p-4">
        <button @click="closeModal" class="absolute top-2 right-2 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 z-10">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
        <div class="text-center">
          <img :src="modalImage" :alt="modalTitle" class="max-w-full max-h-screen object-contain rounded-lg" @click.stop>
          <p class="text-white mt-4 text-lg">{{ modalTitle }}</p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Fieldset from 'primevue/fieldset';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';
import { usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const { props } = usePage();
const student = ref(props.student || {});
const divisions = ref(props.divisions || []);
const districts = ref(props.districts || []);
const thanas = ref(props.thanas || []);

// Modal state
const showModal = ref(false);
const modalImage = ref('');
const modalTitle = ref('');

const departments = [
  { key: 'takmil', flag: 'dept_takmil', title: 'তাকমিল', english: 'dept_takmil_year_english', hijri: 'dept_takmil_year_hijri' },
  { key: 'ifta', flag: 'dept_ifta', title: 'ইফতা', english: 'dept_ifta_year_english', hijri: 'dept_ifta_year_hijri' },
  { key: 'hifz', flag: 'dept_hifz', title: 'হিফজ', english: 'dept_hifz_year_english', hijri: 'dept_hifz_year_hijri' },
  { key: 'qirat', flag: 'dept_qirat', title: 'কিরাআত', english: 'dept_qirat_year_english', hijri: 'dept_qirat_year_hijri' }
];

function getDivisionName(id) {
  if (!id) return 'নির্বাচিত হয়নি';
  const d = divisions.value.find(x => String(x.id) === String(id));
  return d ? d.division_name_bangla : `আইডি ${id} পাওয়া যায়নি`;
}
function getDistrictName(id) {
  if (!id) return 'নির্বাচিত হয়নি';
  const d = districts.value.find(x => String(x.id) === String(id));
  return d ? d.district_name_bangla : `আইডি ${id} পাওয়া যায়নি`;
}
function getThanaName(id) {
  if (!id) return 'নির্বাচিত হয়নি';
  const t = thanas.value.find(x => String(x.id) === String(id));
  return t ? t.thana_name_bangla : `আইডি ${id} পাওয়া যায়নি`;
}


function getIdType(val) {
  if (val === 'birth') return 'জন্মসনদ';
  if (val === 'voter') return 'ভোটার আইডি';
  return 'নির্বাচিত হয়নি';
}



function getPhotoUrl(photo) {
  if (!photo)
    return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzciIHI9IjE4IiBmaWxsPSIjOUI5QjlCIi8+CjxwYXRoIGQ9Ik0yMCA4MEM2IDgwIDM4IDY4IDUwIDY4QzYyIDY4IDk0IDgwIDgwIDgwSDE4WiIgZmlsbD0iIzlCOUI5QiIvPgo8L3N2Zz4=';
  if (typeof photo === 'string' && (photo.startsWith('http://') || photo.startsWith('https://'))) return photo;
  if (typeof photo === 'string' && photo.startsWith('/')) return photo;
  if (typeof photo === 'string') return `/storage/${photo}`;
  return '';
}
function goToEditPage() {
  router.visit(route('student.edit', student.value.id));
}
function printDetails() {
  window.print();
}

// Modal functions
function showImageModal(imageUrl, title) {
  modalImage.value = imageUrl;
  modalTitle.value = title;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  modalImage.value = '';
  modalTitle.value = '';
}

// Summary functions
function getSelectedDepartmentsCount() {
  let count = 0;
  departments.forEach(dept => {
    if (student.value[dept.flag]) count++;
  });
  if (student.value.dept_other) count++;
  return count;
}

function getUploadedFilesCount() {
  let count = 0;
  if (student.value.photo) count++;
  if (student.value.birthCertificatePhoto) count++;
  if (student.value.voterIdPhoto) count++;
  return count;
}

function getClassmatesCount() {
  let count = 0;
  if (student.value.classmate1) count++;
  if (student.value.classmate2) count++;
  if (student.value.classmate3) count++;
  return count;
}

function getCompletionPercentage() {
  let totalFields = 0;
  let filledFields = 0;

  // Basic required fields
  const requiredFields = [
    'fullNameBangla', 'fullNameEnglish', 'fatherName', 'phoneNumber',
    'dateOfBirth', 'address', 'division_id', 'district_id', 'thana_id',
    'examType', 'rollNumber', 'idType', 'photo'
  ];

  requiredFields.forEach(field => {
    totalFields++;
    if (student.value[field]) filledFields++;
  });

  // Department selection (at least one)
  totalFields++;
  if (getSelectedDepartmentsCount() > 0) filledFields++;

  // ID specific fields
  if (student.value.idType === 'birth') {
    totalFields += 2;
    if (student.value.birthCertificate) filledFields++;
    if (student.value.birthCertificatePhoto) filledFields++;
  } else if (student.value.idType === 'voter') {
    totalFields += 2;
    if (student.value.voterId) filledFields++;
    if (student.value.voterIdPhoto) filledFields++;
  }

  return Math.round((filledFields / totalFields) * 100);
}
</script>
