<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-gray-50 mx-5 mt-10">
        <Card class="mx-auto shadow-lg border-2 border-emerald-600">
          <template #title>
            <div class="text-center mb-4">
              <h3 class="text-2xl font-semibold text-emerald-700">কেন্দ্রীয় পরীক্ষা সেটাপ সংশোধন</h3>
            </div>
          </template>

          <template #content>
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <!-- Exam Name Input -->
              <div class="field">
                <label for="examName" class="block text-emerald-700 mb-2 font-medium">পরীক্ষার নাম</label>
                <InputText
                  id="examName"
                  v-model="examName"
                  class="w-full p-inputtext-lg"
                  placeholder="পরীক্ষার নাম লিখুন"
                />
              </div>

              <!-- Year Inputs Grid -->
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Arabic Year -->
                <div class="field">
                  <label for="arabicYear" class="block text-emerald-700 mb-2 font-medium">আরবি সন লিখুন (হিজরি)</label>
                  <InputText
                    id="arabicYear"
                    v-model="arabicYear"
                    class="w-full"
                  />
                </div>

                <!-- Bangla Year -->
                <div class="field">
                  <label for="banglaYear" class="block text-emerald-700 mb-2 font-medium">বাংলা সন লিখুন (বঙ্গাব্দ)</label>
                  <InputText
                    id="banglaYear"
                    v-model="banglaYear"
                    class="w-full"
                  />
                </div>

                <!-- English Year -->
                <div class="field">
                  <label for="englishYear" class="block text-emerald-700 mb-2 font-medium">ইংরেজি সন লিখুন (ঈসাব্দ)</label>
                  <InputText
                    id="englishYear"
                    v-model="englishYear"
                    class="w-full"
                  />
                </div>
              </div>

              <div class="flex justify-end mt-6">
                <Button
                  type="submit"
                  label="আপডেট করুন"
                  icon="pi pi-check"
                  class="p-button-success p-button-lg"
                />
              </div>
            </form>
          </template>
        </Card>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useToast } from 'primevue/usetoast';
  import Card from 'primevue/card';
  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';

  const toast = useToast();
  const examName = ref('');
  const arabicYear = ref('');
  const banglaYear = ref('');
  const englishYear = ref('');

  // Fetch exam setup data when component mounts
  onMounted(async () => {
    try {
      const examId = route().params.id;
      const response = await axios.get(`/api/exam-setups/${examId}`);

      if (response.data.success) {
        const examSetup = response.data.examSetup;
        examName.value = examSetup.exam_name;
        arabicYear.value = examSetup.arabic_year;
        banglaYear.value = examSetup.bangla_year;
        englishYear.value = examSetup.english_year;
      }
    } catch (error) {
      console.error('Error fetching exam setup:', error);
      toast.add({
        severity: 'error',
        summary: 'ত্রুটি',
        detail: 'দুঃখিত! পরীক্ষা সেটাপ লোড করতে সমস্যা হয়েছে।',
        life: 3000
      });
    }
  });

  const handleSubmit = async () => {
    try {
      const examId = route().params.id;
      const response = await axios.put(`/api/exam-setups/${examId}`, {
        exam_name: examName.value,
        arabic_year: arabicYear.value,
        bangla_year: banglaYear.value,
        english_year: englishYear.value
      });

      if (response.data.success) {
        toast.add({
          severity: 'success',
          summary: 'সফল',
          detail: response.data.message,
          life: 3000
        });
      }
    } catch (error) {
      toast.add({
        severity: 'error',
        summary: 'ত্রুটি',
        detail: 'দুঃখিত! কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।',
        life: 3000
      });
      console.error('Error updating exam setup:', error);
    }
  };
  </script>

  <style scoped>
  :deep(.p-card) {
    border-radius: 0.375rem;
    padding: 1rem;
  }

  :deep(.p-card-content) {
    padding: 1.5rem;
  }

  :deep(.p-card-title) {
    padding: 0;
  }

  :deep(.p-inputtext) {
    padding: 0.75rem 1rem;
    border-radius: 0.25rem;
    border: 2px solid #a7f3d0;
  }

  :deep(.p-inputtext:focus) {
    border-color: #10b981;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
  }

  :deep(.p-button-success) {
    background: #059669;
    border-color: #059669;
  }

  :deep(.p-button-success:hover) {
    background: #047857;
    border-color: #047857;
  }

  :deep(.p-button-lg) {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
  }
  </style>
