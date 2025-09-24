<template>
  <div 
  
   style="font-family: 'SolaimanLipi', sans-serif;"
  class="privacy-container bg-blue-50 min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-3xl space-y-8">
      <!-- Privacy Policy Section -->
      <section class="bg-white rounded-xl shadow p-6">
        <h1 class="text-2xl font-bold text-blue-800 mb-4">Privacy Policy</h1>
        <p class="text-gray-700 mb-2">
          This is the official shop website of <span class="font-semibold text-blue-700">তানযীমে আবনায়ে জামিয়া ফরিদাবাদ</span>,
          <a href="https://www.abnaefaridabad.com" target="_blank" class="text-blue-600 hover:underline">www.abnaefaridabad.com</a>.
        </p>
        <p class="text-gray-700 mb-2">
          This page informs visitors about our policies regarding the collection, use, and disclosure of Personal Information when using our Service.
        </p>
        <p class="text-gray-700 mb-2">
          By using our Service, you agree to the collection and use of information as described in this policy. Personal Information is used for providing and improving the Service. We do not share your information except as described here.
        </p>
        <p class="text-gray-700 mb-2">
          The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
          <div>
            <h2 class="text-lg font-semibold text-blue-700 mb-1">Information Collection and Use</h2>
            <p class="text-gray-700 mb-1">
              For a better experience, we may require personal information. The information is retained and used as described in this privacy policy.
            </p>
            <p class="text-gray-700 mb-1">
              The app uses third party services that may collect information used to identify you. 
              <a href="https://policies.google.com/privacy" target="_blank" class="text-blue-600 hover:underline">Google Privacy Policy</a>.
            </p>
            <h2 class="text-lg font-semibold text-blue-700 mt-4 mb-1">Log Data</h2>
            <p class="text-gray-700 mb-1">
              In case of an error, we collect Log Data (IP address, device name, OS version, app configuration, time and date, etc.).
            </p>
          </div>
          <div>
            <h2 class="text-lg font-semibold text-blue-700 mb-1">Cookies</h2>
            <p class="text-gray-700 mb-1">
              This Service does not explicitly use cookies, but third party code and libraries may.
            </p>
            <h2 class="text-lg font-semibold text-blue-700 mt-4 mb-1">Service Providers</h2>
            <p class="text-gray-700 mb-1">
              Third-party companies and individuals may help provide or analyze our Service. They can access your Personal Information only to perform assigned tasks.
            </p>
            <h2 class="text-lg font-semibold text-blue-700 mt-4 mb-1">Security</h2>
            <p class="text-gray-700 mb-1">
              We strive to protect your Personal Information, but no method is 100% secure.
            </p>
            <h2 class="text-lg font-semibold text-blue-700 mt-4 mb-1">Links to Other Sites</h2>
            <p class="text-gray-700 mb-1">
              Our Service may link to other sites not operated by us. Please review their Privacy Policies.
            </p>
            <h2 class="text-lg font-semibold text-blue-700 mt-4 mb-1">Children’s Privacy</h2>
            <p class="text-gray-700 mb-1">
              We do not knowingly collect data from anyone under 13. If discovered, such information is deleted.
            </p>
          </div>
        </div>
      </section>

      <!-- Refund Policy Section -->
      <section class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-green-700 mb-2">Our Refund Policy</h2>
        <p class="text-gray-700">
          Every donation is precious and used promptly to help others. By donating, you confirm your intent to support our work.
          <span class="font-semibold text-red-600 block mt-2">
            We do not offer refunds for any donation or any items received in exchange for donations.
          </span>
        </p>
      </section>

      <!-- Contact Section -->
      <section class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
        <h2 class="text-xl font-bold text-blue-700 mb-2">Contact Us</h2>
        <p class="text-gray-700 text-center mb-2">
          If you have any questions or suggestions about our Privacy Policy, contact:
        </p>
        <a href="mailto:abndaefaridabad@gmail.com" class="text-blue-600 hover:underline font-semibold">abndaefaridabad@gmail.com</a>
      </section>

      <!-- Footer -->
      <footer class="border-t pt-4 text-gray-500 text-xs flex flex-col md:flex-row md:justify-between items-center bg-white rounded-xl shadow px-2">
        <span class="mb-2 md:mb-0">&copy; 2025 <span class="font-bold text-blue-700">তানযীমে আবনায়ে জামিয়া ফরিদাবাদ</span> – All rights reserved.</span>
        <span>Technical support by <span class="font-bold text-green-700">Quantic Dynamics</span></span>
     <div class="flex space-x-4">
        <a href="/terms" class="footer-link">Terms & Conditions</a>
        <a href="/return-policy" class="footer-link">Return & Refund</a>
        <a href="/privacy" class="footer-link">Privacy Policy</a>
      </div>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  name: "PrivacyRefund",
};
</script>

<style scoped>
.privacy-container {
  font-family: 'Inter', sans-serif;
  line-height: 1.75;
}
section {
  transition: box-shadow 0.15s;
}
section:hover {
  box-shadow: 0 8px 24px #38bdf822;
}
.footer-link {
  color: #2563eb;
  font-weight: 500;
  transition: color 0.18s, background 0.18s;
  text-decoration: none;
  padding: 2px 8px;
  border-radius: 4px;
}
.footer-link:hover {
  color: #1d4ed8;
  background: #e0e7ff;
}
</style>