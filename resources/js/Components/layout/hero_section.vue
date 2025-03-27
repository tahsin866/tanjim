<template>
    <section

       style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
    class="py-24 bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-50">
      <div class="container mx-auto text-center px-4">
        <!-- Islamic Decorative Element -->
        <div class="flex justify-center mb-8">
          <div class="w-32 h-32 bg-contain bg-center bg-no-repeat"
               style="background-image: url('/path-to-islamic-ornament.png')">
          </div>
        </div>

        <!-- Main Title with Arabic Styling -->
        <h1 class="text-5xl font-bold text-emerald-900 mb-6 leading-tight">
          বেফাকুল মাদারিসিল আরাবিয়া বাংলাদেশ
        </h1>

        <!-- Decorative Divider -->
        <div class="flex items-center justify-center my-6">
          <div class="h-0.5 w-16 bg-emerald-600"></div>
          <div class="mx-4">
            <svg class="w-8 h-8 text-emerald-600" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2L14.85 8.35L22 9.27L17 14.14L18.18 21L12 17.77L5.82 21L7 14.14L2 9.27L9.15 8.35L12 2Z"/>
            </svg>
          </div>
          <div class="h-0.5 w-16 bg-emerald-600"></div>
        </div>

        <!-- Subtitle with Islamic Border -->
        <div class="inline-block px-8 py-4 border-2 border-emerald-600 rounded-lg bg-white/50 backdrop-blur-sm">
          <h2 class="text-2xl text-emerald-800 font-semibold">
            (বাংলাদেশ কওমী মাদরাসা শিক্ষাবোর্ড)
          </h2>
        </div>

        <!-- Islamic Pattern Background -->
        <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none"
             style="background-image: url('/path-to-islamic-pattern.png')">
        </div>
      </div>
    </section>
  </template>

  <style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;700&display=swap');

  h1 {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  }

  /* Optional: Add smooth hover effects */
  .border-emerald-600 {
    transition: all 0.3s ease;
  }

  .border-emerald-600:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  </style>
