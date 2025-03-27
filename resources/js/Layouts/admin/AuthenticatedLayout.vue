<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import Dropdown from '@/Components/admin/Dropdown.vue';
import DropdownLink from '@/Components/admin/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';

// Sidebar state
// const sidebarOpen = ref(true); // Changed initial state to true
// const isMobile = ref(false);

const showSidebar = ref(false);



// Dropdown states
const dropdownOpen = ref({
    takmil: false,
    Fazilat: false,
    orders: false,
    sanawia: false,
    mutawassita: false,
    ibtedaia: false,
    HifzulQuran: false,
    Qirat: false,
    nigran: false,
    mumtahin: false,
    zone: false,
    presentaion: false,
    result: false,
    bill: false,
});

// Notification & message states
const showNotifications = ref(false);
const showMessages = ref(false);

// Check window width and set mobile state
// Improved checkScreen function
// const checkScreen = () => {
//     isMobile.value = window.innerWidth < 768;
//     sidebarOpen.value = !isMobile.value;
// };

// Toggle sidebar for mobile
const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};



// Notification handlers
const openNotifications = () => {
    showNotifications.value = !showNotifications.value;
    showMessages.value = false;
};

const openMessages = () => {
    showMessages.value = !showMessages.value;
    showNotifications.value = false;
};

const mobileMenuOpen = ref(false)


const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value
}


const selectedItem = ref('');

// কোন লিংকে ক্লিক করা হয়েছে সেটার জন্য ফাংশন
const setSelected = (item) => {
    selectedItem.value = item;
}
</script>


<template>
<!-- massage & Notification -->



    <div

    style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"

    class="flex bg-gray-100 dark:bg-gray-900 min-h-screen">
        <!-- Sidebar -->
        <aside
        :class="[
                'fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 ease-in-out bg-[#004d40] text-white lg:translate-x-0',
                showSidebar ? 'translate-x-0' : '-translate-x-full'
            ]"
        >

          <!-- Replace the header div -->
<div class="flex bg-gradient-to-r h-16 justify-center text-lg text-white font-semibold from-emerald-600 items-center to-emerald-800">
    <div class="flex gap-2 items-center">
        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L3 9V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V9L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        এক্সাম মেনেজমেন্ট সিস্টেম
    </div>
</div>

            <nav style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;" class="max-h-[calc(100vh-4rem)] mt-4 overflow-y-auto scrollbar-hidden space-y-2">
               <Link :href="route('admin.admin_Dashboard')" class="flex text-lg gap-2 hover:bg-[#123524] items-center px-4 py-2">
        <i class="h-6 text-sm w-6 fa-mosque fas"></i>
       ই এম ড্যাশবোর্ড
    </Link>

<!-- তাকমিল -->
<div>
    <button @click="dropdownOpen.takmil = !dropdownOpen.takmil"
        class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
        <div class="flex gap-2 items-center">
            <i class="h-6 text-sm w-6 fa-cog fas"></i>
            সেটাপ সংক্রান্ত
        </div>
        <i :class="{'rotate-180': dropdownOpen.takmil}" class="fa-chevron-down fa-xs fas tex-sm transition-transform"></i>
    </button>

    <div v-if="dropdownOpen.takmil" class="pl-6">

        <Link :href="route('Mrahala_for_Admin.marhala_details_list')"
            @click="setSelected('marhala')"
            class="flex text-lg gap-2 hover:bg-[#123524] items-center px-4 py-2"
            :class="{'bg-[#123524] text-white': selectedItem === 'marhala'}">
            মারহালা সেটাপ
        </Link>

        <!-- subject_setup_list -->
        <Link :href="route('subjects_for_Admin.subject_search_wizard')"
            @click="setSelected('subject')"
            class="text-lg block hover:bg-[#123524] px-4 py-2"
            :class="{'bg-[#123524] text-white': selectedItem === 'subject'}">
            বিষয় সেটাপ
        </Link>

        <Link :href="route('central_Exam_setup.central_exam_mng')"
            @click="setSelected('central_exam')"
            class="text-lg block hover:bg-[#123524] px-4 py-2"
            :class="{'bg-[#123524] text-white': selectedItem === 'central_exam'}">
            কেন্দ্রীয় পরীক্ষা সেটাপ
        </Link>

        <Link :href="route('user_create_for_admin.user_create')"
            @click="setSelected('user_setup')"
            class="text-lg block hover:bg-[#123524] px-4 py-2"
            :class="{'bg-[#123524] text-white': selectedItem === 'user_setup'}">
            ব্যবহারকারী সেটাপ
        </Link>

        <Link href="route('Takmil.cirtificateProvide')"
            @click="setSelected('instruction')"
            class="text-lg block hover:bg-[#123524] px-4 py-2"
            :class="{'bg-[#123524] text-white': selectedItem === 'instruction'}">
            নির্দেশনা
        </Link>

    </div>
