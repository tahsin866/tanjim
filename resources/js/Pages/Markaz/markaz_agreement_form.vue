<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

const selectedCategory = ref('')



const form = useForm({
    category: '',
    // Main Madrasa Data
    user_id: usePage().props.auth.user.id,
    user_name: usePage().props.auth.user.madrasha_name, // Add this
    exam_id: '', // Add this
    exam_name: '', // Add this
    markaz_type: "",
    markaz_type: "",
    fazilat: '',
    sanabiya_ulya: '',
    sanabiya: '',
    mutawassita: '',
    ibtedaiyyah: '',
    hifzul_quran: '',
    noc_file: null,
    resolution_file: null,

    // Requirements
    requirements: '',

    // Main Attachments
    muhtamim_consent: null,
    president_consent: null,
    committee_resolution: null,

    // Associated Madrasas
    associated_madrasas: []
})






// Main rows data with files
const rows = ref([{
    fazilat: "",
    sanabiya_ulya: "",
    sanabiya: "",
    mutawassita: "",
    ibtedaiyyah: "",
    hifzul_quran: "",
    madrasa_Name: "",
    madrasa_id: "",
    searchQuery: "",
    isOpen: false,
    files: {
        noc: null,
        nocPreview: null,
        resolution: null,
        resolutionPreview: null
    }
}])



// Dynamic row handling
const addRow = () => {
  rows.value.push({
    fazilat: "",
    sanabiya_ulya: "",
    sanabiya: "",
    mutawassita: "",
    ibtedaiyyah: "",
    hifzul_quran: "",
    madrasa_Name: "",
    madrasa_id: "",
    searchQuery: "",
    isOpen: false,
    files: {
      noc: null,
      nocPreview: null,
      resolution: null,
      resolutionPreview: null
    }
  })
}

const removeRow = (index) => {
    if (rows.value.length > 1) {
        rows.value.splice(index, 1)
    }
}

// Dynamic file handling
const handleFileUpload = (event, type, index) => {
    const file = event.target.files[0]
    if (!file) return

    if (type === 'noc') {
        rows.value[index].files.noc = file
        rows.value[index].files.nocPreview = URL.createObjectURL(file)
    } else {
        rows.value[index].files.resolution = file
        rows.value[index].files.resolutionPreview = URL.createObjectURL(file)
    }
}

const removeFile = (type, index) => {
    if (type === 'noc') {
        rows.value[index].files.noc = null
        rows.value[index].files.nocPreview = null
    } else {
        rows.value[index].files.resolution = null
        rows.value[index].files.resolutionPreview = null
    }
}



const removeFileForMadrahsa = (type) => {
    if (type === 'noc') {
        nocFileForMadrahsa.value = null
        nocPreviewForMadrahsa.value = null
    } else {
        resolutionFileForMadrahsa.value = null
        resolutionPreviewForMadrahsa.value = null
    }
}






const nocFileForMadrahsa = ref(null)
const nocPreviewForMadrahsa = ref(null)
const resolutionFileForMadrahsa = ref(null)
const resolutionPreviewForMadrahsa = ref(null)
const muhtamimFile = ref(null)
const muhtamimPreview = ref(null)
const presidentFile = ref(null)
const presidentPreview = ref(null)
const committeeFile = ref(null)
const committeePreview = ref(null)

const handleFileUploadMumtahin = (event, type) => {
    const file = event.target.files[0]
    if (!file) return

    switch (type) {
        case 'muhtamim':
            muhtamimFile.value = file
            muhtamimPreview.value = URL.createObjectURL(file)
            break
        case 'president':
            presidentFile.value = file
            presidentPreview.value = URL.createObjectURL(file)
            break
        case 'committee':
            committeeFile.value = file
            committeePreview.value = URL.createObjectURL(file)
            break
    }
}

const removeFileMumtahin = (type) => {
    switch (type) {
        case 'muhtamim':
            muhtamimFile.value = null
            muhtamimPreview.value = null
            break
        case 'president':
            presidentFile.value = null
            presidentPreview.value = null
            break
        case 'committee':
            committeeFile.value = null
            committeePreview.value = null
            break
    }
}









// Close dropdown when clicking outside
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    rows.value.forEach(row => row.isOpen = false)
  }
}






