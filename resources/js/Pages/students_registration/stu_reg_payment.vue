<template>
    <AuthenticatedLayout>
      <div class="p-6 mx-5 mt-5">
        <!-- Bismillah Header -->
        <Card class="mb-4">
          <template #header>
            <div class="bg-yellow-500 text-center py-3 rounded-t-md shadow-md">
              <h2 class="text-xl font-bold text-gray-800">
                ৪৮তম কেন্দ্রীয় পরীক্ষা: নিবন্ধন পেমেন্ট সিস্টেম
              </h2>
            </div>
          </template>
          <template #content>
            <!-- Loading indicator -->
            <div v-if="isLoading" class="text-center py-4">
              <ProgressSpinner style="width:50px;height:50px" strokeWidth="5" fill="var(--surface-ground)" animationDuration=".5s" />
              <p class="mt-3 text-lg">লোড হচ্ছে...</p>
            </div>

            <!-- Table -->
            <DataTable
              v-else
              :value="desserts"
              stripedRows
              responsiveLayout="scroll"
              class="p-datatable-sm"
            >
              <Column field="Marhala" header="মারহালা" style="min-width: 120px"></Column>
              <Column field="regularCount" header="নিয়মিত ছাত্র">
                <template #body="slotProps">
                  {{ slotProps.data.regularCount }} জন
                </template>
              </Column>
              <Column field="regularFee" header="নিয়মিত ফি">
                <template #body="slotProps">
                  {{ slotProps.data.regularFee }} টাকা
                </template>
              </Column>
              <Column field="regularTotalFee" header="নিয়মিত মোট ফি">
                <template #body="slotProps">
                  {{ slotProps.data.regularTotalFee }} টাকা
                </template>
              </Column>
              <Column field="irregularCount" header="অনিয়মিত ছাত্র">
                <template #body="slotProps">
                  {{ slotProps.data.irregularCount }} জন
                </template>
              </Column>
              <Column field="irregularFee" header="অনিয়মিত ফি">
                <template #body="slotProps">
                  {{ slotProps.data.irregularFee }} টাকা
                </template>
              </Column>
              <Column field="isPaid" header="পেমেন্ট স্ট্যাটাস">
                <template #body="slotProps">
                  <Tag v-if="slotProps.data.isPaid" severity="success" value="পরিশোধিত" icon="pi pi-check"></Tag>
                  <Tag v-else severity="danger" value="অপরিশোধিত" icon="pi pi-times"></Tag>
                </template>
              </Column>
              <Column header="একশন">
                <template #body="slotProps">
                  <Button
                    v-if="!slotProps.data.isPaid"
                    @click="openPaymentDialog(slotProps.data.Marhala, slotProps.data.regularTotalFee + slotProps.data.irregularTotalFee)"
                    icon="pi pi-credit-card"
                    label="পেমেন্ট করুন"
                    severity="success"
                    size="small"
                    class="p-button-raised"
                  />
                  <Tag v-else severity="info" value="সম্পন্ন" icon="pi pi-check-circle"></Tag>
                </template>
              </Column>
            </DataTable>
          </template>
        </Card>
      </div>

      <!-- Payment Dialog -->
      <Dialog
        v-model:visible="isDialogVisible"
        :style="{width: '450px'}"
        header="পেমেন্ট নিশ্চিতকরণ"
        :modal="true"
        :closable="!isProcessing"
        :closeOnEscape="!isProcessing"
      >
        <div class="flex flex-column align-items-center">
          <h3 class="text-lg font-semibold text-center text-green-800 mb-3">
            {{ selectedMarhala }} - পেমেন্ট নিশ্চিতকরণ
          </h3>

          <!-- Loading indicator -->
          <div v-if="isLoading" class="text-center py-4">
            <ProgressSpinner style="width:50px;height:50px" strokeWidth="5" fill="var(--surface-ground)" animationDuration=".5s" />
            <p class="mt-3">লোড হচ্ছে...</p>
          </div>

          <div v-else class="w-full">
            <div class="mt-3 text-center">
              <div class="flex justify-content-between align-items-center p-3 border-bottom-1 border-300">
                <span class="text-gray-700">নতুন ছাত্র সংখ্যা:</span>
                <span class="font-semibold">{{ newStudentsCount }} জন</span>
              </div>
              <div class="flex justify-content-between align-items-center p-3 bg-green-50">
                <span class="text-gray-700">মোট পরিমাণ:</span>
                <span class="text-xl font-bold text-green-700">{{ totalAmount }} টাকা</span>
              </div>
            </div>

            <!-- Success Message -->
            <Message v-if="successMessage" severity="success" :closable="false" class="mt-3 w-full">{{ successMessage }}</Message>

            <!-- Error Message -->
            <Message v-if="errorMessage" severity="error" :closable="false" class="mt-3 w-full">{{ errorMessage }}</Message>
          </div>
        </div>

        <template #footer>
          <div class="flex justify-content-center gap-2">
            <Button
              @click="isDialogVisible = false"
              label="বাতিল"
              icon="pi pi-times"
              severity="secondary"
              :disabled="isProcessing || isLoading"
              class="p-button-raised"
            />
            <Button
              @click="confirmPayment"
              label="নিশ্চিত করুন"
              icon="pi pi-check"
              severity="success"
              :disabled="isProcessing || isLoading || newStudentsCount === 0"
              :loading="isProcessing"
              class="p-button-raised"
            />
          </div>
        </template>
      </Dialog>
    </AuthenticatedLayout>
  </template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Card from 'primevue/card';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Tag from 'primevue/tag';
