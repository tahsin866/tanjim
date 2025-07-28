<template>
  <section
    style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
    class="py-16 bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50">

    <div class="container mx-auto px-4">
      <!-- Section Header -->
      <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">
          <i class="pi pi-chart-bar text-emerald-600 mr-3"></i>
          আবনায়ে জামিয়া ফরিদাবাদ পরিসংখ্যান ও তথ্য
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          ক্লাসভিত্তিক ছাত্র রেজিস্ট্রেশন, বছরের উপস্থিতি, এবং আবনা রেজিস্ট্রেশন ও অ্যাপ সংক্রান্ত সকল তথ্য
        </p>
      </div>

      <!-- Statistics Cards + Notice Board Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Notice Board Grid -->
        <div class="lg:col-span-2">
          <Card class="shadow-lg hover:shadow-xl transition-all duration-300 border-0">
            <template #header>
              <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-6 text-white">
                <div class="flex items-center">
                  <Avatar
                    icon="pi pi-bell"
                    class="bg-white/20 text-white mr-4"
                    size="large" />
                  <div>
                    <h3 class="text-2xl font-bold">নোটিস বোর্ড</h3>
                    <p class="text-emerald-100">সর্বশেষ তথ্য, ঘোষণা ও নোটিস</p>
                  </div>
                </div>
              </div>
            </template>
            <template #content>
              <div class="p-6">
                <!-- Notice Board System -->
                <div>
                  <div class="flex items-center justify-between mb-2">
                    <h4 class="text-lg font-bold text-emerald-700 flex items-center">
                      <i class="pi pi-bullhorn mr-2 text-emerald-500"></i> সর্বশেষ নোটিসসমূহ
                    </h4>
                    <Button
                      label="সব নোটিস দেখুন"
                      icon="pi pi-external-link"
                      class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 border-0 px-4 py-2 text-sm font-semibold shadow-sm transition-all duration-200"
                      @click="goToNoticePage"
                    />
                  </div>
                  <div class="notice-board bg-emerald-50 rounded-xl border border-emerald-100 p-4 max-h-72 overflow-y-auto shadow-inner relative">
                    <TransitionGroup name="notice-fade" tag="ul">
                      <li
                        v-for="notice in notices"
                        :key="notice.id"
                        class="flex items-start gap-3 mb-4 bg-white/90 rounded-lg px-4 py-3 shadow group hover:bg-emerald-50 transition-colors duration-200 relative"
                      >
                        <div class="flex-shrink-0 pt-1">
                          <i :class="notice.icon + ' text-emerald-500 text-lg'"></i>
                        </div>
                        <div class="flex-1">
                          <h5 class="font-bold text-emerald-700 mb-1 group-hover:text-teal-700 transition-colors duration-200">
                            {{ notice.title }}
                            <span v-if="notice.isNew" class="ml-2 px-2 py-0.5 bg-gradient-to-r from-emerald-500 to-cyan-400 text-white text-xs rounded-full font-bold animate-pulse">নতুন</span>
                          </h5>
                          <p class="text-gray-700 text-sm font-bangla">{{ notice.body }}</p>
                          <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                            <i class="pi pi-clock"></i>
                            <span>{{ formatDate(notice.date) }}</span>
                            <span v-if="notice.pinned" class="ml-2 px-2 py-0.5 bg-emerald-200 text-emerald-900 rounded-full font-semibold text-xs">Pinned</span>
                          </div>
                          <div v-if="notice.attachment" class="mt-2">
                            <a
                              :href="notice.attachment"
                              target="_blank"
                              class="inline-flex items-center px-2 py-1 text-xs bg-emerald-100 text-emerald-700 rounded hover:bg-emerald-200 transition-colors duration-200"
                            >
                              <i class="pi pi-paperclip mr-1"></i> সংযুক্তি দেখুন
                            </a>
                          </div>
                        </div>
                        <div v-if="notice.urgent" class="absolute top-2 right-2">
                          <i class="pi pi-exclamation-triangle text-red-400 text-xl animate-bounce"></i>
                        </div>
                      </li>
                    </TransitionGroup>
                    <div v-if="notices.length === 0" class="text-center text-gray-400 py-6">
                      <i class="pi pi-info-circle text-2xl"></i> কোন নোটিস নেই
                    </div>
                  </div>
                  <div class="flex items-center gap-3 mt-4">
                    <InputText v-model="noticeSearch" placeholder="নোটিস খুঁজুন..." class="w-full md:w-1/2"/>
                    <Button
                      label="Pinned"
                      icon="pi pi-thumbtack"
                      class="bg-gradient-to-r from-emerald-400 to-teal-400 border-0 px-4 py-2 text-xs font-semibold shadow-sm"
                      @click="showPinned = !showPinned"
                      :outlined="!showPinned"
                    />
                  </div>
                </div>
              </div>
            </template>
          </Card>
        </div>

        <!-- Madrasa Signup Card -->
        <div class="lg:col-span-1">
          <Card class="h-full shadow-lg hover:shadow-xl transition-all duration-300 border-0 bg-gradient-to-br from-white to-emerald-50">
            <template #header>
              <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 p-6 text-white text-center">
                <Avatar
                  icon="pi pi-building"
                  class="bg-white/20 text-white mb-4"
                  size="xlarge" />
                <h3 class="text-2xl font-bold mb-2">আবনা হওয়ার জন্য রেজিস্ট্রেশন</h3>
                <p class="text-emerald-100">সহজ অনলাইন আবেদন</p>
              </div>
            </template>
            <template #content>
              <div class="p-6 text-center">
                <Message
                  severity="info"
                  :closable="false"
                  class="mb-6">
                  <template #messageicon>
                    <i class="pi pi-info-circle"></i>
                  </template>
                  সম্মানিত গ্র্যাজুয়েটগণ, ৭০ সালানা অনুষ্ঠানের সকল আপডেট পেতে এবং ড্যাশবোর্ড সুবিধা নিতে এখনই রেজিস্ট্রেশন করুন।
                </Message>
                <div class="mb-6 text-left">
                  <div class="flex items-center mb-3">
                    <i class="pi pi-check-circle text-emerald-600 mr-3"></i>
                    <span class="text-gray-700">অনলাইনে দ্রুত ফর্ম পূরণ</span>
                  </div>
                  <div class="flex items-center mb-3">
                    <i class="pi pi-check-circle text-emerald-600 mr-3"></i>
                    <span class="text-gray-700">প্রোফাইল/তথ্য হালনাগাদ</span>
                  </div>
                  <div class="flex items-center mb-3">
                    <i class="pi pi-check-circle text-emerald-600 mr-3"></i>
                    <span class="text-gray-700">QR কোডের মাধ্যমে ভেরিফিকেশন</span>
                  </div>
                  <div class="flex items-center">
                    <i class="pi pi-check-circle text-emerald-600 mr-3"></i>
                    <span class="text-gray-700">স্মার্ট ড্যাশবোর্ড সুবিধা</span>
                  </div>
                </div>
                <Button
                  label="রেজিস্ট্রেশন করুন"
                  icon="pi pi-user-plus"
                  iconPos="right"
                  class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 border-0 p-3 text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300"
                  @click="$inertia.visit(route('Register'))" />
              </div>
            </template>
          </Card>
        </div>
      </div>

      <!-- Ulama Slider Title (outside card) + Mobile App Section + Ulama Slider -->
      <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <!-- Mobile App Section -->
        <div>
          <div class="mb-6">
            <h3 class="text-2xl font-bold text-emerald-700 mb-2 flex items-center">
              <i class="pi pi-mobile text-emerald-600 mr-2"></i>
              আবনা মোবাইল অ্যাপ
            </h3>
            <p class="text-gray-700 text-lg mb-4">এখনই ডাউনলোড করুন — অনুষ্ঠান, ছবি, স্মৃতিচারণা, রেজিস্ট্রেশন ও সকল আপডেট পেতে!</p>
            <Button
              label="এপ ডাউনলোড করুন"
              icon="pi pi-download"
              class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-800 hover:to-teal-800 border-0 px-6 py-3 text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300" />
          </div>
          <ul class="space-y-3 text-gray-700">
            <li class="flex items-center">
              <i class="pi pi-check-circle text-emerald-500 mr-3"></i>
              স্মার্ট রেজিস্ট্রেশন ও লগইন
            </li>
            <li class="flex items-center">
              <i class="pi pi-check-circle text-emerald-500 mr-3"></i>
              ছবি, স্মৃতিচারণা, এবং আপডেট গ্যালারি
            </li>
            <li class="flex items-center">
              <i class="pi pi-check-circle text-emerald-500 mr-3"></i>
              QR যাচাইকরণ ও নোটিফিকেশন
            </li>
            <li class="flex items-center">
              <i class="pi pi-check-circle text-emerald-500 mr-3"></i>
              ৭০ সালানা অনুষ্ঠানের সব আপডেট পুশ
            </li>
          </ul>
        </div>
        <!-- Ulama Slider Section (Half Image Card Style) -->
        <div>
          <!-- Ulama Title outside card -->
          <h3 class="text-2xl font-bold text-center text-emerald-800 mb-3 flex items-center justify-center">
            <i class="pi pi-users text-emerald-500 mr-2"></i> আমন্ত্রিত ওলামায়ে কেরাম
          </h3>
          <div class="relative bg-white rounded-md shadow-2xl border-4 border-emerald-100 overflow-hidden ulama-slider-card">
            <div class="relative flex flex-col min-h-[310px]">
              <!-- Half Image (top) -->
              <div class="relative flex justify-center items-center ulama-slider-img-box">
                <img
                  :src="currentUlama.photo"
                  :alt="currentUlama.name"
                  class="ulama-slider-img"
                />
                <!-- Slider Buttons -->
                <button
                  @click="prevUlama"
                  class="absolute left-2 top-1/2 -translate-y-1/2 z-10 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-full p-2 shadow"
                  aria-label="Previous Ulama"
                >
                  <i class="pi pi-chevron-left text-2xl"></i>
                </button>
                <button
                  @click="nextUlama"
                  class="absolute right-2 top-1/2 -translate-y-1/2 z-10 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-full p-2 shadow"
                  aria-label="Next Ulama"
                >
                  <i class="pi pi-chevron-right text-2xl"></i>
                </button>
              </div>
              <!-- Details (bottom) -->
              <div class="ulama-slider-details flex flex-col items-center justify-center px-4 py-4 bg-gradient-to-b from-white/95 via-emerald-50/90 to-teal-50/80 min-h-[100px]">
                <div class="text-lg font-bold text-emerald-800 mb-0.5 font-bangla text-center">{{ currentUlama.name }}</div>
                <div class="text-emerald-600 font-semibold text-xs mb-1 text-center">{{ currentUlama.title }}</div>
                <div class="text-gray-600 font-bangla text-center text-xs">{{ currentUlama.bio }}</div>
                <!-- Slide indicators -->
                <div class="flex justify-center gap-1 mt-4">
                  <span
                    v-for="(ulama, idx) in ulamaList"
                    :key="ulama.name"
                    :class="['inline-block h-2 w-6 rounded-full transition-all duration-300',
                              idx === currentUlamaIndex ? 'bg-emerald-500' : 'bg-emerald-200']"
                  ></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Info Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-14">
        <Card
          v-for="info in additionalInfo"
          :key="info.title"
          class="relative text-center shadow-md hover:shadow-2xl border-0 transition-all duration-300 rounded-2xl overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-teal-50 group"
        >
          <template #content>
            <div class="p-8 relative">
              <!-- Decorative Islamic Motif - Top Right -->
              <svg class="absolute top-0 right-0 w-20 h-16 opacity-10 pointer-events-none" viewBox="0 0 80 40" fill="none">
                <ellipse cx="40" cy="20" rx="38" ry="10" fill="#10b981" fill-opacity="0.14"/>
                <ellipse cx="40" cy="20" rx="27" ry="5" fill="#14b8a6" fill-opacity="0.12"/>
              </svg>
              <!-- Decorative Islamic Motif - Bottom Left -->
              <svg class="absolute bottom-0 left-0 w-20 h-16 opacity-10 pointer-events-none rotate-180" viewBox="0 0 80 40" fill="none">
                <ellipse cx="40" cy="20" rx="38" ry="10" fill="#10b981" fill-opacity="0.14"/>
                <ellipse cx="40" cy="20" rx="27" ry="5" fill="#14b8a6" fill-opacity="0.12"/>
              </svg>
              <div class="flex justify-center mb-4">
                <div class="bg-gradient-to-br from-emerald-200 via-teal-200 to-cyan-100 rounded-full p-2 shadow-lg border-4 border-white group-hover:scale-110 transition-transform duration-300">
                  <Avatar
                    :icon="info.icon"
                    :class="info.avatarClass + ' text-2xl'"
                    size="large"
                  />
                </div>
              </div>
              <h4 class="text-xl font-bold text-emerald-900 mb-2 font-bangla tracking-wide group-hover:text-emerald-700 transition-colors duration-300">
                {{ info.title }}
              </h4>
              <p class="text-gray-600 font-bangla">{{ info.description }}</p>
              <div class="mt-6 h-1 w-2/3 mx-auto rounded-full bg-gradient-to-r from-emerald-400 via-teal-400 to-cyan-400 group-hover:from-emerald-500 group-hover:to-teal-500 transition-all duration-300"></div>
            </div>
          </template>
        </Card>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import Card from 'primevue/card'
