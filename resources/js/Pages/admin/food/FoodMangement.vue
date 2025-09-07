<template>
  <AuthenticatedLayout>
    <div class=" bg-slate-50 py-8 px-4">
      <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
          <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-slate-900">Admin Food Management</h1>
                <p class="text-slate-600 text-sm">খাবার আবেদন পর্যালোচনা ও অনুমোদন সিস্টেম</p>
              </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="flex flex-wrap gap-4">
              <div class="bg-blue-50 px-4 py-2 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ pendingCount }}</div>
                <div class="text-xs text-blue-700">অপেক্ষমান</div>
              </div>
              <div class="bg-green-50 px-4 py-2 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ approvedCount }}</div>
                <div class="text-xs text-green-700">অনুমোদিত</div>
              </div>
              <div class="bg-red-50 px-4 py-2 rounded-lg">
                <div class="text-2xl font-bold text-red-600">{{ rejectedCount }}</div>
                <div class="text-xs text-red-700">প্রত্যাখ্যাত</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
          <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex flex-wrap gap-4">
              <!-- Status Filter -->
              <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-slate-700">স্ট্যাটাস:</label>
                <select v-model="statusFilter" class="px-3 py-2 border border-slate-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                  <option value="all">সব</option>
                  <option value="pending">অপেক্ষমান</option>
                  <option value="approved">অনুমোদিত</option>
                  <option value="rejected">প্রত্যাখ্যাত</option>
                </select>
              </div>

              <!-- Date Filter -->
              <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-slate-700">তারিখ:</label>
                <input 
                  type="date" 
                  v-model="dateFilter"
                  class="px-3 py-2 border border-slate-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                />
              </div>

              <!-- User Filter -->
              <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-slate-700">ইউজার:</label>
                <select v-model="userFilter" class="px-3 py-2 border border-slate-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                  <option value="all">সব ইউজার</option>
                  <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select>
              </div>
            </div>

            <!-- Bulk Actions -->
            <div class="flex items-center space-x-2">
              <div v-if="selectedApplications.length > 0" class="flex items-center space-x-2">
                <span class="text-sm text-slate-600">{{ selectedApplications.length }}টি নির্বাচিত</span>
                <button
                  @click="bulkApprove"
                  class="px-3 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition-colors"
                >
                  সব অনুমোদন
                </button>
                <button
                  @click="bulkReject"
                  class="px-3 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition-colors"
                >
                  সব প্রত্যাখ্যান
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Applications List -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
          <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-semibold text-slate-900">আবেদনসমূহ</h2>
              <div class="flex items-center space-x-2">
                <input 
                  type="checkbox" 
                  :checked="selectAll"
                  @change="toggleSelectAll"
                  class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500"
                />
                <label class="text-sm text-slate-600">সব নির্বাচন</label>
              </div>
            </div>
          </div>

          <div class="divide-y divide-slate-200 max-h-[600px] overflow-y-auto">
            <div v-for="application in filteredApplications" :key="application.id" 
              class="p-6 hover:bg-slate-50 transition-colors">
              
              <div class="flex items-start space-x-4">
                <!-- Selection Checkbox -->
                <div class="flex items-center pt-1">
                  <input 
                    type="checkbox" 
                    :value="application.id"
                    v-model="selectedApplications"
                    class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500"
                  />
                </div>

                <!-- User Avatar -->
                <div class="flex-shrink-0">
                  <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold">{{ getUserName(application.userId).charAt(0) }}</span>
                  </div>
                </div>

                <!-- Application Details -->
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between mb-2">
                    <div>
                      <h3 class="text-lg font-semibold text-slate-900">{{ getUserName(application.userId) }}</h3>
                      <p class="text-sm text-slate-600">{{ getUserCenter(application.userId) }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                      <span :class="getStatusBadgeClass(application.status)" class="px-3 py-1 rounded-full text-xs font-medium">
                        {{ getStatusText(application.status) }}
                      </span>
                      <span class="text-sm text-slate-500">{{ formatDateTime(application.createdAt) }}</span>
                    </div>
                  </div>

                  <!-- Application Info -->
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                      <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">তারিখ</label>
                      <p class="text-sm font-medium text-slate-900">{{ formatDate(application.date) }}</p>
                    </div>
                    <div>
                      <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">রাত্রিযাপন</label>
                      <p class="text-sm font-medium" :class="application.nightStay ? 'text-green-600' : 'text-red-500'">
                        {{ application.nightStay ? 'হ্যাঁ' : 'না' }}
                      </p>
                    </div>
                    <div>
                      <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">মোট খাবার</label>
                      <p class="text-sm font-medium text-slate-900">{{ application.meals.length }}টি</p>
                    </div>
                  </div>

                  <!-- Meals -->
                  <div class="mb-4">
                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-2 block">নির্বাচিত খাবার</label>
                    <div class="flex flex-wrap gap-2">
                      <span v-for="meal in application.meals" :key="meal"
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ meal }}
                      </span>
                    </div>
                  </div>

                  <!-- Admin Note (if any) -->
                  <div v-if="application.adminNote" class="mb-4">
                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-1 block">এডমিন নোট</label>
                    <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-md">{{ application.adminNote }}</p>
                  </div>

                  <!-- Action Buttons -->
                  <div v-if="application.status === 'pending'" class="flex items-center space-x-3">
                    <button
                      @click="showApprovalModal(application)"
                      class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors"
                    >
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg>
                      অনুমোদন
                    </button>
                    <button
                      @click="showRejectionModal(application)"
                      class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors"
                    >
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                      প্রত্যাখ্যান
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- No Data -->
            <div v-if="filteredApplications.length === 0" class="p-12 text-center">
              <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <h3 class="text-lg font-medium text-slate-900 mb-2">কোন আবেদন পাওয়া যায়নি</h3>
              <p class="text-slate-500">নির্বাচিত ফিল্টার অনুযায়ী কোন আবেদন নেই।</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Approval Modal -->
    <div v-if="showModal && modalType === 'approve'" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900">আবেদন অনুমোদন</h3>
          </div>
          <p class="text-slate-600 mb-4">আপনি কি এই আবেদনটি অনুমোদন করতে চান?</p>
          
          <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">অনুমোদনের নোট (ঐচ্ছিক)</label>
            <textarea 
              v-model="adminNote"
              rows="3" 
              class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500"
              placeholder="অতিরিক্ত মন্তব্য লিখুন..."
            ></textarea>
          </div>

          <div class="flex space-x-3">
            <button
              @click="approveApplication"
              class="flex-1 bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors font-medium"
            >
              অনুমোদন করুন
            </button>
            <button
              @click="closeModal"
              class="flex-1 bg-slate-200 text-slate-800 py-2 px-4 rounded-md hover:bg-slate-300 transition-colors font-medium"
            >
              বাতিল
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Rejection Modal -->
    <div v-if="showModal && modalType === 'reject'" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900">আবেদন প্রত্যাখ্যান</h3>
          </div>
          <p class="text-slate-600 mb-4">আপনি কি এই আবেদনটি প্রত্যাখ্যান করতে চান?</p>
          
          <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">প্রত্যাখ্যানের কারণ <span class="text-red-500">*</span></label>
            <textarea 
              v-model="adminNote"
              rows="3" 
              class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500"
              placeholder="প্রত্যাখ্যানের কারণ লিখুন..."
              required
            ></textarea>
          </div>

          <div class="flex space-x-3">
            <button
              @click="rejectApplication"
              :disabled="!adminNote.trim()"
              class="flex-1 bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition-colors font-medium disabled:bg-slate-300 disabled:cursor-not-allowed"
            >
              প্রত্যাখ্যান করুন
            </button>
            <button
              @click="closeModal"
              class="flex-1 bg-slate-200 text-slate-800 py-2 px-4 rounded-md hover:bg-slate-300 transition-colors font-medium"
            >
              বাতিল
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Toast Notification -->
    <transition name="toast">
      <div v-if="showToast" 
        :class="[
          'fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2',
          toastType === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
        ]">
        <svg v-if="toastType === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        <span class="font-medium">{{ toastMessage }}</span>
      </div>
    </transition>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
