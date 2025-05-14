<template>
    <AuthenticatedLayout>
        <div class="container-fluid mx-auto py-8 px-4">
    <div class="bg-white rounded-sm shadow-xl overflow-hidden">
      <!-- Header -->
      <div class="bg-olive-700 px-6 py-4 flex justify-between items-center rounded-t-xl">
        <h3 class="text-white text-xl font-bold">নেগরান মুমতাহিন আবেদন ফরম</h3>
        <div class="flex items-center"></div>
      </div>

      <!-- Form Body -->
      <div class="p-6">
        <form @submit.prevent="submitForm">

        <!-- Profile Section -->
        <div class="text-center mt-4">
          <img
            :src="profileImage || 'img/islamic.png'"
            alt="User profile picture"
            class="w-24 h-24 rounded-full mx-auto mb-3 object-cover"
          >
          <h3 class="text-xl font-semibold"></h3>

          <inputnp
            type="file"
            id="profileImageInput"
            class="hidden"
            @change="handleProfileImageChange"
          />

          <div class="flex justify-center items-center gap-2 mt-3 mb-6">
            <label
              for="profileImageInput"
              class="px-4 py-2 border border-blue-500 text-blue-500 rounded-md text-sm flex items-center hover:bg-blue-50 transition cursor-pointer"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
              </svg>
              প্রোফাইল ছবি নির্বাচন করুন
            </label>
          </div>
        </div>


    <!-- Application Type -->
    <div class="mb-8">
  <div class="md:w-1/3">
    <div class="space-y-2">
      <label for="applicationType" class="block text-emerald-800 font-semibold">আবেদনের ধরন</label>
      <select
        id="applicationType"
        v-model="applicationType"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg bg-white"
      >
        <option>নেগরান</option>
        <option>মুমতাহিন</option>
        <option>নেগরান মুমতাহিন উভয়</option>
        <option>হিফজ মুমতাহিন</option>
        <option>কেরাত মুমতাহিন</option>
      </select>
    </div>
  </div>
</div>

<!-- Personal Information -->
<div class="mb-8 bg-white rounded-lg p-6 border border-emerald-100 shadow-sm">
  <h5 class="text-lg font-semibold mb-4 border-b border-emerald-200 pb-2 text-emerald-800 flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
    </svg>
    ব্যক্তিগত তথ্য
  </h5>
  <div          class="  grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="space-y-2">
      <label for="name" class="block text-emerald-800">নাম</label>
      <input
        type="text"
        id="name"
        v-model="teachers.TName"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"
        placeholder="আপনার নাম লিখুন"

      >
    </div>
    <div class="space-y-2">
      <label for="mobile" class="block text-emerald-800">মোবাইল নম্বর</label>
      <input
        type="text"
        id="mobile"
        v-model="teachers.Mobile"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"
        placeholder="মোবাইল নম্বর লিখুন"

      >
    </div>
    <div class="space-y-2">
      <label for="birthDate" class="block text-emerald-800">জন্ম-তারিখ</label>
      <input
        type="text"
        id="birthDate"
        :value="formatDate(teachers.DateofBirth)"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"

      >
    </div>
    <div class="space-y-2">
      <label for="whatsapp" class="block text-emerald-800">হোয়াটসঅ্যাপ নম্বর</label>
      <input
        type="text"
        id="whatsapp"
        v-model="teachers.whatsapp"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"
        placeholder="হোয়াটসঅ্যাপ নম্বর"

      >
    </div>
    <div class="space-y-2">
      <label for="birthRegNo" class="block text-emerald-800">জন্ম নিবন্ধন নম্বর</label>
      <input
        type="text"
        id="birthRegNo"
        v-model="teachers.National_Id_Card"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"
        placeholder="জন্ম নিবন্ধন নম্বর"

      >
    </div>
    <div class="space-y-2">
      <label for="nid" class="block text-emerald-800">এন.আইডি নম্বর</label>
      <input
        type="text"
        id="nid"
        v-model="teachers.nid"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"
        placeholder="এন.আইডি নম্বর"

      >
    </div>
    <div class="space-y-2">
      <label for="gender" class="block text-emerald-800">জেন্ডার</label>
      <input
        type="text"
        id="gender"
        v-model="teachers.gender"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"

      >
    </div>
  </div>
