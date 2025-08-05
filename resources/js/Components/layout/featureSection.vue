
<template>
  <section
  style=" font-family: 'SolaimanLipi', sans-serif;"

  class="py-16 px-4 bg-white dark:bg-gray-950 transition-colors duration-300 ">

    <div class="container mx-auto max-w-8xl">
      <div class="relative rounded-2xl shadow-2xl overflow-hidden
                  bg-gradient-to-br from-gray-50 via-gray-100 to-gray-50
                  dark:from-gray-900/90 dark:via-gray-900/95 dark:to-gray-900/90
                  ring-1 ring-gray-200 dark:ring-gray-800">

        <div class="px-8 py-6 md:px-12 md:py-8
                    bg-gradient-to-r from-teal-600 to-cyan-700
                    dark:from-teal-800 dark:to-cyan-900 text-white flex flex-col md:flex-row items-center justify-between gap-6">
          <div class="flex items-center gap-4 text-center md:text-left">
            <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/10 shadow-lg shrink-0">
              <i class="pi pi-bell text-3xl"></i>
            </span>
            <div>
              <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-1">
                আবনায়ে জামিয়া ফরিদাবাদ
              </h2>
              <p class="text-sm sm:text-base text-teal-100">
                ৭০ সালানা সম্মেলন • নোটিস ও ডিজিটাল সুবিধা
              </p>
            </div>
          </div>
          <div class="flex flex-wrap justify-center gap-3">
            <a href="#" class="inline-flex items-center px-6 py-3 bg-black text-white rounded-full hover:bg-gray-800 transition-colors shadow-lg">
              <i class="pi pi-android text-xl mr-2"></i>
              <span class="text-sm font-semibold">Google Play</span>
            </a>
            <a href="#" class="inline-flex items-center px-6 py-3 bg-black text-white rounded-full hover:bg-gray-800 transition-colors shadow-lg">
              <i class="pi pi-apple text-xl mr-2"></i>
              <span class="text-sm font-semibold">App Store</span>
            </a>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-0">

          <div class="p-8 md:p-10 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-800">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
              <i class="pi pi-list text-teal-600 dark:text-teal-400"></i> নোটিস বোর্ড
            </h3>

            <div class="flex flex-col sm:flex-row gap-4 mb-6">
              <div class="relative flex-1">
                <i class="pi pi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                <InputText
                  v-model="noticeSearch"
                  placeholder="নোটিস খুঁজুন..."
                  class="w-full pl-12 pr-4 py-3 rounded-full border-2 border-gray-200 focus:border-teal-400 dark:bg-gray-800 dark:text-white dark:border-gray-700 dark:placeholder-gray-500 transition-colors"
                />
              </div>
              <Button
                :label="showPinned ? 'সব নোটিস' : 'Pinned'"
                :icon="showPinned ? 'pi pi-list' : 'pi pi-thumbtack'"
                :class="[
                  'rounded-full px-6 py-3 text-sm font-semibold transition-all duration-300 shadow',
                  showPinned
                    ? 'bg-gradient-to-r from-teal-500 to-cyan-500 text-white border-0'
                    : 'bg-white dark:bg-gray-800 text-teal-600 dark:text-teal-400 border-2 border-teal-200 dark:border-teal-600'
                ]"
                @click="showPinned = !showPinned"
              />
            </div>

            <div class="space-y-4">
              <TransitionGroup name="fade">
                <div
                  v-for="notice in notices"
                  :key="notice.id"
                  class="flex items-start gap-4 p-4 rounded-xl shadow-md border border-gray-200 dark:border-gray-700
                         bg-white dark:bg-gray-800 hover:shadow-lg hover:border-teal-400 dark:hover:border-teal-600 transition-all duration-300"
                >
                  <div class="w-10 h-10 rounded-full bg-teal-100 dark:bg-teal-900 flex items-center justify-center shrink-0">
                    <i :class="notice.icon + ' text-teal-600 dark:text-teal-300 text-lg'"></i>
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="flex items-center flex-wrap gap-2 mb-1">
                      <h4 class="font-bold text-base text-gray-800 dark:text-gray-100">{{ notice.title }}</h4>
                      <span v-if="notice.isNew" class="px-2 py-0.5 bg-green-500 text-white text-xs rounded-full font-bold animate-pulse">নতুন</span>
                      <span v-if="notice.pinned" class="px-2 py-0.5 bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 text-xs rounded-full font-semibold">
                        <i class="pi pi-thumbtack"></i> পিনড
                      </span>
                      <span v-if="notice.urgent" class="px-2 py-0.5 bg-red-500 text-white text-xs rounded-full font-bold animate-pulse">জরুরি</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ notice.body }}</p>
                    <div class="flex justify-between items-center mt-2">
                      <span class="text-xs text-gray-500 dark:text-gray-500">
                        <i class="pi pi-clock mr-1"></i>
                        {{ formatDate(notice.date) }}
                      </span>
                      <a v-if="notice.attachment" :href="notice.attachment" target="_blank" class="inline-flex items-center text-xs text-teal-600 dark:text-teal-300 hover:text-teal-800 dark:hover:text-teal-100 font-semibold transition-colors">
                        <i class="pi pi-paperclip mr-1"></i> সংযুক্তি
                      </a>
                    </div>
                  </div>
                </div>
              </TransitionGroup>
              <div v-if="notices.length === 0" class="text-center text-gray-400 dark:text-gray-600 py-6">
                <i class="pi pi-info-circle text-2xl mb-2"></i>
                <p>কোন নোটিস পাওয়া যায়নি।</p>
              </div>
            </div>

            <div class="mt-8 text-center">
              <Button label="সব নোটিস দেখুন" icon="pi pi-arrow-right" iconPos="right" class="px-8 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold rounded-full shadow-lg transition-all" @click="goToNoticePage" />
            </div>
          </div>

          <div class="p-8 md:p-10 flex flex-col justify-center">
            <div class="text-center mb-8">
              <div class="inline-block p-3 rounded-full bg-teal-100 dark:bg-teal-900 shadow-md mb-3">
                <i class="pi pi-mobile text-3xl text-teal-700 dark:text-teal-300"></i>
              </div>
              <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">আবনা মোবাইল অ্যাপ</h3>
              <p class="text-gray-600 dark:text-gray-400 max-w-sm mx-auto">
                ডিজিটাল স্মার্ট রেজিস্ট্রেশন, QR যাচাইকরণ, ছবি ও আপডেট - সব এক অ্যাপে!
              </p>
            </div>

            <div class="space-y-4 max-w-sm mx-auto w-full">
              <div v-for="(feature, index) in appFeatures" :key="index" class="flex items-center p-3 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700
                  bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" :class="feature.bgClass">
                  <i :class="feature.iconClass + ' text-base'"></i>
                </div>
                <span class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ feature.text }}</span>
              </div>
            </div>

            <div class="mt-8 text-center">
              <Button label="অ্যাপ ডাউনলোড করুন" icon="pi pi-download" iconPos="right" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-full shadow-lg transition-all" />
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

