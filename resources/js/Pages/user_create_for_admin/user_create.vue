<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { ref } from 'vue';

const roles = ref([
    { id: 1, name: 'বোর্ড এডমিন' },
    { id: 2, name: 'সহ বোর্ড এডমিন' },
    { id: 3, name: 'নাজিমে তালিমাত' }
]);

const menuGroups = ref([
    {
        id: 1,
        name: 'সেটাপ সংক্রান্ত',
        menus: [
            { id: 1, name: 'মারহালা সেটাপ' },
            { id: 2, name: 'বিষয় সেটাপ' },
            { id: 3, name: 'কেন্দ্রীয় পরীক্ষা সেটাপ' }
        ]
    },
    {
        id: 2,
        name: 'মাদরাসা সংক্রান্ত',
        menus: [
            { id: 4, name: 'মাদরাসা তালিকা' },
            { id: 5, name: 'বিবিধ' },
            { id: 6, name: 'মাদরাসা এডমিন' }
        ]
    }
]);

const selectedRole = ref(null);
const selectedMenus = ref([]);

const createUser = ref({
    name: '',
    email: '',
    password: '',
    role: null
});

const handleCreateUser = () => {
    // Handle user creation logic
};
</script>

<template>
  <AuthenticatedLayout>
    <div class="p-6 bg-white rounded-lg shadow-md mx-5 mt-5">
        <!-- User Creation Form -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">নতুন ব্যবহারকারী তৈরি</h2>

            <div class="space-y-4">
                <div>
                    <label class="block mb-1">নাম</label>
                    <input type="text" v-model="createUser.name"
                           class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block mb-1">ইমেইল</label>
                    <input type="email" v-model="createUser.email"
                           class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block mb-1">পাসওয়ার্ড</label>
                    <input type="password" v-model="createUser.password"
                           class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block mb-1">রোল নির্বাচন</label>
                    <select v-model="selectedRole"
                            class="w-full p-2 border rounded">
                        <option v-for="role in roles" :key="role.id" :value="role">
                            {{ role.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Menu Access Section -->
        <div>
            <h2 class="text-2xl font-bold mb-4">মেনু একসেস</h2>

            <div class="space-y-6">
                <div v-for="group in menuGroups" :key="group.id"
                     class="border p-4 rounded">
                    <h3 class="font-bold mb-2">{{ group.name }}</h3>

                    <div class="space-y-2">
                        <div v-for="menu in group.menus" :key="menu.id"
                             class="flex items-center">
                            <input type="checkbox"
                                   :id="'menu-' + menu.id"
                                   v-model="selectedMenus"
                                   :value="menu.id"
                                   class="mr-2">
                            <label :for="'menu-' + menu.id">{{ menu.name }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button @click="handleCreateUser"
                    class="px-6 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                সংরক্ষণ করুন
            </button>
        </div>
    </div>
  </AuthenticatedLayout>
</template>
