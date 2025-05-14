<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Message from 'primevue/message';

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
    <Head title="madrasha_check_for_user" />

    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
        <div class="w-full max-w-md">
            <Card class="p-4 shadow-md">
                <template #title>
                    <div class="text-center text-xl font-bold text-emerald-700 mb-4">
                        মাদরাসা তথ্য অনুসন্ধান
                    </div>
                </template>
                <template #content>
                    <form @submit.prevent="submit">
                        <div class="field mb-4">
                            <label for="ElhaqNo" class="block text-sm font-medium text-gray-700 mb-1">ইলহাক নম্বর</label>
                            <span class="p-input-icon-left w-full">
                                <i class="pi pi-id-card" />
                                <InputText
                                    id="ElhaqNo"
                                    v-model="form.ElhaqNo"
                                    placeholder="ইলহাক নম্বর লিখুন"
                                    class="w-full p-inputtext-sm"
                                    required
                                    autofocus
                                />
                            </span>
                            <Message v-if="form.errors.ElhaqNo" severity="error" :text="form.errors.ElhaqNo" class="mt-2 w-full" />
                        </div>
                        <div class="field mb-4">
                            <label for="Mobile" class="block text-sm font-medium text-gray-700 mb-1">মোবাইল নম্বর</label>
                            <span class="p-input-icon-left w-full">
                                <i class="pi pi-mobile" />
                                <InputText
                                    id="Mobile"
                                    v-model="form.Mobile"
                                    placeholder="মোবাইল নম্বর লিখুন"
                                    class="w-full p-inputtext-sm"
                                    required
                                />
                            </span>
                            <Message v-if="form.errors.Mobile" severity="error" :text="form.errors.Mobile" class="mt-2 w-full" />
                        </div>
                        <div class="flex justify-end mt-6">
                            <Button
                                type="submit"
                                label="অনুসন্ধান করুন"
                                icon="pi pi-search"
                                severity="success"
                                :loading="form.processing"
                                :disabled="form.processing"
                                class="p-button-sm"
                            />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </div>
</template>

<style scoped>
.p-card {
    font-family: 'SolaimanLipi', Arial, sans-serif;
}
.p-button {
    font-family: 'SolaimanLipi', Arial, sans-serif;
}
.p-inputtext {
    font-family: 'SolaimanLipi', Arial, sans-serif;
}
</style>
