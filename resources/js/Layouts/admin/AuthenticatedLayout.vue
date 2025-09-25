<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import Dropdown from '@/Components/admin/Dropdown.vue';
import DropdownLink from '@/Components/admin/DropdownLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';

// Sidebar state
const showSidebar = ref(false);
const page = usePage();

// Dropdown states
const dropdownOpen = ref({
    takmil: false,
    Fazilat: false,
    orders: false,
    sanawia: false,
    mutawassita: false,
    ibtedaia: false,
    HifzulQuran: false,
    Qirat: false,
    nigran: false,
    mumtahin: false,
    zone: false,
    presentaion: false,
    result: false,
    bill: false,
    admin_management: false,
    document_management: false,
    application_management: false,
    grant_management: false,
});

// Notification & message states
const showNotifications = ref(false);
const showMessages = ref(false);

// Toggle sidebar for mobile
const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

// Notification handlers
const openNotifications = () => {
    showNotifications.value = !showNotifications.value;
    showMessages.value = false;
};

const openMessages = () => {
    showMessages.value = !showMessages.value;
    showNotifications.value = false;
};

const mobileMenuOpen = ref(false)
const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value
}

const selectedItem = ref('');
const setSelected = (item) => {
    selectedItem.value = item;
}

// Ensure dropdowns show after login if admin object is present
onMounted(() => {
    if (page.props.auth && page.props.auth.admin) {
        selectedItem.value = 'admin_dashboard';
    }
});

// Permission checking helper
const hasPermission = (permission) => {
    const admin = page.props.auth?.admin;
    if (admin?.role === 'super_admin') {
        return true;
    }
    let permissions = admin?.permissions;
    if (typeof permissions === 'string') {
        try {
            permissions = JSON.parse(permissions);
        } catch (e) {
            permissions = [];
        }
    }
    let hasAccess = false;
    if (Array.isArray(permissions)) {
        hasAccess = permissions.includes(permission);
    } else if (permissions && typeof permissions === 'object') {
        hasAccess = permissions[permission] === true;
    }
    return hasAccess;
}

// Check if admin has any permission from a list
const hasAnyPermission = (permissions) => {
    return permissions.some(permission => hasPermission(permission));
}

// Check module access (basic access to a module)
const hasModuleAccess = (module) => {
    const admin = page.props.auth?.admin;
    if (admin?.role === 'super_admin') {
        return true;
    }
    const modulePermissions = {
        'messaging': ['messaging_access'],
        'notice': ['notice_access'],
        'document_management': ['document_management_access'],
        'application_management': ['application_management_access'],
        'grant_management': ['grant_management_access'],
        'product': ['product_access'],
    };
    if (modulePermissions[module]) {
        return hasAnyPermission(modulePermissions[module]);
    }
    return false;
}

// Axios request interceptor to add Authorization header
axios.interceptors.request.use(config => {
  const token = localStorage.getItem('admin_token');
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});
</script>

