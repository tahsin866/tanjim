<template>
    <div class="student-edit-container">
      <h4 class="mb-4">শিক্ষার্থীর তথ্য সম্পাদনা করুন</h4>

      <form @submit.prevent="updateStudent">
        <!-- Basic Information -->
        <div class="row mb-3">
          <div class="col-md-4">
            <label for="name_bn" class="form-label">নাম (বাংলা) <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name_bn" v-model="form.name_bn" required>
            <div v-if="errors.name_bn" class="text-danger">{{ errors.name_bn }}</div>
          </div>

          <div class="col-md-4">
            <label for="name_en" class="form-label">নাম (ইংরেজি)</label>
            <input type="text" class="form-control" id="name_en" v-model="form.name_en">
            <div v-if="errors.name_en" class="text-danger">{{ errors.name_en }}</div>
          </div>

          <div class="col-md-4">
            <label for="name_ar" class="form-label">নাম (আরবি)</label>
            <input type="text" class="form-control" id="name_ar" v-model="form.name_ar">
            <div v-if="errors.name_ar" class="text-danger">{{ errors.name_ar }}</div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="father_name_bn" class="form-label">পিতার নাম (বাংলা) <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="father_name_bn" v-model="form.father_name_bn" required>
            <div v-if="errors.father_name_bn" class="text-danger">{{ errors.father_name_bn }}</div>
          </div>

          <div class="col-md-4">
            <label for="father_name_en" class="form-label">পিতার নাম (ইংরেজি)</label>
            <input type="text" class="form-control" id="father_name_en" v-model="form.father_name_en">
            <div v-if="errors.father_name_en" class="text-danger">{{ errors.father_name_en }}</div>
          </div>

          <div class="col-md-4">
            <label for="father_name_ar" class="form-label">পিতার নাম (আরবি)</label>
            <input type="text" class="form-control" id="father_name_ar" v-model="form.father_name_ar">
            <div v-if="errors.father_name_ar" class="text-danger">{{ errors.father_name_ar }}</div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="mother_name_bn" class="form-label">মাতার নাম (বাংলা)</label>
            <input type="text" class="form-control" id="mother_name_bn" v-model="form.mother_name_bn">
            <div v-if="errors.mother_name_bn" class="text-danger">{{ errors.mother_name_bn }}</div>
          </div>

          <div class="col-md-4">
            <label for="mother_name_en" class="form-label">মাতার নাম (ইংরেজি)</label>
            <input type="text" class="form-control" id="mother_name_en" v-model="form.mother_name_en">
            <div v-if="errors.mother_name_en" class="text-danger">{{ errors.mother_name_en }}</div>
          </div>

          <div class="col-md-4">
            <label for="mother_name_ar" class="form-label">মাতার নাম (আরবি)</label>
            <input type="text" class="form-control" id="mother_name_ar" v-model="form.mother_name_ar">
            <div v-if="errors.mother_name_ar" class="text-danger">{{ errors.mother_name_ar }}</div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="BRN_no" class="form-label">জন্ম নিবন্ধন নম্বর</label>
            <input type="text" class="form-control" id="BRN_no" v-model="form.BRN_no">
            <div v-if="errors.BRN_no" class="text-danger">{{ errors.BRN_no }}</div>
          </div>

          <div class="col-md-4">
            <label for="NID_no" class="form-label">জাতীয় পরিচয়পত্র নম্বর</label>
            <input type="text" class="form-control" id="NID_no" v-model="form.NID_no">
            <div v-if="errors.NID_no" class="text-danger">{{ errors.NID_no }}</div>
          </div>

          <div class="col-md-4">
            <label for="mobile_no" class="form-label">মোবাইল নম্বর</label>
            <input type="text" class="form-control" id="mobile_no" v-model="form.mobile_no">
            <div v-if="errors.mobile_no" class="text-danger">{{ errors.mobile_no }}</div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="Date_of_birth" class="form-label">জন্ম তারিখ</label>
            <input type="date" class="form-control" id="Date_of_birth" v-model="form.Date_of_birth">
            <div v-if="errors.Date_of_birth" class="text-danger">{{ errors.Date_of_birth }}</div>
          </div>

          <div class="col-md-4">
            <label for="student_type" class="form-label">শিক্ষার্থীর ধরন</label>
            <select class="form-select" id="student_type" v-model="form.student_type">
              <option value="নিয়মিত">নিয়মিত</option>
              <option value="অনিয়মিত">অনিয়মিত</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="marhala_id" class="form-label">মারহালা/শ্রেণী</label>
            <select class="form-select" id="marhala_id" v-model="form.marhala_id">
              <option value="">-- মারহালা নির্বাচন করুন --</option>
              <option v-for="marhala in marhalas" :key="marhala.id" :value="marhala.id">
                {{ marhala.marhala_name_bn }}
              </option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="student_image" class="form-label">শিক্ষার্থীর ছবি</label>
            <input type="file" class="form-control" id="student_image" @change="handleStudentImageUpload">
            <div v-if="student.student_image" class="mt-2">
              <img :src="'/storage/' + student.student_image" alt="Student Image" class="img-thumbnail" style="max-height: 100px;">
            </div>
          </div>

          <div class="col-md-6">
            <label for="NID_attach" class="form-label">জাতীয় পরিচয়পত্র সংযুক্তি</label>
            <input type="file" class="form-control" id="NID_attach" @change="handleNIDAttachUpload">
            <div v-if="student.NID_attach" class="mt-2">
              <a :href="'/storage/' + student.NID_attach" target="_blank">বর্তমান সংযুক্তি দেখুন</a>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
          <button type="submit" class="btn btn-update" :disabled="form.processing">
            <i class="fas fa-save me-1"></i> আপডেট করুন
          </button>
          <button type="button" class="btn btn-secondary ms-2" @click="goBack">
            <i class="fas fa-arrow-left me-1"></i> বাতিল করুন
          </button>
        </div>
      </form>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import { router } from '@inertiajs/vue3';

  // Get props from the controller
  const props = defineProps({
    student: Object,
    marhalas: Array,
    errors: Object
  });

  // Create form with student data
  const form = useForm({
    name_bn: props.student.name_bn,
    name_en: props.student.name_en,
    name_ar: props.student.name_ar,
    father_name_bn: props.student.father_name_bn,
    father_name_en: props.student.father_name_en,
    father_name_ar: props.student.father_name_ar,
    mother_name_bn: props.student.mother_name_bn,
    mother_name_en: props.student.mother_name_en,
    mother_name_ar: props.student.mother_name_ar,
    BRN_no: props.student.BRN_no,
    NID_no: props.student.NID_no,
    mobile_no: props.student.mobile_no,
    Date_of_birth: props.student.Date_of_birth,
    student_type: props.student.student_type || 'নিয়মিত',
    marhala_id: props.student.marhala_id,
    student_image: null,
    NID_attach: null,
    _method: 'PUT', // Add this to ensure PUT method is used
  });

  // Handle file uploads
  const handleStudentImageUpload = (event) => {
    form.student_image = event.target.files[0];
  };

  const handleNIDAttachUpload = (event) => {
    form.NID_attach = event.target.files[0];
  };

  // Submit form
  const updateStudent = () => {
    form.submit('put', route('students_registration.student_registration_update', props.student.id), {
      preserveScroll: true,
      onSuccess: () => {
        // Show success message or redirect
        router.visit(route('students_registration.index'));
      },
    });
  };

  // Go back to previous page
  const goBack = () => {
    router.visit(route('students_registration.index'));
  };
  </script>

  <style scoped>
  .student-edit-container {
    padding: 20px;
  }

  .btn-update {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    font-weight: 500;
    transition: background-color 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .btn-update:hover {
    background-color: #45a049;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  }

  .btn-update:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
  }

  .btn-secondary {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    font-weight: 500;
    transition: background-color 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .btn-secondary:hover {
    background-color: #5a6268;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  }
  </style>
