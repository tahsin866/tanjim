<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    admin_Designation: '',
    email: '',
    password: '',
    password_confirmation: '',
    NID_no: '',
    Mobile_no: '',
});

const props = defineProps({
    success: {
        type: String,
        default: null
    },
    madrasha_name: {
        type: String,
        default: null
    },
    thana: {
        type: String,
        default: null
    },
    post: {
        type: String,
        default: null
    },
    custom_code: {
        type: String,
        default: null
    }
});


const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

        <Head title="Register" />
        <div

              style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
        class="min-h-screen bg-[#f8f9fa] py-12 ">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <form @submit.prevent="submit" class="bg-white rounded-sm shadow-lg p-8">
        <!-- Alert Message -->
        <div v-if="props.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
          <strong class="font-bold">{{ props.success }}</strong>
        </div>

        <!-- Madrasha Info Card -->
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">মাদরাসা তথ্য</h3>
          <div class="grid grid-cols-2 gap-4">
            <p><strong>মাদরাসার নাম:</strong> {{ props.madrasha_name }}</p>
            <p><strong>থানা:</strong> {{ props.thana }}</p>
            <p><strong>পোস্ট অফিস:</strong> {{ props.post }}</p>
            <p><strong>রেজিস্ট্রেশন কোড:</strong> {{ props.custom_code }}</p>
          </div>
        </div>

        <!-- Registration Form Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Left Column -->
          <div class="space-y-6">
            <div>
              <InputLabel for="name" class="text-lg font-medium" value="এডমিনের নাম" />
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

            <div>
              <InputLabel for="admin_Designation" class="text-lg font-medium" value="এডমিনের পদবি" />
              <TextInput
                id="admin_Designation"
                type="text"
                class="mt-1 block w-full"
                v-model="form.admin_Designation"
                required
                autocomplete="admin_Designation"
              />
              <InputError class="mt-2" :message="form.errors.admin_Designation" />
            </div>

            <div>
              <InputLabel for="NID_no" class="text-lg font-medium" value="জাতীয় পরিচয়পত্র নম্বর" />
              <TextInput
                id="NID_no"
                type="text"
                class="mt-1 block w-full"
                v-model="form.NID_no"
                required
                autocomplete="NID_no"
              />
              <InputError class="mt-2" :message="form.errors.NID_no" />
            </div>

            <div>
              <InputLabel for="Mobile_no" class="text-lg font-medium" value="এডমিনের হোয়াটস এপ নম্বর" />
              <TextInput
                id="Mobile_no"
                type="text"
                class="mt-1 block w-full"
                v-model="form.Mobile_no"
                required
                autocomplete="Mobile_no"
              />
              <InputError class="mt-2" :message="form.errors.Mobile_no" />
            </div>
          </div>

          <!-- Right Column -->
          <div class="space-y-6">
            <div>
              <InputLabel for="email" class="text-lg font-medium" value="এডমিনের ইমেইল" />
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

            <div>
              <InputLabel for="password" class="text-lg font-medium" value="পাসওয়ার্ড দিন" />
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

            <div>
              <InputLabel for="password_confirmation" class="text-lg font-medium" value="পুনরায় পাসওয়ার্ড দিন" />
              <TextInput
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password_confirmation"
                required
                autocomplete="new-password"
              />
              <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end space-x-4">
          <Link
            :href="route('admin.login')"
            class="text-emerald-600 hover:text-emerald-800 font-medium transition-colors"
          >
            Already registered?
          </Link>

          <PrimaryButton
            class="px-6 py-2.5"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Register
          </PrimaryButton>
        </div>
      </form>
    </div>
  </div>


</template>
