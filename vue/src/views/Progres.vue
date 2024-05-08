<template>
  <PageComponent>
    <div class="lesson-container">
      <form @submit.prevent="handleSubmit" class="lesson-form">
        <label for="lessonId" class="form-label">Select Lesson ID:</label>
        <select v-model="selectedLessonId" id="lessonId" class="form-select">
          <option v-for="lesson in lessons" :value="lesson.id" :key="lesson.id">{{ lesson.title }}</option>
        </select>
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Fetch Likes</button>
      </form>

      <!-- Display selected lesson -->
      <div v-if="selectedLesson" class="lesson-details">
        <h2 class="lesson-title text-3xl font-bold mb-2">{{ selectedLesson.title }}</h2>
        <p class="lesson-content text-gray-700">{{ selectedLesson.content }}</p>
      </div>

      <!-- Display likes count -->
      <div v-if="likesCount !== null" class="likes-container">
        <p v-if="likesCount === 0" class="no-likes-message text-gray-700">No likes yet.</p>
        <p v-else class="likes-message text-green-500">You have {{ likesCount }} like{{ likesCount !== 1 ? 's' : '' }}.</p>
      </div>

      <!-- Display each like separately -->
      <ul v-if="selectedLessonLikes !== null" class="likes-list">
        <li v-for="(like, index) in selectedLessonLikes" :key="index" class="like-item text-gray-700">{{ like }}</li>
      </ul>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import { useStore } from 'vuex';
import { ref, onMounted } from 'vue';

// Access the store
const store = useStore();

// Define reactive variables
const selectedLessonId = ref('');
const selectedLesson = ref(null);
const selectedLessonLikes = ref([]);
const lessons = ref([]);

// Function to handle form submission
const handleSubmit = () => {
  if (selectedLessonId.value) {
    // Fetch lesson data when form is submitted
    store.dispatch('getLesson', selectedLessonId.value)
      .then(() => {
        // Once the lesson data is fetched, fetch the likes for the lesson
        store.dispatch('fetchLikesForLesson', selectedLessonId.value);
        // Set selected lesson after fetching likes
        selectedLesson.value = store.state.selectedLesson;
      })
      .catch(error => {
        console.error('Error fetching lesson:', error);
      });
  }
};

// Watch for changes in selected lesson likes
store.watch(() => store.state.selectedLessonLikes, (value) => {
  // Update selectedLessonLikes as an array containing all the likes
  selectedLessonLikes.value = value;
});

// Watch for changes in lessons
store.watch(() => store.state.lessons.data, (value) => {
  lessons.value = value;
});

// Computed property to get the count of likes
const likesCount = ref(0);
store.watch(() => selectedLessonLikes.value.length, (value) => {
  likesCount.value = value;
});

// Fetch lessons when component is mounted
onMounted(() => {
  store.dispatch('getLessons')
    .catch(error => {
      console.error('Error fetching lessons:', error);
    });
});
</script>


