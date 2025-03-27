<template>
    <AuthenticatedLayout>
        <div class="p-6 space-y-6">
            <!-- Filter Section -->
            <div class="bg-emerald-50 p-6 rounded-sm shadow-md border-t-4 border-emerald-600">
                <div class="relative mb-6">
                    <div class="absolute inset-0 bg-emerald-50 opacity-25 pattern-islamic"></div>
                    <h2 class="text-xl font-bold text-emerald-800">ফিল্টার অপশন</h2>
                </div>

                <div class="grid grid-cols-4 gap-5">
                    <div class="col-span-1">
                        <label class="block font-semibold text-emerald-800 mb-2 text-xl">বিষয় / কোড</label>
                        <input v-model="searchTerm" type="text"
                            class="w-full p-2 border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
                            placeholder="বিষয় / কোড লিখুন">
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xl font-semibold text-emerald-800 mb-2">মারকাযের ধরন</label>
                        <select v-model="markazType"
                            class="w-full p-2 border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            <option value="">নির্বাচন করুন</option>
                            <option value="দরসিয়াত">দরসিয়াত</option>
                            <option value="হিফজুল কোরআন">হিফজুল কোরআন</option>
                            <option value="কিরাআত">কিরাআত</option>
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xl font-semibold text-emerald-800 mb-2">মারহালা নির্বাচন করুন</label>
                        <select v-model="marhalaType"
                            class="w-full p-2 border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            <option value="">নির্বাচন করুন</option>
                            <option v-for="type in marhalaTypes" :key="type" :value="type">
                                {{ type }}
                            </option>
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xl font-semibold text-emerald-800 mb-2">স্ট্যাটাস</label>
                        <select v-model="status"
                            class="w-full p-2 border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            <option value="">নির্বাচন করুন</option>
                            <option value="active">সক্রিয়</option>
                            <option value="inactive">নিষ্ক্রিয়</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex gap-4">
                    <button @click="resetFilters"
                        class="px-6 py-2 bg-gray-500 text-white text-xl rounded-sm hover:bg-gray-600 transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        রিসেট
                    </button>

                    <button @click="fetchData"
                        class="px-6 py-2 bg-emerald-600 text-white text-xl rounded-sm hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        অনুসন্ধান করুন
                    </button>
                </div>
            </div>

            <!-- Subject List Table -->
            <div class="bg-emerald-50 p-6 rounded-sm shadow-md border-t-4 border-emerald-600">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-emerald-800">বিষয় তালিকা</h2>
                    <Link :href="route('subjects_for_Admin.subject_setup_list')"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-sm text-xl hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    নতুন বিষয় সেটাপ
                    </Link>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-auto bg-white border border-emerald-200">
                        <thead class="bg-emerald-100">
                            <tr class="text-emerald-800 text-xl">

                                <th class="border border-emerald-200 p-3 font-semibold ">কোড</th>
                                <th class="border border-emerald-200 p-3  font-semibold">বিষয়</th>
                                <th class="border border-emerald-200 p-3  font-semibold">মারহালা</th>
                                <th class="border border-emerald-200 p-3 font-semibold">বালক/বালিকা</th>
                                <th class="border border-emerald-200 p-3 font-semibold">সিলেবাসের ধরন</th>
                                <th class="border border-emerald-200 p-3  font-semibold">মারকাযের ধরন</th>
                                <th class="border border-emerald-200 p-3 font-semibold">বিষয়ের ধরন</th>
                                <th class="border border-emerald-200 p-3 font-semibold">মোট নাম্বার</th>
                                <th class="border border-emerald-200 p-3 font-semibold">পাশ নম্বর</th>
                                <th class="border border-emerald-200 p-3  font-semibold">স্ট্যাটাস</th>
                                <th class="border border-emerald-200 p-3 font-semibold">কর্মসূচী</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(subject, index) in subjects" :key="index" class="border-b border-emerald-200 hover:bg-emerald-50 text-xl">

    <td class="border border-emerald-200 p-3">{{ subject.code }}</td>
    <td class="border border-emerald-200 p-3">{{ subject.Subject_Names }}</td>
    <td class="border border-emerald-200 p-3">{{ subject.Marhala_type }}</td>
    <td class="border border-emerald-200 p-3">{{ subject.student_type }}</td>
    <td class="border border-emerald-200 p-3">{{ subject.syllabus_type }}</td>
    <td class="border border-emerald-200 p-3">{{ subject.markaz_type }}</td>
    <td class="border border-emerald-200 p-3">{{ subject.subject_type }}</td>
    <td class="border border-emerald-200 p-3">{{ subject.total_marks }}</td>
    <td class="border border-emerald-200 p-3">{{ subject.pass_marks }}</td>
    <td class="border border-emerald-200 p-3">
        <span :class="subject.status === 'active' ? 'bg-emerald-500' : 'bg-red-500'" class="px-3 py-1 text-white rounded-sm">
            {{ subject.status === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
        </span>
    </td>
    <td class="border border-emerald-200 p-3">
        <button
    @click="editSubject(subject)"
    class="px-4 py-1.5 bg-amber-500 text-white rounded-sm hover:bg-amber-600 transition-colors duration-200 flex items-center gap-1">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
    </svg>
    সংশোধন
</button>
    </td>
</tr>
            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { ref, onMounted, watch } from 'vue'


import axios from 'axios'
import { Link } from '@inertiajs/vue3';

const subjects = ref([]);

// ডাটা ফেচ করার ফাংশন
const fetchSubjects = async () => {
    try {
        const response = await axios.get('/api/subjects'); // API রুট ঠিক করে নিবে
        subjects.value = response.data.subjects;
    } catch (error) {
        console.error('ডাটা লোড করতে সমস্যা হয়েছে:', error);
    }
};

// কম্পোনেন্ট লোড হওয়ার সাথে সাথে ডাটা লোড হবে


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

        // Log the entire first subject object to see all available properties
        console.log('Subject object structure:', JSON.stringify(response.data.subjects[0], null, 2));

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


const editSubject = (subject) => {
    console.log('Editing subject:', subject);

    // Make sure subject.marhala_id and subject.id are defined
    if (!subject.marhala_id || !subject.id) {
        console.error('Missing required parameters:', subject);
        return;
    }

    // Use the correct route name and parameters
    window.location.href = route('subjects_for_Admin.subject_setings_edit', {
        marhala: subject.marhala_id,
        id: subject.id
    });
};


// Watch for changes in filter values
watch([searchTerm, markazType, marhalaType, status], () => {
    fetchData();
});

onMounted(() => {
    fetchData();
});





// onMounted(() => {
//     fetchSubjects();
// });














</script>

<style scoped></style>
