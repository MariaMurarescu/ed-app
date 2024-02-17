<template>
  <div>
    <p v-if="enrollmentCode">Enrollment Code: {{ enrollmentCode }}</p>
    <form @submit.prevent="enrollStudent">
      <label for="enrollmentCode">Enter Enrollment Code:</label>
      <input v-model="userInput" type="text" id="enrollmentCode" required>
      <button type="submit">Enroll</button>
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