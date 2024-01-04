<template>
  <PageComponent title="Să vorbim cu și despre texte">
      <div v-if="loading" class="flex justify-center">Se încarcă...</div>
      <div
        v-else
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 text-gray-700"
      >
        <div
          class="bg-white shadow-md p-3 text-center flex flex-col animate-fade-in-down order-1 lg:order-2"
          style="animation-delay: 0.1s"
        >
          <h3 class="text-2xl font-semibold">Toate lecțiile</h3>
          <div
            class="text-8xl pb-4 font-semibold flex-1 flex items-center justify-center"
          >
            {{ data.totalLessons }}
          </div>
        </div>
        <div
          class="bg-white shadow-md p-3 text-center flex flex-col order-2 lg:order-4 animate-fade-in-down"
          style="animation-delay: 0.2s"
        >
          <h3 class="text-2xl font-semibold">Toate răspunsurile</h3>
          <div
            class="text-8xl pb-4 font-semibold flex-1 flex items-center justify-center"
          >
            {{ data.totalAnswers }}
          </div>
        </div>
        <div
          class="row-span-2 animate-fade-in-down order-3 lg:order-1 bg-white shadow-md p-4"
        >
          <h3 class="text-2xl font-semibold">Ultimele lecții</h3>
          <div v-if="data.latestLesson">
            <img
              :src="data.latestLesson.image_url"
              class="w-[240px] mx-auto"
              alt=""
            />
            <h3 class="font-bold text-xl mb-3">{{ data.latestLesson.title }}</h3>
            <div class="flex justify-between text-sm mb-1">
              <div>Data creare:</div>
              <div>{{ data.latestLesson.created_at }}</div>
            </div>
            <div class="flex justify-between text-sm mb-1">
              <div>Dată expirare:</div>
              <div>{{ data.latestLesson.expire_date }}</div>
            </div>
            <div class="flex justify-between text-sm mb-1">
              <div>Status:</div>
              <div>{{ data.latestLesson.status ? "Active" : "Draft" }}</div>
            </div>
            <div class="flex justify-between text-sm mb-1">
              <div>întrebări:</div>
              <div>{{ data.latestLesson.questions }}</div>
            </div>
            <div class="flex justify-between text-sm mb-3">
              <div>Răspunsuri:</div>
              <div>{{ data.latestLesson.answers }}</div>
            </div>
            <div class="flex justify-between">
              <router-link
                :to="{ name: 'LessonView', params: { id: data.latestLesson.id } }"
                class="flex py-2 px-4 border border-transparent text-sm rounded-md text-indigo-500 hover:bg-indigo-700 hover:text-white transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
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
                Editează lecție
              </router-link>

              <router-link
              :to="{ name: 'LessonQuestionAnswer', params: { lessonId: data.latestLesson.id } }"
                class="flex py-2 px-4 border border-transparent text-sm rounded-md text-indigo-500 hover:bg-indigo-700 hover:text-white transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-2"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                  <path
                    fill-rule="evenodd"
                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                    clip-rule="evenodd"
                  />
                </svg>
                Vezi răspunsurile
              </router-link>
            </div>
          </div>
          <div v-else class="text-gray-600 text-center py-16">
           Nu sunt lecții parcurse!
          </div>
        </div>
        <div
          class="bg-white shadow-md p-3 row-span-2 order-4 lg:order-3 animate-fade-in-down"
          style="animation-delay: 0.3s"
        >
          <div class="flex justify-between items-center mb-3 px-2">
            <h3 class="text-2xl font-semibold">Ultimele răspunsuri</h3>

            <a
              href="javascript:void(0)"
              class="text-sm text-blue-500 hover:decoration-blue-500"
            >
             Vedeți tot
            </a>
          </div>

          <div v-if="data.latestAnswers.length">
            <a
              href="#"
              v-for="answer of data.latestAnswers"
              :key="answer.id"
              class="block p-2 hover:bg-gray-100/90"
            >
              <div class="font-semibold">{{ answer.lesson.title }}</div>
              <small>
                Răspuns formulat în:
                <i class="font-semibold">{{ answer.end_date }}</i>
              </small>
            </a>
          </div>
          <div v-else class="text-gray-600 text-center py-16">
            Nu aveți încă răspunsuri!
          </div>
        </div>
      </div>

  </PageComponent>
</template>

<script setup>
import PageComponent from '../components/PageComponent.vue';
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const loading = computed(() => store.state.DeVorba.loading);
const data = computed(() => store.state.DeVorba.data);

store.dispatch("getDeVorbaData");

</script>