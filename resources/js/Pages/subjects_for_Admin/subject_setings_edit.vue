<template>
    <AuthenticatedLayout>
        <div class="p-6 bg-white shadow-md rounded-sm border-t-4 border-emerald-600 mx-5 mt-5">
            <div class="mb-6 text-center relative">
                <div class="absolute inset-0 bg-emerald-50 opacity-25"></div>
                <h2 class="text-2xl font-bold text-emerald-800 py-3">
                    {{ isEditMode ? 'বিষয় তথ্য সম্পাদনা' : 'বিষয় তথ্য সংযোজন' }}
                </h2>
            </div>

            <div v-if="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ successMessage }}
            </div>

            <form @submit.prevent="submit" class="grid grid-cols-4 gap-6">
                <!-- মারহালার নাম -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">মারহালার নাম</label>
                    <input type="text"
                           :value="marhalaName"
                           readonly
                           class="w-full border-emerald-200 rounded-sm py-2 px-3 bg-emerald-50" />
                </div>

                <!-- বিষয় -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">বিষয় নির্বাচন করুন *</label>
                    <select v-model="form.subject_id"
                            class="w-full border-emerald-200 rounded-sm py-2 px-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50 text-gray-700"
                            :disabled="isEditMode">
                        <option value="" class="text-gray-700">নির্বাচন করুন</option>
                        <option v-for="subject in subjects"
                                :key="subject.id"
                                :value="subject.id"
                                class="text-gray-700">
                            {{ subject.name_bangla }}
                        </option>
                    </select>
                </div>

                <!-- সিলেবাসের ধরন -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">সিলেবাসের ধরন *</label>
                    <select v-model="form.syllabus_type"
                            class="w-full border-emerald-200 rounded-sm py-2 px-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
                        <option value="">নির্বাচন করুন</option>
                        <option value="আবশ্যিক">আবশ্যিক</option>
                        <option value="নৈর্বাচনিক">নৈর্বাচনিক</option>
                    </select>
                </div>

                <!-- মারকাযের ধরন -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">মারকাযের ধরন *</label>
                    <select v-model="form.markaz_type"
                            class="w-full border-emerald-200 rounded-sm py-2 px-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
                        <option value="">নির্বাচন করুন</option>
                        <option value="দরসিয়াত">দরসিয়াত</option>
                        <option value="হিফজুল কোরআন">হিফজুল কোরআন</option>
                        <option value="কিরাআত">কিরাআত</option>
                    </select>
                </div>

                <!-- বিষয়ের ধরন -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">বিষয়ের ধরন *</label>
                    <select v-model="form.subject_type"
                            class="w-full border-emerald-200 rounded-sm py-2 px-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
                        <option value="">নির্বাচন করুন</option>
                        <option value="মি'ইয়ারী">মি'ইয়ারী</option>
                        <option value="গায়রে মি'ইয়ারী">গায়রে মি'ইয়ারী</option>
                    </select>
                </div>

                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">ছাত্র/ছাত্রীর ধরন *</label>
                    <select v-model="form.student_type"
                            class="w-full border-emerald-200 rounded-sm py-2 px-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
                        <option value="">নির্বাচন করুন</option>
                        <option value="ছাত্র">ছাত্র</option>
                        <option value="ছাত্রী">ছাত্রী</option>
                        <option value="উভয়">উভয়</option>
                    </select>
                </div>

                <!-- মোট মার্ক -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">মোট মার্ক *</label>
                    <input type="number"
                           v-model="form.total_marks"
                           class="w-full border-emerald-200 rounded-sm py-2 px-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50" />
                </div>

                <!-- পাশ মার্ক -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">পাশ মার্ক *</label>
                    <input type="number"
                           v-model="form.pass_marks"
                           class="w-full border-emerald-200 rounded-sm py-2 px-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50" />
                </div>

                <!-- স্ট্যাটাস -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">স্ট্যাটাস *</label>
                    <select v-model="form.status"
                            class="w-full border-emerald-200 rounded-sm py-2 px-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50">
                        <option value="active">সক্রিয়</option>
                        <option value="inactive">নিষ্ক্রিয়</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-span-4 flex justify-end mt-4">
                    <button type="submit"
                            :disabled="form.processing"
                            class="bg-emerald-600 text-white py-2 px-6 rounded-md hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2 shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ form.processing ? 'সংরক্ষণ হচ্ছে...' : (isEditMode ? 'আপডেট করুন' : 'সংরক্ষণ করুন') }}
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue'
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import { useForm } from '@inertiajs/vue3'