</div>





                <div>
                    <button @click="dropdownOpen.bill = !dropdownOpen.bill"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-cog fas"></i>
    ভাতা ও বিল
</div>
            <i :class="{'rotate-180': dropdownOpen.bill}" class="fa-chevron-down fa-xs fas tex-sm transition-transform"></i>
        </button>
        <div v-if="dropdownOpen.bill" class="pl-6">
            <Link :href="route('Bill_setup_admin.negran_bill_setup')" class="flex text-lg gap-2 hover:bg-[#123524] items-center px-4 py-2">
                <!-- <i class="h-5 w-5 fa-pen-fancy fas"></i> -->
     নেগরান ভাতা
            </Link>
                        <Link :href="route('Bill_setup_admin.mumtahin_bill')" class="text-lg block hover:bg-[#123524] px-4 py-2">মুমতাহিন ভাতা</Link>


                        <Link :href="route('Bill_setup_admin.markaz_admin_bill')" class="text-lg block hover:bg-[#123524] px-4 py-2">মারকায এডমিন ভাতা</Link>

                        <Link href="route('Takmil.cirtificateProvide')" class="text-lg block hover:bg-[#123524] px-4 py-2">জোনাল ভাতা</Link>



                    </div>
                </div>
                <!-- ফযিলত -->

                <div>
                     <button @click="dropdownOpen.orders = !dropdownOpen.orders"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-university fas"></i>
    মাদরাসা সংক্রান্ত
</div>
            <i :class="{'rotate-180': dropdownOpen.orders}" class="fa-chevron-down fa-xs fa-xstransition-transform fas"></i>
        </button>
        <div v-if="dropdownOpen.orders" class="pl-6">
            <Link :href="route('madrasha_data_for_admin.madrasha_list')"
                  class="flex text-lg gap-2 hover:bg-[#123524] items-center px-4 py-2">
                <!-- <i class="h-5 w-5 fa-user-graduate fas"></i> -->
             মাদরাসা তালিকা
            </Link>
                        <Link href="route('students_registration.stuedent_reg_list')" class="text-lg block hover:bg-[#123524] px-4 py-2">বিবিধ</Link>
                        <Link href="route('students_registration.student_reg_card')" class="text-lg block hover:bg-[#123524] px-4 py-2">মাদরাসা এডমিন</Link>
                        <Link href="route('students_registration.stue_reg_draft_soft_delete')" class="text-lg block hover:bg-[#123524] px-4 py-2">ড্রাফ্ট/সফ্ট ডিলিট</Link>
                        <Link href="route('students_registration.stu_reg_payment')" class="text-lg block hover:bg-[#123524] px-4 py-2">পেমেন্ট</Link>
                    </div>
                </div>


                <div>
                    <button @click="dropdownOpen.sanawia = !dropdownOpen.sanawia"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-mosque fas"></i>
    মারকায সংক্রান্ত
</div>
            <i :class="{'rotate-180': dropdownOpen.sanawia}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.sanawia" class="pl-6">
                        <Link :href="route('markaz_for_admin.markaz_setup')" class="text-lg block hover:bg-[#123524] px-4 py-2">মারকায আবেদন তালিকা</Link>
                        <Link href="route('OntorVukti.softDelete_draft_list')" class="text-lg block hover:bg-[#123524] px-4 py-2">প্রস্তাবিত মারকায</Link>
                        <Link :href="route('markaz_for_admin.all_markaz_list')" class="text-lg block hover:bg-[#123524] px-4 py-2">মারকায তালিকা</Link>
                        <Link href="route('OntorVukti.stu_payment')" class="text-lg block hover:bg-[#123524] px-4 py-2">মারকায পরিবর্তনের আবেদন</Link>
                        <Link href="route('OntorVukti.stu_payment')" class="text-lg block hover:bg-[#123524] px-4 py-2">মারকায এডমিন</Link>
                        <Link href="route('OntorVukti.stu_payment')" class="text-lg block hover:bg-[#123524] px-4 py-2">মারকায এডমিন ট্রেনিং</Link>
                        <Link href="route('OntorVukti.stu_payment')" class="text-lg block hover:bg-[#123524] px-4 py-2">মারকায গ্রুপ</Link>
                        <Link href="route('OntorVukti.stu_payment')" class="text-lg block hover:bg-[#123524] px-4 py-2">উত্তরপ্রত্র গ্রুপ সেটাপ</Link>
                        <Link href="route('OntorVukti.stu_payment')" class="text-lg block hover:bg-[#123524] px-4 py-2">মুমতাহিন গ্রুপ</Link>
                    </div>
                </div>


                <!-- মুতাওয়াসসিতাহ -->

                <div>
                     <button @click="dropdownOpen.mutawassita = !dropdownOpen.mutawassita"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-tasks fas"></i>
    পরীক্ষার রুটিন
