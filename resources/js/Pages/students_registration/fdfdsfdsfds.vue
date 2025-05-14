<template>
 ‍<AuthenticatedLayout>
<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">নেগরান/মুমতাহিন এডিট</h2>
    <div v-if="loading" class="text-gray-500">তথ্য লোড হচ্ছে...</div>
    <div v-else>
      <!-- Debug info to see what values we're getting -->

      <div class="mb-4">
        <label>নাম:</label>
        <input v-model="form.name" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>মোবাইল:</label>
        <input v-model="form.mobile" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>জন্ম তারিখ:</label>
        <input v-model="form.birth_date" type="date" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>হোয়াটসঅ্যাপ:</label>
        <input v-model="form.whatsapp" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>জন্ম নিবন্ধন নম্বর:</label>
        <input v-model="form.birth_reg_no" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>এনআইডি:</label>
        <input v-model="form.nid" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>লিঙ্গ:</label>
        <select v-model="form.gender" class="border px-2 py-1 w-full">
          <option value="">লিঙ্গ নির্বাচন করুন</option>
          <option value="পুরুষ">পুরুষ</option>
          <option value="মহিলা">মহিলা</option>
          <option value="অন্যান্য">অন্যান্য</option>
        </select>
      </div>
      <div class="mb-4">
        <label>আবেদনের ধরণ:</label>
        <select v-model="form.application_type" class="border px-2 py-1 w-full">
          <option value="">আবেদনের ধরণ নির্বাচন করুন</option>
          <option value="নেগরান">নেগরান</option>
          <option value="মুমতাহিন">মুমতাহিন</option>
          <option value="উভয়">উভয়</option>
        </select>
      </div>
      <div class="mb-4">
        <label>শিক্ষকতার অভিজ্ঞতা:</label>
        <input v-model="form.teaching_experience" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>নির্বাচিত বই:</label>
        <input v-model="form.selected_book" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>নগদ নম্বর:</label>
        <input v-model="form.nagad_number" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>রকেট নম্বর:</label>
        <input v-model="form.rocket_number" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>বিকাশ নম্বর:</label>
        <input v-model="form.bkash_number" type="text" class="border px-2 py-1 w-full" />
      </div>
      <div class="mb-4">
        <label>নেগরান মন্তব্য:</label>
        <textarea v-model="form.negaranComments" class="border px-2 py-1 w-full" rows="3"></textarea>
      </div>
      <div class="mb-4">
        <label>মুমতাহিন মন্তব্য:</label>
        <textarea v-model="form.mumtahinComments" class="border px-2 py-1 w-full" rows="3"></textarea>
      </div>
      <button @click="updateTeacher" class="bg-blue-500 text-white px-4 py-2 rounded">
        আপডেট করো
      </button>
      <p v-if="message" class="text-green-600 mt-3">{{ message }}</p>
    </div>
  </div>
 </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

// query string থেকে id নিচ্ছি
const urlParams = new URLSearchParams(window.location.search)
const id = urlParams.get('id')

// API থেকে আসা অরিজিনাল ভ্যালু রাখার জন্য
const originalGender = ref('')
const originalAppType = ref('')

const form = ref({
  name: '',
  mobile: '',
  birth_date: '',
  whatsapp: '',
  birth_reg_no: '',
  nid: '',
  gender: '',
  application_type: '',
  teaching_experience: '',
  selected_book: '',
  nagad_number: '',
  rocket_number: '',
  bkash_number: '',
  muhtamim_file: '',
  nid_file: '',
  birth_cert_file: '',
  negaranComments: '',
  mumtahinComments: '',
  profile_image: ''
})

const loading = ref(true)
const message = ref('')