</div>

        <!-- Address Information -->
        <div class="mb-8 bg-white rounded-lg p-6 border border-emerald-100 shadow-sm">
  <h5 class="text-lg font-semibold mb-4 border-b border-emerald-200 pb-2 text-emerald-800 flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
    </svg>
    ঠিকানা
  </h5>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="relative">
                                <label
                                    class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                    বিভাগ
                                </label>
                                <div class="relative">
                                    <select v-model="presentFilters.division" @change="presentHandleDivisionChange"
                                        class="bg-white border border-gray-200 rounded-sm w-full block focus:ring-[#2d6a4f] focus:ring-2 px-4 py-2">
                                        <option value="">সকল</option>
                                        <option v-for="division in divisions" :key="division.id" :value="division.id">
                                            {{ division.Division }}
                                        </option>
                                    </select>
                                    <div class="flex absolute inset-y-0 items-center pointer-events-none px-2 right-0">
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <label
                                    class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                    জেলা
                                </label>
                                <div class="relative">
                                    <select v-model="presentFilters.district" @change="presentHandleDistrictChange"
                                        class="bg-white border border-gray-200 rounded-sm w-full block focus:ring-[#2d6a4f] focus:ring-2 px-4 py-2">
                                        <option value="">সকল</option>
                                        <option v-for="district in presentDistricts" :key="district.DesID"
                                            :value="district.DesID">
                                            {{ district.District }}
                                        </option>
                                    </select>
                                    <div class="flex absolute inset-y-0 items-center pointer-events-none px-2 right-0">
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <label
                                    class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                    থানা/উপজেলা
                                </label>
                                <div class="relative">
                                    <select v-model="presentFilters.Thana"
                                        class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-sm focus:ring-2 focus:ring-[#2d6a4f]">
                                        <option value="">সকল</option>
                                        <option v-for="Thana in presentThanas" :key="Thana.Thana_ID"
                                            :value="Thana.Thana_ID">
                                            {{ Thana.Thana }}
                                        </option>
                                    </select>


                                    <div class="flex absolute inset-y-0 items-center pointer-events-none px-2 right-0">
                                    </div>
                                </div>
                            </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-2">
      <label for="post" class="block text-emerald-800">পোস্ট</label>
      <input
        type="text"
        id="post"
        v-model="address.post"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg bg-emerald-50"
        placeholder="পোস্ট"
      >
    </div>

    <div class="space-y-2">
      <label for="village" class="block text-emerald-800">গ্রাম</label>
      <input
        type="text"
        id="village"
        v-model="address.village"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg bg-emerald-50"
        placeholder="গ্রাম"
      >
    </div>
  </div>
</div>

<!-- Educational Qualifications -->
<div class="mb-8 bg-white rounded-lg p-6 border border-emerald-100 shadow-sm">
  <h5 class="text-lg font-semibold mb-4 border-b border-emerald-200 pb-2 text-emerald-800 flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
      <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
    </svg>
    শিক্ষাগত যোগ্যতা
  </h5>

  <div v-for="(qualification, index) in educationalQualifications" :key="index" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
      <div class="space-y-2">
        <label :for="`class-${index}`" class="block text-emerald-800">মারহালার নাম/ক্লাসের নাম</label>
        <select
          :id="`class-${index}`"
          v-model="qualification.className"
          class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg bg-emerald-50"
        >
          <option>তাকমিল</option>
          <option>ফযীলত</option>
          <option>সানাবিয়া উলইয়া</option>
          <option>সানাবিয়া</option>
          <option>মাস্টার্স</option>
          <option>কামিল</option>
          <option>H.S.C</option>
        </select>
      </div>

      <div class="space-y-2">
        <label :for="`passYear-${index}`" class="block text-emerald-800">পাসের সন</label>
        <input
          type="text"
          :id="`passYear-${index}`"
          v-model="qualification.passYear"
          class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"
          placeholder="পাসের সন"
        >
      </div>

      <div class="space-y-2">
        <label :for="`result-${index}`" class="block text-emerald-800">ফলাফল (বিভাগ)</label>
        <input
          type="text"
          :id="`result-${index}`"
          v-model="qualification.result"
          class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"
          placeholder="ফলাফল (বিভাগ)"
        >
      </div>

      <div class="space-y-2">
        <label :for="`institution-${index}`" class="block text-emerald-800">সমাপনি বোর্ড/মাদরাসা</label>
        <div class="flex gap-2">
          <input
            type="text"
            :id="`institution-${index}`"
            v-model="qualification.institution"
            class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"
            placeholder="সমাপনি বোর্ড/মাদরাসা"
          >
          <button
            v-if="educationalQualifications.length > 1"
            @click="removeQualification(index)"
            type="button"
            class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition flex-shrink-0"
            title="রো মুছুন"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="flex justify-between items-center mt-4">
    <div class="space-y-2 md:w-1/4">
      <label for="teachingExperience" class="block text-emerald-800">শিক্ষকতার অভিজ্ঞতা</label>
      <input
        type="text"
        id="teachingExperience"
        v-model="teachingExperience"
        class="w-full px-4 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50"
        placeholder="কত বছর"
      >
    </div>

    <button
      type="button"
      @click="addQualification"
      class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition"
    >
      আরো যোগ করুন
    </button>
  </div>
</div>


        <!-- Desired Books -->
        <div class="mb-8 flex flex-wrap bg-emerald-50 p-4 rounded-lg">
  <div class="w-full md:w-1/2 pr-4">
    <h5 class="text-lg font-semibold mb-4 border-b border-emerald-500 pb-2 text-emerald-800 flex items-center">
      <span class="mr-2 text-emerald-600"></span> কাঙ্খিত কিতাব
    </h5>
    <div class="relative w-64">
      <button
        @click="toggleBookDropdown"
        class="w-full flex items-center justify-between px-4 py-3 border border-emerald-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg bg-white"
      >
        <span>{{ 'কিতাব নির্বাচন করুন' }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-700" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </button>
      <div v-if="showBookDropdown" class="absolute z-10 w-full mt-1 bg-white border border-emerald-200 rounded-lg shadow-lg">
        <ul class="py-1">
          <li v-for="(category, index) in bookCategories" :key="index" class="relative group">
            <a
              href="#"
              @click.prevent="toggleSubMenu(index)"
              class=" px-4 py-2 hover:bg-emerald-50 flex justify-between items-center"
            >
              {{ category.name }}
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-700" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
            </a>
            <ul v-if="category.showSubmenu" class="absolute left-full top-0 w-full bg-white border border-emerald-200 rounded-lg shadow-lg">
              <li v-for="(book, bookIndex) in category.books" :key="bookIndex">
                <a
                  href="#"
                  @click.prevent="addSelectedBook(book)"
                  class="block px-4 py-2 hover:bg-emerald-50"
                >
                  {{ book }}
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="w-full md:w-1/2 mt-6 md:mt-0">
    <h5 class="text-lg font-semibold mb-4 border-b border-emerald-500 pb-2 text-emerald-800 flex items-center">
      <span class="mr-2 text-emerald-600"></span> নির্বাচিত কিতাবসমূহ
    </h5>
    <div class="bg-white rounded-lg p-4 border border-emerald-200 min-h-[200px] shadow-sm bg-opacity-80 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2720%27%20height%3D%2720%27%20viewBox%3D%270%200%2020%2020%27%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%3E%3Cg%20fill%3D%27%2310b981%27%20fill-opacity%3D%270.05%27%20fill-rule%3D%27evenodd%27%3E%3Ccircle%20cx%3D%273%27%20cy%3D%273%27%20r%3D%273%27%2F%3E%3Ccircle%20cx%3D%2713%27%20cy%3D%2713%27%20r%3D%273%27%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E')]">
      <div v-if="selectedBooks.length === 0" class="text-center text-gray-500 py-8">
        <p>কোন কিতাব নির্বাচন করা হয়নি</p>
      </div>
      <ul v-else>
        <li v-for="(book, index) in selectedBooks" :key="index" class="flex justify-between items-center p-2 mb-2 bg-white rounded border border-emerald-100 hover:shadow-md transition-shadow">
          <span class="text-emerald-900">{{ book }}</span>
          <button @click="removeBook(index)" class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </li>
      </ul>
    </div>
  </div>
</div>

        <!-- Payment Information -->
        <div class="mb-8 bg-emerald-50 p-6 rounded-lg border border-emerald-200">
  <h5 class="text-lg font-semibold mb-4 border-b border-emerald-500 pb-2 text-emerald-800">পেমেন্ট</h5>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="space-y-2">
      <label for="nagadNumber" class="block text-emerald-700 font-medium">নগদ নম্বর</label>
      <input
        type="text"
        id="nagadNumber"
        v-model="payment.nagad"
        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
        placeholder="নগদ নম্বর দিন"
      >
    </div>
    <div class="space-y-2">
      <label for="rocketNumber" class="block text-emerald-700 font-medium">রকেট নম্বর</label>
      <input
        type="text"
        id="rocketNumber"
        v-model="payment.rocket"
        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
        placeholder="রকেট নম্বর দিন"
      >
    </div>
    <div class="space-y-2">
      <label for="bkashNumber" class="block text-emerald-700 font-medium">বিকাশ নম্বর</label>
      <input
        type="text"
        id="bkashNumber"
        v-model="payment.bkash"
        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
        placeholder="বিকাশ নম্বর দিন"
      >
    </div>
  </div>
</div>

<div class="mb-8 bg-white p-6 rounded-lg border border-gray-200">
  <h5 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-800">সংযুক্তি</h5>

  <div class="mt-4 space-y-3">
    <!-- মুহতামিম সাহেব সত্যায়িত কপি -->
    <div class="relative">
      <label class="block text-sm font-medium text-gray-700 mb-1">
        <i class="fas fa-file-alt mr-1"></i>মুহতামিম সাহেব সত্যায়িত কপি
      </label>
      <input
        type="file"
        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
        @change="handleFileChange($event, 'muhtamim')"
        v-if="!files.muhtamim"
      />
      <div v-if="!files.muhtamim" class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
        <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
        <span class="text-gray-600">ফাইল আপলোড করুন</span>
      </div>
      <!-- ফাইল আপলোড হলে দেখাবে -->
      <div v-else class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
        <div class="flex items-center">
          <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
          <span class="text-gray-700 truncate">{{ files.muhtamim.name }}</span>
        </div>
        <div class="flex space-x-2">
          <button type="button" @click="viewFile(files.muhtamim)" class="text-blue-500 hover:text-blue-700">
            <i class="fas fa-eye"></i>
          </button>
          <button type="button" @click="removeFile('muhtamim')" class="text-red-500 hover:text-red-700">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- এন.আইডি কপি -->
    <div class="relative">
      <label class="block text-sm font-medium text-gray-700 mb-1">
        <i class="fas fa-id-card mr-1"></i>এন.আইডি কপি
      </label>
      <input
        type="file"
        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
        @change="handleFileChange($event, 'nid')"
        v-if="!files.nid"
      />
      <div v-if="!files.nid" class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
        <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
        <span class="text-gray-600">ফাইল আপলোড করুন</span>
      </div>
      <!-- ফাইল আপলোড হলে দেখাবে -->
      <div v-else class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
        <div class="flex items-center">
          <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
          <span class="text-gray-700 truncate">{{ files.nid.name }}</span>
        </div>
        <div class="flex space-x-2">
          <button type="button" @click="viewFile(files.nid)" class="text-blue-500 hover:text-blue-700">
            <i class="fas fa-eye"></i>
          </button>
          <button type="button" @click="removeFile('nid')" class="text-red-500 hover:text-red-700">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- জন্ম-সনদ কপি -->
    <div class="relative">
      <label class="block text-sm font-medium text-gray-700 mb-1">
        <i class="fas fa-certificate mr-1"></i>জন্ম-সনদ কপি
      </label>
      <input
        type="file"
        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
        @change="handleFileChange($event, 'birthCert')"
        v-if="!files.birthCert"
      />
      <div v-if="!files.birthCert" class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
        <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
        <span class="text-gray-600">ফাইল আপলোড করুন</span>
      </div>
      <!-- ফাইল আপলোড হলে দেখাবে -->
      <div v-else class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
        <div class="flex items-center">
          <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
          <span class="text-gray-700 truncate">{{ files.birthCert.name }}</span>
        </div>
        <div class="flex space-x-2">
          <button type="button" @click="viewFile(files.birthCert)" class="text-blue-500 hover:text-blue-700">
            <i class="fas fa-eye"></i>
          </button>
          <button type="button" @click="removeFile('birthCert')" class="text-red-500 hover:text-red-700">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Comments -->
<div class="mb-8 bg-white p-6 rounded-lg border border-gray-200">
  <h5 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-800">মন্তব্য</h5>
  <div class="flex flex-col md:flex-row gap-6">
    <div class="md:w-2/3">
      <div class="space-y-2">
        <label for="comments" class="block text-sm font-medium text-gray-700">মন্তব্য লিখুন</label>
        <textarea
          id="comments"
          v-model="comments"
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
          rows="8"
        ></textarea>
      </div>
    </div>
    <div class="md:w-1/3 flex items-end">
      <button
        @click="submitForm"
        class="w-full px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-lg"
      >
        সেভ করুন
      </button>
    </div>
  </div>
</div>
</form >

</div>
      </div>
    </div>


    </AuthenticatedLayout>
  </template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, reactive, watch } from 'vue';
import axios from 'axios';
const props = defineProps({
    // roll: String,
    // reg_id: String,
    // CID: String,
    // modelValue: Object
});



const profileImage = ref(null);
const address = reactive({
  division: 'ঢাকা',
  district: 'মানিকগঞ্জ',
  thana: 'কদমতলী',
  post: '',
  village: ''
});
const applicationType = ref('নেগরান');
const educationalQualifications = reactive([
  {
    className: 'তাকমিল',
    passYear: '',
    result: '',
    institution: ''
  }
]);
const teachingExperience = ref('');
const selectedBook = ref('');
const payment = reactive({
  nagad: '',
  rocket: '',
  bkash: ''
});
const files = reactive({
  muhtamim: null,
  nid: null,
  birthCert: null
});
const comments = ref('');

// Profile image handling
const handleProfileImageChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    profileImage.value = URL.createObjectURL(file);
  }
};

