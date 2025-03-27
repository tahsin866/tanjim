<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import markaz_apply_form from './markaz_apply_form.vue';
import { Link, router } from '@inertiajs/vue3'
import axios from 'axios';

const agreements = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get('/api/markaz/get-table-data');
        agreements.value = response.data.agreements;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});




const showModal = ref(false);
const showToast = ref(false);
let submitId = null;

const openModal = (id) => {
    submitId = id;
    showModal.value = true;
};

const submitApplication = () => {
    router.post(route('markaz.submit', submitId), {}, {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false;
            showToast.value = true;
            setTimeout(() => window.location.reload(), 2000);
        },
        onError: (errors) => {
            if (errors.error) {
                alert(errors.error);
            }
        }
    });
};

// const dropdownPosition = ref({ top: 0, left: 0 });
const showMenu = ref(false);



const emit = defineEmits(['deleted'])

// const showDeleteModal = ref(false)
// const showDeleteToast = ref(false)

// const openDeleteModal = () => {
//   showDeleteModal.value = true
// }

const closeDeleteModal = () => {
  showDeleteModal.value = false
}




const showDeleteModal = ref(false)
const showDeleteToast = ref(false)

const closeMenu = () => {
  showMenu.value = false
}

const deleteId = ref(null)

const openDeleteModal = (id) => {
  deleteId.value = id
  showDeleteModal.value = true
  closeMenu()
}

const deleteAgreement = () => {
    router.delete(route('markaz.delete', { id: deleteId.value }), {
        onSuccess: () => {
            showDeleteModal.value = false
            showDeleteToast.value = true
            setTimeout(() => {
                showDeleteToast.value = false
                window.location.reload()
            }, 3000)
        },
    })
}

const closeDeleteToast = () => {
  showDeleteToast.value = false
}



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


const activeMenu = ref(null);

// toggleMenu ফাংশন আপডেট করুন



const editAgreement = (id) => {
    router.get(route('Markaz.edit', id));
}

</script>