<template>
    <div style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;" class="flex bg-gray-100 dark:bg-gray-900 min-h-screen">
        <!-- Sidebar -->
        <aside
            :class="[
                'fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 ease-in-out bg-gray-800 text-white lg:translate-x-0',
                showSidebar ? 'translate-x-0' : '-translate-x-full'
            ]"
        >
            <!-- Header -->
            <div class="flex h-16 justify-center text-lg text-white font-semibold items-center bg-gray-900">
                <div class="flex gap-2 items-center">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L3 9V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V9L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    তানজিমে আবনা মেনেজমেন্ট
                </div>
            </div>
            <nav style="font-family: 'Merriweather','SolaimanLipi',sans-serif;" class="max-h-[calc(100vh-4rem)] mt-4 overflow-y-auto custom-scrollbar space-y-2">
                <Link v-if="$page.props.auth" :href="route('admin.admin_Dashboard')" class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2">
                    <i class="h-6 text-sm w-6 fa-mosque fas"></i>
                    ড্যাশবোর্ড
                </Link>

                <!-- Admin User Management - Only for Super Admin -->
                <div v-if="$page.props.auth && $page.props.auth.admin && ($page.props.auth.admin.role === 'super_admin' || $page.props.auth.admin.designation == 1)">
                    <button @click="dropdownOpen.admin_management = !dropdownOpen.admin_management"
                        class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
                        <div class="flex gap-2 items-center">
                            <i class="h-6 text-sm w-6 fa-users fas"></i>
                            এডমিন ব্যবস্থাপনা
                        </div>
                        <i :class="{'rotate-180': dropdownOpen.admin_management}" class="fa-chevron-down fa-xs fas tex-sm transition-transform"></i>
                    </button>
                    <div v-if="dropdownOpen.admin_management" class="pl-6 bg-gray-900">
                        <Link
                            :href="route('admin.users.index')"
                            @click="setSelected('admin_users_list')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'admin_users_list'}">
                            <i class="h-4 w-4 fa-list fas"></i>
                            এডমিন ইউজার তালিকা
                        </Link>
                        <Link
                            :href="route('admin.users.create')"
                            @click="setSelected('create_admin_user')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'create_admin_user'}">
                            <i class="h-4 w-4 fa-plus fas"></i>
                            নতুন এডমিন তৈরি করুন
                        </Link>
                    </div>
                </div>

                <!-- Product Management Module/Menu (with icon) -->
                <!-- <div v-if="hasModuleAccess('product')">
                    <button @click="dropdownOpen.product = !dropdownOpen.product"
                        class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
                        <div class="flex gap-2 items-center">
                            <i class="h-6 text-sm w-6 fa-boxes-stacked fas"></i>
                            পণ্য ব্যবস্থাপনা
                        </div>
                        <i :class="{'rotate-180': dropdownOpen.product}" class="fa-chevron-down fa-xs fas tex-sm transition-transform"></i>
                    </button>
                    <div v-if="dropdownOpen.product" class="pl-6 bg-gray-900">
                        <Link
                            v-if="hasPermission('product_list') || hasModuleAccess('product')"
                            :href="route('admin.products.index')"
                            @click="setSelected('product_list')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'product_list'}">
                            <i class="h-4 w-4 fa-list fas"></i>
                            পণ্য তালিকা
                        </Link>
                        <Link
                            v-if="hasPermission('product_create') || hasModuleAccess('product')"
                            :href="route('admin.products.create')"
                            @click="setSelected('product_create')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'product_create'}">
                            <i class="h-4 w-4 fa-plus fas"></i>
                            নতুন পণ্য যোগ করুন
                        </Link>
                        <Link
                            v-if="hasPermission('product_category') || hasModuleAccess('product')"
                            :href="route('admin.product.categories')"
                            @click="setSelected('product_category')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'product_category'}">
                            <i class="h-4 w-4 fa-tags fas"></i>
                            ক্যাটাগরি ব্যবস্থাপনা
                        </Link>
                    </div>
                </div> -->

                <!-- দস্তরবন্দি ব্যবস্থাপনা -->
                <div v-if="$page.props.auth && $page.props.auth.admin && hasModuleAccess('document_management')">
                    <button @click="dropdownOpen.document_management = !dropdownOpen.document_management"
                        class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
                        <div class="flex gap-2 items-center">
                            <i class="h-6 text-sm w-6 fa-file-alt fas"></i>
                            দস্তরবন্দি ব্যবস্থাপনা
                        </div>
                        <i :class="{'rotate-180': dropdownOpen.document_management}" class="fa-chevron-down fa-xs fas tex-sm transition-transform"></i>
                    </button>
                    <div v-if="dropdownOpen.document_management" class="pl-6 bg-gray-900">
                        <Link
                            v-if="hasPermission('document_application_list') || hasModuleAccess('document_management')"
                            :href="route('admin.documents.applications.index')"
                            @click="setSelected('document_application_list')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'document_application_list'}">
                            <i class="h-4 w-4 fa-list fas"></i>
                            দস্তরবন্দি আবেদন তালিকা
                        </Link>
                        <Link
                            v-if="hasPermission('document_approve') || hasModuleAccess('document_management')"
                            :href="route('admin.documents.applications.approved')"
                            @click="setSelected('approval_list')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'approval_list'}">
                            <i class="h-4 w-4 fa-check fas"></i>
                            অনুমোদন তালিকা
                        </Link>
                        <Link
                            v-if="hasPermission('document_reject') || hasModuleAccess('document_management')"
                            href="#"
                            @click="setSelected('cancel_list')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'cancel_list'}">
                            <i class="h-4 w-4 fa-times fas"></i>
                            বাতিল তালিকা
                        </Link>
                        <Link
                            v-if="hasPermission('Food_mangement') || hasModuleAccess('document_management')"
                            :href="route('food.FoodManagement')"
                            @click="setSelected('Food_lis')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'Food_lis'}">
                            <i class="h-4 w-4 fa-utensils fas"></i>
                            খাবার ব্যবস্থাপনা
                        </Link>
                        <Link
                            v-if="hasPermission('Fees_management') || hasModuleAccess('document_management')"
                          :href="route('fees.FeeManagement')"
                            @click="setSelected('fees_list')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'fees_list'}">
                            <i class="h-4 w-4 fa-coins fas"></i>
                            ফি ব্যবস্থাপনা
                        </Link>
                    </div>
                </div>

                <!-- আবেদন ব্যবস্থাপনা -->
                <div v-if="$page.props.auth && $page.props.auth.admin && hasModuleAccess('application_management')">
                    <button @click="dropdownOpen.application_management = !dropdownOpen.application_management"
                        class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
                        <div class="flex gap-2 items-center">
                            <i class="h-6 text-sm w-6 fa-clipboard-list fas"></i>
                            মাসিক নেয়ামত
                        </div>
                        <i :class="{'rotate-180': dropdownOpen.application_management}" class="fa-chevron-down fa-xs fas tex-sm transition-transform"></i>
                    </button>
                    <div v-if="dropdownOpen.application_management" class="pl-6 bg-gray-900">
                        <Link
                            v-if="hasPermission('application_list')"
                            href="#"
                            @click="setSelected('application_list')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'application_list'}">
                            <i class="h-4 w-4 fa-list fas"></i>
                            আবেদন তালিকা
                        </Link>
                        <Link
                            v-if="hasPermission('application_view')"
                            href="#"
                            @click="setSelected('pending_applications')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'pending_applications'}">
                            <i class="h-4 w-4 fa-clock fas"></i>
                            অপেক্ষমান আবেদন
                        </Link>
                        <Link
                            v-if="hasPermission('application_approve')"
                            href="#"
                            @click="setSelected('approved_applications')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'approved_applications'}">
                            <i class="h-4 w-4 fa-check-circle fas"></i>
                            অনুমোদিত আবেদন
                        </Link>
                    </div>
                </div>

                <!-- অনুদান ব্যবস্থাপনা -->
                <div v-if="$page.props.auth && $page.props.auth.admin && hasModuleAccess('grant_management')">
                    <button @click="dropdownOpen.grant_management = !dropdownOpen.grant_management"
                        class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
                        <div class="flex gap-2 items-center">
                            <i class="h-6 text-sm w-6 fa-hand-holding-usd fas"></i>
                            অনুদান ব্যবস্থাপনা
                        </div>
                        <i :class="{'rotate-180': dropdownOpen.grant_management}" class="fa-chevron-down fa-xs fas tex-sm transition-transform"></i>
                    </button>
                    <div v-if="dropdownOpen.grant_management" class="pl-6 bg-gray-900">
                        <Link
                            v-if="hasPermission('grant_project_create')"
                            href="#"
                            @click="setSelected('create_grant_project')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'create_grant_project'}">
                            <i class="h-4 w-4 fa-plus fas"></i>
                            অনুদানের জন্য প্রজেক্ট ক্রিয়েট
                        </Link>
                        <Link
                            v-if="hasPermission('grant_project_edit')"
                            href="#"
                            @click="setSelected('grant_project_list')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'grant_project_list'}">
                            <i class="h-4 w-4 fa-list fas"></i>
                            প্রজেক্ট তালিকা
                        </Link>
                        <Link
                            v-if="hasPermission('grant_application_view')"
                            href="#"
                            @click="setSelected('grant_applications')"
                            class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
                            :class="{'bg-gray-700 text-white': selectedItem == 'grant_applications'}">
                            <i class="h-4 w-4 fa-file-invoice-dollar fas"></i>
                            অনুদান আবেদন
                        </Link>
                    </div>
                    <Link
                        v-if="hasModuleAccess('messaging')"
                        href="#"
                        class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2">
                        <i class="h-6 text-sm w-6 fa-envelope fas"></i>
                        মেসেজিং
                    </Link>
                    <Link
                        v-if="hasModuleAccess('notice')"
                        href="#"
                        class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2">
                        <i class="h-6 text-sm w-6 fa-bell fas"></i>
                        নোটিস
                    </Link>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div
            :class="[
                'flex-1',
                'transition-all duration-300 ease-in-out',
                'lg:ml-64',
                'w-full',
                'overflow-x-hidden'
            ]"
        >
            <nav class="bg-white border-b border-gray-100">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Hamburger -->
                            <div class="shrink-0 flex items-center lg:hidden">
                                <button @click="showSidebar = !showSidebar" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-800 transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{'hidden': showSidebar, 'inline-flex': !showSidebar}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{'hidden': !showSidebar, 'inline-flex': showSidebar}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- Settings Dropdown -->
                        <div class="flex sm:items-center sm:ml-6 space-x-3">
                            <!-- Prayer Times Button -->
                            <button class="hidden sm:inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <i class="fa-solid fa-clock h-5 w-5 mr-1"></i>
                            </button>
                            <!-- Notification Button -->
                            <button @click="openNotifications" class="hidden sm:inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 relative">
                                <i class="fa-solid fa-bell h-5 w-5 mr-1"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                            </button>
                            <!-- Messages Button -->
                            <button @click="openMessages" class="hidden sm:inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 relative">
                                <i class="fa-solid fa-envelope h-5 w-5 mr-1"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">5</span>
                            </button>
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div class="flex items-center">
                                            <div class="mr-2 h-8 w-8 rounded-full overflow-hidden border border-gray-200">
                                                <img v-if="$page.props.auth.admin && $page.props.auth.admin.profile_image" :src="`/storage/${$page.props.auth.admin.profile_image}`" alt="Profile" class="h-full w-full object-cover">
                                                <div v-else class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="hidden sm:block" v-if="$page.props.auth.admin">
                                                <div>{{ $page.props.auth.admin.name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    <span class="px-2 py-0.5 rounded-full text-xs" :class="{
                                                        'bg-purple-100 text-purple-800': $page.props.auth.admin.role === 'super_admin',
                                                        'bg-green-100 text-green-800': $page.props.auth.admin.role === 'admin',
                                                        'bg-blue-100 text-blue-800': $page.props.auth.admin.role === 'moderator'
                                                    }">
                                                        {{ $page.props.auth.admin.role === 'super_admin' ? 'সুপার এডমিন' :
                                                            $page.props.auth.admin.role === 'admin' ? 'এডমিন' : 'মডারেটর' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        প্রোফাইল
                                    </DropdownLink>
                                    <DropdownLink href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        সেটিংস
                                    </DropdownLink>
                                    <DropdownLink :href="route('admin.logout')" method="post" as="button" class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        লগ আউট
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </nav>
            <main class="flex-1 pt-16 lg:mt-10 mt-2 p-2 lg:p-4">
                <slot />
            </main>
        </div>

        <div
            v-show="showSidebar"
            @click="showSidebar = false"
            class="bg-black bg-opacity-50 fixed inset-0 lg:hidden z-40"
        ></div>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(0, 77, 64, 0.1);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(0, 77, 64, 0.5);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: rgba(0, 77, 64, 0.7);
}
.custom-scrollbar {
  scrollbar-width: thin;
  scrollbar-color: rgba(0, 77, 64, 0.5) rgba(0, 77, 64, 0.1);
}
</style>