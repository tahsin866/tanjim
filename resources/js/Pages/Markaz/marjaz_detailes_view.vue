<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from '@inertiajs/vue3';
import moment from 'moment/moment';
import Card from 'primevue/card';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import Avatar from 'primevue/avatar';
import Tooltip from 'primevue/tooltip';
import ScrollPanel from 'primevue/scrollpanel';


defineProps({
    markazDetails: {
        type: Object,
        required: true
    }
});


const formatDate = (timestamp) => {
    return moment(timestamp).format('DD/MM/YYYY');
};



const getStatusSeverity = (status) => {
  switch (status) {
    case 'অনুমোদন':
      return 'success';
    case 'বোর্ড দাখিল':
      return 'warning';
    case 'বোর্ড ফেরত':
      return 'danger';
    case 'বাতিল':
      return 'danger';
    default:
      return 'info';
  }
};

// Get user icon
const getUserIcon = (activity) => {
  return activity.admin_name ? 'pi pi-user-edit' : 'pi pi-user';
};

</script>

<template>

    <Head title="মারকায মাদরাসার বিস্তারিত" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-sm">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 p-6">
                        <h2 class="text-2xl font-bold text-white text-center">
                            মারকায মাদরাসার বিস্তারিত তথ্য
                        </h2>
                    </div>

                    <!-- Main Content -->
                    <div class="p-6">
                        <!-- Basic Info -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                মূল মাদরাসার তথ্য
                            </h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap bg-gray-50 w-1/4">
                                            <div class="text-xl font-medium text-gray-900">মাদরাসার নাম</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-md font-semibold text-gray-900">{{
                                                markazDetails.madrasha_Name }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
                                            <div class="text-xl font-medium text-gray-900">আবেদনের তারিখ</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">  {{ formatDate(markazDetails.created_at) }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Student Statistics -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                মূল মাদরাসার শ্রেণিভিত্তিক ছাত্র সংখ্যা
                            </h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">
                                            ফাযীলাত</th>
                                        <th
                                            class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">
                                            সানাবিয়া উলইয়া</th>
                                        <th
                                            class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">
                                            সানাবিয়া</th>
                                        <th
                                            class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">
                                            মুতাওয়াসসিতা</th>
                                        <th
                                            class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">
                                            ইবতেদাইয়্যাহু</th>
                                        <th
                                            class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">
                                            তাহফিজুল কোরআন</th>

                                            <th
                                            class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">
                                            ইলমুল কিরআত</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ markazDetails.fazilat }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ markazDetails.sanabiya_ulya }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ markazDetails.sanabiya }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ markazDetails.mutawassita }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ markazDetails.ibtedaiyyah }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ markazDetails.hifzul_quran }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ markazDetails.qirat }}</div>
                                        </td>
                                    </tr>



                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
                                            <div class="text-xl font-medium text-gray-900">মারকায টাইপ</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-md font-semibold text-gray-900">{{
                                                markazDetails.markaz_type }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
                                            <div class="text-xl font-medium text-gray-900">পরীক্ষার নাম</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-md font-semibold text-gray-900">{{ markazDetails.exam_name
                                            }}</div>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>



                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                সংযুক্ত ডকুমেন্টস
                            </h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ডকুমেন্টের নাম</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="markazDetails.noc_file">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                                <span class="text-sm text-gray-900">সম্মতিপত্র</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <a :href="'/storage/images/' + markazDetails.president_consent" target="_blank"
   class="inline-flex items-center px-4 py-2 mx-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
   <i class="fas fa-eye mr-2"></i>
   ভিউ ফাইল
