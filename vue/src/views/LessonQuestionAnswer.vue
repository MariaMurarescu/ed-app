<template>
  <div>
    <h2>Lesson Question Answers</h2>

    <div v-if="loading">Loading...</div>

    <div v-else>
      <ul>
        <li v-for="answer in lessonQuestionAnswers" :key="answer.id">
          {{ answer.answer }}
        </li>
      </ul>
    </div>
  </div>
</template>



<script setup>
  import { ref, onMounted, computed } from 'vue';
  import { useStore } from 'vuex';
  import { useRoute } from 'vue-router';

  const loading = ref(false);
  const store = useStore();
  const route = useRoute();

  const getLessonQuestionAnswers = async () => {
    loading.value = true;
    try {
      const lessonId = parseInt(route.params.lessonId, 10);
      console.log('Lesson ID:', lessonId);
      if (!isNaN(lessonId)) {
        await store.dispatch('getLessonQuestionAnswers', lessonId);
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
</script>

