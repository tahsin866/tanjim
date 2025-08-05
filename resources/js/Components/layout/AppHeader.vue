<template>
    <div class="fixed top-0 right-0 z-50 h-16 lg:h-20 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm border-b border-gray-200/50 dark:border-gray-700/50 shadow-lg transition-all duration-300"
         :class="isMobile ? 'left-0' : 'left-0 lg:left-72'">

        <div class="h-full flex items-center justify-between px-4 lg:px-6">
            <!-- Left Side - Mobile menu toggle -->
            <div class="flex items-center gap-4">
                <button
                    v-if="isMobile"
                    @click="toggleSidebar"
                    class="p-2 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105"
                    aria-label="Menu"
                >
                    <i class="pi pi-bars text-lg text-gray-700 dark:text-gray-300"></i>
                </button>

                <!-- Desktop sidebar toggle -->
                <button
                    v-if="!isMobile"
                    @click="toggleSidebar"
                    class="p-2 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105"
                    aria-label="Toggle Sidebar"
                >
                    <i class="pi pi-bars text-lg text-gray-700 dark:text-gray-300"></i>
                </button>

                <!-- Page Title or Breadcrumb -->
                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-gray-800 dark:text-white">
                        ড্যাশবোর্ড
                    </h1>
                </div>
            </div>

            <!-- Right Side - User menu and notifications -->
            <div class="flex items-center gap-3">
                <!-- Notifications -->
                <button class="relative p-2 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105">
                    <i class="pi pi-bell text-lg text-gray-700 dark:text-gray-300"></i>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                        3
                    </span>
                </button>

                <!-- User Menu -->
                <Menu ref="userMenu" :model="userMenuItems" :popup="true" class="user-dropdown-menu">
                    <template #item="{ item }">
                        <Link
                            v-if="item.route"
                            :href="item.route"
                            :method="item.method || 'get'"
                            :as="item.as || 'a'"
                            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 rounded-lg mx-2"
                        >
                            <span :class="item.icon" class="text-gray-500 dark:text-gray-400 mr-3"></span>
                            <span class="font-medium">{{ item.label }}</span>
                        </Link>
                        <button
                            v-else-if="!item.separator"
                            @click="item.command"
                            class="flex items-center w-full px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 text-left rounded-lg mx-2"
                        >
                            <span :class="item.icon" class="text-gray-500 dark:text-gray-400 mr-3"></span>
                            <span class="font-medium">{{ item.label }}</span>
                        </button>
                        <div v-else class="border-t border-gray-200 dark:border-gray-600 my-2 mx-2"></div>
                    </template>
                </Menu>

                <button
                    @click="toggleUserMenu"
                    class="flex items-center gap-3 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md"
                >
                    <Avatar
                        :label="getUserInitials()"
                        class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md"
                        shape="circle"
                        size="normal"
                    />
                    <div class="hidden sm:flex flex-col text-left">
                        <span class="font-semibold text-sm text-gray-800 dark:text-white leading-tight">{{ getUserDisplayName() }}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ getUserRole() }}</span>
                    </div>
                    <i class="pi pi-chevron-down ml-2 text-gray-400 dark:text-gray-500 text-xs transition-transform duration-200"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Badge from 'primevue/badge'
import Menu from 'primevue/menu'
import Avatar from 'primevue/avatar'

const props = defineProps({
    isMobile: Boolean,
    centers: Array
})

const emit = defineEmits(['toggle-sidebar'])

const page = usePage()
const user = computed(() => page.props.auth.user)

// Refs
const userMenu = ref()

// Helper methods for user display
const getUserDisplayName = () => {
    return user.value.fullNameBangla || user.value.full_name_bangla || user.value.name || 'ব্যবহারকারী'
}

const getUserRole = () => {
    return user.value.admin_Designation || 'ব্যবহারকারী'
}

const getUserInitials = () => {
    const name = getUserDisplayName()
    const words = name.split(' ')
    if (words.length >= 2) {
        return (words[0][0] + words[1][0]).toUpperCase()
    }
    return name.substring(0, 2).toUpperCase()
}

// User menu items
const userMenuItems = ref([
    {
        label: 'প্রোফাইল',
        icon: 'pi pi-user',
        route: route('profile.edit')
    },
    {
        label: 'সেটিংস',
        icon: 'pi pi-cog',
        command: () => {
            // Handle settings
        }
    },
    {
        separator: true
    },
    {
        label: 'লগ আউট',
        icon: 'pi pi-sign-out',
        route: route('logout'),
        method: 'post',
        as: 'button'
    }
])

// Methods
const toggleSidebar = () => {
    emit('toggle-sidebar')
}

const toggleUserMenu = (event) => {
    userMenu.value.toggle(event)
}
</script>
