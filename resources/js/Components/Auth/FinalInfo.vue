<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';

// Props
const props = defineProps({
    form: {
        type: Object,
        required: true
    }
});

// Emits
const emit = defineEmits(['submit']);

const handleSubmit = () => {
    emit('submit');
};
</script>

<template>
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">নিরাপত্তা ও অতিরিক্ত তথ্য</h3>

        <!-- পাসওয়ার্ড এবং কনফার্ম পাসওয়ার্ড -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <InputLabel for="password" class="text-lg font-medium" value="পাসওয়ার্ড" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    placeholder="নিরাপদ পাসওয়ার্ড লিখুন"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="password_confirmation" class="text-lg font-medium" value="পাসওয়ার্ড নিশ্চিত করুন" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    placeholder="পাসওয়ার্ড পুনরায় লিখুন"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4">
            <Link
                :href="route('login')"
                class="text-emerald-600 hover:text-emerald-800 font-medium transition-colors underline"
            >
                ইতিমধ্যে রেজিস্ট্রেশন করেছেন? লগইন করুন
            </Link>
            <PrimaryButton
                @click="handleSubmit"
                class="px-8 py-3 text-lg font-semibold"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                <span v-if="form.processing" class="mr-2">
                    <svg class="animate-spin h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                {{ form.processing ? 'রেজিস্ট্রেশন হচ্ছে...' : 'রেজিস্ট্রেশন করুন' }}
            </PrimaryButton>
        </div>
    </div>
</template>
