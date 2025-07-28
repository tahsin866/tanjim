<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const form = useForm({
    email: '',
});

// Body background always white and no margin
onMounted(() => {
    document.body.style.background = '#fff';
    document.body.style.margin = '0';
    document.documentElement.style.background = '#fff';
    document.documentElement.style.margin = '0';
});

const submit = () => {
    form.post(route('password.email'), {
        onFinish: () => form.reset('email'),
    });
};
</script>

<template>
    <div
        style="background: #fff; font-family: 'Merriweather','SolaimanLipi',sans-serif;"
        class="min-h-screen flex items-center justify-center p-4 bg-white"
    >
        <Head title="পাসওয়ার্ড ভুলে গেছেন? - WEMS" />

        <div class="w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Logo Section -->
            <div class="text-center pt-8 pb-4">
                <div class="relative inline-block">
                    <div class="relative mx-auto w-32 h-32 mb-4">
                        <img
                            src="/images/tanjim.png"
                            alt="তানযিমে আবনায়ে ফরিদাবাদ"
                            class="w-full h-full object-cover rounded-full border-4 border-emerald-500 shadow-2xl hover:shadow-emerald-500/50 transition-all duration-500 hover:scale-105"
                            style="background: linear-gradient(135deg, #059669, #10b981, #34d399);"
                        />
                        <div class="absolute inset-0 rounded-full bg-emerald-400 opacity-20 blur-xl animate-pulse"></div>
                        <div class="absolute -inset-2 rounded-full border-2 border-emerald-300/30 animate-spin-slow"></div>
                        <div class="absolute -inset-1 rounded-full border border-emerald-400/40 animate-spin-reverse"></div>
                    </div>
                    <div class="space-y-2">
                        <h1 class="text-2xl font-bold text-emerald-800 font-bangla">তানযিমে আবনায়ে ফরিদাবাদ</h1>
                    </div>
                </div>
            </div>

            <div class="text-center px-6 pb-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-emerald-800 font-bangla">পাসওয়ার্ড ভুলে গেছেন?</h2>
                <p class="text-gray-600 mt-2 font-bangla">আপনার ইমেইল ঠিকানা দিন, আমরা আপনাকে একটি OTP পাঠাবো</p>
            </div>

            <div class="p-6">
                <!-- Error Messages -->
                <div v-if="form.errors.email" class="mb-6 p-4 bg-red-50/80 rounded-lg border-l-4 border-red-500 text-red-700">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-bangla">{{ form.errors.email }}</span>
                    </div>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Email Field -->
                    <div class="group">
                        <label for="email" class="block text-gray-700 font-medium mb-2 font-bangla">ইমেইল ঠিকানা</label>
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
                        <p class="mt-1 text-sm text-gray-500 font-bangla">আমরা আপনার এই ইমেইলে একটি OTP পাঠাবো</p>
                    </div>

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
                            OTP পাঠান
                        </button>

                        <div class="relative flex items-center justify-center w-full mt-6">
                            <div class="w-full h-px bg-gray-200"></div>
                            <div class="absolute px-3 font-medium text-gray-500 bg-white font-bangla">অথবা</div>
                        </div>

                        <div class="text-center space-y-2">
                            <div class="text-sm text-gray-600 font-bangla">
                                <Link
                                    :href="route('login')"
                                    class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors duration-200 font-bangla"
                                >
                                    ← লগইনে ফিরে যান
                                </Link>
                            </div>
                            <div class="text-sm text-gray-600 font-bangla">
                                অ্যাকাউন্ট নেই?
                                <Link
                                    :href="route('register')"
                                    class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors duration-200 ml-1 font-bangla"
                                >
                                    নিবন্ধন করুন
                                </Link>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Mukti:wght@400;500;600;700&display=swap');
@import url('https://fonts.maateen.me/kalpurush/font.css');

.font-bangla {
    font-family: 'Hind Siliguri', 'Kalpurush', 'SolaimanLipi', 'Mukti', 'SutonnyMJ', 'Nikosh', serif;
    line-height: 1.4;
    letter-spacing: 0.5px;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    font-weight: 500;
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
@keyframes spin-reverse {
    from { transform: rotate(360deg); }
    to { transform: rotate(0deg); }
}
.animate-spin-slow {
    animation: spin-slow 8s linear infinite;
}
.animate-spin-reverse {
    animation: spin-reverse 10s linear infinite;
}

button[type="submit"] {
    background: linear-gradient(135deg, #059669, #10b981);
    transition: all 0.3s ease;
}
button[type="submit"]:hover {
    background: linear-gradient(135deg, #047857, #059669);
    transform: translateY(-1px);
    box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
}

/* Remove all dark/gray backgrounds from main wrapper */
body, html, .min-h-screen, .bg-gray-800, .bg-gray-700, .bg-gray-200 {
    background: #fff !important;
    margin: 0 !important;
}
</style>
