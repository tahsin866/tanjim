<script setup>
import { ref,computed } from "vue";
import AuthenticatedLayout from "@/Layouts/admin/AuthenticatedLayout.vue";
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import moment from 'moment';
import { useToast } from "primevue/usetoast";
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Textarea from 'primevue/textarea';
import FileUpload from 'primevue/fileupload';
import Toast from 'primevue/toast'
import Badge from 'primevue/badge';

const toast = useToast();

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
  const file = event.files[0];
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
  if (!rejectReason.value.trim()) {
    toast.add({
      severity: 'error',
      summary: 'ত্রুটি',
      detail: 'অনুগ্রহ করে কারণ লিখুন!',
      life: 3000
    });
    return;
  }

  const formData = new FormData();
  formData.append('message', rejectReason.value.trim());

  if (rejectImage.value) {
    // Convert base64 to file if needed
    const base64Response = fetch(rejectImage.value);
    base64Response.then(res => res.blob()).then(blob => {
      formData.append('image', blob, 'reject-image.jpg');
    });
  }

  const id = props.application?.id || route().params.id;

  router.post(route('markaz.reject', id), formData, {
    onSuccess: () => {
      closeRejectModal();
      toast.add({
        severity: 'success',
        summary: 'সফল',
        detail: 'আবেদন সফলভাবে রিজেক্ট করা হয়েছে!',
        life: 3000
      });
      setTimeout(() => window.location.reload(), 1500);
    },
    onError: (errors) => {
      toast.add({
        severity: 'error',
        summary: 'ত্রুটি',
        detail: errors.message || 'কিছু সমস্যা হয়েছে!',
        life: 3000
      });
    }
  });
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
  const file = event.files[0];
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
    toast.add({
      severity: 'error',
      summary: 'ত্রুটি',
      detail: 'অনুগ্রহ করে কারণ লিখুন!',
      life: 3000
    });
    return;
  }

  const formData = new FormData();
  formData.append('message', returnReason.value.trim());

  if (selectedImage.value) {
    formData.append('image', selectedImage.value);
  }

  const id = props.application?.id || route().params.id;

  router.post(route('markaz.reject', id), formData, {
    onSuccess: () => {
      closeReturnModal();
      toast.add({
        severity: 'success',
        summary: 'সফল',
        detail: 'আবেদন সফলভাবে ফেরত পাঠানো হয়েছে!',
        life: 3000
      });
      setTimeout(() => window.location.reload(), 1500);
    },
    onError: (errors) => {
      toast.add({
        severity: 'error',
        summary: 'ত্রুটি',
        detail: errors.message || 'কিছু সমস্যা হয়েছে!',
        life: 3000
      });
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
      showModal.value = false;
      toast.add({
        severity: 'success',
        summary: 'সফল',
        detail: 'আবেদন সফলভাবে অনুমোদন করা হয়েছে!',
        life: 3000
      });
      setTimeout(() => window.location.reload(), 1500);
    },
    onError: (errors) => {
      if (errors.error) {
        toast.add({
          severity: 'error',
          summary: 'ত্রুটি',
          detail: errors.error,
          life: 3000
        });
      }
    }
  });
};


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
          <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 p-6 relative flex justify-between items-center">
  <div class="flex-grow">
    <h2 class="text-2xl font-bold text-white text-center">
      মারকায মাদরাসার বিস্তারিত তথ্য
    </h2>
  </div>
  <div class="absolute right-6">
    <span v-if="props.application.status === 'pending'"
          class="px-3 py-1 bg-yellow-500 text-white text-sm font-medium rounded-full">
      পেন্ডিং
    </span>
    <span v-else-if="props.application.status === 'approved'"
          class="px-3 py-1 bg-green-500 text-white text-sm font-medium rounded-full">
      অনুমোদিত
    </span>
    <span v-else-if="props.application.status === 'rejected'"
          class="px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-full">
      বাতিল
    </span>
    <span v-else-if="props.application.status === 'returned'"
          class="px-3 py-1 bg-orange-500 text-white text-sm font-medium rounded-full">
      ফেরত
    </span>
    <span v-else
          class="px-3 py-1 bg-gray-500 text-white text-sm font-medium rounded-full">
      অজানা
    </span>
  </div>
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
      <Button @click="openApprovalModal"
              class="p-button-success"
              icon="pi pi-check"
              label="অনুমোদন" />

      <!-- Return Button -->
      <Button @click="openReturnModal"
              class="p-button-warning"
              label="ফেরত" />

      <!-- Reject Button -->
      <Button @click="openRejectModal"
              class="p-button-danger"
              label="রিজেক্ট" />
    </div>

    <!-- Approval Confirmation Dialog -->
    <Dialog v-model:visible="showModal"
            modal

            header="অনুমোদন নিশ্চিতকরণ"
            :style="{width: '30vw'}"
            :closable="false">
      <div class="text-center mb-6">
        <div class="w-16 h-16 mx-auto mb-4 bg-emerald-100 rounded-full flex items-center justify-center">
          <i class="pi pi-check text-emerald-600 text-2xl"></i>
        </div>
        <h4
        style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
        class="text-xl font-semibold text-gray-800 ">অনুমোদন নিশ্চিতকরণ</h4>
        <p
               style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
        class="text-gray-600 mt-2">আপনি কি এই অনুমোদন প্রদান করতে নিশ্চিত?</p>
      </div>
      <template #footer>
        <Button
         style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
        label="না, ফিরে যান"
                icon="pi pi-times"
                @click="showModal = false"
                class="p-button-text" />
        <Button
             style=" font-family: 'Merriweather','SolaimanLipi',sans-serif;"
        label="হ্যাঁ, নিশ্চিত"
                icon="pi pi-check"
                @click="confirmApproval"
                class="p-button-success"
                autofocus />
      </template>
    </Dialog>

    <!-- Return Modal -->
    <Dialog v-model:visible="isReturnModalOpen"
        modal
        header="ফেরতের কারণ"
        :style="{width: '550px'}"
        :closable="false"
        class="return-modal">
  <div class="p-fluid w-full">
    <div class="field w-full">
      <Textarea v-model="returnReason"
                placeholder="ফেরতের কারণ লিখুন..."
                rows="5"
                class="text-2xl w-full"
                style="width: 100%; min-width: 100%;" />
    </div>
    <div class="field mt-5 w-full">
      <label class="block text-sm font-semibold text-emerald-700 mb-2">ছবি সংযুক্ত করুন</label>
      <FileUpload mode="basic"
                  accept="image/*"
                  :maxFileSize="1000000"
                  @select="handleImageUpload"
                  :auto="true"
                  chooseLabel="ছবি নির্বাচন করুন"
                  class="w-full" />
    </div>
    <div v-if="imagePreview" class="mt-4 relative w-full">
      <img :src="imagePreview" class="w-full h-48 object-cover rounded-lg border border-emerald-200">
      <Button icon="pi pi-times"
              @click="removeImage"
              class="p-button-rounded p-button-danger absolute top-2 right-2" />
    </div>
  </div>
  <template #footer>
    <Button label="বাতিল"
            icon="pi pi-times"
            @click="closeReturnModal"
            class="p-button-text" />
    <Button label="সাবমিট"
            icon="pi pi-check"
            @click="submitReturnReason"
            class="p-button-success" />
  </template>
