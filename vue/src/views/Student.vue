<template>
  <PageComponent>
    <!-- Search Bar -->
    <div class="flex justify-between items-center mb-4">
      <div class="flex items-center">
        <h1 class="text-2xl font-bold text-gray-900">Lecții, materiale și ce mai e nevoie</h1>
        <input v-model="search" @input="getStudentLessons"
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
    <div v-else-if="paginatedStudentLessons.length">
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">
        <div v-for="lesson in paginatedStudentLessons" :key="lesson.id"
          class="flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[470px]">

          <!-- Display Student Lesson Details -->
          <img v-if="lesson.image_url" :src="lesson.image_url" alt=""
            class="w-full h-40 object-cover rounded-md mb-4" />
          <h1 class="text-lg font-semibold mb-2">{{ lesson.title }}</h1>
          <p v-if="lesson.description" class="overflow-hidden flex-1 text-gray-500 mb-2 flex-grow">{{
            lesson.description }}</p>
          <p v-if="lesson.keywords" class="text-indigo-500 mr-2">{{ lesson.keywords }}</p>


          <div class="mt-auto"></div> <!-- Ensure buttons stay at the bottom -->

          <div class="flex justify-between items-center mt-3">
            <router-link
              :to="{ name: 'StudentLessonView', params: { slug: lesson.slug, id: lesson.id, lesson_id: lesson.id, user_id: lesson.user_id } }"
              class="flex py-2 px-3 md:px-2 border border-transparent text-sm rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
              </svg>
              Parcurge lectie
            </router-link>

            <!-- Like button with thumb-up SVG -->
            <button @click="likeLesson(lesson.id)"
              class="flex items-center py-2 px-3 md:px-2 border border-transparent text-sm rounded-md text-white bg-green-500 hover:bg-green-600 focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                <path d="M7 21H3a2 2 0 01-2-2V5a2 2 0 012-2h4m9 0h4a2 2 0 012 2v14a2 2 0 01-2 2h-4m-7-5V3h12">
                </path>
              </svg>
              Like
            </button>

            <!-- Generate PDF -->
            <button @click="generatePDF(lesson)"
              class="flex py-2 px-3 md:px-2 border border-transparent text-sm rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M13 2a2 2 0 012 2v1h2a2 2 0 012 2v8a2 2 0 01-2 2h-2v1a2 2 0 01-2 2h-6a2 2 0 01-2-2v-1H3a2 2 0 01-2-2V7a2 2 0 012-2h2V4a2 2 0 012-2h6zM7 4v2h6V4H7zm8 10H5v-2h10v2z"
                  clip-rule="evenodd" />
              </svg>
              Creează PDF
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="text-gray-600 text-center py-16">
      Nu aveți lecții adăugate!
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-8">
      <div>
        <button @click="redirectToFirstPage" class="px-4 py-2 mr-2 bg-gray-200 rounded-md">First Page</button>
        <button @click="prevPage" :disabled="currentPage === 1"
          class="px-4 py-2 mr-2 bg-gray-200 rounded-md">Previous</button>
        <span>{{ currentPage }} / {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages"
          class="px-4 py-2 ml-2 bg-gray-200 rounded-md">Next</button>
        <button @click="redirectToLastPage" class="px-4 py-2 ml-2 bg-gray-200 rounded-md">Last page</button>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from '../components/PageComponent.vue';
import { ref, onMounted, computed, watch } from 'vue';
import { useStore } from 'vuex';
import { createPDF } from '../utils/pdfUtils';


const store = useStore();
const loadingStudent = ref(true);
const studentLessons = ref([]);

const search = ref('');
const perPage = ref(6);
const currentPage = ref(1);

// Fetch student lessons from the server based on role ID
async function getStudentLessons() {
  loadingStudent.value = true;
  try {
    const studentResponse = await store.dispatch('fetchLessonsByRoleId', 2); // Change the role ID as needed
    const lessonsWithImageUrl = studentResponse.data.lessons.map(lesson => ({
      ...lesson,
      image_url: lesson.image ? `http://localhost:8000/${lesson.image}` : null
    }));
    studentLessons.value = lessonsWithImageUrl.filter(lesson => lesson.title.toLowerCase().includes(search.value.toLowerCase()));
    loadingStudent.value = false;
  } catch (error) {
    console.error('Error fetching student lessons:', error);
    loadingStudent.value = false;
  }
}

// Compute the total number of pages based on the number of lessons and lessons per page
const totalPages = computed(() => Math.ceil(studentLessons.value.length / perPage.value));

// Compute the paginated student lessons based on the current page and lessons per page
const paginatedStudentLessons = computed(() => {
  const startIndex = (currentPage.value - 1) * perPage.value;
  const endIndex = startIndex + perPage.value;
  return studentLessons.value.slice(startIndex, endIndex);
});

// Watch for changes in search or perPage, and get student lessons accordingly
watch([search, perPage], () => {
  getStudentLessons();
});

// Function to change the current page
function prevPage() {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
}

function nextPage() {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
}

function redirectToFirstPage() {
  currentPage.value = 1;
}

// Method to redirect to the last page
function redirectToLastPage() {
  currentPage.value = totalPages.value;
}

// Update the generatePDF function to accept a lesson parameter
async function generatePDF(lesson) {
  // Modify description for lessons with empty description
  const lessonWithDefaultDescription = {
    ...lesson,
    description: lesson.description || "No description available"
  };

  // Log the lesson data just before generating the PDF
  console.log("Lesson Data:", lessonWithDefaultDescription);

  // Generate PDF with modified lesson data
  createPDF(lessonWithDefaultDescription);
}

//  likeLesson method
const likeLesson = async (lessonId) => {
  try {
    await store.dispatch('likeLesson', lessonId);
  } catch (error) {
    console.error('Error liking lesson:', error);
  }
}





// Fetch student lessons on component mount
onMounted(getStudentLessons);
</script>
