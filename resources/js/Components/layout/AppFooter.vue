<template>
    <footer class="layout-footer">
        <div class="footer-content">
            <div class="footer-section">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Company Info -->
                    <div class="footer-column">
                        <h6 class="footer-title">
                            <i class="pi pi-home mr-2"></i>
                            ওয়েমস (WEMS)
                        </h6>
                        <p class="footer-text">
                            ওয়াক্ফীয়া এক্সাম ম্যানেজমেন্ট সিস্টেম - আধুনিক প্রযুক্তির মাধ্যমে
                            মাদ্রাসা শিক্ষা ব্যবস্থাপনায় নতুন মাত্রা।
                        </p>
                        <div class="footer-social">
                            <Button
                                icon="pi pi-facebook"
                                class="p-button-rounded p-button-text p-button-sm"
                                v-tooltip.top="'ফেসবুক'"
                                @click="openSocial('facebook')"
                            />
                            <Button
                                icon="pi pi-twitter"
                                class="p-button-rounded p-button-text p-button-sm"
                                v-tooltip.top="'টুইটার'"
                                @click="openSocial('twitter')"
                            />
                            <Button
                                icon="pi pi-youtube"
                                class="p-button-rounded p-button-text p-button-sm"
                                v-tooltip.top="'ইউটিউব'"
                                @click="openSocial('youtube')"
                            />
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-column">
                        <h6 class="footer-title">
                            <i class="pi pi-link mr-2"></i>
                            দ্রুত লিংক
                        </h6>
                        <ul class="footer-links">
                            <li>
                                <Link :href="route('dashboard')" class="footer-link">
                                    <i class="pi pi-home mr-2"></i>ড্যাশবোর্ড
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('students_registration.index')" class="footer-link">
                                    <i class="pi pi-users mr-2"></i>ছাত্র নিবন্ধন
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('others.notice')" class="footer-link">
                                    <i class="pi pi-bell mr-2"></i>নোটিস
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('profile.edit')" class="footer-link">
                                    <i class="pi pi-user mr-2"></i>প্রোফাইল
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact & Support -->
                    <div class="footer-column">
                        <h6 class="footer-title">
                            <i class="pi pi-phone mr-2"></i>
                            যোগাযোগ ও সহায়তা
                        </h6>
                        <div class="footer-contact">
                            <div class="contact-item">
                                <i class="pi pi-phone text-primary"></i>
                                <div>
                                    <span class="contact-label">হটলাইন:</span>
                                    <span class="contact-value">+৮৮০ ১৭১২-৩৪৫৬৭৮</span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="pi pi-envelope text-primary"></i>
                                <div>
                                    <span class="contact-label">ইমেইল:</span>
                                    <span class="contact-value">support@wems.edu.bd</span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="pi pi-clock text-primary"></i>
                                <div>
                                    <span class="contact-label">সেবার সময়:</span>
                                    <span class="contact-value">সকাল ৯টা - সন্ধ্যা ৬টা</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Stats -->
                <div class="footer-stats">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <i class="pi pi-users stat-icon"></i>
                            <div class="stat-content">
                                <span class="stat-number">{{ stats.totalStudents }}</span>
                                <span class="stat-label">মোট ছাত্র</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <i class="pi pi-building stat-icon"></i>
                            <div class="stat-content">
                                <span class="stat-number">{{ stats.totalMadrashas }}</span>
                                <span class="stat-label">মোট মাদ্রাসা</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <i class="pi pi-book stat-icon"></i>
                            <div class="stat-content">
                                <span class="stat-number">{{ stats.totalExams }}</span>
                                <span class="stat-label">মোট পরীক্ষা</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <i class="pi pi-certificate stat-icon"></i>
                            <div class="stat-content">
                                <span class="stat-number">{{ stats.totalCertificates }}</span>
                                <span class="stat-label">মোট সনদ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="footer-copyright">
                        <p>© {{ currentYear }} ওয়াক্ফীয়া এক্সাম ম্যানেজমেন্ট সিস্টেম। সকল অধিকার সংরক্ষিত।</p>
                    </div>
                    <div class="footer-version">
                        <Badge value="v2.0.1" severity="info" />
                        <span class="ml-2 text-sm text-gray-400">বিল্ড: {{ buildNumber }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <Button
            v-show="showBackToTop"
            @click="scrollToTop"
            icon="pi pi-chevron-up"
            class="back-to-top-btn p-button-rounded"
            v-tooltip.left="'উপরে যান'"
        />
    </footer>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import Button from 'primevue/button'
import Badge from 'primevue/badge'

// Current year
const currentYear = new Date().getFullYear()

// Build number (can be from environment or config)
const buildNumber = ref('240712')

// Back to top functionality
const showBackToTop = ref(false)

// Mock stats - replace with real data
const stats = ref({
    totalStudents: '১২,৫৪৩',
    totalMadrashas: '৮৫৬',
    totalExams: '২,৩৪৫',
    totalCertificates: '৯,৮৭৫'
})

// Methods
const openSocial = (platform) => {
    const urls = {
        facebook: 'https://facebook.com/wems.bd',
        twitter: 'https://twitter.com/wems_bd',
        youtube: 'https://youtube.com/c/wems-bd'
    }
    window.open(urls[platform], '_blank')
}

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    })
}

const handleScroll = () => {
    showBackToTop.value = window.scrollY > 300
}

// Lifecycle
onMounted(() => {
    window.addEventListener('scroll', handleScroll)
    // Load real stats here
    // loadStats()
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.layout-footer {
    @apply bg-gray-900 text-white mt-auto;
}

.footer-content {
    @apply px-6 py-8;
}

.footer-section {
    @apply max-w-7xl mx-auto;
}

.footer-column {
    @apply space-y-4;
}

.footer-title {
    @apply text-lg font-bold text-white flex items-center mb-4;
}

.footer-text {
    @apply text-gray-300 text-sm leading-relaxed;
}

.footer-social {
    @apply flex gap-2 mt-4;
}

.footer-links {
    @apply list-none space-y-2;
}

.footer-link {
    @apply text-gray-300 hover:text-white transition-colors duration-200;
    @apply flex items-center text-sm;
}

.footer-contact {
    @apply space-y-3;
}

.contact-item {
    @apply flex items-start gap-3;
}

.contact-label {
    @apply block text-gray-400 text-xs uppercase;
}

.contact-value {
    @apply block text-gray-300 text-sm;
}

.footer-stats {
    @apply mt-8 pt-8 border-t border-gray-700;
}

.stats-grid {
    @apply grid grid-cols-2 md:grid-cols-4 gap-6;
}

.stat-item {
    @apply flex items-center gap-3 bg-gray-800 p-4 rounded-lg;
}

.stat-icon {
    @apply text-2xl text-blue-400;
}

.stat-content {
    @apply flex flex-col;
}

.stat-number {
    @apply text-xl font-bold text-white;
}

.stat-label {
    @apply text-xs text-gray-400 uppercase;
}

.footer-bottom {
    @apply bg-gray-950 border-t border-gray-700;
}

.footer-bottom-content {
    @apply max-w-7xl mx-auto px-6 py-4;
}

.footer-copyright {
    @apply text-gray-400 text-sm;
}

.footer-version {
    @apply flex items-center;
}

.back-to-top-btn {
    @apply fixed bottom-6 right-6 z-50;
    @apply shadow-lg;
}
</style>
