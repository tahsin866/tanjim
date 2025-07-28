<script setup>
import { ref, onMounted } from 'vue';
import Chart from 'chart.js/auto';

const examAnalytics = ref({
  passRate: '৮৫.৭%',
  averageGrade: '৩.৮৫',
  topSubject: 'হাদীস শরীফ',
  lowestSubject: 'আরবি ভাষা'
});

onMounted(() => {
  // Pass Rate Chart
  const passRateCtx = document.getElementById('passRateChart');
  if (passRateCtx) {
    new Chart(passRateCtx, {
      type: 'doughnut',
      data: {
        labels: ['পাস', 'ফেল'],
        datasets: [{
          data: [85.7, 14.3],
          backgroundColor: ['#4F46E5', '#E5E7EB'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '75%',
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  }

  // Subject Performance Chart
  const subjectCtx = document.getElementById('subjectPerformanceChart');
  if (subjectCtx) {
    new Chart(subjectCtx, {
      type: 'bar',
      data: {
        labels: ['হাদীস', 'ফিকাহ', 'তাফসীর', 'আরবি', 'ইসলামি ইতিহাস'],
        datasets: [{
          label: 'গড় নম্বর',
          data: [85, 78, 72, 65, 80],
          backgroundColor: '#4F46E5',
          borderRadius: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  }

  // Yearly Trend Chart
  const trendCtx = document.getElementById('yearlyTrendChart');
  if (trendCtx) {
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: ['১৪৪২', '১৪৪৩', '১৪৪৪', '১৪৪৫', '১৪৪৬'],
        datasets: [{
          label: 'পাস রেট',
          data: [78, 80, 82, 84, 85.7],
          borderColor: '#4F46E5',
          backgroundColor: 'rgba(79, 70, 229, 0.1)',
          tension: 0.3,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: false,
            min: 70,
            max: 100
          }
        }
      }
    });
  }
});
</script>

<template>

</template>
