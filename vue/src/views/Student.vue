<template>
  <PageComponent>

    <!-- Search Bar -->
    <div class="flex justify-between items-center mb-4">
      <div class="flex items-center">
        <h1 class="text-2xl font-bold text-gray-900">Lecții, materiale și ce mai e nevoie</h1>

        <input v-model="search" @input="onSearchInput"
          class="ml-4 appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
          placeholder="Caută lecție" />
      </div>

      <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">Afișează pe pagină</span>
        <select @change="onPerPageChange" v-model="perPage"
          class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option value="3">3</option>
          <option value="6">6</option>
          <option value="9">9</option>
          <option value="12">12</option>
        </select>
      </div>
    </div>


    <!-- Display Student Lessons -->
    <div v-if="loadingStudent" class="flex justify-center">Se încarcă...</div>
    <template v-else>
      <div v-for="studentLesson in studentLessons" :key="studentLesson.id" class="container mx-auto my-4">
        <!-- Display Student Lesson Details -->

        <div class="border p-4 rounded-md shadow-md">
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">
            <div class="col-span-3">

              <img v-if="studentLesson.image" :src="studentLesson.image" alt=""
                class="w-20 h-20 object-cover rounded-full" />
              <!-- Add fallback or default image -->
              <span v-else class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[80%] w-[80%] text-gray-500" viewBox="0 0 20 20"
                  fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                    clip-rule="evenodd" />
                </svg>
              </span>

            </div>

            <div class="col-span-5 ml-4">
              <h1 class="text-2xl font-semibold mb-2">{{ studentLesson.title }}</h1>
              <p v-if="studentLesson.description" class="text-gray-500 mb-2">{{ studentLesson.description }}</p>
              <p v-if="studentLesson.keywords" class="text-indigo-500">{{ studentLesson.keywords }}</p>
              <!-- Display other lesson properties as needed -->

              <div class="flex justify-between items-center mt-3">
                <button
                  class="flex py-2 px-4 border border-transparent text-sm rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                  </svg>
                  Parcurge lecție
                </button>

              </div>
            </div>
          </div>
        </div>
      </div>
      
    </template>
    
  </PageComponent>
</template>

<script setup>
import PageComponent from '../components/PageComponent.vue';
import StudentLessonList from '../components/StudentLessonList.vue';

import { ref, onMounted, watch } from 'vue';
import { useStore } from 'vuex';


const store = useStore();
const loadingStudent = ref(true);
const studentLessons = ref([]);
const search = ref('');
const perPage = ref(6);

onMounted(async () => {


  // Fetch student lessons
  try {
    const studentResponse = await store.dispatch('fetchLessonsByRoleId', 2); // Replace 2 with the role_id for students
    studentLessons.value = studentResponse.data.lessons;
    loadingStudent.value = false;
  } catch (error) {
    console.error('Error fetching student lessons:', error);
    loadingStudent.value = false;
  }


});
</script>
