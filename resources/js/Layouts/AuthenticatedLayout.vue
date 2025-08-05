<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 flex flex-col font-['SolaimanLipi',sans-serif]">

        <!-- Suspended User Message -->
        <div v-if="isUserSuspended" class="fixed inset-0 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900 dark:to-gray-900 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 p-12 rounded-3xl shadow-2xl max-w-md m-8 border border-red-200 dark:border-red-700">
                <div class="text-center">
                    <div class="w-20 h-20 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="pi pi-ban text-4xl text-red-500 dark:text-red-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-3">অ্যাকাউন্ট স্থগিত</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">আপনার অ্যাকাউন্ট সাময়িকভাবে স্থগিত করা হয়েছে।</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">আরো তথ্যের জন্য প্রশাসনের সাথে যোগাযোগ করুন।</p>
                    <div class="mt-6">
                        <Link :href="route('logout')" method="post" as="button"
                              class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-8 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            লগ আউট
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Normal Layout (Hidden for suspended users) -->
        <template v-else>
            <!-- Sidebar Component -->
            <AppSidebar
                :visible="sidebarVisible"
                :is-mobile="isMobile"
                @hide="sidebarVisible = false"
            />

            <!-- Main Layout Container -->
            <div class="flex-1 flex flex-col lg:ml-72">
                <!-- Header Component -->
                <AppHeader
                    :is-mobile="isMobile"
                    :centers="centers"
                    @toggle-sidebar="sidebarVisible = !sidebarVisible"
                />

                <!-- Content Area -->
                <div class="flex-1 flex flex-col pt-16 md:pt-20 lg:pt-24">
                    <main class="flex-1 p-4 md:p-6 lg:p-8 max-w-full">
                        <!-- Breadcrumb -->
                        <div v-if="showBreadcrumb" class="mb-6">
                            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200/50 dark:border-gray-700/50 p-4">
                                <Breadcrumb :model="breadcrumbItems" class="text-sm">
                                    <template #item="{ item }">
                                        <Link
                                            v-if="item.route"
                                            :href="item.route"
                                            class="text-blue-600 dark:text-blue-400 flex items-center gap-2 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200 font-medium"
                                        >
                                            <i v-if="item.icon" :class="item.icon" class="text-sm"></i>
                                            <span>{{ item.label }}</span>
                                        </Link>
                                        <span v-else class="flex items-center gap-2 text-gray-700 dark:text-gray-300 font-medium">
                                            <i v-if="item.icon" :class="item.icon" class="text-sm"></i>
                                            <span>{{ item.label }}</span>
                                        </span>
                                    </template>
                                </Breadcrumb>
                            </div>
                        </div>

                        <!-- Page Content -->
                        <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-6 md:p-8 min-h-[calc(100vh-200px)]">
                            <slot />
                        </div>
                    </main>
                </div>
            </div>
        </template>

        <!-- Loading Overlay -->
        <div v-if="loading" class="fixed inset-0 flex flex-col items-center justify-center bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm z-50">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700">
                <ProgressSpinner class="w-12 h-12 text-blue-500" />
                <p class="mt-4 text-gray-600 dark:text-gray-300 font-medium">লোড হচ্ছে...</p>
            </div>
        </div>

        <!-- Global Toast -->
        <Toast position="top-right" />

        <!-- Confirm Dialog -->
        <ConfirmDialog />
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { useBreakpoints } from '@vueuse/core'

// PrimeVue Components
import Toast from 'primevue/toast'
import ConfirmDialog from 'primevue/confirmdialog'
import ProgressSpinner from 'primevue/progressspinner'
import Breadcrumb from 'primevue/breadcrumb'

// Custom Components
import AppSidebar from '@/Components/layout/AppSidebar.vue'
import AppHeader from '@/Components/layout/AppHeader.vue'

// Composables
const page = usePage()
const breakpoints = useBreakpoints({
    mobile: 768,
    tablet: 1024,
    desktop: 1200
})

// User status check
const user = computed(() => page.props.auth.user)
const isUserSuspended = computed(() => {
    return user.value?.information?.status === 'suspended'
})

// Reactive state
const sidebarVisible = ref(false)
const loading = ref(false)
const centers = ref([])
const error = ref(null)

// Computed properties
const isMobile = computed(() => breakpoints.smaller('tablet').value)
const currentRoute = computed(() => route().current())

// Breadcrumb functionality
const showBreadcrumb = computed(() => currentRoute.value !== 'dashboard')

const breadcrumbItems = computed(() => {
    const items = [
        { label: 'হোম', icon: 'pi pi-home', route: route('dashboard') }
    ]

    const routeMap = {
        'students_registration.index': { label: 'ছাত্র নিবন্ধন', icon: 'pi pi-users' },
        'madrashaDashboard.studentData': { label: 'দস্তরবন্দি আবেদন তালিকা', icon: 'pi pi-send' },
        'profile.edit': { label: 'প্রোফাইল', icon: 'pi pi-user' },
        'others.notice': { label: 'নোটিস', icon: 'pi pi-bell' },
        'others.massaging': { label: 'মেসেজিং', icon: 'pi pi-envelope' },
    }

    const currentPageInfo = routeMap[currentRoute.value]
    if (currentPageInfo) {
        items.push(currentPageInfo)
    }

    return items
})

// Methods
const fetchCenters = async () => {
    try {
        loading.value = true
        const response = await fetch('/api/user-centers')
        if (!response.ok) {
            throw new Error('Failed to fetch centers')
        }
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

// Responsive sidebar behavior
const handleResize = () => {
    if (!isMobile.value) {
        sidebarVisible.value = false
    }
}

watch(isMobile, (newValue) => {
    if (!newValue) {
        sidebarVisible.value = false
    }
})

onMounted(() => {
    fetchCenters()
    window.addEventListener('resize', handleResize)
    // Desktop এ সাইডবার বন্ধ রাখো
    sidebarVisible.value = false
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
})

const handleGlobalError = (error) => {
    console.error('Global error:', error)
}

window.addEventListener('error', handleGlobalError)
window.addEventListener('unhandledrejection', (event) => {
    handleGlobalError(event.reason)
})
</script>
