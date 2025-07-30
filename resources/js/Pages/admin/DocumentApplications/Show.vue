<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    divisions: Array,
    districts: Array,
    thanas: Array,
});

const page = usePage();

const showModal = ref(false);
const modalImage = ref('');
const modalTitle = ref('');

const departments = [
    { key: 'takmil', flag: 'dept_takmil', title: 'তাকমিল', english: 'dept_takmil_year_english', hijri: 'dept_takmil_year_hijri' },
    { key: 'ifta', flag: 'dept_ifta', title: 'ইফতা', english: 'dept_ifta_year_english', hijri: 'dept_ifta_year_hijri' },
    { key: 'hifz', flag: 'dept_hifz', title: 'হিফজ', english: 'dept_hifz_year_english', hijri: 'dept_hifz_year_hijri' },
    { key: 'qirat', flag: 'dept_qirat', title: 'কিরাআত', english: 'dept_qirat_year_english', hijri: 'dept_qirat_year_hijri' }
];

const approveApplication = () => {
    if (confirm('আপনি কি নিশ্চিত যে এই আবেদনটি অনুমোদন করতে চান?')) {
        router.patch(route('admin.documents.applications.approve', props.user.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ preserveScroll: true });
            },
            onError: (errors) => {
                console.error('Approve failed:', errors);
                const errorMessage = errors.error || 'অনুমোদন দিতে সমস্যা হয়েছে।';
                alert(errorMessage);
            }
        });
    }
};

const rejectApplication = () => {
    if (confirm('আপনি কি নিশ্চিত যে এই আবেদনটি বাতিল করতে চান?')) {
        router.patch(route('admin.documents.applications.reject', props.user.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ preserveScroll: true });
            },
            onError: (errors) => {
                console.error('Reject failed:', errors);
                const errorMessage = errors.error || 'বাতিল করতে সমস্যা হয়েছে।';
                alert(errorMessage);
            }
        });
    }
};

const suspendApplication = () => {
    if (confirm('আপনি কি নিশ্চিত যে এই আবেদনটি স্থগিত করতে চান?')) {
        router.patch(route('admin.documents.applications.suspend', props.user.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ preserveScroll: true });
            },
            onError: (errors) => {
                console.error('Suspend failed:', errors);
                const errorMessage = errors.error || 'স্থগিত করতে সমস্যা হয়েছে।';
                alert(errorMessage);
            }
        });
    }
};

const getStatusText = (status) => {
    const statusMap = {
        'approved': 'অনুমোদিত',
        'rejected': 'বাতিল',
        'pending': 'অপেক্ষমান',
        'suspended': 'স্থগিত'
    };
    return statusMap[status] || status;
};

