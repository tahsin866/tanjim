<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col font-['Merriweather','SolaimanLipi',sans-serif]">

    <!-- Suspended User Message -->
    <div v-if="isUserSuspended" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 p-10 rounded-lg shadow-2xl max-w-md m-8 border border-gray-300 dark:border-gray-700 animate-fadeIn">
        <div class="text-center">
          <div class="bg-red-100 dark:bg-red-900/30 w-20 h-20 rounded-full mx-auto flex items-center justify-center mb-6">
            <i class="pi pi-ban text-5xl text-red-500 dark:text-red-400"></i>
          </div>
          <h2 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-4">অ্যাকাউন্ট স্থগিত</h2>
          <p class="text-gray-700 dark:text-gray-300 mb-4">আপনার অ্যাকাউন্ট সাময়িকভাবে স্থগিত করা হয়েছে।</p>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">আরো তথ্যের জন্য প্রশাসনের সাথে যোগাযোগ করুন।</p>
          <div class="mt-6">
            <Link :href="route('logout')" method="post" as="button"
                  class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-8 py-3 rounded-md shadow-md hover:shadow-lg font-medium">
              <span class="flex items-center justify-center gap-2">
                <i class="pi pi-sign-out"></i>
                <span>লগ আউট</span>
              </span>
            </Link>
          </div>
        </div>
      </div>
    </div>

    <!-- Normal Layout -->
    <template v-else>
      <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <AppSidebar
          :visible="sidebarVisible"
          :is-mobile="isMobile"
          @hide="sidebarVisible = false"
          class="bg-gray-900 text-white shadow-lg"
        />

        <!-- Main Layout -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative"
             :class="{'lg:ml-64': !isMobile, 'ml-0': isMobile}">
          
          <!-- Header -->
          <AppHeader
            :is-mobile="isMobile"
            :centers="centers"
            @toggle-sidebar="sidebarVisible = !sidebarVisible"
            class="bg-white dark:bg-gray-800 shadow-md border-b border-gray-300 dark:border-gray-700"
          />

          <!-- Content -->
          <div class="flex-1 overflow-auto pt-16 md:pt-20 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-700 scrollbar-track-gray-200 dark:scrollbar-track-gray-800 bg-gray-100 dark:bg-gray-900">
            <main class="flex-1 p-3 md:p-6 max-w-full pb-20">

              <!-- Breadcrumb -->
              <div v-if="showBreadcrumb" class="mb-4 px-2">
                <Breadcrumb :model="breadcrumbItems"
                  class="bg-gray-200 dark:bg-gray-700 p-2 rounded-md border border-gray-300 dark:border-gray-600 text-sm font-medium shadow-sm">
                  <template #item="{ item }">
                    <Link
                      v-if="item.route"
                      :href="item.route"
                      class="text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-2"
                    >
                      <i v-if="item.icon" :class="[item.icon, 'text-gray-500 dark:text-gray-300']"></i>
                      <span>{{ item.label }}</span>
                    </Link>
                    <span v-else class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
                      <i v-if="item.icon" :class="[item.icon, 'text-gray-500 dark:text-gray-300']"></i>
                      <span>{{ item.label }}</span>
                    </span>
                  </template>
                </Breadcrumb>
              </div>

              <!-- Page Title -->
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 px-2">
                <h1 class="text-xl font-bold text-gray-800 dark:text-white tracking-wide uppercase">
                  {{ getPageTitle() }}
                </h1>
                <div class="flex items-center text-xs text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 px-3 py-1 rounded border border-gray-300 dark:border-gray-600 shadow-sm">
                  <i class="pi pi-calendar mr-2"></i>
                  <span>{{ getCurrentDate() }}</span>
                </div>
              </div>

              <!-- Page Content (Card Style) -->
              <div class="bg-white dark:bg-gray-800 rounded-md border border-gray-300 dark:border-gray-600 shadow-md p-4 md:p-6">
                <slot />
              </div>
              
              <!-- Footer -->
              <footer class="mt-6 px-2 py-2 text-center sm:text-right text-xs text-gray-600 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600">
                <p>© ২০২৫ তানজিমে আবনায়ে ফরিদাবাদ। সর্বস্বত্ব সংরক্ষিত।</p>
              </footer>
            </main>
          </div>
        </div>
      </div>
    </template>

    <!-- Loading Overlay -->
    <div v-if="loading" class="fixed inset-0 flex flex-col items-center justify-center bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm z-50">
      <div class="relative">
        <ProgressSpinner strokeWidth="4" animationDuration=".7s" class="w-16 h-16 text-blue-600" />
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="bg-white dark:bg-gray-800 rounded-full w-6 h-6 flex items-center justify-center">
            <i class="pi pi-sync animate-spin text-blue-600 dark:text-blue-400 text-sm"></i>
          </div>
        </div>
      </div>
      <p class="mt-4 text-gray-700 dark:text-gray-300 font-medium animate-pulse">লোড হচ্ছে...</p>
    </div>

    <!-- Toast -->
    <Toast position="top-right" class="mt-16 lg:mt-20" />

    <!-- Confirm Dialog -->
    <ConfirmDialog>
      <template #container="{ message, acceptLabel, rejectLabel, accept, reject }">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-300 dark:border-gray-700 p-6 max-w-lg w-full mx-4">
          <div class="flex flex-col items-center text-center">
            <i class="pi pi-exclamation-triangle text-3xl text-yellow-500 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">নিশ্চিতকরণ</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">{{ message.message }}</p>
            <div class="flex gap-3">
              <button 
                @click="reject()" 
                class="px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded transition-colors"
              >
                {{ rejectLabel }}
              </button>
              <button 
                @click="accept()"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors"
              >
                {{ acceptLabel }}
              </button>
            </div>
          </div>
        </div>
      </template>
    </ConfirmDialog>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { useBreakpoints } from '@vueuse/core'

