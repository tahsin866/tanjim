<template>
  <div 
    style="font-family: 'SolaimanLipi', sans-serif;"
  class="min-h-screen bg-blue-50 flex items-center justify-center px-4 py-10">
    <div class="terms-container w-full max-w-3xl bg-white rounded-xl shadow-lg p-8">
      <!-- Header -->
      <header class="mb-8 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-900 mb-2">Terms and Conditions</h1>
        <a
          href="https://www.abnaefaridabad.com/"
          target="_blank"
          class="text-blue-600 hover:underline text-sm"
        >
          www.abnaefaridabad.com
        </a>
      </header>

      <div class="grid grid-cols-1 gap-6">
        <section>
          <h2 class="section-heading">Conditions of Use</h2>
          <p>
            Using the <strong>abnaefaridabad</strong> website constitutes agreement to our terms of use. Please review the following information carefully.
          </p>
        </section>
        <section>
          <h2 class="section-heading">Trademarks</h2>
          <p>
            The <strong>abnaefaridabad</strong> and other marks indicated on our site are trademarks owned exclusively by us. Unauthorized use of these trademarks and trade dress is prohibited, especially in any manner that seeks to disparage or discredit <strong>abnaefaridabad</strong> or causes confusion among our customers.
          </p>
        </section>
        <section>
          <h2 class="section-heading">Copyright</h2>
          <p>
            All website content is the exclusive property of <strong>abnaefaridabad</strong>, including generated text, graphics, logos, icons, images, audio/video clips, downloads, and software. This content is protected by Bangladesh and international copyright laws.
          </p>
        </section>
        <section>
          <h2 class="section-heading">Protecting Your Account</h2>
          <p>
            Some portions of this website permit usernames and passwords. You are responsible for protecting your unique credentials and all activities performed under your account.
          </p>
        </section>
        <section>
          <h2 class="section-heading">License And Site Access</h2>
          <p>
            <strong>abnaefaridabad</strong> grants you a limited license to access and use this website personally. This excludes downloading/collecting content, copying account information, or exploiting the site for any commercial purpose without written permission. Unauthorized use voids this license.
          </p>
        </section>
        <section>
          <h2 class="section-heading">Limitation of Liability</h2>
          <p>
            This site is provided by <strong>abnaefaridabad</strong> on an “as is” and “as available” basis. No warranties, either expressed or implied, are made regarding site operation or content. You agree to use this site at your own risk.
          </p>
          <p>
            <strong>abnaefaridabad</strong> cannot warrant that this site, our servers, or related emails are free from viruses. We are not responsible for any damages resulting from use of this site, including direct, indirect, incidental, punitive, and consequential damages.
          </p>
        </section>
        <section>
          <h2 class="section-heading text-green-700">Our Refund Policy</h2>
          <p>
            Every donation is valuable and used quickly to help others. By donating, you confirm your intent to support our work. <span class="font-semibold text-red-600">We do not offer refunds for any donation or related items.</span>
          </p>
        </section>
        <section>
          <h2 class="section-heading">Applicable Law</h2>
          <p>
            By visiting this website, you agree that the laws of Bangladesh will govern these Conditions of Use and any dispute between you and <strong>abnaefaridabad</strong>.
          </p>
        </section>
        <section>
          <h2 class="section-heading">Changes In Policy</h2>
          <p>
            <strong>abnaefaridabad</strong> reserves the right to modify or update these policies at any time. Such changes do not nullify our rights if breaches occurred under a previous version.
          </p>
        </section>
      </div>

      <footer class="mt-8 pt-6 border-t flex flex-col md:flex-row md:justify-between items-center text-gray-500 text-xs">
        <span class="mb-2 md:mb-0">&copy; 2025 <span class="font-bold text-blue-700">abnaefaridabad</span> – All rights reserved.</span>
        <span>Technical support by <span class="font-bold text-green-700">Quantic Dynamics</span></span>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  name: "TermsConditions",
};
</script>

<style scoped>
.terms-container {
  line-height: 1.75;
  font-family: 'Inter', sans-serif;
}
.section-heading {
  @apply text-lg md:text-xl font-semibold text-blue-700 mb-1;
}
section {
  transition: box-shadow 0.18s;
  border-radius: 0.7rem;
  padding: 0.5rem 0.5rem 0.5rem 0;
}
section:hover {
  box-shadow: 0 4px 12px #38bdf822;
  background: #f0f9ff;
}
</style>