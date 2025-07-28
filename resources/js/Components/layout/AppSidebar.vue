<template>
    <div
        :class="[
            'layout-sidebar',
            { 'layout-sidebar-mobile-active': visible }
        ]"
    >
        <!-- Logo Header -->
        <div class="layout-sidebar-header">
            <div class="flex items-center gap-2 px-4 py-3">
                <i class="pi pi-home text-2xl text-white"></i>
                <span class="text-lg font-bold text-white">তানজিমে আবনায়ে ফরিদাবাদ</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="layout-sidebar-content">
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
                class="sidebar-menu"
                @item-click="onMenuItemClick"
            >
                <template #item="{ item }">
                    <Link
                        v-if="item.route"
                        :href="item.route"
                        :class="[
                            'p-menuitem-link',
                            { 'active-menu-item': isActiveRoute(item.routeName) }
                        ]"
                    >
                        <span :class="item.icon"></span>
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
                            'p-menuitem-link w-full text-left',
                            { 'active-menu-item': isActiveRoute(item.routeName) }
                        ]"
                    >
                        <span :class="item.icon"></span>
                        <span class="ml-3">{{ item.label }}</span>
                        <i v-if="item.items" class="pi pi-chevron-down ml-auto"></i>
                    </button>
                </template>
            </PanelMenu>
        </div>

        <!-- Sidebar Footer -->
        <div class="layout-sidebar-footer">
            <div class="px-4 py-3 border-t border-gray-600">
                <div class="text-center text-gray-300 text-sm">
                    <p>© ২০২৫ WEMS</p>
                    <p>সংস্করণ ২.০</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile overlay -->
    <div
        v-if="visible && isMobile"
        class="layout-sidebar-mask"
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
            // {
            //     label: 'মারকায পরিবর্তন',
            //     icon: 'pi pi-refresh',
            //     // route: route('Markaz.markaz_change_table'),
            //     // routeName: 'Markaz.markaz_change_table',
            //     visible: !page.props.auth.user.markaz_serial
            // },
            // {
            //     label: 'বিষয় সেটাপ',
            //     icon: 'pi pi-cog',
            //     // route: route('Markaz.subjectSettings_for_madrasha'),
            //     // routeName: 'Markaz.subjectSettings_for_madrasha'
            // },
            // {
            //     label: 'মারহালা পরিবর্তন',
            //     icon: 'pi pi-arrows-h',
            //     // route: route('Markaz.marhala_change_table'),
            //     // routeName: 'Markaz.marhala_change_table'
            // },

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
    // If user is suspended, return empty array (no menu items)
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

<style scoped>
.layout-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh; /* Changed from 100% to 100vh */
    width: 16rem; /* w-64 */
    background-color: #1f2937; /* bg-gray-800 */
    color: #fff; /* text-white */
    z-index: 40;
    transform: translateX(0);
    transition-property: transform;
    transition-duration: 300ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); /* ease-in-out */
    display: flex;
    flex-direction: column;
    margin: 0;
    padding: 0;
}

.layout-sidebar-mobile-active {
    transform: translateX(0);
}

@media (max-width: 1024px) {
    .layout-sidebar {
        transform: translateX(-100%);
    }
}

@media (min-width: 1024px) {
    .layout-sidebar {
        transform: translateX(0);
    }
}

.layout-sidebar-header {
    background-color: #111827; /* bg-gray-900 */
    border-bottom: 1px solid #374151; /* border-b border-gray-700 */
    flex-shrink: 0;
}

.layout-sidebar-content {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: #4B5563 #374151;
}

.layout-sidebar-content::-webkit-scrollbar {
    width: 6px;
}

.layout-sidebar-content::-webkit-scrollbar-track {
    background: #374151;
}

.layout-sidebar-content::-webkit-scrollbar-thumb {
    background: #4B5563;
    border-radius: 3px;
}

.layout-sidebar-footer {
    flex-shrink: 0;
}

.layout-sidebar-mask {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 30;
}

/* PrimeVue Menu Customization */
:deep(.p-panelmenu) {
    border: 0;
    background-color: transparent;
}

:deep(.p-panelmenu .p-panelmenu-panel) {
    border: 0;
    background-color: transparent;
}

:deep(.p-panelmenu .p-panelmenu-header) {
    border: 0;
    background-color: transparent;
}

:deep(.p-panelmenu .p-panelmenu-header-link) {
    background-color: transparent;
    border: 0;
    color: #fff;
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    transition-property: background-color;
    transition-duration: 200ms;
}
:deep(.p-panelmenu .p-panelmenu-header-link:hover) {
    background-color: #374151; /* bg-gray-700 */
}

:deep(.p-panelmenu .p-panelmenu-content) {
    border: 0;
    background-color: #374151; /* bg-gray-700 */
}

:deep(.p-menuitem-link) {
    color: #fff;
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    border: 0;
    background-color: transparent;
    transition-property: background-color;
    transition-duration: 200ms;
    display: flex;
    align-items: center;
    width: 100%;
    text-align: left;
}
:deep(.p-menuitem-link:hover) {
    background-color: #4b5563; /* bg-gray-600 */
}

:deep(.active-menu-item) {
    background-color: #111827; /* bg-gray-900 */
    border-left: 4px solid #3b82f6; /* border-blue-500 */
    font-weight: 500;
}

:deep(.p-panelmenu .p-menuitem-text) {
    color: #fff;
}

:deep(.p-panelmenu .p-menuitem-icon) {
    color: #fff;
    margin-right: 0.75rem;
}

:deep(.p-panelmenu .p-panelmenu-header-icon) {
    color: #fff;
}

:deep(.p-submenu-list) {
    background-color: #374151; /* bg-gray-700 */
}

:deep(.p-menuitem) {
    border: 0;
}
</style>
