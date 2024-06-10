<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-1xl font-bold text-gray-400">
          {{ route.params.id ? model.title : "Create a Lesson" }}
        </h1>

        <div class="flex">
          <a :href="`/view/lesson/${model.slug}`" target="_blank" v-if="model.slug"
            class="flex py-2 px-4 border border-transparent text-sm rounded-md text-indigo-500 hover:bg-indigo-700 hover:text-white transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            Afișare link public
          </a>
          <!-- Delete lesson button -->
          <button v-if="route.params.id" type="button" @click="deleteLesson()"
            class="py-2 px-3 text-white bg-red-500 rounded-md hover:bg-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -mt-1 inline-block" viewBox="0 0 20 20"
              fill="currentColor">
              <path fill-rule="evenodd"
                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                clip-rule="evenodd" />
            </svg>
            Șterge lecție
          </button>
        </div>
      </div>

    </template>
    <div v-if="lessonLoading" class="flex justify-center">Se încarcă...</div>
    <form v-else @submit.prevent="saveLesson" class="animate-fade-in-down">
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <!-- Lesson Fields -->
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <!-- Image -->
          <div>
            <label class="block text-sm font-medium text-gray-700">
              Imagine
            </label>
            <div class="mt-1 flex items-center">
              <img v-if="model.image_url" :src="model.image_url" :alt="model.title" class="w-64 h-48 object-cover" />
              <span v-else class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[80%] w-[80%] text-gray-300" viewBox="0 0 20 20"
                  fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                    clip-rule="evenodd" />
                </svg>
              </span>
              <button type="button"
                class="relative overflow-hidden ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <input type="file" @change="onImageChoose"
                  class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer" />
                Schimbă
              </button>
            </div>
          </div>
          <!--/ Image -->

          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-500">Titlul</label>
            <input type="text" name="title" id="title" v-model="model.title" autocomplete="lesson_title"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-200 rounded-md" />
          </div>
          <!--/ Title -->

          <!-- Description -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700">
              Descrierea lecției
            </label>
            <div class="mt-1">
              <textarea id="description" name="description" rows="3" v-model="model.description"
                autocomplete="lesson_description"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                placeholder="Descrie lecția" />
            </div>
          </div>
          <!-- Description -->

          <!-- Aim -->
          <div>
              <label for="keywords" class="block text-sm font-medium text-gray-700">Obiective</label>
              <input type="text" name="aim" id="aim" v-model="model.aim" autocomplete="lesson_aim"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
            </div>
            <!--/ Aim -->

          <!-- Keywords -->
          <div>
            <label for="keywords" class="block text-sm font-medium text-gray-700">Cuvinte cheie</label>
            <input type="text" name="keywords" id="keywords" v-model="model.keywords" autocomplete="lesson_keywords"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
          </div>
          <!--/ Keywords -->

          <!-- Expire Date -->
          <div>
            <label for="expire_date" class="block text-sm font-medium text-gray-700">Termen</label>
            <input type="date" name="expire_date" id="expire_date" v-model="model.expire_date"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
          </div>
          <!--/ Expire Date -->

          <!-- Status -->
          <div class="flex items-start">
            <div class="flex items-center h-5">
              <input id="status" name="status" type="checkbox" v-model="model.status"
                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
            </div>
            <div class="ml-3 text-sm">
              <label for="status" class="font-medium text-gray-700">Activ</label>
            </div>
          </div>
          <!--/ Status -->
        </div>
        <!--/ Lesson Fields -->

        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <h3 class="text-2xl font-semibold flex items-center justify-between">
            Întrebări

            <!-- Add new question -->
            <button type="button" @click="addQuestion()"
              class="flex items-center text-sm py-1 px-4 rounded-sm text-white bg-gray-600 hover:bg-gray-700">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                  clip-rule="evenodd" />
              </svg>
              Adaugă întrebare
            </button>
            <!--/ Add new question -->
          </h3>
          <div v-if="!model.questions.length" class="text-center text-gray-600">
            Nu aveți întrebări adăugate!
          </div>
          <div v-for="(question, index) in model.questions" :key="question.id">
            <QuestionEditor :question="question" :index="index" @change="questionChange" @addQuestion="addQuestion"
              @deleteQuestion="deleteQuestion" />
          </div>
        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <button type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Salvează
          </button>
        </div>
      </div>
    </form>
  </PageComponent>
</template>

<script setup>
import { v4 as uuidv4 } from "uuid";
import { computed, ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import store from "../store";
import PageComponent from "../components/PageComponent.vue";
import QuestionEditor from "../components/QuestionEditor.vue";

const router = useRouter();

const route = useRoute();

// Get lesson loading state, which only changes when we fetch lesson from backend
const lessonLoading = computed(() => store.state.currentLesson.loading);

// Create empty lesson
let model = ref({
  title: "",
  slug: "",
  status: false,
  description: null,
  aim: null,
  keywords: null,
  image_url: null,
  expire_date: null,
  questions: [],
});

if (route.params.id) {
  store.dispatch("getLesson", route.params.id);
}

// Watch to current lesson data change and when this happens we update local model
watch(
  () => store.state.currentLesson.data,
  (newVal, oldVal) => {
    model.value = {
      ...JSON.parse(JSON.stringify(newVal)),
      status: newVal.status !== "draft",
    };
  }
);

// If the current component is rendered on lesson update route we make a request to fetch lesson
if (route.params.id) {
  store.dispatch("getLessons", route.params.id);
}

function onImageChoose(ev) {
  const file = ev.target.files[0];

  const reader = new FileReader();
  reader.onload = () => {
    // The field to send on backend and apply validations
    model.value.image = reader.result;

    // The field to display here
    model.value.image_url = reader.result;
    ev.target.value = "";
  };
  reader.readAsDataURL(file);
}

function addQuestion(index) {
  const newQuestion = {
    id: uuidv4(),
    type: "text",
    question: "",
    description: null,
    data: {},
  };

  model.value.questions.splice(index, 0, newQuestion);
}


function deleteQuestion(question) {
  model.value.questions = model.value.questions.filter((q) => q !== question);
}


function questionChange(question) {
  // Important to explicitelly assign question.data.options, because otherwise it is a Proxy object
  // and it is lost in JSON.stringify()
  if (question.data.options) {
    question.data.options = [...question.data.options];
  }
  model.value.questions = model.value.questions.map((q) => {
    if (q.id === question.id) {
      return JSON.parse(JSON.stringify(question));
    }
    return q;
  });
}


// Create or update lesson

const errors = ref({});

function saveLesson() {
  store.dispatch("saveLesson", { ...model.value }).then(({ data }) => {
    store.commit("notify", {
      type: "success",
      message: "Lecția a fost " + (model.value.id ? "modificată" : "creată") + "!",
    });
    // Update the image URL with the path returned from the backend
    model.value.image_url = data.data.image_url;
    router.push({
      name: "LessonView",
      params: { id: data.data.id },
    });
  }).catch(error => {
    console.error("Save lesson error:", error);
  });
}

function deleteLesson() {
  if (
    confirm(
      `Sigur doriți să ștergeți lecția? Atenție, odată ștearsă, lecția nu mai poate fi recuperată!`
    )
  ) {
    store.dispatch("deleteLesson", model.value.id).then(() => {
      router.push({
        name: "Lessons",
      });
    });
  }
}

</script>