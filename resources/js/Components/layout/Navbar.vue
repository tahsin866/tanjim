<template>
  <!-- Fixed Navbar Background Extension (matches hero bg) -->
  <div class="fixed top-0 w-full h-20 bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 z-30"></div>

  <!-- Navbar -->
  <nav
    class="bg-gradient-to-br mt-10 from-emerald-900 via-emerald-800 to-teal-900 fixed top-0 w-full z-40 shadow-2xl border-b border-emerald-700/70 transition-all duration-300"
    style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
  >
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-24 relative">
        <!-- Logo and Brand Section - More Left -->
        <div class="flex items-center space-x-6 relative z-50" style="margin-left: -120px;">
          <div class="relative -my-12">
            <Avatar :image="logoImage" size="xlarge" shape="circle"
              class="bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-700 border-6 border-emerald-400 shadow-2xl hover:shadow-emerald-500/50 transition-all duration-500 hover:scale-110 logo-float logo-glow"
              @error="onImageError"
              style="width: 140px; height: 140px;"
            />
            <div class="absolute inset-0 rounded-full bg-emerald-400 opacity-20 blur-xl animate-pulse"></div>
          </div>
          <div class="flex flex-col mb-5 -ml-4">
            <span class="text-emerald-100 text-4xl md:text-5xl font-bold tracking-wide font-bangla drop-shadow-2xl">
              তানযিমে আবনায়ে ফরিদাবাদ
            </span>
            <span class="text-emerald-300 text-xs font-medium font-bangla">
              ৭০ সালানা আবনায়ে তানজিম সম্মেলন
            </span>
          </div>
        </div>
        <!-- Desktop Navigation - More Right, Keep Button Size -->
        <div class="hidden mb-5 tex-xl lg:flex items-center space-x-4" style="margin-right: -90px;">
          <Button
            label="কোরআন"
            text
            class="text-emerald-100 text-2xl hover:text-white px-7 py-3 font-medium relative group border-b-2 border-transparent hover:border-emerald-300 transition-all duration-300"
            icon="pi pi-book"
            style="font-size: 1.45rem; min-width: 140px;"
          />
          <Button
            :label="'আবনা পেনেল'"
            text
            class="text-emerald-100 hover:text-white px-7 py-3 rounded-lg transition-all duration-300 font-medium relative group border-b-2 border-transparent hover:border-emerald-300"
            icon="pi pi-building"
            style="font-size: 1.45rem; min-width: 170px;"
            @click="$inertia.visit(route('login'))"
          />
          <Button
            label="ডিজিটাল লাইব্রেরী"
            text
            class="text-emerald-100 hover:text-white px-7 py-3 rounded-lg transition-all duration-300 font-medium relative group border-b-2 border-transparent hover:border-emerald-300"
            icon="pi pi-users"
            style="font-size: 1.45rem; min-width: 170px;"
          />
          <Button
            label="অনুদানে পেনেল"
            text
            class="text-emerald-100 hover:text-white px-7 py-3 rounded-lg transition-all duration-300 font-medium relative group border-b-2 border-transparent hover:border-emerald-300"
            icon="pi pi-user"
            style="font-size: 1.45rem; min-width: 170px;"
          />
          <Button
            label="নেয়ামত"
            text
            class="text-white hover:text-emerald-300 px-7 py-3 rounded-lg transition-all duration-300 font-medium relative group border-b-2 border-transparent hover:border-emerald-300 hover:bg-emerald-900"
            icon="pi pi-globe"
            style="font-size: 1.45rem; min-width: 130px;"
          />
        </div>
        <!-- Mobile Menu Button -->
        <div class="lg:hidden">
          <Button @click="mobileMenuOpen = true"
            class="text-emerald-100 hover:text-white hover:bg-emerald-700/50 p-3 rounded-lg transition-all duration-300 border border-emerald-400/50 hover:border-emerald-300"
            icon="pi pi-bars" text />
        </div>
      </div>
    </div>
  </nav>

  <!-- Mobile Sidebar -->
  <Sidebar v-model:visible="mobileMenuOpen" position="right"
    class="w-80 bg-gradient-to-b from-emerald-900 to-teal-950" :showCloseIcon="true">
    <template #header>
      <div class="flex items-center space-x-3 p-4 ">
        <Avatar :image="logoImage" size="large" shape="circle"
          class="bg-emerald-800 border-2 border-emerald-600" />
        <div>
          <h3 class="text-emerald-200 text-xl font-bold font-bangla">তানযিমে আবনায়ে ফরিদাবাদ</h3>
          <p class="text-emerald-400 text-sm font-bangla">Education Management</p>
        </div>
      </div>
    </template>
    <div class="p-4 space-y-3">
      <div class="text-center py-3 bg-emerald-800 rounded-lg mb-4">
        <span class="text-emerald-200 text-sm font-arabic">السلام عليكم ورحمة الله وبركاته</span>
      </div>
      <Button label="বেফাক ইয়ারপি" text
        class="w-full text-left text-emerald-100 hover:text-white hover:bg-emerald-700/50 p-4 rounded-lg transition-all duration-300 justify-start border border-transparent hover:border-emerald-400/30"
        icon="pi pi-book" style="font-size: 1.3rem;" />
      <Button label="মাদরাসা পেনেল" text
        class="w-full text-left text-emerald-100 hover:text-white hover:bg-emerald-700/50 p-4 rounded-lg transition-all duration-300 justify-start border border-transparent hover:border-emerald-400/30"
        icon="pi pi-building" style="font-size: 1.3rem;" @click="$inertia.visit(route('login')); mobileMenuOpen = false" />
      <Button label="শিক্ষক পেনেল" text
        class="w-full text-left text-emerald-100 hover:text-white hover:bg-emerald-700/50 p-4 rounded-lg transition-all duration-300 justify-start border border-transparent hover:border-emerald-400/30"
        icon="pi pi-users" style="font-size: 1.3rem;" />
      <Button label="ছাত্র-ছাত্রী পেনেল" text
        class="w-full text-left text-emerald-100 hover:text-white hover:bg-emerald-700/50 p-4 rounded-lg transition-all duration-300 justify-start border border-transparent hover:border-emerald-400/30"
        icon="pi pi-user" style="font-size: 1.3rem;" />
      <Button label="ওয়েব সাইট" text
        class="w-full text-left text-emerald-100 hover:text-white hover:bg-emerald-700/50 p-4 rounded-lg transition-all duration-300 justify-start border border-transparent hover:border-emerald-400/30"
        icon="pi pi-globe" style="font-size: 1.3rem;" />
      <Divider class="my-4" />
      <div class="mt-8 pt-4 border-t border-emerald-700 text-center">
        <p class="text-emerald-400 text-xs">
          © 2024 WEMS - All Rights Reserved
        </p>
        <p class="text-emerald-500 text-xs mt-1 font-arabic">
          جزاك الله خيرا
        </p>
      </div>
    </div>
  </Sidebar>

  <!-- HERO SECTION -->
  <section
    class=" relative min-h-screen overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900"
  >
    <!-- Decorative calligraphy SVG (Islamic pattern, no gold) -->
    <div class="absolute left-0 top-0 w-full h-full pointer-events-none select-none z-0">
      <svg class="absolute left-0 top-0 w-96 h-96 opacity-10" viewBox="0 0 512 512" fill="none">
        <path d="M256 32C132.3 32 32 132.3 32 256s100.3 224 224 224 224-100.3 224-224S379.7 32 256 32z"
          fill="url(#paint0_radial)" />
        <defs>
          <radialGradient id="paint0_radial" cx="0" cy="0" r="1" gradientTransform="translate(256 256) scale(230)" gradientUnits="userSpaceOnUse">
            <stop stop-color="#10b981" />
            <stop offset="1" stop-color="#134e4a" />
          </radialGradient>
        </defs>
      </svg>
      <svg class="absolute right-0 bottom-0 w-96 h-96 opacity-10 rotate-180" viewBox="0 0 512 512" fill="none">
        <path d="M256 32C132.3 32 32 132.3 32 256s100.3 224 224 224 224-100.3 224-224S379.7 32 256 32z"
          fill="url(#paint1_radial)" />
        <defs>
          <radialGradient id="paint1_radial" cx="0" cy="0" r="1" gradientTransform="translate(256 256) scale(230)" gradientUnits="userSpaceOnUse">
            <stop stop-color="#14b8a6" />
            <stop offset="1" stop-color="#082f49" />
          </radialGradient>
        </defs>
      </svg>
    </div>

    <!-- Background image carousel (with gradient overlay) -->
    <div class="absolute inset-0 z-0">
      <div class="relative w-full h-full">
        <div
          v-for="(image, index) in backgroundImages"
          :key="index"
          :class="[
            'absolute inset-0 transition-opacity duration-1000',
            currentImageIndex === index ? 'opacity-100' : 'opacity-0'
          ]"
        >
          <img
            :src="image.url"
            :alt="image.alt"
            class="w-full h-full object-cover opacity-40"
          />
          <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-emerald-800/70 to-teal-900/90"></div>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="relative z-10 flex items-center min-h-screen">
      <div class="container mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <!-- Left Content -->
          <div class="text-white space-y-8">
            <div class="inline-flex items-center space-x-2 bg-emerald-700/30 backdrop-blur-sm border border-emerald-500/30 rounded-full px-4 py-2 shadow">
              <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
              <span class="text-emerald-300 text-sm font-medium">ইসলামিক শিক্ষা প্রতিষ্ঠান</span>
            </div>

            <div class="space-y-4">
              <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold leading-tight font-bangla drop-shadow-lg">
                <span class="block text-white">আবনায়ে জামিয়া</span>
                <span class="mt-3 block bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-400 bg-clip-text text-transparent">
                  আরাবিয়া ফরিদাবাদ
                </span>
              </h1>
              <div class="flex items-center space-x-4">
                <div class="h-1 w-20 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full"></div>
                <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></div>
              </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-lg">
              <h2 class="text-xl md:text-2xl text-emerald-200 font-semibold font-bangla">
                শতবর্ষী ইসলামী শিক্ষা প্রতিষ্ঠান
              </h2>
              <p class="text-gray-300 mt-2 text-lg font-bangla">
                ইসলামিক শিক্ষার আলোয় আলোকিত একটি আধুনিক প্রতিষ্ঠান
              </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
              <button class="group relative px-8 py-4 bg-emerald-700 hover:bg-teal-700 rounded-xl font-semibold text-white transition-all duration-300 transform hover:scale-105 hover:shadow-2xl ring-1 ring-emerald-500/30">
                <span class="relative z-10 flex items-center justify-center space-x-2">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 5v10l7-5-7-5z"/>
                  </svg>
                  <span>প্রতিষ্ঠান পরিচিতি</span>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-teal-700 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              </button>
              <button class="px-8 py-4 border-2 border-emerald-400/30 hover:border-emerald-500 rounded-xl font-semibold text-white hover:text-emerald-400 transition-all duration-300 backdrop-blur-sm hover:bg-white/10">
                আরও জানুন
              </button>
            </div>
            <div class="grid grid-cols-3 gap-6 pt-8">
              <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-emerald-400">১০০+</div>
                <div class="text-emerald-200 text-sm font-bangla">অধিভুক্ত মাদরাসা</div>
              </div>
              <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-emerald-400">৫০০০+</div>
                <div class="text-emerald-200 text-sm font-bangla">শিক্ষার্থী</div>
              </div>
              <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-emerald-400">২৫+</div>
                <div class="text-emerald-200 text-sm font-bangla">বছরের অভিজ্ঞতা</div>
              </div>
            </div>
          </div>
          <!-- Right Content - Featured Card -->
          <div class="lg:block hidden">
            <div class="relative">
              <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl border border-emerald-400/30 rounded-3xl p-8 shadow-2xl">
                <div class="aspect-video rounded-2xl overflow-hidden mb-6">
                  <img
                    :src="featuredImage"
                    alt="Featured Mosque"
                    class="w-full h-full object-cover"
                  />
                </div>
                <div class="space-y-4">
                  <div class="flex items-center justify-between">
                    <span class="bg-emerald-500/20 text-emerald-300 px-3 py-1 rounded-full text-sm">
                      বৈশিষ্ট্য
                    </span>
                    <div class="flex space-x-1">
                      <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                      <div class="w-2 h-2 bg-emerald-400/50 rounded-full"></div>
                      <div class="w-2 h-2 bg-emerald-400/30 rounded-full"></div>
                    </div>
                  </div>
                  <h3 class="text-xl font-bold text-white font-bangla">
                    আধুনিক ইসলামিক শিক্ষা
                  </h3>
                  <p class="text-gray-300 text-sm leading-relaxed font-bangla">
                    ঐতিহ্যবাহী ইসলামিক শিক্ষার সাথে আধুনিক প্রযুক্তির সমন্বয়ে গড়ে তোলা একটি অনন্য শিক্ষা ব্যবস্থা।
                  </p>
                </div>
              </div>
              <!-- Floating Elements -->
              <div class="absolute -top-4 -right-4 w-24 h-24 bg-emerald-500/20 rounded-full blur-xl"></div>
              <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-teal-500/20 rounded-full blur-xl"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Bottom Gradient -->
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-emerald-900 via-emerald-800 to-transparent"></div>
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-20">
      <div class="w-6 h-10 border-2 border-emerald-300 rounded-full flex justify-center">
        <div class="w-1 h-3 bg-emerald-300 rounded-full mt-2 animate-pulse"></div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import Menubar from 'primevue/menubar'