const noticesAll = [
  { id: 1, title: '৭০তম সালানা সম্মেলন সম্পর্কে জরুরি ঘোষণা', body: 'সকল আবনায়ে ফরিদাবাদদার অনুরোধ করা যাচ্ছে যে নতুন সফটয়্যারের জন্য পরীক্ষামুল ভাবে নিবন্ধন কার্যক্রম শুরু করা হয়েছে । নির্ধারিত সময়ের মধ্যে সকল প্রয়োজনীয় তথ্য প্রদান করুন।', date: '2025-08-02T08:00:00Z', icon: 'pi pi-bullhorn', pinned: true, isNew: true, urgent: true, attachment: null },
  { id: 2, title: 'আবনা মোবাইল অ্যাপ আপডেট', body: 'আবনা অ্যাপের নতুন সংস্করণ উন্মুক্ত করা হয়েছে। নতুন ফিচার ও উন্নত পারফরমেন্সের জন্য Play Store থেকে আপডেট করুন।', date: '2025-08-01T15:30:00Z', icon: 'pi pi-mobile', pinned: false, isNew: true, urgent: false, attachment: 'https://abna.app/release-note.pdf' },
  { id: 3, title: 'সিস্টেম রক্ষণাবেক্ষণ নোটিস', body: 'আজ রাত ১১টা থেকে ১২টা পর্যন্ত ডাটাবেজ আপডেটের কারণে সাইটে সাময়িক সমস্যা হতে পারে। অসুবিধার জন্য দুঃখিত।', date: '2025-07-29T21:00:00Z', icon: 'pi pi-database', pinned: true, isNew: false, urgent: false, attachment: null },
  { id: 4, title: 'নতুন ফিচার: QR যাচাইকরণ সিস্টেম', body: 'প্রতিটি সদস্য এখন নিজের প্রোফাইল থেকে QR যাচাইকরণ করতে পারবেন। এটি নিরাপত্তা বৃদ্ধি করবে।', date: '2025-07-25T13:45:00Z', icon: 'pi pi-qrcode', pinned: false, isNew: false, urgent: false, attachment: null },
  { id: 5, title: 'অনুষ্ঠানের সময়সূচী প্রকাশ', body: '৭০ সালানা সম্মেলনের বিস্তারিত সময়সূচী এবং অনুষ্ঠানমালা প্রকাশ করা হয়েছে। সকলে দেখে নিন।', date: '2025-07-20T10:00:00Z', icon: 'pi pi-calendar', pinned: false, isNew: false, urgent: false, attachment: 'https://abna.app/schedule.pdf' }
];