const addQualification = () => {
  educationalQualifications.push({
    className: 'তাকমিল',
    passYear: '',
    result: '',
    institution: ''
  });
};

const selectBook = (book) => {
  selectedBook.value = book;
  showBookDropdown.value = false;
};

const removeQualification = (index) => {
  if (educationalQualifications.length > 1) {
    educationalQualifications.splice(index, 1);
  }
};




function toggleBookDropdown() {
  showBookDropdown.value = !showBookDropdown.value;
}

function toggleSubMenu(index) {
  // Close all other submenus
  bookCategories.value.forEach((category, i) => {
    if (i !== index) {
      category.showSubmenu = false;
    }
  });
  // Toggle the clicked submenu
  bookCategories.value[index].showSubmenu = !bookCategories.value[index].showSubmenu;
}

function addSelectedBook(book) {
  if (!selectedBooks.value.includes(book)) {
    selectedBooks.value.push(book);
  }
  showBookDropdown.value = false;
}

function removeBook(index) {
  selectedBooks.value.splice(index, 1);
}


// Comments
function handleFileChange(event, type) {
  const file = event.target.files[0];
  if (file) {
    files.value[type] = file;
  }
}

function viewFile(file) {
  if (file) {
    // Create a URL for the file and open it in a new tab
    const fileURL = URL.createObjectURL(file);
    window.open(fileURL, '_blank');
  }
}

