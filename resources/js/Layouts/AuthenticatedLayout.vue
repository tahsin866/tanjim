<template>
    <div style="font-family: 'Merriweather','SolaimanLipi',sans-serif;" class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
      <!-- Sidebar -->
      <aside
        :class="[
          'fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 ease-in-out bg-[#004d40] text-white lg:translate-x-0 shadow-xl',
          showSidebar ? 'translate-x-0' : '-translate-x-full'
        ]"
      >
        <!-- Header -->
        <div class="h-16 flex text-xl items-center justify-center bg-gradient-to-r from-emerald-600 to-emerald-800 text-white font-semibold shadow-md">
          <div class="flex items-center gap-2">
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2L3 9V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V9L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            এক্সাম মেনেজমেন্ট সিস্টেম
          </div>
        </div>

        <nav style="font-family: 'Merriweather','SolaimanLipi',sans-serif;" class="mt-4 space-y-1 overflow-y-auto max-h-[calc(100vh-4rem)] scrollbar-hidden">
          <!-- Dashboard -->
          <Link
            :href="route('dashboard')"
            :class="[
              'text-xl px-4 py-2 flex items-center gap-2 transition-colors duration-200',
              isExactRouteActive('dashboard')
                ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
                : 'hover:bg-[#123524]'
            ]"
          >
            <i class="fas fa-mosque w-6 h-6 text-sm"></i>
            ড্যাশবোর্ড
          </Link>

          <!-- তাকমিল -->
          <div>
  <button
    @click="toggleDropdown('takmil')"
    :class="[
      'w-full text-xl flex justify-between items-center px-4 py-2 transition-colors duration-200',
      activeDropdown === 'takmil' || isRouteActive('Markaz') || isRouteActive('Takmil')
        ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
        : 'hover:bg-[#123524]'
    ]"
  >
    <div class="flex items-center gap-2">
      <i class="fas fa-file-alt w-6 h-6 text-sm"></i>
      আবেদন সংক্রান্ত
    </div>
    <i :class="{'rotate-180': activeDropdown === 'takmil'}" class="pi pi-angle-right transition-transform duration-300"></i>
  </button>
  <div v-if="activeDropdown === 'takmil'" class="pl-6 bg-[#003a30] py-1 space-y-1 transition-all duration-300">
    <Link
      :href="route('Markaz.makaj-apply')"
      :class="[
        'px-4 py-2 text-xl flex items-center gap-2 transition-colors duration-200 rounded-sm',
        isExactRouteActive('Markaz.makaj-apply')
          ? 'bg-emerald-800 text-emerald-100'
          : 'hover:bg-[#123524]'
      ]"
    >
      মারকায আবেদন
    </Link>
    <Link
      v-if="!$page.props.auth.user.markaz_serial"
      :href="route('Markaz.markaz_change_table')"
      :class="[
        'block px-4 py-2 text-xl transition-colors duration-200 rounded-sm',
        isExactRouteActive('Markaz.markaz_change_table')
          ? 'bg-emerald-800 text-emerald-100'
          : 'hover:bg-[#123524]'
      ]"
    >
      মারকায পরিবর্তন
    </Link>
    <Link
      :href="route('Markaz.subjectSettings_for_madrasha')"
      :class="[
        'block px-4 py-2 text-xl transition-colors duration-200 rounded-sm',
        isExactRouteActive('Markaz.subjectSettings_for_madrasha')
          ? 'bg-emerald-800 text-emerald-100'
          : 'hover:bg-[#123524]'
      ]"
    >
      বিষয় সেটাপ
    </Link>
    <Link
      :href="route('Markaz.marhala_change_table')"
      :class="[
        'block px-4 py-2 text-xl transition-colors duration-200 rounded-sm',
        isExactRouteActive('Markaz.marhala_change_table')
          ? 'bg-emerald-800 text-emerald-100'
          : 'hover:bg-[#123524]'
      ]"
    >
      মারহালা পরিবর্তন
    </Link>
    <Link
      href="route('Takmil.cirtificateProvide')"
      :class="[
        'block px-4 py-2 text-xl transition-colors duration-200 rounded-sm',
        isExactRouteActive('Takmil.cirtificateProvide')
          ? 'bg-emerald-800 text-emerald-100'
          : 'hover:bg-[#123524]'
      ]"
    >
      মন্জুরী পত্র আবেদন
    </Link>
  </div>
