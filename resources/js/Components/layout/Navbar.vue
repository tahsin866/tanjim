<template>
    <!-- Enhanced Seamless Navbar -->
    <nav :class="[
        'fixed top-0 w-full z-50 transition-all duration-300 ease-in-out border-b',
        scrolled ? 'bg-gradient-to-br from-emerald-900/95 via-emerald-800/95 to-teal-900/95 backdrop-blur-xl border-emerald-700/50' : 'bg-gradient-to-br from-emerald-900/20 via-emerald-800/20 to-teal-900/20 backdrop-blur-sm border-transparent'
    ]" style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;">
        <div class="container mx-auto px-4 mt-10">
            <!-- Mobile Layout -->
            <div v-if="windowWidth < 1024" class="flex flex-col items-center py-4 space-y-4">
                <div class="flex items-center justify-between w-full">
                    <div class="w-12"></div>
                    <div class="flex flex-col items-center">
                        <Avatar :image="logoImage" shape="circle"
                                class="bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-700 border-4 border-emerald-400 shadow-2xl hover:shadow-emerald-500/50 transition-all duration-500 hover:scale-110 mb-2"
                                @error="onImageError"
                                :style="{
                                    width: windowWidth < 640 ? '60px' : '80px',
                                    height: windowWidth < 640 ? '60px' : '80px'
                                }" />
                        <div class="text-center">
                            <div class="text-white font-bold font-bangla" :style="{
                                fontSize: windowWidth < 640 ? '1.1rem' : '1.4rem',
                                lineHeight: 1.2
                            }">
                                তানযীমে আবনায়ে জামিয়া ফরিদাবাদ
                            </div>
                            <div class="text-emerald-300 font-medium font-bangla mt-1" :style="{
                                fontSize: windowWidth < 640 ? '0.8rem' : '1rem',
                                lineHeight: 1.1
                            }">
                                ৭০ সালানা দস্তরবিন্দি সম্মেলন
                            </div>
                        </div>
                    </div>
                    <Button @click="mobileMenuOpen = true"
                        class="text-white hover:text-white hover:bg-emerald-700/50 p-3 rounded-lg transition-all duration-300 border border-emerald-400/50 hover:border-emerald-300"
                        icon="pi pi-bars" text />
                </div>
            </div>

            <!-- Desktop Layout -->
            <div v-else class="flex items-center justify-between h-24 relative">
                <div class="flex items-center">
                    <Avatar :image="logoImage" shape="circle"
                            class="bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-700 border-6 border-emerald-400 shadow-2xl hover:shadow-emerald-500/50 transition-all duration-500 hover:scale-110 mr-6"
                            @error="onImageError" style="width: 160px; height: 160px;" />
                    <div class="flex flex-col justify-center">
                        <span class="text-white font-bold font-bangla text-3xl leading-tight">
                    তানযীমে আবনায়ে জামিয়া ফরিদাবাদ
                        </span>
                        <span class="text-emerald-300 font-medium font-bangla text-xl mt-2">
                         ৭০ সালানা দস্তরবিন্দি সম্মেলন
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <Button label="কোরআন" text class="text-white text-2xl hover:text-emerald-300 px-7 py-3 font-medium border-b-2 border-transparent hover:border-emerald-300 transition-all duration-300"
                        icon="pi pi-book" style="font-size: 1.45rem; min-width: 140px;" />
                    <Button :label="'আবনা পেনেল'" text class="text-white hover:text-emerald-300 px-7 py-3 rounded-lg transition-all duration-300 font-medium border-b-2 border-transparent hover:border-emerald-300"
                        icon="pi pi-building" style="font-size: 1.45rem; min-width: 170px;" @click="goToLogin" />
                    <Button label="ডিজিটাল লাইব্রেরী" text class="text-white hover:text-emerald-300 px-7 py-3 rounded-lg transition-all duration-300 font-medium border-b-2 border-transparent hover:border-emerald-300"
                        icon="pi pi-users" style="font-size: 1.45rem; min-width: 170px;" />
                    <Button label="অনুদানে পেনেল" text class="text-white hover:text-emerald-300 px-7 py-3 rounded-lg transition-all duration-300 font-medium border-b-2 border-transparent hover:border-emerald-300"
                        icon="pi pi-user" style="font-size: 1.45rem; min-width: 170px;" />
                    <Button label="নেয়ামত" text class="text-white hover:text-emerald-300 px-7 py-3 rounded-lg transition-all duration-300 font-medium border-b-2 border-transparent hover:border-emerald-300 hover:bg-emerald-900/50"
                        icon="pi pi-globe" style="font-size: 1.45rem; min-width: 130px;" />
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar -->
    <Sidebar v-model:visible="mobileMenuOpen" position="right" :showCloseIcon="true"
        style="backdrop-filter: blur(12px);">
        <template #header>
            <div class="flex items-center space-x-3 p-4">
                <Avatar :image="logoImage" size="large" shape="circle"
                    class="bg-emerald-800 border-2 border-emerald-600" />
                <div>
                    <h3 class="text-emerald-200 text-xl font-bold font-bangla"> তানযীমে আবনায়ে জামিয়া ফরিদাবাদ</h3>
                    <p class="text-emerald-400 text-sm font-bangla">৭০ সালানা দস্তরবিন্দি অনুষ্ঠান</p>
                </div>
            </div>
        </template>
        <div class="p-4 space-y-3">
            <div class="text-center py-3 bg-emerald-800/70 rounded-lg mb-4"></div>
            <Button label="কোরআন" text :style="{
                fontFamily: 'SolaimanLipi, sans-serif',
                fontSize: windowWidth < 640 ? '1.1rem' : '1.45rem'
            }" class="text-white text-2xl hover:text-emerald-300 px-7 py-3 font-medium border-b-2 border-transparent hover:border-emerald-300 transition-all duration-300"
                icon="pi pi-book" />
            <Button :label="'আবনা পেনেল'" text :style="{
                fontFamily: 'SolaimanLipi, sans-serif',
                fontSize: windowWidth < 640 ? '1.1rem' : '1.45rem'
            }" class="text-white hover:text-emerald-300 px-7 py-3 rounded-lg transition-all duration-300 font-medium border-b-2 border-transparent hover:border-emerald-300"
                icon="pi pi-building" @click="goToLogin" />
            <Button label="ডিজিটাল লাইব্রেরী" text :style="{
                fontFamily: 'SolaimanLipi, sans-serif',
                fontSize: windowWidth < 640 ? '1.1rem' : '1.45rem'
            }" class="text-white hover:text-emerald-300 px-7 py-3 rounded-lg transition-all duration-300 font-medium border-b-2 border-transparent hover:border-emerald-300"
                icon="pi pi-users" />
            <Button label="অনুদানে পেনেল" text :style="{
                fontFamily: 'SolaimanLipi, sans-serif',
                fontSize: windowWidth < 640 ? '1.1rem' : '1.45rem'
            }" class="text-white hover:text-emerald-300 px-7 py-3 rounded-lg transition-all duration-300 font-medium border-b-2 border-transparent hover:border-emerald-300"
                icon="pi pi-user" />
            <Button label="নেয়ামত" text :style="{
                fontFamily: 'SolaimanLipi, sans-serif',
                fontSize: windowWidth < 640 ? '1.1rem' : '1.45rem'
            }" class="text-white hover:text-emerald-300 px-7 py-3 rounded-lg transition-all duration-300 font-medium border-b-2 border-transparent hover:border-emerald-300 hover:bg-emerald-900/50"
                icon="pi pi-globe" />
        </div>
    </Sidebar>

    <!-- HERO SECTION - Seamless Integration -->
    <section

    style="font-family: 'SolaimanLipi', sans-serif;"
        class="relative min-h-screen overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 pt-20">
        <div class="absolute left-0 top-0 w-full h-full pointer-events-none select-none z-0">
            <svg class="absolute left-0 top-0 w-96 h-96 opacity-10" viewBox="0 0 512 512" fill="none">
                <path d="M256 32C132.3 32 32 132.3 32 256s100.3 224 224 224 224-100.3 224-224S379.7 32 256 32z"
                    fill="url(#paint0_radial)" />
                <defs>
                    <radialGradient id="paint0_radial" cx="0" cy="0" r="1"
                        gradientTransform="translate(256 256) scale(230)" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#10b981" />
                        <stop offset="1" stop-color="#134e4a" />
                    </radialGradient>
                </defs>
            </svg>
            <svg class="absolute right-0 bottom-0 w-96 h-96 opacity-10 rotate-180" viewBox="0 0 512 512" fill="none">
                <path d="M256 32C132.3 32 32 132.3 32 256s100.3 224 224 224 224-100.3 224-224S379.7 32 256 32z"
                    fill="url(#paint1_radial)" />
                <defs>
                    <radialGradient id="paint1_radial" cx="0" cy="0" r="1"
                        gradientTransform="translate(256 256) scale(230)" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#14b8a6" />
                        <stop offset="1" stop-color="#082f49" />
                    </radialGradient>
                </defs>
            </svg>
        </div>

        <!-- Background image carousel (with gradient overlay) -->
        <div class="absolute inset-0 z-0">
            <div class="relative w-full h-full">
                <div v-for="(image, index) in backgroundImages" :key="index" :class="[
                    'absolute inset-0 transition-opacity duration-1000',
                    currentImageIndex === index ? 'opacity-100' : 'opacity-0'
                ]">
                    <img :src="image.url" :alt="image.alt" class="w-full h-full object-cover opacity-40" />
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-emerald-800/70 to-teal-900/90"></div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex items-center min-h-screen pt-0">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="text-white space-y-8">
                        <div class="inline-flex items-center space-x-2 bg-emerald-700/30 backdrop-blur-sm border border-emerald-500/30 rounded-full px-4 py-2 shadow">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                            <span class="text-emerald-300 text-sm font-medium">ইসলামিক শিক্ষা প্রতিষ্ঠান</span>
                        </div>

                        <div class="space-y-4">
                            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold leading-tight font-bangla">
                                <span class="block text-white">আবনায়ে জামিয়া</span>
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
                                        <path d="M8 5v10l7-5-7-5z" />
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
                                    <img :src="featuredImage" alt="Featured Mosque"
                                        class="w-full h-full object-cover" />
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
                            <div class="absolute -top-4 -right-4 w-24 h-24 bg-emerald-500/20 rounded-full blur-xl"></div>
                            <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-teal-500/20 rounded-full blur-xl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-emerald-900 via-emerald-800 to-transparent"></div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-20">
            <div class="w-6 h-10 border-2 border-emerald-300 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-emerald-300 rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Button from 'primevue/button'
