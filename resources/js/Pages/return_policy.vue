<template>
  <div 
  
  style="font-family: 'SolaimanLipi', sans-serif;"
  
  class="refund-footer-container  mt-10 bg-blue-50 min-h-[35vh] flex flex-col justify-between p-6 max-w-2xl mx-auto rounded-xl shadow">
    <!-- Refund Policy Section -->
    <section class="mb-6 bg-white rounded-lg shadow-sm p-5">
      <h2 class="text-xl font-bold text-blue-800 mb-2">Our Refund Policy</h2>
      <p class="text-gray-700 leading-relaxed">
        Every donation is precious and used promptly to help others. By donating, you confirm your intent to support our work. 
        <span class="font-semibold text-red-600">We do not offer refunds for any donation or any items received in exchange for donations.</span>
      </p>
    </section>

    <!-- Footer Section -->
    <footer class="border-t pt-4 text-gray-600 text-xs flex flex-col md:flex-row md:justify-between items-center bg-white rounded-lg shadow-sm">
      <p class="mb-2 md:mb-0">
        &copy; 2025 <span class="font-bold text-blue-700">তানযীমে আবনায়ে জামিয়া ফরিদাবাদ</span> – All rights reserved. Technical support by <span class="font-bold text-green-700">Quantic Dynamics</span>.
      </p>
      <div class="flex space-x-4">
        <a href="#" class="footer-link">Terms & Conditions</a>
        <a href="#" class="footer-link">Return & Refund</a>
        <a href="#" class="footer-link">Privacy Policy</a>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: "RefundFooter",
};
</script>

<style scoped>
.refund-footer-container {
  font-family: 'Inter', sans-serif;
  line-height: 1.7;
}

section {
  transition: box-shadow 0.18s;
}
section:hover {
  box-shadow: 0 8px 24px #38bdf822;
}

.footer-link {
  color: #2563eb;
  font-weight: 500;
  transition: color 0.18s;
  text-decoration: none;
  padding: 2px 6px;
  border-radius: 4px;
}
.footer-link:hover {
  color: #1d4ed8;
  background: #e0e7ff;
}
</style>