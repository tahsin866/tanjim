<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const desserts = ref([])
const payments = ref({})
const isDialogVisible = ref(false)
const selectedMarhala = ref('')
const totalAmount = ref(0)
const newStudentsCount = ref(0)
const isLoading = ref(true)
const isProcessing = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

onMounted(async () => {
  try {
    isLoading.value = true
    const response = await axios.get('/api/payment-stats')
    desserts.value = response.data
    
    // পেমেন্ট স্ট্যাটাস চেক করা
    await checkPaymentStatus()
    
    isLoading.value = false
  } catch (error) {
    console.error('Error fetching payment stats:', error)
    isLoading.value = false
  }
})


// পেমেন্ট স্ট্যাটাস চেক করার ফাংশন
const checkPaymentStatus = async () => {
  try {
    const response = await axios.get('/api/check-payment-status')
    
    // পেমেন্ট স্ট্যাটাস আপডেট করা
    if (response.data && response.data.length > 0) {
      response.data.forEach(item => {
        payments.value[item.class] = item.is_paid ? 'paid' : null
        
        // Update the isPaid property in desserts array
        const dessertIndex = desserts.value.findIndex(d => d.Marhala === item.class)
        if (dessertIndex !== -1) {
          desserts.value[dessertIndex].isPaid = item.is_paid
        }
      })
    }
  } catch (error) {
    console.error('Error checking payment status:', error)
  }
}


const openPaymentDialog = async (marhala, fee) => {
  try {
    isLoading.value = true
    
    // শুধু নতুন ছাত্রদের তথ্য নিয়ে আসা - exam_id পারামিটার যোগ করা
    const response = await axios.get(`/api/unpaid-students-count?class=${marhala}`)
    
    // সঠিক ছাত্র সংখ্যা এবং মোট পরিমাণ নেওয়া
    newStudentsCount.value = response.data.count
    totalAmount.value = response.data.total_amount
    
    selectedMarhala.value = marhala
    isDialogVisible.value = true
    
    // Reset messages
    successMessage.value = ''
    errorMessage.value = ''
    
    isLoading.value = false
  } catch (error) {
    console.error('Error fetching unpaid students:', error)
    isLoading.value = false
    errorMessage.value = 'ছাত্রদের তথ্য লোড করতে সমস্যা হয়েছে।'
  }
}


const confirmPayment = async () => {
  try {
    isProcessing.value = true
    
    // পেমেন্ট ডাটা সার্ভারে পাঠানো
    const response = await axios.post('/api/store-payment', {
      class: selectedMarhala.value,
      total_amount: totalAmount.value
    })
    
    // সফল হলে
    payments.value[selectedMarhala.value] = 'paid'
    successMessage.value = response.data.message
    
    // Update the desserts array to mark the current marhala as paid
    const marhalaToPay = selectedMarhala.value
    desserts.value = desserts.value.map(item => {
      if (item.Marhala === marhalaToPay) {
        return { ...item, isPaid: true }
      }
      return item
    })
    
    // 3 সেকেন্ড পর ডায়ালগ বন্ধ করা
    setTimeout(() => {
      isDialogVisible.value = false
      successMessage.value = ''
    }, 3000)
  } catch (error) {
    console.error('Payment error:', error)
    errorMessage.value = 'পেমেন্ট প্রক্রিয়াকরণে সমস্যা হয়েছে। আবার চেষ্টা করুন।'
  } finally {
    isProcessing.value = false
  }
}

</script>

<template>
<AuthenticatedLayout>
  <div class="p-6 bg-white shadow-md rounded-sm mx-5 mt-5 border-green-700">
    <!-- Bismillah Header -->
    <h2 class="text-lg font-bold text-gray-800 bg-yellow-500 text-center py-2 rounded-sm shadow-md">
      ৪৮তম কেন্দ্রীয় পরীক্ষা: নিবন্ধন পেমেন্ট সিস্টেম
    </h2>
    
    <!-- Loading indicator -->
    <div v-if="isLoading" class="text-center py-4">
      <p>লোড হচ্ছে...</p>
    </div>
    
    <!-- Table -->
    <table v-else class="w-full border-collapse border border-gray-400 bg-gray-50 mt-3">
      <thead>
        <tr class="bg-green-700 text-white">
          <th class="border p-2">মারহালা</th>
          <th class="border p-2">নিয়মিত ছাত্র</th>
          <th class="border p-2">নিয়মিত ফি</th>
          <th class="border p-2">নিয়মিত মোট ফি</th>
          <th class="border p-2">অনিয়মিত ছাত্র</th>
          <th class="border p-2">অনিয়মিত ফি</th>
          <th class="border p-2">পেমেন্ট স্ট্যাটাস</th>
          <th class="border p-2">একশন</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in desserts" :key="item.Marhala" class="text-center">
          <td class="border p-2">{{ item.Marhala }}</td>
          <td class="border p-2">{{ item.regularCount }} জন</td>
          <td class="border p-2">{{ item.regularFee }} টাকা</td>
          <td class="border p-2">{{ item.regularTotalFee }} টাকা</td>
          <td class="border p-2">{{ item.irregularCount }} জন</td>
          <td class="border p-2">{{ item.irregularFee }} টাকা</td>
          <td class="border p-2">
  <span v-if="item.isPaid" class="text-green-700 font-bold">
    ✅ পরিশোধিত
  </span>
  <span v-else class="text-red-600 font-bold"> অপরিশোধিত</span>
</td>
       <td class="border p-2">
  <button
    v-if="!item.isPaid"
    @click="openPaymentDialog(item.Marhala, item.regularTotalFee + item.irregularTotalFee)"
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
      
      <!-- Loading indicator -->
      <div v-if="isLoading" class="text-center py-4">
        <p>লোড হচ্ছে...</p>
      </div>
      
      <div v-else>
        <div class="mt-3 text-center">
          <p class="text-gray-700">
            নতুন ছাত্র সংখ্যা: <span class="font-semibold">{{ newStudentsCount }} জন</span>
          </p>
          <p class="text-gray-700 mt-2">
            মোট পরিমাণ: <span class="text-xl font-bold text-green-700">{{ totalAmount }} টাকা</span>
          </p>
        </div>
        
        <!-- Success Message -->
        <div v-if="successMessage" class="mt-3 p-2 bg-green-100 text-green-800 rounded text-center">
          {{ successMessage }}
        </div>
        
        <!-- Error Message -->
        <div v-if="errorMessage" class="mt-3 p-2 bg-red-100 text-red-800 rounded text-center">
          {{ errorMessage }}
        </div>
      </div>
      
      <div class="mt-4 flex justify-center space-x-3">
        <button 
          @click="isDialogVisible = false" 
          class="bg-red-600 text-white px-4 py-1 rounded-md"
          :disabled="isProcessing || isLoading"
        >
          ❌ বাতিল
        </button>
        <button 
          @click="confirmPayment" 
          class="bg-green-700 text-white px-4 py-1 rounded-md"
          :disabled="isProcessing || isLoading || newStudentsCount === 0"
        >
          <span v-if="isProcessing">প্রক্রিয়াকরণ হচ্ছে...</span>
          <span v-else>✅ নিশ্চিত করুন</span>
        </button>
      </div>
    </div>
  </div>
</AuthenticatedLayout>
</template>