import Avatar from 'primevue/avatar'
import Sidebar from 'primevue/sidebar'

const mobileMenuOpen = ref(false)
const logoImage = '/images/tanjim.png'
const scrolled = ref(false)

const onImageError = (event) => {
    event.target.src = '/storage/images/tanjim.png'
}

const windowWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1200)

const onResize = () => {
    windowWidth.value = window.innerWidth
}

const handleScroll = () => {
    scrolled.value = window.scrollY > 20
}

onMounted(() => {
    window.addEventListener('resize', onResize)
    window.addEventListener('scroll', handleScroll)
    startImageRotation()
})

onUnmounted(() => {
    window.removeEventListener('resize', onResize)
    window.removeEventListener('scroll', handleScroll)
    if (imageInterval) clearInterval(imageInterval)
})

const backgroundImages = ref([
    { url: 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80', alt: 'Beautiful Mosque at Sunset' },
    { url: 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80', alt: 'Islamic Architecture' },
    { url: 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80', alt: 'Mosque Interior' },
    { url: 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80', alt: 'Islamic Calligraphy' }
])
const featuredImage = ref('https://images.unsplash.com/photo-1542816417-0983c9c9ad53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')
const currentImageIndex = ref(0)
let imageInterval = null

const startImageRotation = () => {
    imageInterval = setInterval(() => {
        currentImageIndex.value = (currentImageIndex.value + 1) % backgroundImages.value.length
    }, 5000)
}

function goToLogin() {
    window.location.href = '/login'
}
</script>

<!-- No additional style block. All design is handled by TailwindCSS utility classes in the template. -->
