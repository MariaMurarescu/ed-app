<template>
  <div v-if="selectedLessonWithAnswers">
    <h2 v-if="selectedLessonWithAnswers.lesson">{{ selectedLessonWithAnswers.lesson.title }}</h2>
    <div v-if="selectedLessonWithAnswers.answers.length > 0">
      <ul>
        <li v-for="(answer, index) in selectedLessonWithAnswers.answers" :key="index">
          {{ answer.content }}
          <button @click="submitFeedback(selectedLessonWithAnswers.lesson.id, answer.id)">Submit Feedback</button>
        </li>
      </ul>
    </div>
    <div v-else>
      No answers available.
    </div>
  </div>
  <div v-else>
    Loading...
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const selectedLessonWithAnswers = computed(() => store.state.selectedLessonWithAnswers);

const submitFeedback = (lessonId, answerId) => {
  const feedback = prompt('Enter your feedback:');
  if (feedback) {
    store.dispatch('submitFeedback', { lessonId, answerId, feedback });
  }
};
</script>
