<template>
  <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-100 dark:border-gray-800 p-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
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

const getComputedStyleColor = (cssVar, fallback) => {
  if (typeof window === "undefined") return fallback;
  const el = document.documentElement;
  let color = getComputedStyle(el).getPropertyValue(cssVar);
  return color?.trim() || fallback;
}

const createChart = () => {
  if (!chartCanvas.value || !props.data?.length) return;

  const ctx = chartCanvas.value.getContext('2d');
  const canvas = chartCanvas.value;
  const width = canvas.width = canvas.offsetWidth;
  const height = canvas.height = canvas.offsetHeight;

  ctx.clearRect(0, 0, width, height);

  if (!props.data?.length) return;

  // Determine if dark mode is enabled
  const isDark = document.documentElement.classList.contains('dark');

  // Tailwind colors for light and dark
  const gridColor = isDark ? '#374151' : '#e5e7eb'; // dark:bg-gray-800 / bg-gray-100
  const lineColor = isDark ? '#60a5fa' : '#3b82f6'; // dark:text-blue-400 / text-blue-500
  const pointColor = isDark ? '#60a5fa' : '#3b82f6';
  const labelColor = isDark ? '#d1d5db' : '#6b7280'; // dark:text-gray-300 / text-gray-500

  const maxValue = Math.max(...props.data.map(d => d.count));
  const padding = 40;
  const chartWidth = width - padding * 2;
  const chartHeight = height - padding * 2;

  ctx.strokeStyle = gridColor;
  ctx.lineWidth = 1;

  for (let i = 0; i <= 5; i++) {
    const y = padding + (chartHeight / 5) * i;
    ctx.beginPath();
    ctx.moveTo(padding, y);
    ctx.lineTo(width - padding, y);
    ctx.stroke();
  }

  ctx.strokeStyle = lineColor;
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

    ctx.fillStyle = pointColor;
    ctx.beginPath();
    ctx.arc(x, y, 4, 0, 2 * Math.PI);
    ctx.fill();
  });

  ctx.stroke();

  ctx.fillStyle = labelColor;
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

// Re-draw chart on mount and when data changes or theme changes
onMounted(() => {
  createChart();
  // Listen for dark mode toggle
  const observer = new MutationObserver(() => createChart());
  observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
});

watch(() => props.data, () => {
  createChart();
}, { deep: true });
</script>
