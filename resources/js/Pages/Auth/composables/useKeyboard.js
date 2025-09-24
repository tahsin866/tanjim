import { onMounted, onUnmounted } from 'vue';

export function useKeyboard(currentStep, totalSteps, nextStep, prevStep, submit) {
  const handleKeyboard = (event) => { /* ... */ };

  onMounted(() => document.addEventListener('keydown', handleKeyboard));
  onUnmounted(() => document.removeEventListener('keydown', handleKeyboard));
}