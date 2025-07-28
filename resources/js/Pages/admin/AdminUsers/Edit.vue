<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import InputError from '@/Components/admin/InputError.vue';
import InputLabel from '@/Components/admin/InputLabel.vue';
import PrimaryButton from '@/Components/admin/PrimaryButton.vue';
import TextInput from '@/Components/admin/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    admin: Object,
    graduationYears: Array,
    availablePermissions: Object,
});

// Debug: Log the admin data
console.log('Admin data received:', props.admin);

const form = useForm({
    name: props.admin?.name || '',
    email: props.admin?.email || '',
    password: '',
    password_confirmation: '',
    role: props.admin?.role || 'moderator',
    department: props.admin?.department || '',
    designation: props.admin?.designation || '',
    phone: props.admin?.phone || '',
    graduation_year: props.admin?.graduation_year || '',
    is_active: props.admin?.is_active ?? true,
    permissions: Array.isArray(props.admin?.permissions) ? props.admin.permissions : [],
});

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

const toggleModulePermissions = (moduleKey) => {
    // Ensure permissions is an array
    if (!Array.isArray(form.permissions)) {
        form.permissions = [];
    }

    const modulePermissions = Object.keys(props.availablePermissions[moduleKey].permissions);
    const allSelected = isModuleFullySelected(moduleKey);

    modulePermissions.forEach(permission => {
        const fullPermission = `${moduleKey}.${permission}`;
        const index = form.permissions.indexOf(fullPermission);

        if (allSelected && index > -1) {
            form.permissions.splice(index, 1);
        } else if (!allSelected && index === -1) {
            form.permissions.push(fullPermission);
        }
    });
};

const isModuleFullySelected = (moduleKey) => {
    // Ensure permissions is an array
    if (!Array.isArray(form.permissions)) {
        return false;
    }

    const modulePermissions = Object.keys(props.availablePermissions[moduleKey].permissions);
    return modulePermissions.every(permission =>
        form.permissions.includes(`${moduleKey}.${permission}`)
    );
};

const isModulePartiallySelected = (moduleKey) => {
    // Ensure permissions is an array
    if (!Array.isArray(form.permissions)) {
        return false;
    }

    const modulePermissions = Object.keys(props.availablePermissions[moduleKey].permissions);
    const selectedCount = modulePermissions.filter(permission =>
        form.permissions.includes(`${moduleKey}.${permission}`)
    ).length;
    return selectedCount > 0 && selectedCount < modulePermissions.length;
};

const getPermissionLabel = (moduleKey, permissionKey) => {
    return props.availablePermissions[moduleKey]?.permissions[permissionKey] || permissionKey;
};

