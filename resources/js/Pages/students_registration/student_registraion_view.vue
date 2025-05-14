<template>
    <AuthenticatedLayout>
      <div class="flex flex-col p-4 md:p-6">
        <!-- Main Card -->
        <Card class="border border-emerald-200 shadow-xl">
          <!-- Header with Islamic Pattern -->
          <template #header>
            <div class="bg-emerald-700 text-white p-6 relative overflow-hidden">
              <div class="absolute inset-0 opacity-10 pattern-islamic"></div>
            </div>
          </template>

          <!-- Content -->
          <template #content>
            <div class="p-6">
              <div class="grid">
                <div class="col-12 md:col-4">
                  <!-- Photo Section -->
                  <Card class="mb-6 border border-gray-200 shadow-sm">
  <template #content>
    <div class="flex flex-col items-center justify-center">
      <div
        style="width: 120px; height: 150px;"
        class="bg-gray-100 rounded-md flex flex-col items-center justify-center border border-dashed border-gray-300 mb-2 overflow-hidden"
      >
        <img
          v-if="student.student_image"
          :src="'/storage/' + student.student_image"
          alt="Student"
          class="w-full h-full object-cover"
          style="max-width: 120px; max-height: 150px;"
        />
        <p v-else class="text-gray-500 text-sm mt-2">কোনো ছবি নেই</p>
      </div>
      <p class="text-xs text-center text-gray-500 italic">* ছাত্রীদের ক্ষেত্রে ছবি প্রযোজ্য নয়</p>
    </div>
  </template>
