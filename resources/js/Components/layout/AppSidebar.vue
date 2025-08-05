<template>
    <!-- Sidebar Container -->
    <div
        :class="[
            'fixed top-0 left-0 h-screen w-72 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white z-40 flex flex-col transition-all duration-300 ease-in-out shadow-2xl border-r border-gray-700/50',
            isMobile
                ? (visible ? 'translate-x-0' : '-translate-x-full')
                : (visible ? 'translate-x-0' : '-translate-x-full')
        ]"
    >
        <!-- Logo Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 border-b border-gray-700/50 flex-shrink-0 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-transparent"></div>
            <div class="relative flex items-center gap-3 px-6 py-5">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <i class="pi pi-home text-xl text-white"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white leading-tight">তানজিমে আবনায়ে</span>
                    <span class="text-sm text-blue-100 font-medium">ফরিদাবাদ</span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-4 space-y-2">
            <!-- Show message for suspended users -->
            <div v-if="isUserSuspended" class="px-4 py-6 text-center">
                <div class="bg-gradient-to-r from-red-500/20 to-red-600/20 border border-red-500/30 text-red-200 px-4 py-6 rounded-xl backdrop-blur-sm">
                    <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="pi pi-exclamation-triangle text-2xl text-red-300"></i>
                    </div>
                    <p class="text-sm font-semibold mb-2">অ্যাকাউন্ট সাসপেন্ড</p>
                    <p class="text-xs opacity-90">প্রশাসনের সাথে যোগাযোগ করুন</p>
                </div>
            </div>

            <!-- Regular menu for active users -->
            <nav v-else class="space-y-1">
                <template v-for="item in filteredMenuItems" :key="item.label">
                    <!-- Single menu item -->
                    <Link
                        v-if="item.route && !item.items"
                        :href="item.route"
                        :class="[
                            'group flex items-center w-full px-4 py-3 rounded-xl font-medium transition-all duration-200 relative overflow-hidden',
                            isActiveRoute(item.routeName)
                                ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg transform scale-105'
                                : 'text-gray-300 hover:text-white hover:bg-gray-700/50 hover:scale-105'
                        ]"
                        @click="onMenuItemClick"
                    >
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/0 to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        <div :class="[
                            'w-10 h-10 rounded-lg flex items-center justify-center mr-3 transition-all duration-200',
                            isActiveRoute(item.routeName)
                                ? 'bg-white/20 shadow-md'
                                : 'bg-gray-700/50 group-hover:bg-gray-600/50'
                        ]">
                            <i :class="item.icon" class="text-lg"></i>
                        </div>
                        <span class="flex-1 font-medium">{{ item.label }}</span>
                        <Badge
                            v-if="item.badge"
                            :value="item.badge"
                            severity="danger"
                            class="ml-2"
                        />
                    </Link>

                    <!-- Menu item with submenu -->
                    <div v-else-if="item.items" class="space-y-1">
                        <button
                            @click="item.expanded = !item.expanded"
                            class="group flex items-center w-full px-4 py-3 rounded-xl font-medium transition-all duration-200 text-gray-300 hover:text-white hover:bg-gray-700/50 hover:scale-105 relative overflow-hidden"
                        >
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/0 to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 transition-all duration-200 bg-gray-700/50 group-hover:bg-gray-600/50">
                                <i :class="item.icon" class="text-lg"></i>
                            </div>
                            <span class="flex-1 font-medium">{{ item.label }}</span>
                            <i :class="[
                                'pi pi-chevron-down transition-transform duration-200 text-sm',
                                item.expanded ? 'rotate-180' : ''
                            ]"></i>
                        </button>

                        <!-- Submenu -->
                        <div v-show="item.expanded" class="ml-6 space-y-1 animate-fadeIn">
                            <Link
                                v-for="subItem in item.items"
                                :key="subItem.label"
                                :href="subItem.route"
                                :class="[
                                    'group flex items-center w-full px-4 py-2.5 rounded-lg font-medium transition-all duration-200 relative overflow-hidden',
                                    isActiveRoute(subItem.routeName)
                                        ? 'bg-gradient-to-r from-blue-500/30 to-indigo-600/30 text-white border-l-4 border-blue-400'
                                        : 'text-gray-400 hover:text-white hover:bg-gray-700/30 border-l-4 border-transparent hover:border-gray-600'
                                ]"
                                @click="onMenuItemClick"
                            >
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all duration-200">
                                    <i :class="subItem.icon" class="text-sm"></i>
                                </div>
                                <span class="flex-1 text-sm">{{ subItem.label }}</span>
                            </Link>
                        </div>
                    </div>
                </template>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="flex-shrink-0 px-6 py-4 border-t border-gray-700/50 bg-gradient-to-r from-gray-800/50 to-gray-900/50">
            <div class="text-center text-gray-400 text-sm space-y-1">
                <p class="font-medium">© ২০২৫ আবনায়ে ফরিদাবাদ</p>
                <p class="text-xs opacity-75">সংস্করণ ২.০</p>
            </div>
        </div>
    </div>

    <!-- Mobile overlay -->
    <div
        v-if="visible && isMobile"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 transition-opacity duration-300"
        @click="$emit('hide')"
    ></div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Badge from 'primevue/badge'

const props = defineProps({
    visible: Boolean,
    isMobile: Boolean
})

const emit = defineEmits(['hide'])

const page = usePage()

// Check if user is suspended
const isUserSuspended = computed(() => {
    return page.props.auth?.user?.status === 'suspended'
})

// Current route tracking
const currentRoute = computed(() => route().current())

const isActiveRoute = (routeName) => {
    if (!routeName) return false
    return currentRoute.value === routeName || currentRoute.value.startsWith(routeName.split('.')[0])
}

// Menu items configuration with expansion state
const menuItems = ref([
    {
        label: 'ড্যাশবোর্ড',
        icon: 'pi pi-home',
        route: route('dashboard'),
        routeName: 'dashboard'
    },
    {
        label: 'রেজিস্ট্রেশন সংক্রান্ত',
        icon: 'pi pi-file-edit',
        expanded: false,
        items: [
            {
                label: 'দস্তরবন্দী রেজিস্ট্রেশন',
                icon: 'pi pi-send',
                route: route('madrashaDashboard.studentData'),
                routeName: 'madrashaDashboard.studentData'
            },
        ]
    },
    {
        label: 'সমস্ত ছাত্রদের তথ্য',
        icon: 'pi pi-users',
        expanded: false,
        items: [
            {
                label: 'বর্ষভিত্তিক ছাত্রদের তথ্য',
                icon: 'pi pi-calendar',
                route: route('madrashaDashboard.studentData'),
                routeName: 'madrashaDashboard.studentData'
            },
        ]
    },
    {
        label: 'প্রোফাইল',
        icon: 'pi pi-user',
        route: route('profile.edit'),
        routeName: 'profile.edit'
    }
])

// Filter menu items based on visibility and user status
const filteredMenuItems = computed(() => {
    if (isUserSuspended.value) {
        return []
    }
    return menuItems.value.filter(item => {
        if (item.visible === false) return false
        if (item.items) {
            item.items = item.items.filter(subItem => subItem.visible !== false)
        }
        return true
    })
})

const onMenuItemClick = () => {
    if (props.isMobile) {
        emit('hide')
    }
}
</script>