import Avatar from 'primevue/avatar'
import Button from 'primevue/button'
import Message from 'primevue/message'
import InputText from 'primevue/inputtext'

// Notice System
const noticesAll = [
  {
    id: 1,
    title: '৭০তম সালানা সম্মেলন সম্পর্কে জরুরি ঘোষণা',
    body: 'সকল গ্র্যাজুয়েটকে রেজিস্ট্রেশন সম্পন্ন করার অনুরোধ করা হচ্ছে।',
    date: '2025-07-22T10:00:00Z',
    icon: 'pi pi-bullhorn',
    pinned: true,
    isNew: true,
    urgent: true,
    attachment: null
  },
  {
    id: 2,
    title: 'অ্যাপ আপডেট',
    body: 'আবনা অ্যাপের নতুন সংস্করণ উন্মুক্ত করা হয়েছে। Play Store থেকে আপডেট করুন।',
    date: '2025-07-20T15:30:00Z',
    icon: 'pi pi-mobile',
    pinned: false,
    isNew: true,
    urgent: false,
    attachment: 'https://abna.app/release-note.pdf'
  },
  {
    id: 3,
    title: 'ডাটাবেজ আপডেট চলবে',
    body: 'আজ রাত ১১টা থেকে ১২টা পর্যন্ত সাইটে সাময়িক সমস্যা হতে পারে।',
    date: '2025-07-19T21:00:00Z',
    icon: 'pi pi-database',
    pinned: true,
    isNew: false,
    urgent: false,
    attachment: null
  },
  {
    id: 4,
    title: 'নতুন ফিচার: QR যাচাইকরণ',
    body: 'প্রতিটি সদস্য নিজের প্রোফাইল থেকে QR যাচাইকরণ করতে পারবেন।',
    date: '2025-07-15T13:45:00Z',
    icon: 'pi pi-qrcode',
    pinned: false,
    isNew: false,
    urgent: false,
    attachment: null
  },
  {
    id: 5,
    title: 'ক্লাসভিত্তিক তথ্য হালনাগাদ',
    body: 'নতুন শিক্ষাবর্ষের ছাত্রদের তথ্য যুক্ত করা হয়েছে।',
    date: '2025-07-10T10:00:00Z',
    icon: 'pi pi-users',
    pinned: false,
    isNew: false,
    urgent: false,
    attachment: null
  }
]

