<template>
    <AuthenticatedLayout>
      <div class="mx-5 mt-5 p-8 bg-white rounded-sm shadow-md">
        <div class="text-center mb-8">
          <h3 class="text-xl font-bold text-gray-800">মারহালা সাবজেক্ট ইনফরমেশন</h3>
        </div>

        <form @submit.prevent="handleSubmit">
          <!-- Marhala Info -->
          <div class="grid grid-cols-5 gap-4 mb-6">
            <div>
              <label class="block text-emerald-800 font-semibold mb-2">মারহালা নাম (বাংলা)</label>
              <InputText v-model="formData.marhalaNameBn" class="w-full p-inputtext-sm bg-emerald-50" />
            </div>
            <div>
              <label class="block text-emerald-800 font-semibold mb-2">মারহালা নাম (ইংরেজি)</label>
              <InputText v-model="formData.marhalaNameEn" class="w-full p-inputtext-sm bg-emerald-50" />
            </div>
            <div>
              <label class="block text-emerald-800 font-semibold mb-2">মারহালা নাম (আরবি)</label>
              <InputText v-model="formData.marhalaNameAr" class="w-full p-inputtext-sm bg-emerald-50 arabic-font" />
            </div>
            <div class="col-span-5">
              <Button
                type="button"
                @click="addNewRow"
                class="bg-emerald-500 text-white px-4 py-2 rounded-sm hover:bg-emerald-600 border-0"
              >
                <i class="fas fa-plus mr-2"></i> নতুন সাবজেক্ট যোগ করুন
              </Button>
            </div>
          </div>

          <!-- Subjects Table -->
          <DataTable :value="subjects" class="p-datatable-sm">
            <Column field="code" header="সাবজেক্ট কোড">
              <template #body="{data, index}">
                <InputText v-model="subjects[index].code" class="w-full p-inputtext-sm" />
              </template>
            </Column>

            <Column field="nameBangla" header="কিতাব নাম (বাংলা)">
              <template #body="{data, index}">
                <InputText v-model="subjects[index].nameBangla" class="w-full p-inputtext-sm" />
              </template>
            </Column>

            <Column field="nameEnglish" header="কিতাব নাম (ইংরেজি)">
              <template #body="{data, index}">
                <InputText v-model="subjects[index].nameEnglish" class="w-full p-inputtext-sm" />
              </template>
            </Column>

            <Column field="nameArabic" header="কিতাব নাম (আরবি)">
              <template #body="{data, index}">
                <InputText v-model="subjects[index].nameArabic" class="w-full p-inputtext-sm arabic-font" />
              </template>
            </Column>

            <Column field="status" header="স্ট্যাটাস">
              <template #body="{data, index}">
                <div class="flex justify-center gap-4">
                  <div class="field-radiobutton">
                    <RadioButton v-model="subjects[index].status" value="SRtype_1" :inputId="'status1_'+index" />
                    <label :for="'status1_'+index" class="ml-1">ছাত্র</label>
                  </div>
                  <div class="field-radiobutton">
                    <RadioButton v-model="subjects[index].status" value="SRtype_0" :inputId="'status2_'+index" />
                    <label :for="'status2_'+index" class="ml-1">ছাত্রী</label>
                  </div>
                  <div class="field-radiobutton">
                    <RadioButton v-model="subjects[index].status" value="Both" :inputId="'status3_'+index" />
                    <label :for="'status3_'+index" class="ml-1">উভয়</label>
                  </div>
                </div>
              </template>
            </Column>

            <Column header="অ্যাকশন">
              <template #body="{data, index}">
                <button
                  type="button"
                  @click="removeRow(index)"
                  class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </template>
            </Column>
          </DataTable>

          <div class="flex justify-end mt-6">
            <Button
              type="submit"
              class="bg-emerald-600 text-white px-6 py-2 rounded-md hover:bg-emerald-700 transition-colors duration-200 font-semibold shadow-md border-0"
            >
              সংরক্ষণ করুন
            </Button>
          </div>
        </form>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
  import { ref } from 'vue';
  import { router } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import InputText from 'primevue/inputtext';
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import RadioButton from 'primevue/radiobutton';

  const formData = ref({
    marhalaNameBn: '',
    marhalaNameEn: '',
    marhalaNameAr: '',
  });

  const subjects = ref([]);

  const addNewRow = () => {
    subjects.value.push({
      code: '',
      nameBangla: '',
      nameEnglish: '',
      nameArabic: '',
      status: 'Both'
    });
  };

  const removeRow = (index) => {
    subjects.value.splice(index, 1);
  };

  const handleSubmit = () => {
    router.post(route('marhalas.store'), {
      ...formData.value,
      subjects: subjects.value
    });
  };
  </script>

  <style scoped>
  .arabic-font {
    font-family: 'Amiri', 'Scheherazade New', serif;
  }

  :deep(.p-datatable-thead > tr > th) {
    background-color: #ecfdf5;
    color: #065f46;
    font-weight: 600;
    padding: 0.5rem;
  }

  :deep(.p-inputtext-sm) {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }

  :deep(.p-datatable-tbody > tr:hover) {
    background-color: #ecfdf5;
  }

  :deep(.p-radiobutton .p-radiobutton-box.p-highlight) {
    border-color: #059669;
    background: #059669;
  }

  /* Override PrimeVue default styles to match the original design */
  :deep(.p-inputtext:enabled:focus) {
    outline: 0 none;
    outline-offset: 0;
    box-shadow: 0 0 0 2px #10b981;
    border-color: #10b981;
  }

  :deep(.p-inputtext) {
    border: 1px solid #a7f3d0;
    border-radius: 0.125rem;
  }

  :deep(.p-datatable .p-datatable-tbody > tr > td) {
    border: 1px solid #e5e7eb;
    padding: 0.5rem;
  }

  :deep(.p-datatable .p-datatable-thead > tr > th) {
    border: 1px solid #e5e7eb;
  }
  </style>