import { ref, computed, onMounted } from 'vue'

// Users data
const users = [
  { id: 1, name: 'রফিক উদ্দিন', center: 'সেন্টার ১' },
  { id: 2, name: 'জাহিদ হাসান', center: 'সেন্টার ২' },
  { id: 3, name: 'সুমন আহমেদ', center: 'সেন্টার ৩' },
  { id: 4, name: 'তাসনিম জাহান', center: 'সেন্টার ৪' },
  { id: 5, name: 'রায়হান আলী', center: 'সেন্টার ৫' },
]

// Filters
const statusFilter = ref('all')
const dateFilter = ref('')
const userFilter = ref('all')
const selectedApplications = ref([])

// Modal states
const showModal = ref(false)
const modalType = ref('')
const selectedApplication = ref(null)
const adminNote = ref('')

// Toast
const showToast = ref(false)
const toastType = ref('success')
const toastMessage = ref('')

// Sample applications data
const applications = ref([
  {
    id: 1,
    userId: 1,
    date: '2025-09-01',
    meals: ['সকালের নাশতা', 'দুপুরের খাবার', 'রাতের খাবার'],
    nightStay: true,
    status: 'pending',
    createdAt: new Date('2025-08-27T10:30:00'),
    adminNote: ''
  },
  {
    id: 2,
    userId: 2,
    date: '2025-09-02',
    meals: ['দুপুরের খাবার'],
    nightStay: false,
    status: 'approved',
    createdAt: new Date('2025-08-27T11:15:00'),
    adminNote: 'অনুমোদিত - সব ঠিক আছে'
  },
  {
    id: 3,
    userId: 3,
    date: '2025-09-01',
    meals: ['সকালের নাশতা', 'রাতের খাবার'],
    nightStay: true,
    status: 'rejected',
    createdAt: new Date('2025-08-27T09:45:00'),
    adminNote: 'প্রত্যাখ্যাত - পূর্বের আবেদন বাকি আছে'
  },
  {
    id: 4,
    userId: 4,
    date: '2025-09-03',
    meals: ['বিকেলের নাশতা', 'রাতের খাবার'],
    nightStay: false,
    status: 'pending',
    createdAt: new Date('2025-08-27T14:20:00'),
    adminNote: ''
  },
  {
    id: 5,
    userId: 5,
    date: '2025-09-01',
    meals: ['সকালের নাশতা', 'দুপুরের খাবার', 'বিকেলের নাশতা'],
    nightStay: true,
    status: 'pending',
    createdAt: new Date('2025-08-27T16:10:00'),
    adminNote: ''
  }
])

