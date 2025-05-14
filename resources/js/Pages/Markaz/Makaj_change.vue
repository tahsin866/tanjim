<script setup>
import { ref, onMounted, computed, watch } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import axios from 'axios';
import { createToaster } from "@meforma/vue-toaster";
import { useForm } from '@inertiajs/vue3';
// Sidebar state
const centers = ref({});
const error = ref(null);
const selectedType = ref('');
const searchDarsiyat = ref('');
const searchHifz = ref('');
const searchKirat = ref('');
const searchResults = ref({
  darsiyat: [],
  hifz: [],
  kirat: []
});
const files = ref({
  darsiyat: { noc: null, consent: null },
  hifz: { noc: null, consent: null },
  kirat: { noc: null, consent: null }
});

// Modal state
const showModal = ref(false);
const modalType = ref('');
const currentCenter = ref('');
const modalSearch = ref('');
const modalSearchResults = ref([]);
const modalFiles = ref({ noc: null, consent: null });
const selectedModalCenter = ref('');

// Computed property for modal title
const modalTitle = computed(() => {
  const typeMap = {
    'darsiyat': 'দারসিয়াত',
    'hifz': 'হিফজ',
    'kirat': 'কিরাত'
  };
  return `${typeMap[modalType.value]} মারকাজ পরিবর্তন`;
});

const fetchCenters = async () => {
  try {
    // API প্রিফিক্স সহ সঠিক URL
    const response = await fetch('/api/markaz-Center');

    if (!response.ok) {
      throw new Error('Failed to fetch centers');
    }
    const data = await response.json();
    centers.value = data.centers || {};
    error.value = data.error || null;
  } catch (err) {
    console.error('Error fetching centers:', err);
    error.value = err.message;
  }
};






// Open modal function
function openModal(type, center) {
  modalType.value = type;
  currentCenter.value = center;
  showModal.value = true;
  modalSearch.value = '';
  modalSearchResults.value = [];
  modalFiles.value = { noc: null, consent: null };
  selectedModalCenter.value = '';
}

// Close modal function
function closeModal() {
  showModal.value = false;
}

// Handle file changes in the main form
function handleFileChange(event, type, fileType) {
  const file = event.target.files[0];
  if (file) {
    files.value[type][fileType] = file;
  }
}

// Handle file changes in the modal
function handleModalFileChange(event, fileType) {
  const file = event.target.files[0];
  if (file) {
    modalFiles.value[fileType] = file;
  }
}

// Select center from search results
// Select center from search results
// Select center from search results
function selectCenter(type, center) {
  console.log("Selected center:", center); // ডিবাগিং এর জন্য

  if (type === 'darsiyat') {
    searchDarsiyat.value = center.name; // center.name সঠিকভাবে সেট হচ্ছে কিনা চেক করুন
    searchResults.value.darsiyat = [];
  } else if (type === 'hifz') {
    searchHifz.value = center.name;
    searchResults.value.hifz = [];
  } else if (type === 'kirat') {
    searchKirat.value = center.name;
    searchResults.value.kirat = [];
  }
}





const madrashas = ref([]);

const form = ref({
  exam_id: null,
  exam_name: ''
});