</Card>


                </div>

                <div class="col-12 md:col-8">
                  <!-- Previous Exam Info Section -->
                  <Card v-if="student.is_old_student === 1" class="mb-6 border border-gray-200 shadow-sm">
                    <template #header>
                      <div class="flex items-center">

                        <h2 class="text-xl font-bold text-emerald-800 mt-5 mx-5">বিগত পরীক্ষার তথ্য</h2>
                      </div>
                    </template>
                    <template #content>
                      <DataTable :value="[previousExamInfo]" showGridlines stripedRows>
                        <Column field="examName" header="পরীক্ষার নাম">
                          <template #body="slotProps">
                            {{ student.exam_name_Bn }}
                          </template>
                        </Column>
                        <Column field="studentName" header="পরীক্ষার্থী নাম">
                          <template #body="slotProps">
                            {{ student.name_bn }}
                          </template>
                        </Column>
                        <Column field="gender" header="লিঙ্গ">
                          <template #body="slotProps">
                            ছাত্রী
                          </template>
                        </Column>
                        <Column field="fatherName" header="পিতার নাম">
                          <template #body="slotProps">
                            {{ student.father_name_bn }}
                          </template>
                        </Column>
                        <Column field="roll" header="রোল নং">
                          <template #body="slotProps">
                            {{ student.past_Roll }}
                          </template>
                        </Column>
                        <Column field="regNo" header="রেজিস্ট্রেসন নং">
                          <template #body="slotProps">
                            {{ student.past_reg_id }}
                          </template>
                        </Column>
                        <Column field="passingYear" header="পাশের সন">
                          <template #body="slotProps">
                            {{ student.passing_year }}
                          </template>
                        </Column>
                        <Column field="division" header="প্রাপ্ত বিভাগ">
                          <template #body="slotProps">
                            {{ student.division }}
                          </template>
                        </Column>
                        <Column field="madrasha" header="মাদরাসা">
                          <template #body="slotProps">
                            {{ student.madrasha_name }}
                          </template>
                        </Column>
                        <Column field="markaz" header="মারকায">
                          <template #body="slotProps">
                            {{ student.madrasha_name }}
                          </template>
                        </Column>
                        <Column field="board" header="বোর্ড">
                          <template #body="slotProps">
                            বেফাকুল মাদারিসিল আরাবিয়া বাংলাদেশ
                          </template>
                        </Column>
                      </DataTable>
                    </template>
                  </Card>

                  <!-- Personal Info Section -->
                  <Card class="border border-gray-200 shadow-sm">
                    <template #header>
                      <div class="flex items-center">

                        <h2 class="text-xl font-bold text-emerald-800 mt-5 mx-5">আবেদনকারীর তথ্য</h2>
                      </div>
                    </template>
                    <template #content>
                      <DataTable :value="[personalInfo]" showGridlines stripedRows>
                        <Column field="name" header="নাম">
                          <template #body="slotProps">
                            <div>
                              <span class="block">{{ student.name_bn }}</span>
                              <span class="text-gray-500 text-xs">{{ student.name_en }}</span>
                              <span class="text-gray-500 text-xs block">{{ student.name_ar }}</span>
                            </div>
                          </template>
                        </Column>
                        <Column field="fatherName" header="পিতার নাম">
                          <template #body="slotProps">
                            <div>
                              <span class="block">{{ student.father_name_bn }}</span>
                              <span class="block">{{ student.father_name_en }}</span>
                              <span class="text-gray-500 text-xs">{{ student.father_name_ar }}</span>
                            </div>
                          </template>
                        </Column>
                        <Column field="motherName" header="মাতার নাম">
                          <template #body="slotProps">
                            <div>
                              <span class="block">{{ student.mother_name_bn }}</span>
                              <span class="text-gray-500 text-xs">{{ student.mother_name_en }}</span>
                              <span class="text-gray-500 text-xs block">{{ student.mother_name_ar }}</span>
                            </div>
                          </template>
                        </Column>
                        <Column field="dob" header="জন্ম তারিখ">
                          <template #body="slotProps">
                            {{ student.Date_of_birth }}
                          </template>
                        </Column>
                        <Column field="nationality" header="জাতীয়তা">
                          <template #body="slotProps">
                            <div>
                              <span class="block">বাংলাদেশী</span>
                              <span class="text-gray-500 text-xs">Bangladeshi</span>
                              <span class="text-gray-500 text-xs block font-[Noto_Naskh_Arabic]">بنغلاديشي</span>
                            </div>
                          </template>
                        </Column>
                        <Column field="idCard" header="পরিচয়পত্র">
                          <template #body="slotProps">
                            <div>
                              <span class="block">জন্মসনদ</span>
                              <span class="block text-sm">{{ student.NID_no }}</span>
                              <Button
                                @click="showIdModal = true"
                                icon="pi pi-eye"
                                label="পরিচয়পত্রের স্ক্যান কপি দেখুন"
                                text
                                class="p-0 text-emerald-600 hover:text-emerald-800"
                              />
                            </div>
                          </template>
                        </Column>
                        <Column field="phone" header="ফোন নম্বর">
                          <template #body="slotProps">
                            01766839308
                          </template>
                        </Column>
                        <Column field="email" header="ইমেইল এড্রেস">
                          <template #body="slotProps">
                            <span class="text-gray-500 italic">প্রদান করা হয়নি</span>
                          </template>
                        </Column>
                        <Column field="address" header="স্থায়ী ঠিকানা">
                          <template #body="slotProps">
                            হাজী মোহাম্মদ খোরশেদ আকন কান্দি, পালেরচর হাট, জাজিরা, শরীয়তপুর
                          </template>
                        </Column>
                      </DataTable>
                    </template>
                  </Card>
                </div>
              </div>

              <!-- Footer with Verification -->
              <div class="mt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-500 text-sm mb-4 md:mb-0">
                  <div class="flex items-center">
                    <i class="pi pi-shield text-emerald-600 mr-1"></i>
                    <span>যাচাইকৃত তথ্য</span>
                  </div>
                  <p class="mt-1">রেজিস্ট্রেশন আইডি: DAWRAH-1446-2586</p>
                </div>
                <div class="flex space-x-3">
                  <Button
                    icon="pi pi-download"
                    label="ডাউনলোড"
                    class="p-button-secondary"
                  />
                  <Button
                    icon="pi pi-print"
                    label="প্রিন্ট করুন"
                    class="p-button-success bg-emerald-600 hover:bg-emerald-700"
                  />
                </div>
              </div>
            </div>
          </template>
        </Card>

        <!-- Islamic Quote -->
        <div class="mt-6 text-center text-emerald-800 max-w-2xl mx-auto">
          <p class="italic">"যে ব্যক্তি জ্ঞান অর্জনের জন্য পথ চলে, আল্লাহ তার জন্য জান্নাতের পথ সহজ করে দেন।"</p>
          <p class="text-sm mt-1">- সহীহ মুসলিম</p>
        </div>

        <!-- ID Document Modal -->
        <Dialog
  v-model:visible="showIdModal"
  modal
  header="পরিচয়পত্রের বিবরণ"
  :style="{ width: '90vw', maxWidth: '800px', fontFamily: '\'Merriweather\', \'SolaimanLipi\', sans-serif' }"
  :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
  :maximizable="true"