</div>


          <!-- নিবন্ধন সংক্রান্ত -->
          <div>
            <button
              @click="toggleDropdown('orders')"
              :class="[
                'w-full text-xl flex justify-between items-center px-4 py-2 transition-colors duration-200',
                activeDropdown === 'orders' || isRouteActive('students_registration')
                  ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
                  : 'hover:bg-[#123524]'
              ]"
            >
              <div class="flex items-center gap-2">
                <i class="fas fa-user-plus w-6 h-6 text-sm"></i>
                নিবন্ধন সংক্রান্ত
              </div>
              <i :class="{'rotate-180': activeDropdown === 'orders'}" class="fas fa-chevron-down fa-xs transition-transform duration-300"></i>
            </button>
            <div v-if="activeDropdown === 'orders'" class="pl-6 bg-[#003a30] py-1 space-y-1 transition-all duration-300">
              <Link
                :href="route('students_registration.student_registration')"
                :class="[
                  'px-4 py-2 text-xl flex items-center gap-2 transition-colors duration-200 rounded-sm',
                  isExactRouteActive('students_registration.student_registration')
                    ? 'bg-emerald-800 text-emerald-100'
                    : 'hover:bg-[#123524]'
                ]"
              >
                পরীক্ষার্থী নিবন্ধন
              </Link>
              <Link
                :href="route('students_registration.stuedent_reg_list')"
                :class="[
                  'block text-xl px-4 py-2 transition-colors duration-200 rounded-sm',
                  isExactRouteActive('students_registration.stuedent_reg_list')
                    ? 'bg-emerald-800 text-emerald-100'
                    : 'hover:bg-[#123524]'
                ]"
              >
                নিবন্ধন তালিকা
              </Link>
              <Link
                :href="route('students_registration.student_reg_card')"
                :class="[
                  'block px-4 text-xl py-2 transition-colors duration-200 rounded-sm',
                  isExactRouteActive('students_registration.student_reg_card')
                    ? 'bg-emerald-800 text-emerald-100'
                    : 'hover:bg-[#123524]'
                ]"
              >
                নিবন্ধন পত্র
              </Link>
              <Link
                :href="route('students_registration.stue_reg_draft_soft_delete')"
                :class="[
                  'block px-4 text-xl py-2 transition-colors duration-200 rounded-sm',
                  isExactRouteActive('students_registration.stue_reg_draft_soft_delete')
                    ? 'bg-emerald-800 text-emerald-100'
                    : 'hover:bg-[#123524]'
                ]"
              >
                ড্রাফ্ট/সফ্ট ডিলিট
              </Link>
              <Link
                :href="route('students_registration.stu_reg_payment')"
                :class="[
                  'block px-4 text-xl py-2 transition-colors duration-200 rounded-sm',
                  isExactRouteActive('students_registration.stu_reg_payment')
                    ? 'bg-emerald-800 text-emerald-100'
                    : 'hover:bg-[#123524]'
                ]"
              >
                পেমেন্ট
              </Link>
            </div>
          </div>

          <!-- অন্তর্ভুক্তি সংক্রান্ত -->
          <div>
            <button
              @click="toggleDropdown('sanawia')"
              :class="[
                'w-full text-xl flex justify-between items-center px-4 py-2 transition-colors duration-200',
                activeDropdown === 'sanawia' || isRouteActive('OntorVukti')
                  ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
                  : 'hover:bg-[#123524]'
              ]"
            >
            <div class="flex items-center gap-2">
              <i class="fas fa-users w-6 h-6 text-sm"></i>
              অন্তর্ভুক্তি সংক্রান্ত
            </div>
            <i :class="{'rotate-180': activeDropdown === 'sanawia'}" class="fas fa-chevron-down fa-xs transition-transform duration-300"></i>
          </button>
          <div v-if="activeDropdown === 'sanawia'" class="pl-6 bg-[#003a30] py-1 space-y-1 transition-all duration-300">
            <Link
              :href="route('OntorVukti.ontorvukti_table')"
              :class="[
                'block text-xl px-4 py-2 transition-colors duration-200 rounded-sm',
                isExactRouteActive('OntorVukti.ontorvukti_table')
                  ? 'bg-emerald-800 text-emerald-100'
                  : 'hover:bg-[#123524]'
              ]"
            >
              অন্তর্ভূূূূূূূূূূক্তি তালিকা
            </Link>
            <Link
              :href="route('OntorVukti.softDelete_draft_list')"
              :class="[
                'block px-4 text-xl py-2 transition-colors duration-200 rounded-sm',
                isExactRouteActive('OntorVukti.softDelete_draft_list')
                  ? 'bg-emerald-800 text-emerald-100'
                  : 'hover:bg-[#123524]'
              ]"
            >
              ড্রাফ্ট তালিকা
            </Link>
            <Link
              :href="route('OntorVukti.stu_admit_card')"
              :class="[
                'block px-4 text-xl py-2 transition-colors duration-200 rounded-sm',
                isExactRouteActive('OntorVukti.stu_admit_card')
                  ? 'bg-emerald-800 text-emerald-100'
                  : 'hover:bg-[#123524]'
              ]"
            >
              প্রবেশপত্র
            </Link>
            <Link
              :href="route('OntorVukti.stu_payment')"
              :class="[
                'block px-4 text-xl py-2 transition-colors duration-200 rounded-sm',
                isExactRouteActive('OntorVukti.stu_payment')
                  ? 'bg-emerald-800 text-emerald-100'
                  : 'hover:bg-[#123524]'
              ]"
            >
              পেমেন্ট
            </Link>
          </div>
        </div>

        <!-- নেগরান/মুমতাহিন -->
        <div>
          <button
            @click="toggleDropdown('mutawassita')"
            :class="[
              'w-full text-xl flex justify-between items-center px-4 py-2 transition-colors duration-200',
              activeDropdown === 'mutawassita' || isRouteActive('Negran_Mumtahin')
                ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
                : 'hover:bg-[#123524]'
            ]"
          >
            <div class="flex items-center gap-2">
              <i class="fas fa-user-shield w-6 h-6 text-sm"></i>
              নেগরান/মুমতাহিন
            </div>
            <i :class="{'rotate-180': activeDropdown === 'mutawassita'}" class="fas fa-chevron-down fa-xs transition-transform duration-300"></i>
          </button>
          <div v-if="activeDropdown === 'mutawassita'" class="pl-6 bg-[#003a30] py-1 space-y-1 transition-all duration-300">
            <Link
              :href="route('Negran_Mumtahin.negran_mumtahin')"
              :class="[
                'block text-xl px-4 py-2 transition-colors duration-200 rounded-sm',
                isExactRouteActive('Negran_Mumtahin.negran_mumtahin')
                  ? 'bg-emerald-800 text-emerald-100'
                  : 'hover:bg-[#123524]'
              ]"
            >
              নেগ:/মুম: আবেদন
            </Link>
            <Link
              :href="route('Negran_Mumtahin.mumtahin_list')"
              :class="[
                'block px-4 py-2 text-xl transition-colors duration-200 rounded-sm',
                isExactRouteActive('Negran_Mumtahin.mumtahin_list')
                  ? 'bg-emerald-800 text-emerald-100'
                  : 'hover:bg-[#123524]'
              ]"
            >
              মুমতাহিন তালিকা
            </Link>
            <Link
              :href="route('Negran_Mumtahin.negran_apoint_list')"
              :class="[
                'block px-4 py-2 text-xl transition-colors duration-200 rounded-sm',
                isExactRouteActive('Negran_Mumtahin.negran_apoint_list')
                  ? 'bg-emerald-800 text-emerald-100'
                  : 'hover:bg-[#123524]'
              ]"
            >
              নিয়োগপত্র
            </Link>
          </div>
        </div>

        <!-- মারকায সংক্রান্ত -->
        <div v-if="$page.props.auth.user.markaz_serial">
          <button
            @click="toggleDropdown('ibtedaia')"
            :class="[
              'w-full text-xl flex justify-between items-center px-4 py-2 transition-colors duration-200',
              activeDropdown === 'ibtedaia' || isRouteActive('About_markaj')
                ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
                : 'hover:bg-[#123524]'
            ]"
          >
            <div class="flex items-center gap-2">
              <i class="fas fa-school w-6 h-6 text-sm"></i>
              মারকায সংক্রান্ত
            </div>
            <i :class="{'rotate-180': activeDropdown === 'ibtedaia'}" class="fas fa-chevron-down fa-xs transition-transform duration-300"></i>

          </button>
          <div v-if="activeDropdown === 'ibtedaia'" class="pl-6 bg-[#003a30] py-1 space-y-1 transition-all duration-300">
            <Link
              href="route('About_markaj.madrasha_list')"
              :class="[
                'block text-xl px-4 py-2 transition-colors duration-200 rounded-sm',
                isExactRouteActive('About_markaj.madrasha_list')
                  ? 'bg-emerald-800 text-emerald-100'
                  : 'hover:bg-[#123524]'
              ]"
            >
              মাদরাসার তালিকা
            </Link>
            <Link
              href=""
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              নেগরান তালিকা
            </Link>
            <Link
              href="#"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              প্রশ্নপত্র প্রিন্ট
            </Link>
            <Link
              href="#"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              ভাউচার তৈরি
            </Link>
            <Link
              href="#"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              ছাত্রদের হাজিরা
            </Link>
            <Link
              href="#"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              নেগরানদের হাজিরা
            </Link>
          </div>
        </div>

        <!-- রিপোর্টস -->
        <div>
          <button
            @click="toggleDropdown('HifzulQuran')"
            :class="[
              'w-full text-xl flex justify-between items-center px-4 py-2 transition-colors duration-200',
              activeDropdown === 'HifzulQuran'
                ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
                : 'hover:bg-[#123524]'
            ]"
          >
            <div class="flex items-center gap-2">
              <i class="fas fa-chart-bar w-6 h-6 text-sm"></i>
              রিপোর্টস
            </div>
            <i :class="{'rotate-180': activeDropdown === 'HifzulQuran'}" class="fas fa-chevron-down fa-xs transition-transform duration-300"></i>
          </button>
          <div v-if="activeDropdown === 'HifzulQuran'" class="pl-6 bg-[#003a30] py-1 space-y-1 transition-all duration-300">
            <Link
              href="route('Fajilat.sanawaia')"
              class="block px-4 py-2 text-xl hover:bg-[#123524] transition-colors duration-200 rounded-sm"
            >
              নিবন্ধন রিপোর্ট
            </Link>
            <Link
              href=""
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              অন্তর্ভূক্তি রিপোর্ট
            </Link>
            <Link
              href=""
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              নেগ:/মুম রিপোর্ট
            </Link>
            <Link
              href="#"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              হাজিরা রিপোর্ট
            </Link>
            <Link
              href="#"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              পেমেন্ট রিপোর্ট
            </Link>
            <Link
              href="#"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              নিয়োগ রিপোর্ট
            </Link>
            <Link
              href="#"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              মাদরাসা রিপোর্ট
            </Link>
          </div>
        </div>

        <!-- প্রয়োজনীয় ডকুমেন্টস -->
        <div>
          <button
            @click="toggleDropdown('Qirat')"
            :class="[
              'w-full text-xl flex justify-between items-center px-4 py-2 transition-colors duration-200',
              activeDropdown === 'Qirat'
                ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
                : 'hover:bg-[#123524]'
            ]"
          >
            <div class="flex items-center gap-2">
              <i class="fas fa-file-alt w-6 h-6 text-sm"></i>
              প্রয়োজনীয় ডকুমেন্টস
            </div>
            <i :class="{'rotate-180': activeDropdown === 'Qirat'}" class="fas fa-chevron-down fa-xs transition-transform duration-300"></i>
          </button>
          <div v-if="activeDropdown === 'Qirat'" class="pl-6 bg-[#003a30] py-1 space-y-1 transition-all duration-300">
            <Link
              href="route('fazilat.sanawaia')"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              সকল ছাত্র
            </Link>
            <Link
              href=""
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              আবেদন তালিকা
            </Link>
            <Link
              href="#"
              class="block px-4 py-2 hover:bg-[#123524] text-xl transition-colors duration-200 rounded-sm"
            >
              সনদ কর্যক্রম
            </Link>
          </div>
        </div>

        <!-- মেসেজিং -->
        <Link
          :href="route('others.massaging')"
          :class="[
            'px-4 text-xl py-2 flex items-center gap-2 transition-colors duration-200',
            isExactRouteActive('others.massaging')
              ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
              : 'hover:bg-[#123524]'
          ]"
        >
          <i class="fas fa-envelope w-6 h-6 text-sm"></i>
          মেসেজিং
        </Link>
 <!-- নোটিস -->
 <Link
          :href="route('others.notice')"
          :class="[
            'px-4 text-xl py-2 flex items-center gap-2 transition-colors duration-200',
            isExactRouteActive('others.notice')
              ? 'bg-emerald-700 text-white font-medium border-l-4 border-emerald-300'
              : 'hover:bg-[#123524]'
          ]"
        >
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
        'md:ml-64',  // Always maintain margin on desktop
        'w-full',    // Ensure full width
        'overflow-x-hidden' // Prevent horizontal scrolling
      ]"
    >
      <!-- Top Navigation Bar -->
      <nav class="bg-[#F7F7F7] dark:bg-gray-800 border-b border-emerald-100 dark:border-gray-700 fixed right-0 left-0 z-10 md:left-64 shadow-sm">
        <div class="mx-auto px-2 sm:px-4 lg:px-8">
          <!-- Reduced height for mobile, maintained for larger screens -->
          <div class="flex h-auto sm:h-28 justify-between items-center py-3 sm:py-0">
            <!-- Mobile menu toggle -->
            <button
              @click="showSidebar = !showSidebar"
              class="lg:hidden text-emerald-600 hover:text-emerald-800 focus:outline-none p-2 rounded-md transition-colors duration-200"
            >
              <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Logo and Center Info with responsive adjustments -->
            <div class="flex items-center flex-grow justify-center flex-col pt-2 sm:pt-4 px-1">
              <h1 class="text-sm sm:text-lg md:text-2xl font-semibold text-center mb-1 sm:mb-2 truncate max-w-[200px] sm:max-w-full text-emerald-800 dark:text-emerald-200">
                {{ page.props.auth.user.madrasha_name }} {{ page.props.auth.user.thana }} ({{ page.props.auth.user.custom_code }})
              </h1>

              <!-- Centers displayed below madrasha name -->
              <div v-if="!error && Object.keys(centers).length > 0" class="flex flex-wrap justify-center gap-1 sm:gap-2 mb-1 sm:mb-2">
                <span
                  v-for="(centerName, type) in centers"
                  :key="type"
                  class="text-xs sm:text-sm md:text-xl bg-emerald-100 text-emerald-800 px-2 py-0.5 sm:px-3 sm:py-1 rounded-full truncate max-w-[100px] sm:max-w-full shadow-sm"
                >
                  {{ centerName }}
                </span>
              </div>
            </div>

            <!-- Notification and User Dropdown - Always visible with responsive design -->
            <div class="flex items-center space-x-1 sm:space-x-4">
              <!-- Prayer Times Button - Hidden on smallest screens -->
              <button class="hidden xs:inline-flex relative text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 p-1 sm:p-2 rounded-md group transition-all duration-300">
                <i class="fas fa-kaaba h-4 w-4 sm:h-6 sm:w-6 transform group-hover:scale-110 transition-transform duration-300"></i>
              </button>

              <!-- Notification Icon -->
              <button
                @click="openNotifications"
                class="relative text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 p-1 sm:p-2 rounded-md group transition-all duration-300"
              >
                <i class="fas fa-bell h-4 w-4 sm:h-6 sm:w-6 transform group-hover:scale-110 transition-transform duration-300"></i>
                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[16px] sm:min-w-[20px] h-4 sm:h-5 px-1 sm:px-1.5 text-[10px] sm:text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-green-500 rounded-full transform scale-100 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                  3
                </span>
              </button>

              <!-- Message Icon - Hidden on smallest screens -->
              <button
                @click="openMessages"
                class="hidden xs:inline-flex relative text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 p-1 sm:p-2 rounded-md group transition-all duration-300"
              >
                <i class="fas fa-envelope h-4 w-4 sm:h-6 sm:w-6 transform group-hover:scale-110 transition-transform duration-300"></i>
                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[16px] sm:min-w-[20px] h-4 sm:h-5 px-1 sm:px-1.5 text-[10px] sm:text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-green-500 rounded-full transform scale-100 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                  5
                </span>
              </button>

              <!-- User Dropdown - Simplified for mobile -->
              <Dropdown align="right" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button
                      style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
                      class="inline-flex items-center px-2 sm:px-4 py-1 sm:py-2 bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-600 rounded-lg shadow-sm text-xs sm:text-md font-medium leading-4 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 dark:focus:ring-emerald-500 transition duration-150 ease-in-out"
                    >
                      <!-- Mobile view - only icon -->
                      <div class="sm:hidden">
                        <i class="fas fa-user-circle text-lg text-emerald-600"></i>
                      </div>

                      <!-- Desktop view - full content -->
                      <div class="hidden sm:flex flex-col items-start mr-2">
                        <i class="fas fa-user-circle text-xl mb-1 text-emerald-600"></i>
                      </div>
                      <div class="hidden sm:flex flex-col items-start">
                        <span class="font-semibold text-sm">{{ $page.props.auth.user.name }}</span>
                        <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full text-xs mt-0.5">
                          {{ $page.props.auth.user.admin_Designation }}
                        </span>
                      </div>
                      <i class="fas fa-chevron-down ml-1 sm:ml-2 text-xs sm:text-sm"></i>
                    </button>
                  </span>
                </template>

                <template #content>
                  <DropdownLink
                    :href="route('profile.edit')"
                    class="flex items-center px-4 py-2 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-700 rounded-lg transition"
                  >
                    <i class="fas fa-user-edit mr-2"></i>
                    Profile
                  </DropdownLink>
                  <DropdownLink
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="flex items-center px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900 rounded-lg transition"
                  >
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Log Out
                  </DropdownLink>
                </template>
              </Dropdown>
            </div>
          </div>
        </div>
      </nav>

      <!-- Main Content Area -->
      <main class="flex-1 pt-16 mt-10 p-4">
        <slot />
      </main>
    </div>
  </div>

  <!-- Overlay for mobile sidebar -->
  <div
    v-show="showSidebar"
    @click="showSidebar = false"
    class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden transition-opacity duration-300"
  ></div>

  <!-- Notification Panel (can be implemented as needed) -->
  <div
    v-if="showNotifications"
    class="fixed right-2 top-16 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl z-50 border border-emerald-100 dark:border-emerald-700 overflow-hidden transition-all duration-300 transform origin-top-right"
  >
    <div class="p-4 bg-emerald-50 dark:bg-emerald-900 border-b border-emerald-100 dark:border-emerald-700">
      <h3 class="text-lg font-semibold text-emerald-800 dark:text-emerald-200">নোটিফিকেশন</h3>
    </div>
    <div class="max-h-96 overflow-y-auto p-2">
      <!-- Sample notifications -->
      <div class="p-3 hover:bg-emerald-50 dark:hover:bg-emerald-900 rounded-lg mb-2 border border-emerald-100 dark:border-emerald-800">
        <div class="flex items-start">
          <div class="flex-shrink-0 bg-emerald-100 dark:bg-emerald-800 p-2 rounded-full">
            <i class="fas fa-bell text-emerald-600 dark:text-emerald-400"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">নতুন নোটিশ</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">১০ মিনিট আগে</p>
          </div>
        </div>
      </div>
      <div class="p-3 hover:bg-emerald-50 dark:hover:bg-emerald-900 rounded-lg mb-2 border border-emerald-100 dark:border-emerald-800">
        <div class="flex items-start">
          <div class="flex-shrink-0 bg-emerald-100 dark:bg-emerald-800 p-2 rounded-full">
            <i class="fas fa-file-alt text-emerald-600 dark:text-emerald-400"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">আবেদন অনুমোদিত হয়েছে</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">১ ঘন্টা আগে</p>
          </div>
        </div>
      </div>
    </div>
    <div class="p-2 border-t border-emerald-100 dark:border-emerald-700 bg-emerald-50 dark:bg-emerald-900">
      <button class="w-full py-2 text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 font-medium">
        সব দেখুন
      </button>
    </div>
  </div>

  <!-- Messages Panel (can be implemented as needed) -->
  <div
    v-if="showMessages"
    class="fixed right-2 top-16 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl z-50 border border-emerald-100 dark:border-emerald-700 overflow-hidden transition-all duration-300 transform origin-top-right"
  >
    <div class="p-4 bg-emerald-50 dark:bg-emerald-900 border-b border-emerald-100 dark:border-emerald-700">
      <h3 class="text-lg font-semibold text-emerald-800 dark:text-emerald-200">মেসেজ</h3>
    </div>
    <div class="max-h-96 overflow-y-auto p-2">
      <!-- Sample messages -->
      <div class="p-3 hover:bg-emerald-50 dark:hover:bg-emerald-900 rounded-lg mb-2 border border-emerald-100 dark:border-emerald-800">
        <div class="flex items-start">
          <div class="flex-shrink-0">
            <div class="w-10 h-10 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-700">
              <i class="fas fa-user"></i>
            </div>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">আব্দুল্লাহ</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">আসসালামু আলাইকুম, কেমন আছেন?</p>
            <p class="text-xs text-gray-400 mt-1">৩০ মিনিট আগে</p>
          </div>
        </div>
      </div>
      <div class="p-3 hover:bg-emerald-50 dark:hover:bg-emerald-900 rounded-lg mb-2 border border-emerald-100 dark:border-emerald-800">
        <div class="flex items-start">
          <div class="flex-shrink-0">
            <div class="w-10 h-10 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-700">
              <i class="fas fa-user"></i>
            </div>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">মোহাম্মদ</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">আপনার ডকুমেন্ট পাঠিয়েছি, দেখবেন</p>
            <p class="text-xs text-gray-400 mt-1">২ ঘন্টা আগে</p>
          </div>
        </div>
      </div>
    </div>
    <div class="p-2 border-t border-emerald-100 dark:border-emerald-700 bg-emerald-50 dark:bg-emerald-900">
      <button class="w-full py-2 text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 font-medium">
        সব মেসেজ দেখুন
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import 'primeicons/primeicons.css'