const removePermission = (permission) => {
    // Ensure permissions is an array
    if (!Array.isArray(form.permissions)) {
        form.permissions = [];
        return;
    }

    const index = form.permissions.indexOf(permission);
    if (index > -1) {
        form.permissions.splice(index, 1);
    }
};const submit = () => {
    if (!props.admin?.id) {
        console.error('Admin ID not found');
        return;
    }

    form.put(route('admin.users.update', props.admin.id), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="এডমিন ইউজার সম্পাদনা করুন" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    এডমিন ইউজার সম্পাদনা করুন - {{ admin?.name || 'লোড হচ্ছে...' }}
                </h2>
                <Link :href="route('admin.users.index')"
                      class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ফিরে যান
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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

                            <!-- Password (Optional for editing) -->
                            <div class="mt-4">
                                <InputLabel for="password" value="নতুন পাসওয়ার্ড (ঐচ্ছিক)" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    placeholder="পাসওয়ার্ড পরিবর্তন করতে চাইলে লিখুন"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                                <p class="text-sm text-gray-600 mt-1">
                                    পাসওয়ার্ড পরিবর্তন না করতে চাইলে এই ফিল্ড খালি রাখুন
                                </p>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4" v-if="form.password">
                                <InputLabel for="password_confirmation" value="পাসওয়ার্ড নিশ্চিত করুন *" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password_confirmation"
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
                                    :disabled="admin?.role === 'super_admin'"
                                >
                                    <option value="super_admin" v-if="admin?.role === 'super_admin'">সুপার এডমিন</option>
                                    <option value="admin">এডমিন</option>
                                    <option value="moderator">মডারেটর</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.role" />
                                <p v-if="admin?.role === 'super_admin'" class="text-sm text-gray-600 mt-1">
                                    সুপার এডমিনের ভূমিকা পরিবর্তন করা যাবে না
                                </p>
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
                            </div>

                            <!-- Permissions -->
                            <div class="mt-6" v-if="form.role === 'moderator' && availablePermissions">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">মডারেটর অনুমতি</h3>
                                <div class="space-y-6 border rounded-lg p-6 bg-gray-50">
                                    <!-- Permission Modules -->
                                    <div v-for="(module, moduleKey) in availablePermissions" :key="moduleKey" class="space-y-3">
                                        <!-- Module Header -->
                                        <div class="flex items-center justify-between bg-white p-3 rounded-lg border">
                                            <h4 class="font-medium text-gray-900">{{ module.label }}</h4>
                                            <div class="flex items-center space-x-2">
                                                <span v-if="isModulePartiallySelected(moduleKey)"
                                                      class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">
                                                    আংশিক নির্বাচিত
                                                </span>
                                                <span v-else-if="isModuleFullySelected(moduleKey)"
                                                      class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                                                    সম্পূর্ণ নির্বাচিত
                                                </span>
                                                <button
                                                    type="button"
                                                    @click="toggleModulePermissions(moduleKey)"
                                                    class="text-sm text-indigo-600 hover:text-indigo-800 font-medium"
                                                >
                                                    {{ isModuleFullySelected(moduleKey) ? 'সব বাতিল' : 'সব নির্বাচন' }}
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Individual Permissions -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 ml-4">
                                            <div v-for="(permissionLabel, permissionKey) in module.permissions"
                                                 :key="permissionKey"
                                                 class="flex items-center space-x-2 p-2 bg-white rounded border">
                                                <input
                                                    type="checkbox"
                                                    :id="`${moduleKey}_${permissionKey}`"
                                                    :checked="form.permissions.includes(`${moduleKey}.${permissionKey}`)"
                                                    @change="togglePermission(`${moduleKey}.${permissionKey}`)"
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                />
                                                <label :for="`${moduleKey}_${permissionKey}`"
                                                       class="text-sm text-gray-700 cursor-pointer">
                                                    {{ permissionLabel }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Selected Permissions Summary -->
                                    <div v-if="form.permissions.length > 0" class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                        <h5 class="text-sm font-medium text-blue-900 mb-2">নির্বাচিত অনুমতিসমূহ ({{ form.permissions.length }}টি):</h5>
                                        <div class="flex flex-wrap gap-2">
                                            <span v-for="permission in form.permissions"
                                                  :key="permission"
                                                  class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                                {{ getPermissionLabel(permission.split('.')[0], permission.split('.')[1]) }}
                                                <button
                                                    type="button"
                                                    @click="removePermission(permission)"
                                                    class="ml-1 text-blue-600 hover:text-blue-800"
                                                >
                                                    ×
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div v-else class="text-sm text-gray-500 text-center py-4">
                                        কোনো অনুমতি নির্বাচিত নেই
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
                                        :disabled="admin?.role === 'super_admin'"
                                    />
                                    <span class="ml-2 text-sm text-gray-600">সক্রিয় অ্যাকাউন্ট</span>
                                </label>
                                <InputError class="mt-2" :message="form.errors.is_active" />
                                <p v-if="admin?.role === 'super_admin'" class="text-sm text-gray-600 mt-1">
                                    সুপার এডমিনের অ্যাকাউন্ট নিষ্ক্রিয় করা যাবে না
                                </p>
                            </div>

                            <!-- Admin Info -->
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">অতিরিক্ত তথ্য</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div>
                                        <strong>তৈরির তারিখ:</strong>
                                        {{ admin?.created_at ? new Date(admin.created_at).toLocaleDateString('bn-BD') : 'N/A' }}
                                    </div>
                                    <div>
                                        <strong>শেষ আপডেট:</strong>
                                        {{ admin?.updated_at ? new Date(admin.updated_at).toLocaleDateString('bn-BD') : 'N/A' }}
                                    </div>
                                    <div>
                                        <strong>শেষ লগইন:</strong>
                                        {{ admin?.last_login_at ? new Date(admin.last_login_at).toLocaleDateString('bn-BD') : 'কখনো লগইন করেনি' }}
                                    </div>
                                    <div>
                                        <strong>IP ঠিকানা:</strong>
                                        {{ admin?.last_login_ip || 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6 space-x-4">
                                <Link
                                    :href="route('admin.users.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900"
                                >
                                    বাতিল করুন
                                </Link>

                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    আপডেট করুন
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
