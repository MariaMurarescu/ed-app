<template>
  <PageComponent>
    <div class="py-8 px-4">
      <h2 class="text-2xl font-bold mb-4">Răspunsuri lecții</h2>

      <div v-if="loading" class="text-gray-600">Se încarcă...</div>

      <div v-else>
        <ul class="divide-y divide-gray-200">
          <li v-for="answer in lessonQuestionAnswers" :key="answer.id" class="py-4 shadow-md">
            <div class="flex justify-between items-center">
              <p class="text-lg font-semibold">Trimis de: {{ answer.email }}</p>
              <button @click="selectAnswerForFeedback(answer)" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Oferă Feedback</button>
            </div>
            <p class="mt-2">{{ answer.answer }}</p>
          </li>
        </ul>
      </div>

      <!-- Modal for feedback -->
      <div v-if="showFeedbackModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
          <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Trimite Feedback</h3>
            <div class="mt-2 px-7 py-3">
              <textarea v-model="feedback" rows="4" class="w-full border rounded-md p-2" placeholder="Scrie feedbackul aici..."></textarea>
            </div>
            <div class="items-center px-4 py-3">
              <button @click="sendFeedback" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Trimite
              </button>
              <button @click="closeFeedbackModal" class="px-4 py-2 mt-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                Anulează
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from '../components/PageComponent.vue';
import { ref, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const loading = ref(false);
const store = useStore();
const route = useRoute();

const showFeedbackModal = ref(false);
const selectedAnswer = ref(null);
const feedback = ref('');

const getLessonQuestionAnswers = async () => {
  loading.value = true;
  try {
    const lessonId = parseInt(route.params.lessonId, 10);
    if (!isNaN(lessonId)) {
      await store.dispatch('getLessonQuestionAnswers', lessonId);
      console.log(store.state.lessonQuestionAnswers.data); // Log pentru a verifica datele
    } else {
      console.error('Invalid lesson ID in route');
    }
  } catch (error) {
    console.error('Error fetching lesson question answers:', error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  getLessonQuestionAnswers();
});

const lessonQuestionAnswers = computed(() => store.state.lessonQuestionAnswers.data.data || []);

const selectAnswerForFeedback = (answer) => {
  selectedAnswer.value = answer;
  showFeedbackModal.value = true;
};

const closeFeedbackModal = () => {
  showFeedbackModal.value = false;
  feedback.value = '';
};

const sendFeedback = async () => {
  if (selectedAnswer.value && feedback.value.trim()) {
    try {
      const lessonId = selectedAnswer.value.lesson_id; // Extract lesson ID from the selected answer
      const answerId = selectedAnswer.value.id; // Extract answer ID from the selected answer
      await store.dispatch('submitFeedback', { lessonId, answerId, feedback: feedback.value });
      closeFeedbackModal();
    } catch (error) {
      console.error('Error sending feedback:', error);
    }
  } else {
    console.warn('Feedback is required');
  }
};
</script>