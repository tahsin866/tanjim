<script setup>
import GuestLayout from '@/Layouts/admin/GuestLayout.vue';
import InputError from '@/Components/admin/InputError.vue';
import InputLabel from '@/Components/admin/InputLabel.vue';
import PrimaryButton from '@/Components/admin/PrimaryButton.vue';
import TextInput from '@/Components/admin/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'super_admin', // Default role
    department: '',
    designation: '',
    phone: '',
});

const submit = () => {
    form.post(route('admin.register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="এডমিন নিবন্ধন" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="নাম" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="ইমেইল" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="পাসওয়ার্ড" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="পাসওয়ার্ড নিশ্চিত করুন"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <!-- Optional Fields -->
            <div class="mt-4">
                <InputLabel for="department" value="বিভাগ (ঐচ্ছিক)" />

                <TextInput
                    id="department"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.department"
                    autocomplete="organization"
                />

                <InputError class="mt-2" :message="form.errors.department" />
            </div>

            <div class="mt-4">
                <InputLabel for="designation" value="পদবি (ঐচ্ছিক)" />

                <TextInput
                    id="designation"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.designation"
                    autocomplete="organization-title"
                />

                <InputError class="mt-2" :message="form.errors.designation" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="ফোন নম্বর (ঐচ্ছিক)" />

                <TextInput
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    autocomplete="tel"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('admin.login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                >
                    ইতিমধ্যে নিবন্ধিত?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    নিবন্ধন করুন
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
