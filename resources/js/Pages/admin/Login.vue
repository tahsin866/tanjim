<script setup>
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
        onSuccess: (page) => {
            // If token exists in response, save to localStorage
            if (page.props && page.props.token) {
                localStorage.setItem('admin_token', page.props.token);
            }
        },
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="তানজিম এডমিন পেনেল" />

    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
                <div class="text-center pt-8 pb-4">
                    <div class="relative inline-block">
                        <div class="relative mx-auto w-32 h-32 mb-4">
                            <img
                                src="/images/tanjim.png"
                                alt="তানযিমে আবনায়ে ফরিদাবাদ"
                                class="w-full h-full object-cover rounded-full border-4 border-emerald-500 shadow-2xl transition-all duration-500"
                            />
                        </div>
                        <div class="space-y-2">
                            <h1 class="text-2xl font-bold text-emerald-800 dark:text-emerald-300 font-bangla">তানযিমে আবনায়ে ফরিদাবাদ</h1>
                        </div>
                    </div>
                </div>

                <div class="text-center px-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-emerald-800 dark:text-emerald-300 font-bangla">এডমিন লগইন</h2>
                </div>

                <div class="px-6 py-8">
                    <div v-if="status" class="mb-6 p-4 bg-emerald-50 dark:bg-gray-700 rounded-lg border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ status }}</span>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label for="email" class="block text-gray-700 dark:text-gray-200 font-medium mb-2 font-bangla">ইমেইল</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input
                                    id="email"
                                    type="email"
                                    v-model="form.email"
                                    class="pl-10 block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white dark:bg-gray-900 dark:text-gray-100 shadow-sm font-bangla"
                                    placeholder="আপনার ইমেইল ঠিকানা"
                                    required
                                    autofocus
                                />
                            </div>
                            <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
                        </div>

                        <div>
                            <label for="password" class="block text-gray-700 dark:text-gray-200 font-medium mb-2 font-bangla">পাসওয়ার্ড</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    v-model="form.password"
                                    class="pl-10 block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white dark:bg-gray-900 dark:text-gray-100 shadow-sm font-bangla"
                                    placeholder="আপনার পাসওয়ার্ড লিখুন"
                                    required
                                />
                            </div>
                            <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    v-model="form.remember"
                                    class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-200 font-bangla">মনে রাখুন</span>
                            </label>
                            <Link
                                :href="route('admin.password.request')"
                                class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition duration-200 font-bangla"
                            >
                                পাসওয়ার্ড ভুলে গেছেন?
                            </Link>
                        </div>

                        <div class="space-y-4">
                            <button
                                type="submit"
                                class="w-full py-3 px-4 rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-300 font-bangla
                                    dark:bg-emerald-500 dark:hover:bg-emerald-600 dark:text-gray-900 dark:focus:ring-emerald-400"
                                :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                            >
                                <span class="font-bangla">প্রবেশ করুন</span>
                            </button>

                            <div class="text-sm text-center text-gray-600 dark:text-gray-300 mt-6 font-bangla">
                                অ্যাকাউন্ট নেই?
                                <!-- <Link
                                    :href="route('admin.register')"
                                    class="font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition duration-200 ml-1 font-bangla"
                                >
                                    নিবন্ধন করুন
                                </Link> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
