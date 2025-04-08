<template>
<AuthenticatedLayout>
    <div class="bg-white mx-5 mt-5 dark:bg-gray-900 rounded-lg shadow-lg p-6 border border-emerald-100 dark:border-emerald-900">
      <!-- Header with Islamic pattern -->
      <div class="relative mb-6 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg p-4 overflow-hidden">
        <div class="absolute inset-0 opacity-10"></div>
        <h2 class="text-2xl  text-emerald-800 dark:text-emerald-200 text-center relative z-10">
          ইউজার ম্যানেজমেন্ট সিস্টেম
        </h2>
      </div>

      <!-- Search and Filter Section -->
      <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="flex-1">
          <div class="relative">
            <input
              type="text"
              placeholder="ফোন নম্বর দিয়ে সার্চ করুন"
              class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:text-gray-200"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>
        </div>

        <div class="w-full md:w-48">
          <select
            class="w-full py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:text-gray-200"
          >
            <option value="">সকল ইউজার</option>
            <option value="super_admin">সুপার এডমিন</option>
            <option value="board_admin">বোর্ড এডমিন</option>
            <option value="admin">এডমিন</option>
            <option value="user">সাধারণ ইউজার</option>
          </select>
        </div>

        <div>
          <Link
          :href="route('user_create_for_admin.new_user_for_admin')"
            class="w-full md:w-auto px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md transition-colors duration-200 flex items-center justify-center gap-2 shadow-md"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            নতুন ইউজার
          </Link>
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-emerald-50 dark:bg-emerald-900/30">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-emerald-800 dark:text-emerald-200 uppercase tracking-wider">ছবি</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-emerald-800 dark:text-emerald-200 uppercase tracking-wider">নাম</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-emerald-800 dark:text-emerald-200 uppercase tracking-wider">ফোন নম্বর</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-emerald-800 dark:text-emerald-200 uppercase tracking-wider">ইমেইল</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-emerald-800 dark:text-emerald-200 uppercase tracking-wider">পদবি</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-emerald-800 dark:text-emerald-200 uppercase tracking-wider">একশন</th>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
        <tr v-for="admin in admins" :key="admin.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-150">
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-emerald-200 dark:border-emerald-700">
              <img :src="admin.profile_image ? '/storage/' + admin.profile_image : 'https://randomuser.me/api/portraits/men/1.jpg'"
                   :alt="admin.name" class="h-full w-full object-cover" />
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ admin.name }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-700 dark:text-gray-300">{{ admin.phone }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-700 dark:text-gray-300">{{ admin.email }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                  :class="getDesignationClass(admin.designation)">
              {{ getDesignationText(admin.designation) }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex space-x-2">
                <Link
    :href="route('user_create_for_admin.admin_user_edit', admin.id)"
    class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
    </svg>
</Link>


<div>
    <!-- ডিলিট বাটন -->
    <button
      @click="confirmDelete(admin.id)"
      class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
      </svg>
    </button>

    <!-- কনফার্মেশন মডাল -->
    <div v-if="showModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" @click="showModal = false">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                  এডমিন ডিলিট করুন
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">
                    আপনি কি নিশ্চিত যে আপনি এই এডমিন ডিলিট করতে চান? এই কাজটি অপরিবর্তনীয়।
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button
              @click="deleteAdmin"
              type="button"
              class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
              ডিলিট করুন
            </button>
            <button
              @click="showModal = false"
              type="button"
              class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
              বাতিল করুন
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-6">
      <div class="flex items-center">
        <span class="text-sm text-gray-700 dark:text-gray-300">
          মোট <span class="font-medium">৫০</span> জন ইউজারের মধ্যে <span class="font-medium">১-৫</span> দেখাচ্ছে
        </span>
      </div>
      <div class="flex items-center space-x-2">
        <button class="px-3 py-1 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
          আগের পেজ
        </button>
        <button class="px-3 py-1 rounded-md bg-emerald-600 text-white hover:bg-emerald-700">
          ১
        </button>
        <button class="px-3 py-1 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
          ২
        </button>
        <button class="px-3 py-1 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
          ৩
        </button>
        <button class="px-3 py-1 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
          পরের পেজ
        </button>
      </div>
    </div>
  </div>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

const admins = ref([]);

onMounted(() => {
  fetchAdmins();
});

const fetchAdmins = async () => {
  try {
    const response = await axios.get('/api/admins');
    admins.value = response.data;
  } catch (error) {
    console.error('Error fetching admins:', error);
  }
};

const getDesignationText = (designation) => {
  if (designation == 1) {
    return 'সুপার এডমিন';
  } else if (designation == 2) {
    return 'সহ সুপার এডমিন';
  } else {
    return 'বোর্ড এডমিন';
  }
};

const getDesignationClass = (designation) => {
  if (designation == 1) {
    return 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200';
  } else if (designation == 2) {
    return 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200';
  } else {
    return 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200';
  }
};



const showModal = ref(false);
const adminIdToDelete = ref(null);

const confirmDelete = (id) => {
  adminIdToDelete.value = id;
  showModal.value = true;
};

const deleteAdmin = () => {
  // Inertia.js ব্যবহার করে ডিলিট রিকোয়েস্ট পাঠানো
  router.delete(route('user_create_for_admin.destroy', adminIdToDelete.value));
  showModal.value = false;
};






// আপনি এখানে ডাটা যোগ করতে পারেন
</script>

<style scoped>
.font-arabic {
  font-family: 'Noto Sans Bengali', 'Hind Siliguri', sans-serif;
}

.islamic-pattern {
  background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
</style>
