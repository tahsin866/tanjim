<script setup lang="ts">
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const notices = ref([
  {
    id: 1,
    title: 'মাসিক পরীক্ষার নোটিশ',
    priority: 'high',
    description: 'আগামী ১০ জুলাই থেকে মাসিক পরীক্ষা শুরু হবে। সকল ছাত্রদের উপস্থিত থাকার জন্য অনুরোধ করা হলো।',
    date: '০৫ জুলাই ২০২৩',
    author: 'প্রধান শিক্ষক'
  },
  {
    id: 2,
    title: 'বার্ষিক ক্রীড়া প্রতিযোগিতা',
    priority: 'normal',
    description: 'বার্ষিক ক্রীড়া প্রতিযোগিতা আগামী ১৫ জুলাই অনুষ্ঠিত হবে।',
    date: '০৩ জুলাই ২০২৩',
    author: 'ক্রীড়া শিক্ষক'
  },
  // Add more notices as needed
]);


</script>

<template>
   <AuthenticatedLayout>
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-sm shadow-lg overflow-hidden mx-5 mt-5">
        <div class="p-6 border-b border-emerald-100">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-emerald-800 dark:text-emerald-200 flex items-center gap-2">
                    <i class="fas fa-bullhorn"></i>
                    নোটিশ বোর্ড
                </h3>
                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-sm text-sm font-medium transition-all">
                        <i class="fas fa-filter mr-2"></i>ফিল্টার
                    </button>

                </div>
            </div>
        </div>

        <!-- Notice Search and Categories -->
        <div class="p-4 bg-emerald-50 border-b border-emerald-100">
            <div class="flex gap-4 flex-wrap">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" placeholder="নোটিশ খুঁজুন..." class="w-full pl-10 pr-4 py-2 rounded-sm border border-emerald-200 focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                        <i class="fas fa-search absolute left-3 top-3 text-emerald-400"></i>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 rounded-sm bg-emerald-600 text-white hover:bg-emerald-700 transition-all">সকল</button>
                    <button class="px-4 py-2 rounded-sm bg-white text-emerald-700 hover:bg-emerald-50 transition-all">একাডেমিক</button>
                    <button class="px-4 py-2 rounded-sm bg-white text-emerald-700 hover:bg-emerald-50 transition-all">প্রশাসনিক</button>
                </div>
            </div>
        </div>

        <!-- Notice List -->
        <div class="divide-y divide-emerald-100">
            <div v-for="notice in notices" key="notice.id" class="p-6 hover:bg-emerald-50 transition-all">
                <div class="flex items-start gap-4">
                    <div class="bg-emerald-100 rounded-lg p-3 text-emerald-600">
                        <i class="fas fa-file-alt text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h4 class="font-semibold text-lg text-emerald-800">{{ notice.title }}</h4>
                            <span class="px-3 py-1 text-xs font-medium rounded-full"
                                  :class="notice.priority === 'high' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700'">
                                {{ notice.priority }}
                            </span>
                        </div>
                        <p class="text-gray-600 mt-2">{{ notice.description }}</p>
                        <div class="flex items-center gap-4 mt-4">
                            <span class="text-sm text-gray-500">
                                <i class="far fa-clock mr-1"></i>{{ notice.date }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="far fa-user mr-1"></i>{{ notice.author }}
                            </span>
                            <div class="flex-1 text-right">
                                <button class="text-emerald-600 hover:text-emerald-700 transition-all">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </AuthenticatedLayout>
</template>
