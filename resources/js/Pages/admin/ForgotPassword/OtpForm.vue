<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted, computed, nextTick } from 'vue';

const props = defineProps({
    email: String,
});

const page = usePage();

const form = useForm({
    email: props.email,
    otp: '',
});

const resendForm = useForm({
    email: props.email,
});

const otpInputs = ref([]);
const countdown = ref(0);
const canResend = computed(() => countdown.value === 0);

// Auto-focus and handle OTP input
const handleOtpInput = (index, event) => {
    const value = event.target.value.replace(/[^0-9]/g, '');

    if (value.length > 1) {
        // If multiple digits are pasted, split them
        const digits = value.slice(0, 6).split('');
        digits.forEach((digit, i) => {
            if (index + i < 6) {
                otpInputs.value[index + i].value = digit;
            }
        });
        // Focus on the next empty input or the last one
        const nextIndex = Math.min(index + digits.length, 5);
        otpInputs.value[nextIndex].focus();
    } else if (value.length === 1) {
        event.target.value = value;
        // Move to next input
        if (index < 5) {
            otpInputs.value[index + 1].focus();
        }
    }

    updateOtpForm();
};

const handleKeydown = (index, event) => {
    if (event.key === 'Backspace' && !event.target.value && index > 0) {
        otpInputs.value[index - 1].focus();
    }
    if (event.key === 'ArrowLeft' && index > 0) {
        otpInputs.value[index - 1].focus();
    }
    if (event.key === 'ArrowRight' && index < 5) {
        otpInputs.value[index + 1].focus();
    }
};

const updateOtpForm = () => {
    form.otp = otpInputs.value.map(input => input.value).join('');
};

const startCountdown = () => {
    countdown.value = 60;
    const timer = setInterval(() => {
        countdown.value--;
        if (countdown.value === 0) {
            clearInterval(timer);
        }
    }, 1000);
};

const resendOtp = () => {
    if (!canResend.value) return;

    resendForm.post(route('admin.password.resend'), {
        onSuccess: () => {
            startCountdown();
        },
    });
};

// Body background always white and no margin
onMounted(() => {
    document.body.style.background = '#fff';
    document.body.style.margin = '0';
    document.documentElement.style.background = '#fff';
    document.documentElement.style.margin = '0';

    // Start countdown on mount
    startCountdown();

    // Focus first input
    nextTick(() => {
        if (otpInputs.value[0]) {
            otpInputs.value[0].focus();
        }
    });
});

const submit = () => {
    if (form.otp.length === 6) {
        form.post(route('admin.password.verify'));
    }
};
</script>

<template>
    <div
        style="background: #fff; font-family: 'Merriweather','SolaimanLipi',sans-serif;"
        class="min-h-screen flex items-center justify-center p-4 bg-white"
    >
        <Head title="এডমিন OTP যাচাই করুন - WEMS" />

        <div class="w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Logo Section -->
            <div class="text-center pt-8 pb-4">
                <div class="relative inline-block">
                    <!-- Admin Badge -->
                    <div class="flex justify-center mb-4">
                        <div class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold font-bangla">
                            এডমিন প্যানেল
                        </div>
                    </div>
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
                <h2 class="text-2xl font-bold text-emerald-800 font-bangla">এডমিন OTP যাচাই করুন</h2>
                <p class="text-gray-600 mt-2 font-bangla">
                    আমরা <span class="font-semibold text-emerald-600">{{ email }}</span> এ একটি ৬-ডিজিটের কোড পাঠিয়েছি
                </p>
            </div>

            <div class="p-6">
                <!-- Success Message -->
                <div v-if="page.props.flash?.success" class="mb-6 p-4 bg-emerald-50/80 rounded-lg border-l-4 border-emerald-500 text-emerald-700">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-bangla">{{ page.props.flash.success }}</span>
                    </div>
                </div>

                <!-- Error Messages -->
                <div v-if="form.errors.otp" class="mb-6 p-4 bg-red-50/80 rounded-lg border-l-4 border-red-500 text-red-700">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-bangla">{{ form.errors.otp }}</span>
                    </div>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- OTP Input -->
                    <div class="group">
                        <label class="block text-gray-700 font-medium mb-4 text-center font-bangla">OTP কোড লিখুন</label>
                        <div class="flex justify-center space-x-2 mb-4">
                            <input
                                v-for="i in 6"
                                :key="i"
                                :ref="el => otpInputs[i-1] = el"
                                type="text"
                                maxlength="1"
                                class="w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500 transition-colors duration-200"
                                @input="handleOtpInput(i-1, $event)"
                                @keydown="handleKeydown(i-1, $event)"
                                autocomplete="off"
                            />
                        </div>
                        <p class="text-center text-sm text-gray-500 font-bangla">
                            কোড ১০ মিনিটের জন্য বৈধ
                        </p>
                    </div>

                    <!-- Resend OTP Section -->
                    <div class="text-center border-t pt-4">
                        <p class="text-sm text-gray-600 font-bangla mb-2">কোড পাননি?</p>
                        <button
                            type="button"
                            @click="resendOtp"
                            :disabled="!canResend || resendForm.processing"
                            class="text-emerald-600 hover:text-emerald-700 font-medium font-bangla transition-colors duration-200"
                            :class="{ 'opacity-50 cursor-not-allowed': !canResend || resendForm.processing }"
                        >
                            <span v-if="resendForm.processing">পাঠানো হচ্ছে...</span>
                            <span v-else-if="!canResend">{{ countdown }} সেকেন্ড পরে আবার পাঠান</span>
                            <span v-else>আবার OTP পাঠান</span>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <button
                            type="submit"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 text-lg font-medium font-bangla"
                            :class="{ 'opacity-75 cursor-not-allowed': form.processing || form.otp.length !== 6 }"
                            :disabled="form.processing || form.otp.length !== 6"
                        >
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            যাচাই করুন
                        </button>

                        <div class="relative flex items-center justify-center w-full mt-6">
                            <div class="w-full h-px bg-gray-200"></div>
                            <div class="absolute px-3 font-medium text-gray-500 bg-white font-bangla">অথবা</div>
                        </div>

                        <div class="text-center space-y-2">
                            <div class="text-sm text-gray-600 font-bangla">
                                <Link
                                    :href="route('admin.password.request')"
                                    class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors duration-200 font-bangla"
                                >
                                    ← ইমেইল পরিবর্তন করুন
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
button[type="submit"]:hover:not(:disabled) {
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
