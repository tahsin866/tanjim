<template>
  <section class=" mt-20 relative min-h-screen overflow-hidden bg-black">
    <!-- Background Video/Image Slider -->
    <div class="absolute inset-0">
      <div class="relative w-full h-full">
        <!-- Background Images Carousel -->
        <div
          v-for="(image, index) in backgroundImages"
          :key="index"
          :class="[
            'absolute inset-0 transition-opacity duration-1000',
            currentImageIndex === index ? 'opacity-100' : 'opacity-0'
          ]"
        >
          <!-- <img
            :src="image.url"
            :alt="image.alt"
            class="w-full h-full object-cover"
          /> -->
          <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/70"></div>
        </div>
      </div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 flex items-center min-h-screen">
      <div class="container mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

          <!-- Left Content -->
          <div class="text-white space-y-8">
            <!-- Badge -->
            <div class="inline-flex items-center space-x-2 bg-emerald-600/20 backdrop-blur-sm border border-emerald-500/30 rounded-full px-4 py-2">
              <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
              <span class="text-emerald-300 text-sm font-medium">ইসলামিক শিক্ষা প্রতিষ্ঠান</span>
            </div>

            <!-- Main Title -->
            <div class="space-y-4">
              <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold leading-tight">
                <span class="block text-white">আবনায়ে জামিয়া</span>
                <span class=" mt-3 block bg-gradient-to-r from-emerald-400 to-teal-300 bg-clip-text text-transparent">
                  আরাবিয়া ফরিদাবাদ
                </span>
              </h1>

              <div class="flex items-center space-x-4">
                <div class="h-1 w-20 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full"></div>
                <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></div>
              </div>
            </div>

            <!-- Subtitle -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6">
              <h2 class="text-xl md:text-2xl text-emerald-200 font-semibold">
               শতবর্ষী ইসলামী শিক্ষা প্রতিষ্ঠান
              </h2>
              <p class="text-gray-300 mt-2 text-lg">
                ইসলামিক শিক্ষার আলোয় আলোকিত একটি আধুনিক প্রতিষ্ঠান
              </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
              <button class="group relative px-8 py-4 bg-emerald-600 hover:bg-emerald-700 rounded-xl font-semibold text-white transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                <span class="relative z-10 flex items-center justify-center space-x-2">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 5v10l7-5-7-5z"/>
                  </svg>
                  <span>প্রতিষ্ঠান পরিচিতি</span>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              </button>

              <button class="px-8 py-4 border-2 border-white/30 hover:border-emerald-400 rounded-xl font-semibold text-white hover:text-emerald-400 transition-all duration-300 backdrop-blur-sm hover:bg-white/10">
                আরও জানুন
              </button>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6 pt-8">
              <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-emerald-400">১০০+</div>
                <div class="text-gray-400 text-sm">অধিভুক্ত মাদরাসা</div>
              </div>
              <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-emerald-400">৫০০০+</div>
                <div class="text-gray-400 text-sm">শিক্ষার্থী</div>
              </div>
              <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-emerald-400">২৫+</div>
                <div class="text-gray-400 text-sm">বছরের অভিজ্ঞতা</div>
              </div>
            </div>
          </div>

          <!-- Right Content - Featured Card -->
          <div class="lg:block hidden">
            <div class="relative">
              <!-- Main Featured Card -->
              <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl border border-white/20 rounded-3xl p-8 shadow-2xl">
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

                  <h3 class="text-xl font-bold text-white">
                    আধুনিক ইসলামিক শিক্ষা
                  </h3>

                  <p class="text-gray-300 text-sm leading-relaxed">
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
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-black to-transparent"></div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
      <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
        <div class="w-1 h-3 bg-white/50 rounded-full mt-2 animate-pulse"></div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// Background images data (মসজিদের ছবি)
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

// Auto-change background images
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
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

* {
  font-family: 'Inter', 'SolaimanLipi', sans-serif;
}

/* Custom scrollbar for webkit browsers */
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

/* Smooth animations */
.animate-float {
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-20px);
  }
}

/* Glass morphism effect */
.backdrop-blur-xl {
  backdrop-filter: blur(20px);
}

/* Gradient text animation */
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
