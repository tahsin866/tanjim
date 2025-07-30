<template>
  <div style="font-family: 'Merriweather','SolaimanLipi',sans-serif;" class="flex bg-gray-100 dark:bg-gray-900 min-h-screen">
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
          <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none"><path d="M12 2L3 9V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V9L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          তানজিমে আবনা মেনেজমেন্ট
        </div>
      </div>

      <nav class="max-h-[calc(100vh-4rem)] mt-4 overflow-y-auto space-y-2">
        <Link :href="route('admin.admin_Dashboard')" class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2">
          <i class="h-6 text-sm w-6 fa-mosque fas"></i>
          তানজিম ড্যাশবোর্ড
        </Link>

        <!-- Admin User Management - Only for Super Admin/Authorized -->
        <div v-if="hasPermission('admin_management')">
          <button @click="toggleDropdown('admin_management')" class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
            <div class="flex gap-2 items-center">
              <i class="h-6 text-sm w-6 fa-users fas"></i>
              এডমিন ব্যবস্থাপনা
            </div>
            <i :class="{'rotate-180': dropdownOpen.admin_management}" class="fa-chevron-down fa-xs fas tex-sm transition-transform"></i>
          </button>
          <div v-if="dropdownOpen.admin_management" class="pl-6 bg-gray-900">
            <Link
              v-if="hasPermission('admin_users_list')"
              :href="route('admin.users.index')"
              @click="setSelected('admin_users_list')"
              class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
              :class="{'bg-gray-700 text-white': selectedItem == 'admin_users_list'}">
              <i class="h-4 w-4 fa-list fas"></i>
              এডমিন ইউজার তালিকা
            </Link>
            <Link
              v-if="hasPermission('create_admin_user')"
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
        <div v-if="hasPermission('document_management')">
          <button @click="toggleDropdown('document_management')" class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
            <div class="flex gap-2 items-center">
              <i class="h-6 text-sm w-6 fa-file-alt fas"></i>
              দস্তরবন্দি ব্যবস্থাপনা
            </div>
            <i :class="{'rotate-180': dropdownOpen.document_management}" class="fa-chevron-down fa-xs fas tex-sm transition-transform"></i>
          </button>
          <div v-if="dropdownOpen.document_management" class="pl-6 bg-gray-900">
            <Link
              v-if="hasPermission('document_application_list')"
              :href="route('admin.documents.applications.index')"
              @click="setSelected('document_application_list')"
              class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
              :class="{'bg-gray-700 text-white': selectedItem == 'document_application_list'}">
              <i class="h-4 w-4 fa-list fas"></i>
              দস্তরবন্দি আবেদন তালিকা
            </Link>
            <Link
              v-if="hasPermission('document_approve')"
              href="#"
              @click="setSelected('approval_list')"
              class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2"
              :class="{'bg-gray-700 text-white': selectedItem == 'approval_list'}">
              <i class="h-4 w-4 fa-check fas"></i>
              অনুমোদন তালিকা
            </Link>
            <Link
              v-if="hasPermission('document_reject')"
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
        <div v-if="hasPermission('application_management')">
          <button @click="toggleDropdown('application_management')" class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
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
        <div v-if="hasPermission('grant_management')">
          <button @click="toggleDropdown('grant_management')" class="flex justify-between text-lg w-full hover:bg-gray-700 items-center px-4 py-2">
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
        </div>

        <!-- Messaging -->
        <Link
          v-if="hasPermission('messaging_access')"
          :href="route('others.massaging')"
          class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2">
          <i class="h-6 text-sm w-6 fa-envelope fas"></i>
          মেসেজিং
        </Link>

        <!-- Notice -->
        <Link
          v-if="hasPermission('notice_access')"
          :href="route('others.notice')"
          class="flex text-lg gap-2 hover:bg-gray-700 items-center px-4 py-2">
          <i class="h-6 text-sm w-6 fa-bell fas"></i>
          নোটিস
        </Link>
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
      <!-- Navbar -->
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
            <!-- Settings Dropdown/User Info -->
            <div class="flex sm:items-center sm:ml-6 space-x-3">
              <!-- (User info & dropdown here, as per your previous code) -->
            </div>
          </div>
        </div>
      </nav>
      <main class="flex-1 pt-16 lg:mt-10 mt-2 p-2 lg:p-4">
        <slot />
      </main>
    </div>
    <!-- Mobile Sidebar Overlay -->
    <div
      v-show="showSidebar"
      @click="showSidebar = false"
      class="bg-black bg-opacity-50 fixed inset-0 lg:hidden z-40"
    ></div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const showSidebar = ref(false)
const page = usePage()

// Dropdown states per module
const dropdownOpen = ref({
  admin_management: false,
  document_management: false,
  application_management: false,
  grant_management: false,
})

// Selected menu
const selectedItem = ref('')

const setSelected = (item) => {
  selectedItem.value = item
}

// Toggle dropdown menu
const toggleDropdown = (key) => {
  dropdownOpen.value[key] = !dropdownOpen.value[key]
}

// Permission check: Super admin gets all, otherwise check permission list
const hasPermission = (permission) => {
  const admin = page.props.auth?.admin
  if (admin?.role === 'super_admin') return true
  return admin?.permissions && admin.permissions.includes(permission)
}
</script>
