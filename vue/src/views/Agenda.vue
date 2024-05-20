<template>
  <PageComponent title="Faci azi ca să nu mai faci mâine">
    <div class="mt-8">
      <button @click="generateCode"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        Generate Enrollment Code
      </button>
      <div v-if="enrollmentCode" class="mt-4">
        <p class="text-gray-700">Enrollment Code:</p>
        <p class="font-semibold">{{ enrollmentCode }}</p>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import store from '../store';
import PageComponent from '../components/PageComponent.vue';
import { ref, computed } from 'vue';

const generateCode = () => {
  store.dispatch('generateEnrollmentCode');
};

const enrollmentCode = computed(() => store.state.enrollmentCode);
</script>