// Sidebar state
const showSidebar = ref(false);

// Dropdown states with single active management
const activeDropdown = ref(null);

// Function to toggle dropdown - closes others when one is opened
const toggleDropdown = (name) => {
  if (activeDropdown.value === name) {
    activeDropdown.value = null;
  } else {
    activeDropdown.value = name;
  }
};

// Notification & message states
const showNotifications = ref(false);
const showMessages = ref(false);

// Toggle sidebar for mobile
const toggleSidebar = () => {
  showSidebar.value = !showSidebar.value;
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

const mobileMenuOpen = ref(false);
const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value;
};

const page = usePage();
const centers = ref([]);
const error = ref(null);

// Get current route for active menu highlighting
const currentRoute = computed(() => route().current());

// Check if a route is active or its child routes are active
const isRouteActive = (routeName) => {
  return currentRoute.value.startsWith(routeName.split('.')[0]);
};

// Check if a specific route is exactly active
const isExactRouteActive = (routeName) => {
  return currentRoute.value === routeName;
};

const fetchCenters = async () => {
  try {
    const response = await fetch('/api/user-centers');
    if (!response.ok) {
      throw new Error('Failed to fetch centers');
    }
    const data = await response.json();
    centers.value = data.centers || [];
    error.value = data.error || null;
  } catch (err) {
    console.error('Error fetching centers:', err);
    error.value = err.message;
  }
};

