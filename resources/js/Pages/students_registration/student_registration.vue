<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
// Import PrimeVue components
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'

const isDialogOpen = ref(false)
const examFees = ref([])
const examName = ref('')
const globalFilterValue = ref('')
const filters = ref({
  global: { value: null, matchMode: 'contains' }
})

// Watch for changes in globalFilterValue to update filters
watch(globalFilterValue, (newValue) => {
  filters.value.global.value = newValue;
})

const fetchExamFees = async () => {
  try {
    const response = await axios.get('/api/exam-fees')
    examFees.value = response.data.examFees
    examName.value = response.data.examName
  } catch (error) {
    console.error('Error fetching exam fees:', error)
  }
}

onMounted(() => {
  fetchExamFees()
})

const toggleDialog = () => {
  isDialogOpen.value = !isDialogOpen.value
}
</script>


<template>
  <AuthenticatedLayout>
    <div class="card mx-5 mt-5">
      <!-- Header Section -->
      <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 p-6 rounded-t-sm shadow-lg">
        <div class="container mx-auto">
          <div class="flex justify-between items-center">
            <!-- Title -->
            <h2 class="text-white text-xl md:text-3xl font-bold">
              {{ examName }}
            </h2>
          </div>
        </div>
      </div>

      <!-- DataTable Section -->
      <div class="card">
        <DataTable
          :value="examFees"
          :paginator="true"
          :rows="10"
          :rowsPerPageOptions="[5, 10, 20, 50]"
          tableStyle="min-width: 50rem"
          stripedRows
          class="p-datatable-lg"
          :globalFilterFields="['marhala_name_bn']"
          v-model:filters="filters"
          filterDisplay="menu"
        >
          <template #header>
            <div class="flex justify-between">
              <span class="p-input-icon-left">
                <i class="pi pi-search" />
                <InputText v-model="globalFilterValue" placeholder="অনুসন্ধান করুন..." class="p-inputtext-lg" />
              </span>
            </div>
          </template>

          <Column field="marhala_name_bn" header="মারহালা" sortable style="min-width: 12rem"></Column>

          <Column header="নিয়মিত রেজিস্ট্রেশন (শুরু)" field="regularStartDate" sortable style="min-width: 10rem"></Column>
          <Column header="নিয়মিত রেজিস্ট্রেশন (শেষ)" field="regularEndDate" sortable style="min-width: 10rem"></Column>
          <Column header="নিয়মিত ফি" field="regularFee" sortable style="min-width: 8rem">
            <template #body="slotProps">
              <span class="font-medium">৳{{ slotProps.data.regularFee }}</span>
            </template>
          </Column>

          <Column header="বিলম্ব রেজিস্ট্রেশন (শুরু)" field="lateStartDate" sortable style="min-width: 10rem"></Column>
          <Column header="বিলম্ব রেজিস্ট্রেশন (শেষ)" field="lateEndDate" sortable style="min-width: 10rem"></Column>
          <Column header="বিলম্ব ফি" field="lateFee" sortable style="min-width: 8rem">
            <template #body="slotProps">
              <span class="font-medium">৳{{ slotProps.data.lateFee }}</span>
            </template>
          </Column>

          <Column header="নিয়মিত ছাত্র সংখ্যা" field="regularStudents" sortable style="min-width: 8rem"></Column>
          <Column header="অনিয়মিত ছাত্র সংখ্যা" field="irregularStudents" sortable style="min-width: 8rem"></Column>

          <Column header="একশন" style="min-width: 12rem">
            <template #body="slotProps">
              <div class="flex gap-2">
                <Link
                  :href="route('students_registration.old_stu_reg_Form', { marhalaId: slotProps.data.marhala_id })"
                  class="no-underline"
                >
                  <Button
                    label="নিবন্ধন"
                    icon="pi pi-user-plus"
                    class="p-button-success p-button-lg"
                  />
                </Link>
                <Link
                  :href="route('students_registration.student_reg_table')"
                  class="no-underline"
                >
                  <Button
                    label="তালিকা"
                    icon="pi pi-list"
                    class="p-button-info p-button-lg"
                  />
                </Link>
              </div>
            </template>
          </Column>
        </DataTable>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
