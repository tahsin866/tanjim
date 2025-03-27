<template>
    <div>
      <!-- Navbar -->
      <Navbar />

      <!-- Hero Section -->
      <hero_section />

      <!-- Features Section -->
      <featureSection />

      <!-- Contact Section -->
      <contact_section />

      <!-- FAQ and Video Section -->
      <FAQVideoSection />

      <!-- Footer -->
      <Footer />
    </div>
  </template>

  <script setup>
  import Navbar from '@/Components/layout/Navbar.vue';
  import hero_section from '@/Components/layout/hero_section.vue';
  import featureSection from '@/Components/layout/featureSection.vue';
  import contact_section from '@/Components/layout/contact_section.vue';
  import FAQVideoSection from '@/Components/layout/FAQVideoSection.vue';
  import Footer from '@/Components/layout/Footer.vue';
  </script>