// Computed properties
const filteredApplications = computed(() => {
  let filtered = applications.value

  if (statusFilter.value !== 'all') {
    filtered = filtered.filter(app => app.status === statusFilter.value)
  }

  if (dateFilter.value) {
    filtered = filtered.filter(app => app.date === dateFilter.value)
  }

  if (userFilter.value !== 'all') {
    filtered = filtered.filter(app => app.userId === userFilter.value)
  }

  return filtered.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt))
})

const pendingCount = computed(() => applications.value.filter(app => app.status === 'pending').length)
const approvedCount = computed(() => applications.value.filter(app => app.status === 'approved').length)
const rejectedCount = computed(() => applications.value.filter(app => app.status === 'rejected').length)

const selectAll = computed({
  get: () => filteredApplications.value.length > 0 && selectedApplications.value.length === filteredApplications.value.length,
  set: (value) => {
    if (value) {
      selectedApplications.value = filteredApplications.value.map(app => app.id)
    } else {
      selectedApplications.value = []
    }
  }
})

// Methods
function getUserName(userId) {
  const user = users.find(u => u.id === userId)
  return user ? user.name : 'Unknown'
}

function getUserCenter(userId) {
  const user = users.find(u => u.id === userId)
  return user ? user.center : 'Unknown'
}

