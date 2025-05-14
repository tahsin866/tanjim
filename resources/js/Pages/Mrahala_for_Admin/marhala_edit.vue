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
              <label class="block text-emerald-800 text-xl font-semibold mb-2">মারহালা নাম (বাংলা)</label>
              <InputText v-model="form.marhalaNameBn" class="w-full text-xl bg-emerald-50" />
            </div>
            <div>
              <label class="block text-emerald-800 text-xl font-semibold mb-2">মারহালা নাম (ইংরেজি)</label>
              <InputText v-model="form.marhalaNameEn" class="w-full text-xl bg-emerald-50" />
            </div>
            <div>
              <label class="block text-emerald-800 text-xl font-semibold mb-2">মারহালা নাম (আরবি)</label>
              <InputText v-model="form.marhalaNameAr" class="w-full text-xl bg-emerald-50 arabic-font" />
            </div>
            <div class="col-span-5">
              <Button
                type="button"
                @click="addNewRow"
                class="bg-emerald-500 text-white px-4 py-2 text-xl rounded-sm hover:bg-emerald-600 border-0"
              >
                <i class="fas fa-plus mr-2"></i> নতুন সাবজেক্ট যোগ করুন
              </Button>
            </div>
          </div>

          <!-- Subjects Table -->
          <DataTable :value="form.subjects" class="text-xl">
            <Column field="code" header="সাবজেক্ট কোড">
              <template #body="{data, index}">
                <InputText v-model="form.subjects[index].code" class="w-full text-xl" />
              </template>
              <template #header>

              </template>
            </Column>

            <Column field="nameBangla" header="কিতাব নাম (বাংলা)">
              <template #body="{data, index}">
                <InputText v-model="form.subjects[index].nameBangla" class="w-full text-xl" />
              </template>
              <template #header>

              </template>
            </Column>

            <Column field="nameEnglish" header="কিতাব নাম (ইংরেজি)">
              <template #body="{data, index}">
                <InputText v-model="form.subjects[index].nameEnglish" class="w-full text-xl" />
              </template>
              <template #header>

              </template>
            </Column>

            <Column field="nameArabic" header="কিতাব নাম (আরবি)">
              <template #body="{data, index}">
                <InputText v-model="form.subjects[index].nameArabic" class="w-full text-xl arabic-font" />
              </template>
              <template #header>

              </template>
            </Column>

            <Column field="status" header="স্ট্যাটাস">
              <template #body="{data, index}">
                <div class="flex justify-center gap-4">
                  <div class="field-radiobutton">
                    <RadioButton v-model="form.subjects[index].status" value="SRtype_1" :inputId="'status1_'+index" />
                    <label :for="'status1_'+index" class="ml-1 text-xl">ছাত্র</label>
                  </div>
                  <div class="field-radiobutton">
                    <RadioButton v-model="form.subjects[index].status" value="SRtype_0" :inputId="'status2_'+index" />
                    <label :for="'status2_'+index" class="ml-1 text-xl">ছাত্রী</label>
                  </div>
                  <div class="field-radiobutton">
                    <RadioButton v-model="form.subjects[index].status" value="Both" :inputId="'status3_'+index" />
                    <label :for="'status3_'+index" class="ml-1 text-xl">উভয়</label>
                  </div>
                </div>
              </template>

            </Column>

            <Column header="অ্যাকশন">
              <template #body="{data, index}">
                <button
                  type="button"
                  @click="removeRow(index)"
                  class="bg-red-500 text-white px-3 py-1 text-xl rounded hover:bg-red-600"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </template>
              <template #header>

              </template>
            </Column>
          </DataTable>

          <div class="flex justify-end mt-6">
            <Button
              type="submit"
              class="bg-emerald-600 text-white px-6 py-2 text-xl rounded-md hover:bg-emerald-700 transition-colors duration-200 font-semibold shadow-md border-0"
            >
              সংশোধন করুন
            </Button>
          </div>
        </form>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { router } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import InputText from 'primevue/inputtext';
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import RadioButton from 'primevue/radiobutton';

  const props = defineProps({
    marhala: {
      type: Object,
      required: true
    }
  });

  const marhalaId = props.marhala.id;

  const form = ref({
    marhalaNameBn: props.marhala.marhala_name_bn,
    marhalaNameEn: props.marhala.marhala_name_en,
    marhalaNameAr: props.marhala.marhala_name_ar,
    subjects: props.marhala.subjects.map(subject => ({
      code: subject.subject_code,
      nameBangla: subject.name_bangla,
      nameEnglish: subject.name_english,
      nameArabic: subject.name_arabic,
      status: subject.status || 'Both'
    }))
  });

  // নতুন সারি যোগ করা
  const addNewRow = () => {
    form.value.subjects.push({
      code: '',
      nameBangla: '',
      nameEnglish: '',
      nameArabic: '',
      status: 'Both'
    });
  };

  // সারি রিমুভ করা
  const removeRow = (index) => {
    form.value.subjects.splice(index, 1);
  };

  // ফর্ম সাবমিট
  const handleSubmit = () => {
    router.put(`/marhalas/${marhalaId}`, form.value);
  };
  </script>

  <style scoped>
  .arabic-font {
    font-family: 'Amiri', 'Scheherazade New', serif;
  }

  :deep(.p-datatable-thead > tr > th) {
    background-color: #ecfdf5;
    border: 1px solid #e5e7eb;
    padding: 0.5rem;
  }

  :deep(.p-datatable-tbody > tr > td) {
    border: 1px solid #e5e7eb;
    padding: 0.5rem;
  }

  :deep(.p-datatable-tbody > tr:hover) {
    background-color: #ecfdf5;
  }

  :deep(.p-inputtext) {
    padding: 0.25rem 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.125rem;
  }

  :deep(.p-inputtext:enabled:focus) {
    outline: 0 none;
    outline-offset: 0;
    box-shadow: 0 0 0 2px #10b981;
    border-color: #10b981;
  }

  :deep(.p-radiobutton .p-radiobutton-box.p-highlight) {
    border-color: #059669;
    background: #059669;
  }

  :deep(.p-radiobutton .p-radiobutton-box) {
    width: 1.25rem;
    height: 1.25rem;
  }

  :deep(.p-button) {
    font-size: 1.25rem;
  }
  </style>