<template>
    <AuthenticatedLayout>
        <div class="container-fluid mx-5 mt-8 overflow-x-auto max-w-full ">
            <!-- Form Section -->

            <!-- Table Section -->
            <div class="bg-white rounded-sm shadow-xl">
                <!-- Header with Islamic Pattern -->
                <div
                    class="bg-gradient-to-r from-emerald-900 to-emerald-800 text-white px-8 py-3 rounded-t-sm flex justify-between items-center relative overflow-hidden">
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

                <!-- Table Container -->
                <div class="p-8">
                    <div class="overflow-hidden rounded-sm border border-emerald-100 shadow-md">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-emerald-900 to-emerald-800">
                                    <th class="px-6 py-4 text-white font-semibold whitespace-nowrap">আবেদন নং</th>
                                    <th class="px-6 py-4 text-white font-semibold whitespace-nowrap">আবেদনের তারিখ</th>
                                    <th class="px-6 py-4 text-white font-semibold whitespace-nowrap">মাদরাসার নাম</th>
                                    <th class="px-6 py-4 text-white font-semibold whitespace-nowrap">কেন্দ্রীয় পরীক্ষা
                                    </th>
                                    <th class="px-6 py-4 text-white font-semibold whitespace-nowrap">ছাত্র সংখ্যা</th>
                                    <th class="px-6 py-4 text-white font-semibold whitespace-nowrap">স্ট্যাটাস</th>
                                    <th class="px-6 py-4 text-white font-semibold whitespace-nowrap">করনীয়</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr v-for="agreement in agreements" :key="agreement.id"
                                    class="hover:bg-emerald-50 transition duration-200 border-b border-emerald-100">
                                    <td class="px-6 py-4 text-center font-medium">{{ agreement.id }}</td>
                                    <td class="px-6 py-4 text-center">{{ agreement.application_date }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div>{{ agreement.main_madrasa }}</div>
                                        <div v-for="madrasa in agreement.associated_madrasas" :key="madrasa"
                                            class="text-sm text-gray-600">
                                            {{ madrasa }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">{{ agreement.exam_name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div>মূল মাদরাসা: {{ agreement.main_total_students }}</div>
                                        <div>সংযুক্ত মাদরাসা: {{ agreement.associated_total_students }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span :class="{
                                            'bg-yellow-300 text-black px-4 py-2 text-sm font-medium rounded-full': agreement.status === 'বোর্ড দাখিল',
                                            'bg-red-100 text-red-700 px-4 py-2 text-sm font-medium rounded-full': agreement.status === 'বোর্ড ফেরত',
                                            'bg-green-600 text-white px-4 py-2 text-sm font-medium rounded-full': agreement.status === 'অনুমোদন'
                                        }">
                                            {{ agreement.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
    <div class="relative inline-block text-left">
        <!-- Dropdown Toggle Button -->
        <button type="button" @click="toggleMenu($event, agreement)"
            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div v-if="agreement.showMenu"
            class="absolute right-0 w-48 rounded-md shadow-xl bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-[9999]"
            :class="[isBottomRow(agreement) ? 'bottom-full mb-1' : 'top-full mt-1']">
            <div class="py-1">
                <!-- View Details - Always Visible -->
                <a @click="router.get(route('Markaz.view', agreement.id))"
                    class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 cursor-pointer">
                    <i class="fas fa-eye mr-3 text-gray-400 group-hover:text-emerald-700"></i>
                    বিস্তারিত দেখুন
                </a>

                <!-- Conditional Buttons - Only show if status is not 'অনুমোদন' -->
                <template v-if="agreement.status !== 'অনুমোদন'">
                    <!-- Edit Button -->
                    <a @click="editAgreement(agreement.id)"
    class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 cursor-pointer">
    <i class="fas fa-edit mr-3 text-gray-400 group-hover:text-emerald-700"></i>
    সম্পাদনা করুন
</a>

                    <!-- Delete Button -->
                    <a @click="openDeleteModal(agreement.id)"
                        class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 cursor-pointer">
                        <i class="fas fa-trash-alt mr-3 text-gray-400 group-hover:text-red-700"></i>
                        মুছে ফেলুন
                    </a>

                    <!-- Board Submit Button -->
                    <a @click="openModal(agreement.id)"
                        class="group flex items-center px-4 py-2 text-sm text-emerald-700 hover:bg-emerald-50 hover:text-emerald-800 cursor-pointer">
                        <i class="fas fa-upload mr-3 text-emerald-400 group-hover:text-emerald-700"></i>
                        বোর্ড দাখিল করুন
                    </a>
                </template>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 z-50">
        <div class="bg-white rounded-lg shadow-2xl w-[450px] mx-auto transform transition-all">
            <div class="bg-red-600 rounded-t-lg p-4">
                <div class="flex justify-center">
                    <i class="fas fa-exclamation-triangle text-4xl text-white mb-2"></i>
                </div>
                <h2 class="text-xl font-bold text-white text-center">সতর্কীকরণ!</h2>
            </div>
            <div class="p-6 border-t border-red-100">
                <p class="text-gray-700 text-center text-lg">আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?</p>
                <p class="text-red-600 text-center text-sm mt-2">এই কাজটি অপরিবর্তনীয়!</p>
                <div class="mt-6 flex justify-center space-x-4">
                    <button @click="showDeleteModal = false"
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors duration-200">
                        বাতিল করুন
                    </button>
                    <button @click="deleteAgreement"
                        class="px-6 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-trash-alt mr-2"></i>
                        মুছে ফেলুন
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Success Toast -->
    <div v-if="showDeleteToast"
        class="fixed top-20 -right-96 flex items-center w-full max-w-md p-6 text-white bg-gradient-to-r from-red-600 to-red-700 rounded-lg shadow-2xl border-l-4 border-red-400 transition-all duration-300 ease-out transform translate-x-[-512px]">
        <div class="flex items-center space-x-4">
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-xl">আবেদন সফলভাবে মুছে ফেলা হয়েছে!</span>
            </div>
        </div>
        <button @click="showDeleteToast = false" class="ml-auto text-white hover:text-red-200 text-xl">&times;</button>
    </div>

    <!-- Board Submit Modal -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 z-50">
        <div class="bg-white rounded-lg shadow-2xl w-[450px] mx-auto transform transition-all">
            <div class="bg-emerald-600 rounded-t-lg p-4">
                <div class="flex justify-center">
                    <i class="fas fa-paper-plane text-4xl text-white mb-2"></i>
                </div>
                <h2 class="text-xl font-bold text-white text-center">বোর্ড দাখিল করুন</h2>
            </div>
            <div class="p-6 border-t border-emerald-100">
                <p class="text-gray-700 text-center text-lg">আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?</p>
                <div class="mt-6 flex justify-center space-x-4">
                    <button @click="showModal = false"
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors duration-200">
                        বাতিল করুন
                    </button>
                    <button @click="submitApplication"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-full hover:bg-emerald-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        সাবমিট করুন
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Success Toast -->
    <div v-if="showToast"
        class="fixed top-20 -right-96 flex items-center w-full max-w-md p-6 text-white bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-lg shadow-2xl border-l-4 border-emerald-400 transition-all duration-300 ease-out transform translate-x-[-512px]">
        <div class="flex items-center space-x-4">
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-xl">আবেদন সফলভাবে সাবমিট হয়েছে!</span>
            </div>
        </div>
        <button @click="showToast = false" class="ml-auto text-white hover:text-emerald-200 text-xl">&times;</button>
    </div>
</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style></style>
