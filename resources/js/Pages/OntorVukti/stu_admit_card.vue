<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue'

const search = ref('')
const selectedLevel = ref('')
const selectedType = ref('')

const levels = [
  { value: 'mutawassitah', label: 'মুতাওয়াসসিতা' },
  { value: 'thanawiyyah', label: 'সানাবিয়্যাহ' },
  { value: 'alimiyyah', label: 'ইবতেদাইয়্যাহ' }
]

const applicationTypes = [
  { value: 'new', label: 'নতুন আবেদন' },
  { value: 'renewal', label: 'নবায়ন' },
  { value: 'transfer', label: 'স্থানান্তর' }
]

const desserts = [
  {
    dessert: 'Frozen Yogurt',
    calories: 159,
    fat: 6,
    carbs: 24,
    protein: 4,
  }
]


const selected = ref({
  dafil: true,
  onumodito: true
})
</script>

<template>
<AuthenticatedLayout>
    <div class="mb-8 mx-5 mt-6">
    <!-- Search Card -->
    <div class="bg-white rounded-md shadow-lg">
      <div class="bg-emerald-900 p-3 rounded-t-md">
        <div class="flex justify-end">
          <button class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-md transition">
            <span>একসাথে ডাউনলোড করুন</span>
            <i class="fas fa-cloud-download-alt"></i>
          </button>
        </div>
      </div>

      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <!-- Marhala Dropdown -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">মারহালা তালিকা</label>
            <select
              v-model="selectedLevel"
              class="w-full rounded-md   border-emerald-200  focus:outline-none focus:ring-2 focus:ring-emerald-500"
            >
              <option value="">Select Item</option>
              <option v-for="level in levels" :key="level.value" :value="level.value">
                {{ level.label }}
              </option>
            </select>
          </div>

          <!-- Search Field -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">শিক্ষার্থী/রেজি:/এনআইড/বি আর এন</label>
            <div class="relative">
              <input
                v-model="search"
                type="text"
                class="w-full rounded-md   border-emerald-200  focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-3 pr-10"
                placeholder="Search ..."
              >
              <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
          </div>

          <!-- Application Type -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">আবেদনের ধরন</label>
            <select
              v-model="selectedType"
              class="w-full rounded-md   border-emerald-200  focus:outline-none focus:ring-2 focus:ring-emerald-500"
            >
              <option value="">Select Item</option>
              <option v-for="type in applicationTypes" :key="type.value" :value="type.value">
                {{ type.label }}
              </option>
            </select>
          </div>

          <!-- Buttons -->
          <div class="flex items-end gap-4">
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-md transition">
              <i class="fas fa-search mr-2"></i>
              সার্চ করুন
            </button>
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition">
              <i class="fas fa-redo-alt mr-2"></i>
              রেসেট
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Registration Card -->
    <div

    class="bg-white rounded-md shadow-lg mt-8">
      <div class="bg-emerald-900 p-4 rounded-t-md">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
          <div class="md:col-span-2">
            <h4 class="text-amber-400 text-lg">
              <i class="fas fa-scroll mr-2"></i>
              নিবন্ধন পত্র
            </h4>
          </div>
          <div class="md:col-span-2">
            <!-- Spacer -->
          </div>
          <div class="md:col-span-2">
            <h4 class="text-white mr-5 text-lg">
              <!-- <i class="fas fa-star-and-crescent mr-2"></i> -->
              ৪৮তম কেন্দ্রীয় পরীক্ষা: মুতাওয়াসসিতা
            </h4>
          </div>
        </div>
      </div>
      <div class="border-t border-gray-200"></div>
      <div class="p-6">
        <!-- Content goes here -->

        <div class="flex items-start justify-between w-full p-6 bg-emerald-50 rounded-lg border border-emerald-200">
    <!-- Student Information -->
    <div class="text-left space-y-3">
      <div class="flex items-center gap-2 mb-4">
        <i class="fas fa-user-graduate text-emerald-700"></i>
        <p class="font-semibold text-lg text-emerald-900">মৌনিন ইসলাম ফারিন</p>
      </div>
      <div class="space-y-2 text-emerald-800">
        <p class="flex items-center gap-2">
          <i class="fas fa-male text-emerald-600"></i>
          পিতা - মোঃ ফেজায়েল উদ্দিন
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-female text-emerald-600"></i>
          মাতা - মোছাঃ নাসরিন পারভিন
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-mosque text-emerald-600"></i>
          নিবন্ধিত মাদ্রাসার কোড - ৪০৭১২১
        </p>
      </div>
    </div>

    <!-- Exam Information -->
    <div class="text-left space-y-3">
      <div class="flex items-center gap-2 mb-4">
        <i class="fas fa-scroll text-emerald-700"></i>
        <p class="font-semibold text-emerald-900">নিবন্ধন</p>
      </div>
      <div class="space-y-2 text-emerald-800">
        <p class="flex items-center gap-2">
          <i class="fas fa-book-open text-emerald-600"></i>
          দাওরায়ে হাদীস - ১৪৪৬
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-id-card text-emerald-600"></i>
          রেজিস্ট্রেশন নং - ৫৯১৫৮৯৭৯৯
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-fingerprint text-emerald-600"></i>
          নিবন্ধন নং - ৮৪০৩০৩০১৯১
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-list-ol text-emerald-600"></i>
          গত পরীক্ষার রোল নং - ১৪২২৩
        </p>
      </div>
    </div>

    <!-- Checkbox Section -->
    <div class="space-y-3 bg-white p-4 rounded-lg shadow-sm">
      <div class="flex items-center gap-3">
        <input
          type="checkbox"
          v-model="selected.dafil"
          class="w-5 h-5 text-emerald-600 border-emerald-300 rounded focus:ring-emerald-500"
        >
        <label class="flex items-center gap-2 text-emerald-800">

     বেফাকুল মাদারসিল আরাবিয়া
        </label>
      </div>
      <div class="flex items-center gap-3">
        <input
          type="checkbox"
          v-model="selected.onumodito"
          class="w-5 h-5 text-emerald-600 border-emerald-300 rounded focus:ring-emerald-500"
        >
        <label class="flex items-center gap-2 text-emerald-800">

      সংযুুক্তি
        </label>
      </div>
      <div class="flex items-center gap-3">
        <input
          type="checkbox"
          v-model="selected.onumodito"
          class="w-5 h-5 text-emerald-600 border-emerald-300 rounded focus:ring-emerald-500"
        >
        <label class="flex items-center gap-2 text-emerald-800">

পেমেন্ট
        </label>
      </div>
    </div>

    <!-- Button -->
    <button class="bg-emerald-700 text-white px-6 py-2 rounded-md hover:bg-emerald-800 transition-colors duration-200 flex items-center gap-2">
  <i class="fas fa-cloud-download-alt"></i>
  <!-- <i class="fas fa-download"></i> -->
  ডাউনলোড
</button>

  </div>
      </div>
    </div>
  </div>
</AuthenticatedLayout>
</template>

<style scoped>
.font-arabic {
  font-family: 'Noto Naskh Arabic', serif;
}
</style>
