<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/admin/PrimaryButton.vue';

defineProps({
    admins: Array,
});
</script>

<template>
    <Head title="এডমিন ইউজার ম্যানেজমেন্ট" />
<AuthenticatedLayout>
    <template #header>
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold leading-tight text-gray-800">
                এডমিন ইউজার ম্যানেজমেন্ট
            </h2>
            <Link :href="route('admin.users.create')">
                <PrimaryButton class="transition duration-150 ease-in-out hover:scale-105">নতুন এডমিন যোগ করুন</PrimaryButton>
            </Link>
        </div>
    </template>

    <div class="py-12">
        <div class=" sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">নাম</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">ইমেইল</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">ভূমিকা</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">বিভাগ</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">স্ট্যাটাস</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">তৈরির তারিখ</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-700">কার্যক্রম</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="admin in admins" :key="admin.id" class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ admin.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ admin.email }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
                                            :class="{
                                                'bg-red-100 text-red-800': admin.role === 'super_admin',
                                                'bg-blue-100 text-blue-800': admin.role === 'admin',
                                                'bg-green-100 text-green-800': admin.role === 'moderator'
                                            }">
                                            {{ admin.role === 'super_admin' ? 'সুপার এডমিন' :
                                               admin.role === 'admin' ? 'এডমিন' : 'মডারেটর' }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ admin.department || 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
                                            :class="{
                                                'bg-green-100 text-green-800': admin.is_active,
                                                'bg-red-100 text-red-800': !admin.is_active
                                            }">
                                            {{ admin.is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ new Date(admin.created_at).toLocaleDateString('bn-BD') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <Link :href="route('admin.users.edit', admin.id)"
                                            class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-1 text-xs font-medium text-white shadow-sm transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-2">
                                            সম্পাদনা
                                        </Link>
                                        <button v-if="admin.role !== 'super_admin'"
                                            @click="deleteAdmin(admin.id)"
                                            class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-1 text-xs font-medium text-white shadow-sm transition duration-150 ease-in-out hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                            মুছুন
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
</template>

<script>
import { router } from '@inertiajs/vue3';

export default {
    methods: {
        deleteAdmin(adminId) {
            if (confirm('আপনি কি নিশ্চিত যে এই এডমিন ইউজারটি মুছে ফেলতে চান?')) {
                router.delete(route('admin.users.destroy', adminId));
            }
        }
    }
}
</script>

<style scoped>
* {
    font-family: 'Merriweather', 'SolaimanLipi', sans-serif;
}
</style>
