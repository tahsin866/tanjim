<template>
  <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
      <i class="pi pi-chart-line text-blue-500"></i>
      মাসিক নিবন্ধন প্রবণতা (১২ মাস)
    </h3>
    <div class="h-64">
      <canvas ref="chartCanvas" class="w-full h-full"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
  data: Array
});

const chartCanvas = ref(null);

const createChart = () => {
  if (!chartCanvas.value || !props.data?.length) return;

  const ctx = chartCanvas.value.getContext('2d');
  const canvas = chartCanvas.value;
  const width = canvas.width = canvas.offsetWidth;
  const height = canvas.height = canvas.offsetHeight;

  ctx.clearRect(0, 0, width, height);

  if (!props.data?.length) return;

  const maxValue = Math.max(...props.data.map(d => d.count));
  const padding = 40;
  const chartWidth = width - padding * 2;
  const chartHeight = height - padding * 2;

  ctx.strokeStyle = '#e5e7eb';
  ctx.lineWidth = 1;

  for (let i = 0; i <= 5; i++) {
    const y = padding + (chartHeight / 5) * i;
    ctx.beginPath();
    ctx.moveTo(padding, y);
    ctx.lineTo(width - padding, y);
    ctx.stroke();
  }

  ctx.strokeStyle = '#3b82f6';
  ctx.lineWidth = 2;
  ctx.beginPath();

  props.data.forEach((point, index) => {
    const x = padding + (chartWidth / (props.data.length - 1)) * index;
    const y = padding + chartHeight - (point.count / maxValue) * chartHeight;

    if (index === 0) {
      ctx.moveTo(x, y);
    } else {
      ctx.lineTo(x, y);
    }

    ctx.fillStyle = '#3b82f6';
    ctx.beginPath();
    ctx.arc(x, y, 4, 0, 2 * Math.PI);
    ctx.fill();
  });

  ctx.stroke();

  ctx.fillStyle = '#6b7280';
  ctx.font = '12px Arial';
  ctx.textAlign = 'center';

  props.data.forEach((point, index) => {
    const x = padding + (chartWidth / (props.data.length - 1)) * index;
    ctx.fillText(point.month, x, height - 10);
  });

  ctx.textAlign = 'right';
  for (let i = 0; i <= 5; i++) {
    const y = padding + (chartHeight / 5) * i;
    const value = maxValue - (maxValue / 5) * i;
    ctx.fillText(Math.round(value), padding - 10, y + 5);
  }
};

onMounted(() => {
  createChart();
});

watch(() => props.data, () => {
  createChart();
}, { deep: true });
</script>
