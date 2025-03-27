<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';

const students = ref([]);
const loading = ref(true);
const error = ref(null);
const showModal = ref(false);
const showToast = ref(false);
let submitId = null;

onMounted(async () => {
  try {
    loading.value = true;
    const response = await axios.get('/api/students-registration');
    // Add showMenu property to each student
    students.value = response.data.map(student => ({
      ...student,
      showMenu: false
    }));
  } catch (err) {
    error.value = 'ডাটা লোড করতে সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।';
    console.error(err);
  } finally {
    loading.value = false;
  }

  // Add click outside listener to close menus
  document.addEventListener('click', closeAllMenus);
});

onUnmounted(() => {
  // Remove click outside listener
  document.removeEventListener('click', closeAllMenus);
});

const handleSearch = () => {
  // Implement search logic
}

const resetSearch = () => {
  search.value = ''
  searchMobile.value = ''
}

// Close all menus when clicking outside
function closeAllMenus(event) {
  if (!event.target.closest('.relative')) {
    students.value.forEach(student => {
      student.showMenu = false;
    });
  }
}

const openModal = (id) => {
  submitId = id;
  showModal.value = true;
};

const submitApplication = () => {
  router.post(route('student_reg.submit', submitId), {}, {
    preserveScroll: true,
    onSuccess: () => {
      showModal.value = false;
      showToast.value = true;
      setTimeout(() => window.location.reload(), 2000);
    },
    onError: (errors) => {
      if (errors.error) {
        alert(errors.error);
      }
    }
  });
};

// মেনু টগল করার ফাংশন
const toggleMenu = (student) => {
  // অন্য সব মেনু বন্ধ করা
  students.value.forEach(s => {
    if (s.id !== student.id) {
      s.showMenu = false;
    }
  });

  // বর্তমান মেনু টগল করা
  student.showMenu = !student.showMenu;
};

// মেনুর পজিশন নির্ধারণ করার ফাংশন
const getMenuPosition = (studentId) => {
  // DOM এলিমেন্টের পজিশন চেক করা
  const buttonElement = document.querySelector(`[data-student-id="${studentId}"]`);

  if (!buttonElement) return 'right-0';

  const rect = buttonElement.getBoundingClientRect();
  const spaceBelow = window.innerHeight - rect.bottom;
  const spaceRight = window.innerWidth - rect.right;

  // নিচে যথেষ্ট জায়গা না থাকলে উপরে দেখানো
  const verticalClass = spaceBelow < 200 ? 'bottom-full mb-2' : 'top-full mt-2';

  // ডানে যথেষ্ট জায়গা না থাকলে বামে দেখানো
  const horizontalClass = spaceRight < 200 ? 'right-full mr-2' : 'left-0';

  return `${verticalClass} ${horizontalClass}`;
};



// delete student funtion

const emit = defineEmits(['deleted'])

const closeDeleteModal = () => {
  showDeleteModal.value = false
}




const showDeleteModal = ref(false)
const showDeleteToast = ref(false)

const closeMenu = () => {
  showMenu.value = false
}

const deleteId = ref(null)

const openDeleteModal = (id) => {
  deleteId.value = id
  showDeleteModal.value = true
  closeMenu()
}

const deleteStudent = () => {
    router.delete(route('students.delete', { id: deleteId.value }), {
        onSuccess: () => {
            showDeleteModal.value = false
            showDeleteToast.value = true
            setTimeout(() => {
                showDeleteToast.value = false
                window.location.reload()
            }, 3000)
        },
    })
}

const closeDeleteToast = () => {
  showDeleteToast.value = false
}










</script>


