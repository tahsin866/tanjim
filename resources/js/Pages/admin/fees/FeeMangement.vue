<template>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-center">অনুষ্ঠান ফুড ম্যানেজমেন্ট</h1>
    <div class="mb-8">
      <label class="block mb-2 font-semibold">নিবন্ধিত অতিথি নির্বাচন করুন:</label>
      <select v-model="selectedUser" class="w-full p-2 border rounded">
        <option v-for="user in users" :key="user.id" :value="user.id">
          {{ user.name }} ({{ user.center }})
        </option>
      </select>
    </div>
    <div class="mb-8">
      <label class="block mb-2 font-semibold">তারিখ নির্বাচন করুন:</label>
      <select v-model="selectedDate" class="w-full p-2 border rounded">
        <option v-for="date in dates" :key="date">{{ date }}</option>
      </select>
    </div>
    <div class="mb-8">
      <label class="block mb-2 font-semibold">খাবার নির্বাচন করুন:</label>
      <div class="grid grid-cols-2 gap-4">
        <div v-for="meal in meals" :key="meal" class="flex items-center">
          <input
            type="checkbox"
            :id="meal"
            :value="meal"
            v-model="selectedMeals"
            class="mr-2"
          />
          <label :for="meal">{{ meal }}</label>
        </div>
      </div>
      <div class="mt-4">
        <input
          type="checkbox"
          id="nightStay"
          v-model="nightStay"
          class="mr-2"
        />
        <label for="nightStay">রাত্রিযাপন করতে চাই</label>
      </div>
    </div>
    <button
      @click="registerFood"
      class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
    >
      সাবমিট করুন
    </button>

    <div class="mt-8">
      <h2 class="text-xl font-semibold mb-2">রেজিস্ট্রেশন ডিটেইলস (ডামি ডাটা)</h2>
      <div
        v-for="(reg, idx) in registrations"
        :key="idx"
        class="bg-gray-100 p-4 mb-4 rounded"
      >
        <div>
          <strong>অতিথি:</strong> {{ getUserName(reg.userId) }}
        </div>
        <div>
          <strong>তারিখ:</strong> {{ reg.date }}
        </div>
        <div>
          <strong>খাবার:</strong> {{ reg.meals.join(', ') }}
        </div>
        <div>
          <strong>রাত্রিযাপন:</strong>
          <span v-if="reg.nightStay">হ্যাঁ</span>
          <span v-else>না</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// ডামি ইউজার ও সেন্টার
const users = [
  { id: 1, name: 'রফিক', center: 'সেন্টার ১' },
  { id: 2, name: 'জাহিদ', center: 'সেন্টার ২' },
  { id: 3, name: 'সুমন', center: 'সেন্টার ৩' },
  { id: 4, name: 'তাসনিম', center: 'সেন্টার ৪' },
  { id: 5, name: 'রায়হান', center: 'সেন্টার ৫' },
]

// ডামি ডেট
const dates = [
  '২০২৫-০৯-০১',
  '২০২৫-০৯-০২',
  '২০২৫-০৯-০৩'
]

// ৫ বেলা খাবার
const meals = [
  'সকাল',
  'ব্রেক',
  'দুপুর',
  'বিকেল',
  'রাত'
]

const selectedUser = ref(users[0].id)
const selectedDate = ref(dates[0])
const selectedMeals = ref([])
const nightStay = ref(false)

// রেজিস্ট্রেশন ডামি ডাটা
const registrations = ref([
  {
    userId: 1,
    date: '২০২৫-০৯-০১',
    meals: ['দুপুর', 'রাত'],
    nightStay: true,
  },
  {
    userId: 2,
    date: '২০২৫-০৯-০২',
    meals: ['রাত'],
    nightStay: false,
  },
])

function registerFood() {
  registrations.value.push({
    userId: selectedUser.value,
    date: selectedDate.value,
    meals: [...selectedMeals.value],
    nightStay: nightStay.value,
  })
  selectedMeals.value = []
  nightStay.value = false
}

function getUserName(id) {
  const user = users.find(u => u.id === id)
  return user ? `${user.name} (${user.center})` : ''
}
</script>