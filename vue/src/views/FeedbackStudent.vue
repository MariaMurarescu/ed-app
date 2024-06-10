<template>
  <div class="max-w-2xl mx-auto p-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Feedback pentru Lecția 1</h2>
    <ul v-if="feedback.length" class="space-y-4">
      <li v-for="item in feedback" :key="item.id" class="bg-white p-4 rounded-lg shadow-sm">
        <p class="text-lg text-gray-700"><strong>Feedback:</strong> {{ item.feedback }}</p>
        <div class="mt-2 text-sm text-gray-500 flex justify-between">
        </div>
      </li>
    </ul>
    <p v-else class="text-center text-gray-600 text-lg">Nu există feedback disponibil pentru această lecție.</p>
  </div>
</template>

<script>
import axiosClient from '../axios'; 
export default {
  data() {
    return {
      feedback: []
    };
  },
  mounted() {
    this.fetchFeedback();
  },
  methods: {
    fetchFeedback() {
      axiosClient.get(`/feedback/11`) 
        .then(response => {
          this.feedback = response.data;
        })
        .catch(error => {
          console.error('Error fetching feedback:', error);
        });
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('ro-RO', options);
    }
  }
}
</script>