<template>
<AuthenticatedLayout>
    <div class="p-4 mt-5 mx-auto">


      <div style="font-family: 'Merriweather','SolaimanLipi',sans-serif"
     class="grid grid-cols-1 gap-6 lg:grid-cols-4 mb-5 sm:grid-cols-2">

    <!-- Total Students Card -->
    <div class="bg-gradient-to-br border border-emerald-100 p-6 rounded-md duration-300 from-emerald-50 hover:shadow-lg islamic-pattern to-white transition-all">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-emerald-600 text-sm font-semibold">মোট</span>
                </div>
                <p class="text-emerald-900 font-medium">মোট নিবন্ধিত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-xl">
                <i class="text-2xl text-amber-600 fa-female fas"></i>
            </div>
        </div>
    </div>

    <!-- Board Return Students Card -->
    <div class="bg-gradient-to-br border border-teal-100 p-6 rounded-md duration-300 from-teal-50 hover:shadow-lg islamic-pattern to-white transition-all">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-sm text-teal-600 font-semibold">জন</span>
                </div>
                <p class="text-teal-900 font-medium">বোর্ড ফেরত শিক্ষার্থী সংখ্যা</p>
            </div>
            <div class="bg-teal-100 p-3 rounded-xl">
                <i class="text-2xl text-amber-600 fa-female fas"></i>
            </div>
        </div>
        <div class="border-t border-teal-100 mt-4 pt-4"></div>
    </div>

    <!-- Female Students Card -->
    <div class="bg-gradient-to-br border border-amber-100 p-6 rounded-md duration-300 from-amber-50 hover:shadow-lg islamic-pattern to-white transition-all">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-amber-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-amber-900 font-medium">নিয়মিত ছাত্র সংখ্যা</p>
            </div>
            <div class="bg-amber-100 p-3 rounded-xl">
                <i class="text-2xl text-amber-600 fa-female fas"></i>
            </div>
        </div>
        <div class="border-amber-100 border-t mt-4 pt-4"></div>
    </div>

    <!-- Year Total Card -->
    <div class="bg-gradient-to-br border border-emerald-100 p-6 rounded-md duration-300 from-emerald-50 hover:shadow-lg islamic-pattern to-white transition-all">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <div class="flex items-baseline space-x-2">
                    <span class="text-emerald-600 text-sm font-semibold">জন</span>
                </div>
                <p class="text-emerald-900 font-medium">{{ selectedYear }} অনিয়মিত ছাত্র সংখ্যা</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-xl">
                <i class="text-2xl text-amber-600 fa-female fas"></i>
            </div>
        </div>
        <div class="border-emerald-100 border-t mt-4 pt-4"></div>
    </div>
