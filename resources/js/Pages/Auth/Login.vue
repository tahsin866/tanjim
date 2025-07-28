<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    phoneNumber: '',
    password: '',
    remember: false,
});

// Check if account is suspended based on error
const isSuspendedAccount = computed(() => {
    return form.errors.suspended ? true : false;
});

const showPassword = ref(false);
const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

// Body background always white and no margin
onMounted(() => {
    document.body.style.background = '#fff';
    document.body.style.margin = '0';
    document.documentElement.style.background = '#fff';
    document.documentElement.style.margin = '0';
});
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div
        style="background: #fff; font-family: 'Merriweather','SolaimanLipi',sans-serif;"
        class=" flex items-center justify-center p-0 bg-white"
    >
        <Head title="Login to WEMS" />

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
                <h2 class="text-2xl font-bold text-emerald-800 font-bangla">আবনা লগইন</h2>
            </div>

            <div class="p-6">
                <div v-if="status" class="mb-6 p-4 bg-emerald-50/80 rounded-lg border-l-4 border-emerald-500 text-emerald-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ status }}</span>
                </div>

                <!-- Suspended Account Error Message -->
                <div v-if="form.errors.suspended" class="mb-6 p-4 bg-red-50/80 rounded-lg border-l-4 border-red-500 text-red-700">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-bold font-bangla">অ্যাকাউন্ট সাসপেন্ড</span>
                    </div>
                    <p class="text-sm font-bangla">{{ form.errors.suspended }}</p>
                    <p class="text-xs mt-1 font-bangla">আরও তথ্যের জন্য প্রশাসনের সাথে যোগাযোগ করুন।</p>
                </div>

                <!-- General Login Error Message -->
                <div v-if="form.errors.email || form.errors.phoneNumber" class="mb-6 p-4 bg-red-50/80 rounded-lg border-l-4 border-red-500 text-red-700">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-bangla">লগইনে সমস্যা হয়েছে</span>
                    </div>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Mobile Number Field -->
                    <div class="group">
                        <label for="phone_number" class="block text-gray-700 font-medium mb-2 font-bangla">মোবাইল নম্বর</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <input
                                id="phone_number"
                                type="text"
                                v-model="form.phoneNumber"
                                class="pl-10 block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white/50 shadow-sm font-bangla"
                                :class="{ 'opacity-50 cursor-not-allowed': isSuspendedAccount }"
                                placeholder="০১XXXXXXXXX"
                                required
                                autofocus
                                :disabled="isSuspendedAccount"
                            />
                        </div>
                        <p v-if="form.errors.phoneNumber" class="mt-2 text-sm text-red-600">{{ form.errors.phoneNumber }}</p>
                    </div>

                    <!-- Password Field with Show/Hide Toggle -->
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
                                :type="showPassword ? 'text' : 'password'"
                                v-model="form.password"
                                class="pl-10 pr-10 block w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white/50 shadow-sm font-bangla"
                                :class="{ 'opacity-50 cursor-not-allowed': isSuspendedAccount }"
                                placeholder="আপনার পাসওয়ার্ড লিখুন"
                                required
                                :disabled="isSuspendedAccount"
                            />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button
                                    type="button"
                                    @click="togglePassword"
                                    class="text-emerald-600 hover:text-emerald-800 focus:outline-none"
                                >
                                    <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center" :class="{ 'opacity-50 cursor-not-allowed': isSuspendedAccount }">
                            <input
                                type="checkbox"
                                v-model="form.remember"
                                class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                :disabled="isSuspendedAccount"
                            />
                            <span class="ml-2 text-sm text-gray-600 font-bangla">মনে রাখুন</span>
                        </label>
                        <Link
                            v-if="canResetPassword && !isSuspendedAccount"
                            :href="route('password.request')"
                            class="text-sm text-emerald-600 hover:text-emerald-700 transition-colors duration-200 font-bangla"
                        >
                            পাসওয়ার্ড ভুলে গেছেন?
                        </Link>
                    </div>

                    <div class="space-y-4">
                        <button
                            type="submit"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 text-lg font-medium font-bangla"
                            :class="{
                                'opacity-75 cursor-not-allowed': form.processing || isSuspendedAccount,
                                'bg-red-500 hover:bg-red-600': isSuspendedAccount
                            }"
                            :disabled="form.processing || isSuspendedAccount"
                        >
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="font-bangla">
                                {{ isSuspendedAccount ? 'অ্যাকাউন্ট সাসপেন্ড' : 'প্রবেশ করুন' }}
                            </span>
                        </button>

                        <div class="relative flex items-center justify-center w-full mt-6">
                            <div class="w-full h-px bg-gray-200"></div>
                            <div class="absolute px-3 font-medium text-gray-500 bg-white font-bangla">অথবা</div>
                        </div>

                        <!-- <div class="text-sm text-center text-gray-600 mt-6 font-bangla" :class="{ 'opacity-50': isSuspendedAccount }">
                            অ্যাকাউন্ট নেই?
                            <Link
                                v-if="!isSuspendedAccount"
                                :href="route('register')"
                                class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors duration-200 ml-1 font-bangla"
                            >
                                নিবন্ধন করুন
                            </Link>
                            <span v-else class="font-medium text-gray-400 ml-1 font-bangla">
                                নিবন্ধন করুন
                            </span>
                        </div> -->
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
.logo-container {
    position: relative;
    transition: all 0.3s ease;
}
.logo-container:hover { transform: translateY(-2px); }
.font-bangla.text-emerald-800 { text-shadow: 0 2px 4px rgba(5, 150, 105, 0.1);}
.font-bangla.text-emerald-600 { text-shadow: 0 1px 2px rgba(5, 150, 105, 0.1);}
.group { position: relative; }
button[type="submit"] {
    background: linear-gradient(135deg, #059669, #10b981);
    transition: all 0.3s ease;
}
button[type="submit"]:hover {
    background: linear-gradient(135deg, #047857, #059669);
    transform: translateY(-1px);
    box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
}
img[alt*="তানযিমে"] {
    background: linear-gradient(135deg, #059669, #10b981, #34d399);
}
/* Remove all dark/gray backgrounds from main wrapper */
body, html, .min-h-screen, .bg-gray-800, .bg-gray-700, .bg-gray-200 {
    background: #fff !important;
    margin: 0 !important;
}
/* Remove margin from top so the login is perfectly centered vertically */
.flex.min-h-screen.items-center.justify-center {
    padding-top: 0 !important;
}
</style>
