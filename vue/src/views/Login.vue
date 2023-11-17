
<template>
  <div>
    <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Conectează-te!</h2>
    <p class="mt-2 text-center text-sm text-gray-600">
      Sau
      {{ ' ' }}
      <router-link :to="{name: 'Register'}" class="font-medium text-indigo-600 hover:text-indigo-500">Creează gratuit un cont</router-link>
    </p>
  </div>
  <form class="mt-8 space-y-6" @submit.prevent="login">
    <div v-if="errorMsg" class="flex items-center justify-between py-3 px-5 bg-red-500 text-white rounded">
      {{ errorMsg }}
 
        <span
          @click="errorMsg = ''"
          class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
        >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </span>
      </div>
    
      <input type="hidden" name="remember" value="true" />
    <div class="-space-y-px rounded-md shadow-sm">
      <div>
        <label for="email-address" class="sr-only">Adresă de email</label>
        <input id="email-address" name="email" type="email" autocomplete="email" required="" v-model="user.email" class="relative block w-full rounded-t-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Adresă de email" />
      </div>
      <div>
        <label for="password" class="sr-only">Parolă</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required="" v-model="user.password" class="relative block w-full rounded-b-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Parolă" />
      </div>
    </div>

    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <input id="remember-me" name="remember-me" type="checkbox" v-model="user.remember" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
        <label for="remember-me" class="ml-2 block text-sm text-gray-900">Reține parolă</label>
      </div>

      <div class="text-sm">
        <router-link :to="{name: 'requestPassword'}" class="font-medium text-indigo-600 hover:text-indigo-500">Ai uitat parola?</router-link>
      </div>
    </div>

    <div>
      <button type="submit" class="group relative flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
          <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
        </span>
        Conectare
      </button>
    </div>
  </form>
</template>

<script setup>
import { LockClosedIcon } from '@heroicons/vue/20/solid'
import store from "../store";
import { useRouter } from "vue-router";
import { ref } from 'vue';

const router = useRouter();
let errorMsg = ref('');
let loading = ref(false);


const user = {
  email: "",
  password: "",
  remember: false,
  role_id: ''
};

// Define the login function
function login(ev) {
  if (store.state.user.token) {
    // If the user is already logged in, redirect them based on their role
    redirectToRole(store.state.user.role_id);
  } else {
    loading.value = true;

    store
      .dispatch("login", user)
      .then(({ user }) => {
        loading.value = false;

        // Call the redirectToRole function with the user's role
        redirectToRole(user.role_id);
      })
      .catch(({ response }) => {
        loading.value = false;
        console.log('Received error response:', response.data.message); // Log the entire response
        errorMsg.value = "An error occurred. Please try again later."; 
      });
  }
}

// Define a function to redirect based on the user's role
function redirectToRole(userRole) {
  switch (userRole) {
    case 1: // Student
      router.push({ name: 'student' });
      break;
    case 2: // Teacher
      router.push({ name: 'teacher' });
      break;
    case 3: //Admin
      router.push({name: 'app'});
      break;
    default:
      // Handle other roles or default redirection here
      router.push({ name: 'teacher' }); // Default redirection
  }
}
</script>