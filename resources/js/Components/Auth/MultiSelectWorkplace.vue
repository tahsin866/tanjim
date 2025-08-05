<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
  modelValue: {
    type: Array,
    default: () => []
  }
});

const emit = defineEmits(['update:modelValue']);

const selectedOptions = ref(props.modelValue || []);
const showDropdown = ref(false);

const options = [
  { value: "শাইখুল হাদিস", label: "শাইখুল হাদিস" },
  { value: "প্রধান মুফতি", label: "প্রধান মুফতি" },
  { value: "মুঈনে মুফতি", label: "মুঈনে মুফতি" },
  { value: "সাংবাদিক", label: "সাংবাদিক" },
  { value: "লেখক", label: "লেখক" },
  { value: "আদীব", label: "আদীব" },
  { value: "মাদরাসা শিক্ষক", label: "মাদরাসা শিক্ষক" },
  { value: "ইমাম", label: "ইমাম" },
  { value: "খতিব", label: "খতিব" },
  { value: "মুয়াজ্জিন", label: "মুয়াজ্জিন" },
  { value: "মসজিদের খাদেম", label: "মসজিদের খাদেম" },
  { value: "মুহতামিম", label: "মুহতামিম" },
  { value: "ব্যবসায়ী", label: "ব্যবসায়ী" },
  { value: "প্রবাসি", label: "প্রবাসি" },
  { value: "চাকুরিজীবি", label: "চাকুরিজীবি" },
  { value: "বক্তা", label: "বক্তা" },
  { value: "অন্যান্য", label: "অন্যান্য" }
];

const toggleOption = (option) => {
  const index = selectedOptions.value.indexOf(option.value);
  if (index === -1) {
    selectedOptions.value.push(option.value);
  } else {
    selectedOptions.value.splice(index, 1);
  }
  emit('update:modelValue', selectedOptions.value);
};

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value;
};

const closeDropdown = () => {
  showDropdown.value = false;
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
  const dropdown = document.getElementById('workplace-dropdown');
  if (dropdown && !dropdown.contains(event.target)) {
    closeDropdown();
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

watch(() => props.modelValue, (newValue) => {
  selectedOptions.value = newValue || [];
}, { deep: true });
</script>

<template>
  <div id="workplace-dropdown" class="relative">
    <div @click="toggleDropdown"
      class="cursor-pointer mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border flex justify-between items-center">
      <div class="flex flex-wrap gap-1">
        <span v-if="selectedOptions.length === 0" class="text-gray-500 dark:text-gray-400">নির্বাচন করুন</span>
        <div v-for="(option, index) in selectedOptions" :key="index"
          class="bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 rounded px-2 py-0.5 text-sm flex items-center">
          {{ option }}
          <button type="button" @click.stop="toggleOption({value: option})"
            class="ml-1 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
          clip-rule="evenodd" />
      </svg>
    </div>
    <div v-show="showDropdown"
      class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 shadow-lg rounded-md border border-gray-300 dark:border-gray-700 max-h-60 overflow-y-auto">
      <div v-for="option in options" :key="option.value" @click="toggleOption(option)"
        class="p-2 cursor-pointer hover:bg-indigo-50 dark:hover:bg-gray-700 flex items-center">
        <input type="checkbox" :checked="selectedOptions.includes(option.value)" class="mr-2 h-4 w-4 text-indigo-600 border-gray-300 rounded">
        <span>{{ option.label }}</span>
      </div>
    </div>
  </div>
</template>