const submitForm = () => {
    form.category = selectedCategory.value

    // Map rows data to associated_madrasas
    form.associated_madrasas = rows.value.map(row => ({
        madrasa_Name: row.madrasa_Name,
        madrasa_id: row.madrasa_id, // Use the stored madrasa name
        fazilat: row.fazilat,
        sanabiya_ulya: row.sanabiya_ulya,
        sanabiya: row.sanabiya,
        mutawassita: row.mutawassita,
        ibtedaiyyah: row.ibtedaiyyah,
        hifzul_quran: row.hifzul_quran,
        noc_file: row.files.noc,
        resolution_file: row.files.resolution
    }))

    // Add main attachments
    form.muhtamim_consent = muhtamimFile.value
    form.president_consent = presidentFile.value
    form.committee_resolution = committeeFile.value

    form.post(route('markaz-agreements.store'))
}









const handleFileUploadForMadrahsa = (event, type) => {
    const file = event.target.files[0]
    if (!file) return

    if (type === 'noc') {
        form.noc_file = file
        nocFileForMadrahsa.value = file
        nocPreviewForMadrahsa.value = URL.createObjectURL(file)
    } else {
        form.resolution_file = file
        resolutionFileForMadrahsa.value = file
        resolutionPreviewForMadrahsa.value = URL.createObjectURL(file)
    }
}


onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})


const madrashas = ref([])

onMounted(async () => {
    const { data } = await axios.get(route('madrashas.list'))
    madrashas.value = data
    const response = await axios.get(route('exam-setups.latest'))
    form.exam_id = response.data.id
    form.exam_name = response.data.exam_name
})

const filteredOptions = computed(() => (row) => {
    if (!row.searchQuery) return [];

    return madrashas.value.filter(madrasha => {
        const name = (madrasha.name || '').toLowerCase();
        const elhaqNo = (madrasha.ElhaqNo || '').toString().toLowerCase();
        const searchQuery = row.searchQuery.toLowerCase().trim();

        // Handle all types of Elhaq number formats
        const normalizedElhaqNo = elhaqNo.replace(/[`']/g, '').replace(/\s+/g, '');
        const normalizedSearchQuery = searchQuery.replace(/[`']/g, '').replace(/\s+/g, '');

        // Check if search query matches any part of the Elhaq number
        if (normalizedElhaqNo.includes(normalizedSearchQuery)) return true;

        // Check name match
        const searchWords = searchQuery.split(' ');
        return searchWords.every(word => name.includes(word));
    });
});

const selectOption = (madrasha, row) => {
    row.madrasa_Name = madrasha.name;  // Store the madrasa name
    row.madrasa_id = madrasha.id;  // এই লাইনটি যোগ করুন - মাদরাসার আইডি সেট করুন
    row.searchQuery = `${madrasha.name} (ইলহাক: ${madrasha.ElhaqNo})`; // Display formatted name with Elhaq
    row.isOpen = false;
};


// Add click outside to close dropdown
const closeDropdown = (row) => {
    row.isOpen = false;
};

onMounted(() => {
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-container')) {
            rows.value.forEach(row => row.isOpen = false);
        }
    });
});

</script>