const noticeSearch = ref('')
const showPinned = ref(false)

const notices = computed(() => {
  let filtered = noticesAll
  if (showPinned.value) {
    filtered = filtered.filter(n => n.pinned)
  }
  if (noticeSearch.value) {
    const s = noticeSearch.value.toLowerCase()
    filtered = filtered.filter(n =>
      n.title.toLowerCase().includes(s) ||
      n.body.toLowerCase().includes(s)
    )
  }
  filtered = filtered.slice().sort((a, b) => {
    if (a.pinned && !b.pinned) return -1
    if (!a.pinned && b.pinned) return 1
    return new Date(b.date) - new Date(a.date)
  })
  return filtered
})

function formatDate(dateStr) {
  const d = new Date(dateStr)
  return d.toLocaleDateString('bn-BD', { year: 'numeric', month: 'long', day: 'numeric' }) +
    ' ' + d.toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' })
}
function goToNoticePage() {
  window.location.href = '/notices'
}

// Ulama Slider Data
const ulamaList = [
  {
    name: 'জাস্টিস তাকি উসমানি দা:বা:',
    photo: '/images/Mufti-Muhammad-Taqi-Usmani-scaled.jpg',
    title: 'প্রধান অতিথি, ইসলামি চিন্তাবিদ',
    bio: 'মুফতি আজিজুল হক বাংলাদেশের অন্যতম শীর্ষস্থানীয় ইসলামি ব্যক্তিত্ব। তিনি ইসলামী গবেষণা ও সমাজকল্যাণমূলক কার্যক্রমে অগ্রণী ভূমিকা রেখেছেন।'
  },
  {
    name: 'শায়েখ আওয়ামা',
    photo: '/images/shayekh-awama.jpg',
    title: 'বিশেষ বক্তা, কুরআন গবেষক',
    bio: 'মাওলানা শফিকুর রহমান কুরআন শিক্ষায় বিশেষ অবদান রেখেছেন এবং তরুণদের মাঝে ইসলামী মূল্যবোধ ছড়িয়ে দিচ্ছেন।'
  },
  {
    name: 'হাফেজ মাহমুদুল হাসান',
        photo: '/images/shayekh-sudais.jpeg',
    title: 'সভাপতি, আন্তর্জাতিক হিফজ প্রতিযোগিতা',
    bio: 'হাফেজ সাহেব আন্তর্জাতিক পর্যায়ে কুরআন হিফজ প্রতিযোগিতায় বাংলাদেশের প্রতিনিধিত্ব করেছেন।'
  },
  {
    name: 'মাওলানা মিজানুর রহমান',
       photo: '/images/Mufti-Muhammad-Taqi-Usmani-scaled.jpg',
    title: 'ইসলামি স্কলার ও লেখক',
    bio: 'মাওলানা মিজানুর রহমান বিভিন্ন ইসলামি বইয়ের লেখক ও সমাজ সংস্কারক।'
  }
]
const currentUlamaIndex = ref(0)
const currentUlama = computed(() => ulamaList[currentUlamaIndex.value])

