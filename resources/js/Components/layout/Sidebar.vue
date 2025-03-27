<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  isOpen: Boolean,
  isMobile: Boolean
});

const emit = defineEmits(['toggle']);

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
</script>

<template>
  <aside
    class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0"
    :class="[isOpen ? 'translate-x-0' : '-translate-x-full']"
  >
    <div class="h-16 flex items-center justify-between px-4 bg-gray-900">
      <span class="text-xl font-semibold">সনদ শাখা</span>
      <button
        v-if="isMobile"
        @click="$emit('toggle')"
        class="text-white hover:text-gray-300"
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  <nav style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;" class="mt-4 space-y-2 overflow-y-auto">
                <Link :href="route ('dashboard')" class="block text-xl px-4 py-2 hover:bg-gray-700">ড্যাশবোর্ড</Link>

<!-- তাকমিল -->
                <div>
                    <button
                        @click="dropdownOpen.takmil = !dropdownOpen.takmil"
                        class="w-full text-xl flex justify-between items-center  px-4 py-2 hover:bg-gray-700"
                    >
                    আবেদন সংক্রান্ত
                        <svg
                            class="w-4 h-4 transition-transform"
                            :class="{'rotate-180': dropdownOpen.takmil}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div v-if="dropdownOpen.takmil" class="pl-6">
                        <Link :href="route('Markaz.Makaj_apply')" class="block px-4 py-2 text-xl hover:bg-gray-700">মারকায আবেদন</Link>

                        <Link :href="route('Markaz.markaz_change_table')" class="block px-4 py-2 text-xl hover:bg-gray-700">মারকায পরিবর্তন</Link>


                        <Link :href="route('Markaz.marhala_change_table')" class="block px-4 py-2 text-xl hover:bg-gray-700">মারহালা পরিবর্তন</Link>
                        <Link href="route('Takmil.cirtificateProvide')" class="block px-4 py-2 text-xl hover:bg-gray-700">মন্জুরী পত্র আবেদন</Link>

                    </div>
                </div>

                <!-- ফযিলত -->

                <div>
                    <button
                        @click="dropdownOpen.orders = !dropdownOpen.orders"
                        class="w-full  text-xl flex justify-between items-center px-4 py-2 hover:bg-gray-700"
                    >
                নিবন্ধন সংক্রান্ত
                        <svg
                            class="w-4 h-4 transition-transform"
                            :class="{'rotate-180': dropdownOpen.orders}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div v-if="dropdownOpen.orders" class="pl-6">
                        <Link :href="route('students_registration.student_registration')" class="block px-4 py-2 hover:bg-gray-700 text-xl ">পরীক্ষার্থী নিবন্ধন</Link>
                        <Link href="#" class="block text-xl px-4 py-2 hover:bg-gray-700">নিবন্ধন তালিকা</Link>
                        <Link href="route('sanawia.sanawiacirtificateProvide')" class="block px-4 text-xl py-2 hover:bg-gray-700">নিবন্ধন পত্র</Link>
                        <Link href="route('sanawia.sanawiacirtificateProvide')" class="block px-4 text-xl py-2 hover:bg-gray-700">ড্রাফ্ট/সফ্ট ডিলিট</Link>
                        <Link href="route('sanawia.sanawiacirtificateProvide')" class="block px-4 text-xl  py-2 hover:bg-gray-700">পেমেন্ট</Link>
                    </div>
                </div>
