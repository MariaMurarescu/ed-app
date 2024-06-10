<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex justify-between items-center">

        <div class="flex items-center">
          <h1 class="text-2xl font-bold text-gray-900">Lecții, materiale și ce mai e nevoie</h1>

          <input v-model="search" @change="getLessons(null)"
            class="ml-4 appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            placeholder="Caută lecție">
        </div>

        <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">Afișează pe pagină</span>
        <select @change="getLessons(null)" v-model="perPage"
                class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option value="3">3</option>
          <option value="6">6</option>
          <option value="9">9</option>
          <option value="12">12</option>
        </select>
        <span class="ml-3">lecții {{lessons.total}} găsite </span>
      </div>

        

        <router-link :to="{ name: 'LessonCreate' }"
          class="ml-4 appearance-none relative block w-48 py-2 px-3 text-white bg-emerald-600 rounded-md hover:bg-emerald-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -mt-1 inline-block" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Adaugă lecție
        </router-link>
      </div>
    </template>


    <div v-if="lessons.loading" class="flex justify-center">Se încarcă...</div>
    <div v-else-if="lessons.data.length">
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">
        <LessonListItem v-for="(lesson, ind) in lessons.data" :key="lesson.id" :lesson="lesson"
          class="opacity-0 animate-fade-in-down" :style="{ animationDelay: `${ind * 0.1}s` }"
          @delete="deleteLesson(lesson)" />
      </div>



      <div class="flex justify-center mt-5">
        <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <a v-for="(link, i) of lessons.links" :key="i" :disabled="!link.url" href="#" @click="getForPage($event, link)"
            aria-current="page"
            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap" :class="[
              link.active
                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
              i === 0 ? 'rounded-l-md bg-gray-100 text-gray-700' : '',
              i === lessons.links.length - 1 ? 'rounded-r-md' : '',
            ]" v-html="link.label">
          </a>
        </nav>
      </div>
    </div>
    <div v-else class="text-gray-600 text-center py-16">
      Nu aveți lecții adăugate!
    </div>
  </PageComponent>
</template>
   
<script setup>
import LessonListItem from '../components/LessonListItem.vue';
import PageComponent from '../components/PageComponent.vue';
import store from "../store";
import { computed, ref } from "vue";
import {LESSONS_PER_PAGE} from "../constants";

const lessons = computed(() => store.state.lessons);
const search = ref('');
const perPage = ref(LESSONS_PER_PAGE);


store.dispatch('getLessons'); //fetch all available lessons

function getLessons(url = null){
  store.dispatch('getLessons', {
    url,
    search: search.value,
    perPage: perPage.value,
  })
}

function deleteLesson(lesson) {
  if (
    confirm(
      `Sigur doriți să ștergeți lecția? Atenție, odată ștearsă, lecția nu mai poate fi recuperată!`
    )
  ) {
    store.dispatch("deleteLesson", lesson.id).then(() => {
      store.dispatch("getLessons");
    });
  }
}

function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }

  store.dispatch("getLessons", { url: link.url });
}

</script>