const marhala = ref({})
const subjects = ref([])
const loading = ref(true)
const successMessage = ref('')

// Check if we're in edit mode
const isEditMode = computed(() => !!route().params.id)
const marhalaName = computed(() => marhala.value?.marhala_name_bn || '')

const form = useForm({
    id: null,
    marhala_id: route().params.marhala,
    subject_id: '',
    Marhala_type: '',
    Subject_Names: '',
    student_type: '',
    syllabus_type: '',
    markaz_type: '',
    subject_type: '',
    subject_code: '',
    total_marks: '',
    pass_marks: '',
    status: 'active'
});

const fetchData = async () => {
    try {
        // সঠিক API এন্ডপয়েন্ট ব্যবহার করুন
        const response = await axios.get(`/api/subject-settings/${id}`);
        // ডাটা প্রসেস করুন
        console.log("API response:", response.data);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

const fetchSubjectSetting = async (id) => {
    try {
        const response = await axios.get(`/api/subject-settings/${id}`);
        const data = response.data.subjectSetting;

        // Populate the form with existing data
        form.id = data.id;
        form.marhala_id = data.marhala_id;
        form.subject_id = data.subject_id;
        form.Marhala_type = data.Marhala_type;
        form.Subject_Names = data.Subject_Names;
        form.student_type = data.student_type;
        form.syllabus_type = data.syllabus_type;
        form.markaz_type = data.markaz_type;
        form.subject_type = data.subject_type;
        form.subject_code = data.subject_code;
        form.total_marks = data.total_marks;
        form.pass_marks = data.pass_marks;
        form.status = data.status;
    } catch (error) {
        console.error('Error fetching subject setting:', error);
    }
};

const submit = async () => {
    try {
        let response;

        if (isEditMode.value) {
            // Update existing record
            response = await axios.put(`/api/subject-settings/${form.id}`, form);
        } else {
            // Create new record
            response = await axios.post(route('subject-settings.store'), form);
        }

        if (response.data.success) {
            const marhalaId = form.marhala_id;

            if (!isEditMode.value) {
                // Only reset form for new entries
                form.reset();
                form.marhala_id = marhalaId;
            }

            // Show success message
            successMessage.value = response.data.message;

            // Clear success message after 3 seconds
            setTimeout(() => {
                successMessage.value = '';
            }, 3000);

            // Refresh data if needed
            if (!isEditMode.value) {
                await fetchData(marhalaId);
            }
        }
    } catch (error) {
        if (error.response?.data?.errors) {
            // Handle validation errors
            console.error('Validation errors:', error.response.data.errors);
        } else {
            console.error('Error saving data:', error);
        }
    }
};

watch(() => form.subject_id, (newValue) => {
    if (newValue) {
        const selectedSubject = subjects.value.find(subject => subject.id === parseInt(newValue));
        if (selectedSubject) {
            form.Subject_Names = selectedSubject.name_bangla;
            form.subject_code = selectedSubject.subject_code;
            form.Marhala_type = marhala.value.marhala_name_bn;
        }
    }
});

onMounted(async () => {
    const marhalaId = route().params.marhala;
    await fetchData(marhalaId);

    if (isEditMode.value) {
        await fetchSubjectSetting(route().params.id);
    }
});
</script>

<style scoped>
/* Your styles here */
</style>
