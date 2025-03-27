<script setup>
   import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';
import { ref , computed } from 'vue'


const students = ref([
  {
    id: 1,
    examName: "Final Exam",
    examType: "Regular",
    examYear: "2024",
    prevExam: {
      name: "Mid-Term",
      studentName: "Tahsin Abdullah",
      gender: "Male",
      fatherName: "Mr. Abdullah",
      rollNo: "2021101",
      division: "A",
      madrasa: "Al Madina",
      board: "Dhaka Board",
    },
  },
  {
    id: 2,
    examName: "Final Exam",
    examType: "Irregular",
    examYear: "2023",
    prevExam: {
      name: "Annual",
      studentName: "Rahim Uddin",
      gender: "Male",
      fatherName: "Mr. Karim",
      rollNo: "2022105",
      division: "B",
      madrasa: "Islamic Center",
      board: "Chittagong Board",
    },
  },
]);

const currentIndex = ref(0);

// Navigate between students
const nextStudent = () => {
  currentIndex.value = (currentIndex.value + 1) % students.value.length;
};

const prevStudent = () => {
  currentIndex.value =
    (currentIndex.value - 1 + students.value.length) % students.value.length;
};

// Get current student dynamically
const student = computed(() => students.value[currentIndex.value]);

const registrations = ref([
  {
    name: "মুফতি বেলাল হুসাইন",
    position: "মাদ্রাসা অ্যাডমিন",
    dateTime: "১১ ডিসেম্বর ২০২৪ - ২৩:২২:৩৭",
    status: "অন্তর্ভুক্তির পেমেন্ট সম্পন্ন হয়েছে",
    statusClass: "bg-emerald-100 text-emerald-600",
    icon: "fas fa-money-check-alt",
    note: "-",
  },
  {
    name: "মু. অহিদুর রহমান",
    position: "আল-হাইআতুল উলয়া সুপার অ্যাডমিন",
    dateTime: "১১ ডিসেম্বর ২০২৪ - ১৬:৪০:২৩",
    status: "হাইআতুল উলয়া কর্তৃক অনুমোদিত",
    statusClass: "bg-green-100 text-green-600",
    icon: "fas fa-check-circle",
    note: "-",
  },
  {
    name: "মোঃ নজরুল ইসলাম",
    position: "আল-হাইআতুল উলয়া অ্যাডমিন",
    dateTime: "১১ ডিসেম্বর ২০২৪ - ১৫:১৭:১২",
    status: "সংযোজন আপলোড করা হয়েছে",
    statusClass: "bg-amber-100 text-amber-600",
    icon: "fas fa-upload",
    note: "-",
  },
  {
    name: "মোঃ নজরুল ইসলাম",
    position: "আল-হাইআতুল উলয়া অ্যাডমিন",
    dateTime: "১১ ডিসেম্বর ২০২৪ - ১৫:১০:৪৪",
    status: "সংযোজন আপলোড করা হয়েছে",
    statusClass: "bg-amber-100 text-amber-600",
    icon: "fas fa-upload",
    note: "-",
  }
])
</script>

<template>
<AuthenticatedLayout>
    <div class="p-6">
    <!-- Exam Title -->
    <div class="bg-emerald-800 text-white p-4 rounded-sm shadow-lg mb-6">
      <div class="flex items-center gap-3">
        <!-- <i class="fas fa-star-and-crescent text-2xl"></i> -->
        <h2 class="text-xl">
          {{ student.examName }} পরীক্ষার নিবন্ধন - {{ student.examYear }} / ২০২৫ ঈসাদ
        </h2>
      </div>
    </div>

    <div class=" mx-auto mt-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- First Column -->
    <div
      class="bg-white p-6 rounded-sm shadow-md border-t-4 border-emerald-600 transition-all duration-500"
    >
      <h3
        class="text-lg font-semibold text-emerald-800 border-b border-emerald-100 pb-3 mb-4 flex items-center gap-2"
      >
        <i class="fas fa-file-alt text-emerald-600"></i>
        আবেদনের ধরন
      </h3>
      <div class="space-y-3">
        <p class="flex items-center gap-2">
          <i class="fas fa-book-open text-emerald-600"></i>
          <span class="font-medium">পরীক্ষার নাম:</span> {{ student.examName }}
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-user-graduate text-emerald-600"></i>
          <span class="font-medium">পরীক্ষার্থী ধরন:</span> {{ student.examType }}
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-calendar-alt text-emerald-600"></i>
          <span class="font-medium">পরীক্ষার সন:</span> {{ student.examYear }}
        </p>
      </div>
    </div>

    <!-- Second Column -->
    <div
      class="bg-white p-6 rounded-sm shadow-md border-t-4 border-emerald-600 transition-all duration-500"
    >
      <h3
        class="text-lg font-semibold text-emerald-800 border-b border-emerald-100 pb-3 mb-4 flex items-center gap-2"
      >
        <i class="fas fa-history text-emerald-600"></i>
        বিগত পরীক্ষার তথ্য
      </h3>
      <div class="space-y-3">
        <p class="flex items-center gap-2">
          <i class="fas fa-scroll text-emerald-600"></i>
          <span class="font-medium">পরীক্ষার নাম:</span> {{ student.prevExam.name }}
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-user text-emerald-600"></i>
          <span class="font-medium">পরীক্ষার্থী নাম:</span> {{ student.prevExam.studentName }}
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-venus-mars text-emerald-600"></i>
          <span class="font-medium">লিঙ্গ:</span> {{ student.prevExam.gender }}
        </p>
        <p class="flex items-center gap-2">
          <i class="fas fa-id-card text-emerald-600"></i>
          <span class="font-medium">রোল নং:</span> {{ student.prevExam.rollNo }}
        </p>
      </div>
    </div>
  </div>

  <!-- Navigation Buttons -->
  <div class="flex justify-between mt-6">
    <button
      @click="prevStudent"
      class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md transition"
    >
      <i class="fas fa-arrow-left"></i> পূর্ববর্তী
    </button>
    <button
      @click="nextStudent"
      class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md transition"
    >
      পরবর্তী <i class="fas fa-arrow-right"></i>
    </button>
  </div>
