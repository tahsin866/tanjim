<template>
  <AuthenticatedLayout>
        <div class="p-6 bg-white shadow-md rounded-sm border-t-4 border-emerald-600 mx-5 mt-5">
            <div class="mb-6 text-center relative">
                <div class="absolute inset-0 bg-emerald-50 opacity-25"></div>
                <h2 class="text-2xl font-bold text-emerald-800 py-3">বিষয় তথ্য আপডেট</h2>
            </div>
            <form @submit.prevent="submit" class="grid grid-cols-4 gap-6">
                <!-- মারহালার নাম -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">মারহালার নাম</label>
                    <InputText
                        :value="marhalaName"
                        readonly
                        class="w-full bg-emerald-50" />
                </div>

                <!-- বিষয় -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">বিষয় নির্বাচন করুন *</label>
                    <Dropdown
                        v-model="form.subject_id"
                        :options="subjects"
                        optionLabel="name_bangla"
                        optionValue="id"
                        placeholder="নির্বাচন করুন"
                        class="w-full bg-emerald-50" />
                </div>

                <!-- সিলেবাসের ধরন -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">সিলেবাসের ধরন *</label>
                    <Dropdown
                        v-model="form.syllabus_type"
                        :options="[
                            { label: 'আবশ্যিক', value: 'আবশ্যিক' },
                            { label: 'নৈর্বাচনিক', value: 'নৈর্বাচনিক' }
                        ]"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="নির্বাচন করুন"
                        class="w-full bg-emerald-50" />
                </div>

                <!-- মারকাযের ধরন -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">মারকাযের ধরন *</label>
                    <Dropdown
                        v-model="form.markaz_type"
                        :options="[
                            { label: 'দরসিয়াত', value: 'দরসিয়াত' },
                            { label: 'হিফজুল কোরআন', value: 'হিফজুল কোরআন' },
                            { label: 'কিরাআত', value: 'কিরাআত' }
                        ]"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="নির্বাচন করুন"
                        class="w-full bg-emerald-50" />
                </div>

                <!-- বিষয়ের ধরন -->
          <!-- বিষয়ের ধরন -->
<div class="col-span-1">
    <label class="block text-sm font-semibold text-emerald-800 mb-2">বিষয়ের ধরন *</label>
    <Dropdown
        v-model="form.subject_type"
        :options="[
            { label: 'মিইয়ারী', value: 'মিইয়ারী' },
            { label: 'গায়রে মিইয়ারী', value: 'গায়রে মিইয়ারী' }
        ]"
        optionLabel="label"
        optionValue="value"
        placeholder="নির্বাচন করুন"
        class="w-full bg-emerald-50" />
</div>


                <!-- ছাত্র/ছাত্রীর ধরন -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">ছাত্র/ছাত্রীর ধরন *</label>
                    <Dropdown
                        v-model="form.student_type"
                        :options="[
                            { label: 'ছাত্র', value: 'ছাত্র' },
                            { label: 'ছাত্রী', value: 'ছাত্রী' },
                            { label: 'উভয়', value: 'উভয়' }
                        ]"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="নির্বাচন করুন"
                        class="w-full bg-emerald-50" />
                </div>

                <!-- মোট মার্ক -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">মোট মার্ক *</label>
                    <InputNumber
                        v-model="form.total_marks"
                        class="w-full bg-emerald-50" />
                </div>

                <!-- পাশ মার্ক -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">পাশ মার্ক *</label>
                    <InputNumber
                        v-model="form.pass_marks"
                        class="w-full bg-emerald-50" />
                </div>

                <!-- স্ট্যাটাস -->
                <div class="col-span-1">
                    <label class="block text-sm font-semibold text-emerald-800 mb-2">স্ট্যাটাস *</label>
                    <Dropdown
                        v-model="form.status"
                        :options="[
                            { label: 'সক্রিয়', value: 'active' },
                            { label: 'নিষ্ক্রিয়', value: 'inactive' }
                        ]"
                        optionLabel="label"
                        optionValue="value"
                        class="w-full bg-emerald-50" />
                </div>

                <!-- Submit Button -->
                <div class="col-span-4 flex justify-end mt-4">
                    <Button
                        type="submit"
                        :disabled="form.processing"
                        icon="pi pi-check"
                        class="bg-emerald-600 hover:bg-emerald-700"
                        :label="form.processing ? 'আপডেট হচ্ছে...' : 'আপডেট করুন'" />
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
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import Dropdown from 'primevue/dropdown'
import Button from 'primevue/button'

