<template>
    <AuthenticatedLayout>
        <div class="bg-gray-100 rounded-sm p-6 border-t-4 border-emerald-700 mx-5 mt-5">
  <div class="relative mb-6">
    <h2 class="text-xl font-semibold text-center text-emerald-800 py-3">মারহালা তথ্য</h2>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full table-fixed border border-gray-300 border-collapse border-spacing-0">
      <thead>
        <tr class="bg-emerald-700 text-white text-center">
          <th class="w-2/6 p-3 text-left">মারহালা নাম</th>
          <th class="w-1/6 p-3">মোট বিষয়</th>
          <th class="w-1/6 p-3">পুরুষ</th>
          <th class="w-1/6 p-3">মহিলা</th>
          <th class="w-1/6 p-3">উভয়</th>
          <th class="w-2/6 p-3">অ্যাকশন</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="marhala in marhalas" :key="marhala.id" class="border-b border-gray-200 hover:bg-gray-50 text-center text-md">
          <td class="p-3 text-left text-gray-800">{{ marhala.marhala_name_bn }}</td>
          <td class="p-3 text-gray-700 font-medium">{{ marhala.total_subjects }}</td>
          <td class="p-3 text-gray-700 font-medium">{{ marhala.male_subjects }}</td>
          <td class="p-3 text-gray-700 font-medium">{{ marhala.female_subjects }}</td>
          <td class="p-3 text-gray-700 font-medium">{{ marhala.both_subjects }}</td>
          <td class="p-3">
            <div class="flex justify-center gap-2">
              <Link
                :href="route('Mrahala_for_Admin.marhala_edit', { marhala: marhala.id })"
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
              >
                সংশোধন
              </Link>
              <Link
                :href="route('Mrahala_for_Admin.marhala_setup_list', { id: marhala.id })"
                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition"
              >
                নতুন যোগ করুন
              </Link>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { Link } from '@inertiajs/vue3';

  const marhalas = ref([]);

  const fetchMarhalas = async () => {
      try {
          const response = await axios.get('/api/get-marhala-list');
          marhalas.value = response.data;
      } catch (error) {
          console.error('Error fetching marhalas:', error);
      }
  };

  onMounted(() => {
      fetchMarhalas();
  });
  </script>
