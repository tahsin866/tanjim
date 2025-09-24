<template>
  <div ref="cardRef" class="registration-card">
    <div class="card-header">
      <img :src="photoUrl" alt="Student Photo" class="card-photo" />
      <div class="qr-container">
        <img :src="qrCodeUrl" alt="QR Code" class="qr-code" />
      </div>
    </div>
    <div class="card-body">
      <div class="card-row"><strong>নাম:</strong> {{ name }}</div>
      <div class="card-row"><strong>সেশন ইয়ার:</strong> {{ sessionYear }}</div>
      <div class="card-row"><strong>ফোন নম্বর:</strong> {{ phone }}</div>
    </div>
    <button @click="downloadCard" class="download-btn">ডাউনলোড করুন</button>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import html2canvas from 'html2canvas';

const props = defineProps({
  name: String,
  sessionYear: String,
  phone: String,
  photoUrl: String,
  qrCodeUrl: String,
});

const cardRef = ref(null);

function downloadCard() {
  if (!cardRef.value) return;
  html2canvas(cardRef.value).then(canvas => {
    const link = document.createElement('a');
    link.download = 'registration_card.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
  });
}
</script>

<style scoped>
.registration-card {
  width: 320px;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  background: #fff;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  padding: 16px;
  font-family: 'SolaimanLipi', sans-serif;
}
.card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.card-photo {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #e5e7eb;
}
.qr-container {
  margin-left: 12px;
}
.qr-code {
  width: 64px;
  height: 64px;
}
.card-body {
  margin-top: 16px;
}
.card-row {
  margin-bottom: 8px;
  font-size: 16px;
}
.download-btn {
  margin-top: 12px;
  background: #2563eb;
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 15px;
}
.download-btn:hover {
  background: #1d4ed8;
}
</style>
