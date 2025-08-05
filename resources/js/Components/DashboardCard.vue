<template>
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 transition-all duration-300 hover:shadow-xl hover:scale-105 hover:bg-white/90 dark:hover:bg-gray-800/90">
        <div class="flex items-center justify-between mb-4">
            <div :class="[
                'w-12 h-12 rounded-xl flex items-center justify-center shadow-lg',
                iconBgClass || 'bg-gradient-to-r from-blue-500 to-indigo-600'
            ]">
                <i :class="icon" class="text-xl text-white"></i>
            </div>
            <div v-if="badge" class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 text-xs font-bold rounded-full">
                {{ badge }}
            </div>
        </div>

        <div class="mb-3">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-1">{{ value }}</h3>
            <p class="text-gray-600 dark:text-gray-300 font-medium">{{ title }}</p>
        </div>

        <div v-if="subtitle" class="text-sm text-gray-500 dark:text-gray-400">
            {{ subtitle }}
        </div>

        <div v-if="showTrend && trend" class="flex items-center mt-3 pt-3 border-t border-gray-200/50 dark:border-gray-700/50">
            <i :class="[
                'text-sm mr-2',
                trend > 0 ? 'pi pi-arrow-up text-green-500' : 'pi pi-arrow-down text-red-500'
            ]"></i>
            <span :class="[
                'text-sm font-medium',
                trend > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'
            ]">
                {{ Math.abs(trend) }}% {{ trend > 0 ? 'বৃদ্ধি' : 'হ্রাস' }}
            </span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: [String, Number],
        required: true
    },
    subtitle: {
        type: String,
        default: ''
    },
    icon: {
        type: String,
        required: true
    },
    iconBgClass: {
        type: String,
        default: ''
    },
    badge: {
        type: [String, Number],
        default: null
    },
    trend: {
        type: Number,
        default: null
    },
    showTrend: {
        type: Boolean,
        default: false
    }
})
</script>