</div>
            <i :class="{'rotate-180': dropdownOpen.mutawassita}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.mutawassita" class="pl-6">
                        <Link href="route('Negran_Mumtahin.negran_mumtahin')" class="text-lg block hover:bg-[#123524] px-4 py-2">পরীক্ষার রুটিন গ্রুপ</Link>
                        <Link href="route('Negran_Mumtahin.mumtahin_list')" class="text-lg block hover:bg-[#123524] px-4 py-2">পরীক্ষার রুটিন</Link>
                        <Link href="route('Negran_Mumtahin.negran_apoint_list')" class="text-lg block hover:bg-[#123524] px-4 py-2">মৌখিক পরীক্ষার মুমতাহিন</Link>
                    </div>
                </div>

                <!-- ইবতেদাইয়্যাহ -->


                <div>
                   <button @click="dropdownOpen.ibtedaia = !dropdownOpen.ibtedaia"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-user-plus fas"></i>
    নিবন্ধন সংক্রান্ত
</div>
            <i :class="{'rotate-180': dropdownOpen.ibtedaia}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.ibtedaia" class="pl-6">
                        <Link href="route('About_markaj.madrasha_list')" class="text-lg block hover:bg-[#123524] px-4 py-2">মাদরাসার তালিকা</Link>
                        <Link :href="route('nibondon_for_admin.nibondon_Markaz_list')" class="text-lg block hover:bg-[#123524] px-4 py-2">নিবন্ধন তালিকা</Link>
                        <Link href="route('nibondon_for_admin.abandon_stu_list')" class="text-lg block hover:bg-[#123524] px-4 py-2">বাতিলকৃত নিবন্ধন তালিকা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">পেমেন্ট তালিকা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">বোর্ড ফেরত তালিকা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">নিবন্ধন পত্র তৈরি</Link>
                    </div>
                </div>

<!-- হিফজুল কোরান -->

<div>
                  <button @click="dropdownOpen.HifzulQuran = !dropdownOpen.HifzulQuran"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-user-check fas"></i>
    অন্তর্ভুক্তি সংক্রান্ত
</div>
            <i :class="{'rotate-180': dropdownOpen.HifzulQuran}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.HifzulQuran" class="pl-6">
                        <Link href="route('Fajilat.sanawaia')" class="text-lg block hover:bg-[#123524] px-4 py-2">অন্তর্ভুক্তি তালিকা</Link>
                        <Link href="" class="text-lg block hover:bg-[#123524] px-4 py-2">রোল জেনারেট</Link>
                        <Link href="" class="text-lg block hover:bg-[#123524] px-4 py-2">প্রবেশপত্র তৈরি</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">পেমেন্ট</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">বাতিলকৃত নিবন্ধন তালিকা</Link>
                        <!-- <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">নিয়োগ রিপোর্ট</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">মাদরাসা রিপোর্ট</Link> -->
                    </div>
                </div>


                <!-- কিরাত -->


                <div>
                    <button @click="dropdownOpen.Qirat = !dropdownOpen.Qirat"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-book-open fas"></i>
    খাতা ও লুজ
</div>
            <i :class="{'rotate-180': dropdownOpen.Qirat}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.Qirat" class="pl-6">
                        <Link href="route('fazilat.sanawaia')" class="text-lg block hover:bg-[#123524] px-4 py-2">খাতা ও লুজ সেটাপ</Link>
                        <Link href="" class="text-lg block hover:bg-[#123524] px-4 py-2">খাতা ও লুজ জেনারেট</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">খাত ও লুজের হিসাব</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">অন্যান্য</Link>
                    </div>
                </div>


                <div>
                    <button @click="dropdownOpen.nigran = !dropdownOpen.nigran"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-users-cog fas"></i>
    নেগরান সংক্রান্ত
