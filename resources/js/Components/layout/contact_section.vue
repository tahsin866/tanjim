<template>
  <section
    style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
    class="py-16 bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 relative overflow-hidden transition-colors duration-300">

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5 pointer-events-none select-none">
      <div class="absolute top-10 left-10 w-32 h-32 bg-emerald-400 rounded-full blur-3xl animate-[float_6s_ease-in-out_infinite]"></div>
      <div class="absolute bottom-10 right-10 w-40 h-40 bg-teal-400 rounded-full blur-3xl animate-[float_7s_ease-in-out_infinite]"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
      <!-- Section Header -->
      <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
          <i class="pi pi-heart text-emerald-600 dark:text-emerald-400 mr-3"></i>
          চ্যারিটি ও দান কার্যক্রম
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          আবনায়ে জামিয়া ফরিদাবাদের পক্ষ থেকে স্বেচ্ছাসেবী ও দানমূলক নানা কার্যক্রমে অংশগ্রহণ করুন
        </p>
      </div>

      <!-- Charity Project Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="(project, index) in charityProjects"
          :key="project.title"
          class="transform hover:scale-[1.03] transition-all duration-500"
          :class="`animate-[fadeInUp_0.6s_ease-out_forwards]`"
          :style="{ animationDelay: `${index * 120}ms` }"
        >
          <Card class="h-full shadow-lg hover:shadow-2xl transition-all duration-500 border-0 overflow-hidden group dark:bg-gray-900/90">
            <template #header>
              <div class="relative">
                <img
                  :src="project.image"
                  :alt="project.title"
                  class="w-full h-52 object-cover rounded-t-xl group-hover:scale-105 transition-transform duration-500"
                />
                <div class="absolute top-2 left-2 bg-emerald-600 text-white text-xs px-3 py-1 rounded-full shadow animate-pulse">
                  {{ project.category }}
                </div>
              </div>
            </template>
            <template #content>
              <div class="p-5 flex flex-col h-full">
                <h3 class="text-xl font-bold text-emerald-800 dark:text-emerald-300 mb-2 font-bangla">{{ project.title }}</h3>
                <p class="text-gray-700 dark:text-gray-200 font-bangla mb-4 flex-1">{{ project.description }}</p>
                <div class="flex items-center justify-between mt-2">
                  <Button
                    :label="project.buttonText"
                    icon="pi pi-handshake"
                    class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 dark:from-emerald-700 dark:to-teal-700 dark:hover:from-emerald-800 dark:hover:to-teal-800 border-0 px-5 py-2 font-semibold shadow group-hover:scale-105 transition-transform duration-300"
                    @click="() => handleCharityAction(project)"
                  />
                  <span class="text-xs text-gray-500 dark:text-gray-400">{{ project.update }}</span>
                </div>
              </div>
            </template>
          </Card>
        </div>
      </div>

      <!-- Quick Actions / Links -->
      <div class="mt-14">
        <h3 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-8 font-bangla">
          <i class="pi pi-link text-emerald-600 dark:text-emerald-400 mr-2"></i>
          আরও কার্যক্রম
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div
            v-for="(link, index) in quickLinks"
            :key="link.title"
            class="relative group transition-all duration-400 transform hover:-translate-y-2"
            :class="`animate-[fadeInUp_0.6s_ease-out_forwards]`"
            :style="{ animationDelay: `${index * 100}ms` }"
          >
            <Card
              class="text-center shadow-xl hover:shadow-2xl transition-all duration-400 border-0 cursor-pointer group rounded-2xl overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-teal-50 dark:from-gray-900 dark:via-gray-800 dark:to-teal-900 border border-emerald-100 dark:border-emerald-900 hover:border-emerald-300 dark:hover:border-emerald-700"
            >
              <template #content>
                <div class="p-6 relative">
                  <!-- Decorative Islamic Motif Top Right -->
                  <svg class="absolute top-0 right-0 w-14 h-10 opacity-10 pointer-events-none" viewBox="0 0 60 24" fill="none">
                    <ellipse cx="30" cy="12" rx="25" ry="6" fill="#10b981" fill-opacity="0.15"/>
                    <ellipse cx="30" cy="12" rx="16" ry="3" fill="#14b8a6" fill-opacity="0.10"/>
                  </svg>
                  <!-- Decorative Motif Bottom Left -->
                  <svg class="absolute bottom-0 left-0 w-14 h-10 opacity-10 pointer-events-none rotate-180" viewBox="0 0 60 24" fill="none">
                    <ellipse cx="30" cy="12" rx="25" ry="6" fill="#10b981" fill-opacity="0.15"/>
                    <ellipse cx="30" cy="12" rx="16" ry="3" fill="#14b8a6" fill-opacity="0.10"/>
                  </svg>
                  <div class="flex justify-center mb-4">
                    <span class="inline-flex items-center justify-center rounded-full p-2 bg-gradient-to-br from-emerald-200 to-teal-100 dark:from-emerald-800 dark:to-teal-900 shadow-lg border-4 border-white dark:border-gray-900 group-hover:scale-110 transition-transform duration-300">
                      <Avatar
                        :icon="link.icon"
                        :class="link.avatarClass + ' text-2xl'"
                        size="large"
                      />
                    </span>
                  </div>
                  <h4 class="text-base font-bold text-emerald-800 dark:text-emerald-300 mb-1 font-bangla tracking-wide group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                    {{ link.title }}
                  </h4>
                  <p v-if="link.description" class="text-xs text-gray-500 dark:text-gray-400 font-bangla mb-2">{{ link.description }}</p>
                  <!-- Bottom border with Islamic color accent -->
                  <div class="mt-4 h-1 w-1/2 mx-auto rounded-full bg-gradient-to-r from-emerald-400 via-teal-400 to-cyan-400 dark:from-emerald-700 dark:via-teal-700 dark:to-cyan-700 group-hover:from-emerald-500 group-hover:to-teal-500 transition-all duration-300"></div>
                </div>
              </template>
            </Card>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import Avatar from 'primevue/avatar'