</div>














    <!-- Search Card -->
 <div class="bg-white rounded-sm shadow-lg mb-6">
  <!-- Header with Islamic pattern -->
  <div class="bg-emerald-900 p-3 rounded-t-sm islamic-pattern">
    <div class="grid grid-cols-1 gap-4 items-center md:grid-cols-3">
      <h3 class="text-amber-400 text-lg font-bold">
        <i class="fa-search-plus fas ml-2"></i> সার্চ উইযার্ড
      </h3>

      <h3 class="text-center text-lg text-white">
         <!-- ৪৮তম কেন্দ্রীয় পরীক্ষা: নেগরান মুমতাহিন -->
      </h3>

      <div class="flex justify-end gap-3">
        <Link
          :href="route('students_registration.student_registration')"
          class="flex bg-emerald-600 rounded-sm text-white duration-200 gap-2 hover:bg-emerald-700 items-center px-4 py-2 transition-colors"
        >
          <i class="fa-user-plus fas"></i>
          <span>নিবন্ধন করুন</span>
        </Link>

        <button class="bg-teal-600 rounded-sm text-white hover:bg-teal-700 inline-flex items-center px-4 py-2">
          <i class="fa-file-import fas mr-2"></i>
          ইম্পোর্ট করুন
        </button>
      </div>
    </div>
  </div>

  <!-- Search Form Section -->
  <div class="bg-emerald-50 p-6">
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 mb-4 md:grid-cols-3">
      <div class="relative">

        <select class="border-2 border-emerald-200 rounded-sm w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2">
          <option value="">মারহালা সিলেক্ট করুন</option>
          <option value="mutawassita">মুতাওয়াসসিতা</option>
          <option value="sanabia">সানাবিয়া</option>
          <option value="fazilat">ফযীলত</option>
        </select>
      </div>

      <div class="relative">

        <select class="border-2 border-emerald-200 rounded-sm w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2">
          <option value="">অবস্থা সিলেক্ট করুন</option>
          <option value="active">সক্রিয়</option>
          <option value="inactive">নিষ্ক্রিয়</option>
        </select>
      </div>

      <div class="relative">

        <select class="border-2 border-emerald-200 rounded-sm w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2">
          <option value="">আবেদনের ধরন</option>
          <option value="regular">নিয়মিত</option>
          <option value="irregular">অনিয়মিত</option>
        </select>
      </div>

      <div class="relative">

        <select class="border-2 border-emerald-200 rounded-sm w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2">
          <option value="">পেমেন্ট অবস্থা</option>
          <option value="paid">পরিশোধিত</option>
          <option value="unpaid">অপরিশোধিত</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 mb-4 md:grid-cols-3">
      <div class="relative">

        <select class="border-2 border-emerald-200 rounded-sm w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2">
          <option value="">বোর্ড দাখিল অবস্থা</option>
          <option value="submitted">দাখিল করা হয়েছে</option>
          <option value="pending">দাখিল করা হয়নি</option>
        </select>
      </div>

      <div class="relative">

        <input
          type="text"
          v-model="search"
          placeholder="কোড সার্চ করুন..."
          class="border-2 border-emerald-200 rounded-sm w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2"
        >
      </div>

      <div class="relative">

        <input
          type="text"
          v-model="searchMobile"
          placeholder="মোবাইল নম্বর সার্চ করুন..."
          class="border-2 border-emerald-200 rounded-sm w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 pl-10 pr-4 py-2"
        >
      </div>

      <div class="flex gap-3">
        <button
          @click="handleSearch"
          class="flex bg-emerald-600 rounded-sm text-white gap-2 hover:bg-emerald-700 items-center px-4 py-2"
        >
          <i class="fa-search fas"></i>
          সার্চ করুন
        </button>
        <button
          @click="resetSearch"
          class="flex bg-red-500 rounded-sm text-white gap-2 hover:bg-red-600 items-center px-4 py-2"
        >
          <i class="fa-undo fas"></i>
          রিসেট
        </button>
      </div>
    </div>
  </div>
</div>


    <!-- Data Table -->
   <div class="bg-white rounded-sm shadow-lg">
  <!-- Header with Islamic pattern -->
  <div class="bg-emerald-900 p-3 rounded-t-sm islamic-pattern">
    <div class="grid grid-cols-1 gap-4 items-center md:grid-cols-3">
      <h3 class="text-amber-300 text-lg font-bold">
        <i class="fa-users-class fas ml-2"></i> মোট নিবন্ধিত ছাত্র সংখ্যা
      </h3>

      <h3 class="text-amber-300 text-center text-lg">
    <!-- ৪৮তম কেন্দ্রীয় পরীক্ষা: মুতাওয়াসসিতা -->
      </h3>

      <div class="flex justify-end gap-3">
        <button class="bg-amber-500 rounded-sm text-white hover:bg-amber-600 inline-flex items-center px-4 py-1">
          <i class="fa-file-pdf fas mr-2"></i>
          PDF ডাউনলোড
        </button>
        <button class="bg-emerald-600 rounded-sm text-white hover:bg-emerald-700 inline-flex items-center px-4 py-2">
          <i class="fa-paper-plane fas mr-2"></i>
          বোর্ড দাখিল
        </button>
      </div>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
  <thead class="bg-emerald-50">
    <tr>
      <th class="text-center text-emerald-800 text-x font-medium px-6 py-3 uppercase">রেজিস্ট্রেশ নং</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">ছবি</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">নাম</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">পিতার নাম</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">মাদরাসার নাম</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">পরিক্ষার নাম</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">মারহালা</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">জন্ম-তারিখ</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">পরিক্ষার্থীর ধরন</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">পেমেন্ট স্ট্যাটাস</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">আবেদন অবস্থা</th>
      <th class="text-center text-emerald-800 text-xl font-medium px-6 py-3 uppercase">করনীয়</th>
    </tr>
  </thead>
  <tbody class="bg-white divide-emerald-100 divide-y text-xl">
    <tr v-for="student in students" :key="student.id">
      <td class="text-center px-6 py-4">{{ student.id }}</td>
      <td class="p-2 text-center">
  <img
    v-if="student.student_image"
    :src="'/storage/' + student.student_image"
    alt="Student"
    class="w-20 h-20 rounded-sm mx-auto object-cover"
  />
  <div v-else class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mx-auto">
    <span class="text-gray-500 text-xs">No Image</span>
  </div>