function removeFile(type) {
  files.value[type] = null;
}

function saveForm() {
  // Implement your save logic here
  console.log('Saving form with files:', files.value);
  console.log('Comments:', comments.value);
  // You would typically send this data to your server here
}

// টিচার ডাটা হ্যান্ডলিং
const teachers = ref({
    TName: '',
    Mobile: '',
    DateofBirth: '',
  whatsapp: '',
  National_Id_Card: '',
  nid: '',
  gender: ''
});

// ব্যাকএন্ড থেকে ডাটা লোড করা
onMounted(() => {
  // লোকাল স্টোরেজ থেকে সার্চ রেজাল্ট লোড করুন
  const storedResults = localStorage.getItem('teacherSearchResults');
  if (storedResults) {
    const parsedResults = JSON.parse(storedResults);
    if (Array.isArray(parsedResults) && parsedResults.length > 0) {
      teachers.value = parsedResults[0]; // প্রথম টিচারের ডাটা নিয়ে আসা
    } else if (typeof parsedResults === 'object') {
      teachers.value = parsedResults; // একক অবজেক্ট হলে সেটাই নিয়ে আসা
    }
  }
});

const goBack = () => {
  window.location.href = '/teacher-search';
};

// তারিখ ফরম্যাট করার ফাংশন
const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('bn-BD', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }).format(date);
};

