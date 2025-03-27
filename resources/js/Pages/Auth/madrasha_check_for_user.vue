<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    ElhaqNo: '',
    Mobile: '',

});

const submit = () => {
    form.post(route('madrasha.check'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    });
};

</script>

<template>
    <GuestLayout>
        <Head title="madrasha_check_for_user" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="ElhaqNo" value="ইলহাক নম্বর" />

                <TextInput
                    id="ElhaqNo"
                    type="text"
                        class="mt-1 block w-full  rounded-sm"
                    v-model="form.ElhaqNo"
                    required
                    autofocus
                    autocomplete="ElhaqNo"
                />

                <InputError class="mt-2" :message="form.errors.ElhaqNo" />
            </div>

            <div>
                <InputLabel for="Mobile" value="মোবইল নম্বর" />

                <TextInput
                    id="Mobile"
                    type="text"
                    class="mt-1 block w-full  rounded-sm"
                    v-model="form.Mobile"
                    required
                    autofocus
                    autocomplete="Mobile"
                />

                <InputError class="mt-2" :message="form.errors.Mobile" />
            </div>


            <div class="mt-4 flex items-center justify-end">
                <!-- <Link
                    :href="route('admin.login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </Link> -->

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    অনুন্ধান করুন
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
