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
                            <img :src="profileImage || 'img/islamic.png'" alt="User profile picture"
                                class="w-24 h-24 rounded-full mx-auto mb-3 object-cover">
                            <h3 class="text-xl font-semibold"></h3>
                            <input type="file" id="profileImageInput" class="hidden"
                                @change="handleProfileImageChange" />
                            <div class="flex justify-center items-center gap-2 mt-3 mb-6">
                                <label for="profileImageInput"
                                    class="px-4 py-2 border border-blue-500 text-blue-500 rounded-md text-sm flex items-center hover:bg-blue-50 transition cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    প্রোফাইল ছবি নির্বাচন করুন
                                </label>
                            </div>
                        </div>

                        <!-- Application Type -->
                        <div class="mb-8">
                            <div class="md:w-1/3">
                                <div class="space-y-2">
                                    <label for="applicationType" class="block text-emerald-800 font-semibold">আবেদনের
                                        ধরন</label>
                                    <Dropdown id="applicationType" v-model="form.applicationType"
                                        :options="applicationTypes" placeholder="আবেদনের ধরন নির্বাচন করুন"
                                        class="w-full" />
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <Card class="mb-8">
                            <template #header>
                                <div class="flex items-center text-lg font-semibold text-emerald-800 mt-3 mx-5">
                                    <i class="pi pi-user mr-2 text-emerald-600"></i>
                                    ব্যক্তিগত তথ্য
                                </div>
                            </template>
                            <template #content>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                    <div class="field">
                                        <label for="name" class="block text-emerald-800">নাম</label>
                                        <InputText id="name" v-model="form.teachers.name" class="w-full"
                                            placeholder="আপনার নাম লিখুন" />
                                        <small v-if="form.errors['teachers.name']" class="p-error">
                                            {{ form.errors['teachers.name'] }}
                                        </small>
                                    </div>

                                    <div class="field">
                                        <label for="mobile" class="block text-emerald-800">মোবাইল নম্বর</label>
                                        <InputText id="mobile" v-model="form.teachers.Mobile" class="w-full"
                                            placeholder="মোবাইল নম্বর লিখুন" />
                                        <small v-if="form.errors['teachers.Mobile']" class="p-error">
                                            {{ form.errors['teachers.Mobile'] }}
                                        </small>
                                    </div>

                                    <div class="field">
                                        <label for="birthDate" class="block text-emerald-800">জন্ম-তারিখ</label>
                                        <Calendar id="birthDate" v-model="form.teachers.DateofBirth"
                                            dateFormat="yy-mm-dd" class="w-full" />
                                        <small v-if="form.errors['teachers.DateofBirth']" class="p-error">
                                            {{ form.errors['teachers.DateofBirth'] }}
                                        </small>
                                    </div>

                                    <div class="field">
                                        <label for="whatsapp" class="block text-emerald-800">হোয়াটসঅ্যাপ নম্বর</label>
                                        <InputText id="whatsapp" v-model="form.teachers.whatsapp" class="w-full"
                                            placeholder="হোয়াটসঅ্যাপ নম্বর" />
                                        <small v-if="form.errors['teachers.whatsapp']" class="p-error">
                                            {{ form.errors['teachers.whatsapp'] }}
                                        </small>
                                    </div>

                                    <div class="field">
                                        <label for="birthRegNo" class="block text-emerald-800">জন্ম নিবন্ধন
                                            নম্বর</label>
                                        <InputText id="birthRegNo" v-model="form.teachers.National_Id_Card"
                                            class="w-full" placeholder="জন্ম নিবন্ধন নম্বর" />
                                        <small v-if="form.errors['teachers.National_Id_Card']" class="p-error">
                                            {{ form.errors['teachers.National_Id_Card'] }}
                                        </small>
                                    </div>

                                    <div class="field">
                                        <label for="nid" class="block text-emerald-800">এন.আইডি নম্বর</label>
                                        <InputText id="nid" v-model="form.teachers.nid" class="w-full"
                                            placeholder="এন.আইডি নম্বর" />
                                        <small v-if="form.errors['teachers.nid']" class="p-error">
                                            {{ form.errors['teachers.nid'] }}
                                        </small>
                                    </div>

                                    <div class="field">
                                        <label for="gender" class="block text-emerald-800">জেন্ডার</label>
                                        <Dropdown id="gender" v-model="form.teachers.gender" :options="genderOptions"
                                            class="w-full" />
                                        <small v-if="form.errors['teachers.gender']" class="p-error">
                                            {{ form.errors['teachers.gender'] }}
                                        </small>
                                    </div>
                                </div>
                            </template>
                        </Card>





                        <Card class="mb-8">
                            <template #header>
                                <div class="flex items-center text-lg font-semibold text-emerald-800 mt-3 mx-5">
                                    <i class="pi pi-book mr-2 text-emerald-600"></i>
                                    শিক্ষাগত যোগ্যতা
                                </div>
                            </template>
                            <template #content>
                                <div v-for="(qualification, index) in form.educationalQualifications" :key="index"
                                    class="mb-6">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                                        <div class="field">
                                            <label :for="`class-${index}`" class="block text-emerald-800">মারহালার
                                                নাম/ক্লাসের নাম</label>
                                            <Dropdown :id="`class-${index}`"
                                                v-model="form.educationalQualifications[index].className"
                                                :options="classOptions" placeholder="ক্লাস নির্বাচন করুন"
                                                class="w-full" />
                                        </div>

                                        <div class="field">
                                            <label :for="`passYear-${index}`" class="block text-emerald-800">পাসের
                                                সন</label>
                                            <InputText :id="`passYear-${index}`"
                                                v-model="form.educationalQualifications[index].passYear" class="w-full"
                                                placeholder="পাসের সন" />
                                        </div>

                                        <div class="field">
                                            <label :for="`result-${index}`" class="block text-emerald-800">ফলাফল
                                                (বিভাগ)</label>
                                            <InputText :id="`result-${index}`"
                                                v-model="form.educationalQualifications[index].result" class="w-full"
                                                placeholder="ফলাফল (বিভাগ)" />
                                        </div>

                                        <div class="field">
                                            <label :for="`institution-${index}`" class="block text-emerald-800">সমাপনি
                                                বোর্ড/মাদরাসা</label>
                                            <div class="flex gap-2">
                                                <InputText :id="`institution-${index}`"
                                                    v-model="form.educationalQualifications[index].institution"
                                                    class="w-full" placeholder="সমাপনি বোর্ড/মাদরাসা" />
                                                <button v-if="form.educationalQualifications.length > 1"
                                                    @click="removeQualification(index)" type="button"
                                                    class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition flex-shrink-0"
                                                    title="রো মুছুন">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-4">
                                    <div class="field md:w-1/4">
                                        <label for="teachingExperience" class="block text-emerald-800">শিক্ষকতার
                                            অভিজ্ঞতা</label>
                                        <InputText id="teachingExperience" v-model="form.teachers.teaching_experience"
                                            class="w-full" placeholder="কত বছর" />
                                    </div>
                                    <Button type="button" @click="addQualification" label="আরো যোগ করুন"
                                        icon="pi pi-plus" severity="success" />
                                </div>
                            </template>
                        </Card>



                        <div class="mb-8 flex flex-wrap bg-emerald-50 p-4 rounded-lg">
                            <div class="w-full md:w-1/2 pr-4">
                                <h5
                                    class="text-lg font-semibold mb-4 border-b border-emerald-500 pb-2 text-emerald-800 flex items-center">
                                    <span class="mr-2 text-emerald-600"></span> কাঙ্খিত কিতাব
                                </h5>
                                <div class="relative w-64">
                                    <Button type="button" @click="toggleBookDropdown"
                                        class="w-full flex items-center justify-between px-4 py-3 border border-emerald-600 rounded-lg text-lg"
                                        outlined>
                                        <span>{{ 'কিতাব নির্বাচন করুন' }}</span>
                                        <i class="pi pi-chevron-down text-emerald-700"></i>
                                    </Button>

                                    <!-- Keep the original nested dropdown structure -->
                                    <div v-if="showBookDropdown"
                                        class="absolute z-10 w-full mt-1 bg-white border border-emerald-200 rounded-lg shadow-lg">
                                        <ul class="py-1">
                                            <li v-for="(category, index) in bookCategories" :key="index"
                                                class="relative group">
                                                <a href="#" @click.prevent="toggleSubMenu(index)"
                                                    class="px-4 py-2 hover:bg-emerald-50 flex justify-between items-center">
                                                    {{ category.name }}
                                                    <i class="pi pi-chevron-right text-emerald-700"></i>
                                                </a>
                                                <ul v-if="category.showSubmenu"
                                                    class="absolute left-full top-0 w-full bg-white border border-emerald-200 rounded-lg shadow-lg">
                                                    <li v-for="(book, bookIndex) in category.books" :key="bookIndex">
                                                        <a type="button" href="#" @click.prevent="addSelectedBook(book)"
                                                            class="block px-4 py-2 hover:bg-emerald-50">
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
                                <h5
                                    class="text-lg font-semibold mb-4 border-b border-emerald-500 pb-2 text-emerald-800 flex items-center">
                                    <span class="mr-2 text-emerald-600"></span> কাঙ্খিত কিতাব
                                </h5>
                                <Panel
                                    class="min-h-[200px] shadow-sm bg-opacity-80 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2720%27%20height%3D%2720%27%20viewBox%3D%270%200%2020%2020%27%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%3E%3Cg%20fill%3D%27%2310b981%27%20fill-opacity%3D%270.05%27%20fill-rule%3D%27evenodd%27%3E%3Ccircle%20cx%3D%273%27%20cy%3D%273%27%20r%3D%273%27%2F%3E%3Ccircle%20cx%3D%2713%27%20cy%3D%2713%27%20r%3D%273%27%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E')]">
                                    <div v-if="selectedBooks.length === 0" class="text-center text-gray-500 py-8">
                                        <p>কোন কিতাব নির্বাচন করা হয়নি</p>
                                    </div>
                                    <ul v-else>
                                        <li v-for="(book, index) in selectedBooks" :key="index"
                                            class="flex justify-between items-center p-2 mb-2 bg-white rounded border border-emerald-100 hover:shadow-md transition-shadow">
                                            <span class="text-emerald-900">{{ book }}</span>
                                            <!-- Keep the original cross icon -->
                                            <button type="button" @click="removeBook(index)"
                                                class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </li>
                                    </ul>
                                </Panel>
                            </div>
                        </div>


                        <!-- ঠিকানা -->
                        <Card class="mb-8">
                            <template #header>
                                <div class="flex items-center text-lg font-semibold text-emerald-800 mt-3 mx-5">
                                    <i class="pi pi-map-marker mr-2 text-emerald-600"></i>
                                    ঠিকানা
                                </div>
                            </template>
                            <template #content>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                    <div class="relative">
                                        <label
                                            class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                            বিভাগ
                                        </label>
                                        <div class="relative">
                                            <Dropdown v-model="presentFilters.division"
                                                @change="presentHandleDivisionChange" :options="divisions"
                                                optionLabel="Division" optionValue="id" placeholder="সকল"
                                                class="w-full" />
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <label
                                            class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                            জেলা
                                        </label>
                                        <div class="relative">
                                            <Dropdown v-model="presentFilters.district"
                                                @change="presentHandleDistrictChange" :options="presentDistricts"
                                                optionLabel="District" optionValue="DesID" placeholder="সকল"
                                                class="w-full" />
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <label
                                            class="flex text-emerald-700 text-lg font-arabic font-medium gap-2 items-center mb-1">
                                            থানা/উপজেলা
                                        </label>
                                        <div class="relative">
                                            <Dropdown v-model="presentFilters.Thana" :options="presentThanas"
                                                optionLabel="Thana" optionValue="Thana_ID" placeholder="সকল"
                                                class="w-full" />
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="field">
                                        <label for="post" class="block text-emerald-800">পোস্ট</label>
                                        <InputText id="post" v-model="form.teachers.post" class="w-full text-lg"
                                            placeholder="পোস্ট" />
                                    </div>

                                    <div class="field">
                                        <label for="village" class="block text-emerald-800">গ্রাম</label>
                                        <InputText id="village" v-model="form.teachers.village" class="w-full text-lg"
                                            placeholder="গ্রাম" />
                                    </div>
                                </div>
                            </template>
                        </Card>


                        <!-- পেমেন্ট -->
                        <Card class="mb-8 bg-emerald-50 border-emerald-200">
                            <template #header>
                                <div class="text-lg font-semibold text-emerald-800 mt-3 mx-5">
                                    পেমেন্ট
                                </div>
                            </template>
                            <template #content>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="field">
                                        <label for="nagadNumber" class="block text-emerald-700 font-medium">নগদ
                                            নম্বর</label>
                                        <InputText id="nagadNumber" v-model="form.teachers.nagad_number" class="w-full"
                                            placeholder="নগদ নম্বর দিন" />
                                    </div>

                                    <div class="field">
                                        <label for="rocketNumber" class="block text-emerald-700 font-medium">রকেট
                                            নম্বর</label>
                                        <InputText id="rocketNumber" v-model="form.teachers.rocket_number"
                                            class="w-full" placeholder="রকেট নম্বর দিন" />
                                    </div>

                                    <div class="field">
                                        <label for="bkashNumber" class="block text-emerald-700 font-medium">বিকাশ
                                            নম্বর</label>
                                        <InputText id="bkashNumber" v-model="form.teachers.bkash_number" class="w-full"
                                            placeholder="বিকাশ নম্বর দিন" />
                                    </div>
                                </div>
                            </template>
                        </Card>



                        <div class="mb-8 bg-white p-6 rounded-lg border border-gray-200">
                            <h5 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-800">সংযুক্তি</h5>
                            <div class="mt-4 space-y-3">
                                <!-- মুহতামিম সাহেব সত্যায়িত কপি -->
                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-file-alt mr-1"></i>মুহতামিম সাহেব সত্যায়িত কপি
                                    </label>
                                    <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        @change="handleFileChange($event, 'muhtamim')" v-if="!files.muhtamim" />
                                    <div v-if="!files.muhtamim"
                                        class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
                                        <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
                                        <span class="text-gray-600">ফাইল আপলোড করুন</span>
                                    </div>
                                    <!-- ফাইল আপলোড হলে দেখাবে -->
                                    <div v-else
                                        class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
                                        <div class="flex items-center">
                                            <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
                                            <span class="text-gray-700 truncate">{{ files.muhtamim.name }}</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" @click="viewFile(files.muhtamim)"
                                                class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" @click="removeFile('muhtamim')"
                                                class="text-red-500 hover:text-red-700">
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
                                    <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        @change="handleFileChange($event, 'nid')" v-if="!files.nid" />
                                    <div v-if="!files.nid"
                                        class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
                                        <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
                                        <span class="text-gray-600">ফাইল আপলোড করুন</span>
                                    </div>
                                    <!-- ফাইল আপলোড হলে দেখাবে -->
                                    <div v-else
                                        class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
                                        <div class="flex items-center">
                                            <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
                                            <span class="text-gray-700 truncate">{{ files.nid.name }}</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" @click="viewFile(files.nid)"
                                                class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" @click="removeFile('nid')"
                                                class="text-red-500 hover:text-red-700">
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
                                    <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        @change="handleFileChange($event, 'birthCert')" v-if="!files.birthCert" />
                                    <div v-if="!files.birthCert"
                                        class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
                                        <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
                                        <span class="text-gray-600">ফাইল আপলোড করুন</span>
                                    </div>
                                    <!-- ফাইল আপলোড হলে দেখাবে -->
                                    <div v-else
                                        class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
                                        <div class="flex items-center">
                                            <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
                                            <span class="text-gray-700 truncate">{{ files.birthCert.name }}</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" @click="viewFile(files.birthCert)"
                                                class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" @click="removeFile('birthCert')"
                                                class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- নেগরান মন্তব্য -->
                                <div class="space-y-2">
                                    <label for="negaran-comments" class="block text-xl font-medium text-gray-700">নেগরান
                                        মন্তব্য</label>
                                    <Editor v-model="form.teachers.negaranComments" editorStyle="height: 150px"
                                        class="w-full text-xl" />
                                </div>

                                <!-- মুমতাহিন মন্তব্য -->
                                <div class="space-y-2">
                                    <label for="mumtahin-comments"
                                        class="block text-xl font-medium text-gray-700">মুমতাহিন মন্তব্য</label>
                                    <Editor v-model="form.teachers.mumtahinComments" editorStyle="height: 150px"
                                        class="w-full" />
                                </div>
                            </div>
                        </div>



                        <!-- Submit Button -->
                        <div class="md:w-1/3 flex items-end mt-5">
                            <button type="submit"
                                class="w-full px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-lg"
                                :disabled="form.processing">
                                {{ form.processing ? 'প্রক্রিয়াকরণ হচ্ছে...' : 'সেভ করুন' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, reactive, onMounted, computed } from 'vue';
// import { useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { createToaster } from "@meforma/vue-toaster";
import { useForm, usePage } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Calendar from 'primevue/calendar';
import Card from 'primevue/card';
import Menu from 'primevue/menu';
import Panel from 'primevue/panel';
import Editor from 'primevue/editor';



const toaster = createToaster({
    position: "top-right"
});

const page = usePage();

const props = defineProps({
    // roll: String,
    // reg_id: String,
    // CID: String,
    // modelValue: Object
});


components: {
    Editor
}



const bookMenuItems = computed(() => {
    return bookCategories.value.map((category, index) => {
        return {
            label: category.name,
            icon: 'pi pi-book',
            items: category.books.map(book => {
                return {
                    label: book,
                    command: () => addSelectedBook(book)
                };
            })
        };
    });
});

const applicationTypes = [
    'নেগরান',
    'মুমতাহিন',
    'নেগরান মুমতাহিন উভয়',
    'হিফজ মুমতাহিন',
    'কেরাত মুমতাহিন'
];

const genderOptions = [
    'পুরুষ',
    'মহিলা',

];


const classOptions = [
    'তাকমিল',
    'ফযীলত',
    'সানাবিয়া উলইয়া',
    'সানাবিয়া',
    'মাস্টার্স',
    'কামিল',
    'H.S.C'
]



const showBookDropdown = ref(false);
const bookCategories = ref([]);
const selectedBooks = ref([]);
// Profile image preview
const profileImage = ref(null);

// Create Inertia form
const form = useForm({
    profileImage: null,
    muhtamim_file: null,  // নতুন যোগ করা হয়েছে
    nid_file: null,       // নতুন যোগ করা হয়েছে
    birth_cert_file: null, // নতুন যোগ করা হয়েছে
    applicationType: 'নেগরান',
    teachers: {
        name: '',
        Mobile: '',
        DateofBirth: '',
        comments: '',
        whatsapp: '',
        post: '',
        village: '',
        division: '',
        district: '',
        thana: '',
        teaching_experience: '',
        negaranComments: '',
        mumtahinComments: '',
        nagad_number: '',
        rocket_number: '',
        bkash_number: '',
        National_Id_Card: '',
        nid: '',
        gender: 'পুরুষ'
    },
    educationalQualifications: [
        {
            className: '',
            passYear: '',
            result: '',
            institution: ''
        }
    ],
    selectedBooks: [] // এখানে selectedBooks প্রপার্টি যোগ করা হয়েছে
});


// selectedBooks পরিবর্তন হলে form.teachers.selected_book আপডেট করা
watch(selectedBooks, (newBooks) => {
    // অ্যারেকে কমা দিয়ে আলাদা করা স্ট্রিং-এ রূপান্তর করা
    form.teachers.selected_book = newBooks.join(', ');
}, { deep: true });




const educationalQualifications = reactive([
    {
        className: 'তাকমিল',
        passYear: '',
        result: '',
        institution: ''
    }
]);

const addQualification = () => {
    form.educationalQualifications.push({
        className: 'তাকমিল',
        passYear: '',
        result: '',
        institution: ''
    });
};

const removeQualification = (index) => {
    if (form.educationalQualifications.length > 1) {
        form.educationalQualifications.splice(index, 1);
    }
};



// Handle profile image change
const handleProfileImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Update form data with the file
        form.profileImage = file;

        // For preview
        const reader = new FileReader();
        reader.onload = (e) => {
            profileImage.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Format date for display
const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('bn-BD');
};

// Submit form using Inertia
const submitForm = () => {
    form.post('/teacher-store', {
        onSuccess: () => {
            toaster.success(page.props.flash?.success || 'আপনার আবেদন সফলভাবে জমা হয়েছে');
            form.reset();
            profileImage.value = null;
            selectedBooks.value = [];
        },
        onError: () => {
            toaster.error('আবেদন জমা দেওয়ার সময় একটি ত্রুটি হয়েছে');
        },
        preserveScroll: true,
        forceFormData: true,
    });
};








// ফাইল হ্যান্ডলিং এর জন্য reactive অবজেক্ট
const files = reactive({
    muhtamim: null,
    nid: null,
    birthCert: null
});

// ফাইল হ্যান্ডলিং ফাংশন
const handleFileChange = (event, type) => {
    const file = event.target.files[0];
    if (!file) return;

    files[type] = file;

    // ফর্মে ফাইল সেট করুন
    if (type === 'muhtamim') {
        form.muhtamim_file = file;
    } else if (type === 'nid') {
        form.nid_file = file;
    } else if (type === 'birthCert') {
        form.birth_cert_file = file;
    }
};

// ফাইল রিমুভ করার ফাংশন
const removeFile = (type) => {
    files[type] = null;

    // ফর্ম থেকে ফাইল রিমুভ করুন
    if (type === 'muhtamim') {
        form.muhtamim_file = null;
    } else if (type === 'nid') {
        form.nid_file = null;
    } else if (type === 'birthCert') {
        form.birth_cert_file = null;
    }
};

// ফাইল প্রিভিউ করার ফাংশন
const viewFile = (file) => {
    if (!file) return;

    const fileUrl = URL.createObjectURL(file);
    window.open(fileUrl, '_blank');
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









// থানা/জেলা

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


// Watch for changes in presentFilters and update form.teachers
watch(presentFilters, (newValues) => {
    form.teachers.division = newValues.division;
    form.teachers.district = newValues.district;
    form.teachers.thana = newValues.Thana;
}, { deep: true });


</script>
