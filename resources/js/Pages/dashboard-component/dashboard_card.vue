<script setup>
const props = defineProps({
  stats: Array
});
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div
      v-for="(stat, index) in stats"
      :key="index"
      class="bg-white dark:bg-gray-900 rounded-lg shadow-sm p-6 border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow duration-300"
    >
      <div class="flex items-center justify-between">
        <div>
          <p class="text-gray-500 dark:text-gray-300 text-sm font-medium mb-1">{{ stat.title }}</p>
          <div class="flex items-center">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ stat.value }}</h3>
            <span
              class="ml-2 text-xs font-medium px-2 py-0.5 rounded-full"
              :class="stat.change.includes('+')
                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'"
            >
              {{ stat.change }}
            </span>
          </div>
          <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">গত মাসের তুলনায়</p>
        </div>
        <div :class="`${stat.color} text-white dark:text-gray-100 p-3 rounded-full`">
          <i :class="`fas fa-${stat.icon} text-xl`"></i>
        </div>
      </div>
    </div>
  </div>
</template>
