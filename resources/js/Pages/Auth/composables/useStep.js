import { ref, computed } from 'vue';

export function useStep(form) {
  const currentStep = ref(1);
  const totalSteps = 3;
  const progressPercentage = computed(() => Math.round((currentStep.value / totalSteps) * 100));

  // Step items definition (should always have at least one element)
  const stepItems = [
    { label: 'ব্যক্তিগত তথ্য', icon: 'pi pi-user', description: 'আপনার ব্যক্তিগত তথ্য দিন' },
    { label: 'শিক্ষাগত তথ্য', icon: 'pi pi-book', description: 'শিক্ষাগত যোগ্যতা ও বিভাগ' },
    { label: 'নিরাপত্তা ও অতিরিক্ত', icon: 'pi pi-shield', description: 'পাসওয়ার্ড ও অন্যান্য তথ্য' }
  ];

  // Responsive icon size
  const windowWidth = ref(typeof window !== "undefined" ? window.innerWidth : 1280);
  const stepIconSize = computed(() => windowWidth.value < 400 ? '1.2rem' : windowWidth.value < 700 ? '1.5rem' : '2rem');
  if (typeof window !== "undefined") {
    window.addEventListener("resize", () => {
      windowWidth.value = window.innerWidth;
    });
  }

  // Completion status and percentage
  const stepCompletionStatus = computed(() => {
    const step1Complete = form.fullNameBangla && form.fullNameEnglish && form.fatherName && form.email && form.phoneNumber && form.dateOfBirth && form.classmate1 && form.classmate2 && form.classmate3;
    const isRollNumberValid = !form.examType || form.examType === 'জানা নেই' || form.rollNumber;
    const step2Complete = (form.dept_takmil || form.dept_ifta || form.dept_hifz || form.dept_qirat || form.dept_adab || form.dept_other) &&
                          form.examType && isRollNumberValid && form.idType;
    const step3Complete = form.password && form.password_confirmation;
    return {
      1: step1Complete,
      2: step2Complete && step1Complete,
      3: step3Complete && step2Complete && step1Complete
    };
  });
  const stepCompletionPercentage = computed(() => {
    const step1Fields = ['fullNameBangla', 'fullNameEnglish', 'fatherName', 'email', 'phoneNumber', 'dateOfBirth', 'address', 'division', 'district', 'thana', 'classmate1', 'classmate2', 'classmate3'];
    let step2Fields = ['examType', 'idType'];
    if (form.examType && form.examType !== 'জানা নেই') {
      step2Fields.push('rollNumber');
    }
    const step3Fields = ['password', 'password_confirmation'];
    const getFieldsCompletion = (fields) => {
      const completed = fields.filter(field => form[field] && form[field] !== '').length;
      return Math.round((completed / fields.length) * 100);
    };
    const deptCompletion = (form.dept_takmil || form.dept_ifta || form.dept_hifz || form.dept_qirat || form.dept_adab || form.dept_other) ? 100 : 0;
    return {
      1: getFieldsCompletion(step1Fields),
      2: Math.round((getFieldsCompletion(step2Fields) + deptCompletion) / 2),
      3: getFieldsCompletion(step3Fields)
    };
  });

  return {
    currentStep,
    totalSteps,
    progressPercentage,
    stepItems,
    windowWidth,
    stepIconSize,
    stepCompletionStatus,
    stepCompletionPercentage
  };

  return {
    currentStep,
    totalSteps,
    progressPercentage,
    // ...other step related refs/computeds
  };
}