import ProgressSpinner from 'primevue/progressspinner';
import Message from 'primevue/message';

const desserts = ref([]);
const payments = ref({});
const isDialogVisible = ref(false);
const selectedMarhala = ref('');
const totalAmount = ref(0);
const newStudentsCount = ref(0);
const isLoading = ref(true);
const isProcessing = ref(false);
const successMessage = ref('');
const errorMessage = ref('');

onMounted(async () => {
  try {
    isLoading.value = true;
    const response = await axios.get('/api/payment-stats');
    desserts.value = response.data;

    // পেমেন্ট স্ট্যাটাস চেক করা
    await checkPaymentStatus();

    isLoading.value = false;
  } catch (error) {
    console.error('Error fetching payment stats:', error);
    isLoading.value = false;
  }
});

// পেমেন্ট স্ট্যাটাস চেক করার ফাংশন
const checkPaymentStatus = async () => {
  try {
    const response = await axios.get('/api/check-payment-status');

    // পেমেন্ট স্ট্যাটাস আপডেট করা
    if (response.data && response.data.length > 0) {
      response.data.forEach(item => {
        payments.value[item.class] = item.is_paid ? 'paid' : null;

        // Update the isPaid property in desserts array
        const dessertIndex = desserts.value.findIndex(d => d.Marhala === item.class);
        if (dessertIndex !== -1) {
          desserts.value[dessertIndex].isPaid = item.is_paid;
        }
      });
    }
  } catch (error) {
    console.error('Error checking payment status:', error);
  }
};

const openPaymentDialog = async (marhala, fee) => {
  try {
    isLoading.value = true;

    // শুধু নতুন ছাত্রদের তথ্য নিয়ে আসা - exam_id পারামিটার যোগ করা
    const response = await axios.get(`/api/unpaid-students-count?class=${marhala}`);

    // সঠিক ছাত্র সংখ্যা এবং মোট পরিমাণ নেওয়া
    newStudentsCount.value = response.data.count;
    totalAmount.value = response.data.total_amount;

    selectedMarhala.value = marhala;
    isDialogVisible.value = true;

    // Reset messages
    successMessage.value = '';
    errorMessage.value = '';

    isLoading.value = false;
  } catch (error) {
    console.error('Error fetching unpaid students:', error);
    isLoading.value = false;
    errorMessage.value = 'ছাত্রদের তথ্য লোড করতে সমস্যা হয়েছে।';
  }
};

const confirmPayment = async () => {
  try {
    isProcessing.value = true;

    // পেমেন্ট ডাটা সার্ভারে পাঠানো
    const response = await axios.post('/api/store-payment', {
      class: selectedMarhala.value,
      total_amount: totalAmount.value
    });

    // সফল হলে
    payments.value[selectedMarhala.value] = 'paid';
    successMessage.value = response.data.message;

    // Update the desserts array to mark the current marhala as paid
    const marhalaToPay = selectedMarhala.value;
    desserts.value = desserts.value.map(item => {
      if (item.Marhala === marhalaToPay) {
        return { ...item, isPaid: true };
      }
      return item;
    });

    // 3 সেকেন্ড পর ডায়ালগ বন্ধ করা
    setTimeout(() => {
      isDialogVisible.value = false;
      successMessage.value = '';
    }, 3000);
  } catch (error) {
    console.error('Payment error:', error);
    errorMessage.value = 'পেমেন্ট প্রক্রিয়াকরণে সমস্যা হয়েছে। আবার চেষ্টা করুন।';
  } finally {
    isProcessing.value = false;
  }
};
</script>


  <style scoped>
  :deep(.p-card) {
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
  }

  :deep(.p-card-header) {
    padding: 0;
    border-bottom: none;
  }

  :deep(.p-card-content) {
    padding: 1.5rem;
  }

  :deep(.p-datatable .p-datatable-thead > tr > th) {
    background-color: #15803d; /* green-700 */
    color: white;
    text-align: center;
    padding: 0.75rem;
    font-weight: 600;
  }

  :deep(.p-datatable .p-datatable-tbody > tr) {
    text-align: center;
  }

  :deep(.p-datatable .p-datatable-tbody > tr:nth-child(even)) {
    background-color: #f8fafc;
  }

  :deep(.p-datatable .p-datatable-tbody > tr:hover) {
    background-color: #f1f5f9;
  }

  :deep(.p-button.p-button-success) {
    background-color: #15803d;
    border-color: #15803d;
  }

  :deep(.p-button.p-button-success:hover) {
    background-color: #166534;
    border-color: #166534;
  }

  :deep(.p-dialog-header) {
    border-bottom: 4px solid #15803d;
    padding: 1.25rem 1.5rem;
  }

  :deep(.p-dialog-content) {
    padding: 1.5rem;
  }

  :deep(.p-dialog-footer) {
    padding: 1rem 1.5rem 1.5rem 1.5rem;
    border-top: 1px solid #e2e8f0;
  }

  :deep(.p-tag) {
    font-weight: 600;
  }
  </style>
