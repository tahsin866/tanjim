
<template>
  <section

  style="font-family: 'SolaimanLipi', sans-serif;"

  class="py-16 bg-white dark:bg-gray-900 transition-colors duration-300">
    <div class="container mx-auto px-4 relative">
      <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
          <i class="pi pi-comments text-teal-600 dark:text-teal-400 mr-3"></i>
          প্রশ্ন ও ছবি গ্যালারি
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          ৭০ বছর পূর্তি উপলক্ষে সম্মাননা অনুষ্ঠান, প্রশ্ন-উত্তর, ও অনুষ্ঠানের মুহূর্তগুলো দেখুন।
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="transform transition-all duration-500">
          <Card class="shadow-xl rounded-xl border-0 h-full dark:bg-gray-800">
            <template #header>
              <div class="bg-gradient-to-r from-teal-600 to-cyan-600 dark:from-teal-800 dark:to-cyan-900 p-6 text-white relative overflow-hidden rounded-t-xl">
                <div class="flex items-center relative z-10">
                  <Avatar icon="pi pi-question" class="bg-white/20 text-white mr-4" size="large" />
                  <div>
                    <h3 class="text-2xl font-bold mb-1">শুভেচ্ছা ও প্রশ্ন</h3>
                    <p class="text-teal-100">অনুষ্ঠান, অতিথি, স্মৃতিচারণ, ও সম্মাননা সংক্রান্ত প্রশ্ন</p>
                  </div>
                </div>
              </div>
            </template>
            <template #content>
              <div class="p-6">
                <Accordion :activeIndex="0" class="faq-accordion">
                  <AccordionTab v-for="(faq, index) in faqs" :key="index">
                    <template #header>
                      <div class="flex items-center w-full">
                        <Avatar :label="(index + 1).toString()" class="bg-teal-100 text-teal-600 mr-3" size="small" />
                        <span class="font-semibold text-gray-800 dark:text-gray-100">{{ faq.question }}</span>
                      </div>
                    </template>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                      <p class="text-gray-700 dark:text-gray-200 leading-relaxed">{{ faq.answer }}</p>
                    </div>
                  </AccordionTab>
                </Accordion>
                <div class="mt-6 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-blue-900">
                  <div class="flex items-center mb-3">
                    <i class="pi pi-headphones text-blue-600 dark:text-blue-300 mr-2"></i>
                    <span class="font-semibold text-blue-800 dark:text-blue-200">বিশেষ তথ্য জানতে চান?</span>
                  </div>
                  <Button label="আবনা কমিটির সাথে যোগাযোগ করুন।" icon="pi pi-phone" class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 border-0" @click="contactSupport" />
                </div>
              </div>
            </template>
          </Card>
        </div>

        <div class="transform transition-all duration-500">
          <Card class="shadow-xl rounded-xl border-0 h-full dark:bg-gray-800">
            <template #header>
              <div class="bg-gradient-to-r from-teal-600 to-cyan-600 dark:from-teal-800 dark:to-cyan-900 p-6 text-white relative overflow-hidden rounded-t-xl">
                <div class="flex items-center relative z-10">
                  <Avatar icon="pi pi-images" class="bg-white/20 text-white mr-4" size="large" />
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
                  <div v-for="(image, index) in galleryImages" :key="index" class="relative group cursor-pointer overflow-hidden rounded-lg" @click="showImageModal(image)">
                    <img :src="image.url" :alt="image.caption" class="w-full h-auto object-cover aspect-video group-hover:scale-110 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-black/40 flex items-end p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                      <p class="text-white text-xs font-medium">{{ image.caption }}</p>
                    </div>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <Button label="আরো ছবি দেখুন" icon="pi pi-images" class="bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-emerald-600 hover:to-teal-700 border-0" @click="showGalleryModal = true" />
                </div>
              </div>
            </template>
          </Card>
        </div>
      </div>

      <div class="mt-12">
        <h3 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-8">
          <i class="pi pi-bolt text-teal-600 dark:text-teal-400 mr-2"></i>
          দ্রুত তথ্য ও কার্যক্রম
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="(action, index) in quickActions" :key="action.title" class="transform hover:scale-105 transition-all duration-300 cursor-pointer" :style="{ animationDelay: `${index * 100}ms` }">
            <Card class="text-center shadow-md rounded-xl hover:shadow-xl transition-all duration-300 border-0 group h-full dark:bg-gray-800">
              <template #content>
                <div class="p-6">
                  <Avatar :icon="action.icon" :class="action.avatarClass + ' dark:bg-gray-700 dark:text-teal-300'" size="xlarge" class="mb-4 group-hover:scale-110 transition-transform duration-300" />
                  <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ action.title }}</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-300">{{ action.description }}</p>
                </div>
              </template>
            </Card>
          </div>
        </div>
      </div>
    </div>

    <Dialog v-model:visible="showGalleryModal" :style="{ width: '90vw', maxWidth: '700px' }" modal maximizable header="ছবি গ্যালারি" class="gallery-modal dark:bg-gray-900">
      <div class="grid grid-cols-2 gap-4">
        <div v-for="(image, index) in galleryImages" :key="index" class="relative group">
          <img :src="image.url" :alt="image.caption" class="rounded-lg shadow-lg object-cover aspect-video" />
          <div class="absolute bottom-2 left-2 right-2 bg-black/40 text-white text-xs rounded px-2 py-1">
            {{ image.caption }}
          </div>
        </div>
      </div>
    </Dialog>
    <Dialog v-model:visible="showImageSingleModal" :style="{ width: '50vw', maxWidth: '480px' }" modal header="ছবি" class="gallery-modal dark:bg-gray-900">
      <img :src="selectedImage?.url" :alt="selectedImage?.caption" class="rounded-lg w-full shadow-lg mb-3" />
      <div class="text-center text-gray-700 dark:text-gray-200">{{ selectedImage?.caption }}</div>
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
    answer: 'প্রতিষ্ঠানের ৭০ বছর পূর্তি উপলক্ষে, সকল গ্র্যাজুয়েট ও সংশ্লিষ্টদের সম্মাননা জানানো এবং তাদের অবদানকে স্মরণ করাই এই অনুষ্ঠানের মূল লক্ষ্য।'
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
    avatarClass: 'bg-teal-100 text-teal-600 dark:bg-teal-900 dark:text-teal-300',
    action: 'ask'
  },
  {
    title: 'ছবি আপলোড',
    description: 'আপনার স্মৃতিময় ছবি শেয়ার করুন',
    icon: 'pi pi-upload',
    avatarClass: 'bg-teal-100 text-teal-600 dark:bg-teal-900 dark:text-teal-300',
    action: 'upload'
  },
  {
    title: 'স্মৃতিচারণ',
    description: 'আপনার অনুভূতি ও গল্প লিখুন',
    icon: 'pi pi-pencil',
    avatarClass: 'bg-teal-100 text-teal-600 dark:bg-teal-900 dark:text-teal-300',
    action: 'share'
  },
  {
    title: 'যোগাযোগ',
    description: 'অনুষ্ঠান কমিটির সাথে যোগাযোগ করুন',
    icon: 'pi pi-phone',
    avatarClass: 'bg-teal-100 text-teal-600 dark:bg-teal-900 dark:text-teal-300',
    action: 'contact'
  }
])

const showGalleryModal = ref(false)
const showImageSingleModal = ref(false)
const selectedImage = ref(null)

const contactSupport = () => {
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
@import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=SolaimanLipi&display=swap');

.faq-accordion .p-accordion-header-link {
  border-radius: 8px;
}
.faq-accordion .p-accordion-content {
  border-radius: 8px;
}
.gallery-modal .p-dialog-content {
  padding: 1.5rem !important;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-\[fadeInUp_0\.6s_ease-out_forwards\] {
  animation: fadeInUp 0.6s ease-out forwards;
}

</style>
```
