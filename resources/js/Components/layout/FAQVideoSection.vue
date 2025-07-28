<template>
  <section
    style="font-family: 'Merriweather', 'SolaimanLipi', sans-serif;"
    class="py-16 bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 relative overflow-hidden">

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10 pointer-events-none select-none">
      <div class="absolute top-20 left-20 w-64 h-64 bg-emerald-300 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute bottom-20 right-20 w-80 h-80 bg-teal-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
      <!-- Section Header -->
      <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">
          <i class="pi pi-comments text-emerald-600 mr-3"></i>
          প্রশ্ন ও ছবি গ্যালারি
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          ৭০ বছর পূর্তি উপলক্ষে সম্মাননা অনুষ্ঠান, প্রশ্ন-উত্তর, ও অনুষ্ঠানের মুহূর্তগুলো দেখুন
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Questions (FAQ) Section -->
        <div class="transform hover:scale-[1.01] transition-all duration-500">
          <Card class="shadow-xl hover:shadow-2xl transition-all duration-500 border-0 h-full">
            <template #header>
              <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
                <div class="flex items-center relative z-10">
                  <Avatar
                    icon="pi pi-question"
                    class="bg-white/20 text-white mr-4"
                    size="large" />
                  <div>
                    <h3 class="text-2xl font-bold mb-1">শুভেচ্ছা ও প্রশ্ন</h3>
                    <p class="text-emerald-100">অনুষ্ঠান, অতিথি, স্মৃতিচারণ, ও সম্মাননা সংক্রান্ত প্রশ্ন</p>
                  </div>
                </div>
              </div>
            </template>
            <template #content>
              <div class="p-6">
                <Accordion :activeIndex="0" class="faq-accordion">
                  <AccordionTab
                    v-for="(faq, index) in faqs"
                    :key="index"
                    :header="faq.question"
                    class="mb-2">
                    <template #header>
                      <div class="flex items-center w-full">
                        <Avatar
                          :label="(index + 1).toString()"
                          class="bg-emerald-100 text-emerald-600 mr-3"
                          size="small" />
                        <span class="font-semibold text-gray-800">{{ faq.question }}</span>
                      </div>
                    </template>
                    <div class="p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg">
                      <p class="text-gray-700 leading-relaxed">{{ faq.answer }}</p>
                      <!-- Action buttons for each FAQ -->
                      <div class="flex gap-2 mt-4">
                        <Button
                          label="উত্তরটি পছন্দ"
                          icon="pi pi-thumbs-up"
                          size="small"
                          severity="success"
                          outlined
                          class="text-xs" />
                      </div>
                    </div>
                  </AccordionTab>
                </Accordion>
                <!-- Contact for more info -->
                <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                  <div class="flex items-center mb-3">
                    <i class="pi pi-headphones text-blue-600 mr-2"></i>
                    <span class="font-semibold text-blue-800">বিশেষ তথ্য জানতে চান?</span>
                  </div>
                  <Button
                    label="অনুষ্ঠান কমিটির সাথে যোগাযোগ"
                    icon="pi pi-phone"
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 border-0"
                    @click="contactSupport" />
                </div>
              </div>
            </template>
          </Card>
        </div>

        <!-- Gallery Section -->
        <div class="transform hover:scale-[1.01] transition-all duration-500">
          <Card class="shadow-xl hover:shadow-2xl transition-all duration-500 border-0 h-full">
            <template #header>
              <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 -translate-x-8"></div>
                <div class="flex items-center relative z-10">
                  <Avatar
                    icon="pi pi-images"
                    class="bg-white/20 text-white mr-4"
                    size="large" />
                  <div>
                    <h3 class="text-2xl font-bold mb-1">ছবি গ্যালারি</h3>
                    <p class="text-teal-100">অনুষ্ঠানের বিশেষ মুহূর্ত ও স্মৃতি</p>
                  </div>
                </div>
              </div>
            </template>
            <template #content>
              <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                  <div
                    v-for="(image, index) in galleryImages"
                    :key="index"
                    class="relative group cursor-pointer"
                    @click="showImageModal(image)">
                    <img :src="image.url" :alt="image.caption" class="rounded-lg shadow-lg object-cover aspect-video group-hover:scale-105 transition-all duration-300" />
                    <div class="absolute bottom-2 left-2 right-2 bg-black/40 text-white text-xs rounded px-2 py-1">
                      {{ image.caption }}
                    </div>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <Button
                    label="আরো ছবি দেখুন"
                    icon="pi pi-images"
                    class="bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-emerald-500 hover:to-teal-600 border-0"
                    @click="showGalleryModal = true"
                  />
                </div>
              </div>
            </template>
          </Card>
        </div>
      </div>

      <!-- Quick Actions / Info -->
      <div class="mt-12">
        <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">
          <i class="pi pi-bolt text-emerald-600 mr-2"></i>
          দ্রুত তথ্য ও কার্যক্রম
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div
            v-for="(action, index) in quickActions"
            :key="action.title"
            class="transform hover:scale-105 transition-all duration-300 cursor-pointer"
            @click="handleQuickAction(action)"
            :style="{ animationDelay: `${index * 100}ms` }"
          >
            <Card class="text-center shadow-md hover:shadow-xl transition-all duration-300 border-0 group h-full">
              <template #content>
                <div class="p-6">
                  <Avatar
                    :icon="action.icon"
                    :class="action.avatarClass"
                    size="xlarge"
                    class="mb-4 group-hover:scale-110 transition-transform duration-300" />
                  <h4 class="font-semibold text-gray-800 mb-2">{{ action.title }}</h4>
                  <p class="text-sm text-gray-600">{{ action.description }}</p>
                </div>
              </template>
            </Card>
          </div>
        </div>
      </div>
    </div>

    <!-- Image Modal -->
    <Dialog
      v-model:visible="showGalleryModal"
      :style="{ width: '90vw', maxWidth: '700px' }"
      modal
      maximizable
      header="ছবি গ্যালারি"
      class="gallery-modal"
    >
      <div class="grid grid-cols-2 gap-4">
        <div
          v-for="(image, index) in galleryImages"
          :key="index"
          class="relative group"
        >
          <img :src="image.url" :alt="image.caption" class="rounded-lg shadow-lg object-cover aspect-video" />
          <div class="absolute bottom-2 left-2 right-2 bg-black/40 text-white text-xs rounded px-2 py-1">
            {{ image.caption }}
          </div>
        </div>
      </div>
    </Dialog>
    <!-- Single Image Modal (optional, if you want to show one large image when clicked) -->
    <Dialog
      v-model:visible="showImageSingleModal"
      :style="{ width: '50vw', maxWidth: '480px' }"
      modal
      header="ছবি"
      class="gallery-modal"
    >
      <img :src="selectedImage?.url" :alt="selectedImage?.caption" class="rounded-lg w-full shadow-lg mb-3" />
      <div class="text-center text-gray-700">{{ selectedImage?.caption }}</div>
    </Dialog>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import Avatar from 'primevue/avatar'
