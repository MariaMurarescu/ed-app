<template>
    <PageComponent>
        <div class="py-5 px-8">

<!-- Add the email input field -->
<div class="mb-4">
    <label for="email" class="block text-sm font-medium text-gray-700">Adresă email elev</label>
    <input v-model="email" type="email" id="email" name="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
    <p v-if="showEmailError" class="mt-2 text-sm text-red-500">Te rog, utiliează o adresă de email validă!</p>
  </div>

  <div v-if="loading" class="flex justify-center">Se încarcă...</div>
  <form @submit.prevent="submitLesson" v-else class="container mx-auto">
    <div class="grid grid-cols-6 items-center">
      <div class="mr-4">
        <img :src="lesson.image_url" alt="" />
      </div>
      <div class="col-span-5">
        <h1 class="text-3xl mb-3">{{ lesson.title }}</h1>
        <p class="text-gray-500 text-sm" v-html="lesson.description"></p>
        <p class="text-indigo-500 text-sm" v-html="lesson.keywords"></p>
      </div>
    </div>

    <div v-if="lessonFinished" class="py-8 px-6 bg-emerald-400 text-white w-[600px] mx-auto">
      <div class="text-xl mb-3 font-semibold ">Vă mulțumim că ați parcurs această lecție!</div>
      <button @click="submitAnotherResponse" type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Alegeți să parcurgeți din nou lecția
      </button>
    </div>
    <div v-else>
      <hr class="my-3">
      <div v-for="(question, ind) of lesson.questions" :key="question.id">
        <QuestionViewer
          v-model="answers[question.id]"
          :question="question"
          :index="ind"
        />
      </div>

      <button
        type="submit"
        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Trimite
      </button>
    </div>
  </form>
</div>


    </PageComponent>

</template>

<script setup>

import { computed, ref, watch } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import QuestionViewer from "../components/QuestionViewer.vue"
import PageComponent from '../components/PageComponent.vue';

const route = useRoute();
const store = useStore();

const loading = computed(() => store.state.currentLesson.loading);
const lesson = computed(() => store.state.currentLesson.data);

const lessonFinished = ref(false);


//'answers' = object and the key will be the question id and the value will be the chosen answer on that question
const answers = ref({}); 

store.dispatch("getLessonBySlug", route.params.slug);

const submissionCount = ref(0);
const email = ref('');
const showEmailError = ref(false);

watch(
  () => route.params.slug,
  async (newSlug) => {
    try {
      await store.dispatch("getLessonBySlug", newSlug);
    } catch (error) {
      console.error('Error fetching lesson:', error);
    }
  },
  { immediate: true } // Fetch the lesson immediately when the component is mounted
);

function submitLesson() {
  if (submissionCount.value >= 3) {
    console.log('You have already submitted two responses.');
    return;
  }

  console.log(JSON.stringify(answers.value, undefined, 2));
  store
    .dispatch("saveLessonAnswer", {
      lessonId: lesson.value.id,
      answers: answers.value,
      email: email.value,
    })
    .then((response) => {
      if (response.status === 201) {
        lessonFinished.value = true;
        submissionCount.value++; 
      }
    });
}

function submitAnotherResponse() {
  if (submissionCount.value >= 3) {
    console.log('You have already submitted two responses.');
    return;
  }

  answers.value = {};
  lessonFinished.value = false;
  submissionCount.value++; 
}

</script>