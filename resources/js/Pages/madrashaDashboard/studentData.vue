<template>
    <AuthenticatedLayout style="font-family: 'SolaimanLipi', sans-serif;">
        <div>
            <div class="card">
                <DataTable :value="students" tableStyle="min-width: 50rem">
                    <Column header="ছবি" style="width: 80px">
                        <template #body="slotProps">
                            <Avatar :image="getPhotoUrl(slotProps.data.photo)"
                                    size="large"
                                    shape="circle"
                                    class="border-2 border-gray-200"
                                    @error="handleImageError" />
                        </template>
                    </Column>
                    <Column field="fullNameBangla" header="পূর্ণ নাম (বাংলা)"></Column>
                    <Column field="fullNameEnglish" header="পূর্ণ নাম (ইংরেজি)"></Column>
                    <Column field="dateOfBirth" header="জন্মতারিখ">
                        <template #body="slotProps">
                            <span>{{ slotProps.data.dateOfBirth ? formatDate(slotProps.data.dateOfBirth) : '' }}</span>
                        </template>
                    </Column>
                    <Column field="fatherName" header="পিতার নাম"></Column>
                    <Column field="phoneNumber" header="ফোন নম্বর"></Column>
                    <Column field="departments" header="বিভাগ">
                        <template #body="slotProps">
                            <div class="flex flex-wrap gap-1">
                                <span v-if="slotProps.data.dept_takmil"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    তাকমিল ({{ slotProps.data.dept_takmil_year_english }})
                                </span>
                                <span v-if="slotProps.data.dept_ifta"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ইফতা ({{ slotProps.data.dept_ifta_year_english }})
                                </span>
                                <span v-if="slotProps.data.dept_hifz"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    হিফজ ({{ slotProps.data.dept_hifz_year_english }})
                                </span>
                                <span v-if="slotProps.data.dept_qirat"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    কিরাআত ({{ slotProps.data.dept_qirat_year_english }})
                                </span>
                                <span v-if="slotProps.data.dept_other"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    অন্যান্য ({{ slotProps.data.dept_other_class }})
                                </span>
                            </div>
                        </template>
                    </Column>
                    <Column header="রেজিশ্ট্রেশন পেমেন্ট স্ট্যাটাস">
                        <template #body="slotProps">
                            <span>
                                {{ slotProps.data.examType }}
                                <template v-if="slotProps.data.roll_number">
                                    <br>
                                    <span class="text-xs text-gray-600">রোল: {{ slotProps.data.roll_number }}</span>
                                </template>
                            </span>
                        </template>
                    </Column>
                    <Column field="status" header="স্ট্যাটাস">
                        <template #body="slotProps">
                            <span :class="{
                                'text-yellow-600 font-semibold': slotProps.data.status === 'pending',
                                'text-green-600 font-semibold': slotProps.data.status === 'approved',
                                'text-red-600 font-semibold': slotProps.data.status === 'rejected',
                                'text-gray-600 font-semibold': slotProps.data.status === 'suspended',
                            }">{{ slotProps.data.status }}</span>
                        </template>
                    </Column>
                    <Column header="অ্যাকশন">
                        <template #body="slotProps">
                            <SplitButton
                                v-if="slotProps.data.status !== 'suspended'"
                                label="অ্যাকশন"
                                :model="getMenuItems(slotProps.data)"
                                class="p-button-sm"
                            />
                            <span
                                v-else
                                class="text-gray-400 text-sm italic">
                                কোন অ্যাকশন উপলব্ধ নয়
                            </span>
                        </template>
                    </Column>
                </DataTable>
            </div>

            <!-- View Dialog (your previous code here, unchanged) -->


        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Avatar from 'primevue/avatar';
import SplitButton from 'primevue/splitbutton';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Fieldset from 'primevue/fieldset';
import InputText from 'primevue/inputtext';
import { usePage, router } from '@inertiajs/vue3';

const { props } = usePage();
const students = ref(props.students);

const displayViewModal = ref(false);
const selectedStudent = ref({});

