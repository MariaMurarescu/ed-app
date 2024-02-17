<template>
  <PageComponent title="Faci azi ca să nu mai faci mâine">Conținut</PageComponent>
  <!-- TeacherComponent.vue -->

  <div>
    <button @click="generateCode">Generate Enrollment Code</button>
    <div v-if="enrollmentCode">Enrollment Code: {{ enrollmentCode }}</div>
  </div>
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

