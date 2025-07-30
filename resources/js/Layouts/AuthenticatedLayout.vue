<template>
    <div class="min-h-screen bg-gray-50 flex flex-col font-['Merriweather','SolaimanLipi',sans-serif]">

        <!-- Suspended User Message -->
        <div v-if="isUserSuspended" class="fixed inset-0 bg-gray-50 flex items-center justify-center z-50">
            <div class="bg-white p-12 rounded-2xl shadow-2xl max-w-md m-8">
                <div class="text-center">
                    <i class="pi pi-ban text-6xl text-red-500 mb-4"></i>
                    <h2 class="text-2xl font-bold text-red-600 mb-2">অ্যাকাউন্ট স্থগিত</h2>
                    <p class="text-gray-600 mb-4">আপনার অ্যাকাউন্ট সাময়িকভাবে স্থগিত করা হয়েছে।</p>
                    <p class="text-sm text-gray-500">আরো তথ্যের জন্য প্রশাসনের সাথে যোগাযোগ করুন।</p>
                    <div class="mt-6">
                        <Link :href="route('logout')" method="post" as="button"
                              class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md transition-colors">
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
            <div class="flex-1 flex flex-col lg:ml-64">
                <!-- Header Component -->
                <AppHeader
                    :is-mobile="isMobile"
                    :centers="centers"
                    @toggle-sidebar="sidebarVisible = !sidebarVisible"
                />

                <!-- Content Area -->
                <div class="flex-1 flex flex-col pt-16 md:pt-20">
                    <main class="flex-1 p-2 md:p-6 max-w-full">
                        <!-- Breadcrumb -->
                        <div v-if="showBreadcrumb" class="mb-4">
                            <Breadcrumb :model="breadcrumbItems">
                                <template #item="{ item }">
                                    <Link
                                        v-if="item.route"
                                        :href="item.route"
                                        class="text-blue-600 flex items-center gap-2 hover:underline"
                                    >
                                        <i v-if="item.icon" :class="item.icon"></i>
                                        <span>{{ item.label }}</span>
                                    </Link>
                                    <span v-else class="flex items-center gap-2">
                                        <i v-if="item.icon" :class="item.icon"></i>
                                        <span>{{ item.label }}</span>
                                    </span>
                                </template>
                            </Breadcrumb>
                        </div>

                        <!-- Page Content -->
                        <div class="bg-white rounded-lg shadow p-3 md:p-6">
                            <slot />
                        </div>
                    </main>
                </div>
            </div>
        </template>

        <!-- Loading Overlay -->
        <div v-if="loading" class="fixed inset-0 flex flex-col items-center justify-center bg-white/80 z-50">
            <ProgressSpinner />
            <p class="mt-4 text-gray-600">লোড হচ্ছে...</p>
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
    if (isMobile.value) {
        sidebarVisible.value = true
    } else {
        sidebarVisible.value = false
    }
}

watch(isMobile, (newValue) => {
    if (newValue) {
        sidebarVisible.value = true
    } else {
        sidebarVisible.value = false
    }
})

onMounted(() => {
    fetchCenters()
    window.addEventListener('resize', handleResize)
    if (isMobile.value) {
        sidebarVisible.value = true
    } else {
        sidebarVisible.value = false
    }
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
