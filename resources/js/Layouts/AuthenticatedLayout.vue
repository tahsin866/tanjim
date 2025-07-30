<template>
    <div class="layout-wrapper" style="font-family: 'Merriweather','SolaimanLipi',sans-serif; margin: 0; padding: 0;">

        <!-- Suspended User Message -->
        <div v-if="isUserSuspended" class="suspended-user-overlay">
            <div class="suspended-message">
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
            <div class="layout-main">
                <!-- Header Component -->
                <AppHeader
                    :is-mobile="isMobile"
                    :centers="centers"
                    @toggle-sidebar="sidebarVisible = !sidebarVisible"
                />

                <!-- Content Area -->
                <div class="layout-content">
                    <main class="main-content">
                        <!-- Breadcrumb -->
                        <div v-if="showBreadcrumb" class="breadcrumb-container">
                            <Breadcrumb :model="breadcrumbItems" class="mb-4">
                                <template #item="{ item }">
                                    <Link
                                        v-if="item.route"
                                        :href="item.route"
                                        class="breadcrumb-link"
                                    >
                                        <i v-if="item.icon" :class="item.icon"></i>
                                        <span>{{ item.label }}</span>
                                    </Link>
                                    <span v-else class="breadcrumb-item">
                                        <i v-if="item.icon" :class="item.icon"></i>
                                        <span>{{ item.label }}</span>
                                    </span>
                                </template>
                            </Breadcrumb>
                        </div>

                        <!-- Page Content -->
                        <div class="page-content">
                            <slot />
                        </div>
                    </main>
                </div>

                <!-- Footer Component -->

            </div>
        </template>

        <!-- Loading Overlay -->
        <div v-if="loading" class="loading-overlay">
            <ProgressSpinner />
            <p class="loading-text">লোড হচ্ছে...</p>
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
    // Check if user has information and if status is suspended
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
const showBreadcrumb = computed(() => {
    // Don't show breadcrumb on dashboard
    return currentRoute.value !== 'dashboard'
})

const breadcrumbItems = computed(() => {
    const items = [
        { label: 'হোম', icon: 'pi pi-home', route: route('dashboard') }
    ]

    // Add current page based on route
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

const handleResize = () => {
    if (!isMobile.value) {
        sidebarVisible.value = false
    }
}

// Watchers
watch(isMobile, (newValue) => {
    if (!newValue) {
        sidebarVisible.value = false
    }
})

// Lifecycle
onMounted(() => {
    fetchCenters()
    window.addEventListener('resize', handleResize)
    // Show sidebar by default on desktop
    if (!isMobile.value) {
        sidebarVisible.value = false
    }
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
})

// Global error handling
const handleGlobalError = (error) => {
    console.error('Global error:', error)
    // You can add toast notification here
}

// Provide global error handler
window.addEventListener('error', handleGlobalError)
window.addEventListener('unhandledrejection', (event) => {
    handleGlobalError(event.reason)
})
</script>

<style scoped>
/* Global body reset for this layout */
:global(body) {
    margin: 0 !important;
    padding: 0 !important;
}

.layout-wrapper {
    min-height: 100vh;
    background-color: #f9fafb;
    display: flex;
    flex-direction: column;
    margin: 0;
    padding: 0;
}

.suspended-user-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #f9fafb;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.suspended-message {
    background: white;
    padding: 3rem;
    border-radius: 1rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    max-width: 500px;
    margin: 2rem;
}

.layout-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    margin-left: 0;
}

@media (min-width: 1024px) {
    .layout-main {
        margin-left: 256px; /* 64 * 4 = 256px for w-64 sidebar */
    }
}

.layout-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding-top: 4rem; /* Header height on mobile */
}

@media (min-width: 768px) {
    .layout-content {
        padding-top: 5rem; /* Header height on desktop */
    }
}

.main-content {
    flex: 1;
    padding: 1rem;
    max-width: 100%;
}

@media (min-width: 768px) {
    .main-content {
        padding: 1.5rem;
    }
}

.breadcrumb-container {
    margin-bottom: 1rem;
}

.breadcrumb-link {
    color: #2563eb;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-link:hover {
    text-decoration: underline;
}

.breadcrumb-separator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-container {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding: 1rem;
}

@media (min-width: 768px) {
    .card-container {
        padding: 1.5rem;
    }
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

.modal-title {
    color: white;
    margin-top: 1rem;
    font-size: 1.125rem;
}

/* Custom scrollbar */
* {
    scrollbar-width: thin;
    scrollbar-color: #CBD5E0 #F7FAFC;
}

*::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

*::-webkit-scrollbar-track {
    background: #F7FAFC;
}

*::-webkit-scrollbar-thumb {
    background: #CBD5E0;
    border-radius: 3px;
}

*::-webkit-scrollbar-thumb:hover {
    background: #A0AEC0;
}

/* Responsive adjustments */
@media (max-width: 767px) {
    .main-content {
        padding: 0.5rem;
    }

    .page-content {
        padding: 0.75rem;
    }
}

/* Animation classes */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateX(-100%);
}

/* PrimeVue component customizations */
:deep(.p-toast) {
    z-index: 9999;
}

:deep(.p-confirm-dialog) {
    z-index: 9999;
}

:deep(.p-breadcrumb) {
    background: transparent;
    border: 0;
    padding: 0;
}

:deep(.p-breadcrumb ul) {
    background: transparent;
}

:deep(.p-breadcrumb .p-breadcrumb-item) {
    background: transparent;
}

:deep(.p-progressspinner) {
    width: 3rem;
    height: 3rem;
}
</style>