<template>
    <AuthenticatedLayout>
        <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-md shadow-lg mx-5 mt-5 mb-3">
            <!-- Category Selection -->
            <div class="flex-1 min-w-[150px] mb-6">
                <label class="block text-xl font-semibold text-emerald-800 mb-2">

                    মারকাযের স্তর নির্বাচন করুন
                </label>
                <select v-model="form.markaz_type"
                    class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm">
                    <option value="">নির্বাচন করুন</option>
                    <option value="দরসিয়াত">দরসিয়াত</option>
                    <option value="তাহফিজুল কোরআন">তাহফিজুল কোরআন</option>
                    <option value="কিরাআত">কিরাআত</option>
                </select>
            </div>

            <!-- Madrasa Info Section -->
            <div class="p-6 bg-white rounded-md shadow-md border border-emerald-200">
                <h2 class="text-2xl font-bold text-emerald-700 mb-6">

                    আবেদনকৃত মাদরাসার তথ্য
                </h2>

                <div class="flex flex-wrap gap-6">
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-lg font-medium text-emerald-700 mb-2">

                            ফযীলত
                        </label>
                        <input type="number"
                          v-model="form.fazilat"
                            class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                            placeholder="ছাত্র সংখ্যা লিখুন" />
                    </div>

                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-lg font-medium text-emerald-700 mb-2">

                            সানাবিয়া ‍উলইয়া
                        </label>
                        <input type="number"
                         v-model="form.sanabiya_ulya"
                            class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                            placeholder="ছাত্র সংখ্যা লিখুন" />
                    </div>

                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-lg font-medium text-emerald-700 mb-2">

                            সানাবিয়া
                        </label>
                        <input type="number"
                         v-model="form.sanabiya"
                            class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                            placeholder="ছাত্র সংখ্যা লিখুন" />
                    </div>

                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-lg font-medium text-emerald-700 mb-2">

                            মুতাওয়াসসিতা
                        </label>
                        <input type="number"
                          v-model="form.mutawassita"
                            class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                            placeholder="ছাত্র সংখ্যা লিখুন" />
                    </div>

                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-lg font-medium text-emerald-700 mb-2">

                            ইবতেদাইয়্যাহ
                        </label>
                        <input type="number"
                                v-model="form.ibtedaiyyah"
                            class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                            placeholder="ছাত্র সংখ্যা লিখুন" />
                    </div>

                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-lg font-medium text-emerald-700 mb-2">

                            হিফজুল কোরান
                        </label>
                        <input type="number"
                        v-model="form.hifzul_quran"
                            class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                            placeholder="ছাত্র সংখ্যা লিখুন" />
                    </div>
                </div>

                <!-- এটাচমেন্ট -->
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-emerald-700 mb-6">প্রয়োজনীয় ডকুমেন্টস</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NOC Upload -->
                        <div class="p-3 border-2 border-dashed border-emerald-300 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-lg font-medium text-emerald-700">পূর্বের মাদরাসার অনাপত্তিপত্র</label>
                                <div v-if="nocFileForMadrahsa" class="flex items-center space-x-4">
                                    <a :href="nocPreviewForMadrahsa" target="_blank"
                                        class="text-emerald-600 hover:text-emerald-800 flex items-center">
                                        <span class="material-symbols-outlined mr-1">দেখুন</span>
                                        <span>প্রিভিউ</span>
                                    </a>
                                    <button @click="removeFileForMadrahsa('noc')"
                                        class="text-red-600 hover:text-red-800 flex items-center">
                                        <span class="material-symbols-outlined mr-1"></span>
                                        <span>মুছুন</span>
                                    </button>
                                </div>
                            </div>
                            <input
    type="file"
    @change="handleFileUploadForMadrahsa($event, 'noc')"
    class="w-full text-emerald-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
/>

                        </div>

                        <!-- Resolution Upload -->
                        <div class="p-4 border-2 border-dashed border-emerald-300 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-lg font-medium text-emerald-700">সম্মতিপত্র</label>
                                <div v-if="resolutionPreviewForMadrahsa" class="flex items-center space-x-4">
                                    <a :href="resolutionPreviewForMadrahsa" target="_blank"
                                        class="text-emerald-600 hover:text-emerald-800 flex items-center">
                                        <span class="material-symbols-outlined mr-1">দেখুন</span>
                                        <span>প্রিভিউ</span>
                                    </a>
                                    <button @click="removeFileForMadrahsa('resolution')"
                                        class="text-red-600 hover:text-red-800 flex items-center">
                                        <span class="material-symbols-outlined mr-1"></span>
                                        <span>মুছুন</span>
                                    </button>
                                </div>
                            </div>
                            <input
    type="file"
    @change="handleFileUploadForMadrahsa($event, 'resolution')"
    class="w-full text-emerald-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