</td>
      <td class="text-center px-6 py-4">{{ student.name_bn }}</td>
      <td class="text-center px-6 py-4">{{ student.father_name_bn }}</td>
      <td class="text-center px-6 py-4">{{ student.current_madrasha }}</td>
      <td class="text-center px-6 py-4">{{ student.exam_name_Bn }}</td>
      <td class="text-center px-6 py-4"></td>

      <td class="text-center px-6 py-4">{{ student.Date_of_birth }}</td>

      <td class="text-center px-6 py-4">{{ student.student_type }}</td>
      <td class="text-center px-6 py-4">


      </td>

      <td class="text-center px-6 py-4">
        <div class="flex justify-center">
            <span :class="{
                                            'bg-yellow-300 text-black px-4 py-2 text-sm font-medium rounded-full': student.status === 'বোর্ড দাখিল',
                                            'bg-red-100 text-red-700 px-4 py-2 text-sm font-medium rounded-full': student.status === 'বোর্ড ফেরত',
                                            'bg-green-600 text-white px-4 py-2 text-sm font-medium rounded-full': student.status === 'অনুমোদন'
                                        }">
                                            {{ student.status }}
                                        </span>
        </div>
      </td>
      <td class="text-center px-6 py-4">
<div class="text-left inline-block relative group">
  <div>
   <button
  @click="toggleMenu(student)"
  type="button"
  :data-student-id="student.id"
  class="bg-gray-100 p-2 rounded-full text-gray-700 focus:outline-none hover:bg-gray-200 transition-colors duration-200 shadow-sm hover:shadow"
>
  <i class="fa-ellipsis-v fas"></i>
</button>

  </div>

  <div
    v-if="student.showMenu"
    class="absolute mt-2 z-20"
    :class="getMenuPosition(student.id)"
  >
    <div
      class="bg-white rounded-lg shadow-xl w-56 ring-1 ring-black ring-opacity-5 overflow-hidden transform transition-all duration-200 ease-out scale-100"
    >
      <div class="py-1" role="menu" aria-orientation="vertical">
        <a
          @click="openModal(student.id)"
          class="group flex items-center px-4 py-3 text-sm text-emerald-700 hover:bg-emerald-50 hover:text-emerald-800 cursor-pointer transition-colors duration-150"
        >
          <i class="fas fa-upload mr-3 text-emerald-500 group-hover:text-emerald-700"></i>
          <span class="font-medium">বোর্ড দাখিল করুন</span>
        </a>

        <div class="border-t border-gray-100"></div>

        <Link
          :href="route('students_registration.student_registration_edit', student.id)"
          class="group flex items-center px-4 py-3 text-sm text-amber-600 hover:bg-amber-50 hover:text-amber-800 transition-colors duration-150"
        >
          <i class="fa-pencil-alt fas mr-3 text-amber-500 group-hover:text-amber-700"></i>
          <span class="font-medium">এডিট</span>
        </Link>

        <div class="border-t border-gray-100"></div>

        <Link
          :href="route('students_registration.student_registraion_view', student.id)"
          class="group flex items-center px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 hover:text-blue-800 transition-colors duration-150"
        >
          <i class="fa-info-circle fas mr-3 text-blue-500 group-hover:text-blue-700"></i>
          <span class="font-medium">বিস্তারিত দেখুন</span>
        </Link>

        <div class="border-t border-gray-100"></div>

        <!-- <Link
          class="group flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-800 w-full transition-colors duration-150"
        >
          <i class="fa-trash-alt fas mr-3 text-red-500 group-hover:text-red-700"></i>
          <span class="font-medium">ডিলিট</span>
        </Link> -->

   <a @click="openDeleteModal(student.id)"
                        class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 cursor-pointer">
                        <i class="fas fa-trash-alt mr-3 text-gray-400 group-hover:text-red-700"></i>
                        মুছে ফেলুন
                    </a>
        


      </div>
    </div>
  </div>