const charityProjects = ref([
  {
    title: 'বৃক্ষরোপণ কর্মসূচি',
    description: 'পরিবেশ রক্ষায় ও গ্রিন ক্যাম্পাস গড়ে তুলতে বৃক্ষরোপণের উদ্যোগ। চলতি মাসে ২০০টি চারা রোপণ সম্পন্ন হয়েছে।',
    image: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80',
    category: 'পরিবেশ',
    buttonText: 'অংশ নিন',
    update: 'সর্বশেষ আপডেট: জুলাই ২০২৫'
  },
  {
    title: 'শীতার্তদের মাঝে বস্ত্র বিতরণ',
    description: 'শীত মৌসুমে অসহায় ও দরিদ্রদের মাঝে কম্বল ও শীতবস্ত্র বিতরণ করা হচ্ছে। আপনিও অংশ নিতে এবং দান করতে পারেন।',
    image: 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=600&q=80',
    category: 'দাতব্য',
    buttonText: 'দান করুন',
    update: 'সর্বশেষ আপডেট: জানুয়ারি ২০২৫'
  },
  {
    title: 'জামিয়া ফরিদাবাদ ফান্ড',
    description: 'প্রতিষ্ঠানের উন্নয়ন, ছাত্রদের বৃত্তি এবং জরুরী প্রয়োজনে অর্থ সহায়তার জন্য ফান্ড সংগ্রহ চলছে।',
    image: 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=600&q=80',
    category: 'ফান্ডরেইজিং',
    buttonText: 'দান করুন',
    update: 'সর্বশেষ আপডেট: জুলাই ২০২৫'
  },
  {
    title: 'ফাংশনে দান কার্যক্রম',
    description: 'বিভিন্ন মিলাদ, সভা ও ইসলামী অনুষ্ঠানে দানের মাধ্যমে সহযোগিতার সুযোগ।',
    image: 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=600&q=80',
    category: 'অনুষ্ঠান',
    buttonText: 'অংশ নিন',
    update: 'সর্বশেষ আপডেট: জুন ২০২৫'
  }
])

const quickLinks = ref([
  {
    title: 'যোগাযোগ',
    icon: 'pi pi-phone',
    avatarClass: 'bg-green-100 text-green-600 dark:bg-emerald-900 dark:text-emerald-300'
  },
  {
    title: 'সহায়তা',
    icon: 'pi pi-question-circle',
    avatarClass: 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-300'
  },
  {
    title: 'ছবি গ্যালারি',
    icon: 'pi pi-images',
    avatarClass: 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300'
  },
  {
    title: 'স্মৃতিচারণা',
    icon: 'pi pi-pencil',
    avatarClass: 'bg-orange-100 text-orange-600 dark:bg-orange-900 dark:text-orange-300'
  }
])

const handleCharityAction = (project) => {
  alert(`"${project.title}" কার্যক্রমে অংশ নিতে কিংবা দান করতে অফিসে যোগাযোগ করুন অথবা নির্ধারিত ফর্ম পূরণ করুন।`);
}
</script>