// অতিরিক্ত তথ্য আছে কিনা চেক করার ফাংশন
const hasAdditionalInfo = (teacher) => {
  return teacher.Hifz !== 0 || teacher.Kirat !== 0 || teacher.Momtahin !== 0;
};







const emit = defineEmits(['update:modelValue']);
const divisions = ref([]);
const presentDistricts = ref([]);
const presentThanas = ref([]);
const districts = ref([]);
const thanas = ref([]);

// Separate refs for present and permanent address data
const presentFilters = ref({
    division: '',
    district: '',
    Thana: ''
});

const permanentFilters = ref({
    division: '',
    district: '',
    Thana: ''
});

// Initialize filters from props if they exist
const initializeFilters = () => {
    if (props.modelValue && props.modelValue.presernt_DID) {
        presentFilters.value.division = props.modelValue.presernt_DID;
    }
    if (props.modelValue && props.modelValue.present_des_id) {
        presentFilters.value.district = props.modelValue.present_des_id;
    }
    if (props.modelValue && props.modelValue.present_TID) {
        presentFilters.value.Thana = props.modelValue.present_TID;
    }

    if (props.modelValue && props.modelValue.parmanent_DID) {
        permanentFilters.value.division = props.modelValue.parmanent_DID;
    }
    if (props.modelValue && props.modelValue.parmanent_desId) {
        permanentFilters.value.district = props.modelValue.parmanent_desId;
    }
    if (props.modelValue && props.modelValue.parmanent_TID) {
        permanentFilters.value.Thana = props.modelValue.parmanent_TID;
    }
};

// Watch for changes in props.modelValue to initialize filters
watch(() => props.modelValue, (newValue) => {
    if (newValue) {
        initializeFilters();
    }
}, { immediate: true });

