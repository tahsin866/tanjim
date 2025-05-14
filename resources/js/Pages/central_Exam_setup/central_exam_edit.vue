<template>
    <AuthenticatedLayout>
      <div class="p-8 bg-[#f8f9fa] min-h-screen">
        <div class="bg-white rounded-sm shadow-md border border-emerald-100">
          <!-- Header Section -->
          <div class="bg-emerald-50 p-6 rounded-t-sm border-b border-emerald-100">
            <div class="flex items-center justify-center gap-3">
              <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
              <h2 class="text-2xl font-bold text-emerald-800">
                {{ `${examSetup.exam_name} ${examSetup.arabic_year} হিজরি/${examSetup.bangla_year} বঙ্গাব্দ/${examSetup.english_year} ইসাব্দ` }}
              </h2>
            </div>
          </div>

          <!-- Table Section -->
          <div class="p-6 overflow-x-auto">
            <DataTable :value="examFeesData" class="custom-datatable" responsiveLayout="scroll" stripedRows>
              <Column field="index" header="ক্রমিক" style="width: 60px; text-align: center">
                <template #body="{ index }">
                  <span class="font-medium">{{ index + 1 }}</span>
                </template>
              </Column>

              <Column field="exam_name" header="পরীক্ষা (মারহালা)" style="width: 150px">
                <template #body="slotProps">
                  <span class="font-medium text-emerald-900">{{ slotProps.data.exam_name }}</span>
                </template>
              </Column>

              <!-- Registration Fee Section -->
              <Column header="সময় সীমা" style="width: 300px">
                <template #body="slotProps">
                  <div class="flex items-center gap-1">
                    <div class="relative" style="width: 48%;">
                      <span class="absolute -top-2 left-2 bg-white px-1 text-xs text-emerald-600 z-10">শুরু</span>
                      <Calendar
                        v-model="examFeesData[slotProps.index].reg_date_from"
                        dateFormat="yy-mm-dd"
                        class="w-full custom-calendar"
                        showIcon
                      />
                    </div>
                    <span class="whitespace-nowrap font-medium text-emerald-700 px-1">থেকে</span>
                    <div class="relative" style="width: 48%;">
                      <span class="absolute -top-2 left-2 bg-white px-1 text-xs text-emerald-600 z-10">শেষ</span>
                      <Calendar
                        v-model="examFeesData[slotProps.index].reg_date_to"
                        dateFormat="yy-mm-dd"
                        class="w-full custom-calendar"
                        showIcon
                      />
                    </div>
                  </div>
                </template>
              </Column>

              <Column header="নিয়মিত" style="width: 100px">
                <template #body="slotProps">
                  <InputNumber
                    v-model="examFeesData[slotProps.index].reg_regular_fee"
                    class="w-full custom-input"
                    mode="decimal"
                  />
                </template>
              </Column>

              <Column header="অনিয়মিত (যেমনি)" style="width: 100px">
                <template #body="slotProps">
                  <InputNumber
                    v-model="examFeesData[slotProps.index].reg_irregular_jemni"
                    class="w-full custom-input"
                    mode="decimal"
                  />
                </template>
              </Column>

              <Column header="অনিয়মিত (মানোন্নয়ন)" style="width: 100px">
                <template #body="slotProps">
                  <InputNumber
                    v-model="examFeesData[slotProps.index].reg_irregular_manonnoyon"
                    class="w-full custom-input"
                    mode="decimal"
                  />
                </template>
              </Column>

              <Column header="অনিয়মিত (অন্যান্য)" style="width: 100px">
                <template #body="slotProps">
                  <InputNumber
                    v-model="examFeesData[slotProps.index].reg_irregular_others"
                    class="w-full custom-input"
                    mode="decimal"
                  />
                </template>
              </Column>

              <!-- Late Fee Section -->
              <Column header="সময় সীমা" style="width: 300px">
                <template #body="slotProps">
                  <div class="flex items-center gap-1">
                    <div class="relative" style="width: 48%;">
                      <span class="absolute -top-2 left-2 bg-white px-1 text-xs text-emerald-600 z-10">শুরু</span>
                      <Calendar
                        v-model="examFeesData[slotProps.index].late_date_from"
                        dateFormat="yy-mm-dd"
                        class="w-full custom-calendar"
                        showIcon
                      />
                    </div>
                    <span class="whitespace-nowrap font-medium text-emerald-700 px-1">থেকে</span>
                    <div class="relative" style="width: 48%;">
                      <span class="absolute -top-2 left-2 bg-white px-1 text-xs text-emerald-600 z-10">শেষ</span>
                      <Calendar
                        v-model="examFeesData[slotProps.index].late_date_to"
                        dateFormat="yy-mm-dd"
                        class="w-full custom-calendar"
                        showIcon
                      />
                    </div>
                  </div>
                </template>
              </Column>

              <Column header="নিয়মিত" style="width: 100px">
                <template #body="slotProps">
                  <InputNumber
                    v-model="examFeesData[slotProps.index].late_regular_fee"
                    class="w-full custom-input"
                    mode="decimal"
                  />
                </template>
              </Column>

              <Column header="অনিয়মিত (যেমনি)" style="width: 100px">
                <template #body="slotProps">
                  <InputNumber
                    v-model="examFeesData[slotProps.index].late_irregular_jemni"
                    class="w-full custom-input"
                    mode="decimal"
                  />
                </template>
              </Column>

              <Column header="অনিয়মিত (মানোন্নয়ন)" style="width: 100px">
                <template #body="slotProps">
                  <InputNumber
                    v-model="examFeesData[slotProps.index].late_irregular_manonnoyon"
                    class="w-full custom-input"
                    mode="decimal"
                  />
                </template>
              </Column>

              <Column header="অনিয়মিত (অন্যান্য)" style="width: 100px">
                <template #body="slotProps">
                  <InputNumber
                    v-model="examFeesData[slotProps.index].late_irregular_others"
                    class="w-full custom-input"
                    mode="decimal"
                  />
                </template>
              </Column>
            </DataTable>
          </div>

          <!-- Action Buttons -->
          <div class="bg-gray-50 p-6 rounded-b-xl border-t border-gray-100 flex justify-between items-center">
            <Button
              icon="pi pi-file-excel"
              label="এক্সেল ডাউনলোড"
              class="p-button-text p-button-secondary"
            />
            <div class="flex gap-3">
              <Button
                icon="pi pi-refresh"
                label="রিসেট"
                class="p-button-outlined"
                @click="resetForm"
              />
              <Button
                icon="pi pi-check"
                label="সংরক্ষণ করুন"
                class="p-button-success"
                @click="submit"
              />
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
  import DataTable from 'primevue/datatable'
  import Column from 'primevue/column'
  import Calendar from 'primevue/calendar'
  import InputNumber from 'primevue/inputnumber'
  import Button from 'primevue/button'

  const props = defineProps({
    examFees: {
      type: Array,
      required: true
    },
    examSetup: {
      type: Object,
      required: true
    }
  })

  // Track exam fees data
  const examFeesData = ref(props.examFees)

  // Submit function to update exam fees
  const submit = async () => {
    try {
      // Map through examFeesData to update each row
      const promises = examFeesData.value.map(async (examFee) => {
        const response = await axios.put(`/api/central-exam-setup/${examFee.id}`, examFee)
        return response.data
      })
      await Promise.all(promises)
      alert('পরীক্ষার ফি সফলভাবে আপডেট করা হয়েছে')
    } catch (error) {
      alert('আপডেট ব্যর্থ হয়েছে')
    }
  }

  // Reset form to initial data
  const resetForm = () => {
    examFeesData.value = JSON.parse(JSON.stringify(props.examFees))
  }
  </script>

  <style scoped>
  /* Custom styling for consistent field sizes */
  .custom-datatable :deep(.p-datatable-thead) th {
    background-color: #ecfdf5;
    color: #065f46;
    font-weight: 600;
    padding: 1rem;
    border: 1px solid #a7f3d0;
  }

  .custom-datatable :deep(.p-datatable-tbody) td {
    padding: 0.75rem;
    border: 1px solid #d1fae5;
  }

  .custom-datatable :deep(.p-datatable-tbody) tr:nth-child(even) {
    background-color: #f8fdfb;
  }

  .custom-datatable :deep(.p-datatable-tbody) tr:hover {
    background-color: #ecfdf5;
  }

  /* Make calendar inputs consistent size */
  .custom-calendar {
    width: 100% !important;
  }

  .custom-calendar :deep(.p-inputtext) {
    width: 100%;
    height: 38px;
  }

  .custom-calendar :deep(.p-button) {
    height: 38px;
  }

  /* Make number inputs consistent size */
  .custom-input {
    width: 100% !important;
  }

  .custom-input :deep(.p-inputtext) {
    width: 100%;
    height: 38px;
  }

  /* Ensure all PrimeVue components have consistent styling */
  :deep(.p-component) {
    font-family: inherit;
  }

  :deep(.p-button) {
    height: 40px;
  }
  </style>
