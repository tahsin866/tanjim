<template>
    <div class="layout-topbar">
        <div class="layout-topbar-start">
            <!-- Mobile menu toggle -->
            <Button
                v-if="isMobile"
                icon="pi pi-bars"
                @click="toggleSidebar"
                class="p-button-text p-button-plain"
                aria-label="Menu"
            />
        </div>



        <div class="layout-topbar-end">
            <div class="layout-topbar-menu">
                <!-- User Menu -->
                <Menu ref="userMenu" :model="userMenuItems" :popup="true" class="user-dropdown-menu">
                    <template #item="{ item }">
                        <Link
                            v-if="item.route"
                            :href="item.route"
                            :method="item.method || 'get'"
                            :as="item.as || 'a'"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                        >
                            <span :class="item.icon" class="text-gray-500 mr-3"></span>
                            <span class="font-medium">{{ item.label }}</span>
                        </Link>
                        <button
                            v-else-if="!item.separator"
                            @click="item.command"
                            class="flex items-center w-full px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors duration-200 text-left"
                        >
                            <span :class="item.icon" class="text-gray-500 mr-3"></span>
                            <span class="font-medium">{{ item.label }}</span>
                        </button>
                        <div v-else class="border-t border-gray-200 my-1"></div>
                    </template>
                </Menu>

                <Button
                    @click="toggleUserMenu"
                    class="user-menu-btn bg-white hover:bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 shadow-sm"
                    text
                >
                    <div class="flex items-center gap-3">
                        <Avatar
                            :label="getUserInitials()"
                            class="bg-blue-500 text-white"
                            shape="circle"
                            size="normal"
                        />
                        <div class="flex flex-col text-left">
                            <span class="font-semibold text-sm text-gray-800">{{ getUserDisplayName() }}</span>
                            <span class="text-xs text-gray-500">{{ getUserRole() }}</span>
                        </div>
                        <i class="pi pi-chevron-down ml-2 text-gray-400 text-xs"></i>
                    </div>
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Button from 'primevue/button'
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

<style scoped>
.layout-topbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 50;

    border-bottom: 1px solid #e5e7eb;
    height: 4rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1rem;
}

@media (min-width: 768px) {
    .layout-topbar {
        left: 16rem;
        height: 5rem;
    }
}

.layout-topbar-start {
    display: flex;
    align-items: center;
}

.layout-topbar-end {
    display: flex;
    align-items: center;
}

.layout-topbar-menu {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.user-menu-btn {
    transition: all 0.2s ease;
}

.user-menu-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

:deep(.user-dropdown-menu) {
    min-width: 200px;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

:deep(.user-dropdown-menu .p-menu-list) {
    padding: 0.5rem 0;
}

@media (max-width: 768px) {
    .layout-topbar {
        left: 0;
    }
}
</style>