</div>
            <i :class="{'rotate-180': dropdownOpen.nigran}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.nigran" class="pl-6">
                        <Link href="route('fazilat.sanawaia')" class="text-lg block hover:bg-[#123524] px-4 py-2">আবেদন তালিকা</Link>
                        <Link href="" class="text-lg block hover:bg-[#123524] px-4 py-2">প্রস্তাবিত তালিকা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">অপেক্ষমান তালিকা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">বাতিল তালিকা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">মুমতাহিন তালিকা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">নেগরান রিপোর্ট</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">নেগরান ভাতা</Link>
                    </div>
                </div>



                <div>
                    <button @click="dropdownOpen.mumtahin = !dropdownOpen.mumtahin"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-chalkboard-teacher fas"></i>
    মুমতাহিন সংক্রান্ত
</div>
            <i :class="{'rotate-180': dropdownOpen.mumtahin}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.mumtahin" class="pl-6">
                        <Link href="route('fazilat.sanawaia')" class="text-lg block hover:bg-[#123524] px-4 py-2">আবেদন তালিকা</Link>
                        <Link href="" class="text-lg block hover:bg-[#123524] px-4 py-2">প্রস্তাবিত তালিকা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">নিরিক্ষক সেটাপ</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">মুমতাহিন তালিকা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">দরসিয়াত মুমতাহিন</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">হিফজ মুমতাহিন নির্বাচন</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">কিরাত মুমতাহিন নির্বাচন</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">মুমতাহিন ট্রেনিং</Link>
                    </div>
                </div>

                <div>
                    <button @click="dropdownOpen.zone = !dropdownOpen.zone"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-map-marked-alt fas"></i>
    জোন সংক্রান্ত
</div>
            <i :class="{'rotate-180': dropdownOpen.zone}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.zone" class="pl-6">
                        <Link href="route('fazilat.sanawaia')" class="text-lg block hover:bg-[#123524] px-4 py-2">জোন সেটাপ</Link>
                        <Link href="" class="text-lg block hover:bg-[#123524] px-4 py-2">জোনাল নির্বাচন</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">সাব জোন সেটাপ</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">জোনওয়ারী মারকায সেটাপ</Link>
                    </div>
                </div>

                <div>
                    <button @click="dropdownOpen.presentaion = !dropdownOpen.presentaion"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-clipboard-check fas"></i>
    হজিরা সংক্রান্ত
</div>
            <i :class="{'rotate-180': dropdownOpen.presentaion}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.presentaion" class="pl-6">
                        <Link href="route('fazilat.sanawaia')" class="text-lg block hover:bg-[#123524] px-4 py-2">পরীক্ষার্থী হাজিরা</Link>
                        <Link href="" class="text-lg block hover:bg-[#123524] px-4 py-2">নেগরান হাজিরা</Link>
                        <!-- <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">খাত ও লুজের হিসাব</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">অন্যান্য</Link> -->
                    </div>
                </div>

                <div>
                    <button @click="dropdownOpen.result = !dropdownOpen.result"
                class="flex justify-between text-lg w-full hover:bg-[#123524] items-center px-4 py-2">
                <div class="flex gap-2 items-center">
    <i class="h-6 text-sm w-6 fa-chart-line fas"></i>
    ফলাফল সংক্রান্ত