const getTeacher = async () => {
  try {
    const response = await axios.get(`/api/negran/edit/${id}`)
    console.log('API Response:', response.data) // ডিবাগ লগ

    // সাধারণ ফিল্ডগুলো সেট করি
    form.value.name = response.data.name || ''
    form.value.mobile = response.data.mobile || ''
    form.value.birth_date = response.data.birth_date || ''
    form.value.whatsapp = response.data.whatsapp || ''
    form.value.birth_reg_no = response.data.birth_reg_no || ''
    form.value.nid = response.data.nid || ''
    form.value.teaching_experience = response.data.teaching_experience || ''
    form.value.selected_book = response.data.selected_book || ''
    form.value.nagad_number = response.data.nagad_number || ''
    form.value.rocket_number = response.data.rocket_number || ''
    form.value.bkash_number = response.data.bkash_number || ''
    form.value.muhtamim_file = response.data.muhtamim_file || ''
    form.value.nid_file = response.data.nid_file || ''
    form.value.birth_cert_file = response.data.birth_cert_file || ''
    form.value.negaranComments = response.data.negaranComments || ''
    form.value.mumtahinComments = response.data.mumtahinComments || ''
    form.value.profile_image = response.data.profile_image || ''

    // অরিজিনাল ভ্যালু সেভ করি
    originalGender.value = response.data.gender
    originalAppType.value = response.data.application_type

    // জেন্ডার সেট করি - বাংলা ভ্যালু অনুযায়ী
    if (response.data.gender === 'পুরুষ' || response.data.gender === 'male' || response.data.gender === 1) {
      form.value.gender = 'পুরুষ'
    } else if (response.data.gender === 'মহিলা' || response.data.gender === 'female' || response.data.gender === 2) {
      form.value.gender = 'মহিলা'
    } else if (response.data.gender === 'অন্যান্য' || response.data.gender === 'other' || response.data.gender === 3) {
      form.value.gender = 'অন্যান্য'
    } else {
      form.value.gender = ''
    }

    // অ্যাপ্লিকেশন টাইপ সেট করি - বাংলা ভ্যালু অনুযায়ী
    if (response.data.application_type === 'নেগরান' || response.data.application_type === 'negran' || response.data.application_type === 1) {
      form.value.application_type = 'নেগরান'
    } else if (response.data.application_type === 'মুমতাহিন' || response.data.application_type === 'mumtahin' || response.data.application_type === 2) {
      form.value.application_type = 'মুমতাহিন'
    } else if (response.data.application_type === 'উভয়' || response.data.application_type === 'both' || response.data.application_type === 3) {
      form.value.application_type = 'উভয়'
    } else {
      form.value.application_type = ''
    }

    loading.value = false
  } catch (error) {
    console.error('Failed to load teacher:', error)
  }
}

const updateTeacher = async () => {
  try {
    // আপডেট করার সময় API-এর প্রয়োজন অনুযায়ী ভ্যালু কনভার্ট করি
    const formData = { ...form.value }

    // জেন্ডার কনভার্ট করি যদি প্রয়োজন হয়
    if (originalGender.value === 'male' || originalGender.value === 1) {
      formData.gender = formData.gender === 'পুরুষ' ? 'male' : formData.gender
    } else if (originalGender.value === 'female' || originalGender.value === 2) {
      formData.gender = formData.gender === 'মহিলা' ? 'female' : formData.gender
    } else if (originalGender.value === 'other' || originalGender.value === 3) {
      formData.gender = formData.gender === 'অন্যান্য' ? 'other' : formData.gender
    }

    // অ্যাপ্লিকেশন টাইপ কনভার্ট করি যদি প্রয়োজন হয়
    if (originalAppType.value === 'negran' || originalAppType.value === 1) {
      formData.application_type = formData.application_type === 'নেগরান' ? 'negran' : formData.application_type
    } else if (originalAppType.value === 'mumtahin' || originalAppType.value === 2) {
      formData.application_type = formData.application_type === 'মুমতাহিন' ? 'mumtahin' : formData.application_type
    } else if (originalAppType.value === 'both' || originalAppType.value === 3) {
      formData.application_type = formData.application_type === 'উভয়' ? 'both' : formData.application_type
    }

    const response = await axios.put(`/api/negran/update/${id}`, formData)
    message.value = response.data.message
  } catch (error) {
    console.error('Update failed:', error)
  }
}

onMounted(() => {
  getTeacher()
})
</script>
