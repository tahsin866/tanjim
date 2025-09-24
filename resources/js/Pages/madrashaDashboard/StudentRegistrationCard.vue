<template>
  <div ref="cardRef" class="registration-card bg-gradient-to-t from-[#e3e8ef] via-[#dbeafe] to-[#f1f5f9] w-[480px] min-h-[1000px] rounded-2xl shadow-xl border border-slate-300 px-16 py-16 flex flex-col justify-between font-[SolaimanLipi,sans-serif]">
    <!-- Top: Photo & QR very open, large, and far apart -->
    <div class="flex flex-row items-start justify-between mb-20">
      <div class="flex items-center justify-center w-[180px] h-[180px] bg-white rounded-2xl shadow overflow-hidden">
        <img :src="photoUrl" alt="Student Photo" class="w-[160px] h-[160px] rounded-xl object-cover bg-slate-50" />
      </div>
      <div class="flex items-center justify-center w-[110px] h-[110px] bg-white rounded-2xl shadow overflow-visible">
        <!-- QR code smaller, but perfectly centered and NO cropping -->
        <div class="flex items-center justify-center w-full h-full">
          <span v-html="qrCodeSvg" class="block w-[100px] h-[100px] m-0 p-0" style="border:none; display:block;" />
        </div>
      </div>
    </div>
    <!-- Info section -->
    <div class="flex-1 flex flex-col justify-center px-1 py-14">
      <div class="w-full py-2">
        <div class="flex items-center text-[28px] mb-10">
          <span class="font-bold text-gray-800 min-w-[180px]">নাম:</span>
          <span class="text-gray-700 ml-4 font-medium">{{ name }}</span>
        </div>
        <div class="flex items-center text-[28px] mb-10">
          <span class="font-bold text-gray-800 min-w-[180px]">সেশন ইয়ার:</span>
          <span class="text-gray-700 ml-4 font-medium">{{ sessionYear }}</span>
        </div>
        <div class="flex items-center text-[28px]">
          <span class="font-bold text-gray-800 min-w-[180px]">ফোন নম্বর:</span>
          <span class="text-gray-700 ml-4 font-medium">{{ phone }}</span>
        </div>
      </div>
    </div>
    <!-- Button at bottom -->
    <div class="flex justify-end mt-16">
      <button @click="downloadPDF"
        class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-5 rounded-lg font-semibold text-[22px] shadow transition">
        PDF ডাউনলোড করুন
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

const props = defineProps({
  name: String,
  sessionYear: String,
  phone: String,
  photoUrl: String,
  qrCodeSvg: String,
});

const cardRef = ref(null);

async function downloadPDF() {
  if (!cardRef.value) return;
  const canvas = await html2canvas(cardRef.value);
  const imgData = canvas.toDataURL('image/png');
  const pdf = new jsPDF({
    orientation: 'portrait',
    unit: 'px',
    format: [cardRef.value.offsetWidth, cardRef.value.offsetHeight]
  });
  pdf.addImage(imgData, 'PNG', 0, 0, cardRef.value.offsetWidth, cardRef.value.offsetHeight);
  pdf.save('registration_card.pdf');
}
</script>

<style scoped>
.registration-card {
  /* Only Tailwind classes used in template */
}
/* Ensure QR code SVG is never cropped */
.qr-section {
  overflow: visible !important;
}
</style>