// Watch for changes in presentFilters and update the form
watch(presentFilters, async (newValues) => {
    if (!props.modelValue) return;

    const updatedValue = { ...props.modelValue };

    // Update division
    if (newValues.division) {
        const selectedDivision = divisions.value.find(d => d.id == newValues.division);
        if (selectedDivision) {
            updatedValue.present_division_name = selectedDivision.Division_U;
            updatedValue.presernt_DID = selectedDivision.id;
        }
    }

    // Update district
    if (newValues.district) {
        const selectedDistrict = presentDistricts.value.find(d => d.DesID == newValues.district);
        if (selectedDistrict) {
            updatedValue.present_district_name = selectedDistrict.District_U;
            updatedValue.present_des_id = selectedDistrict.DesID;
        }
    }

    // Update thana
    if (newValues.Thana) {
        const selectedThana = presentThanas.value.find(t => t.Thana_ID == newValues.Thana);
        if (selectedThana) {
            updatedValue.present_thana_name = selectedThana.Thana_U;
            updatedValue.present_TID = selectedThana.Thana_ID;
        }
    }

    emit('update:modelValue', updatedValue);
}, { deep: true });


// Watch for changes in permanentFilters and update the form
watch(permanentFilters, async (newValues) => {
    if (!props.modelValue) return;

    const updatedValue = { ...props.modelValue };

    // Update division
    if (newValues.division) {
        const selectedDivision = divisions.value.find(d => d.id == newValues.division);
        if (selectedDivision) {
            updatedValue.parmanent_division_name = selectedDivision.Division_U;
            updatedValue.parmanent_DID = selectedDivision.id;
        }
    }

    // Update district
    if (newValues.district) {
        const selectedDistrict = districts.value.find(d => d.DesID == newValues.district);
        if (selectedDistrict) {
            updatedValue.parmanent_district_name = selectedDistrict.District_U;
            updatedValue.parmanent_desId = selectedDistrict.DesID;
        }
    }

    // Update thana
    if (newValues.Thana) {
        const selectedThana = thanas.value.find(t => t.Thana_ID == newValues.Thana);
        if (selectedThana) {
            updatedValue.parmanent_thana_name = selectedThana.Thana_U;
            updatedValue.parmanent_TID = selectedThana.Thana_ID;
        }
    }

    emit('update:modelValue', updatedValue);
}, { deep: true });

onMounted(async () => {
    await loadDivisions();
    initializeFilters();

    // If we have saved values, load the related districts and thanas
    if (presentFilters.value.division) {
        await presentHandleDivisionChange();

        if (presentFilters.value.district) {
            await presentHandleDistrictChange();
        }
    }

    if (permanentFilters.value.division) {
        await handleDivisionChange();

        if (permanentFilters.value.district) {
            await handleDistrictChange();
        }
    }

    // const marhalaId = route().params.marhalaId;
    // currentMarhalaId.value = marhalaId;

    // try {
    //     const response = await axios.get(`/api/student-registration/${marhalaId}`);
    //     examName.value = response.data.examName;
    //     marhalaName.value = response.data.marhalaName;

    //     // এই লাইন যোগ করুন - studentInfoForm এ মারহালার নাম সেট করুন
    //     studentInfoForm.current_class = response.data.marhalaName;
    //     studentInfoForm.marhala_id = marhalaId;

    // } catch (error) {
    //     console.error("Error fetching marhala info:", error);
    // }
});



const loadDivisions = async () => {
    try {
        const response = await axios.get('/api/divisions');
        divisions.value = response.data;
        return true;
    } catch (error) {
        console.error('Error loading divisions:', error);
        return false;
    }
};

// Present address handlers
const presentHandleDivisionChange = async () => {
    presentFilters.value.district = '';
    presentFilters.value.Thana = '';
    presentDistricts.value = [];
    presentThanas.value = [];

    if (!presentFilters.value.division) {
        return;
    }

    try {
        const response = await axios.get(`/api/districts/${presentFilters.value.division}`);
        presentDistricts.value = response.data;
    } catch (error) {
        console.error('Error loading districts:', error);
    }
};

const presentHandleDistrictChange = async () => {
    presentFilters.value.Thana = '';
    presentThanas.value = [];

    if (!presentFilters.value.district) {
        return;
    }

    try {
        const response = await axios.get(`/api/thanas/${presentFilters.value.district}`);
        presentThanas.value = response.data;
    } catch (error) {
        console.error('Error loading thanas:', error);
    }
};

// const presentHandleDistrictChange = async () => {
//     presentFilters.value.Thana = '';
//     presentThanas.value = [];

//     if (!presentFilters.value.district) {
//         return;
//     }

//     try {
//         const response = await axios.get(`/api/thanas/${presentFilters.value.district}`);
//         presentThanas.value = response.data;
//     } catch (error) {
//         console.error('Error loading thanas:', error);
//     }
// };

// Permanent address handlers
const handleDivisionChange = async () => {
    permanentFilters.value.district = '';
    permanentFilters.value.Thana = '';
    districts.value = [];
    thanas.value = [];

    if (!permanentFilters.value.division) {
        return;
    }

    try {
        const response = await axios.get(`/api/districts/${permanentFilters.value.division}`);
        districts.value = response.data;
    } catch (error) {
        console.error('Error loading districts:', error);
    }
};

