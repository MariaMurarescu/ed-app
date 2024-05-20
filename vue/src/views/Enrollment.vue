<template>
  <div class="max-w-md mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <p v-if="enrollmentCode" class="text-center text-gray-700 mb-4">Enrollment Code: {{ enrollmentCode }}</p>
    <form @submit.prevent="enrollStudent">
      <div class="mb-4">
        <label for="enrollmentCode" class="block text-gray-700 text-sm font-bold mb-2">Enter Enrollment Code:</label>
        <input v-model="userInput" type="text" id="enrollmentCode" required
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
      </div>
      <div class="flex items-center justify-center">
        <button type="submit"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Enroll
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      userInput: '',
    };
  },
  computed: {
    enrollmentCode() {
      return this.$store.state.enrollmentCode;
    },
  },
  methods: {
    enrollStudent() {
      this.$store.dispatch('enrollStudent', this.userInput);
    },
  },
};
</script>
