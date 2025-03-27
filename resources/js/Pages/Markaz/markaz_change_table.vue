<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';

  const items = [
    {
      id: 1,
      applicationNo: 'APP001',
      currentLevel: 'স্তর ১',
      currentMadrasa: 'মাদরাসা নাম ১',
      date: '2024-01-15',
      joiningDate: '2024-02-01',
      status: 'active'
    },
    // Add more items as needed
  ]

  const viewItem = (item) => {
    // Implement view logic
  }

  const updateItem = (item) => {
    // Implement update logic
  }

  const deleteItem = (item) => {
    // Implement delete logic
  }
  </script>


<template>
    <AuthenticatedLayout>
      <div class="bg-white rounded-md shadow-xl overflow-hidden mx-5 mt-5">
        <!-- Table Header with Islamic Pattern -->
        <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 px-6 py-4 relative">
          <div class="absolute inset-0 opacity-10 pattern-islamic"></div>
          <div class="flex justify-between items-center relative z-10">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
              <i class="fas fa-mosque"></i>
              মারকায আবেদন তালিকা
            </h2>
            <Link
              :href="route('Markaz.Makaj_change')"
              class="px-6 py-3 bg-emerald-700 hover:bg-emerald-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 shadow-md"
            >
              <span>মারকাজ পরিবর্তন ফরম</span>
              <i class="fas fa-arrow-right"></i>
            </Link>
          </div>
        </div>

        <!-- Table Container -->
        <div class="p-8 bg-emerald-50">
          <div class="overflow-x-auto rounded-md shadow-md">
            <table class="w-full bg-white">
              <thead>
                <tr class="bg-gradient-to-r from-emerald-900 to-emerald-800">
                  <th class="px-6 py-4 text-white font-semibold">আবেদন নং</th>
                  <th class="px-6 py-4 text-white font-semibold">বর্তমান স্তর</th>
                  <th class="px-6 py-4 text-white font-semibold">বর্তমান মাদরাসা</th>
                  <th class="px-6 py-4 text-white font-semibold">তারিখ</th>
                  <th class="px-6 py-4 text-white font-semibold">জয়েনিং তারিক</th>
                  <th class="px-6 py-4 text-white font-semibold">স্টাটাস</th>
                  <th class="px-6 py-4 text-white font-semibold">একশন</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in items"
                  :key="item.id"
                  class="border-b border-emerald-100 hover:bg-emerald-50 transition-all duration-200"
                >
                  <td class="px-6 py-4 text-center">{{ item.applicationNo }}</td>
                  <td class="px-6 py-4 text-center">{{ item.currentLevel }}</td>
                  <td class="px-6 py-4 text-center">{{ item.currentMadrasa }}</td>
                  <td class="px-6 py-4 text-center">{{ item.date }}</td>
                  <td class="px-6 py-4 text-center">{{ item.joiningDate }}</td>
                  <td class="px-6 py-4 text-center">
                    <span
                      class="px-4 py-1.5 text-sm font-medium rounded-full"
                      :class="{
                        'bg-emerald-100 text-emerald-800': item.status === 'active',
                        'bg-red-100 text-red-800': item.status === 'inactive'
                      }"
                    >
                      {{ item.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex justify-center gap-3">
                      <button
                        @click="viewItem(item)"
                        class="p-2 text-emerald-600 hover:bg-emerald-100 rounded-lg transition-all duration-200"
                        title="View Details"
                      >
                        <i class="fas fa-eye"></i>
                      </button>
                      <button
                        @click="updateItem(item)"
                        class="p-2 text-emerald-600 hover:bg-emerald-100 rounded-lg transition-all duration-200"
                        title="Edit"
                      >
                        <i class="fas fa-edit"></i>
                      </button>
                      <button
                        @click="deleteItem(item)"
                        class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200"
                        title="Delete"
                      >
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

  <style>
  .pattern-islamic {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l15 30-15 30-15-30z' fill='%23ffffff' fill-opacity='0.1'/%3E%3C/svg%3E");
    background-repeat: repeat;
  }
  </style>



