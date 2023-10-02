<template>
  <div class="flex min-h-full items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Creează cont gratuit</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          <!-- Additional information or text can go here -->
        </p>
      </div>

      <div class="mt-4 space-y-2 text-gray-600 text-center">
        <p v-if="showPasswordInfo">Parola trebuie să conțină cel puțin 8 caractere, o majusculă, o literă mică, un număr și un caracter special.</p>
        <p v-if="showEmailInfo">Adresa de email trebuie să fie validă.</p>
      </div>

      <form class="mt-8 space-y-6" @submit.prevent="register">
        <input type="hidden" name="remember" value="true" />

        <!-- Full Name Input -->
        <div>
          <label for="fullname" class="sr-only">Nume și prenume</label>
          <input
            id="fullname"
            name="fullname"
            type="text"
            autocomplete="Nume și prenume"
            required=""
            v-model="user.name"
            class="relative block w-full rounded-t-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            placeholder="Nume și prenume"
          />
        </div>

        <!-- Email Input -->
        <div>
          <label for="email-address" class="sr-only">Adresa email</label>
          <input
            id="email-address"
            name="email"
            type="email"
            autocomplete="email"
            required=""
            v-model="user.email"
            class="relative block w-full border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            placeholder="Adresă de email"
          />
        </div>

        <!-- Password Input -->
        <div>
          <label for="password" class="sr-only">Parola</label>
          <input
            id="password"
            name="password"
            type="password"
            autocomplete="current-password"
            required=""
            v-model="user.password"
            class="relative block w-full border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            placeholder="Parolă"
          />
        </div>

        <!-- Confirm Password Input -->
        <div>
          <label for="password_confirmation" class="sr-only">Confirmă parola</label>
          <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            autocomplete="current-password"
            required=""
            v-model="user.password_confirmation"
            class="relative block w-full border-0 py-1.5 text-gray-900 rounded-b-md ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            placeholder="Confirmă parolă"
          />
        </div>

        <!-- Role Selection -->
        <div>
          <label for="role" class="sr-only">Selectează rol</label>
          <select
            id="role"
            name="role"
            v-model="user.role_id"
            class="relative block w-full border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          >
            <option value="" disabled selected>Selectează rol</option>
            <option value="1">Student</option>
            <option value="2">Teacher</option>
          </select>
        </div>

        <!-- Create Account Button -->
        <div>
          <button
            type="submit"
            class="group relative flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
            </span>
            Creează cont
          </button>
        </div>
      </form>
    </div>
  </div>

    <!-- Error Messages -->
    <div v-if="errorMessages.length" class="mt-4 space-y-2 text-red-600 text-center">
    <ul>
      <li v-for="errorMessage in errorMessages" :key="errorMessage">{{ errorMessage }}</li>
    </ul>
  </div>

</template>


<script setup>
import { ref } from 'vue';
import { LockClosedIcon } from '@heroicons/vue/20/solid'
import store from '../store';
import { useRouter } from 'vue-router';

const router = useRouter();

const errorMessages = ref([]); // Initialize an empty array for error messages

const user = ref ({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role_id: ''
});


async function register(ev) {
  ev.preventDefault();
  errorMessages.value = []; // Clear previous error messages
  showPasswordInfo = false;
  showEmailInfo = false

  try {
    // Your registration logic here
    await store.dispatch("register", user.value);
    router.push({ 
      name: "Login",
    });
    // Check for password criteria and email validation
if (user.password.length < 8) {
  showPasswordInfo = true;
  errorMessages.value.push("Parola trebuie să conțină cel puțin 8 caractere.");
} else {
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/;
  if (!passwordRegex.test(user.password)) {
    showPasswordInfo = true;
    errorMessages.value.push("Parola trebuie să conțină cel puțin o majusculă, o literă mică, un număr și un caracter special.");
  }
}

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if (!emailRegex.test(user.email)) {
  showEmailInfo = true;
  errorMessages.value.push("Adresa de email trebuie să fie validă.");
}
  } catch (error) {
    // Handle errors and add corresponding error messages
    if (error.response) {
      if (error.response.status === 422) {
        const validationErrors = error.response.data.errors;
        for (const key in validationErrors) {
          errorMessages.value.push(validationErrors[key][0]);
        }
        // Check specifically for the "email has already been taken" error message
        if (validationErrors.email && validationErrors.email[0] === "The email has already been taken.") {
          errorMessages.value.push("Please provide another email address!");
        }
      } else if (error.response.status === 500) {
        errorMessages.value.push("Server error. Please try again later.");
      }
    }
  }
}
</script>