</a>
                                            <a :href="'/storage/' + markazDetails.noc_file" target="_blank"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                <i class="fas fa-download mr-2"></i>
                                                ডাউনলোড
                                            </a>
                                        </td>
                                    </tr>
                                    <tr v-if="markazDetails.resolution_file">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                                <span class="text-sm text-gray-900">রেজুলেশন ফাইল</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <a :href="'/storage/' + markazDetails.president_consent" target="_blank"
                                                class="inline-flex items-center px-4 py-2 mx-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
                                                <i class="fas fa-eye mr-2"></i>
                                                ভিউ ফাইল
                                            </a>


                                            <a :href="'/storage/' + markazDetails.resolution_file" target="_blank"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                <i class="fas fa-download mr-2"></i>
                                                ডাউনলোড
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>





                        <!-- Associated Madrasas -->
                        <div v-if="markazDetails.associated_madrasas && markazDetails.associated_madrasas.length"
                            class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                সংযুক্ত মাদরাসা সমূহ
                            </h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                            মাদরাসার নাম</th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold  text-gray-500 uppercase tracking-wider">
                                            ফাযীলাত</th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                            সানাবিয়া উলইয়া</th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                            সানাবিয়া</th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                            মুতাওয়াসসিতাহ</th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                            ইবতেদায়ীয়াহ</th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                            হিফযুল কুরআন</th>

                                            <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                        ইলমুল কিরাআত</th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                            মোট</th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                            সম্মতিপত্র</th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">
                                            অনাপত্তিপত্র</th>

                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="madrasa in markazDetails.associated_madrasas" :key="madrasa.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ madrasa.madrasa_Name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ madrasa.fazilat }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ madrasa.sanabiya_ulya }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ madrasa.sanabiya }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ madrasa.mutawassita }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ madrasa.ibtedaiyyah }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ madrasa.hifzul_quran }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ madrasa.qirat }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ madrasa.fazilat + madrasa.sanabiya_ulya + madrasa.sanabiya +
                                                    madrasa.mutawassita + madrasa.ibtedaiyyah + madrasa.hifzul_quran }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a :href="'/storage/' + markazDetails.president_consent" target="_blank"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
                                                <i class="fas fa-eye mr-2"></i>
                                                ভিউ ফাইল
                                            </a>
                                            <a :href="'/storage/' + markazDetails.noc_file" target="_blank"
                                                class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                <i class="fas fa-download mr-2"></i>
                                                ডাউনলোড
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a :href="'/storage/' + markazDetails.president_consent" target="_blank"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
                                                <i class="fas fa-eye mr-2"></i>
                                                ভিউ ফাইল
                                            </a>
                                            <a :href="'/storage/' + markazDetails.noc_file" target="_blank"
                                                class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                <i class="fas fa-download mr-2"></i>
                                                ডাউনলোড
                                            </a>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Attachments -->

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                প্রয়োজনীয় তথ্য
                            </h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
                                            <div class="text-xl font-medium text-gray-900">প্রয়োজনীয়তা</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="max-h-32 overflow-y-auto text-md text-gray-900 pr-4">
                                                {{ markazDetails.requirements }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
                                            <div class="text-xl font-medium text-gray-900">মহতামিমের সম্মতি</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a :href="'/storage/' + markazDetails.muhtamim_consent" target="_blank"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
                                                <i class="fas fa-eye mr-2"></i>
                                                ভিউ ফাইল
                                            </a>

                                            <a :href="'/storage/' + markazDetails.noc_file" target="_blank"
                                                class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                <i class="fas fa-download mr-2"></i>
                                                ডাউনলোড
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
                                            <div class="text-xl font-medium text-gray-900">সভাপতির সম্মতি</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a :href="'/storage/' + markazDetails.president_consent" target="_blank"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
                                                <i class="fas fa-eye mr-2"></i>
                                                ভিউ ফাইল
                                            </a>
                                            <a :href="'/storage/' + markazDetails.noc_file" target="_blank"
                                                class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                <i class="fas fa-download mr-2"></i>
                                                ডাউনলোড
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
                                            <div class="text-xl font-medium text-gray-900">কমিটি রেজুলেশন</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a :href="'/storage/' + markazDetails.committee_resolution" target="_blank"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
                                                <i class="fas fa-eye mr-2"></i>
                                                ভিউ ফাইল
                                            </a>
                                            <a :href="'/storage/' + markazDetails.noc_file" target="_blank"
                                                class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                <i class="fas fa-download mr-2"></i>
                                                ডাউনলোড
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>




                        <div class="mt-6">
  <Card class="registration-status-card">
    <template #header>
      <div class="bg-teal-700 p-4 -m-4 mb-5">
        <div class="flex align-items-center">
          <i class="pi pi-chart-line text-white mr-2 text-xl"></i>
          <h2 class="text-xl font-bold text-white m-0">নিবন্ধন অবস্থা পর্যবেক্ষণ</h2>
        </div>
      </div>
    </template>
    <template #content>
      <DataTable
        :value="markazDetails.activity_logs"
        dataKey="id"
        stripedRows
        responsiveLayout="scroll"
        class="status-table "
        :rowHover="true"
        showGridlines
        v-tooltip.top="'সম্পূর্ণ তথ্য দেখতে টেবিল স্ক্রল করুন'"
      >
        <!-- User Column -->
        <Column field="user_name" header="সিদ্ধান্ত গ্রহণকারী" class="w-1/6">
          <template #body="{ data }">
            <div class="flex align-items-center">
              <Avatar
                :icon="getUserIcon(data)"
                size="normal"
                shape="circle"
                :style="{
                  'background-color': data.admin_name ? '#10b981' : '#3b82f6',
                  'color': 'white'
                }"
                class="mr-2"
              />
              <span class="font-medium">{{ data.admin_name || data.user_name }}</span>
            </div>
          </template>
        </Column>
        <!-- Position Column -->
        <Column field="user_position" header="পদবি" class="w-1/6">
          <template #body="{ data }">
            <Tag
              severity="info"
              class="p-2"
              :style="{ 'background-color': '#e0f2fe', 'color': '#0369a1' }"
            >
              {{ data.admin_position_text || data.user_position }}
            </Tag>
          </template>
        </Column>
        <!-- Date Column -->
        <Column field="created_at" header="তারিখ ও সময়" class="w-1/5">
          <template #body="{ data }">
            <div class="flex align-items-center">
              <i class="pi pi-calendar mr-2 text-blue-500"></i>
              <span>{{ formatDate(data.created_at) }}</span>
            </div>
          </template>
        </Column>
        <!-- Status Column -->
        <Column field="status" header="অবস্থা" class="w-1/6">
          <template #body="{ data }">
            <Tag :severity="getStatusSeverity(data.status)" class="p-2">
              {{ data.status }}
            </Tag>
          </template>
        </Column>
        <!-- Comment Column -->
        <Column field="admin_message" header="মন্তব্য" class="w-1/4">
          <template #body="{ data }">
            <div v-if="data.admin_message" class="comment-container">
              <ScrollPanel style="width: 100%; height: 80px" class="custom-scrollbar">
                <div class="p-3 border-round bg-red-50 border-1 border-red-200">
                  <div class="flex align-items-start">
                    <i class="pi pi-exclamation-circle text-red-500 mr-2 mt-1"></i>
                    <span class="text-red-700 text-sm">{{ data.admin_message }}</span>
                  </div>
                </div>
              </ScrollPanel>
            </div>
            <div v-else class="text-gray-400 italic text-sm p-2">
              <i class="pi pi-comment mr-2"></i>
              কোন মন্তব্য নেই
            </div>
          </template>
        </Column>
      </DataTable>
      <div v-if="!markazDetails.activity_logs || markazDetails.activity_logs.length === 0" class="p-4 text-center">
        <Tag severity="info" class="p-3">
          <i class="pi pi-info-circle mr-2"></i>
          <span>কোন অ্যাকটিভিটি লগ পাওয়া যায়নি</span>
        </Tag>
      </div>
    </template>
  </Card>
</div>







                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
