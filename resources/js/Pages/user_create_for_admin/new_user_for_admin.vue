<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Textarea from 'primevue/textarea';
import Password from 'primevue/password';
import Button from 'primevue/button';
import FileUpload from 'primevue/fileupload';


const designationOptions = [
  { name: 'সুপার এডমিন', value: '1' },
  { name: 'সহ সুপার এডমিন', value: '2' },
  { name: 'বোর্ড এডমিন', value: '3' }
];






const handleImageUpload = (event) => {
  const file = event.files[0];
  if (file) {
    // ফাইল ফর্মে সেট করা
    form.profile_image = file;

    // ইমেজ প্রিভিউ দেখানো
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);

    // আপলোড হওয়ার পর ফাইল সিলেক্টর ক্লিয়ার করা (যদি প্রয়োজন হয়)
    event.options.clear();
  }
};

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    nid: '',
    brn: '',
    phone: '',
    address: '',
    designation: '',
    profile_image: null,

    // Setup related permissions
    setup_access: false,
    marhala_setup: false,
    subject_setup: false,
    central_exam_setup: false,
    user_setup: false,
    instruction: false,

    // Bill related permissions
    bill_access: false,
    negran_bill: false,
    mumtahin_bill: false,
    markaz_admin_bill: false,
    zonal_bill: false,

    // Madrasa related permissions
    madrasa_access: false,
    madrasa_list: false,
    madrasa_misc: false,
    madrasa_admin: false,
    draft_soft_delete: false,
    madrasa_payment: false,

    // Markaz related permissions
    markaz_access: false,
    markaz_application_list: false,
    proposed_markaz: false,
    markaz_list: false,
    markaz_change_application: false,
    markaz_admin: false,
    markaz_admin_training: false,
    markaz_group: false,
    answer_sheet_group_setup: false,
    mumtahin_group: false,

    // Exam routine permissions
    exam_routine_access: false,
    exam_routine_group: false,
    exam_routine: false,
    oral_exam_mumtahin: false,

    // Registration related permissions
    registration_access: false,
    madrasa_list_reg: false,
    registration_list: false,
    cancelled_registration_list: false,
    payment_list: false,
    board_return_list: false,
    registration_card_create: false,

    // Inclusion related permissions
    inclusion_access: false,
    inclusion_list: false,
    roll_generate: false,
    admit_card_create: false,
    inclusion_payment: false,
    cancelled_inclusion_list: false,

    // Khata and Loose related permissions
    khata_loose_access: false,
    khata_loose_setup: false,
    khata_loose_generate: false,
    khata_loose_account: false,
    khata_loose_others: false,

    // Negran related permissions
    negran_access: false,
    negran_application_list: false,
    negran_proposed_list: false,
    negran_pending_list: false,
    negran_cancelled_list: false,
    negran_mumtahin_list: false,
    negran_report: false,
    negran_allowance: false,

    // Mumtahin related permissions
    mumtahin_access: false,
    mumtahin_application_list: false,
    mumtahin_proposed_list: false,
    inspector_setup: false,
    mumtahin_list: false,
    darsiyat_mumtahin: false,
    hifz_mumtahin_selection: false,
    kirat_mumtahin_selection: false,
    mumtahin_training: false,

    // Zone related permissions
    zone_access: false,
    zone_setup: false,
    zonal_selection: false,
    sub_zone_setup: false,
    zone_wise_markaz_setup: false,

    // Attendance related permissions
    attendance_access: false,
    examinee_attendance: false,
    negran_attendance: false,

    // Result related permissions
    result_access: false,
    result_condition: false,
    merit_condition: false,
    inspection_formula: false,
    darsiyat_result: false,
    oral_result: false,
    result_correction: false,
    result_review: false,
    review_result_correction: false,

    // Other permissions
    messaging: false,
    notice: false,
});

const errors = ref({});
const imagePreview = ref(null);
const activeTab = ref('basic');

// const handleImageUpload = (e) => {
//     const file = e.target.files[0];
//     if (file) {
//         form.profile_image = file;
//         const reader = new FileReader();
//         reader.onload = (e) => {
//             imagePreview.value = e.target.result;
//         };
//         reader.readAsDataURL(file);
//     }
// };

const toggleAllPermissions = (section, value) => {
    Object.keys(form).forEach(key => {
        if (key.startsWith(section) && key !== section + '_access') {
            form[key] = value;
        }
    });
};

