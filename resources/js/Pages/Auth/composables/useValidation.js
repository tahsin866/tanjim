import { ref } from 'vue';

export function useValidation(form, currentStep) {
  const validationErrors = ref({});
  const hasAttemptedValidation = ref(false);

const validateStep = () => {
  validationErrors.value = {};
  hasAttemptedValidation.value = true;

  if (currentStep.value === 1) {
    if (!form.fullNameBangla) validationErrors.value.fullNameBangla = 'বাংলা নাম প্রয়োজন';
    if (!form.fullNameEnglish) validationErrors.value.fullNameEnglish = 'ইংরেজি নাম প্রয়োজন';
    if (!form.fatherName) validationErrors.value.fatherName = 'বাবার নাম প্রয়োজন';
    if (!form.email) validationErrors.value.email = 'ইমেইল ঠিকানা প্রয়োজন';
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) validationErrors.value.email = 'সঠিক ইমেইল ঠিকানা লিখুন';
    if (!form.phoneNumber) validationErrors.value.phoneNumber = 'ফোন নম্বর প্রয়োজন';
    else if (form.phoneNumber.trim().length !== 11) validationErrors.value.phoneNumber = 'ফোন নম্বর অবশ্যই ১১ সংখ্যার হতে হবে';
    else if (!/^[0-9]+$/.test(form.phoneNumber.trim())) validationErrors.value.phoneNumber = 'ফোন নম্বরে শুধুমাত্র সংখ্যা থাকবে';
    if (!form.dateOfBirth) validationErrors.value.dateOfBirth = 'জন্মতারিখ প্রয়োজন';
    if (!form.address) validationErrors.value.address = 'ঠিকানা প্রয়োজন';
    if (!form.division) validationErrors.value.division = 'বিভাগ নির্বাচন করুন';
    if (!form.district) validationErrors.value.district = 'জেলা নির্বাচন করুন';
    if (!form.thana) validationErrors.value.thana = 'থানা নির্বাচন করুন';
    if (!form.classmate1) validationErrors.value.classmate1 = 'সহপাঠী ১ এর নাম প্রয়োজন';
    if (!form.classmate2) validationErrors.value.classmate2 = 'সহপাঠী ২ এর নাম প্রয়োজন';
    if (!form.classmate3) validationErrors.value.classmate3 = 'সহপাঠী ৩ এর নাম প্রয়োজন';
    return Object.keys(validationErrors.value).length === 0;
  }
  if (currentStep.value === 2) {
    const hasAnyDepartment =
      form.dept_takmil ||
      form.dept_ifta ||
      form.dept_hifz ||
      form.dept_qirat ||
      form.dept_adab ||
      form.dept_other;
    const isRollNumberValid = !form.examType || form.examType === 'জানা নেই' || form.rollNumber;
    if (!form.examType) validationErrors.value.examType = 'পরীক্ষার ধরন নির্বাচন করুন';
    if (form.examType && form.examType !== 'জানা নেই' && !form.rollNumber) validationErrors.value.rollNumber = 'রোল নাম্বার লিখুন';
    if (!form.idType) validationErrors.value.idType = 'পরিচয়পত্রের ধরন নির্বাচন করুন';
    if (!hasAnyDepartment) validationErrors.value.departments = 'অন্তত একটি বিভাগ নির্বাচন করুন';
    if (form.idType === 'birth') {
      if (!form.birthCertificate) validationErrors.value.birthCertificate = 'জন্মনিবন্ধন নম্বর লিখুন';
      else if (form.birthCertificate.length !== 17) validationErrors.value.birthCertificate = 'জন্মনিবন্ধন নম্বর অবশ্যই ১৭ সংখ্যার হতে হবে';
      else if (!/^[0-9]+$/.test(form.birthCertificate)) validationErrors.value.birthCertificate = 'জন্মনিবন্ধন নম্বরে শুধুমাত্র সংখ্যা থাকবে';
      if (!form.birthCertificatePhoto) validationErrors.value.birthCertificatePhoto = 'জন্মনিবন্ধন ছবি আপলোড করুন';
    }
    if (form.idType === 'voter') {
      if (!form.voterId) validationErrors.value.voterId = 'ভোটার আইডি নম্বর লিখুন';
      else if (form.voterId.length !== 10 && form.voterId.length !== 17) validationErrors.value.voterId = 'ভোটার আইডি নম্বর অবশ্যই ১০ বা ১৭ সংখ্যার হতে হবে';
      else if (!/^[0-9]+$/.test(form.voterId)) validationErrors.value.voterId = 'ভোটার আইডি নম্বরে শুধুমাত্র সংখ্যা থাকবে';
      if (!form.voterIdPhoto) validationErrors.value.voterIdPhoto = 'ভোটার আইডি ছবি আপলোড করুন';
    }
    if (form.idType === 'passport') {
      if (!form.passport_id) validationErrors.value.passport_id = 'পাসপোর্ট নম্বর লিখুন';
      if (!form.passport_photo || 
          (typeof form.passport_photo === 'string' && form.passport_photo.trim() === '') ||
          (typeof form.passport_photo === 'object' && form.passport_photo.size === 0)) {
        validationErrors.value.passport_photo = 'পাসপোর্টের ছবি আপলোড করুন';
      }
    }
    return Object.keys(validationErrors.value).length === 0;
  }
  if (currentStep.value === 3) {
    if (!form.password) validationErrors.value.password = 'পাসওয়ার্ড প্রয়োজন';
    else if (form.password.length < 8) validationErrors.value.password = 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষর হতে হবে';
    if (!form.password_confirmation) validationErrors.value.password_confirmation = 'পাসওয়ার্ড নিশ্চিতকরণ প্রয়োজন';
    else if (form.password !== form.password_confirmation) validationErrors.value.password_confirmation = 'পাসওয়ার্ড মিলছে না';
    return Object.keys(validationErrors.value).length === 0;
  }
  return true;
};

  return {
    validationErrors,
    hasAttemptedValidation,
    validateStep,
  };
}