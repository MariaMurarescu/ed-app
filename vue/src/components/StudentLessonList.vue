<template>
  <div class="container mx-auto my-4">
    <!-- Lesson Card Content -->
    <div class="border p-4 rounded-md shadow-md">
      <!-- Display Lesson Image -->
      <img
        :src="lesson.image_url || 'https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg'"
        :alt="lesson.title"
        class="w-full h-48 object-cover"
      />
      <!--/ Display Lesson Image -->

      <h1 class="text-2xl font-semibold mb-2">{{ lesson.title }}</h1>
      <p v-if="lesson.description" class="text-gray-500 mb-2">{{ lesson.description }}</p>
      <!-- Add more details about the lesson as needed -->

      <div class="flex justify-between items-center mt-3">
      <router-link
        :to="{ name: 'StudentLessonView', params: { id: studentLesson.id } }"
        class="flex py-2 px-4 border border-transparent text-sm rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 mr-2"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
          />
        </svg>
        Editează
      </router-link>
      </div>

    </div>
  </div>
</template>



<script setup>
import { ref } from "vue";


</script>