function getStatusBadgeClass(status) {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    approved: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800'
  }
  return classes[status] || 'bg-slate-100 text-slate-800'
}

function getStatusText(status) {
  const texts = {
    pending: 'অপেক্ষমান',
    approved: 'অনুমোদিত',
    rejected: 'প্রত্যাখ্যাত'
  }
  return texts[status] || status
}

function formatDate(dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString('bn-BD', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

function formatDateTime(dateTime) {
  const date = new Date(dateTime)
  return date.toLocaleString('bn-BD', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

function toggleSelectAll() {
  selectAll.value = !selectAll.value
}

function showApprovalModal(application) {
  selectedApplication.value = application
  modalType.value = 'approve'
  adminNote.value = ''
  showModal.value = true
}

function showRejectionModal(application) {
  selectedApplication.value = application
  modalType.value = 'reject'
  adminNote.value = ''
  showModal.value = true
}

function closeModal() {
  showModal.value = false
  selectedApplication.value = null
  adminNote.value = ''
}

function approveApplication() {
  if (selectedApplication.value) {
    const app = applications.value.find(a => a.id === selectedApplication.value.id)
    if (app) {
      app.status = 'approved'
      app.adminNote = adminNote.value || 'অনুমোদিত'
      showToast.value = true
      toastType.value = 'success'
      toastMessage.value = 'আবেদন সফলভাবে অনুমোদিত হয়েছে!'
      setTimeout(() => showToast.value = false, 3000)
    }
  }
  closeModal()
}

function rejectApplication() {
  if (selectedApplication.value && adminNote.value.trim()) {
    const app = applications.value.find(a => a.id === selectedApplication.value.id)
    if (app) {
      app.status = 'rejected'
      app.adminNote = adminNote.value
      showToast.value = true
      toastType.value = 'success'
      toastMessage.value = 'আবেদন প্রত্যাখ্যান করা হয়েছে!'
      setTimeout(() => showToast.value = false, 3000)
    }
  }
  closeModal()
}

function bulkApprove() {
  selectedApplications.value.forEach(appId => {
    const app = applications.value.find(a => a.id === appId)
    if (app && app.status === 'pending') {
      app.status = 'approved'
      app.adminNote = 'বাল্ক অনুমোদন'
    }
  })
  selectedApplications.value = []
  showToast.value = true
  toastType.value = 'success'
  toastMessage.value = 'নির্বাচিত আবেদনগুলো অনুমোদিত হয়েছে!'
  setTimeout(() => showToast.value = false, 3000)
}

function bulkReject() {
  selectedApplications.value.forEach(appId => {
    const app = applications.value.find(a => a.id === appId)
    if (app && app.status === 'pending') {
          app.status = 'rejected'
      app.adminNote = 'বাল্ক প্রত্যাখ্যান'
    }
  })
  selectedApplications.value = []
  showToast.value = true
  toastType.value = 'error'
  toastMessage.value = 'নির্বাচিত আবেদনগুলো প্রত্যাখ্যাত হয়েছে!'
  setTimeout(() => showToast.value = false, 3000)
}

// Optional: Reset selection when filtered list changes
onMounted(() => {
  // You might want to reset selections whenever filter changes
  // But for simplicity, not adding watcher here
})

</script>

<style>
.toast-enter-active, .toast-leave-active {
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.toast-enter-from, .toast-leave-to {
  opacity: 0;
  transform: translateY(-20px) scale(.96);
}
</style>