const handleDistrictChange = async () => {
    permanentFilters.value.Thana = '';
    thanas.value = [];

    if (!permanentFilters.value.district) {
        return;
    }

    try {
        const response = await axios.get(`/api/thanas/${permanentFilters.value.district}`);
        thanas.value = response.data;
    } catch (error) {
        console.error('Error loading thanas:', error);
    }
};







const updateFormData = () => {
    // বর্তমান ঠিকানার ডাটা আপডেট
    if (presentFilters.value.division) {
        const selectedDivision = divisions.value.find(d => d.id == presentFilters.value.division);
        if (selectedDivision) {
            studentInfoForm.present_division_name = selectedDivision.Division;
            studentInfoForm.presernt_DID = selectedDivision.id;
            console.log('Updated present division:', studentInfoForm.present_division_name, studentInfoForm.presernt_DID);
        }
    }

    if (presentFilters.value.district) {
        const selectedDistrict = presentDistricts.value.find(d => d.DesID == presentFilters.value.district);
        if (selectedDistrict) {
            studentInfoForm.present_district_name = selectedDistrict.District;
            studentInfoForm.present_desId = selectedDistrict.DesID;
            console.log('Updated present district:', studentInfoForm.present_district_name, studentInfoForm.present_desId);
        }
    }

    if (presentFilters.value.Thana) {
        // এখানে Thana_ID ব্যবহার করুন, TID নয়
        const selectedThana = presentThanas.value.find(t => t.Thana_ID == presentFilters.value.Thana);
        if (selectedThana) {
            studentInfoForm.present_thana_name = selectedThana.Thana;
            studentInfoForm.present_TID = selectedThana.Thana_ID;
            console.log('Updated present thana:', studentInfoForm.present_thana_name, studentInfoForm.present_TID);
        } else {
            console.log('Thana not found with ID:', presentFilters.value.Thana);
            console.log('Available thanas:', presentThanas.value);
        }
    }

    // স্থায়ী ঠিকানার ডাটা আপডেট
    if (permanentFilters.value.division) {
        const selectedDivision = divisions.value.find(d => d.id == permanentFilters.value.division);
        if (selectedDivision) {
            studentInfoForm.parmanent_division_name = selectedDivision.Division;
            studentInfoForm.parmanent_DID = selectedDivision.id;
            console.log('Updated permanent division:', studentInfoForm.parmanent_division_name, studentInfoForm.parmanent_DID);
        }
    }

    if (permanentFilters.value.district) {
        const selectedDistrict = districts.value.find(d => d.DesID == permanentFilters.value.district);
        if (selectedDistrict) {
            studentInfoForm.parmanent_district_name = selectedDistrict.District;
            studentInfoForm.parmanent_desId = selectedDistrict.DesID;
            console.log('Updated permanent district:', studentInfoForm.parmanent_district_name, studentInfoForm.parmanent_desId);
        }
    }

    if (permanentFilters.value.Thana) {
        // এখানে Thana_ID ব্যবহার করুন, TID নয়
        const selectedThana = thanas.value.find(t => t.Thana_ID == permanentFilters.value.Thana);
        if (selectedThana) {
            studentInfoForm.parmanent_thana_name = selectedThana.Thana;
            studentInfoForm.parmanent_TID = selectedThana.Thana_ID;
            console.log('Updated permanent thana:', studentInfoForm.parmanent_thana_name, studentInfoForm.parmanent_TID);
        } else {
            console.log('Permanent thana not found with ID:', permanentFilters.value.Thana);
            console.log('Available permanent thanas:', thanas.value);
        }
    }
}










const showBookDropdown = ref(false);
const bookCategories = ref([]);
const selectedBooks = ref([]);

// Toggle the main dropdown
// const toggleBookDropdown = () => {
//   showBookDropdown.value = !showBookDropdown.value;
// };

// // Toggle submenu for a specific category
// const toggleSubMenu = (index) => {
//   bookCategories.value.forEach((category, i) => {
//     if (i === index) {
//       category.showSubmenu = !category.showSubmenu;
//     } else {
//       category.showSubmenu = false;
//     }
//   });
// };

// // Add a book to the selected books list
// const addSelectedBook = (book) => {
//   if (!selectedBooks.value.includes(book)) {
//     selectedBooks.value.push(book);
//   }
//   showBookDropdown.value = false;
// };

// // Remove a book from the selected books list
// const removeBook = (index) => {
//   selectedBooks.value.splice(index, 1);
// };

// Fetch book categories and subjects from the backend
onMounted(async () => {
  try {
    const response = await fetch('/api/get-book-categories');
    if (response.ok) {
      bookCategories.value = await response.json();
    } else {
      console.error('Failed to fetch book categories');
    }
  } catch (error) {
    console.error('Error fetching book categories:', error);
  }
});












