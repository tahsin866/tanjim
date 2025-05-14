<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    mobile_no: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);
const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div
    style="font-family: 'Merriweather','SolaimanLipi',sans-serif;"



    class="flex min-h-screen items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
        <Head title="Login to WEMS" />

        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="text-center p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-emerald-800 dark:text-emerald-200">মাদরাসা লগইন</h2>
            </div>

            <div class="p-6">
                <!-- Status Message -->
                <div v-if="status" class="mb-6 p-4 bg-emerald-50/80 dark:bg-emerald-900/80 rounded-lg border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ status }}</span>
                </div>

                <!-- Form Content -->
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Mobile Number Field -->
                    <div class="group">
                        <label for="mobile_no" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">মোবাইল নম্বর</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <input
                                id="mobile_no"
                                type="text"
                                v-model="form.mobile_no"
                                class="pl-10 block w-full rounded-md border-emerald-300 dark:border-emerald-700 focus:border-emerald-500 focus:ring-emerald-500 bg-white/50 dark:bg-gray-800/50 shadow-sm"
                                placeholder="০১XXXXXXXXX"
                                required
                                autofocus
                            />
                        </div>
                        <p v-if="form.errors.mobile_no" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.mobile_no }}</p>
                    </div>

                    <!-- Password Field with Show/Hide Toggle -->
                    <div class="group">
                        <label for="password" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">পাসওয়ার্ড</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                v-model="form.password"
                                class="pl-10 pr-10 block w-full rounded-md border-emerald-300 dark:border-emerald-700 focus:border-emerald-500 focus:ring-emerald-500 bg-white/50 dark:bg-gray-800/50 shadow-sm"
                                placeholder="আপনার পাসওয়ার্ড লিখুন"
                                required
                            />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button
                                    type="button"
                                    @click="togglePassword"
                                    class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300 focus:outline-none"
                                >
                                    <!-- Eye Icon (Show Password) -->
                                    <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    <!-- Eye-Slash Icon (Hide Password) -->
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ form.errors.password }}</p>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input
                                type="checkbox"
                                v-model="form.remember"
                                class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700"
                            />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">মনে রাখুন</span>
                        </label>
                        <Link
                            v-if="canResetPassword"
                            href="route('password.request')"
                            class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors duration-200"
                        >
                            পাসওয়ার্ড ভুলে গেছেন?
                        </Link>
                    </div>

                    <!-- Submit Button & Register Link -->
                    <div class="space-y-4">
                        <button
                            type="submit"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 text-lg font-medium"
                            :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
                            :disabled="form.processing"
                        >
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>প্রবেশ করুন</span>
                        </button>

                        <div class="relative flex items-center justify-center w-full mt-6">
                            <div class="w-full h-px bg-gray-200 dark:bg-gray-700"></div>
                            <div class="absolute px-3 font-medium text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-800">অথবা</div>
                        </div>

                        <div class="text-sm text-center text-gray-600 dark:text-gray-400 mt-6">
                            অ্যাকাউন্ট নেই?
                            <Link
                                :href="route('Auth.madrasha_check_for_user')"
                                class="font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors duration-200 ml-1"
                            >
                                নিবন্ধন করুন
                            </Link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
