<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
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
    <Head title="Login to WEMS" />

    <!-- Main container with centered content -->
    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">

                <!-- Logo Section -->
                <div class="text-center pt-8 pb-4">
                    <div class="relative inline-block">
                        <!-- Main Logo with Enhanced Styling -->
                        <div class="relative mx-auto w-32 h-32 mb-4">
                            <img
                                src="/images/tanjim.png"
                                alt="তানযিমে আবনায়ে ফরিদাবাদ"
                                class="w-full h-full object-cover rounded-full border-4 border-emerald-500 shadow-2xl hover:shadow-emerald-500/50 transition-all duration-500 hover:scale-105"
                                style="background: linear-gradient(135deg, #059669, #10b981, #34d399);"
                            />
                            <!-- Glow Effect Behind Logo -->
                            <div class="absolute inset-0 rounded-full bg-emerald-400 opacity-20 blur-xl animate-pulse"></div>

                            <!-- Decorative Ring Around Logo -->
                            <div class="absolute -inset-2 rounded-full border-2 border-emerald-300/30 animate-spin-slow"></div>
                            <div class="absolute -inset-1 rounded-full border border-emerald-400/40 animate-spin-reverse"></div>
                        </div>

                        <!-- Organization Name -->
                        <div class="space-y-2">
                            <h1 class="text-2xl font-bold text-emerald-800 font-bangla">
                                তানযিমে আবনায়ে ফরিদাবাদ
                            </h1>

                        </div>
                    </div>
                </div>

                <!-- Header -->
                <div class="text-center px-6 pb-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-emerald-800 font-bangla">এডমিন লগইন</h2>
                </div>

                <div class="px-6 py-8">
                    <!-- Status Message -->
                    <div v-if="status" class="mb-6 p-4 bg-emerald-50/80 rounded-lg border-l-4 border-emerald-500 text-emerald-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ status }}</span>
                    </div>

                    <!-- Form Content -->
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Email Field -->
                        <div class="group">
                            <label for="email" class="block text-gray-700 font-medium mb-2 font-bangla">ইমেইল</label>
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
                                    class="pl-10 block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white/50 shadow-sm font-bangla"
                                    placeholder="আপনার ইমেইল ঠিকানা"
                                    required
                                    autofocus
                                />
                            </div>
                            <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
                        </div>

                        <!-- Password Field -->
                        <div class="group">
                            <label for="password" class="block text-gray-700 font-medium mb-2 font-bangla">পাসওয়ার্ড</label>
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
                                    class="pl-10 block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white/50 shadow-sm font-bangla"
                                    placeholder="আপনার পাসওয়ার্ড লিখুন"
                                    required
                                />
                            </div>
                            <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    v-model="form.remember"
                                    class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                />
                                <span class="ml-2 text-sm text-gray-600 font-bangla">মনে রাখুন</span>
                            </label>
                            <Link
                                :href="route('admin.password.request')"
                                class="text-sm text-emerald-600 hover:text-emerald-700 transition-colors duration-200 font-bangla"
                            >
                                পাসওয়ার্ড ভুলে গেছেন?
                            </Link>
                        </div>

                        <!-- Submit Button & Register Link -->
                        <div class="space-y-4">
                            <button
                                type="submit"
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 text-lg font-medium font-bangla"
                                :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                            >
                                <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="font-bangla">প্রবেশ করুন</span>
                            </button>

                            <div class="relative flex items-center justify-center w-full mt-6">
                                <div class="w-full h-px bg-gray-200"></div>
                                <div class="absolute px-3 font-medium text-gray-500 bg-white font-bangla">অথবা</div>
                            </div>

                            <div class="text-sm text-center text-gray-600 mt-6 font-bangla">
                                অ্যাকাউন্ট নেই?
                                <Link
                                    :href="route('admin.register')"
                                    class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors duration-200 ml-1 font-bangla"
                                >
                                    নিবন্ধন করুন
                                </Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Kalpurush&display=swap');

.font-bangla {
    font-family: 'Hind Siliguri', 'Kalpurush', 'SolaimanLipi', sans-serif;
}

/* Custom animations for enhanced UI */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes spin-reverse {
    from { transform: rotate(360deg); }
    to { transform: rotate(0deg); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-spin-slow {
    animation: spin-slow 8s linear infinite;
}

.animate-spin-reverse {
    animation: spin-reverse 6s linear infinite;
}

/* Enhanced form field focus effects */
.group input:focus {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.15);
}

/* Custom button hover effects */
button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.25);
}

/* Logo glow effect */
.logo-glow {
    filter: drop-shadow(0 0 20px rgba(16, 185, 129, 0.3));
}

/* Smooth transitions for all elements */
* {
    transition: all 0.3s ease;
}
</style>
