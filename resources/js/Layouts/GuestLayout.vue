<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0 dark:bg-gray-900"
    >
        <!-- <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
            </Link>
        </div> -->
  <div
    style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
    class="flex mt-10  flex-col items-center islamic-pattern pt-8 sm:justify-center sm:pt-0 "
>
    <!-- Islamic Decorative Header -->
    <div class="w-full text-center mb-10">
        <div>
            <!-- Bangla Title - Full Width and Larger -->
            <h2 class="w-full text-4xl md:text-5xl font-extrabold text-emerald-900 tracking-wide">
                বেফাকুল মাদারসিল আরাবিয়া বাংলাদেশ
            </h2>
        </div>
    </div>
    <!-- Main Content Card -->
    <div class="w-full sm:max-w-md ">
        <div class="bg-white rounded-md shadow-2xl overflow-hidden border border-emerald-300">
            <!-- Islamic Decorative Top Border -->
            <div class="h-2 bg-gradient-to-r from-emerald-900 via-emerald-700 to-emerald-900"></div>

            <!-- Content Area -->
            <div class="px-6 py-8 space-y-6 mt-10">
                <slot />
            </div>

            <!-- Islamic Decorative Bottom -->

        </div>
    </div>
</div>
</div>
</template>