function nextUlama() {
  currentUlamaIndex.value = (currentUlamaIndex.value + 1) % ulamaList.length
}
function prevUlama() {
  currentUlamaIndex.value = (currentUlamaIndex.value - 1 + ulamaList.length) % ulamaList.length
}
// Auto-slide
let autoSlideInterval
onMounted(() => {
  autoSlideInterval = setInterval(() => {
    nextUlama()
  }, 5000)
})
onBeforeUnmount(() => clearInterval(autoSlideInterval))

// Additional info cards data
const additionalInfo = [
  {
    title: 'ড্যাশবোর্ড সুবিধা',
    description: 'আপনার সকল তথ্য, রেজিস্ট্রেশন ও নোটিস এক জায়গায়। স্মার্ট ফিচার ও সহজ ব্যবহার।',
    icon: 'pi pi-th-large',
    avatarClass: 'bg-gradient-to-br from-emerald-500 to-teal-500'
  },
  {
    title: 'ইভেন্ট ও ছবি গ্যালারি',
    description: 'অনুষ্ঠান, আড্ডা, স্মৃতিচারণা ও ছবির ডেডিকেটেড গ্যালারি।',
    icon: 'pi pi-image',
    avatarClass: 'bg-gradient-to-br from-teal-500 to-cyan-500'
  },
  {
    title: 'নিরাপদ তথ্য সংরক্ষণ',
    description: 'আপনার সকল তথ্য নিরাপদভাবে সংরক্ষিত ও গোপনীয় থাকবে।',
    icon: 'pi pi-lock',
    avatarClass: 'bg-gradient-to-br from-cyan-500 to-emerald-500'
  }
]
</script>

