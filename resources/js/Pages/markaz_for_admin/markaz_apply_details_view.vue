<script setup>
import { ref,computed } from "vue";
import AuthenticatedLayout from "@/Layouts/admin/AuthenticatedLayout.vue";
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import moment from 'moment';



const props = defineProps({
    markazDetails: {
        type: Object,
        required: true
    },
    application: {
        type: Object,
        required: false,
        default: () => ({})
    }
});





const statusText = ref("পেন্ডিং");
const isRejectModalOpen = ref(false);
const rejectReason = ref("");
const returnImage = ref(null);
const rejectImage = ref(null);


const openRejectModal = () => {
  isRejectModalOpen.value = true;
};

const closeRejectModal = () => {
  isRejectModalOpen.value = false;
  rejectReason.value = "";
  rejectImage.value = null;
};

const handleReturnImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = () => {
      returnImage.value = reader.result;
    };
    reader.readAsDataURL(file);
  }
};

const handleRejectImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = () => {
      rejectImage.value = reader.result;
    };
    reader.readAsDataURL(file);
  }
};

const removeReturnImage = () => {
  returnImage.value = null;
};

const removeRejectImage = () => {
  rejectImage.value = null;
};



const submitRejectReason = () => {
  console.log("রিজেক্ট কারণ:", rejectReason.value);
  closeRejectModal();
};




// const isReturnModalOpen = ref(false);

const isReturnModalOpen = ref(false);
const returnReason = ref('');
const imagePreview = ref(null);
const selectedImage = ref(null);

// মডাল ওপেন করার ফাংশন
const openReturnModal = () => {
  isReturnModalOpen.value = true;
};

// মডাল ক্লোজ করার ফাংশন
const closeReturnModal = () => {
  isReturnModalOpen.value = false;
  returnReason.value = '';
  selectedImage.value = null;
  imagePreview.value = null;
};

// ইমেজ আপলোড হ্যান্ডলার
const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    selectedImage.value = file;
    const reader = new FileReader();
    reader.onload = () => {
      imagePreview.value = reader.result;
    };
    reader.readAsDataURL(file);
  }
};

// ইমেজ রিমুভ করার ফাংশন
const removeImage = () => {
  selectedImage.value = null;
  imagePreview.value = null;
};

// ফেরতের কারণ সাবমিট করার ফাংশন
const submitReturnReason = () => {
    if (!returnReason.value.trim()) {
        alert('অনুগ্রহ করে কারণ লিখুন!');
        return;
    }

    const formData = new FormData();
    // Sending the admin feedback message
    formData.append('message', returnReason.value.trim());

    // Sending image if selected
    if (selectedImage.value) {
        formData.append('image', selectedImage.value);
    }

    // Get the ID from props or route params
    const id = props.application?.id || route().params.id;

    router.post(route('markaz.reject', id), formData, {
        onSuccess: () => {
            closeReturnModal();
            alert('আবেদন সফলভাবে ফেরত পাঠানো হয়েছে!');
            // Optionally refresh the page to show updated data
            window.location.reload();
        },
        onError: (errors) => {
            alert(errors.message || 'কিছু সমস্যা হয়েছে!');
        }
    });
};











const showModal = ref(false)
const showToast = ref(false)

const openApprovalModal = () => {
  showModal.value = true
}

const confirmApproval = () => {
  router.post(route('markaz.approve', { id: props.markazDetails.id }), {}, {
    preserveScroll: true,
    onSuccess: () => {
      showModal.value = false
      showToast.value = true
      setTimeout(() => window.location.reload(), 100)
    },
    onError: (errors) => {
      if (errors.error) {
        alert(errors.error)
      }
    }
  })
}


const formatDate = (timestamp) => {
    return moment(timestamp).format('DD/MM/YYYY');
};


</script>