// Auto-open dropdown based on current route
watch(currentRoute, (newRoute) => {
  if (newRoute.startsWith('Markaz') || newRoute.startsWith('Takmil')) {
    activeDropdown.value = 'takmil';
  } else if (newRoute.startsWith('students_registration')) {
    activeDropdown.value = 'orders';
  } else if (newRoute.startsWith('OntorVukti')) {
    activeDropdown.value = 'sanawia';
  } else if (newRoute.startsWith('Negran_Mumtahin')) {
    activeDropdown.value = 'mutawassita';
  } else if (newRoute.startsWith('About_markaj')) {
    activeDropdown.value = 'ibtedaia';
  } else if (newRoute.includes('report')) {
    activeDropdown.value = 'HifzulQuran';
  } else if (newRoute.includes('document')) {
    activeDropdown.value = 'Qirat';
  }
}, { immediate: true });

onMounted(() => {
  fetchCenters();
});
</script>

<style scoped>
/* Custom scrollbar for sidebar */
.sidebar-scrollbar::-webkit-scrollbar {
  width: 4px;
}

.sidebar-scrollbar::-webkit-scrollbar-track {
  background: #004d40;
}

.sidebar-scrollbar::-webkit-scrollbar-thumb {
  background-color: #00796b;
  border-radius: 4px;
}

.sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: #00897b;
}

/* Transition for sidebar */
.sidebar-enter-active,
.sidebar-leave-active {
  transition: transform 0.3s ease;
}

.sidebar-enter-from,
.sidebar-leave-to {
  transform: translateX(-100%);
}

/* Ensure proper font rendering for Bangla text */
* {
  font-family: 'SolaimanLipi', sans-serif;
}
</style>