const marhala = ref({})
const subjects = ref([])
const subjectSetting = ref({})
const marhalaName = computed(() => marhala.value?.marhala_name_bn || '')

const fetchSubjectSetting = async (id) => {
    try {
        const response = await axios.get(`/api/subject-settings/${id}`);
        if (response.data.success) {
            subjectSetting.value = response.data.subjectSetting;
            // Populate the form with existing data
            form.marhala_id = subjectSetting.value.marhala_id;
            form.subject_id = subjectSetting.value.subject_id;
            form.Marhala_type = subjectSetting.value.Marhala_type;
            form.Subject_Names = subjectSetting.value.Subject_Names;
            form.student_type = subjectSetting.value.student_type;
            form.syllabus_type = subjectSetting.value.syllabus_type;
            form.markaz_type = subjectSetting.value.markaz_type;
            form.subject_type = subjectSetting.value.subject_type;
            form.subject_code = subjectSetting.value.subject_code;
            form.total_marks = subjectSetting.value.total_marks;
            form.pass_marks = subjectSetting.value.pass_marks;
            form.status = subjectSetting.value.status;
            // Fetch marhala and subjects data
            await fetchData(subjectSetting.value.marhala_id);
        }
    } catch (error) {
        console.error('Error fetching subject setting:', error);
    }
};

const fetchData = async (marhalaId) => {
    try {
        const response = await axios.get(`/api/marhala/${marhalaId}/subjects`);
        marhala.value = response.data.marhala;
        subjects.value = response.data.subjects;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

const form = useForm({
    marhala_id: '',
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

const submit = async () => {
    try {
        const id = route().params.marhala;
        const response = await axios.put(`/api/subject-settings/${id}`, form);
        if (response.data.success) {
            // Show beautiful flash message
            const flashMessage = document.createElement('div');
            flashMessage.className = 'fixed top-4 right-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-md transition-all duration-500 ease-in-out z-50 flex items-center';
            flashMessage.innerHTML = `
                <div class="mr-3 text-emerald-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium">${response.data.message}</p>
                </div>
                <button class="ml-auto text-emerald-500 hover:text-emerald-700" onclick="this.parentElement.remove()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
            document.body.appendChild(flashMessage);
            // Remove the flash message after 5 seconds
            setTimeout(() => {
                flashMessage.style.opacity = '0';
                setTimeout(() => {
                    flashMessage.remove();
                }, 500);
            }, 5000);
        }
    } catch (error) {
        if (error.response?.data?.errors) {
            // Handle validation errors
            console.error('Validation errors:', error.response.data.errors);
            // Show error flash message
            const errorMessage = document.createElement('div');
            errorMessage.className = 'fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md transition-all duration-500 ease-in-out z-50 flex items-center';
            errorMessage.innerHTML = `
                <div class="mr-3 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium">ভুল হয়েছে!</p>
                    <p>ফর্মে কিছু ত্রুটি রয়েছে। অনুগ্রহ করে চেক করুন।</p>
                </div>
                <button class="ml-auto text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
            document.body.appendChild(errorMessage);
            // Remove the error message after 5 seconds
            setTimeout(() => {
                errorMessage.style.opacity = '0';
                setTimeout(() => {
                    errorMessage.remove();
                }, 500);
            }, 5000);
        } else {
            console.error('Error updating data:', error);
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

onMounted(() => {
    const id = route().params.marhala;
    fetchSubjectSetting(id);
});
</script>

<style scoped>
/* Custom styles for PrimeVue components */
:deep(.p-dropdown) {
    width: 100%;
}

:deep(.p-dropdown-panel) {
    font-size: 0.875rem;
}

:deep(.p-inputtext) {
    padding: 0.5rem 0.75rem;
    border-color: rgb(167, 243, 208);
    border-radius: 0.125rem;
}

:deep(.p-inputtext:focus) {
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgb(16, 185, 129);
    border-color: rgb(16, 185, 129);
}

:deep(.p-button) {
    padding: 0.5rem 1.5rem;
    border-radius: 0.25rem;
    font-weight: 600;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

:deep(.p-inputnumber-input) {
    width: 100%;
}

/* Background color for PrimeVue components */
:deep(.p-dropdown), :deep(.p-inputtext), :deep(.p-inputnumber) {
    background-color: rgb(236, 253, 245);
}
</style>
