<script setup>
import { ref, onMounted, computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';
 import { usePage } from '@inertiajs/vue3';
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
    Qirat: false
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


const page = usePage()



</script>


<template>
<!-- massage & Notification -->



    <div

    style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"

    class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside
        :class="[
                'fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 ease-in-out bg-[#004d40] text-white lg:translate-x-0',
                showSidebar ? 'translate-x-0' : '-translate-x-full'
            ]"
        >

          <!-- Replace the header div -->
<div class="h-16 flex text-xl items-center justify-center bg-gradient-to-r from-emerald-600 to-emerald-800 text-white font-semibold">
    <div class="flex items-center gap-2">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L3 9V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V9L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        এক্সাম মেনেজমেন্ট সিস্টেম
    </div>
</div>

            <nav style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;" class="mt-4 space-y-2 overflow-y-auto max-h-[calc(100vh-4rem)] scrollbar-hidden">
               <Link :href="route('dashboard')" class="text-xl px-4 py-2 hover:bg-[#123524] flex items-center gap-2">
        <i class="fas fa-mosque w-6 h-6 text-sm"></i>
        ড্যাশবোর্ড
    </Link>

<!-- তাকমিল -->
<div>
                    <button @click="dropdownOpen.takmil = !dropdownOpen.takmil"
                class="w-full text-xl flex justify-between items-center px-4 py-2 hover:bg-[#123524]">
            <div class="flex items-center gap-2">
                <i class="fas fa-file-alt w-6 h-6 text-sm"></i>
                আবেদন সংক্রান্ত
            </div>
            <i :class="{'rotate-180': dropdownOpen.takmil}" class="fas fa-chevron-down fa-xs transition-transform"></i>
        </button>
        <div v-if="dropdownOpen.takmil" class="pl-6">
            <Link :href="route('Markaz.Makaj_apply')" class="px-4 py-2 text-xl hover:bg-[#123524] flex items-center gap-2">
                <!-- <i class="fas fa-pen-fancy w-5 h-5"></i> -->
                মারকায আবেদন
            </Link>
            <Link
    v-if="!$page.props.auth.user.markaz_serial"
    :href="route('Markaz.markaz_change_table')"
    class="block px-4 py-2 text-xl hover:bg-[#123524]"
>
    মারকায পরিবর্তন
</Link>

