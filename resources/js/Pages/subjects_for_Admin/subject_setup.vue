<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-white shadow-md rounded-sm border-t-4 border-emerald-600 mx-5 mt-5">
        <div class="mb-6 text-center relative">
          <div class="absolute inset-0 bg-emerald-50 opacity-25"></div>
          <h2 class="text-2xl font-bold text-emerald-800 py-3">বিষয় তথ্য সংযোজন</h2>
        </div>

        <!-- Success Message -->
        <Toast />

        <form @submit.prevent="submit" class="grid grid-cols-4 gap-6">
          <!-- মারহালার নাম -->
          <div class="col-span-1">
            <label class="block text-sm font-semibold text-emerald-800 mb-2">মারহালার নাম</label>
            <InputText
              :value="marhalaName"
              readonly
              class="w-full bg-emerald-50"
            />
          </div>

          <!-- বিষয় -->
          <div class="col-span-1">
            <label class="block text-sm font-semibold text-emerald-800 mb-2">বিষয় নির্বাচন করুন *</label>
            <Dropdown
              v-model="form.subject_id"
              :options="subjects"
              optionLabel="name_bangla"
              optionValue="id"
              placeholder="নির্বাচন করুন"
              class="w-full bg-emerald-50"
            />
          </div>

          <!-- সিলেবাসের ধরন -->
          <div class="col-span-1">
            <label class="block text-sm font-semibold text-emerald-800 mb-2">সিলেবাসের ধরন *</label>
            <Dropdown
              v-model="form.syllabus_type"
              :options="syllabusTypes"
              optionLabel="name"
              optionValue="value"
              placeholder="নির্বাচন করুন"
              class="w-full bg-emerald-50"
            />
          </div>

          <!-- মারকাযের ধরন -->
          <div class="col-span-1">
            <label class="block text-sm font-semibold text-emerald-800 mb-2">মারকাযের ধরন *</label>
            <Dropdown
              v-model="form.markaz_type"
              :options="markazTypes"
              optionLabel="name"
              optionValue="value"
              placeholder="নির্বাচন করুন"
              class="w-full bg-emerald-50"
            />
          </div>

          <!-- বিষয়ের ধরন -->
          <div class="col-span-1">
            <label class="block text-sm font-semibold text-emerald-800 mb-2">বিষয়ের ধরন *</label>
            <Dropdown
              v-model="form.subject_type"
              :options="subjectTypes"
              optionLabel="name"
              optionValue="value"
              placeholder="নির্বাচন করুন"
              class="w-full bg-emerald-50"
            />
          </div>

          <!-- ছাত্র/ছাত্রীর ধরন -->
          <div class="col-span-1">
            <label class="block text-sm font-semibold text-emerald-800 mb-2">ছাত্র/ছাত্রীর ধরন *</label>
            <Dropdown
              v-model="form.student_type"
              :options="studentTypes"
              optionLabel="name"
              optionValue="value"
              placeholder="নির্বাচন করুন"
              class="w-full bg-emerald-50"
            />
          </div>

          <!-- মোট মার্ক -->
          <div class="col-span-1">
            <label class="block text-sm font-semibold text-emerald-800 mb-2">মোট মার্ক *</label>
            <InputNumber
              v-model="form.total_marks"
              class="w-full bg-emerald-50"
              inputClass="w-full"
            />
          </div>

          <!-- পাশ মার্ক -->
          <div class="col-span-1">
            <label class="block text-sm font-semibold text-emerald-800 mb-2">পাশ মার্ক *</label>
            <InputNumber
              v-model="form.pass_marks"
              class="w-full bg-emerald-50"
              inputClass="w-full"
            />
          </div>

          <!-- স্ট্যাটাস -->
          <div class="col-span-1">
            <label class="block text-sm font-semibold text-emerald-800 mb-2">স্ট্যাটাস *</label>
            <Dropdown
              v-model="form.status"
              :options="statusOptions"
              optionLabel="name"
              optionValue="value"
              class="w-full bg-emerald-50"
            />
          </div>

          <!-- Submit Button -->
          <div class="col-span-4 flex justify-end mt-4">
            <Button
              type="submit"
              :loading="form.processing"
              icon="pi pi-check"
              label="সংরক্ষণ করুন"
              class="bg-emerald-600 hover:bg-emerald-700"
            />
          </div>
        </form>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
  import { ref, computed, onMounted, watch } from 'vue'
  import axios from 'axios'
  import { useForm } from '@inertiajs/vue3'
  import { useToast } from 'primevue/usetoast'

  // PrimeVue Components
  import InputText from 'primevue/inputtext'
  import Dropdown from 'primevue/dropdown'
  import InputNumber from 'primevue/inputnumber'
  import Button from 'primevue/button'
  import Toast from 'primevue/toast'

  const toast = useToast()
  const marhala = ref({})
  const subjects = ref([])
  const loading = ref(true)
  const marhalaName = computed(() => marhala.value?.marhala_name_bn || '')

  // Dropdown options
  const syllabusTypes = [
    { name: 'আবশ্যিক', value: 'আবশ্যিক' },
    { name: 'নৈর্বাচনিক', value: 'নৈর্বাচনিক' }
  ]

  const markazTypes = [
    { name: 'দরসিয়াত', value: 'দরসিয়াত' },
    { name: 'হিফজুল কোরআন', value: 'হিফজুল কোরআন' },
    { name: 'কিরাআত', value: 'কিরাআত' }
  ]

  const subjectTypes = [
    { name: 'মিইয়ারী', value: 'মিইয়ারী' },
    { name: 'গায়রে মিইয়ারী', value: 'গায়রে মিইয়ারী' }
  ]

  const studentTypes = [
    { name: 'ছাত্র', value: 'ছাত্র' },
    { name: 'ছাত্রী', value: 'ছাত্রী' },
    { name: 'উভয়', value: 'উভয়' }
  ]

  const statusOptions = [
    { name: 'সক্রিয়', value: 'active' },
    { name: 'নিষ্ক্রিয়', value: 'inactive' }
  ]

  const fetchData = async (marhalaId) => {
    try {
      const response = await axios.get(`/api/marhala/${marhalaId}/subjects`);
      marhala.value = response.data.marhala;
      subjects.value = response.data.subjects;
      form.Marhala_type = response.data.marhala.marhala_name_bn;
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  const form = useForm({
    marhala_id: route().params.marhala,
    subject_id: '',
    Marhala_type: '',
    Subject_Names: '',
    student_type: '',
    syllabus_type: '',
    markaz_type: '',
    subject_type: '',
    subject_code: '',
    total_marks: '',
    pass_marks: '',
    status: 'active'
  });

  const submit = async () => {
    try {
      const response = await axios.post(route('subject-settings.store'), form);
      if (response.data.success) {
        const marhalaId = form.marhala_id;
        form.reset();
        form.marhala_id = marhalaId;

        // Show success message with PrimeVue Toast
        toast.add({
          severity: 'success',
          summary: 'সফল',
          detail: response.data.message,
          life: 3000
        });

        // Refresh data
        await fetchData(marhalaId);
      }
    } catch (error) {
      if (error.response?.data?.errors) {
        // Handle validation errors
        console.error('Validation errors:', error.response.data.errors);
        toast.add({
          severity: 'error',
          summary: 'ত্রুটি',
          detail: 'ফর্ম সংরক্ষণ করা যায়নি। অনুগ্রহ করে সকল তথ্য সঠিকভাবে পূরণ করুন।',
          life: 5000
        });
      } else {
        console.error('Error saving data:', error);
        toast.add({
          severity: 'error',
          summary: 'ত্রুটি',
          detail: 'একটি ত্রুটি ঘটেছে। পরে আবার চেষ্টা করুন।',
          life: 5000
        });
      }
    }
  };

  watch(() => form.subject_id, (newValue) => {
    if (newValue) {
      const selectedSubject = subjects.value.find(subject => subject.id === parseInt(newValue));
      if (selectedSubject) {
        form.Subject_Names = selectedSubject.name_bangla;
        form.subject_code = selectedSubject.subject_code;
        form.Marhala_type = marhala.value.marhala_name_bn;
      }
    }
  });

  onMounted(() => {
    const marhalaId = route().params.marhala
    fetchData(marhalaId)
  })
  </script>

  <style scoped>
  /* PrimeVue custom styling */
  :deep(.p-dropdown) {
    width: 100%;
  }

  :deep(.p-inputtext) {
    width: 100%;
  }

  :deep(.p-button) {
    background-color: rgb(5, 150, 105);
    border-color: rgb(5, 150, 105);
  }

  :deep(.p-button:hover) {
    background-color: rgb(4, 120, 87);
    border-color: rgb(4, 120, 87);
  }

  :deep(.p-inputnumber-input) {
    width: 100%;
  }
  </style>
