<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue'

const currentStep = ref(0)
const formData = ref({
  username: '',
  email: '',
  country: '',
  dateOfBirth: '',
  gender: ''
})

const qualifications = ref([{
  exam: '',
  passingYear: '',
  result: '',
  institution: '',
  madrasaName: ''
}])

const addQualification = () => {
  qualifications.value.push({
    exam: '',
    passingYear: '',
    result: '',
    institution: '',
    madrasaName: ''
  })
}

const removeQualification = (index) => {
  if (qualifications.value.length > 1) {
    qualifications.value.splice(index, 1)
  }
}

const onSubmit = () => {
  console.log(formData.value)
}
</script>

<template>
<AuthenticatedLayout>
    <div class="container-fluid mx-auto p-4 mt-5">
    <!-- Personal Information -->
    <div class="bg-white rounded-sm shadow-lg mb-6">
      <div class="bg-[#243b55] text-white p-4 rounded-t-sm">
        <h5 class="text-xl font-medium">ব্যক্তিগত তথ্য</h5>
      </div>

      <div class="p-6">
        <form @submit.prevent="onSubmit">
          <!-- Application Type -->
          <div class="mb-6">
            <label class="block text-gray-700 mb-2">আবেদনের ধরন নির্বাচন করুন</label>
            <select v-model="formData.applicationType"
                    class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
              <option value="">Select Item</option>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
            </select>
          </div>

          <!-- Personal Details Grid -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Name -->
            <div>
              <label class="block text-gray-700 mb-2">নাম</label>
              <input type="text"
                     v-model="formData.name"
                     class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                     placeholder="নাম">
            </div>

            <!-- Mobile -->
            <div>
              <label class="block text-gray-700 mb-2">মোবাইল নম্বর</label>
              <input type="tel"
                     v-model="formData.mobile"
                     class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                     placeholder="মোবাইল নম্বর">
            </div>

            <!-- WhatsApp -->
            <div>
              <label class="block text-gray-700 mb-2">হোয়াট্সঅ্যাপ নম্বর</label>
              <input type="tel"
                     v-model="formData.whatsapp"
                     class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                     placeholder="হোয়াট্সঅ্যাপ নম্বর">
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Educational Qualifications -->
    <div class="bg-white rounded-sm shadow-lg mb-6">
      <div class="bg-[#243b55] text-white p-4 rounded-t-sm">
        <h5 class="text-xl font-medium">শিক্ষাগত যোগ্যতা</h5>
      </div>

      <div class="p-6">
        <div v-for="(qual, index) in qualifications" :key="index" class="mb-4">
          <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
            <select v-model="qual.exam"
                    class="p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
              <option value="">মারহালা/ক্লাসের নাম</option>
            </select>

            <select v-model="qual.passingYear"
                    class="p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
              <option value="">পাসের সন</option>
            </select>

            <select v-model="qual.result"
                    class="p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
              <option value="">ফলাফল/বিভাগ</option>
            </select>

            <input type="text"
                   v-model="qual.institution"
                   class="p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                   placeholder="মাদরাসা/ইউনিভার্সিটির নাম">

            <div class="flex gap-2">
              <button @click="addQualification"
                      class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                +
              </button>
              <button v-if="qualifications.length > 1"
                      @click="() => removeQualification(index)"
                      class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                -
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="text-right">
      <button type="submit"
              class="bg-[#243b55] text-white px-6 py-2 rounded hover:bg-[#1a2d40] transition-colors">
        Submit
      </button>
    </div>
  </div>
</AuthenticatedLayout>
</template>