import Button from 'primevue/button'
import Avatar from 'primevue/avatar'
import Badge from 'primevue/badge'
import Sidebar from 'primevue/sidebar'
import Divider from 'primevue/divider'

const mobileMenuOpen = ref(false)
const logoImage = '/images/tanjim.png'
const onImageError = (event) => {
  event.target.src = '/storage/images/tanjim.png'
}
const backgroundImages = ref([
  {
    url: 'https://images.unsplash.com/photo-1564769662533-4f00a87b4056?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
    alt: 'Beautiful Mosque at Sunset'
  },
  {
    url: 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
    alt: 'Islamic Architecture'
  },
  {
    url: 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
    alt: 'Mosque Interior'
  },
  {
    url: 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
    alt: 'Islamic Calligraphy'
  }
])
const featuredImage = ref('https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')
const currentImageIndex = ref(0)
let imageInterval = null

const startImageRotation = () => {
  imageInterval = setInterval(() => {
    currentImageIndex.value = (currentImageIndex.value + 1) % backgroundImages.value.length
  }, 5000)
}

onMounted(() => {
  startImageRotation()
})

onUnmounted(() => {
  if (imageInterval) {
    clearInterval(imageInterval)
  }
})
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Mukti:wght@400;500;600;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
@import url('https://fonts.maateen.me/kalpurush/font.css');