<template>
  <Head title="মারকায মাদরাসার বিস্তারিত" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class=" mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-sm">
          <!-- Header -->
          <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 p-6">
            <h2 class="text-2xl font-bold text-white text-center">
              মারকায মাদরাসার বিস্তারিত তথ্য
            </h2>
          </div>

          <!-- Main Content -->
          <div class="p-6">
            <!-- Basic Info -->
            <div class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">
                মূল মাদরাসার তথ্য
              </h3>
              <table class="min-w-full divide-y divide-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap bg-gray-50 w-1/4">
                      <div class="text-xl font-medium text-gray-900">মাদরাসার নাম</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-md font-semibold text-gray-900">{{markazDetails.madrasha_Name}}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
                      <div class="text-xl font-medium text-gray-900">আবেদনের তারিখ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900"> {{ formatDate(markazDetails.created_at) }}</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Student Statistics -->
            <div class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">
                মূল মাদরাসার শ্রেণিভিত্তিক ছাত্র সংখ্যা
              </h3>
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">ফাযীলাত</th>
                    <th class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">সানাবিয়া উলইয়া</th>
                    <th class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">সানাবিয়া</th>
                    <th class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">মুতাওয়াসসিতা</th>
                    <th class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">ইবতেদাইয়্যাহু</th>
                    <th class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">তাহফিজুল কোরআন</th>


                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr>

                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ markazDetails.fazilat }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ markazDetails.sanabiya_ulya }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ markazDetails.sanabiya }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ markazDetails.mutawassita }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ markazDetails.ibtedaiyyah }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ markazDetails.hifzul_quran }}</div>
                    </td>
                  </tr>



                  <tr>
    <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
        <div class="text-xl font-medium text-gray-900">মারকায টাইপ</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-md font-semibold text-gray-900">{{ markazDetails.markaz_type }}</div>
    </td>
</tr>
<tr>
    <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
        <div class="text-xl font-medium text-gray-900">পরীক্ষার নাম</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-md font-semibold text-gray-900">{{ markazDetails.exam_name }}</div>
    </td>
</tr>


                </tbody>
              </table>
            </div>

            <div class="mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">
        প্রয়োজনীয় তথ্য
    </h3>
    <table class="min-w-full divide-y divide-gray-200">
        <tbody class="bg-white divide-y divide-gray-200">
            <tr>
    <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
        <div class="text-xl font-medium text-gray-900">প্রয়োজনীয়তা</div>
    </td>
    <td class="px-6 py-4">
        <div class="max-h-32 text-2xl overflow-y-auto text-md text-gray-900 pr-4">
            {{ markazDetails.requirements }}
        </div>
    </td>
</tr>
            <tr>
    <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
        <div class="text-xl font-medium text-gray-900">মহতামিমের সম্মতি</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <a :href="'/storage/' + markazDetails.muhtamim_consent"
           target="_blank"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
            <i class="fas fa-eye mr-2"></i>
            ভিউ ফাইল
        </a>

        <a :href="'/storage/' + markazDetails.muhtamim_consent"
                         target="_blank"
                         class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-download mr-2"></i>
                        ডাউনলোড
                      </a>
    </td>
</tr>


<tr>
    <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
        <div class="text-xl font-medium text-gray-900">কমিটির রেজুলেশন</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <a :href="'/storage/' + markazDetails.committee_resolution"
           target="_blank"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
            <i class="fas fa-eye mr-2"></i>
            ভিউ ফাইল
        </a>

        <a :href="'/storage/' + markazDetails.committee_resolution"
                         target="_blank"
                         class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-download mr-2"></i>
                        ডাউনলোড
                      </a>
    </td>
</tr>









<tr>
    <td class="px-6 py-4 whitespace-nowrap bg-gray-50">
        <div class="text-xl font-medium text-gray-900">সভাপতির সম্মতি</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <a :href="'/storage/' + markazDetails.president_consent"
           target="_blank"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
            <i class="fas fa-eye mr-2"></i>
            ভিউ ফাইল
        </a>
        <a :href="'/storage/' + markazDetails.president_consent"
                         target="_blank"
                         class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-download mr-2"></i>
                        ডাউনলোড
                      </a>
    </td>
</tr>
        </tbody>
    </table>
</div>