const getStatusBadgeClass = (status) => {
    const classMap = {
        'approved': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'rejected': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'suspended': 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
    };
    return classMap[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
};

function getIdType(val) {
    if (val === 'birth') return 'জন্মসনদ';
    if (val === 'voter') return 'ভোটার আইডি';
    return 'নির্বাচিত হয়নি';
}

function getPhotoUrl(photo) {
    if (!photo)
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzciIHI9IjE4IiBmaWxsPSIjOUI5QjlCIi8+CjxwYXRoIGQ9Ik0yMCA4MEM2IDgwIDM4IDY4IDUwIDY4QzYyIDY4IDk0IDgwIDgwIDgwSDE4WiIgZmlsbD0iIzlCOUI5QiIvPgo8L3N2Zz4=';
    if (typeof photo === 'string' && (photo.startsWith('http://') || photo.startsWith('https://'))) return photo;
    if (typeof photo === 'string' && photo.startsWith('/')) return photo;
    if (typeof photo === 'string') return `/storage/${photo}`;
    return '';
}

// Modal functions for image viewing
const viewImage = (imageUrl, title) => {
    modalImage.value = imageUrl;
    modalTitle.value = title;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    modalImage.value = '';
    modalTitle.value = '';
};
</script>

<template>
    <Head :title="`${user.fullNameBangla} - বিস্তারিত তথ্য`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                    {{ user.fullNameBangla }} - বিস্তারিত তথ্য
                </h2>
                <Link :href="route('admin.documents.applications.index')"
                      class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ফিরে যান
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Admin Action Buttons -->
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">প্রশাসনিক কার্যক্রম</h3>
                    <div class="flex flex-wrap gap-3">
                        <button v-if="user.status === 'pending' || user.status === 'rejected' || user.status === 'suspended'"
                                @click="approveApplication"
                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            <i class="fas fa-check mr-2"></i>অনুমোদন করুন
                        </button>
                        <button v-if="page.props.auth.user.role === 'super_admin' && user.status !== 'rejected'"
                                @click="rejectApplication"
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            <i class="fas fa-times mr-2"></i>বাতিল করুন
                        </button>
                        <button v-if="page.props.auth.user.role === 'super_admin' && user.status !== 'suspended'"
                                @click="suspendApplication"
                                class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            <i class="fas fa-pause mr-2"></i>স্থগিত করুন
                        </button>
                    </div>
                </div>

                <!-- Profile Header -->
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 flex flex-col sm:flex-row items-center gap-8 mb-8">
                    <div class="flex-shrink-0">
                        <img :src="getPhotoUrl(user.photo)"
                             :alt="user.fullNameBangla"
                             class="w-32 h-32 rounded-full object-cover border-4 border-indigo-200 dark:border-indigo-700 shadow-lg">
                    </div>
                    <div class="flex-1 flex flex-col gap-2 text-center sm:text-left">
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ user.fullNameBangla || 'নাম নেই' }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 text-lg">{{ user.fullNameEnglish || 'No English Name' }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                            <p class="text-gray-500 dark:text-gray-400">ফোন: <span class="font-medium">{{ user.phoneNumber || 'নেই' }}</span></p>
                            <p class="text-gray-500 dark:text-gray-400">বাবার নাম: <span class="font-medium">{{ user.fatherName || 'নেই' }}</span></p>
                            <p class="text-gray-500 dark:text-gray-400">ইমেইল: <span class="font-medium">{{ user.email || 'নেই' }}</span></p>
                            <p class="text-gray-500 dark:text-gray-400">
                                স্ট্যাটাস:
                                <span :class="['px-2 py-1 rounded-full text-sm font-medium', getStatusBadgeClass(user.status)]">
                                    {{ getStatusText(user.status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Personal & Address Info -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6">
                        <div class="text-xl font-semibold text-indigo-700 dark:text-indigo-300 mb-4 border-b pb-2 flex items-center">
                            <i class="fas fa-user mr-2"></i>ব্যক্তিগত তথ্য
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">বিকল্প ফোন:</span>
                                <span>{{ user.alternatePhoneNumber || 'নেই' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">জন্মতারিখ:</span>
                                <span>{{ user.dateOfBirth || 'নেই' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">ব্লাড গ্রুপ:</span>
                                <span>{{ user.bloodGroup || 'নেই' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600 dark:text-gray-300">ঠিকানা:</span>
                                <span class="text-right">{{ user.address || 'নেই' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6">
                        <div class="text-xl font-semibold text-indigo-700 dark:text-indigo-300 mb-4 border-b pb-2 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>অবস্থান তথ্য
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">বিভাগ:</span>
                                <span>{{ user.division_name_bangla || 'নির্বাচিত হয়নি' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">জেলা:</span>
                                <span>{{ user.district_name_bangla || 'নির্বাচিত হয়নি' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600 dark:text-gray-300">থানা:</span>
                                <span>{{ user.thana_name_bangla || 'নির্বাচিত হয়নি' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Info -->
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 mb-8">
                    <div class="text-xl font-semibold text-indigo-700 dark:text-indigo-300 mb-4 border-b pb-2 flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i>শিক্ষা বিভাগ
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <template v-for="dept in departments" :key="dept.key">
                            <div v-if="user[dept.flag]" class="border border-indigo-200 dark:border-indigo-700 rounded-lg bg-indigo-50 dark:bg-indigo-950 p-4">
                                <div class="text-lg font-bold text-indigo-700 dark:text-indigo-200 mb-3 flex items-center">
                                    <i class="fas fa-book mr-2"></i>{{ dept.title }}
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">ইংরেজি বছর:</span>
                                        <span class="font-semibold">{{ user[dept.english] || 'নির্বাচিত হয়নি' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">হিজরি বছর:</span>
                                        <span class="font-semibold">{{ user[dept.hijri] || 'নির্বাচিত হয়নি' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">স্ট্যাটাস:</span>
                                        <span class="text-green-600 dark:text-green-300 font-medium flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i>নির্বাচিত
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div v-if="user.dept_other" class="border border-indigo-200 dark:border-indigo-700 rounded-lg bg-indigo-50 dark:bg-indigo-950 p-4 md:col-span-2">
                            <div class="text-lg font-bold text-indigo-700 dark:text-indigo-200 mb-3 flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i>অন্যান্য বিভাগ
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-600 dark:text-gray-300">বিভাগের নাম:</span>
                                    <span class="font-semibold">{{ user.dept_other_name || 'নির্বাচিত হয়নি' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-600 dark:text-gray-300">ক্লাস:</span>
                                    <span class="font-semibold">{{ user.dept_other_class || 'নির্বাচিত হয়নি' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Show unselected departments -->
                    <div class="mt-6" v-if="departments.some(dept => !user[dept.flag]) || !user.dept_other">
                        <div class="text-md font-medium text-gray-600 dark:text-gray-300 mb-3">নির্বাচিত নয়:</div>
                        <div class="flex flex-wrap gap-2">
                            <template v-for="dept in departments" :key="'unselected-' + dept.key">
                                <span v-if="!user[dept.flag]" class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 px-3 py-1 rounded-full text-sm">
                                    {{ dept.title }}
                                </span>
                            </template>
                            <span v-if="!user.dept_other" class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 px-3 py-1 rounded-full text-sm">
                                অন্যান্য বিভাগ
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Exam Info -->
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 mb-6">
                    <div class="text-xl font-semibold text-indigo-700 dark:text-indigo-300 mb-4 border-b pb-2 flex items-center">
                        <i class="fas fa-clipboard-list mr-2"></i>পরীক্ষা ও অন্যান্য তথ্য
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">পরীক্ষার ধরন:</span>
                                <span>{{ user.examType || 'নেই' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">রোল নম্বর:</span>
                                <span>{{ user.rollNumber || 'নেই' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">কর্মস্থল:</span>
                                <span>{{ user.workplace || 'নেই' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600 dark:text-gray-300">পরিচয়পত্র টাইপ:</span>
                                <span>{{ getIdType(user.idType) }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <template v-if="user.idType === 'birth'">
                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-medium text-gray-600 dark:text-gray-300">জন্ম নিবন্ধন নম্বর:</span>
                                    <span>{{ user.birthCertificate || 'নেই' }}</span>
                                </div>
                            </template>
                            <template v-else-if="user.idType === 'voter'">
                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-medium text-gray-600 dark:text-gray-300">ভোটার আইডি নম্বর:</span>
                                    <span>{{ user.voterId || 'নেই' }}</span>
                                </div>
                            </template>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">সহপাঠী ১:</span>
                                <span>{{ user.classmate1 || 'নেই' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">সহপাঠী ২:</span>
                                <span>{{ user.classmate2 || 'নেই' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600 dark:text-gray-300">সহপাঠী ৩:</span>
                                <span>{{ user.classmate3 || 'নেই' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Upload Information -->
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 mb-6">
                    <div class="text-xl font-semibold text-indigo-700 dark:text-indigo-300 mb-4 border-b pb-2 flex items-center">
                        <i class="fas fa-file-image mr-2"></i>আপলোডকৃত ফাইল সমূহ
                    </div>

                    <!-- Profile Photo Card -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800 mb-6">
                        <div class="text-lg font-medium text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                            <i class="fas fa-user-circle mr-2 text-blue-600"></i>প্রোফাইল ছবি
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Left side - Image -->
                            <div class="text-center">
                                <div :class="['px-3 py-1 rounded-full text-sm font-medium mb-3', user.photo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200']">
                                    {{ user.photo ? '✓ আপলোড করা হয়েছে' : '✗ আপলোড করা হয়নি' }}
                                </div>
                                <div v-if="user.photo">
                                    <img :src="getPhotoUrl(user.photo)" alt="প্রোফাইল ছবি"
                                         @click="viewImage(getPhotoUrl(user.photo), 'প্রোফাইল ছবি')"
                                         class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600 mx-auto cursor-pointer hover:border-blue-400 transition-colors">
                                    <div class="text-xs text-gray-500 break-all mt-2">{{ user.photo }}</div>
                                </div>
                            </div>
                            <!-- Right side - Basic Info -->
                            <div class="bg-white dark:bg-gray-900 rounded-md p-3 border dark:border-gray-700">
                                <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">ব্যক্তিগত তথ্য:</div>
                                <div class="space-y-1 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">নাম:</span>
                                        <span class="font-medium">{{ user.fullNameBangla }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">পিতার নাম:</span>
                                        <span class="font-medium">{{ user.fatherName }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">জন্মতারিখ:</span>
                                        <span class="font-medium">{{ user.dateOfBirth || 'নেই' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">ফোন নম্বর:</span>
                                        <span class="font-medium">{{ user.phoneNumber || 'নেই' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Birth Certificate/Voter ID Card -->
                    <div v-if="user.idType === 'birth' || user.idType === 'voter'" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800">
                        <!-- Birth Certificate -->
                        <div v-if="user.idType === 'birth'">
                            <div class="text-lg font-medium text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                                <i class="fas fa-certificate mr-2 text-green-600"></i>জন্ম সনদের তথ্য ও ছবি
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Left side - Document Image -->
                                <div class="text-center">
                                    <div :class="['px-3 py-1 rounded-full text-sm font-medium mb-3', user.birthCertificatePhoto ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200']">
                                        {{ user.birthCertificatePhoto ? '✓ ছবি আপলোড করা হয়েছে' : '✗ ছবি আপলোড করা হয়নি' }}
                                    </div>
                                    <div v-if="user.birthCertificatePhoto">
                                        <button @click="viewImage(getPhotoUrl(user.birthCertificatePhoto), 'জন্ম সনদের ছবি')"
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center justify-center mb-3">
                                            <i class="fas fa-eye mr-2"></i>জন্ম সনদের ছবি দেখুন
                                        </button>
                                        <div class="text-xs text-gray-500 break-all">ফাইল: {{ user.birthCertificatePhoto }}</div>
                                    </div>
                                </div>
                                <!-- Right side - Information Comparison -->
                                <div class="bg-white dark:bg-gray-900 rounded-md p-3 border dark:border-gray-700">
                                    <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">তথ্য তুলনা (ফর্ম vs জন্ম সনদ):</div>
                                    <div class="space-y-1 text-xs">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">নাম:</span>
                                            <span class="font-medium text-right">{{ user.fullNameBangla }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">পিতার নাম:</span>
                                            <span class="font-medium text-right">{{ user.fatherName }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">জন্মতারিখ:</span>
                                            <span class="font-medium text-right">{{ user.dateOfBirth || 'নেই' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">জন্ম নিবন্ধন নম্বর:</span>
                                            <span class="font-medium text-right">{{ user.birthCertificate || 'নেই' }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 p-2 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded text-xs text-yellow-700 dark:text-yellow-200">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        জন্ম সনদের ছবির সাথে এই তথ্যগুলো মিলিয়ে দেখুন
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Voter ID -->
                        <div v-if="user.idType === 'voter'">
                            <div class="text-lg font-medium text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                                <i class="fas fa-id-card mr-2 text-purple-600"></i>ভোটার আইডির তথ্য ও ছবি
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Left side - Document Image -->
                                <div class="text-center">
                                    <div :class="['px-3 py-1 rounded-full text-sm font-medium mb-3', user.voterIdPhoto ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200']">
                                        {{ user.voterIdPhoto ? '✓ ছবি আপলোড করা হয়েছে' : '✗ ছবি আপলোড করা হয়নি' }}
                                    </div>
                                    <div v-if="user.voterIdPhoto">
                                        <button @click="viewImage(getPhotoUrl(user.voterIdPhoto), 'ভোটার আইডি ছবি')"
                                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center justify-center mb-3">
                                            <i class="fas fa-eye mr-2"></i>ভোটার আইডি ছবি দেখুন
                                        </button>
                                        <div class="text-xs text-gray-500 break-all">ফাইল: {{ user.voterIdPhoto }}</div>
                                    </div>
                                </div>
                                <!-- Right side - Information Comparison -->
                                <div class="bg-white dark:bg-gray-900 rounded-md p-3 border dark:border-gray-700">
                                    <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">তথ্য তুলনা (ফর্ম vs ভোটার আইডি):</div>
                                    <div class="space-y-1 text-xs">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">নাম:</span>
                                            <span class="font-medium text-right">{{ user.fullNameBangla }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">পিতার নাম:</span>
                                            <span class="font-medium text-right">{{ user.fatherName }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">জন্মতারিখ:</span>
                                            <span class="font-medium text-right">{{ user.dateOfBirth || 'নেই' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">ভোটার আইডি নম্বর:</span>
                                            <span class="font-medium text-right">{{ user.voterId || 'নেই' }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 p-2 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded text-xs text-yellow-700 dark:text-yellow-200">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        ভোটার আইডি কার্ডের ছবির সাথে এই তথ্যগুলো মিলিয়ে দেখুন
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status and Created Info -->
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 mb-6">
                    <div class="text-xl font-semibold text-indigo-700 dark:text-indigo-300 mb-4 border-b pb-2 flex items-center">
                        <i class="fas fa-clock mr-2"></i>স্ট্যাটাস ও সময়ের তথ্য
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">আবেদনের স্ট্যাটাস:</span>
                                <span :class="['px-3 py-1 rounded-full text-sm font-medium', getStatusBadgeClass(user.status)]">
                                    {{ getStatusText(user.status) }}
                                </span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">আবেদনের তারিখ:</span>
                                <span>{{ user.created_at ? new Date(user.created_at).toLocaleString('bn-BD', {
                                    year: 'numeric', month: 'long', day: 'numeric',
                                    hour: '2-digit', minute: '2-digit'
                                }) : 'নেই' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600 dark:text-gray-300">সর্বশেষ আপডেট:</span>
                                <span>{{ user.updated_at ? new Date(user.updated_at).toLocaleString('bn-BD', {
                                    year: 'numeric', month: 'long', day: 'numeric',
                                    hour: '2-digit', minute: '2-digit'
                                }) : 'নেই' }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <template v-if="user.approved_at">
                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-medium text-gray-600 dark:text-gray-300">অনুমোদনের তারিখ:</span>
                                    <span>{{ new Date(user.approved_at).toLocaleString('bn-BD', {
                                        year: 'numeric', month: 'long', day: 'numeric',
                                        hour: '2-digit', minute: '2-digit'
                                    }) }}</span>
                                </div>
                            </template>
                            <template v-if="user.approved_by_name">
                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-medium text-gray-600 dark:text-gray-300">অনুমোদনকারী:</span>
                                    <span>{{ user.approved_by_name }}</span>
                                </div>
                            </template>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600 dark:text-gray-300">তথ্য সংরক্ষণের তারিখ:</span>
                                <span>{{ user.info_created_at ? new Date(user.info_created_at).toLocaleString('bn-BD', {
                                    year: 'numeric', month: 'long', day: 'numeric',
                                    hour: '2-digit', minute: '2-digit'
                                }) : 'নেই' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Image Modal -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" @click="closeModal">
            <div class="relative max-w-4xl max-h-full p-4">
                <button @click="closeModal" class="absolute top-2 right-2 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="text-center">
                    <img :src="modalImage" :alt="modalTitle" class="max-w-full max-h-screen object-contain rounded-lg" @click.stop>
                    <p class="text-white mt-4 text-lg">{{ modalTitle }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
* {
    font-family: 'Merriweather', 'SolaimanLipi', sans-serif;
}
</style>
