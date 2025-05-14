<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import markaz_apply_form from './markaz_apply_form.vue';
import { Link, router } from '@inertiajs/vue3';
import axios from 'axios';

// PrimeVue components
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import SplitButton from 'primevue/splitbutton';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import Tag from 'primevue/tag';

const toast = useToast();
const confirm = useConfirm();

const agreements = ref([]);
const activeMenu = ref(null);
const deleteId = ref(null);
const showMenu = ref(false);
const showModal = ref(false);
const showToast = ref(false);
const showDeleteModal = ref(false);
const showDeleteToast = ref(false);
let submitId = null;

onMounted(async () => {
    try {
        const response = await axios.get('/api/markaz/get-table-data');
        agreements.value = response.data.agreements;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

// Function to determine status severity for Tag component
const getStatusSeverity = (status) => {
    switch (status) {
        case 'বোর্ড দাখিল':
            return 'warning';
        case 'বোর্ড ফেরত':
            return 'danger';
        case 'অনুমোদন':
            return 'success';
        default:
            return 'info';
    }
};

// Get menu items based on agreement status
const getMenuItems = (agreement) => {
    const items = [];

    if (agreement.status !== 'অনুমোদন') {
        items.push({
            label: 'সম্পাদনা করুন',
            icon: 'fas fa-edit',
            command: () => {
                editAgreement(agreement.id);
            }
        });

        items.push({
            label: 'মুছে ফেলুন',
            icon: 'fas fa-trash-alt',
            command: () => {
                openDeleteModal(agreement.id);
            }
        });

        items.push({
            label: 'বোর্ড দাখিল করুন',
            icon: 'fas fa-upload',
            command: () => {
                openModal(agreement.id);
            }
        });
    }

    return items;
};

const editAgreement = (id) => {
    router.get(route('Markaz.edit', id));
};

const openDeleteModal = (id) => {
    deleteId.value = id;

    confirm.require({
        message: 'আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?',
        header: 'সতর্কীকরণ!',
        icon: 'fas fa-exclamation-triangle',
        acceptClass: 'p-button-danger',
        acceptLabel: 'মুছে ফেলুন',
        rejectLabel: 'বাতিল করুন',
        accept: () => {
            deleteAgreement();
        }
    });
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
};

const closeMenu = () => {
    showMenu.value = false;
};

const deleteAgreement = () => {
    router.delete(route('markaz.delete', { id: deleteId.value }), {
        onSuccess: () => {
            toast.add({
                severity: 'error',
                summary: 'সফল',
                detail: 'আবেদন সফলভাবে মুছে ফেলা হয়েছে!',
                life: 3000
            });
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        },
    });
};

const closeDeleteToast = () => {
    showDeleteToast.value = false;
};

const openModal = (id) => {
    submitId = id;

    confirm.require({
        group: 'boardSubmit',
        message: 'আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?',
        header: 'বোর্ড দাখিল করুন',
        icon: 'fas fa-paper-plane',
        acceptClass: 'p-button-success',

        acceptLabel: 'সাবমিট করুন',
        rejectLabel: 'বাতিল করুন',
        accept: () => {
            submitApplication();
        }
    });
};

const submitApplication = () => {
    router.post(route('markaz.submit', submitId), {}, {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'সফল',
                detail: 'আবেদন সফলভাবে সাবমিট হয়েছে!',
                life: 3000
            });
            setTimeout(() => window.location.reload(), 2000);
        },
        onError: (errors) => {
            if (errors.error) {
                alert(errors.error);
            }
        }
    });
};

const toggleMenu = (event, agreement) => {
    const tableHeight = event.target.closest('table').offsetHeight;
    const rowPosition = event.target.closest('tr').offsetTop;

    // যদি অন্য মেনু ওপেন থাকে তবে সেটা বন্ধ করা
    if (activeMenu.value && activeMenu.value !== agreement.id) {
        agreements.value.forEach(a => a.showMenu = false);
    }

    agreement.isBottom = (tableHeight - rowPosition) < 200;
    agreement.showMenu = !agreement.showMenu;

    // বর্তমান মেনুর ID সেট করা
    activeMenu.value = agreement.showMenu ? agreement.id : null;
};

const isBottomRow = (agreement) => {
    return agreement.isBottom;
};

const emit = defineEmits(['deleted']);
</script>