import Accordion from 'primevue/accordion'
import AccordionTab from 'primevue/accordiontab'
import Dialog from 'primevue/dialog'

const faqs = ref([
  {
    question: '৭০ বছর পূর্তি উপলক্ষে এই সম্মাননা অনুষ্ঠানের উদ্দেশ্য কী?',
    answer: 'প্রতিষ্ঠানের ৭০ বছর পূর্তি উপলক্ষে, সকল গ্র্যাজুয়েট ও সংশ্লিষ্টদের সম্মাননা জানানো এবং তাদের অবদানকে স্মরণ করাই এই অনুষ্ঠানের মূল লক্ষ্য।'
  },
  {
    question: 'অনুষ্ঠানে কারা কারা উপস্থিত থাকবেন?',
    answer: 'প্রাক্তন শিক্ষার্থী, বর্তমান শিক্ষক, অতিথি, ও প্রতিষ্ঠানের শুভানুধ্যায়ীরা এই অনুষ্ঠানে উপস্থিত থাকবেন।'
  },
  {
    question: 'অনুষ্ঠানের বিশেষ আকর্ষণ কী কী?',
    answer: 'সম্মাননা প্রদান, স্মৃতিচারণ, মিলনমেলা, ও অনুষ্ঠানের বিভিন্ন মুহূর্তের ছবি শেয়ার করা হবে।'
  },
  {
    question: 'অনুষ্ঠানের আপডেট ও ছবি কোথায় পাওয়া যাবে?',
    answer: 'এই ওয়েবসাইটের ছবি গ্যালারিতে এবং হোমপেজে নিয়মিত আপডেট দেওয়া হবে।'
  }
])

