<template>
  <div class="min-h-full flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
  <div class="w-full max-w-md space-y-8">
    <div>
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Alege o parolă nouă</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
      </p>
    </div>

  <form class="mt-8 space-y-6" @submit="register">
    <input type="hidden" name="remember" value="true" />

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="#" method="POST">
        <div>
          <label for="new-password" class="block text-sm font-medium leading-6 text-gray-900">Noua parolă</label>
          <div class="mt-2">
            <input id="new-password" name="password" type="password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <label for="repet-password" class="block text-sm font-medium leading-6 text-gray-900">Repetă parola</label>
          <div class="mt-2">
            <input id="repet-password" name="password" type="password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div class="flex items-center  justify-between">
          <div class="text-sm">
            <router-link :to="{name: 'Login'}" class="font-medium text-indigo-600 hover:text-indigo-500">
              Autentificare
            </router-link>
          </div>
        </div>

      </form>
    </div>

    <div>
      <button type="submit" class="group relative flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
          <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true"/>
        </span>
        Schimbă parola
      </button>
    </div>
  </form>
  </div>
</div>
</template>

  
  <script setup>
  import {LockClosedIcon} from '@heroicons/vue/solid'
  </script>