const appFeatures = ref([
  { text: 'স্মার্ট রেজিস্ট্রেশন ও লগইন', iconClass: 'pi pi-user-plus', bgClass: 'bg-teal-100 text-teal-600 dark:bg-teal-900 dark:text-teal-300' },
  { text: 'ছবি ও স্মৃতিচারণা', iconClass: 'pi pi-images', bgClass: 'bg-cyan-100 text-cyan-600 dark:bg-cyan-900 dark:text-cyan-300' },
  { text: 'QR যাচাইকরণ ও নোটিফিকেশন', iconClass: 'pi pi-qrcode', bgClass: 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-300' },
  { text: 'অনুষ্ঠানের সব আপডেট', iconClass: 'pi pi-calendar', bgClass: 'bg-orange-100 text-orange-600 dark:bg-orange-900 dark:text-orange-300' }
]);

const noticeSearch = ref('');
const showPinned = ref(true);

const notices = computed(() => {
  let filtered = noticesAll;
  if (showPinned.value) {
    filtered = filtered.filter(n => n.pinned);
  }
  if (noticeSearch.value) {
    const s = noticeSearch.value.toLowerCase();
    filtered = filtered.filter(n =>
      n.title.toLowerCase().includes(s) || n.body.toLowerCase().includes(s)
    );
  }
  return filtered.slice().sort((a, b) => {
    if (a.pinned && !b.pinned) return -1;
    if (!a.pinned && b.pinned) return 1;
    return new Date(b.date) - new Date(a.date);
  });
});

function formatDate(dateStr) {
  const d = new Date(dateStr);
  return d.toLocaleDateString('bn-BD', { year: 'numeric', month: 'long', day: 'numeric' }) +
    ' ' + d.toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' });
}

function goToNoticePage() {
  alert("সব নোটিস দেখতে নতুন একটি পাতায় নিয়ে যাওয়া হবে।");
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;700&display=swap');

.font-bangla {
  font-family: 'Noto Sans Bengali', sans-serif !important;
}

h2, h3, h4 {
  font-family: 'Noto Sans Bengali', sans-serif;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
```