/>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Dynamic Rows Section -->
            <div class="mb-8 mt-6">
                <h3 class="text-xl text-emerald-800 font-bold mb-4 arabic-font">আবেদনকৃত মাদরাসায় পরীক্ষা দিতে ইচ্ছুক
                    মাদরাসার তালিকা ও তথ্য</h3>

                <div class="flex flex-col gap-6">
                    <div v-for="(row, index) in rows" :key="index"
                        class="bg-white p-6 rounded-md shadow-md border border-emerald-200 hover:border-emerald-300 transition-all duration-300">

                        <div class="flex flex-wrap gap-6 items-end">
                            <div class="flex-1 min-w-[150px]">
                                <label class="block text-lg font-medium text-emerald-700 mb-2 arabic-font">ফযীলত</label>
                                <input type="number" v-model="row.fazilat"
                                    class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                                    placeholder="ছাত্র সংখ্যা লিখুন" />
                            </div>

                            <div class="flex-1 min-w-[150px]">
                                <label class="block text-lg font-medium text-emerald-700 mb-2 arabic-font">সানাবিয়া
                                    ‍উলইয়া</label>
                                <input type="number" v-model="row.sanabiya_ulya"
                                    class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                                    placeholder="ছাত্র সংখ্যা লিখুন" />
                            </div>

                            <div class="flex-1 min-w-[150px]">
                                <label
                                    class="block text-lg font-medium text-emerald-700 mb-2 arabic-font">সানাবিয়া</label>
                                <input type="number" v-model="row.sanabiya"
                                    class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                                    placeholder="ছাত্র সংখ্যা লিখুন" />
                            </div>

                            <div class="flex-1 min-w-[150px]">
                                <label
                                    class="block text-lg font-medium text-emerald-700 mb-2 arabic-font">মুতাওয়াসসিতা</label>
                                <input type="number" v-model="row.mutawassita"
                                    class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                                    placeholder="ছাত্র সংখ্যা লিখুন" />
                            </div>

                            <div class="flex-1 min-w-[150px]">
                                <label
                                    class="block text-lg font-medium text-emerald-700 mb-2 arabic-font">ইবতেদাইয়্যাহ</label>
                                <input type="number" v-model="row.ibtedaiyyah"
                                    class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                                    placeholder="ছাত্র সংখ্যা লিখুন" />
                            </div>

                            <div class="flex-1 min-w-[150px]">
                                <label class="block text-lg font-medium text-emerald-700 mb-2 arabic-font">হিফজুল
                                    কোরান</label>
                                <input type="number" v-model="row.hifzul_quran"
                                    class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                                    placeholder="ছাত্র সংখ্যা লিখুন" />
                            </div>
                            <div class="search-container relative">
    <input
        type="text"
        v-model="row.searchQuery"
        @focus="row.isOpen = true"
        placeholder="মাদরাসার নাম বা ইলহাক নম্বর দিয়ে খুঁজুন"
        class="w-full px-4 py-2 border border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500"
    />

    <div
        v-if="row.isOpen && filteredOptions(row).length > 0"
        class="absolute z-50 w-full mt-1 bg-white border border-emerald-300 rounded-md shadow-lg max-h-60 overflow-auto"
    >
        <div
            v-for="madrasha in filteredOptions(row)"
            :key="madrasha.id"
            @click="selectOption(madrasha, row)"
            class="px-4 py-2 cursor-pointer hover:bg-emerald-50"
        >
            <div class="font-medium">{{ madrasha.name }}</div>
            <div class="text-sm text-gray-600">ইলহাক: {{ madrasha.ElhaqNo }}</div>
        </div>
    </div>