<style scoped>
.notice-board {
  background: linear-gradient(135deg, #f0fdfa 60%, #e0f2fe 100%);
  backdrop-filter: blur(2px);
}
.notice-fade-move, .notice-fade-enter-active, .notice-fade-leave-active {
  transition: all 0.4s cubic-bezier(.49,.7,.44,1.09);
}
.notice-fade-enter-from, .notice-fade-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
/* Ulama Slider Half Image Card */
.ulama-slider-card {
  min-height: 310px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  border-radius: 2rem;
  overflow: hidden;
  position: relative;
  background: linear-gradient(135deg, #f0fdfa 70%, #e0f2fe 100%);
}
.ulama-slider-img-box {
  width: 100%;
  height: 110px;
  overflow: hidden;
  position: relative;
  background: linear-gradient(135deg, #d1fae5 60%, #f0fdfa 100%);
  border-bottom-left-radius: 2rem;
  border-bottom-right-radius: 2rem;
  z-index: 1;
}
.ulama-slider-img {
  width: 110px;
  height: 110px;
  object-fit: cover;
  border-radius: 50%;
  border: 4px solid #34d399;
  box-shadow: 0 6px 16px #05966913;
  transition: transform 0.4s cubic-bezier(.49,.7,.44,1.09);
  margin: 0 auto;
  display: block;
  background: #f7fafc;
  position: relative;
  top: 10px;
}
.ulama-slider-details {
  background: linear-gradient(180deg, #fff 60%, #f0fdfa 100%);
  border-bottom-left-radius: 2rem;
  border-bottom-right-radius: 2rem;
  min-height: 100px;
  z-index: 2;
  box-shadow: 0 2px 8px #0596690d;
}
@media (max-width: 640px) {
  .ulama-slider-img-box, .ulama-slider-img {
    height: 70px;
    min-height: 70px;
  }
  .ulama-slider-img {
    width: 70px;
    height: 70px;
    border-width: 3px;
    top: 6px;
  }
  .ulama-slider-details {
    min-height: 85px;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
  }
}
</style>