<div class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">
                সংযুক্ত ডকুমেন্টস
              </h3>
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ডকুমেন্টের নাম</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">অ্যাকশন</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-if="markazDetails.noc_file">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                        <span class="text-sm text-gray-900">NOC ফাইল</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">

                        <a :href="'/storage/' + markazDetails.president_consent"
           target="_blank"
           class="inline-flex items-center px-4 py-2 mx-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
            <i class="fas fa-eye mr-2"></i>
            ভিউ ফাইল
        </a>
                      <a :href="'/storage/' + markazDetails.noc_file"
                         target="_blank"
                         class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-download mr-2"></i>
                        ডাউনলোড
                      </a>
                    </td>
                  </tr>
                  <tr v-if="markazDetails.resolution_file">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                        <span class="text-sm text-gray-900">রেজুলেশন ফাইল</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">

                        <a :href="'/storage/' + markazDetails.president_consent"
           target="_blank"
           class="inline-flex items-center px-4 py-2 mx-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
            <i class="fas fa-eye mr-2"></i>
            ভিউ ফাইল
        </a>


                      <a :href="'/storage/' + markazDetails.resolution_file"
                         target="_blank"
                         class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-download mr-2"></i>
                        ডাউনলোড
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>


            <!-- Associated Madrasas -->
            <div v-if="markazDetails.associated_madrasas && markazDetails.associated_madrasas.length" class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">
                সংযুক্ত মাদরাসা সমূহ
              </h3>
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">মাদরাসার নাম</th>
                    <th class="px-6 py-3 text-left text-md font-semibold  text-gray-500 uppercase tracking-wider">ফাযীলাত</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">সানাবিয়া উলইয়া</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">সানাবিয়া</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">মুতাওয়াসসিতাহ</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">ইবতেদায়ীয়াহ</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">হিফযুল কুরআন</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">মোট</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">সম্মতিপত্র</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-500 uppercase tracking-wider">অনাপত্তিপত্র</th>

                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="madrasa in markazDetails.associated_madrasas" :key="madrasa.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ madrasa.madrasa_Name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ madrasa.fazilat }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ madrasa.sanabiya_ulya }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ madrasa.sanabiya }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ madrasa.mutawassita }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ madrasa.ibtedaiyyah }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ madrasa.hifzul_quran }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ madrasa.fazilat + madrasa.sanabiya_ulya + madrasa.sanabiya +
                           madrasa.mutawassita + madrasa.ibtedaiyyah + madrasa.hifzul_quran }}
                      </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
        <a :href="'/storage/' + markazDetails.president_consent"
           target="_blank"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
            <i class="fas fa-eye mr-2"></i>
            ভিউ ফাইল
        </a>
        <a :href="'/storage/' + markazDetails.noc_file"
                         target="_blank"
                         class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-download mr-2"></i>
                        ডাউনলোড
                      </a>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <a :href="'/storage/' + markazDetails.president_consent"
           target="_blank"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
            <i class="fas fa-eye mr-2"></i>
            ভিউ ফাইল
        </a>
        <a :href="'/storage/' + markazDetails.noc_file"
                         target="_blank"
                         class="inline-flex items-center mx-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-download mr-2"></i>
                        ডাউনলোড
                      </a>
    </td>

                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Attachments -->

            <div class="p-6 bg-white shadow-lg rounded-lg w-full border border-emerald-100">
  <h2 class="text-xl font-bold text-emerald-800 mb-4 text-center">
    <span class="border-b-2 border-emerald-500 pb-1">আবেদনের অবস্থা পরিবর্তন করুন</span>
  </h2>

  <div class="flex gap-3 justify-center">
    <!-- Approval Button -->
    <button
  @click="openApprovalModal()"
  class="px-5 py-2 text-white bg-emerald-600 hover:bg-emerald-700 rounded-sm transition duration-200 shadow-sm flex items-center gap-2"
>
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
  </svg>
  অনুমোদন
