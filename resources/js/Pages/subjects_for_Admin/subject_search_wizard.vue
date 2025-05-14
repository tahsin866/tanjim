<template>
    <AuthenticatedLayout>
        <div class="p-6 space-y-6">
            <!-- Subject List Table with PrimeVue -->
            <div class="bg-emerald-50 p-6 rounded-sm shadow-md border-t-4 border-emerald-600">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-emerald-800">বিষয় তালিকা</h2>
                    <Link :href="route('subjects_for_Admin.subject_setup_list')"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-sm text-xl hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        নতুন বিষয় সেটাপ
                    </Link>
                </div>

                <DataTable :value="subjects" :paginator="true" :rows="10"
                    stripedRows paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rowsPerPageOptions="[10, 20, 50]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                    responsiveLayout="scroll" class="p-datatable-sm">

                    <!-- Table Header with Filters -->
                    <template #header>
                        <div class="flex flex-wrap gap-5 p-2">
                            <div class="flex-1 min-w-[200px]">
                                <span class="p-input-icon-left w-full">
                                    <i class="pi pi-search" />
                                    <InputText v-model="searchTerm" placeholder="বিষয় / কোড লিখুন" class="w-full p-2" />
                                </span>
                            </div>
                            <div class="flex-1 min-w-[200px]">
                                <Dropdown v-model="markazType" :options="[
                                    { label: 'নির্বাচন করুন', value: '' },
                                    { label: 'দরসিয়াত', value: 'দরসিয়াত' },
                                    { label: 'হিফজুল কোরআন', value: 'হিফজুল কোরআন' },
                                    { label: 'কিরাআত', value: 'কিরাআত' }
                                ]" optionLabel="label" optionValue="value" placeholder="মারকাযের ধরন" class="w-full" />
                            </div>
                            <div class="flex-1 min-w-[200px]">
                                <Dropdown v-model="marhalaType" :options="marhalaTypes.map(type => ({ label: type, value: type }))"
                                    optionLabel="label" optionValue="value" placeholder="মারহালা নির্বাচন করুন" class="w-full" />
                            </div>
                            <div class="flex-1 min-w-[200px]">
                                <Dropdown v-model="status" :options="[
                                    { label: 'নির্বাচন করুন', value: '' },
                                    { label: 'সক্রিয়', value: 'active' },
                                    { label: 'নিষ্ক্রিয়', value: 'inactive' }
                                ]" optionLabel="label" optionValue="value" placeholder="স্ট্যাটাস" class="w-full" />
                            </div>
                            <div class="flex gap-2">
                                <Button icon="pi pi-refresh" class="p-button-outlined" @click="resetFilters" />
                                <Button icon="pi pi-search" label="অনুসন্ধান করুন" @click="fetchData" />
                            </div>
                        </div>
                    </template>

                    <!-- Table Columns -->
                    <Column field="code" header="কোড" sortable></Column>
                    <Column field="Subject_Names" header="বিষয়" sortable></Column>
                    <Column field="Marhala_type" header="মারহালা" sortable></Column>
                    <Column field="student_type" header="বালক/বালিকা" sortable></Column>
                    <Column field="syllabus_type" header="সিলেবাসের ধরন" sortable></Column>
                    <Column field="markaz_type" header="মারকাযের ধরন" sortable></Column>
                    <Column field="subject_type" header="বিষয়ের ধরন" sortable></Column>
                    <Column field="total_marks" header="মোট নাম্বার" sortable></Column>
                    <Column field="pass_marks" header="পাশ নম্বর" sortable></Column>

                    <Column field="status" header="স্ট্যাটাস" sortable>
                        <template #body="slotProps">
                            <span :class="slotProps.data.status === 'active' ? 'bg-emerald-500' : 'bg-red-500'"
                                class="px-3 py-1 text-white rounded-sm">
                                {{ slotProps.data.status === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                            </span>
                        </template>
                    </Column>

                    <Column header="কর্মসূচী">
                        <template #body="slotProps">
                            <Link :href="route('subjects_for_Admin.subject_setings_edit', { marhala: slotProps.data.id })"
                                class="px-4 py-1.5 bg-amber-500 text-white rounded-sm hover:bg-amber-600 transition-colors duration-200 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                সংশোধন
                            </Link>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';

const subjects = ref([]);
const searchTerm = ref('');
const markazType = ref('');
const marhalaType = ref('');
const status = ref('');
const marhalaTypes = ref([]);

const fetchData = async () => {
    try {
        const response = await axios.get('/api/subjects', {
            params: {
                search_term: searchTerm.value,
                markaz_type: markazType.value,
                marhala_type: marhalaType.value,
                status: status.value
            }
        });
        subjects.value = response.data.subjects;
        marhalaTypes.value = response.data.marhalaTypes;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

const resetFilters = () => {
    searchTerm.value = '';
    markazType.value = '';
    marhalaType.value = '';
    status.value = '';
    fetchData();
};

// Watch for changes in filter values
watch([searchTerm, markazType, marhalaType, status], () => {
    fetchData();
});

onMounted(() => {
    fetchData();
});
</script>

<style scoped>
/* You may need to add some custom styles for PrimeVue components */
:deep(.p-datatable) {
    font-size: 1.125rem;
}

:deep(.p-datatable .p-datatable-thead > tr > th) {
    background-color: rgb(209, 250, 229);
    color: rgb(6, 95, 70);
    font-weight: 600;
    border-color: rgb(167, 243, 208);
    padding: 0.75rem;
}

:deep(.p-datatable .p-datatable-tbody > tr) {
    border-bottom-color: rgb(167, 243, 208);
}

:deep(.p-datatable .p-datatable-tbody > tr > td) {
    border-color: rgb(167, 243, 208);
    padding: 0.75rem;
}

:deep(.p-datatable .p-datatable-tbody > tr:hover) {
    background-color: rgb(236, 253, 245);
}
</style>
