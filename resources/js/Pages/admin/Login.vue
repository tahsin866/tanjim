<script setup>
import Checkbox from '@/Components/admin/Checkbox.vue';
import GuestLayout from '@/Layouts/admin/GuestLayout.vue';
import InputError from '@/Components/admin/InputError.vue';
import InputLabel from '@/Components/admin/InputLabel.vue';
import PrimaryButton from '@/Components/admin/PrimaryButton.vue';
import TextInput from '@/Components/admin/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('admin.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login to WEMS" />




        <!-- Enhanced Islamic Header -->
        <div
        style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
        class="text-center mb-8">
            <div class="arabic-pattern h-16 mb-4"></div>

            <h2 class="text-xl text-gray-700 dark:text-gray-300 font-semibold">মাদরাসা পেনেল</h2>
        </div>


        <!-- Status Message -->
        <div v-if="status" class="mb-4 p-4 bg-emerald-50/80 dark:bg-emerald-900/80 rounded-lg text-emerald-700 dark:text-emerald-300">
            {{ status }}
        </div>

        <!-- Form Content -->
        <form @submit.prevent="submit"
              style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
        class="space-y-6">
            <!-- Email Field -->
            <div>
                <InputLabel for="email" value="ইমেইল" class="text-gray-700 dark:text-gray-300" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full rounded-md border-emerald-300 dark:border-emerald-700 focus:border-emerald-500 focus:ring-emerald-500 bg-white/50 dark:bg-gray-800/50"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div>
                <InputLabel for="password" value="পাসওয়ার্ড" class="text-gray-700 dark:text-gray-300" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full rounded-lg border-emerald-300 dark:border-emerald-700 focus:border-emerald-500 focus:ring-emerald-500 bg-white/50 dark:bg-gray-800/50"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>


            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" class="text-emerald-600" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">মনে রাখুন</span>
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300"
                >
                    পাসওয়ার্ড ভুলে গেছেন?
                </Link>
            </div>

            <!-- Submit Button & Register Link -->
            <div class="flex flex-col space-y-4">
                <PrimaryButton
                    class="w-full justify-center py-3 bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500 transition-all duration-300"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    প্রবেশ করুন
                </PrimaryButton>

                <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                    অ্যাকাউন্ট নেই?
                    <Link
                        :href="route('admin.register')"
                        class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300"
                    >
                        নিবন্ধন করুন
                    </Link>
                </div>
            </div>
        </form>




    </GuestLayout>
</template>
