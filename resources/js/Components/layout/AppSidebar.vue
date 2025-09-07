<template>
  <div
    :class="[
      'fixed top-0 left-0 h-screen w-64 bg-gray-800 text-white z-40 flex flex-col shadow-lg transition-transform duration-300 ease-in-out',
      isMobile
        ? (visible ? 'translate-x-0' : '-translate-x-full')
        : 'translate-x-0'
    ]"
  >
    <!-- Logo Header -->
    <div class="bg-gray-900 border-b border-gray-700 py-4 px-5">
      <div class="flex items-center gap-3">
        <i class="pi pi-home text-2xl text-blue-400"></i>
        <span class="text-lg font-bold text-white tracking-wide">আবনায়ে ফরিদাবাদ</span>
      </div>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden py-2">
      <!-- Show message for suspended users -->
      <div v-if="isUserSuspended" class="px-5 py-6">
        <div class="bg-red-900/30 border border-red-500/50 text-red-100 px-4 py-4 rounded-lg">
          <div class="flex items-center justify-center mb-2">
            <i class="pi pi-exclamation-triangle text-xl text-red-300"></i>
          </div>
          <p class="text-sm font-medium text-center">আপনার অ্যাকাউন্ট সাসপেন্ড করা হয়েছে</p>
          <p class="text-xs mt-2 text-center text-red-300">আরও তথ্যের জন্য আবনা প্রশাসনের সাথে যোগাযোগ করুন</p>
        </div>
      </div>

      <!-- Regular menu for active users -->
      <div v-else class="space-y-1 px-3 py-1">
        <!-- Top level menu items -->
        <div v-for="(item, index) in filteredMenuItems" :key="index" class="mb-1">
          <!-- Direct link item -->
          <Link
            v-if="item.route && !item.items"
            :href="item.route"
            :class="[
              'flex items-center w-full text-left px-4 py-3 rounded-lg transition-colors duration-200',
              isActiveRoute(item.routeName)
                ? 'bg-gray-700 border-l-4 border-blue-400 pl-3 font-medium text-blue-100'
                : 'hover:bg-gray-700/70 hover:text-white text-gray-300'
            ]"
          >
            <span :class="item.icon + ' text-lg'" />
            <span class="ml-3 text-sm">{{ item.label }}</span>
            <Badge
              v-if="item.badge"
              :value="item.badge"
              severity="danger"
              class="ml-auto"
            />
          </Link>
          
          <!-- Expandable menu item -->
          <div v-else class="mb-2">
            <button
              @click="toggleSubmenu(index)"
              :class="[
                'flex items-center justify-between w-full text-left px-4 py-3 rounded-lg transition-colors duration-200',
                expandedMenus.includes(index)
                  ? 'bg-gray-700/70 text-white font-medium'
                  : 'text-gray-300 hover:bg-gray-700/50 hover:text-white'
              ]"
            >
              <div class="flex items-center">
                <span :class="item.icon + ' text-lg'" />
                <span class="ml-3 text-sm">{{ item.label }}</span>
              </div>
              <i 
                :class="[
                  'pi text-sm transition-transform duration-200',
                  expandedMenus.includes(index) ? 'pi-chevron-up' : 'pi-chevron-down'
                ]"
              ></i>
            </button>
            
            <!-- Submenu items -->
            <div 
              v-if="item.items"
              :class="[
                'mt-1 ml-4 pl-2 border-l border-gray-600 space-y-1 transition-all duration-200 overflow-hidden',
                expandedMenus.includes(index) ? 'max-h-60' : 'max-h-0'
              ]"
            >
              <Link
                v-for="(subItem, subIndex) in item.items"
                :key="subIndex"
                :href="subItem.route"
                :class="[
                  'flex items-center w-full text-left px-4 py-2 rounded-lg transition-colors duration-200 text-sm',
                  isActiveRoute(subItem.routeName)
                    ? 'bg-gray-700/80 text-blue-200 font-medium'
                    : 'text-gray-400 hover:bg-gray-700/30 hover:text-gray-200'
                ]"
                @click="onMenuItemClick"
              >
                <span :class="subItem.icon + ' text-sm opacity-80'" />
                <span class="ml-3 text-xs">{{ subItem.label }}</span>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="flex-shrink-0 px-4 py-3 border-t border-gray-700/50 mt-auto">
      <div class="text-center text-gray-400 text-xs">
        <p>© ২০২৫ আবনায়ে ফরিদাবাদ</p>
        <p class="mt-1">সংস্করণ ২.০</p>
      </div>
    </div>
  </div>

  <!-- Mobile overlay -->
  <div
    v-if="visible && isMobile"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30"
    @click="$emit('hide')"
  ></div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import Badge from 'primevue/badge'

const props = defineProps({
  visible: Boolean,
  isMobile: Boolean
})

const emit = defineEmits(['hide'])
const page = usePage()
const expandedMenus = ref([])

// Toggle submenu state
const toggleSubmenu = (index) => {
  const position = expandedMenus.value.indexOf(index)
  if (position !== -1) {
    expandedMenus.value.splice(position, 1)
  } else {
    expandedMenus.value.push(index)
  }
}

// Check if user is suspended
const isUserSuspended = computed(() => {
  return page.props.auth?.user?.status === 'suspended'
})

// Current route tracking
const currentRoute = computed(() => {
  try {
    return page.props.ziggy?.location || route().current() || ''
  } catch (error) {
    console.warn('Route detection failed:', error)
    return ''
  }
})

const isActiveRoute = (routeName) => {
  if (!routeName) return false
  try {
    const current = currentRoute.value
    return current === routeName || (current && current.startsWith(routeName.split('.')[0]))
  } catch (error) {
    console.warn('Route comparison failed:', error)
    return false
  }
}

// Menu items configuration (static data, no need for ref)
const menuItems = [
  {
    label: 'ড্যাশবোর্ড',
    icon: 'pi pi-home',
    get route() { return route('dashboard') },
    routeName: 'dashboard'
  },
  {
    label: 'রেজিস্ট্রেশন সংক্রান্ত',
    icon: 'pi pi-file-edit',
    items: [
      {
        label: 'দস্তরবন্দী রেজিস্ট্রেশন',
        icon: 'pi pi-send',
        get route() { return route('madrashaDashboard.studentData') },
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
        get route() { return route('madrashaDashboard.studentData') },
        routeName: 'madrashaDashboard.studentData'
      },
      // {
      //   label: 'খাবার ব্যবস্থাপনা',
      //   icon: 'pi pi-send',
      //   get route() { return route('madrashaDashboard.food') },
      //   routeName: 'madrashaDashboard.food'
      // },
    ]
  },
]

// Filter menu items based on visibility and user status
const filteredMenuItems = computed(() => {
  if (isUserSuspended.value) {
    return []
  }
  return menuItems.filter(item => {
    if (item.visible === false) return false
    // Create a copy of the item to avoid mutating the original
    const filteredItem = { ...item }
    if (filteredItem.items) {
      filteredItem.items = filteredItem.items.filter(subItem => subItem.visible !== false)
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