<template>
    <AuthenticatedLayout>
        <div class="container-fluid mx-5 mt-8 overflow-x-auto max-w-full">
            <!-- Table Section -->
            <div class="bg-white rounded-sm shadow-xl">
                <!-- Header with Islamic Pattern -->
                <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 text-white px-8 py-3 rounded-t-sm flex justify-between items-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 pattern-islamic"></div>
                    <h2 class="text-2xl font-bold flex items-center gap-2">
                        আবেদন তালিকা
                    </h2>
                    <Link :href="route('Markaz.markaz_agreement_form')"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2 text-base font-medium text-white bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-sm hover:from-emerald-700 hover:to-emerald-800 transform hover:scale-105 transition-all duration-200 shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <i class="fas fa-plus-circle text-lg"></i>
                        <span style="font-family: 'SolaimanLipi', sans-serif;">আবেদন করুন</span>
                    </Link>
                </div>

                <!-- DataTable Container -->
                <div class="p-8">
                    <DataTable :value="agreements" stripedRows class="p-datatable-sm custom-datatable" responsiveLayout="scroll">
                        <Column field="id" header="আবেদন নং" style="text-align: center;"></Column>
                        <Column field="application_date" header="আবেদনের তারিখ" style="text-align: center;"></Column>
                        <Column header="মাদরাসার নাম" style="text-align: center;">
                            <template #body="slotProps">
                                <div>{{ slotProps.data.main_madrasa }}</div>
                                <div v-for="madrasa in slotProps.data.associated_madrasas" :key="madrasa" class="text-sm text-gray-600">
                                    {{ madrasa }}
                                </div>
                            </template>
                        </Column>
                        <Column field="exam_name" header="কেন্দ্রীয় পরীক্ষা" style="text-align: center;"></Column>
                        <Column header="ছাত্র সংখ্যা" style="text-align: center;">
                            <template #body="slotProps">
                                <div>মূল মাদরাসা: {{ slotProps.data.main_total_students }}</div>
                                <div>সংযুক্ত মাদরাসা: {{ slotProps.data.associated_total_students }}</div>
                            </template>
                        </Column>
                        <Column header="স্ট্যাটাস" style="text-align: center;">
                            <template #body="slotProps">
                                <Tag :severity="getStatusSeverity(slotProps.data.status)" :value="slotProps.data.status" />
                            </template>
                        </Column>
                        <Column header="করনীয়" style="text-align: center;">
                            <template #body="slotProps">
                                <div class="flex justify-center">
                                    <SplitButton
                                        label="বিস্তারিত দেখুন"
                                        icon="fas fa-eye"
                                        @click="router.get(route('Markaz.view', slotProps.data.id))"
                                        :model="getMenuItems(slotProps.data)"
                                        class="p-button-sm p-button-outlined" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>

        <!-- PrimeVue Toast -->
        <Toast />

        <!-- PrimeVue Confirm Dialog for Delete -->
        <ConfirmDialog>
            <template #message="{ message }">
                <div class="flex flex-column align-items-center">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-3"></i>
                    <h3>সতর্কীকরণ!</h3>
                    <p>আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?</p>
                    <p class="text-red-600 text-center text-sm mt-2">এই কাজটি অপরিবর্তনীয়!</p>
                </div>
            </template>
        </ConfirmDialog>

        <!-- PrimeVue Confirm Dialog for Board Submit -->
        <ConfirmDialog group="boardSubmit">
            <template

            #message="{ message }">
                <div class="flex flex-column align-items-center">
                    <i class="fas fa-paper-plane text-4xl text-emerald-500 mb-3"></i>
                    <h3
                         style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
                    >বোর্ড দাখিল করুন</h3>
                    <p
                         style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
                    >আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?</p>
                </div>
            </template>
        </ConfirmDialog>
    </AuthenticatedLayout>
</template>


<style scoped>
/* Custom DataTable Styling */
:deep(.custom-datatable .p-datatable-header) {
    background: linear-gradient(to right, #065f46, #065f46);
    color: white;
}

:deep(.custom-datatable .p-datatable-thead > tr > th) {
    background: linear-gradient(to right, #065f46, #065f46) !important;
    color: white !important;
    padding: 1rem;
    text-align: center !important;
    border-color: #064e3b;
}

:deep(.custom-datatable .p-datatable-tbody > tr > td) {
    text-align: center;
    padding: 0.75rem 1rem;
}

/* SplitButton Styling */
:deep(.p-splitbutton) {
    display: inline-flex;
}

:deep(.p-splitbutton-menubutton) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

:deep(.p-splitbutton-defaultbutton) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

/* Tag Styling */
:deep(.p-tag) {
    padding: 0.4rem 0.8rem;
    font-size: 0.875rem;
}
</style>


