
<template>
  <section
  style="font-family: 'SolaimanLipi', sans-serif;"

  class="py-16 bg-white dark:bg-gray-900 transition-colors duration-300">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
          <i class="pi pi-hand-heart text-teal-600 dark:text-teal-400 mr-3"></i>
         সামাজিক কার্যক্রম
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
        তানযীমে আবনায়ে জামিয়া আরাবিয়া ফরিদাবাদের পক্ষ থেকে স্বেচ্ছাসেবী ও জামাজিক নানা কার্যক্রমে অংশগ্রহণ করুন।
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="(project, index) in charityProjects" :key="project.title" class="transform hover:scale-[1.03] transition-all duration-500 animate-fadeInUp" :style="{ animationDelay: `${index * 120}ms` }">
          <Card class="h-full shadow-lg hover:shadow-xl transition-all duration-500 rounded-xl overflow-hidden group dark:bg-gray-800 border dark:border-gray-700">
            <template #header>
              <div class="relative overflow-hidden">
                <img :src="project.image" :alt="project.title" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500" />
                <div class="absolute top-4 left-4 bg-teal-600 text-white text-xs px-3 py-1 rounded-full shadow-md animate-pulse">
                  {{ project.category }}
                </div>
              </div>
            </template>
            <template #content>
              <div class="p-5 flex flex-col h-full">
                <h3 class="text-2xl font-bold text-teal-800 dark:text-teal-300 mb-3">{{ project.title }}</h3>
                <p class="text-gray-700 dark:text-gray-200 mb-4 flex-1">{{ project.description }}</p>
                <div class="flex items-center justify-between mt-2">
                  <Button :label="project.buttonText" icon="pi pi-handshake" class="bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white border-0 px-5 py-2 font-semibold shadow-md rounded-full group-hover:scale-105 transition-transform duration-300" @click="() => handleCharityAction(project)" />
                  <span class="text-sm text-gray-500 dark:text-gray-400">{{ project.update }}</span>
                </div>
              </div>
            </template>
          </Card>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';

const charityProjects = ref([
  {
    title: 'বৃক্ষরোপণ কর্মসূচি',
    description: 'পরিবেশ রক্ষায় ও গ্রিন ক্যাম্পাস গড়ে তুলতে বৃক্ষরোপণের উদ্যোগ। চলতি মাসে ২০০টি চারা রোপণ সম্পন্ন হয়েছে।',
    image: '/images/plant.jpg',
    category: 'পরিবেশ',
    buttonText: 'অংশ নিন',
    update: 'সর্বশেষ আপডেট: জুলাই ২০২৫'
  },
  {
    title: 'শীতার্তদের মাঝে বস্ত্র বিতরণ',
    description: 'শীত মৌসুমে অসহায় ও দরিদ্রদের মাঝে কম্বল ও শীতবস্ত্র বিতরণ করা হচ্ছে। আপনিও অংশ নিতে এবং দান করতে পারেন।',
    image: '/images/ChatGPT Image Aug 5, 2025, 04_36_35 PM.png',
    category: 'দাতব্য',
    buttonText: 'দান করুন',
    update: 'সর্বশেষ আপডেট: জানুয়ারি ২০২৫'
  },
  {
    title: 'জামিয়া ফরিদাবাদ ফান্ড',
    description: 'প্রতিষ্ঠানের উন্নয়ন, ছাত্রদের বৃত্তি এবং জরুরী প্রয়োজনে অর্থ সহায়তার জন্য ফান্ড সংগ্রহ চলছে।',
    image: '/images/fund-of-fund.jpg',
    category: 'ফান্ডরেইজিং',
    buttonText: 'দান করুন',
    update: 'সর্বশেষ আপডেট: জুলাই ২০২৫'
  },
  {
    title: 'আবনা সম্মেলন দস্তরবন্দী',
    description: 'আবনা সম্মেলন, ইসলাহী ইজতেমা,জেলা ও বিভাগীয় আবনা সম্মেলনে দানের মাধ্যমে অংশগ্রহণ।',
    image: '/images/graduation.jpg',
    category: 'অনুষ্ঠান',
    buttonText: 'অংশ নিন',
    update: 'সর্বশেষ আপডেট: জুন ২০২৫'
  }
]);

const handleCharityAction = (project) => {
  alert(`"${project.title}" কার্যক্রমে অংশ নিতে কিংবা দান করতে অফিসে যোগাযোগ করুন অথবা নির্ধারিত ফর্ম পূরণ করুন।`);
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Noto+Sans+Bengali:wght@400;700&display=swap');

.font-bangla {
  font-family: 'Noto Sans Bengali', sans-serif;
}

h2, h3 {
  font-family: 'Merriweather', 'Noto Sans Bengali', serif;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeInUp {
  animation: fadeInUp 0.6s ease-out forwards;
}
</style>
```