</div>
</td>


    </tr>
  </tbody>
</table>







<div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 z-50">
        <div class="bg-white rounded-lg shadow-2xl w-[450px] mx-auto transform transition-all">
            <div class="bg-emerald-600 rounded-t-lg p-4">
                <div class="flex justify-center">
                    <i class="fas fa-paper-plane text-4xl text-white mb-2"></i>
                </div>
                <h2 class="text-xl font-bold text-white text-center">বোর্ড দাখিল করুন</h2>
            </div>
            <div class="p-6 border-t border-emerald-100">
                <p class="text-gray-700 text-center text-lg">আপনি কি নিশ্চিত যে এই আবেদনটি সাবমিট করতে চান?</p>
                <div class="mt-6 flex justify-center space-x-4">
                    <button @click="showModal = false"
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors duration-200">
                        বাতিল করুন
                    </button>
                    <button @click="submitApplication"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-full hover:bg-emerald-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        সাবমিট করুন
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
                <span class="text-xl">আবেদন সফলভাবে সাবমিট হয়েছে!</span>
            </div>
        </div>
        <button @click="showToast = false" class="ml-auto text-white hover:text-emerald-200 text-xl">&times;</button>
    </div>




  <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 z-50">
        <div class="bg-white rounded-lg shadow-2xl w-[450px] mx-auto transform transition-all">
            <div class="bg-red-600 rounded-t-lg p-4">
                <div class="flex justify-center">
                    <i class="fas fa-exclamation-triangle text-4xl text-white mb-2"></i>
                </div>
                <h2 class="text-xl font-bold text-white text-center">সতর্কীকরণ!</h2>
            </div>
            <div class="p-6 border-t border-red-100">
                <p class="text-gray-700 text-center text-lg">আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?</p>
                <p class="text-red-600 text-center text-sm mt-2">এই কাজটি অপরিবর্তনীয়!</p>
                <div class="mt-6 flex justify-center space-x-4">
                    <button @click="showDeleteModal = false"
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors duration-200">
                        বাতিল করুন
                    </button>
                    <button @click="deleteStudent"
                        class="px-6 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-trash-alt mr-2"></i>
                        মুছে ফেলুন
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Success Toast -->
    <div v-if="showDeleteToast"
        class="fixed top-20 -right-96 flex items-center w-full max-w-md p-6 text-white bg-gradient-to-r from-red-600 to-red-700 rounded-lg shadow-2xl border-l-4 border-red-400 transition-all duration-300 ease-out transform translate-x-[-512px]">
        <div class="flex items-center space-x-4">
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-xl">আবেদন সফলভাবে মুছে ফেলা হয়েছে!</span>
            </div>
        </div>
        <button @click="showDeleteToast = false" class="ml-auto text-white hover:text-red-200 text-xl">&times;</button>
    </div>
















  </div>
</div>

  </div>
</AuthenticatedLayout>
</template>
