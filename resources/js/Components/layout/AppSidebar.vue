<template>
    <div
        :class="[
            'fixed top-0 left-0 h-screen w-64 bg-gray-800 text-white z-40 flex flex-col transition-transform duration-300 ease-in-out',
            isMobile
                ? (visible ? 'translate-x-0' : '-translate-x-full')
                : 'translate-x-0'
        ]"
    >
        <!-- Logo Header -->
        <div class="bg-gray-900 border-b border-gray-700 flex-shrink-0">
            <div class="flex items-center gap-2 px-4 py-3">
                <i class="pi pi-home text-2xl text-white"></i>
                <span class="text-lg font-bold text-white">তানজিমে আবনায়ে ফরিদাবাদ</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden">
            <!-- Show message for suspended users -->
            <div v-if="isUserSuspended" class="px-4 py-6 text-center">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <i class="pi pi-exclamation-triangle text-xl mb-2"></i>
                    <p class="text-sm font-medium">আপনার অ্যাকাউন্ট সাসপেন্ড করা হয়েছে</p>
                    <p class="text-xs mt-1">আরও তথ্যের জন্য আবনা প্রশাসনের সাথে যোগাযোগ করুন</p>
                </div>
            </div>

            <!-- Regular menu for active users -->
            <PanelMenu
                v-else
                :model="filteredMenuItems"
                class="bg-transparent border-0 custom-sidebar-menu"
                @item-click="onMenuItemClick"
            >
                <template #item="{ item }">
                    <Link
                        v-if="item.route"
                        :href="item.route"
                        :class="[
                            'flex items-center w-full text-left px-4 py-2 rounded-lg transition-colors',
                            isActiveRoute(item.routeName)
                                ? 'bg-gray-700 border-l-4 border-blue-500 font-semibold shadow-sm'
                                : 'hover:bg-gray-700 '
                        ]"
                        style="background: none;"
                    >
                        <span :class="item.icon + ' text-lg'" />
                        <span class="ml-3">{{ item.label }}</span>
                        <Badge
                            v-if="item.badge"
                            :value="item.badge"
                            severity="danger"
                            class="ml-auto"
                        />
                    </Link>
                    <button
                        v-else
                        @click="item.command"
                        :class="[
                            'flex items-center w-full text-left px-4 py-2 rounded-lg transition-colors',
                            isActiveRoute(item.routeName)
                                ? 'bg-gray-700 border-l-4 border-blue-500 font-semibold shadow-sm'
                                : 'hover:bg-gray-700 h'
                        ]"
                        style="background: none;"
                    >
                        <span :class="item.icon + ' text-lg'" />
                        <span class="ml-3">{{ item.label }}</span>
                        <i v-if="item.items" class="pi pi-chevron-down ml-auto"></i>
                    </button>
                </template>
    </PanelMenu>
</div>

        <!-- Sidebar Footer -->
        <div class="flex-shrink-0 px-4 py-3 border-t border-gray-600">
            <div class="text-center text-gray-300 text-sm">
                <p>© ২০২৫ আবনায়ে ফরিদাবাদ</p>
                <p>সংস্করণ ২.০</p>
            </div>
        </div>
    </div>

    <!-- Mobile overlay -->
    <div
        v-if="visible && isMobile"
        class="fixed inset-0 bg-black bg-opacity-50 z-30"
        @click="$emit('hide')"
    ></div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import PanelMenu from 'primevue/panelmenu'
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

// Menu items configuration
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
        icon: 'pi pi-file-edit',
        items: [
            {
                label: 'বর্ষভিত্তিক ছাত্রদের তথ্য',
                icon: 'pi pi-send',
                route: route('madrashaDashboard.studentData'),
                routeName: 'madrashaDashboard.studentData'
            },
        ]
    },
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


<style>
/* Custom sidebar menu for clean dark look */
.custom-sidebar-menu .p-panelmenu .p-panelmenu-panel {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
}
.custom-sidebar-menu .p-panelmenu .p-panelmenu-header {
    background: transparent !important;
    border: none !important;
    color: #d1d5db;
    font-weight: 500;
    padding: 0;
}
.custom-sidebar-menu .p-panelmenu .p-panelmenu-content {
    background: transparent !important;
    border: none !important;
    padding: 0;
}
.custom-sidebar-menu .p-panelmenu .p-menuitem-link {
    background: none !important;
    color: #d1d5db;
    border-radius: 0.5rem;
    margin: 2px 0;
    font-size: 1rem;
    transition: background 0.2s, color 0.2s;
}
.custom-sidebar-menu .p-panelmenu .p-menuitem-link:hover {
    background: #374151 !important;
    color: #fff !important;
}
.custom-sidebar-menu .p-panelmenu .p-menuitem-link.p-highlight {
    background: #374151 !important;
    color: #fff !important;
    font-weight: 600;
}
</style>