const submit = () => {
    form.post(route('user_create_for_admin.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
        onError: (e) => {
            errors.value = e;
        }
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Create Admin User" />

        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">এডমিন সেটাপ</h2>

                        <!-- Tabs -->
                        <div class="mb-6 border-b">
                            <div class="flex">
                                <button
                                    @click="activeTab = 'basic'"
                                    :class="{'border-b-2 border-blue-500 text-blue-600': activeTab === 'basic'}"
                                    class="px-4 py-2 text-xl"
                                >
                               বেসিক তথ্য
                                </button>
                                <button
                                    @click="activeTab = 'permissions'"
                                    :class="{'border-b-2 border-blue-500 text-blue-600': activeTab === 'permissions'}"
                                     class="px-4 py-2 text-xl"
                                >
                                   পারমিশন সেটিং
                                </button>
                            </div>
                        </div>

                        <form @submit.prevent="submit">
                            <!-- Basic Information Tab -->
                            <div v-if="activeTab === 'basic'">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="col-span-1 md:col-span-2 flex justify-center">
      <div class="mb-4 text-center">
        <div class="w-32 h-40 mx-auto mb-2 overflow-hidden rounded-xl bg-gray-100 flex items-center justify-center border border-gray-300">
          <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover" />
          <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </div>
        <p class="text-xs text-gray-500 mb-2">পাসপোর্ট সাইজের ছবি (3.5 × 4.5 সেমি)</p>
        <FileUpload
  mode="basic"
  chooseLabel="ছবি আপলোড করুন"
  :customUpload="true"
  @uploader="handleImageUpload"
  accept="image/*"
  class="p-button-primary"
/>
        <small v-if="form.errors.profile_image" class="p-error">{{ form.errors.profile_image }}</small>
      </div>
    </div>
    <div class="mb-4">
      <span class="p-float-label">
        <InputText id="name" v-model="form.name" class="w-full text-xl" required autofocus autocomplete="name" />
        <label for="name" class="text-xl">নাম</label>
      </span>
      <small v-if="form.errors.name" class="p-error">{{ form.errors.name }}</small>
    </div>
    <div class="mb-4">
      <span class="p-float-label">
        <InputText id="email" v-model="form.email" class="w-full text-xl" type="email" required autocomplete="username" />
        <label for="email" class="text-xl">ইমেইল</label>
      </span>
      <small v-if="form.errors.email" class="p-error">{{ form.errors.email }}</small>
    </div>
    <div class="mb-4">
      <span class="p-float-label">
        <InputText id="phone" v-model="form.phone" class="w-full text-xl" />
        <label for="phone" class="text-xl">ফোন নম্বর</label>
      </span>
      <small v-if="form.errors.phone" class="p-error">{{ form.errors.phone }}</small>
    </div>
    <div class="mb-4">
      <span class="p-float-label">
        <Dropdown id="designation" v-model="form.designation" :options="designationOptions" optionLabel="name" optionValue="value" placeholder="পদবি সিলেক্ট করুন" class="w-full text-xl" />
        <label for="designation" class="text-xl">পদবি</label>
      </span>
      <small v-if="form.errors.designation" class="p-error">{{ form.errors.designation }}</small>
    </div>
    <div class="mb-4">
      <span class="p-float-label">
        <InputText id="nid" v-model="form.nid" class="w-full text-xl" />
        <label for="nid" class="text-xl">এন আই ডি নম্বর</label>
      </span>
      <small v-if="form.errors.nid" class="p-error">{{ form.errors.nid }}</small>
    </div>
    <div class="mb-4">
      <span class="p-float-label">
        <InputText id="brn" v-model="form.brn" class="w-full text-xl" />
        <label for="brn" class="text-xl">জন্ম-নিবন্ধন নম্বর</label>
      </span>
      <small v-if="form.errors.brn" class="p-error">{{ form.errors.brn }}</small>
    </div>
    <div class="mb-4 col-span-1 md:col-span-2">
      <span class="p-float-label">
        <Textarea id="address" v-model="form.address" rows="3" class="w-full text-xl" />
        <label for="address" class="text-xl">ঠিকানা</label>
      </span>
      <small v-if="form.errors.address" class="p-error">{{ form.errors.address }}</small>
    </div>
    <div class="mb-4">
  <span class="p-float-label">
    <Password
      id="password"
      v-model="form.password"
      :feedback="false"
      :toggleMask="true"
      inputClass="w-full text-xl"
      required
      autocomplete="new-password"
      inputStyle="width: 100%"
    />
    <label for="password" class="text-xl">পাসওয়ার্ড</label>
  </span>
  <small v-if="form.errors.password" class="p-error">{{ form.errors.password }}</small>
</div>

<div class="mb-4">
  <span class="p-float-label">
    <Password
      id="password_confirmation"
      v-model="form.password_confirmation"
      :feedback="false"
      :toggleMask="true"
      inputClass="w-full text-xl"
      required
      autocomplete="new-password"
      inputStyle="width: 100%"
    />
    <label for="password_confirmation" class="text-xl">পাসওয়ার্ড নিশ্চিতকরণ</label>
  </span>
  <small v-if="form.errors.password_confirmation" class="p-error">{{ form.errors.password_confirmation }}</small>
</div>

  </div>
  <div class="flex justify-between mt-6">
    <div></div>
    <Button
      label="Next: Set Permissions"
      @click="activeTab = 'permissions'"
      class="p-button-primary"
    />
  </div>
</div>






                            <!-- Permissions Tab -->
                            <div v-if="activeTab === 'permissions'" class="space-y-8">
                                <!-- Setup Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="setup_access"
                                                v-model="form.setup_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('setup', form.setup_access)"
                                            >
                                            <label for="setup_access" class=" text-gray-700 text-xl font-semibold">সেটাপ সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.setup_access = !form.setup_access; toggleAllPermissions('setup', form.setup_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.setup_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="marhala_setup" v-model="form.marhala_setup" class="mr-2">
                                            <label for="marhala_setup" class="text-xl">মারহালা সেটাপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="subject_setup" v-model="form.subject_setup" class="mr-2">
                                            <label for="subject_setup">বিষয় সেটাপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="central_exam_setup" v-model="form.central_exam_setup" class="mr-2">
                                            <label for="central_exam_setup">কেন্দ্রীয় পরীক্ষা সেটাপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="user_setup" v-model="form.user_setup" class="mr-2">
                                            <label for="user_setup">ব্যবহারকারী সেটাপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="instruction" v-model="form.instruction" class="mr-2">
                                            <label for="instruction">নির্দেশনা</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bill Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="bill_access"
                                                v-model="form.bill_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('bill', form.bill_access)"
                                            >
                                            <label for="bill_access" class=" text-gray-700 text-xl font-semibold">ভাতা ও বিল</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.bill_access = !form.bill_access; toggleAllPermissions('bill', form.bill_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.bill_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="negran_bill" v-model="form.negran_bill" class="mr-2">
                                            <label for="negran_bill">নেগরান ভাতা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="mumtahin_bill" v-model="form.mumtahin_bill" class="mr-2">
                                            <label for="mumtahin_bill">মুমতাহিন ভাতা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="markaz_admin_bill" v-model="form.markaz_admin_bill" class="mr-2">
                                            <label for="markaz_admin_bill">মারকায এডমিন ভাতা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="zonal_bill" v-model="form.zonal_bill" class="mr-2">
                                            <label for="zonal_bill">জোনাল ভাতা</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Madrasa Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="madrasa_access"
                                                v-model="form.madrasa_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('madrasa', form.madrasa_access)"
                                            >
                                            <label for="madrasa_access" class=" text-gray-700 text-xl font-semibold">মাদরাসা সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.madrasa_access = !form.madrasa_access; toggleAllPermissions('madrasa', form.madrasa_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.madrasa_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="madrasa_list" v-model="form.madrasa_list" class="mr-2">
                                            <label for="madrasa_list">মাদরাসা তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="madrasa_misc" v-model="form.madrasa_misc" class="mr-2">
                                            <label for="madrasa_misc">বিবিধ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="madrasa_admin" v-model="form.madrasa_admin" class="mr-2">
                                            <label for="madrasa_admin">মাদরাসা এডমিন</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="draft_soft_delete" v-model="form.draft_soft_delete" class="mr-2">
                                            <label for="draft_soft_delete">ড্রাফ্ট/সফ্ট ডিলিট</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="madrasa_payment" v-model="form.madrasa_payment" class="mr-2">
                                            <label for="madrasa_payment">পেমেন্ট</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Markaz Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="markaz_access"
                                                v-model="form.markaz_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('markaz', form.markaz_access)"
                                            >
                                            <label for="markaz_access" class=" text-gray-700 text-xl font-semibold">মারকায সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.markaz_access = !form.markaz_access; toggleAllPermissions('markaz', form.markaz_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.markaz_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="markaz_application_list" v-model="form.markaz_application_list" class="mr-2">
                                            <label for="markaz_application_list">মারকায আবেদন তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="proposed_markaz" v-model="form.proposed_markaz" class="mr-2">
                                            <label for="proposed_markaz">প্রস্তাবিত মারকায</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="markaz_list" v-model="form.markaz_list" class="mr-2">
                                            <label for="markaz_list">মারকায তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="markaz_change_application" v-model="form.markaz_change_application" class="mr-2">
                                            <label for="markaz_change_application">মারকায পরিবর্তনের আবেদন</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="markaz_admin" v-model="form.markaz_admin" class="mr-2">
                                            <label for="markaz_admin">মারকায এডমিন</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="markaz_admin_training" v-model="form.markaz_admin_training" class="mr-2">
                                            <label for="markaz_admin_training">মারকায এডমিন ট্রেনিং</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="markaz_group" v-model="form.markaz_group" class="mr-2">
                                            <label for="markaz_group">মারকায গ্রুপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="answer_sheet_group_setup" v-model="form.answer_sheet_group_setup" class="mr-2">
                                            <label for="answer_sheet_group_setup">উত্তরপ্রত্র গ্রুপ সেটাপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="mumtahin_group" v-model="form.mumtahin_group" class="mr-2">
                                            <label for="mumtahin_group">মুমতাহিন গ্রুপ</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Exam Routine Permissions -->
                                <!-- Exam Routine Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="exam_routine_access"
                                                v-model="form.exam_routine_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('exam_routine', form.exam_routine_access)"
                                            >
                                            <label for="exam_routine_access" class=" text-gray-700 text-xl font-semibold">পরীক্ষার রুটিন</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.exam_routine_access = !form.exam_routine_access; toggleAllPermissions('exam_routine', form.exam_routine_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.exam_routine_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="exam_routine_group" v-model="form.exam_routine_group" class="mr-2">
                                            <label for="exam_routine_group">পরীক্ষার রুটিন গ্রুপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="exam_routine" v-model="form.exam_routine" class="mr-2">
                                            <label for="exam_routine">পরীক্ষার রুটিন</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="oral_exam_mumtahin" v-model="form.oral_exam_mumtahin" class="mr-2">
                                            <label for="oral_exam_mumtahin">মৌখিক পরীক্ষার মুমতাহিন</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Registration Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="registration_access"
                                                v-model="form.registration_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('registration', form.registration_access)"
                                            >
                                            <label for="registration_access" class=" text-gray-700 text-xl font-semibold">রেজিস্ট্রেশন সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.registration_access = !form.registration_access; toggleAllPermissions('registration', form.registration_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.registration_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="madrasa_list_reg" v-model="form.madrasa_list_reg" class="mr-2">
                                            <label for="madrasa_list_reg">মাদরাসা তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="registration_list" v-model="form.registration_list" class="mr-2">
                                            <label for="registration_list">রেজিস্ট্রেশন তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="cancelled_registration_list" v-model="form.cancelled_registration_list" class="mr-2">
                                            <label for="cancelled_registration_list">বাতিলকৃত রেজিস্ট্রেশন তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="payment_list" v-model="form.payment_list" class="mr-2">
                                            <label for="payment_list">পেমেন্ট তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="board_return_list" v-model="form.board_return_list" class="mr-2">
                                            <label for="board_return_list">বোর্ড রিটার্ন তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="registration_card_create" v-model="form.registration_card_create" class="mr-2">
                                            <label for="registration_card_create">রেজিস্ট্রেশন কার্ড তৈরি</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Inclusion Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="inclusion_access"
                                                v-model="form.inclusion_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('inclusion', form.inclusion_access)"
                                            >
                                            <label for="inclusion_access" class=" text-gray-700 text-xl font-semibold">অন্তর্ভুক্তি সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.inclusion_access = !form.inclusion_access; toggleAllPermissions('inclusion', form.inclusion_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.inclusion_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="inclusion_list" v-model="form.inclusion_list" class="mr-2">
                                            <label for="inclusion_list">অন্তর্ভুক্তি তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="roll_generate" v-model="form.roll_generate" class="mr-2">
                                            <label for="roll_generate">রোল জেনারেট</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="admit_card_create" v-model="form.admit_card_create" class="mr-2">
                                            <label for="admit_card_create">প্রবেশপত্র তৈরি</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="inclusion_payment" v-model="form.inclusion_payment" class="mr-2">
                                            <label for="inclusion_payment">অন্তর্ভুক্তি পেমেন্ট</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="cancelled_inclusion_list" v-model="form.cancelled_inclusion_list" class="mr-2">
                                            <label for="cancelled_inclusion_list">বাতিলকৃত অন্তর্ভুক্তি তালিকা</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Khata and Loose Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="khata_loose_access"
                                                v-model="form.khata_loose_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('khata_loose', form.khata_loose_access)"
                                            >
                                            <label for="khata_loose_access" class=" text-gray-700 text-xl font-semibold">খাতা ও লুজ সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.khata_loose_access = !form.khata_loose_access; toggleAllPermissions('khata_loose', form.khata_loose_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.khata_loose_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="khata_loose_setup" v-model="form.khata_loose_setup" class="mr-2">
                                            <label for="khata_loose_setup">খাতা ও লুজ সেটাপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="khata_loose_generate" v-model="form.khata_loose_generate" class="mr-2">
                                            <label for="khata_loose_generate">খাতা ও লুজ জেনারেট</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="khata_loose_account" v-model="form.khata_loose_account" class="mr-2">
                                            <label for="khata_loose_account">খাতা ও লুজ হিসাব</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="khata_loose_others" v-model="form.khata_loose_others" class="mr-2">
                                            <label for="khata_loose_others">অন্যান্য</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Negran Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="negran_access"
                                                v-model="form.negran_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('negran', form.negran_access)"
                                            >
                                            <label for="negran_access" class="font-medium text-gray-700 text-xl ">নেগরান সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.negran_access = !form.negran_access; toggleAllPermissions('negran', form.negran_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.negran_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="negran_application_list" v-model="form.negran_application_list" class="mr-2">
                                            <label for="negran_application_list">নেগরান আবেদন তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="negran_proposed_list" v-model="form.negran_proposed_list" class="mr-2">
                                            <label for="negran_proposed_list">প্রস্তাবিত নেগরান তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="negran_pending_list" v-model="form.negran_pending_list" class="mr-2">
                                            <label for="negran_pending_list">অনিষ্পন্ন নেগরান তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="negran_cancelled_list" v-model="form.negran_cancelled_list" class="mr-2">
                                            <label for="negran_cancelled_list">বাতিলকৃত নেগরান তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="negran_mumtahin_list" v-model="form.negran_mumtahin_list" class="mr-2">
                                            <label for="negran_mumtahin_list">নেগরান-মুমতাহিন তালিকা</label>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="checkbox" id="negran_report" v-model="form.negran_report" class="mr-2">
                                            <label for="negran_report">নেগরান রিপোর্ট</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="negran_allowance" v-model="form.negran_allowance" class="mr-2">
                                            <label for="negran_allowance">নেগরান ভাতা</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mumtahin Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="mumtahin_access"
                                                v-model="form.mumtahin_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('mumtahin', form.mumtahin_access)"
                                            >
                                            <label for="mumtahin_access" class="font-medium text-gray-700 text-xl ">মুমতাহিন সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.mumtahin_access = !form.mumtahin_access; toggleAllPermissions('mumtahin', form.mumtahin_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.mumtahin_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="mumtahin_application_list" v-model="form.mumtahin_application_list" class="mr-2">
                                            <label for="mumtahin_application_list">মুমতাহিন আবেদন তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="mumtahin_proposed_list" v-model="form.mumtahin_proposed_list" class="mr-2">
                                            <label for="mumtahin_proposed_list">প্রস্তাবিত মুমতাহিন তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="inspector_setup" v-model="form.inspector_setup" class="mr-2">
                                            <label for="inspector_setup">পরিদর্শক সেটাপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="mumtahin_list" v-model="form.mumtahin_list" class="mr-2">
                                            <label for="mumtahin_list">মুমতাহিন তালিকা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="darsiyat_mumtahin" v-model="form.darsiyat_mumtahin" class="mr-2">
                                            <label for="darsiyat_mumtahin">দারসিয়াত মুমতাহিন</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="hifz_mumtahin_selection" v-model="form.hifz_mumtahin_selection" class="mr-2">
                                            <label for="hifz_mumtahin_selection">হিফজ মুমতাহিন নির্বাচন</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="kirat_mumtahin_selection" v-model="form.kirat_mumtahin_selection" class="mr-2">
                                            <label for="kirat_mumtahin_selection">কিরাত মুমতাহিন নির্বাচন</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="mumtahin_training" v-model="form.mumtahin_training" class="mr-2">
                                            <label for="mumtahin_training">মুমতাহিন প্রশিক্ষণ</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Zone Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="zone_access"
                                                v-model="form.zone_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('zone', form.zone_access)"
                                            >
                                            <label for="zone_access" class="font-medium text-gray-700 text-xl ">জোন সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.zone_access = !form.zone_access; toggleAllPermissions('zone', form.zone_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.zone_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="zone_setup" v-model="form.zone_setup" class="mr-2">
                                            <label for="zone_setup">জোন সেটাপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="zonal_selection" v-model="form.zonal_selection" class="mr-2">
                                            <label for="zonal_selection">জোনাল নির্বাচন</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="sub_zone_setup" v-model="form.sub_zone_setup" class="mr-2">
                                            <label for="sub_zone_setup">সাব-জোন সেটাপ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="zone_wise_markaz_setup" v-model="form.zone_wise_markaz_setup" class="mr-2">
                                            <label for="zone_wise_markaz_setup">জোন অনুযায়ী মারকায সেটাপ</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="attendance_access"
                                                v-model="form.attendance_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('attendance', form.attendance_access)"
                                            >
                                            <label for="attendance_access" class=" text-gray-700 text-xl font-semibold">হাজিরা সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.attendance_access = !form.attendance_access; toggleAllPermissions('attendance', form.attendance_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.attendance_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="examinee_attendance" v-model="form.examinee_attendance" class="mr-2">
                                            <label for="examinee_attendance">পরীক্ষার্থী হাজিরা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="negran_attendance" v-model="form.negran_attendance" class="mr-2">
                                            <label for="negran_attendance">নেগরান হাজিরা</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Result Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="result_access"
                                                v-model="form.result_access"
                                                class="mr-2"
                                                @change="toggleAllPermissions('result', form.result_access)"
                                            >
                                            <label for="result_access" class="font-medium text-gray-700 text-xl ">ফলাফল সংক্রান্ত</label>
                                        </div>
                                        <button
                                            type="button"
                                            @click="form.result_access = !form.result_access; toggleAllPermissions('result', form.result_access)"
                                            class="text-xl text-blue-500 hover:text-blue-700"
                                        >
                                            {{ form.result_access ? 'Deselect All' : 'Select All' }}
                                        </button>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="result_condition" v-model="form.result_condition" class="mr-2">
                                            <label for="result_condition">ফলাফল শর্ত</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="merit_condition" v-model="form.merit_condition" class="mr-2">
                                            <label for="merit_condition">মেধা শর্ত</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="inspection_formula" v-model="form.inspection_formula" class="mr-2">
                                            <label for="inspection_formula">পরিদর্শন ফর্মুলা</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="darsiyat_result" v-model="form.darsiyat_result" class="mr-2">
                                            <label for="darsiyat_result">দারসিয়াত ফলাফল</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="oral_result" v-model="form.oral_result" class="mr-2">
                                            <label for="oral_result">মৌখিক ফলাফল</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="result_correction" v-model="form.result_correction" class="mr-2">
                                            <label for="result_correction">ফলাফল সংশোধন</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="result_review" v-model="form.result_review" class="mr-2">
                                            <label for="result_review">ফলাফল পুনঃনিরীক্ষণ</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="review_result_correction" v-model="form.review_result_correction" class="mr-2">
                                            <label for="review_result_correction">পুনঃনিরীক্ষণ ফলাফল সংশোধন</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Other Permissions -->
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b">
                                        <div class="font-medium text-gray-700 text-xl ">অন্যান্য</div>
                                    </div>
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="messaging" v-model="form.messaging" class="mr-2">
                                            <label for="messaging">মেসেজিং</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="notice" v-model="form.notice" class="mr-2">
                                            <label for="notice">নোটিশ</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between mt-6">
                                    <button
                                        type="button"
                                        @click="activeTab = 'basic'"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"

                                    >
                                        Back to Basic Info
                                    </button>
                                    <button
                                        type="submit"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                        :disabled="form.processing"
                                    >
                                        <span v-if="form.processing">Processing...</span>
                                        <span v-else>Create Admin User</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