import Toast from 'primevue/toast'
import ConfirmDialog from 'primevue/confirmdialog'
import ProgressSpinner from 'primevue/progressspinner'
import Breadcrumb from 'primevue/breadcrumb'

import AppSidebar from '@/Components/layout/AppSidebar.vue'
import AppHeader from '@/Components/layout/AppHeader.vue'

const page = usePage()
const breakpoints = useBreakpoints({
    mobile: 768,
    tablet: 1024,
    desktop: 1200
})

const user = computed(() => page.props.auth.user)
const isUserSuspended = computed(() => {
    return user.value?.information?.status === 'suspended'
})

const sidebarVisible = ref(false)
const loading = ref(false)
const centers = ref([])
const error = ref(null)

const isMobile = computed(() => breakpoints.smaller('tablet').value)
const currentRoute = computed(() => route().current())
const showBreadcrumb = computed(() => currentRoute.value !== 'dashboard')

const breadcrumbItems = computed(() => {
    const items = [{ label: 'হোম', icon: 'pi pi-home', route: route('dashboard') }]
    const routeMap = {
        'students_registration.index': { label: 'ছাত্র নিবন্ধন', icon: 'pi pi-users' },
        'madrashaDashboard.studentData': { label: 'দস্তরবন্দি আবেদন তালিকা', icon: 'pi pi-send' },
        'profile.edit': { label: 'প্রোফাইল', icon: 'pi pi-user' },
        'others.notice': { label: 'নোটিস', icon: 'pi pi-bell' },
        'others.massaging': { label: 'মেসেজিং', icon: 'pi pi-envelope' },
    }
    const currentPageInfo = routeMap[currentRoute.value]
    if (currentPageInfo) items.push(currentPageInfo)
    return items
})

const getPageTitle = () => {
    const routeMap = {
        'dashboard': 'ড্যাশবোর্ড',
        'students_registration.index': 'ছাত্র নিবন্ধন',
        'madrashaDashboard.studentData': 'দস্তরবন্দি আবেদন তালিকা',
        'profile.edit': 'প্রোফাইল সেটিংস',
        'others.notice': 'নোটিস',
        'others.massaging': 'মেসেজিং',
    }
    return routeMap[currentRoute.value] || 'পেইজ';
}

const getCurrentDate = () => {
    const today = new Date();
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return today.toLocaleDateString('bn-BD', options);
}

const fetchCenters = async () => {
    try {
        loading.value = true
        const response = await fetch('/api/user-centers')
        if (!response.ok) throw new Error('Failed to fetch centers')
        const data = await response.json()
        centers.value = data.centers || []
        error.value = data.error || null
    } catch (err) {
        console.error('Error fetching centers:', err)
        error.value = err.message
    } finally {
        loading.value = false
    }
}

const handleResize = () => {
    sidebarVisible.value = !isMobile.value
}
watch(isMobile, (val) => { sidebarVisible.value = !val })

onMounted(() => {
    fetchCenters()
    window.addEventListener('resize', handleResize)
    handleResize()
    document.documentElement.style.scrollBehavior = 'smooth';
})
onUnmounted(() => window.removeEventListener('resize', handleResize))

const handleGlobalError = (error) => console.error('Global error:', error)
window.addEventListener('error', handleGlobalError)
window.addEventListener('unhandledrejection', (event) => handleGlobalError(event.reason))
</script>

<style>
.scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
.scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: #9ca3af; border-radius: 3px; }
.dark .scrollbar-thin::-webkit-scrollbar-thumb { background: #4b5563; }

@keyframes fadeIn { from { opacity: 0; transform: translateY(-10px);} to { opacity: 1; transform: translateY(0);} }
.animate-fadeIn { animation: fadeIn 0.5s ease-out forwards; }

@keyframes pulse { 0%,100% { opacity: 1;} 50% { opacity: 0.7;} }
.animate-pulse { animation: pulse 1.5s infinite; }
</style>