</Dialog>


    <!-- Reject Modal -->
    <Dialog v-model:visible="isRejectModalOpen"
            modal
            header="রিজেক্টের কারণ"
            :style="{width: '550px'}"
            :closable="false">
      <div class="p-fluid">
        <div class="field">
          <Textarea v-model="rejectReason"
                    placeholder="রিজেক্টের কারণ লিখুন..."
                    rows="5"
        class="text-2xl w-full"
                    />
        </div>
        <div class="field mt-5">
          <label class="block text-sm font-semibold text-red-700 mb-2">ছবি সংযুক্ত করুন</label>
          <FileUpload mode="basic"
                      accept="image/*"
                      :maxFileSize="1000000"
                      @select="handleRejectImageUpload"
                      :auto="true"
                      chooseLabel="ছবি নির্বাচন করুন" />
        </div>
        <div v-if="rejectImage" class="mt-4 relative">
          <img :src="rejectImage" class="w-full h-48 object-cover rounded-lg border border-red-200">
          <Button icon="pi pi-times"
                  @click="removeRejectImage"
                  class="p-button-rounded p-button-danger absolute top-2 right-2" />
        </div>
      </div>
      <template #footer>
        <Button label="বাতিল"
                icon="pi pi-times"
                @click="closeRejectModal"
                class="p-button-text" />
        <Button label="সাবমিট"
                icon="pi pi-check"
                @click="submitRejectReason"
                class="p-button-danger" />
      </template>
    </Dialog>

    <!-- Toast -->
    <Toast position="top-right" />
  </div>




          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