</div>



    <!-- Applicant Info -->
    <div class="mt-6 bg-white p-6 rounded-sm shadow-md border-t-4 border-emerald-600">
      <h3 class="text-lg font-semibold text-emerald-800 border-b border-emerald-100 pb-3 mb-4 flex items-center gap-2">
        <i class="fas fa-user-edit text-emerald-600"></i>
        আবেদনকারীর তথ্য
      </h3>
      <!-- <p class="flex items-center gap-2">
        <i class="fas fa-mouse-pointer text-emerald-600"></i>
        <span class="font-medium">রেজিস্ট্রেশন ফর্মের ক্লিক সংখ্যা:</span> {{ student.applicantInfo.regFormClick }}
      </p> -->

      <div class="p-6 bg-emerald-50 min-h-screen">
    <div class="bg-emerald-800 text-white p-4 rounded-sm shadow-lg mb-6">
      <h2 class="text-lg flex items-center gap-2">
        <!-- <i class="fas fa-star-and-crescent"></i> -->
        নিবন্ধন অবস্থা পর্যবেক্ষণ
      </h2>
    </div>

    <div class="bg-white rounded-sm shadow-md overflow-hidden border border-emerald-100">
      <table class="w-full text-left border-collapse">
        <!-- Table Header -->
        <thead class="bg-emerald-700 text-white">
          <tr>
            <th class="p-4 ">
              <div class="flex items-center gap-2">
                <i class="fas fa-user-circle"></i>
                সিদ্ধান্ত গ্রহণকারী
              </div>
            </th>
            <th class="p-4 ">
              <div class="flex items-center gap-2">
                <i class="fas fa-id-badge"></i>
                পদবি
              </div>
            </th>
            <th class="p-4 ">
              <div class="flex items-center gap-2">
                <i class="fas fa-calendar-alt"></i>
                তারিখ ও সময়
              </div>
            </th>
            <th class="p-4 ">
              <div class="flex items-center gap-2">
                <i class="fas fa-info-circle"></i>
                অবস্থা
              </div>
            </th>
            <th class="p-4">
              <div class="flex items-center gap-2">
                <i class="fas fa-comment-alt"></i>
                মন্তব্য
              </div>
            </th>
          </tr>
        </thead>

        <!-- Table Body -->
        <tbody>
          <tr
            v-for="(entry, index) in registrations"
            :key="index"
            :class="{ 'bg-emerald-50': index % 2 !== 0 }"
            class="hover:bg-emerald-100 transition-colors duration-150"
          >
            <td class="p-4 border-b border-emerald-100">
              <div class="flex items-center gap-2">
                <i class="fas fa-user text-emerald-600"></i>
                {{ entry.name }}
              </div>
            </td>
            <td class="p-4 border-b border-emerald-100">
              <div class="flex items-center gap-2">
                <i class="fas fa-mosque text-emerald-600"></i>
                {{ entry.position }}
              </div>
            </td>
            <td class="p-4 border-b border-emerald-100">
              <div class="flex items-center gap-2">
                <i class="fas fa-clock text-emerald-600"></i>
                {{ entry.dateTime }}
              </div>
            </td>
            <td class="p-4 border-b border-emerald-100">
              <span
                class="px-3 py-1 rounded-md font-medium flex items-center gap-2 w-fit"
                :class="entry.statusClass"
              >
                <i :class="entry.icon"></i>
                {{ entry.status }}
              </span>
            </td>
            <td class="p-4 border-b border-emerald-100">
              <div class="flex items-center gap-2">
                <i class="fas fa-pen text-emerald-600"></i>
                {{ entry.note }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
    </div>
  </div>
</AuthenticatedLayout>
</template>

<style scoped>
.font-arabic {
  font-family: 'Noto Naskh Arabic', serif;
}
</style>
