<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import Dropdown from '@/Components/admin/Dropdown.vue';
import DropdownLink from '@/Components/admin/DropdownLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

// Sidebar state
// const sidebarOpen = ref(true); // Changed initial state to true
// const isMobile = ref(false);

// const props = defineProps({
//   auth: Object
// });



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

});

// Notification & message states
const showNotifications = ref(false);
const showMessages = ref(false);

// Check window width and set mobile state
// Improved checkScreen function
// const checkScreen = () => {
//     isMobile.value = window.innerWidth < 768;
//     sidebarOpen.value = !isMobile.value;
// };

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

// কোন লিংকে ক্লিক করা হয়েছে সেটার জন্য ফাংশন
const setSelected = (item) => {
    selectedItem.value = item;
}

// Permission checking helper
const hasPermission = (permission) => {
    const admin = page.props.auth?.admin;

    // Super admin has all permissions
    if (admin?.role === 'super_admin') {
        return true;
    }

    // Check if admin has specific permission
    let permissions = admin?.permissions;
    
    // Handle permissions as both array and object format
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

    // Super admin has all access
    if (admin?.role === 'super_admin') {
        return true;
    }

    // Check specific module access permissions
    const modulePermissions = {
        'messaging': ['messaging_access'],
        'notice': ['notice_access'],
        'document_management': ['document_management_access'],
        'application_management': ['application_management_access'],
        'grant_management': ['grant_management_access']
    };

    if (modulePermissions[module]) {
        return hasAnyPermission(modulePermissions[module]);
    }

    return false;
}





</script>


<template>
<!-- massage & Notification -->



    <div

    style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"

    class="flex bg-gray-100 dark:bg-gray-900 min-h-screen">
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
        <Link :href="route('admin.admin_Dashboard')" class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2">
        <i class="h-6 text-sm w-6 fa-mosque fas"></i>
      তানজিম ড্যাশবোর্ড
        </Link>



        <!-- Admin User Management - Only for Super Admin -->
        <div v-if="$page.props.auth.admin?.role === 'super_admin' || $page.props.auth.admin?.designation == 1">
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



        <!-- দস্তরবন্দি ব্যবস্থাপনা -->
        <div v-if="hasModuleAccess('document_management')">
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
                    href="#"
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
            </div>
        </div>

        <!-- আবেদন ব্যবস্থাপনা -->
        <div v-if="hasModuleAccess('application_management')">
            <button @click="dropdownOpen.application_management = !dropdownOpen.application_management"
                class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
                <div class="flex gap-2 items-center">
                    <i class="h-6 text-sm w-6 fa-clipboard-list fas"></i>
                    আবেদন ব্যবস্থাপনা
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
        <div v-if="hasModuleAccess('grant_management')">
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
        'lg:ml-64',  // Always maintain margin on desktop
        'w-full',    // Ensure full width
        'overflow-x-hidden' // Prevent horizontal scrolling
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>

                    <!-- Notification Button -->
                    <button @click="openNotifications" class="hidden sm:inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button>

                    <!-- Messages Button -->
                    <button @click="openMessages" class="hidden sm:inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">5</span>
                    </button>

                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div class="flex items-center">
                                    <div class="mr-2 h-8 w-8 rounded-full overflow-hidden border border-gray-200">
                                        <img v-if="$page.props.auth.admin.profile_image" :src="`/storage/${$page.props.auth.admin.profile_image}`" alt="Profile" class="h-full w-full object-cover">
                                        <div v-else class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="hidden sm:block">
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
    </div>





<!-- Notification & massage model -->






<div
            v-show="showSidebar"
            @click="showSidebar = false"
            class="bg-black bg-opacity-50 fixed inset-0 lg:hidden z-40"
        ></div>






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

/* Firefox */
.custom-scrollbar {
  scrollbar-width: thin;
  scrollbar-color: rgba(0, 77, 64, 0.5) rgba(0, 77, 64, 0.1);
}
</style>
