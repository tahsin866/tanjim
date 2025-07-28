<template>
    <div>
      <!-- Navbar -->
      <Navbar />

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
  import featureSection from '@/Components/layout/featureSection.vue';
  import contact_section from '@/Components/layout/contact_section.vue';
  import FAQVideoSection from '@/Components/layout/FAQVideoSection.vue';
  import Footer from '@/Components/layout/Footer.vue';
  </script>