>

          <div
          style="font-family: 'Merriweather','SolaimanLipi',sans-serif;"

          class="grid">
            <div class="col-12 md:col-6">
              <!-- ID Document Image -->
              <div class="bg-gray-100 rounded-lg p-2 flex items-center justify-center">
                <img
          v-if="student.student_image"
          :src="'/storage/' + student.NID_attach"
          alt="Student"
          class="w-full h-full object-cover"
          style="max-width: 120px; max-height: 150px;"
        />
              </div>
            </div>
            <div class="col-12 md:col-6">
              <!-- ID Document Details -->
              <h4 class="text-lg font-bold text-emerald-800 mb-4">জন্মসনদ বিবরণ</h4>
              <DataTable :value="[idCardDetails]" showGridlines stripedRows>
                <Column field="name" header="নাম">
                  <template #body="slotProps">
                    শিখা আক্তার
                  </template>
                </Column>
                <Column field="fatherName" header="পিতার নাম">
                  <template #body="slotProps">
                    হাবিবুর রহমান খান
                  </template>
                </Column>
                <Column field="motherName" header="মাতার নাম">
                  <template #body="slotProps">
                    হাসিদা বেগম
                  </template>
                </Column>
                <Column field="dob" header="জন্ম তারিখ">
                  <template #body="slotProps">
                    ২০ অক্টোবর ২০০৬
                  </template>
                </Column>
                <Column field="birthCertNo" header="জন্মসনদ নম্বর">
                  <template #body="slotProps">
                    ২০০৬৮৬১৯৪৭৩১০১৩৯৪
                  </template>
                </Column>
                <Column field="regNo" header="নিবন্ধন নম্বর">
                  <template #body="slotProps">
                    ৪৬০২০৩৩০৫৭
                  </template>
                </Column>
                <Column field="issueDate" header="ইস্যু তারিখ">
                  <template #body="slotProps">
                    ১২ জানুয়ারি ২০১০
                  </template>
                </Column>
              </DataTable>
            </div>
          </div>
        </Dialog>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { ref } from 'vue';
  import Card from 'primevue/card';
  import Button from 'primevue/button';
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import Dialog from 'primevue/dialog';

  const props = defineProps({
    student: Object
  });

  // State for modal
  const showIdModal = ref(false);

// Dummy data for DataTable
const previousExamInfo = ref({});
const personalInfo = ref({});
const idCardDetails = ref({});
</script>

<style>
/* Islamic pattern background */
.pattern-islamic {
  background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* PrimeVue customizations to match the emerald theme */
:deep(.p-card) {
  border-radius: 0.5rem;
  overflow: hidden;
}

:deep(.p-card .p-card-content) {
  padding: 1.5rem;
}

:deep(.p-datatable .p-datatable-header) {
  background-color: #047857;
  color: white;
  font-weight: bold;
}

:deep(.p-datatable .p-datatable-thead > tr > th) {
  background-color: #ecfdf5;
  color: #047857;
  font-weight: bold;
}

:deep(.p-button.p-button-success) {
  background: #059669;
  border-color: #059669;
}

:deep(.p-button.p-button-success:hover) {
  background: #047857;
  border-color: #047857;
}

:deep(.p-dialog .p-dialog-header) {
  background-color: #047857;
  color: white;
}

:deep(.p-dialog .p-dialog-header .p-dialog-header-icon) {
  color: white;
}
</style>

