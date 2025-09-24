import { ref } from 'vue';

export function usePayment(form) {
  const showPaymentModal = ref(false);
  const isPaymentConfirmed = ref(false);

  const handlePaymentSubmitModal = async () => { /* ... */ };
  const handlePaymentSubmit = async () => { /* ... */ };

  return {
    showPaymentModal,
    isPaymentConfirmed,
    handlePaymentSubmitModal,
    handlePaymentSubmit,
  };
}