</div>
            <i :class="{'rotate-180': dropdownOpen.result}" class="fa-chevron-down fa-xs fas transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.result" class="pl-6">
                        <Link href="route('fazilat.sanawaia')" class="text-lg block hover:bg-[#123524] px-4 py-2">ফলাফল কন্ডিশন</Link>
                        <Link href="" class="text-lg block hover:bg-[#123524] px-4 py-2">মেধা কন্ডিশন</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">নিরিক্ষন ফরমুলা</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">দরসিয়াত ফলাফল</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2">মৌখিক ফলাফল</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2"> ফলাফল সংশোধন</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2"> নজরে সানী</Link>
                        <Link href="#" class="text-lg block hover:bg-[#123524] px-4 py-2"> নজরে সানী ফলাফল সংশোধন</Link>
                    </div>
                </div>






             <Link :href="route('others.massaging')" class="flex text-lg gap-2 hover:bg-[#123524] items-center px-4 py-2">
        <i class="h-6 text-sm w-6 fa-envelope fas"></i>
        মেসেজিং
    </Link>
                <Link :href="route('others.notice')" class="flex text-lg gap-2 hover:bg-[#123524] items-center px-4 py-2">
        <i class="h-6 text-sm w-6 fa-bell fas"></i>
        নোটিস
    </Link>








            </nav>
        </aside>

        <!-- Main Content -->
        <div
            :class="[
                'flex-1',
                'transition-all duration-300 ease-in-out',
                'md:ml-64'  // Always maintain margin on desktop
            ]"
        >

        <nav class="bg-[#F7F7F7] border-b border-emerald-100 dark:bg-gray-800 dark:border-gray-700 fixed left-0 md:left-64 right-0 z-10">
                <div class="lg:px-8 mx-auto px-4 sm:px-6">
                    <div class="flex h-16 justify-between items-center">
                        <button
                        @click="showSidebar = !showSidebar"
                        class="text-gray-600 focus:outline-none hover:text-gray-900 lg:hidden"
                    >
                        <span class="material-symbols-outlined">menu</span>
                    </button>

            <!-- Logo -->
            <div class="flex items-center">
                <!-- <i class="text-2xl text-emerald-600 dark:text-emerald-400 fa-mosque fas"></i> -->
            </div>

            <!-- Notification and User Dropdown -->
            <div class="hidden items-center sm:flex space-x-4">
                <!-- Prayer Times Button -->
                <button class="p-2 rounded-md text-emerald-600 dark:hover:text-emerald-300 dark:text-emerald-400 duration-300 group hover:text-emerald-700 relative transition-all">
                    <i class="h-6 w-6 duration-300 fa-kaaba fas group-hover:scale-110 transform transition-transform"></i>
                </button>

                <!-- Notification Icon -->
                <button @click="openNotifications" class="p-2 rounded-md text-emerald-600 dark:hover:text-emerald-300 dark:text-emerald-400 duration-300 group hover:text-emerald-700 relative transition-all">
                    <i class="h-6 w-6 duration-300 fa-bell fas group-hover:scale-110 transform transition-transform"></i>
                    <span class="bg-gradient-to-r h-5 justify-center rounded-full shadow-lg text-white text-xs -right-1 -top-1 absolute duration-300 font-bold from-emerald-500 group-hover:scale-110 inline-flex items-center min-w-[20px] px-1.5 scale-100 to-green-500 transform transition-transform">
                        3
                    </span>
                </button>

                <!-- Message Icon -->
                <button @click="openMessages" class="p-2 rounded-md text-emerald-600 dark:hover:text-emerald-300 dark:text-emerald-400 duration-300 group hover:text-emerald-700 relative transition-all">
                    <i class="h-6 w-6 duration-300 fa-envelope fas group-hover:scale-110 transform transition-transform"></i>
                    <span class="bg-gradient-to-r h-5 justify-center rounded-full shadow-lg text-white text-xs -right-1 -top-1 absolute duration-300 font-bold from-emerald-500 group-hover:scale-110 inline-flex items-center min-w-[20px] px-1.5 scale-100 to-green-500 transform transition-transform">
                        5
                    </span>
                </button>

                <!-- User Dropdown -->
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <span class="rounded-md inline-flex">
                            <button style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
                                class="bg-white border border-emerald-200 rounded-lg shadow-sm text-emerald-700 text-md dark:bg-gray-800 dark:border-emerald-600 dark:focus:ring-emerald-500 dark:hover:bg-emerald-700 dark:text-emerald-300 duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-300 font-medium hover:bg-emerald-50 inline-flex items-center leading-4 px-4 py-2 transition"
                            >
                                <i class="fa-user-circle fas mr-2"></i>
                                {{ $page.props.auth.admin.name }}
                                <i class="fa-chevron-down fas ml-2"></i>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('profile.edit')"
                            class="flex rounded-lg text-emerald-700 dark:hover:bg-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 items-center px-4 py-2 transition">
                            <i class="fa-user-edit fas mr-2"></i>
                            Profile
                        </DropdownLink>

                        <DropdownLink :href="route('admin.logout')" method="post" as="button"
                            class="flex rounded-lg text-red-600 dark:hover:bg-red-900 dark:text-red-400 hover:bg-red-50 items-center px-4 py-2 transition">
                            <i class="fa-sign-out-alt fas mr-2"></i>
                            Log Out
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
        </div>
    </div>
</nav>

<main class="flex-1 pt-16">
                <slot />
            </main>
        </div>
    </div>





<!-- Notification & massage model -->






<div
            v-show="showSidebar"
            @click="showSidebar = false"
            class="bg-black bg-opacity-50 fixed inset-0 lg:hidden z-40"
        ></div>






</template>

<style scoped>



</style>
