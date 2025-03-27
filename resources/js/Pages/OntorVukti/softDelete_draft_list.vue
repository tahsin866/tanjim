<template>
    <AuthenticatedLayout>
      <div class="p-6 bg-gray-50 min-h-screen mx-5 mt-5">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">ছাত্র-ছাত্রী রিস্টোর</h2>

        <!-- Student Table -->
        <div class="bg-white shadow-lg rounded-lg p-4">
          <h3 class="text-lg font-semibold mb-2 text-emerald-600">সাময়িক বাতিল ছাত্রদের লিস্ট</h3>
          <table class="w-full border border-gray-300 rounded-lg">
            <thead>
              <tr class="bg-emerald-700 text-white">
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Status</th>
                <th class="py-2 px-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="student in activeStudents" :key="student.id" class="border-b">
                <td class="py-2 px-4">{{ student.name }}</td>
                <td class="py-2 px-4">{{ student.status }}</td>
                <td class="py-2 px-4 flex gap-2">
                  <button @click="openModal('draft', student)" class="px-3 py-1 text-yellow-600 bg-yellow-100 rounded-md">
                    ড্রাফ্ট
                  </button>
                  <button @click="openModal('softDelete', student)" class="px-3 py-1 text-red-600 bg-red-100 rounded-md">
                 সাময়িক ডিলিট
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Draft Students -->
        <div v-if="draftStudents.length" class="bg-yellow-50 shadow-lg rounded-lg p-4 mt-4">
          <h3 class="text-lg font-semibold mb-2 text-yellow-600">Draft Students</h3>
          <table class="w-full border border-yellow-300 rounded-lg">
            <thead>
              <tr class="bg-yellow-700 text-white">
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="student in draftStudents" :key="student.id" class="border-b">
                <td class="py-2 px-4">{{ student.name }}</td>
                <td class="py-2 px-4">
                  <button @click="restoreStudent('draft', student)" class="px-3 py-1 text-green-600 bg-green-100 rounded-md">
                    Restore
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Soft Deleted Students -->
        <div v-if="deletedStudents.length" class="bg-red-50 shadow-lg rounded-lg p-4 mt-4">
          <h3 class="text-lg font-semibold mb-2 text-red-600">Soft Deleted Students</h3>
          <table class="w-full border border-red-300 rounded-lg">
            <thead>
              <tr class="bg-red-700 text-white">
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="student in deletedStudents" :key="student.id" class="border-b">
                <td class="py-2 px-4">{{ student.name }}</td>
                <td class="py-2 px-4">
                  <button @click="restoreStudent('softDelete', student)" class="px-3 py-1 text-green-600 bg-green-100 rounded-md">
                    Restore
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Modal -->
        <div v-if="modalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
          <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold text-gray-800">{{ modalTitle }}</h2>
            <p class="text-gray-600 mt-2">{{ modalMessage }}</p>
            <div class="flex justify-end gap-3 mt-4">
              <button @click="modalOpen = false" class="px-4 py-2 bg-gray-200 rounded-md">Cancel</button>
              <button @click="confirmAction" class="px-4 py-2 bg-emerald-600 text-white rounded-md">Confirm</button>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
    </template>

    <script setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { ref,computed } from "vue";

    // Initial student data
    const students = ref([
      { id: 1, name: "আলি হাসান", status: "Active" },
      { id: 2, name: "ফাতেমা বেগম", status: "Active" },
      { id: 3, name: "রহিম উদ্দিন", status: "Active" },
    ]);

    const draftStudents = ref([]);
    const deletedStudents = ref([]);
    const modalOpen = ref(false);
    const modalTitle = ref("");
    const modalMessage = ref("");
    let selectedStudent = null;
    let actionType = null;

    // Get active students
    const activeStudents = computed(() =>
      students.value.filter(
        (student) =>
          !draftStudents.value.some((d) => d.id === student.id) &&
          !deletedStudents.value.some((d) => d.id === student.id)
      )
    );

    // Open modal for confirmation
    const openModal = (type, student) => {
      modalOpen.value = true;
      selectedStudent = student;
      actionType = type;

      if (type === "draft") {
        modalTitle.value = "Move to Draft";
        modalMessage.value = `Are you sure you want to move ${student.name} to draft?`;
      } else if (type === "softDelete") {
        modalTitle.value = "Soft Delete";
        modalMessage.value = `আপনি নিশ্চিত  ${student.name}? সফ্ট ডিলিট করতে চান`;
      }
    };

    // Confirm action
    const confirmAction = () => {
      if (actionType === "draft") {
        draftStudents.value.push(selectedStudent);
      } else if (actionType === "softDelete") {
        deletedStudents.value.push(selectedStudent);
      }
      modalOpen.value = false;
    };

    // Restore student
    const restoreStudent = (type, student) => {
      if (type === "draft") {
        draftStudents.value = draftStudents.value.filter((s) => s.id !== student.id);
      } else if (type === "softDelete") {
        deletedStudents.value = deletedStudents.value.filter((s) => s.id !== student.id);
      }
    };
    </script>

    <style>
    /* Optional Tailwind custom styles */
    </style>