</div>
                            <button v-if="rows.length > 1" @click="removeRow(index)"
                                class="px-4 py-2 bg-red-600 text-white rounded-sm hover:bg-red-700 transition-colors duration-200 shadow-md">
                                সারি মুছুন
                            </button>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-emerald-700 mb-6">প্রয়োজনীয় ডকুমেন্টস</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- NOC Upload -->
                                <div class="p-3 border-2 border-dashed border-emerald-300 rounded-lg">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="text-lg font-medium text-emerald-700">পূর্বের মাদরাসার অনাপত্তিপত্র</label>
                                        <div v-if="row.files.nocPreview" class="flex items-center space-x-4">
                                            <a :href="row.files.nocPreview" target="_blank"
                                                class="text-emerald-600 hover:text-emerald-800 flex items-center">
                                                <span>প্রিভিউ</span>
                                            </a>
                                            <button @click="removeFile('noc', index)"
                                                class="text-red-600 hover:text-red-800 flex items-center">
                                                <span>মুছুন</span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="file" @change="handleFileUpload($event, 'noc', index)"
                                        class="w-full text-emerald-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />

                                </div>

                                <!-- Resolution Upload -->
                                <div class="p-4 border-2 border-dashed border-emerald-300 rounded-lg">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="text-lg font-medium text-emerald-700">বর্তমান মাদরাসার সম্মতিপত্র</label>
                                        <div v-if="row.files.resolutionPreview" class="flex items-center space-x-4">
                                            <a :href="row.files.resolutionPreview" target="_blank"
                                                class="text-emerald-600 hover:text-emerald-800 flex items-center">
                                                <span>প্রিভিউ</span>
                                            </a>
                                            <button @click="removeFile('resolution', index)"
                                                class="text-red-600 hover:text-red-800 flex items-center">
                                                <span>মুছুন</span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="file" @change="handleFileUpload($event, 'resolution', index)"
                                        class="w-full text-emerald-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                                </div>
                            </div>
                        </div>


                    </div>

                    <button @click="addRow"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-sm hover:bg-emerald-700 transition-colors duration-200 shadow-md w-fit">
                        নতুন সারি যোগ করুন +
                    </button>
                </div>
            </div>





            <!-- Requirements Section -->
            <div class="mb-8 bg-white p-6 rounded-md shadow-md border border-emerald-200">
                <label class="block text-xl text-emerald-800 font-bold mb-4 arabic-font">মারকায প্রাপ্তির
                    প্রয়োজনীয়তা</label>
                <textarea v-model="form.requirements"
                    class="w-full px-4 py-2 border text-2xl border-emerald-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm"
                    rows="4">
    </textarea>
            </div>

            <!-- File Upload Section -->
            <div class="bg-white rounded-md shadow-md border border-emerald-200 p-6">
                <h3 class="text-xl text-emerald-800 font-bold mb-6 arabic-font">সংযুক্তি</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Muhtamim's Consent -->
                    <div class="space-y-3">
                        <label class="block text-lg font-medium text-emerald-700 arabic-font">মুহতামিমের
                            সম্মতিপত্র</label>
                        <div class="relative">
                            <div
                                class="flex items-center justify-between border-2 border-dashed border-emerald-300 rounded-md p-4 hover:border-emerald-500 transition-colors duration-200 bg-emerald-50">
                                <span class="text-emerald-600 arabic-font">
                                    {{ muhtamimFile ? muhtamimFile.name : 'ফাইল আপলোড করুন' }}
                                </span>
                                <div v-if="muhtamimPreview"
                                    class="flex items-center space-x-2 relative z-10 pointer-events-auto">
                                    <a :href="muhtamimPreview" target="_blank"
                                        class="text-emerald-600 hover:text-emerald-800">প্রিভিউ</a>
                                    <button @click.stop="removeFileMumtahin('muhtamim')"
                                        class="text-red-600 hover:text-red-800">মুছুন</button>
                                </div>
                            </div>
                            <input type="file" @change="handleFileUploadMumtahin($event, 'muhtamim')"
                                class="absolute inset-0 opacity-0 w-full h-full cursor-pointer z-0"
                                accept="image/*,.pdf,.doc,.docx">
                        </div>
                    </div>

                    <!-- District President's Consent -->
                    <div class="space-y-3">
                        <label class="block text-lg font-medium text-emerald-700 arabic-font">জেলা সভাপতির
                            সম্মাতি</label>
                        <div class="relative">
                            <div
                                class="flex items-center justify-between border-2 border-dashed border-emerald-300 rounded-md p-4 hover:border-emerald-500 transition-colors duration-200 bg-emerald-50">
                                <span class="text-emerald-600 arabic-font">
                                    {{ presidentFile ? presidentFile.name : 'ফাইল আপলোড করুন' }}
                                </span>
                                <div v-if="presidentPreview"
                                    class="flex items-center space-x-2 relative z-10 pointer-events-auto">
                                    <a :href="presidentPreview" target="_blank"
                                        class="text-emerald-600 hover:text-emerald-800">প্রিভিউ</a>
                                    <button @click.stop="removeFileMumtahin('president')"
                                        class="text-red-600 hover:text-red-800">মুছুন</button>
                                </div>
                            </div>
                            <input type="file" @change="handleFileUploadMumtahin($event, 'president')"
                                class="absolute inset-0 opacity-0 w-full h-full cursor-pointer z-0"
                                accept="image/*,.pdf,.doc,.docx">
                        </div>
                    </div>

                    <!-- Committee Resolution -->
                    <div class="space-y-3">
                        <label class="block text-lg font-medium text-emerald-700 arabic-font">কমিটি রেজুলেশন</label>
                        <div class="relative">
                            <div
                                class="flex items-center justify-between border-2 border-dashed border-emerald-300 rounded-md p-4 hover:border-emerald-500 transition-colors duration-200 bg-emerald-50">
                                <span class="text-emerald-600 arabic-font">
                                    {{ committeeFile ? committeeFile.name : 'ফাইল আপলোড করুন' }}
                                </span>
                                <div v-if="committeePreview"
                                    class="flex items-center space-x-2 relative z-10 pointer-events-auto">
                                    <a :href="committeePreview" target="_blank"
                                        class="text-emerald-600 hover:text-emerald-800">প্রিভিউ</a>
                                    <button @click.stop="removeFileMumtahin('committee')"
                                        class="text-red-600 hover:text-red-800">মুছুন</button>
                                </div>
                            </div>
                            <input type="file" @change="handleFileUploadMumtahin($event, 'committee')"
                                class="absolute inset-0 opacity-0 w-full h-full cursor-pointer z-0"
                                accept="image/*,.pdf,.doc,.docx">
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <div class="mt-8 mx-5">
            <button @click="submitForm"
                class="px-6 py-2 mb-5 bg-green-500 text-white rounded-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                সেভ করুন
            </button>
        </div>
    </AuthenticatedLayout>

</template>
<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>