<Link :href="route('Markaz.subjectSettings_for_madrasha')" class="block px-4 py-2 text-xl hover:bg-[#123524]">বিষয় সেটাপ</Link>
                        <Link :href="route('Markaz.marhala_change_table')" class="block px-4 py-2 text-xl hover:bg-[#123524]">মারহালা পরিবর্তন</Link>
                        <Link href="route('Takmil.cirtificateProvide')" class="block px-4 py-2 text-xl hover:bg-[#123524]">মন্জুরী পত্র আবেদন</Link>

                    </div>
                </div>

                <!-- ফযিলত -->

                <div>
                     <button @click="dropdownOpen.orders = !dropdownOpen.orders"
                class="w-full text-xl flex justify-between items-center px-4 py-2 hover:bg-[#123524]">
            <div class="flex items-center gap-2">
                <i class="fas fa-user-plus w-6 h-6 text-sm"></i>
                নিবন্ধন সংক্রান্ত
            </div>
            <i :class="{'rotate-180': dropdownOpen.orders}" class="fas fa-chevron-down fa-xs fa-xstransition-transform"></i>
        </button>
        <div v-if="dropdownOpen.orders" class="pl-6">
            <Link :href="route('students_registration.student_registration')"
                  class=" px-4 py-2 text-xl hover:bg-[#123524] flex items-center gap-2">
                <!-- <i class="fas fa-user-graduate w-5 h-5"></i> -->
                পরীক্ষার্থী নিবন্ধন
            </Link>
                        <Link :href="route('students_registration.stuedent_reg_list')" class="block text-xl px-4 py-2 hover:bg-[#123524]">নিবন্ধন তালিকা</Link>
                        <Link :href="route('students_registration.student_reg_card')" class="block px-4 text-xl py-2 hover:bg-[#123524]">নিবন্ধন পত্র</Link>
                        <Link :href="route('students_registration.stue_reg_draft_soft_delete')" class="block px-4 text-xl py-2 hover:bg-[#123524]">ড্রাফ্ট/সফ্ট ডিলিট</Link>
                        <Link :href="route('students_registration.stu_reg_payment')" class="block px-4 text-xl  py-2 hover:bg-[#123524]">পেমেন্ট</Link>
                    </div>
                </div>


                <div>
                    <button @click="dropdownOpen.sanawia = !dropdownOpen.sanawia"
                class="w-full text-xl flex justify-between items-center px-4 py-2 hover:bg-[#123524]">
            <div class="flex items-center gap-2">
                <i class="fas fa-users w-6 h-6 text-sm"></i>
                অন্তর্ভুক্তি সংক্রান্ত
            </div>
            <i :class="{'rotate-180': dropdownOpen.sanawia}" class="fas fa-chevron-down fa-xs transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.sanawia" class="pl-6">
                        <Link :href="route('OntorVukti.ontorvukti_table')" class="block text-xl px-4 py-2 hover:bg-[#123524]">অন্তর্ভূূূূূূূূূূক্তি তালিকা</Link>
                        <Link :href="route('OntorVukti.softDelete_draft_list')" class="block px-4 text-xl py-2 hover:bg-[#123524]">ড্রাফ্ট তালিকা</Link>
                        <Link :href="route('OntorVukti.stu_admit_card')" class="block px-4 text-xl py-2 hover:bg-[#123524]">প্রবেশপত্র</Link>
                        <Link :href="route('OntorVukti.stu_payment')" class="block px-4 text-xl py-2 hover:bg-[#123524]">পেমেন্ট</Link>
                    </div>
                </div>


                <!-- মুতাওয়াসসিতাহ -->

                <div>
                     <button @click="dropdownOpen.mutawassita = !dropdownOpen.mutawassita"
                class="w-full text-xl flex justify-between items-center px-4 py-2 hover:bg-[#123524]">
            <div class="flex items-center gap-2">
                <i class="fas fa-user-shield w-6 h-6 text-sm"></i>
                নেগরান/মুমতাহিন
            </div>
            <i :class="{'rotate-180': dropdownOpen.mutawassita}" class="fas fa-chevron-down fa-xs transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.mutawassita" class="pl-6">
                        <Link :href="route('Negran_Mumtahin.negran_mumtahin')" class="block text-xl px-4 py-2 hover:bg-[#123524]">নেগ:/মুম: আবেদন</Link>
                        <Link :href="route('Negran_Mumtahin.mumtahin_list')" class="block px-4 py-2 text-xl hover:bg-[#123524]">মুমতাহিন তালিকা</Link>
                        <Link :href="route('Negran_Mumtahin.negran_apoint_list')" class="block px-4 py-2 text-xl hover:bg-[#123524]">নিয়োগপত্র</Link>
                    </div>
                </div>

                <!-- ইবতেদাইয়্যাহ -->


                <div v-if="$page.props.auth.user.markaz_serial">
    <button @click="dropdownOpen.ibtedaia = !dropdownOpen.ibtedaia"
        class="w-full text-xl flex justify-between items-center px-4 py-2 hover:bg-[#123524]">
        <div class="flex items-center gap-2">
            <i class="fas fa-school w-6 h-6 text-sm"></i>
            মারকায সংক্রান্ত
        </div>
        <i :class="{'rotate-180': dropdownOpen.ibtedaia}" class="fas fa-chevron-down fa-xs transition-transform"></i>
    </button>
    <div v-if="dropdownOpen.ibtedaia" class="pl-6">
        <Link href="route('About_markaj.madrasha_list')" class="block text-xl px-4 py-2 hover:bg-[#123524]">মাদরাসার তালিকা</Link>
        <Link href="" class="block px-4 py-2 hover:bg-[#123524] text-xl">নেগরান তালিকা</Link>
        <Link href="#" class="block px-4 py-2 hover:bg-[#123524] text-xl">প্রশ্নপত্র প্রিন্ট</Link>
        <Link href="#" class="block px-4 py-2 hover:bg-[#123524] text-xl">ভাউচার তৈরি</Link>
        <Link href="#" class="block px-4 py-2 hover:bg-[#123524] text-xl">ছাত্রদের হাজিরা</Link>
        <Link href="#" class="block px-4 py-2 hover:bg-[#123524] text-xl">নেগরানদের হাজিরা</Link>
    </div>
</div>

<!-- হিফজুল কোরান -->

