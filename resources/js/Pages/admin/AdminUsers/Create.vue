<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import InputError from '@/Components/admin/InputError.vue';
import InputLabel from '@/Components/admin/InputLabel.vue';
import PrimaryButton from '@/Components/admin/PrimaryButton.vue';
import TextInput from '@/Components/admin/TextInput.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    graduationYears: Array,
    availablePermissions: Object,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'moderator',
    department: '',
    designation: '',
    phone: '',
    graduation_year: '',
    is_active: true,
    permissions: [],
});

const submit = () => {
    form.post(route('admin.users.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

// Permission management functions
const togglePermission = (permission) => {
    // Ensure permissions is an array
    if (!Array.isArray(form.permissions)) {
        form.permissions = [];
    }

    const index = form.permissions.indexOf(permission);
    if (index > -1) {
        form.permissions.splice(index, 1);
    } else {
        form.permissions.push(permission);
    }
};

const hasPermission = (permission) => {
    // Ensure permissions is an array
    if (!Array.isArray(form.permissions)) {
        return false;
    }
    return form.permissions.includes(permission);
};

const toggleModulePermissions = (module, permissions) => {
    // Ensure permissions is an array
    if (!Array.isArray(form.permissions)) {
        form.permissions = [];
    }

    const allChecked = permissions.every(permission => hasPermission(permission));

    if (allChecked) {
        // Remove all permissions of this module
        permissions.forEach(permission => {
            const index = form.permissions.indexOf(permission);
            if (index > -1) {
                form.permissions.splice(index, 1);
            }
        });
    } else {
        // Add all permissions of this module
        permissions.forEach(permission => {
            if (!hasPermission(permission)) {
                form.permissions.push(permission);
            }
        });
    }
};

const isModuleFullySelected = (permissions) => {
    // Ensure form.permissions is an array
    if (!Array.isArray(form.permissions)) {
        return false;
    }
    return permissions.every(permission => hasPermission(permission));
};

const isModulePartiallySelected = (permissions) => {
    // Ensure form.permissions is an array
    if (!Array.isArray(form.permissions)) {
        return false;
    }
    return permissions.some(permission => hasPermission(permission)) && !isModuleFullySelected(permissions);
};

// Get permission label for display
const getPermissionLabel = (permissionKey) => {
    for (const module of Object.values(props.availablePermissions)) {
        if (module.permissions[permissionKey]) {
            return module.permissions[permissionKey];
        }
    }
    return permissionKey;
};
</script>

<template>
    <Head title="নতুন এডমিন ইউজার তৈরি করুন" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    নতুন এডমিন ইউজার তৈরি করুন
                </h2>
                <Link :href="route('admin.users.index')"
                      class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ফিরে যান
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- Name -->
                            <div>
                                <InputLabel for="name" value="নাম *" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- Email -->
                            <div class="mt-4">
                                <InputLabel for="email" value="ইমেইল *" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <InputLabel for="password" value="পাসওয়ার্ড *" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <InputLabel for="password_confirmation" value="পাসওয়ার্ড নিশ্চিত করুন *" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password_confirmation"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>

                            <!-- Role -->
                            <div class="mt-4">
                                <InputLabel for="role" value="ভূমিকা *" />
                                <select
                                    id="role"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.role"
                                    required
                                >
                                    <option value="moderator">মডারেটর</option>
                                    <option value="admin">এডমিন</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.role" />
                            </div>

                            <!-- Department -->
                            <div class="mt-4">
                                <InputLabel for="department" value="বিভাগ" />
                                <TextInput
                                    id="department"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.department"
                                />
                                <InputError class="mt-2" :message="form.errors.department" />
                            </div>

                            <!-- Designation -->
                            <div class="mt-4">
                                <InputLabel for="designation" value="পদবি" />
                                <TextInput
                                    id="designation"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.designation"
                                />
                                <InputError class="mt-2" :message="form.errors.designation" />
                            </div>

                            <!-- Phone -->
                            <div class="mt-4">
                                <InputLabel for="phone" value="ফোন নম্বর" />
                                <TextInput
                                    id="phone"
                                    type="tel"
                                    class="mt-1 block w-full"
                                    v-model="form.phone"
                                />
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>

                            <!-- Graduation Year -->
                            <div class="mt-4" v-if="form.role === 'moderator'">
                                <InputLabel for="graduation_year" value="পাস সাল (মডারেটরদের জন্য)" />
                                <select
                                    id="graduation_year"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.graduation_year"
                                >
                                    <option value="">সাল নির্বাচন করুন</option>
                                    <option v-for="year in graduationYears" :key="year" :value="year">
                                        {{ year }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.graduation_year" />
                                <p class="mt-1 text-sm text-gray-600">
                                    মডারেটর শুধুমাত্র নির্বাচিত পাস সালের ডাটা দেখতে পাবেন
                                </p>
                            </div>

                            <!-- Advanced Permissions -->
                            <div class="mt-6" v-if="form.role === 'moderator' || form.role === 'admin'">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">অনুমতি ব্যবস্থাপনা</h3>

                                <div class="space-y-6 border rounded-lg p-6 bg-gray-50">
                                    <div v-for="(module, moduleKey) in availablePermissions" :key="moduleKey" class="space-y-3">
                                        <!-- Module Header with Select All -->
                                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm border">
                                            <h4 class="text-base font-semibold text-gray-800">{{ module.name }}</h4>
                                            <div class="flex items-center space-x-2">
                                                <label class="flex items-center cursor-pointer">
                                                    <input
                                                        type="checkbox"
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                        :checked="isModuleFullySelected(Object.keys(module.permissions))"
                                                        :indeterminate="isModulePartiallySelected(Object.keys(module.permissions))"
                                                        @change="toggleModulePermissions(moduleKey, Object.keys(module.permissions))"
                                                    />
                                                    <span class="ml-2 text-sm font-medium text-gray-700">সব নির্বাচন</span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Individual Permissions -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 ml-4">
                                            <div v-for="(permissionLabel, permissionKey) in module.permissions" :key="permissionKey">
                                                <label class="flex items-center p-2 hover:bg-white rounded-md cursor-pointer transition-colors">
                                                    <input
                                                        type="checkbox"
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                        :checked="hasPermission(permissionKey)"
                                                        @change="togglePermission(permissionKey)"
                                                    />
                                                    <span class="ml-2 text-sm text-gray-700">{{ permissionLabel }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Permission Summary -->
                                    <div v-if="form.permissions.length > 0" class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                        <h5 class="text-sm font-medium text-blue-800 mb-2">নির্বাচিত অনুমতিসমূহ:</h5>
                                        <div class="flex flex-wrap gap-1">
                                            <span v-for="permission in form.permissions" :key="permission"
                                                  class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ getPermissionLabel(permission) }}
                                                <button @click="togglePermission(permission)" class="ml-1 text-blue-600 hover:text-blue-800">
                                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Is Active -->
                            <div class="mt-4">
                                <label class="flex items-center">
                                    <input
                                        type="checkbox"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        v-model="form.is_active"
                                    />
                                    <span class="ml-2 text-sm text-gray-600">সক্রিয় অ্যাকাউন্ট</span>
                                </label>
                                <InputError class="mt-2" :message="form.errors.is_active" />
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <Link
                                    :href="route('admin.users.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 mr-4"
                                >
                                    বাতিল করুন
                                </Link>

                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    তৈরি করুন
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
* {
    font-family: 'Merriweather', 'SolaimanLipi', sans-serif;
}
</style>