.font-arabic {
  font-family: 'Amiri', 'Traditional Arabic', serif;
}
.font-bangla {
  font-family: 'Hind Siliguri', 'Kalpurush', 'SolaimanLipi', 'Mukti', 'SutonnyMJ', 'Nikosh', 'Akaash', serif;
  line-height: 1.4;
  letter-spacing: 0.5px;
  font-weight: 500;
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
:global(body) {
  padding-top: 140px;
  background: #0f172a;
}
.logo-glow {
  box-shadow:
    0 0 30px rgba(52, 211, 153, 0.4),
    0 0 60px rgba(52, 211, 153, 0.2),
    inset 0 0 20px rgba(52, 211, 153, 0.1);
}
@keyframes logoFloat {
  0%, 100% { transform: translateY(0px) scale(1); }
  50% { transform: translateY(-3px) scale(1.02); }
}
.logo-float {
  animation: logoFloat 4s ease-in-out infinite;
}
.font-bangla.text-white {
  text-shadow:
    2px 2px 4px rgba(0, 0, 0, 0.5),
    0 0 10px rgba(52, 211, 153, 0.3);
}
@keyframes textGlow {
  0%, 100% {
    text-shadow:
      2px 2px 4px rgba(0, 0, 0, 0.5),
      0 0 10px rgba(52, 211, 153, 0.3);
  }
  50% {
    text-shadow:
      2px 2px 4px rgba(0, 0, 0, 0.7),
      0 0 15px rgba(52, 211, 153, 0.5),
      0 0 20px rgba(52, 211, 153, 0.2);
  }
}
.font-bangla:hover {
  animation: textGlow 2s ease-in-out infinite;
}
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.1);
}
::-webkit-scrollbar-thumb {
  background: rgba(16, 185, 129, 0.5);
  border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
  background: rgba(16, 185, 129, 0.7);
}
.backdrop-blur-xl {
  backdrop-filter: blur(20px);
}
@keyframes gradient {
  0%, 100% {
    background-size: 200% 200%;
    background-position: left center;
  }
  50% {
    background-size: 200% 200%;
    background-position: right center;
  }
}
.bg-gradient-to-r {
  animation: gradient 3s ease infinite;
}
</style>
