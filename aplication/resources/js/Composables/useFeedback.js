import { ref } from 'vue';

const feedback = ref({ show: false, timeout: 3000, color: 'success', text: '' });

export function useFeedback() {
    const trigger = (text, color = 'success', timeout = 3000) => {
        feedback.value = { show: true, text, color, timeout };
    };
    return { feedback, trigger };
}