const formData = reactive({
  name: '',
  email: '',
  phone: '',
  message: '',
});

// লোডিং এবং এরর স্টেট
const isSubmitting = ref(false);
const errors = reactive({});
const successMessage = ref('');

// ফর্ম সাবমিট হ্যান্ডলার
const submitForm = async () => {
  try {
    // Create form data for file uploads
    const formData = new FormData();

    // Add personal information
    Object.keys(teachers).forEach(key => {
      formData.append(`teachers[${key}]`, teachers[key]);
    });

    // Add profile image
    if (profileImage.value) {
      formData.append('profileImage', profileImage.value);
    }

    // Add application type
    formData.append('applicationType', applicationType.value);

    // Add address information
    formData.append('presentFilters[division]', presentFilters.division);
    formData.append('presentFilters[district]', presentFilters.district);
    formData.append('presentFilters[Thana]', presentFilters.Thana);
    formData.append('address[post]', address.post);
    formData.append('address[village]', address.village);

    // Add educational qualifications
    educationalQualifications.forEach((qualification, index) => {
      Object.keys(qualification).forEach(key => {
        formData.append(`educationalQualifications[${index}][${key}]`, qualification[key]);
      });
    });

    // Add teaching experience
    formData.append('teachingExperience', teachingExperience.value);

    // Add selected books
    selectedBooks.value.forEach((book, index) => {
      formData.append(`selectedBooks[${index}]`, book);
    });

    // Add payment information
    formData.append('payment[nagad]', payment.nagad);
    formData.append('payment[rocket]', payment.rocket);
    formData.append('payment[bkash]', payment.bkash);

    // Add files
    if (files.muhtamim) {
      formData.append('files[muhtamim]', files.muhtamim);
    }
    if (files.nid) {
      formData.append('files[nid]', files.nid);
    }
    if (files.birthCert) {
      formData.append('files[birthCert]', files.birthCert);
    }

    // Add comments
    formData.append('comments', comments.value);

    // Submit the form without explicit Content-Type header
    const response = await axios.post('/api/neg-mumtahin-application', formData);

    // Handle success
    if (response.data.success) {
      alert('আপনার আবেদন সফলভাবে জমা হয়েছে');
      window.location.href = '/dashboard';
    }
  } catch (error) {
    console.error('Form submission error:', error);

    // এরর রেসপন্স দেখুন
    if (error.response) {
      console.log('Error status:', error.response.status);
      console.log('Error data:', error.response.data);

      // ভ্যালিডেশন এরর মেসেজগুলি দেখান
      if (error.response.data.errors) {
        const errorMessages = Object.values(error.response.data.errors).flat();
        alert('আবেদন জমা দেওয়ার সময় ত্রুটি: ' + errorMessages.join('\n'));
      } else if (error.response.data.message) {
        alert('আবেদন জমা দেওয়ার সময় ত্রুটি: ' + error.response.data.message);
      } else {
        alert('আবেদন জমা দেওয়ার সময় একটি ত্রুটি হয়েছে');
      }
    } else {
      alert('আবেদন জমা দেওয়ার সময় একটি ত্রুটি হয়েছে');
    }
  }
};



// ফর্ম ভ্যালিডেশন
const validateForm = () => {
  const newErrors = {};

  if (!formData.name.trim()) {
    newErrors.name = 'নাম আবশ্যক';
  }

  if (!formData.email.trim()) {
    newErrors.email = 'ইমেইল আবশ্যক';
  } else if (!/^\S+@\S+\.\S+$/.test(formData.email)) {
    newErrors.email = 'সঠিক ইমেইল দিন';
  }

  if (!formData.phone.trim()) {
    newErrors.phone = 'ফোন নম্বর আবশ্যক';
  }

  if (!formData.message.trim()) {
    newErrors.message = 'বার্তা আবশ্যক';
  }

  errors.value = newErrors;
  return Object.keys(newErrors).length === 0;
};



// ফর্ম সাবমিট হ্যান্ডলার (ভ্যালিডেশন সহ)
const handleSubmit = () => {
  if (validateForm()) {
    submitForm();
  }
};

// কম্পোনেন্ট মাউন্ট হওয়ার সময় কোন ইনিশিয়ালাইজেশন প্রয়োজন হলে
onMounted(() => {
  // কোন ইনিশিয়ালাইজেশন লজিক (যদি প্রয়োজন হয়)
});

// এক্সপোজ করা ভ্যারিয়েবল এবং ফাংশন (টেম্পলেট থেকে অ্যাক্সেস করার জন্য)
// <script setup> এ defineExpose() ব্যবহার করে এক্সপোজ করতে হয়
defineExpose({
  formData,
  isSubmitting,
  errors,
  successMessage,
  handleSubmit,
  validateForm
});
</script>