<!--
                সানাবিয়া -->
                <div>
                    <button
                        @click="dropdownOpen.sanawia = !dropdownOpen.sanawia"
                        class="w-full text-xl flex justify-between items-center px-4 py-2 hover:bg-gray-700"
                    >
                অন্তর্ভুক্তি সংক্রান্ত
                        <svg
                            class="w-4 h-4 transition-transform"
                            :class="{'rotate-180': dropdownOpen.sanawia}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div v-if="dropdownOpen.sanawia" class="pl-6">
                        <Link href="route('Fajilat.sanawaia')" class="block text-xl px-4 py-2 hover:bg-gray-700">অন্তর্ভূূূূূূূূূূক্তি তালিকা</Link>
                        <Link href="" class="block px-4 text-xl py-2 hover:bg-gray-700">ড্রাফ্ট তালিকা</Link>
                        <Link href="#" class="block px-4 text-xl py-2 hover:bg-gray-700">প্রবেশপত্র</Link>
                                 <Link href="#" class="block px-4 text-xl py-2 hover:bg-gray-700">পেমেন্ট</Link>
                    </div>
                </div>


                <!-- মুতাওয়াসসিতাহ -->

                <div>
                    <button
                        @click="dropdownOpen.mutawassita = !dropdownOpen.mutawassita"
                        class="w-full text-xl flex justify-between items-center px-4 py-2 hover:bg-gray-700"
                    >
             নেগরান/মুমতাহিন
                        <svg
                            class="w-4 h-4 transition-transform"
                            :class="{'rotate-180': dropdownOpen.mutawassita}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div v-if="dropdownOpen.mutawassita" class="pl-6">
                        <Link href="route('mutawassitah.Mutawassitah')" class="block text-xl px-4 py-2 hover:bg-gray-700">নেগ:/মুম: আবেদন</Link>
                        <Link href="" class="block px-4 py-2 text-xl hover:bg-gray-700">মুমতাহিন তালিকা</Link>
                        <Link href="route('mutawassitah.mutawassitahcirtificate')" class="block px-4 py-2 text-xl hover:bg-gray-700">নিয়োগপত্র</Link>
                    </div>
                </div>

                <!-- ইবতেদাইয়্যাহ -->



                <div>
                    <button
                        @click="dropdownOpen.ibtedaia = !dropdownOpen.ibtedaia"
                        class="w-full flex justify-between items-center text-xl px-4 py-2 hover:bg-gray-700"
                    >
           মারকায সংক্রান্ত
                        <svg
                            class="w-4 h-4 transition-transform"
                            :class="{'rotate-180': dropdownOpen.ibtedaia}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div v-if="dropdownOpen.ibtedaia" class="pl-6">
                        <Link href="route('Fajilat.sanawaia')" class="block text-xl px-4 py-2 hover:bg-gray-700">মাদরাসার তালিকা</Link>
                        <Link href="" class="block px-4 py-2 hover:bg-gray-700 text-xl">নেগরান তালিকা</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-gray-700 text-xl">প্রশ্নপত্র প্রিন্ট</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-gray-700 text-xl">ভাউচার তৈরি</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-gray-700 text-xl">ছাত্রদের হাজিরা</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-gray-700 text-xl">নেগরানদের হাজিরা</Link>
                    </div>
                </div>

<!-- হিফজুল কোরান -->

<div>
                    <button
                        @click="dropdownOpen.HifzulQuran = !dropdownOpen.HifzulQuran"
                        class="w-full flex justify-between items-center text-xl px-4 py-2 hover:bg-gray-700"
                    >
                   রিপোর্টস
                        <svg
                            class="w-4 h-4 transition-transform"
                            :class="{'rotate-180': dropdownOpen.HifzulQuran}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div v-if="dropdownOpen.HifzulQuran" class="pl-6">
                        <Link href="route('Fajilat.sanawaia')" class="block px-4 py-2 text-xl hover:bg-gray-700">সকল ছাত্র</Link>
                        <Link href="" class="block px-4 py-2 hover:bg-gray-700 text-xl">আবেদন তালিকা</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-gray-700 text-xl">সনদ কর্যক্রম</Link>
                    </div>
                </div>


                <!-- কিরাত -->


                <div>
                    <button
                        @click="dropdownOpen.Qirat = !dropdownOpen.Qirat"
                        class="w-full flex justify-between items-center text-xl px-4 py-2 hover:bg-gray-700"
                    >
                প্রয়োজনীয় ডকুমেন্টস
                        <svg
                            class="w-4 h-4 transition-transform"
                            :class="{'rotate-180': dropdownOpen.Qirat}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div v-if="dropdownOpen.Qirat" class="pl-6">
                        <Link href="route('fazilat.sanawaia')" class="block px-4 py-2 hover:bg-gray-700 text-xl">সকল ছাত্র</Link>
                        <Link href="" class="block px-4 py-2 hover:bg-gray-700 text-xl">আবেদন তালিকা</Link>
                        <Link href="#" class="block px-4 py-2 hover:bg-gray-700 text-xl">সনদ কর্যক্রম</Link>
                    </div>
                </div>






                <Link href="#" class="block px-4 text-xl py-2 hover:bg-gray-700">মেসেজিং</Link>
                <Link href="#" class="block px-4 text-xl py-2 hover:bg-gray-700">নোটিস</Link>
            </nav>
    <!-- Your existing sidebar navigation items -->
  </aside>
</template>
