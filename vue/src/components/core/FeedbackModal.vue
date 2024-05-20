<!-- FeedbackModal.vue -->
<template>
    <div v-if="show" class="fixed inset-0 overflow-y-auto">
      <!-- Modal backdrop -->
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Modal overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
  
        <!-- Modal content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <!-- Continutul modalului -->
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Trimite Feedback</h3>
            <!-- Aici adaugăm formularul pentru trimiterea feedback-ului -->
            <!-- Formularul ar trebui să includă lista de întrebări și câmpurile pentru feedback -->
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button @click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Închide</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      show: Boolean, // Proprietatea pentru afișarea/ascunderea modalului
      lessons: Array, // Lista lecțiilor disponibile
      students: Array, // Lista studenților disponibili
    },
    methods: {
      closeModal() {
        // Emitem un eveniment pentru închiderea modalului
        this.$emit('update:show', false);
      },
    },
  };
  </script>
  