// Then the onMounted function will work correctly
onMounted(async () => {
  try {
    const response = await axios.get('/api/markaz-madrashas/list');
    madrashas.value = response.data;
    const examResponse = await axios.get(route('exam-setups.latest'));
    form.value.exam_id = examResponse.data.id;
    form.value.exam_name = examResponse.data.exam_name;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
});




// Search function for main form
const searchMadrashas = async (query, type) => {
  if (!query || query.length < 2) {
    searchResults.value[type] = [];
    return;
  }

  const filteredMadrashas = madrashas.value.filter(madrasha => {
    const name = (madrasha.name || '').toLowerCase();
    const elhaqNo = (madrasha.ElhaqNo || '').toString().toLowerCase();
    const searchQuery = query.toLowerCase().trim();

    // Handle all types of Elhaq number formats
    const normalizedElhaqNo = elhaqNo.replace(/[`']/g, '').replace(/\s+/g, '');
    const normalizedSearchQuery = searchQuery.replace(/[`']/g, '').replace(/\s+/g, '');

    // Check if search query matches any part of the Elhaq number
    if (normalizedElhaqNo.includes(normalizedSearchQuery)) return true;

    // Check name match
    const searchWords = searchQuery.split(' ');
    return searchWords.every(word => name.includes(word));
  });

  searchResults.value[type] = filteredMadrashas;
};



// Search function for modal
// Search function for modal
const searchModalMadrashas = async (query) => {
  if (!query || query.length < 2) {
    modalSearchResults.value = [];
    return;
  }

  const filteredMadrashas = madrashas.value.filter(madrasha => {
    const name = (madrasha.name || '').toLowerCase();
    const elhaqNo = (madrasha.ElhaqNo || '').toString().toLowerCase();
    const searchQuery = query.toLowerCase().trim();

    // Handle all types of Elhaq number formats
    const normalizedElhaqNo = elhaqNo.replace(/[`']/g, '').replace(/\s+/g, '');
    const normalizedSearchQuery = searchQuery.replace(/[`']/g, '').replace(/\s+/g, '');

    // Check if search query matches any part of the Elhaq number
    if (normalizedElhaqNo.includes(normalizedSearchQuery)) return true;

    // Check name match
    const searchWords = searchQuery.split(' ');
    return searchWords.every(word => name.includes(word));
  });

  modalSearchResults.value = filteredMadrashas;
};

// Select center in modal
function selectModalCenter(center) {
  selectedModalCenter.value = center.name;
  modalSearch.value = center.name;
  modalSearchResults.value = [];
}

// Save modal changes
// Save modal changes
async function saveModalChanges() {
  if (selectedModalCenter.value) {
    // ফাইল চেক করি
    if (!modalFiles.value.noc || !modalFiles.value.consent) {
      alert('দয়া করে সকল প্রয়োজনীয় ফাইল আপলোড করুন');
      return;
    }
    try {
      const formData = new FormData();
      formData.append('markaz_type', modalType.value);
      formData.append('asking_madrasha', selectedModalCenter.value);
      formData.append('onapotti_potro', modalFiles.value.noc);
      formData.append('shommoti_potro', modalFiles.value.consent);

      // URL পরিবর্তন - route() হেল্পার ব্যবহার করুন অথবা সরাসরি URL দিন
      const response = await axios.post('/markaz-exchange', formData, {
  headers: {
    'Content-Type': 'multipart/form-data'
  }
});


      alert(response.data.message);
      closeModal();
      fetchCenters(); // রিফ্রেশ করি বর্তমান মারকাজ তথ্য
    } catch (error) {
      console.error(error);
      alert('আবেদন জমা দেওয়ার সময় একটি সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।');
    }
  } else {
    // Show error or validation message
    alert('দয়া করে একটি মারকাজ নির্বাচন করুন');
  }
}


// Watch for search inputs
watch(searchDarsiyat, (val) => {
  searchMadrashas(val, 'darsiyat');
});

watch(searchHifz, (val) => {
  searchMadrashas(val, 'hifz');
});

watch(searchKirat, (val) => {
  searchMadrashas(val, 'kirat');
});

watch(modalSearch, (val) => {
  searchModalMadrashas(val);
});

onMounted(() => {
  fetchCenters();
});




// ফাইল দেখার ফাংশন
function viewFile(file) {
  if (file) {
    const fileURL = URL.createObjectURL(file);
    window.open(fileURL, '_blank');
  }
}

// ফাইল রিমুভ করার ফাংশন
function removeFile(type, fileType) {
  files.value[type][fileType] = null;
}


// মোডাল ফাইল রিমুভ করার ফাংশন
function removeModalFile(fileType) {
  modalFiles.value[fileType] = null;
}


const toaster = createToaster();


const markazForm = useForm({
  markaz_type: '',
  asking_madrasha: '',

  onapotti_potro: null,
  shommoti_potro: null
});



const submitMarkazChange = () => {
  // Check if user has no existing markaz
  if (!Object.keys(centers.value).length) {
    // Check if type is selected
    if (!selectedType.value) {
      toaster.error('দয়া করে একটি মারকাজ টাইপ নির্বাচন করুন');
      return;
    }

    // Get selected madrasa name
    let askingMadrasha = '';
    if (selectedType.value === 'darsiyat') askingMadrasha = searchDarsiyat.value;
    if (selectedType.value === 'hifz') askingMadrasha = searchHifz.value;
    if (selectedType.value === 'kirat') askingMadrasha = searchKirat.value;

    // Check madrasa name
    if (!askingMadrasha) {
      toaster.error('দয়া করে একটি কাঙ্খিত মারকাজ নির্বাচন করুন');
      return;
    }

    // Check files
    if (!files.value[selectedType.value].noc || !files.value[selectedType.value].consent) {
      toaster.error('দয়া করে সকল প্রয়োজনীয় ফাইল আপলোড করুন');
      return;
    }

    // Set form values
    markazForm.markaz_type = selectedType.value;
    markazForm.asking_madrasha = askingMadrasha;
    markazForm.onapotti_potro = files.value[selectedType.value].noc;
    markazForm.shommoti_potro = files.value[selectedType.value].consent;

    // Submit form
    markazForm.post('/markaz-exchange', {
      onSuccess: (response) => {
        // Check if we have a response with data
        if (response && response.data && response.data.message) {
          toaster.success(response.data.message);
        } else {
          toaster.success('আপনার মারকাজ পরিবর্তনের আবেদন সফলভাবে জমা হয়েছে');
        }
        resetForm();
      },
      onError: (errors) => {
        console.error(errors);
        toaster.error('আবেদন জমা দেওয়ার সময় একটি সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।');
      },
      forceFormData: true
    });
  } else {
    // If user already has markaz, check which type they're trying to submit for
    let markazType = '';
    let askingMadrasha = '';

    if (searchDarsiyat.value && !centers.value.darsiyat) {
      markazType = 'darsiyat';
      askingMadrasha = searchDarsiyat.value;
    } else if (searchHifz.value && !centers.value.hifz) {
      markazType = 'hifz';
      askingMadrasha = searchHifz.value;
    } else if (searchKirat.value && !centers.value.kirat) {
      markazType = 'kirat';
      askingMadrasha = searchKirat.value;
    }

    // If they're trying to add a new type of markaz
    if (markazType && askingMadrasha) {
      // Check files
      if (!files.value[markazType].noc || !files.value[markazType].consent) {
        toaster.error('দয়া করে সকল প্রয়োজনীয় ফাইল আপলোড করুন');
        return;
      }

      // Set form values
      markazForm.markaz_type = markazType;
      markazForm.asking_madrasha = askingMadrasha;
      markazForm.onapotti_potro = files.value[markazType].noc;
      markazForm.shommoti_potro = files.value[markazType].consent;

      // Submit form
      markazForm.post('/markaz-exchange', {

        onSuccess: (response) => {
          // Check if we have a response with data
          if (response && response.data && response.data.message) {
            toaster.success(response.data.message);
          } else {
            toaster.success('আপনার মারকাজ পরিবর্তনের আবেদন সফলভাবে জমা হয়েছে');
          }
          resetForm();
        },
        onError: (errors) => {
          console.error(errors);
          toaster.error('আবেদন জমা দেওয়ার সময় একটি সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।');
        },
        forceFormData: true
      });
    } else {
      // If they're trying to change an existing markaz
      toaster.info('বর্তমান মারকাজ পরিবর্তন করতে, উপরে "পরিবর্তন করুন" বাটনে ক্লিক করুন।');
    }
  }
};





// Add this function to reset the form after submission
const resetForm = () => {
  searchDarsiyat.value = '';
  searchHifz.value = '';
  searchKirat.value = '';
  selectedType.value = '';

  // Reset files
  files.value = {
    darsiyat: { noc: null, consent: null },
    hifz: { noc: null, consent: null },
    kirat: { noc: null, consent: null }
  };

  // Refresh centers data
  fetchCenters();
};










</script>



<template>
    <AuthenticatedLayout>

    <!-- Content Section -->
    <div class="p-6 mt-10">
      <table class="w-full border-collapse">
        <tbody>
          <!-- Centers Information -->
          <tr>
            <td class="border p-4 w-1/3">
              <label class="text-emerald-800 font-semibold">বর্তমান মারকাজসমূহ</label>
            </td>
            <td class="border p-4 w-2/3">
              <div class="space-y-3">
                <div v-if="centers.darsiyat" class="flex justify-between items-center bg-emerald-50 p-3 rounded-md">
                  <span class="text-gray-800"><span class="font-semibold">দরসিয়াত:</span><br> {{ centers.darsiyat }}</span>
                  <button @click="openModal('darsiyat')" class="px-3 py-1 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">
                    পরিবর্তন করুন
                  </button>
                </div>
                <div v-if="centers.hifz" class="flex justify-between items-center bg-emerald-50 p-3 rounded-md">
                  <span class="text-gray-800"><span class="font-semibold">হিফজ:</span><br> {{ centers.hifz }}</span>
                  <button @click="openModal('hifz')" class="px-3 py-1 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">
                    পরিবর্তন করুন
                  </button>
                </div>
                <div v-if="centers.kirat" class="flex justify-between items-center bg-emerald-50 p-3 rounded-md">
                  <span class="text-gray-800"><span class="font-semibold">কিরাত:</span><br> {{ centers.kirat }}</span>
                  <button @click="openModal('kirat')" class="px-3 py-1 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">
                    পরিবর্তন করুন
                  </button>
                </div>
                <div v-if="!Object.keys(centers).length" class="text-gray-500 italic">
                  <div class="mb-4">কোন মারকাজ পাওয়া যায়নি</div>

                  <!-- Radio buttons for users without any markaz -->
                  <div class="space-y-2">
                    <div class="flex items-center">
                      <input id="darsiyat-radio" type="radio" v-model="selectedType" value="darsiyat" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                      <label for="darsiyat-radio" class="ml-2 text-gray-700">দারসিয়াত মারকাজ</label>
                    </div>
                    <div class="flex items-center">
                      <input id="hifz-radio" type="radio" v-model="selectedType" value="hifz" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                      <label for="hifz-radio" class="ml-2 text-gray-700">হিফজ মারকাজ</label>
                    </div>
                    <div class="flex items-center">
                      <input id="kirat-radio" type="radio" v-model="selectedType" value="kirat" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                      <label for="kirat-radio" class="ml-2 text-gray-700">কিরাত মারকাজ</label>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <!-- Desired Centers by Type -->
          <tr v-if="!centers.darsiyat || selectedType === 'darsiyat'">
            <td class="border p-4">
              <label class="text-emerald-800 font-semibold">কাঙ্খিত দারসিয়াত মারকাজ</label>
            </td>
            <td class="border p-4">
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <i class="fas fa-search text-gray-400"></i>
                </div>
                <input
                  type="text"
                  placeholder="দারসিয়াত মাদরাসা সার্চ করুন..."
                  class="w-full pl-10 px-4 py-2 border border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  v-model="searchDarsiyat"

                >
                <!-- Dropdown results would go here -->
                <div v-if="searchDarsiyat && searchResults.darsiyat.length" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg">
  <ul class="max-h-60 overflow-y-auto">
    <li v-for="(result, index) in searchResults.darsiyat" :key="index"
        class="px-4 py-2 hover:bg-emerald-50 cursor-pointer"
        @click="selectCenter('darsiyat', result)">
      {{ result.name }} ({{ result.ElhaqNo }})
    </li>
  </ul>
</div>
              </div>

              <!-- Attachments for Darsiyat -->
              <div class="mt-4 space-y-3" v-if="!centers.darsiyat || selectedType === 'darsiyat'">
  <div class="relative">
    <label class="block text-sm font-medium text-gray-700 mb-1">
      <i class="fas fa-file-alt mr-1"></i>বর্তমান মারকাজ অনাপত্তিপত্র
    </label>
    <input
      type="file"
      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
      @change="handleFileChange($event, 'darsiyat', 'noc')"
      v-if="!files.darsiyat.noc"
    />
    <div v-if="!files.darsiyat.noc" class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
      <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
      <span class="text-gray-600">ফাইল আপলোড করুন</span>
    </div>
    <!-- ফাইল আপলোড হলে দেখাবে -->
    <div v-else class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
      <div class="flex items-center">
        <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
        <span class="text-gray-700 truncate">{{ files.darsiyat.noc.name }}</span>
      </div>
      <div class="flex space-x-2">
        <button type="button" @click="viewFile(files.darsiyat.noc)" class="text-blue-500 hover:text-blue-700">
          <i class="fas fa-eye"></i>
        </button>
        <button type="button" @click="removeFile('darsiyat', 'noc')" class="text-red-500 hover:text-red-700">
          <i class="fas fa-trash-alt"></i>
        </button>
      </div>
    </div>
  </div>

  <div class="relative">
    <label class="block text-sm font-medium text-gray-700 mb-1">
      <i class="fas fa-file-signature mr-1"></i>কাঙ্খিত মারকাজ সম্মতিপত্র
    </label>
    <input
      type="file"
      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
      @change="handleFileChange($event, 'darsiyat', 'consent')"
      v-if="!files.darsiyat.consent"
    />
    <div v-if="!files.darsiyat.consent" class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
      <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
      <span class="text-gray-600">ফাইল আপলোড করুন</span>
    </div>
    <!-- ফাইল আপলোড হলে দেখাবে -->
    <div v-else class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
      <div class="flex items-center">
        <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
        <span class="text-gray-700 truncate">{{ files.darsiyat.consent.name }}</span>
      </div>
      <div class="flex space-x-2">
        <button type="button" @click="viewFile(files.darsiyat.consent)" class="text-blue-500 hover:text-blue-700">
          <i class="fas fa-eye"></i>
        </button>
        <button type="button" @click="removeFile('darsiyat', 'consent')" class="text-red-500 hover:text-red-700">
          <i class="fas fa-trash-alt"></i>
        </button>
      </div>
    </div>
  </div>
</div>

            </td>
          </tr>

          <tr v-if="!centers.hifz || selectedType === 'hifz'">
            <td class="border p-4">
              <label class="text-emerald-800 font-semibold">কাঙ্খিত হিফজ মারকাজ</label>
            </td>
            <td class="border p-4">
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <i class="fas fa-search text-gray-400"></i>
                </div>
                <input
                  type="text"
                  placeholder="হিফজ মাদরাসা সার্চ করুন..."
                  class="w-full pl-10 px-4 py-2 border border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  v-model="searchHifz"
                >
                <!-- Dropdown results would go here -->
             <!-- হিফজ সার্চ রেজাল্ট -->
<div v-if="searchHifz && searchResults.hifz.length" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg">
  <ul class="max-h-60 overflow-y-auto">
    <li v-for="(result, index) in searchResults.hifz" :key="index"
        class="px-4 py-2 hover:bg-emerald-50 cursor-pointer"
        @click="selectCenter('hifz', result)">
      {{ result.name }} ({{ result.ElhaqNo }})
    </li>
  </ul>
</div>
              </div>

              <!-- Attachments for Hifz -->
              <div class="mt-4 space-y-3" v-if="!centers.hifz || selectedType === 'hifz'">
                <div class="relative">
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-file-alt mr-1"></i>বর্তমান মারকাজ অনাপত্তিপত্র
                  </label>
                  <input
                    type="file"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    @change="handleFileChange($event, 'hifz', 'noc')"
                  />
                  <div class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
                    <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
                    <span class="text-gray-600">ফাইল আপলোড করুন</span>
                  </div>
                </div>

                <div class="relative">
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-file-signature mr-1"></i>কাঙ্খিত মারকাজ সম্মতিপত্র
                  </label>
                  <input
                    type="file"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    @change="handleFileChange($event, 'hifz', 'consent')"
                  />
                  <div class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
                    <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
                    <span class="text-gray-600">ফাইল আপলোড করুন</span>
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <tr v-if="!centers.kirat || selectedType === 'kirat'">
            <td class="border p-4">
              <label class="text-emerald-800 font-semibold">কাঙ্খিত কিরাত মারকাজ</label>
            </td>
            <td class="border p-4">
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <i class="fas fa-search text-gray-400"></i>
                </div>
                <input
                  type="text"
                  placeholder="কিরাত মাদরাসা সার্চ করুন..."
                  class="w-full pl-10 px-4 py-2 border border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  v-model="searchKirat"
                >
                <!-- Dropdown results would go here -->
                <div v-if="searchKirat && searchResults.kirat.length" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg">
  <ul class="max-h-60 overflow-y-auto">
    <li v-for="(result, index) in searchResults.kirat" :key="index"
        class="px-4 py-2 hover:bg-emerald-50 cursor-pointer"
        @click="selectCenter('kirat', result)">
      {{ result.name }} ({{ result.ElhaqNo }})
    </li>
  </ul>
</div>
              </div>

              <!-- Attachments for Kirat -->
              <div class="mt-4 space-y-3" v-if="!centers.kirat || selectedType === 'kirat'">
  <div class="relative">
    <label class="block text-sm font-medium text-gray-700 mb-1">
      <i class="fas fa-file-alt mr-1"></i>বর্তমান মারকাজ অনাপত্তিপত্র
    </label>
    <input
      type="file"
      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
      @change="handleFileChange($event, 'kirat', 'noc')"
      v-if="!files.kirat.noc"
    />
    <div v-if="!files.kirat.noc" class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
      <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
      <span class="text-gray-600">ফাইল আপলোড করুন</span>
    </div>
    <!-- ফাইল আপলোড হলে দেখাবে -->
    <div v-else class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
      <div class="flex items-center">
        <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
        <span class="text-gray-700 truncate">{{ files.kirat.noc.name }}</span>
      </div>
      <div class="flex space-x-2">
        <button type="button" @click="viewFile(files.kirat.noc)" class="text-blue-500 hover:text-blue-700">
          <i class="fas fa-eye"></i>
        </button>
        <button type="button" @click="removeFile('kirat', 'noc')" class="text-red-500 hover:text-red-700">
          <i class="fas fa-trash-alt"></i>
        </button>
      </div>
    </div>
  </div>

  <div class="relative">
    <label class="block text-sm font-medium text-gray-700 mb-1">
      <i class="fas fa-file-signature mr-1"></i>কাঙ্খিত মারকাজ সম্মতিপত্র
    </label>
    <input
      type="file"
      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
      @change="handleFileChange($event, 'kirat', 'consent')"
      v-if="!files.kirat.consent"
    />
    <div v-if="!files.kirat.consent" class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
      <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
      <span class="text-gray-600">ফাইল আপলোড করুন</span>
    </div>
    <!-- ফাইল আপলোড হলে দেখাবে -->
    <div v-else class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
      <div class="flex items-center">
        <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
        <span class="text-gray-700 truncate">{{ files.kirat.consent.name }}</span>
      </div>
      <div class="flex space-x-2">
        <button type="button" @click="viewFile(files.kirat.consent)" class="text-blue-500 hover:text-blue-700">
          <i class="fas fa-eye"></i>
        </button>
        <button type="button" @click="removeFile('kirat', 'consent')" class="text-red-500 hover:text-red-700">
          <i class="fas fa-trash-alt"></i>
        </button>
      </div>
    </div>
  </div>
</div>

            </td>
          </tr>

          <!-- Submit Button -->
          <tr>
            <td colspan="2" class="border p-4">
                <button
  @click="submitMarkazChange"
  class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
  <i class="fas fa-paper-plane mr-2"></i>আবেদন জমা দিন
</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>


  <!-- Modal for changing markaz -->
  <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
      <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
        <h3 class="text-xl font-bold">{{ modalTitle }}</h3>
        <button @click="closeModal" class="text-white hover:text-gray-200">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="p-6">
        <!-- Search for new markaz -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            কাঙ্খিত {{ modalType === 'darsiyat' ? 'দারসিয়াত' : modalType === 'hifz' ? 'হিফজ' : 'কিরাত' }} মারকাজ
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <i class="fas fa-search text-gray-400"></i>
            </div>
            <input
              type="text"
              :placeholder="`${modalType === 'darsiyat' ? 'দারসিয়াত' : modalType === 'hifz' ? 'হিফজ' : 'কিরাত'} মাদরাসা সার্চ করুন...`"
              class="w-full pl-10 px-4 py-2 border border-emerald-200 rounded-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
              v-model="modalSearch"
            >
            <!-- Dropdown results -->
           <!-- মোডাল সার্চ রেজাল্ট -->
<div v-if="modalSearch && modalSearchResults.length" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg">
  <ul class="max-h-60 overflow-y-auto">
    <li v-for="(result, index) in modalSearchResults" :key="index"
        class="px-4 py-2 hover:bg-emerald-50 cursor-pointer"
        @click="selectModalCenter(result)">
      {{ result.name }} ({{ result.ElhaqNo }})
    </li>
  </ul>
</div>

          </div>
        </div>

      <!-- Attachments in modal -->
<div class="space-y-4 mt-4">
  <div class="relative">
    <label class="block text-sm font-medium text-gray-700 mb-1">
      <i class="fas fa-file-alt mr-1"></i>বর্তমান মারকাজ অনাপত্তিপত্র
    </label>
    <input
      type="file"
      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
      @change="handleModalFileChange($event, 'noc')"
      v-if="!modalFiles.noc"
    />
    <div v-if="!modalFiles.noc" class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
      <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
      <span class="text-gray-600">ফাইল আপলোড করুন</span>
    </div>
    <!-- ফাইল আপলোড হলে দেখাবে -->
    <div v-else class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
      <div class="flex items-center">
        <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
        <span class="text-gray-700 truncate">{{ modalFiles.noc.name }}</span>
      </div>
      <div class="flex space-x-2">
        <button type="button" @click="viewFile(modalFiles.noc)" class="text-blue-500 hover:text-blue-700">
          <i class="fas fa-eye"></i>
        </button>
        <button type="button" @click="removeModalFile('noc')" class="text-red-500 hover:text-red-700">
          <i class="fas fa-trash-alt"></i>
        </button>
      </div>
    </div>
  </div>

  <div class="relative">
    <label class="block text-sm font-medium text-gray-700 mb-1">
      <i class="fas fa-file-signature mr-1"></i>কাঙ্খিত মারকাজ সম্মতিপত্র
    </label>
    <input
      type="file"
      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
      @change="handleModalFileChange($event, 'consent')"
      v-if="!modalFiles.consent"
    />
    <div v-if="!modalFiles.consent" class="flex items-center justify-center w-full px-4 py-2 bg-white border-2 border-dashed border-emerald-300 rounded-md hover:border-emerald-500">
      <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl mr-2"></i>
      <span class="text-gray-600">ফাইল আপলোড করুন</span>
    </div>
    <!-- ফাইল আপলোড হলে দেখাবে -->
    <div v-else class="flex items-center justify-between w-full px-4 py-2 bg-white border border-emerald-300 rounded-md">
      <div class="flex items-center">
        <i class="fas fa-file-pdf text-emerald-500 text-xl mr-2"></i>
        <span class="text-gray-700 truncate">{{ modalFiles.consent.name }}</span>
      </div>
      <div class="flex space-x-2">
        <button type="button" @click="viewFile(modalFiles.consent)" class="text-blue-500 hover:text-blue-700">
          <i class="fas fa-eye"></i>
        </button>
        <button type="button" @click="removeModalFile('consent')" class="text-red-500 hover:text-red-700">
          <i class="fas fa-trash-alt"></i>
        </button>
      </div>
    </div>
  </div>
</div>


        <!-- Modal buttons -->
        <div class="flex justify-end mt-6 space-x-3">
          <button @click="closeModal" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
            বাতিল করুন
          </button>
          <button @click="saveModalChanges" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">
            পরিবর্তন সংরক্ষণ করুন
          </button>
        </div>
      </div>
    </div>
  </div>

    </AuthenticatedLayout>
  </template>

  <style>

  </style>