const galleryImages = ref([
  {
    url: 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=500&q=80',
    caption: 'সম্মাননা প্রদান মুহূর্ত'
  },
  {
    url: 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=500&q=80',
    caption: 'প্রাক্তন শিক্ষার্থীদের মিলনমেলা'
  },
  {
    url: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=500&q=80',
    caption: 'অনুষ্ঠানের প্রাণবন্ত পরিবেশ'
  },
  {
    url: 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=500&q=80',
    caption: 'মঞ্চে অতিথিদের বক্তব্য'
  }
])

const quickActions = ref([
  {
    title: 'প্রশ্ন করুন',
    description: 'অনুষ্ঠান সংক্রান্ত যে কোন প্রশ্ন করুন',
    icon: 'pi pi-question-circle',
    avatarClass: 'bg-emerald-100 text-emerald-600',
    action: 'ask'
  },
  {
    title: 'ছবি আপলোড',
    description: 'আপনার স্মৃতিময় ছবি শেয়ার করুন',
    icon: 'pi pi-upload',
    avatarClass: 'bg-teal-100 text-teal-600',
    action: 'upload'
  },
  {
    title: 'স্মৃতিচারণ',
    description: 'আপনার অনুভূতি ও গল্প লিখুন',
    icon: 'pi pi-pencil',
    avatarClass: 'bg-cyan-100 text-cyan-600',
    action: 'share'
  },
  {
    title: 'যোগাযোগ',
    description: 'অনুষ্ঠান কমিটির সাথে যোগাযোগ করুন',
    icon: 'pi pi-phone',
    avatarClass: 'bg-blue-100 text-blue-600',
    action: 'contact'
  }
])

const showGalleryModal = ref(false)
const showImageSingleModal = ref(false)
const selectedImage = ref(null)

const contactSupport = () => {
  // যোগাযোগ ফাংশন
  alert('অনুষ্ঠান কমিটির সাথে যোগাযোগের জন্য ফোন বা ইমেইল ব্যবহার করুন।');
}

const handleQuickAction = (action) => {
  switch(action.action) {
    case 'ask':
      alert('আপনার প্রশ্ন লিখুন অথবা ফর্মে জমা দিন।')
      break
    case 'upload':
      alert('ছবি আপলোড করার ফিচার শীঘ্রই আসছে!')
      break
    case 'share':
      alert('আপনার স্মৃতিচারণা লিখে আমাদের পাঠান।')
      break
    case 'contact':
      contactSupport()
      break
    default:
      alert('কোন অ্যাকশন নেই')
  }
}

const showImageModal = (image) => {
  selectedImage.value = image
  showImageSingleModal.value = true
}
</script>

<style scoped>
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px);}
  to { opacity: 1; transform: translateY(0);}
}
.animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards;}
.grid > div { opacity: 0; animation: fadeInUp 0.6s ease-out forwards;}
:deep(.faq-accordion .p-accordion-tab) {
  margin-bottom: 0.5rem;
  border-radius: 0.5rem;
  overflow: hidden;
  border: 1px solid #d1fae5;
}
:deep(.faq-accordion .p-accordion-header) {
  background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
  border: none;
}
:deep(.faq-accordion .p-accordion-header:hover) {
  background: linear-gradient(135deg, #dcfce7, #d1fae5);
}
:deep(.faq-accordion .p-accordion-header-link) {
  padding: 1rem 1.5rem;
  color: #065f46;
  font-weight: 600;
}
:deep(.faq-accordion .p-accordion-content) {
  background: #ffffff;
  border: none;
  padding: 0;
}
.p-card:hover { transform: translateY(-4px);}
:deep(.gallery-modal .p-dialog-header) {
  background: linear-gradient(135deg, #0f766e, #0d9488);
  color: white;
}
:deep(.gallery-modal .p-dialog-content) {
  padding: 1.5rem;
}
@media (max-width: 768px) {
  .container { padding-left: 1rem; padding-right: 1rem; }
  .grid { gap: 1rem; }
  :deep(.gallery-modal) { width: 95vw !important;}
}
</style>