const divisions = ref(props.divisions || []);
const districts = ref(props.districts || []);
const thanas = ref(props.thanas || []);

const filteredDistricts = computed(() =>
    districts.value.filter(d => d.division_id === editForm.value.division)
);
const filteredThanas = computed(() =>
    thanas.value.filter(t => t.district_id === editForm.value.district)
);

function getPhotoUrl(photo) {
    if (!photo) {
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzciIHI9IjE4IiBmaWxsPSIjOUI5QjlCIi8+CjxwYXRoIGQ9Ik0yMCA4MEM2IDgwIDM4IDY4IDUwIDY4QzYyIDY4IDk0IDgwIDgwIDgwSDE4WiIgZmlsbD0iIzlCOUI5QiIvPgo8L3N2Zz4=';
    }
    if (typeof photo === 'string' && (photo.startsWith('http://') || photo.startsWith('https://'))) {
        return photo;
    }
    if (typeof photo === 'string' && photo.startsWith('/')) {
        return photo;
    }
    if (typeof photo === 'string') {
        return `/storage/${photo}`;
    }
    if (photo instanceof File && photoPreview.value) {
        return photoPreview.value;
    }
    return '';
}
function handleImageError(event) {
    event.target.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzciIHI9IjE4IiBmaWxsPSIjOUI5QjlCIi8+CjxwYXRoIGQ9Ik0yMCA4MEM2IDgwIDM4IDY4IDUwIDY4QzYyIDY4IDk0IDgwIDgwIDgwSDE4WiIgZmlsbD0iIzlCOUI5QiIvPgo8L3N2Zz4=';
}
function getMenuItems(student) {
    const baseItems = [];

    // স্ট্যাটাস অনুযায়ী conditional actions
    if (student.status === 'approved') {
        // অনুমোদিত হলে: বিস্তারিত দেখুন, রেজিস্ট্রেশন করুন, রেজিস্ট্রেশন কার্ড ডাউনলোড
        baseItems.push(
            {
                label: 'বিস্তারিত দেখুন',
                icon: 'pi pi-eye',
                command: () => router.visit(route('student.details', student.id)),
            },
            {
                label: 'রেজিস্ট্রেশন করুন',
                icon: 'pi pi-check-circle',
                command: () => {
                    // রেজিস্ট্রেশন করার logic এখানে যোগ করুন
                    console.log('রেজিস্ট্রেশন করুন:', student.id);
                },
            },
            {
                label: 'রেজিস্ট্রেশন কার্ড ডাউনলোড',
                icon: 'pi pi-download',
                command: () => {
                    // কার্ড ডাউনলোড logic এখানে যোগ করুন
                    console.log('কার্ড ডাউনলোড:', student.id);
                },
            }
        );
    } else if (student.status === 'suspended') {
        // সাসপেন্ড হলে: কোন action দেখাবে না
        return [];
    } else if (student.status === 'rejected') {
        // স্থগিত/প্রত্যাখ্যান হলে: শুধু বিস্তারিত দেখুন এবং সম্পাদনা করুন
        baseItems.push(
            {
                label: 'বিস্তারিত দেখুন',
                icon: 'pi pi-eye',
                command: () => router.visit(route('student.details', student.id)),
            },
            {
                label: 'সম্পাদনা করুন',
                icon: 'pi pi-pencil',
                command: () => router.visit(route('student.edit', student.id)),
            }
        );
    } else {
        // pending বা অন্য যেকোন status এর জন্য: সব options
        baseItems.push(
            {
                label: 'বিস্তারিত দেখুন',
                icon: 'pi pi-eye',
                command: () => router.visit(route('student.details', student.id)),
            },
            {
                label: 'সম্পাদনা করুন',
                icon: 'pi pi-pencil',
                command: () => router.visit(route('student.edit', student.id)),
            }
        );
    }

    return baseItems;
}
function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('bn-BD', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
function viewStudent(student) {
    selectedStudent.value = { ...student };
    displayViewModal.value = true;
}
function closeViewModal() {
    displayViewModal.value = false;
}
</script>