</button>
  <!-- Islamic Modal -->
  <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-96 overflow-hidden">
      <!-- Islamic Pattern Header -->
      <div class="bg-emerald-600 p-4 relative">
        <div class="absolute inset-0 opacity-20 pattern-islamic"></div>

      </div>

      <!-- Modal Content -->
      <div class="p-6">
        <div class="text-center mb-6">
          <div class="w-16 h-16 mx-auto mb-4 bg-emerald-100 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h4 class="text-xl font-semibold text-gray-800">অনুমোদন নিশ্চিতকরণ</h4>
          <p class="text-gray-600 mt-2">আপনি কি এই অনুমোদন প্রদান করতে নিশ্চিত?</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center gap-4">
          <button
            @click="confirmApproval"
            class="px-6 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition duration-200"
          >
            হ্যাঁ, নিশ্চিত
          </button>
          <button
            @click="showModal = false"
            class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition duration-200"
          >
            না, ফিরে যান
          </button>
        </div>
      </div>
    </div>
  </div>


  <div v-if="showToast"
        class="fixed top-20 -right-96 flex items-center w-full max-w-md p-6 text-white bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-lg shadow-2xl border-l-4 border-emerald-400 transition-all duration-300 ease-out transform translate-x-[-512px]">
        <div class="flex items-center space-x-4">
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-xl">আবেদন সফলভাবে অনুমোদন করা হয়েছে!</span>
            </div>
        </div>
        <button @click="showToast = false" class="ml-auto text-white hover:text-emerald-200 text-xl">&times;</button>
    </div>










    <button @click="openReturnModal"
      class="px-5 py-2 text-white bg-amber-500 hover:bg-amber-600 rounded-sm transition duration-200 shadow-sm">
      ফেরত
    </button>

    <button @click="openRejectModal"
      class="px-5 py-2 text-white bg-red-600 hover:bg-red-700 rounded-sm transition duration-200 shadow-sm">
      রিজেক্ট
    </button>
  </div>











  <!-- Return Modal -->
  <div v-if="isReturnModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60">
    <div class="bg-white p-8 rounded-lg shadow-xl w-[550px] border-t-4 border-emerald-500">
      <h3 class="text-xl font-bold text-emerald-800 mb-4 text-center">ফেরতের কারণ</h3>

      <textarea v-model="returnReason" placeholder="ফেরতের কারণ লিখুন..."
        class="w-full h-36 p-4 border text-2xl border-emerald-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 resize-none"></textarea>

      <div class="mt-5">
        <label class="block text-sm font-semibold text-emerald-700 mb-2">ছবি সংযুক্ত করুন</label>
        <input type="file" @change="handleImageUpload"
          class="block w-full text-sm text-gray-700 border border-emerald-200 rounded-lg p-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-500">
      </div>

      <div v-if="imagePreview" class="mt-4 relative">
        <img :src="imagePreview" class="w-full h-48 object-cover rounded-lg border border-emerald-200">
        <button @click="removeImage"
          class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition">
          ❌
        </button>
      </div>

      <div class="flex justify-end mt-6 gap-3">
        <button @click="closeReturnModal"
          class="px-5 py-2.5 bg-gray-400 hover:bg-gray-500 text-white rounded-sm transition">
          বাতিল
        </button>
        <button @click="submitReturnReason"
          class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-sm transition">
          সাবমিট
        </button>
      </div>
    </div>
  </div>

  <!-- Reject Modal -->
  <div v-if="isRejectModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60">
    <div class="bg-white p-8 rounded-lg shadow-xl w-[550px] border-t-4 border-red-500">
      <h3 class="text-xl font-bold text-red-800 mb-4 text-center">রিজেক্টের কারণ</h3>

      <textarea v-model="rejectReason" placeholder="রিজেক্টের কারণ লিখুন..."
        class="w-full h-36 p-4 border border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"></textarea>

      <div class="mt-5">
        <label class="block text-sm font-semibold text-red-700 mb-2">ছবি সংযুক্ত করুন</label>
        <input type="file" @change="handleRejectImageUpload"
          class="block w-full text-sm text-gray-700 border border-red-200 rounded-lg p-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-red-500">
      </div>

      <div v-if="rejectImage" class="mt-4 relative">
        <img :src="rejectImage" class="w-full h-48 object-cover rounded-lg border border-red-200">
        <button @click="removeRejectImage"
          class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition">
          ❌
        </button>
      </div>

      <div class="flex justify-end mt-6 gap-3">
        <button @click="closeRejectModal"
          class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-sm transition">
          বাতিল
        </button>
        <button @click="submitRejectReason"
          class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-sm transition">
          সাবমিট
        </button>
      </div>
    </div>
  </div>
</div>




          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
