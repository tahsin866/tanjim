<template>
    <AuthenticatedLayout>
      <div class="p-4 md:p-8 bg-[#f8f9fa] min-h-screen">
        <div class="bg-white rounded-sm shadow-md border border-emerald-100">
          <!-- Header Section -->
          <div class="bg-emerald-50 p-4 md:p-6 rounded-t-sm border-b border-emerald-100">
            <div class="flex items-center justify-center gap-3">
              <svg class="w-6 h-6 md:w-8 md:h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
              <h2 class="text-xl md:text-2xl font-bold text-emerald-800">{{ formattedTitle }}</h2>
            </div>
          </div>

          <!-- Table Section -->
          <div class="p-3 md:p-6">
            <div class="overflow-x-auto">
              <DataTable :value="rows" class="p-datatable-lg custom-datatable" responsiveLayout="scroll" stripedRows>
                <Column field="index" header="ক্রমিক" style="width: 80px; text-align: center">
                  <template #body="{ index }">
                    <span class="font-medium">{{ index + 1 }}</span>
                  </template>
                </Column>

                <Column field="examName" header="পরীক্ষা (মারহালা)" style="width: 200px">
                  <template #body="slotProps">
                    <span class="font-medium text-emerald-900">{{ slotProps.data.examName }}</span>
                  </template>
                </Column>

                <!-- Registration Fee Section -->
                <Column header="নিবন্ধন ফি সময়সীমা" style="width: 320px">
                  <template #body="slotProps">
                    <div class="flex items-center gap-2">
                      <Calendar v-model="slotProps.data.dateFrom1"
                                dateFormat="yy-mm-dd"
                                placeholder="থেকে"
                                showIcon
                                class="custom-calendar" />
                      <span class="font-medium">থেকে</span>
                      <Calendar v-model="slotProps.data.dateTo1"
                                dateFormat="yy-mm-dd"
                                placeholder="পর্যন্ত"
                                showIcon
                                class="custom-calendar" />
                    </div>
                  </template>
                </Column>

                <Column header="নিয়মিত" style="width: 150px">
                  <template #body="slotProps">
                    <InputNumber v-model="slotProps.data.fee1"
                                 mode="currency"
                                 currency="BDT"
                                 locale="bn-BD"
                                 class="w-full custom-input" />
                  </template>
                </Column>

                <Column header="অনিয়মিত (যেমনি)" style="width: 150px">
                  <template #body="slotProps">
                    <InputNumber v-model="slotProps.data.invest1Men"
                                 mode="currency"
                                 currency="BDT"
                                 locale="bn-BD"
                                 class="w-full custom-input" />
                  </template>
                </Column>

                <Column header="অনিয়মিত (মানোন্নয়ন)" style="width: 150px">
                  <template #body="slotProps">
                    <InputNumber v-model="slotProps.data.invest1Madan"
                                 mode="currency"
                                 currency="BDT"
                                 locale="bn-BD"
                                 class="w-full custom-input" />
                  </template>
                </Column>

                <Column header="অনিয়মিত (অন্যান্য)" style="width: 150px">
                  <template #body="slotProps">
                    <InputNumber v-model="slotProps.data.invest1Others"
                                 mode="currency"
                                 currency="BDT"
                                 locale="bn-BD"
                                 class="w-full custom-input" />
                  </template>
                </Column>

                <!-- Late Fee Section -->
                <Column header="বিলম্ব ফি সময়সীমা" style="width: 320px">
                  <template #body="slotProps">
                    <div class="flex items-center gap-2">
                      <Calendar v-model="slotProps.data.dateFrom2"
                                dateFormat="yy-mm-dd"
                                placeholder="থেকে"
                                showIcon
                                class="custom-calendar" />
                      <span class="font-medium">থেকে</span>
                      <Calendar v-model="slotProps.data.dateTo2"
                                dateFormat="yy-mm-dd"
                                placeholder="পর্যন্ত"
                                showIcon
                                class="custom-calendar" />
                    </div>
                  </template>
                </Column>

                <Column header="নিয়মিত" style="width: 150px">
                  <template #body="slotProps">
                    <InputNumber v-model="slotProps.data.fee2"
                                 mode="currency"
                                 currency="BDT"
                                 locale="bn-BD"
                                 class="w-full custom-input" />
                  </template>
                </Column>

                <Column header="অনিয়মিত (যেমনি)" style="width: 150px">
                  <template #body="slotProps">
                    <InputNumber v-model="slotProps.data.invest2Men"
                                 mode="currency"
                                 currency="BDT"
                                 locale="bn-BD"
                                 class="w-full custom-input" />
                  </template>
                </Column>

                <Column header="অনিয়মিত (মানোন্নয়ন)" style="width: 150px">
                  <template #body="slotProps">
                    <InputNumber v-model="slotProps.data.invest2Madan"
                                 mode="currency"
                                 currency="BDT"
                                 locale="bn-BD"
                                 class="w-full custom-input" />
                  </template>
                </Column>

                <Column header="অনিয়মিত (অন্যান্য)" style="width: 150px">
                  <template #body="slotProps">
                    <InputNumber v-model="slotProps.data.invest2Others"
                                 mode="currency"
                                 currency="BDT"
                                 locale="bn-BD"
                                 class="w-full custom-input" />
                  </template>
                </Column>
              </DataTable>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="bg-gray-50 p-4 md:p-6 rounded-b-xl border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <Button
              icon="pi pi-file-excel"
              label="এক্সেল ডাউনলোড"
              class="p-button-outlined p-button-secondary"
              @click="downloadExcel"
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
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
  import { ref, onMounted, computed } from 'vue'
  import axios from 'axios'

  // Correct PrimeVue imports as default exports
  import DataTable from 'primevue/datatable'
  import Column from 'primevue/column'
  import Calendar from 'primevue/calendar'
  import InputNumber from 'primevue/inputnumber'
  import Button from 'primevue/button'

  const examSetup = ref(null)
  const rows = ref([])

  // Format title
  const formattedTitle = computed(() => {
    if (!examSetup.value) return ''
    return `${examSetup.value.exam_name} ${examSetup.value.arabic_year} হিজরি/${examSetup.value.bangla_year} বঙ্গাব্দ/${examSetup.value.english_year} ইসাব্দ`
  })

  // Fetch exam setup data
  const fetchExamSetup = async () => {
    const response = await axios.get('/api/exam-setups/latest')
    examSetup.value = response.data
  }

  // Load marhalas and create rows
  const loadMarhalas = async () => {
    const response = await axios.get('/api/marhalas')
    rows.value = response.data.map(marhala => ({
      examName: marhala.marhala_name_bn,
      dateFrom1: null,
      dateTo1: null,
      fee1: null,
      invest1Men: null,
      invest1Madan: null,
      invest1Others: null,
      dateFrom2: null,
      dateTo2: null,
      fee2: null,
      invest2Men: null,
      invest2Madan: null,
      invest2Others: null
    }))
  }

  // Reset form
  const resetForm = () => {
    loadMarhalas()
  }

  // Submit form
  const submit = async () => {
    try {
      const feesData = rows.value.map(row => ({
        exam_setup_id: examSetup.value.id,
        exam_name: row.examName,
        reg_date_from: row.dateFrom1,
        reg_date_to: row.dateTo1,
        reg_regular_fee: row.fee1,
        reg_irregular_jemni: row.invest1Men,
        reg_irregular_manonnoyon: row.invest1Madan,
        reg_irregular_others: row.invest1Others,
        late_date_from: row.dateFrom2,
        late_date_to: row.dateTo2,
        late_regular_fee: row.fee2,
        late_irregular_jemni: row.invest2Men,
        late_irregular_manonnoyon: row.invest2Madan,
        late_irregular_others: row.invest2Others
      }));

      const response = await axios.post('/api/exam-fees', { fees: feesData });
      console.log('Response:', response.data);
      alert('পরীক্ষার ফি সফলভাবে সংরক্ষণ করা হয়েছে!');
    } catch (error) {
      console.error('Error details:', error.response?.data);
      alert('ডাটা সংরক্ষণে সমস্যা হয়েছে!');
    }
  };

  // Excel download function
  const downloadExcel = () => {
    // Implement excel download logic here
  }

  onMounted(async () => {
    await fetchExamSetup()
    await loadMarhalas()
  })
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
    width: 140px !important;
  }

  .custom-calendar :deep(.p-inputtext) {
    width: 100%;
    height: 40px;
  }

  /* Make number inputs consistent size */
  .custom-input {
    width: 100% !important;
  }

  .custom-input :deep(.p-inputtext) {
    width: 100%;
    height: 40px;
  }

  /* Ensure all PrimeVue components have consistent styling */
  :deep(.p-component) {
    font-family: inherit;
  }

  :deep(.p-button) {
    height: 40px;
  }
  </style>