<div>
                  <button @click="dropdownOpen.HifzulQuran = !dropdownOpen.HifzulQuran"
                class="w-full text-xl flex justify-between items-center px-4 py-2 hover:bg-[#123524]">
            <div class="flex items-center gap-2">
                <i class="fas fa-chart-bar w-6 h-6 text-sm"></i>
                রিপোর্টস
            </div>
            <i :class="{'rotate-180': dropdownOpen.HifzulQuran}" class="fas fa-chevron-down fa-xs transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.HifzulQuran" class="pl-6">
                        <Link href="route('Fajilat.sanawaia')" class="block px-4 py-2 text-xl hover:bg-[#123524]">নিবন্ধন রিপোর্ট</Link>
                        <Link href="" class="block px-4 py-2 hover:bg-[#123524] text-xl">অন্তর্ভূক্তি রিপোর্ট</Link>
                        <Link href="" class="block px-4 py-2 hover:bg-[#123524] text-xl">নেগ:/মুম রিপোর্ট</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-[#123524] text-xl">হাজিরা রিপোর্ট</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-[#123524] text-xl">পেমেন্ট রিপোর্ট</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-[#123524] text-xl">নিয়োগ রিপোর্ট</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-[#123524] text-xl">মাদরাসা রিপোর্ট</Link>
                    </div>
                </div>


                <!-- কিরাত -->


                <div>
                    <button @click="dropdownOpen.Qirat = !dropdownOpen.Qirat"
                class="w-full text-xl flex justify-between items-center px-4 py-2 hover:bg-[#123524]">
            <div class="flex items-center gap-2">
                <i class="fas fa-file-alt w-6 h-6 text-sm"></i>
                প্রয়োজনীয় ডকুমেন্টস
            </div>
            <i :class="{'rotate-180': dropdownOpen.Qirat}" class="fas fa-chevron-down fa-xs transition-transform"></i>
        </button>
                    <div v-if="dropdownOpen.Qirat" class="pl-6">
                        <Link href="route('fazilat.sanawaia')" class="block px-4 py-2 hover:bg-[#123524] text-xl">সকল ছাত্র</Link>
                        <Link href="" class="block px-4 py-2 hover:bg-[#123524] text-xl">আবেদন তালিকা</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-[#123524] text-xl">সনদ কর্যক্রম</Link>
                    </div>
                </div>






             <Link :href="route('others.massaging')" class=" px-4 text-xl py-2 hover:bg-[#123524] flex items-center gap-2">
        <i class="fas fa-envelope w-6 h-6 text-sm"></i>
        মেসেজিং
    </Link>
                <Link :href="route('others.notice')" class="px-4 text-xl py-2 hover:bg-[#123524] flex items-center gap-2">
        <i class="fas fa-bell w-6 h-6 text-sm"></i>
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

        <nav class="bg-[#F7F7F7] dark:bg-gray-800 border-b border-emerald-100 dark:border-gray-700 fixed right-0 left-0 z-10 md:left-64">
                <div class=" mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between items-center">
                        <button
                        @click="showSidebar = !showSidebar"
                        class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none"
                    >
                        <span class="material-symbols-outlined">menu</span>
                    </button>

            <!-- Logo -->
            <div class="flex items-center flex-grow justify-center">
    <h1 class="text-2xl font-semibold text-center">
      {{ page.props.auth.user.madrasha_name }} {{ page.props.auth.user.thana }} ({{ page.props.auth.user.custom_code }})
    </h1>
  </div>

            <!-- Notification and User Dropdown -->
            <div class="hidden sm:flex items-center space-x-4">
                <!-- Prayer Times Button -->
                <button class="relative text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 p-2 rounded-md group transition-all duration-300">
                    <i class="fas fa-kaaba h-6 w-6 transform group-hover:scale-110 transition-transform duration-300"></i>
                </button>

                <!-- Notification Icon -->
                <button @click="openNotifications" class="relative text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 p-2 rounded-md group transition-all duration-300">
                    <i class="fas fa-bell h-6 w-6 transform group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-green-500 rounded-full transform scale-100 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        3
                    </span>
                </button>

                <!-- Message Icon -->
                <button @click="openMessages" class="relative text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 p-2 rounded-md group transition-all duration-300">
                    <i class="fas fa-envelope h-6 w-6 transform group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-green-500 rounded-full transform scale-100 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        5
                    </span>
                </button>

                <!-- User Dropdown -->
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-600 rounded-lg shadow-sm text-md font-medium leading-4 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 dark:focus:ring-emerald-500 transition duration-150 ease-in-out"
                            >
                                <i class="fas fa-user-circle mr-2"></i>
                                {{ $page.props.auth.user.name }}
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('profile.edit')"
                            class="flex items-center px-4 py-2 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-700 rounded-lg transition">
                            <i class="fas fa-user-edit mr-2"></i>
                            Profile
                        </DropdownLink>

                        <DropdownLink :href="route('logout')" method="post" as="button"
                            class="flex items-center px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900 rounded-lg transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>
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
            class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
        ></div>






</template>

<style scoped></style>
