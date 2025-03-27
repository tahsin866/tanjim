<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue'

const desserts = [
  { Marhala: 'ফযীলত', fee: 500 },
  { Marhala: 'সানাবিয়া উলইয়া', fee: 700 },
  { Marhala: 'সানাবিয়া', fee: 800 },
  { Marhala: 'মুতাওয়াসসিতা', fee: 1000 },
  { Marhala: 'ইবতেদাইয়্যাহ', fee: 1200 },
  { Marhala: 'হিফজুল কোরআন', fee: 1500 },
  { Marhala: 'ক্বিরআত', fee: 1800 },
]

const payments = ref({})
const isDialogVisible = ref(false)
const selectedMarhala = ref('')
const totalAmount = ref(0)

const openPaymentDialog = (marhala, fee) => {
  selectedMarhala.value = marhala
  totalAmount.value = fee
  isDialogVisible.value = true
}

const confirmPayment = () => {
  payments.value[selectedMarhala.value] = 'paid'
  isDialogVisible.value = false
}
</script>

<template>
<AuthenticatedLayout>
    <div class="p-6 bg-white shadow-md rounded-sm mx-5 mt-5  border-green-700">
  <!-- Bismillah Header -->


  <h2 class="text-lg font-bold text-gray-800 bg-yellow-500 text-center py-2 rounded-sm shadow-md">
    ৪৮তম কেন্দ্রীয় পরীক্ষা: অন্তর্ভুক্তি পেমেন্ট সিস্টেম
  </h2>

  <!-- Table -->
  <table class="w-full border-collapse border border-gray-400 bg-gray-50 mt-3">
    <thead>
      <tr class="bg-green-700 text-white">
        <th class="border p-2">মারহালা</th>
        <th class="border p-2">মোট ফি</th>
        <th class="border p-2">পেমেন্ট স্ট্যাটাস</th>
        <th class="border p-2">একশন</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in desserts" :key="item.Marhala" class="text-center">
        <td class="border p-2">{{ item.Marhala }}</td>
        <td class="border p-2">{{ item.fee }} টাকা</td>
        <td class="border p-2">
          <span v-if="payments[item.Marhala] === 'paid'" class="text-green-700 font-bold">
            ✅ পরিশোধিত
          </span>
          <span v-else class="text-red-600 font-bold"> অপরিশোধিত</span>
        </td>
        <td class="border p-2">
          <button
            v-if="!payments[item.Marhala]"
            @click="openPaymentDialog(item.Marhala, item.fee)"
            class="bg-green-700 text-white px-4 py-1 rounded-sm hover:bg-green-800 transition"
          >
            💳 পেমেন্ট করুন
          </button>
          <span v-else class="text-gray-600"> সম্পন্ন</span>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<!-- Payment Dialog -->
<div v-if="isDialogVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96 border-t-4 border-green-700">
    <h3 class="text-lg font-semibold text-center text-green-800">
      {{ selectedMarhala }} - পেমেন্ট নিশ্চিতকরণ
    </h3>
    <p class="text-gray-700 mt-3 text-center">
      মোট পরিমাণ: <span class="text-xl font-bold text-green-700">{{ totalAmount }} টাকা</span>
    </p>
    <div class="mt-4 flex justify-center space-x-3">
      <button @click="isDialogVisible = false" class="bg-red-600 text-white px-4 py-1 rounded-md">
        ❌ বাতিল
      </button>
      <button @click="confirmPayment" class="bg-green-700 text-white px-4 py-1 rounded-md">
        ✅ নিশ্চিত করুন
      </button>
    </div>
  </div>
</div>

</AuthenticatedLayout>
</template>
