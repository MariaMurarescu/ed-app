<template>
    <div>
      <!-- Student-specific layout content -->
      <header></header>
      <div class="min-h-full">
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="flex-shrink-0">
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <router-link
                v-for="item in navigation" 
                :key="item.name" 
                :to="item.to"
                active-class="bg-gray-900 text-white" 
                :class="[
                 this.$route.name === item.to.name
                  ? ' ' 
                  : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" 
                  >{{ item.name }}
                </router-link>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <button type="button" class="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                <span class="sr-only">Notificări</span>
                <BellIcon class="h-6 w-6" aria-hidden="true" />
              </button>

              <!-- Profile dropdown -->
              <Menu as="div" class="relative ml-3">
                <div class="flex">
                  <MenuButton class="max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <span class="sr-only">Open user menu</span>
                    <div class="mx-3">
                      <div class="text-left text-base font-medium leading-none text-white">
                        {{ user.name }}
                      </div>
                      <div class="text-sm font-medium leading-none text-gray-300">
                        {{ user.email }}
                      </div>
                    </div>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-8 w-8"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="white"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
      
                  </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                  <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <MenuItem 
                      v-slot="{ active }">
                      <a @click="logout" 
                      :class="['block px-4 py-2 text-sm text-gray-700 cursor-pointer']">Deconectare</a>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">

            <!-- Mobile menu button visible only on small screen, hiden for desktop-->
            <DisclosureButton class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
              <span class="sr-only">Open main menu</span>
              <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
          <router-link 
          v-for="item in navigation" 
          :key="item.name" 
          :to="item.to" active-class="bg-gray-900 text-white" 
          :class="[
            this.$route.name === item.to.name 
            ? ' ' 
            :'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']" 
            >{{ item.name }}</router-link>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="white"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">
                {{ user.name }}
              </div>
              <div class="text-sm font-medium leading-none text-gray-400">
                {{ user.email }}
              </div>
            </div>
          </div>
          <div class="mt-3 space-y-1 px-2">
            <DisclosureButton 
            as="a"
            @click="logout"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white cursor-pointer">Deconectare</DisclosureButton>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>
    <link rel="shortcut icon" href="#">

    <Notification/>
 
  </div>

      <router-view /> <!-- Render the content specific to each route -->
      
    </div>
  </template>
  
  <script>

import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import {useStore} from 'vuex';
import { computed } from 'vue';
import { useRouter } from 'vue-router';
import Notification from '../../components/Notification.vue';
import FeedbackStudent from '../FeedbackStudent.vue';

const navigation = [
  
  { name: 'Lecții', to: {name: 'Student'}},
  { name: 'Feedback', to: {name: 'FeedbackStudent'}},
  { name: 'Agenda', to: {name: 'Enrollment'}},

]

  export default {
    name: "StudentLayout",
    components: 
    {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        Bars3Icon,
        XMarkIcon,
        Notification,
  },
  setup() {
    const store = useStore();
    const router = useRouter();

    function logout(){
      store.dispatch("logout")
      .then(()=> {
        router.push({
        name: 'Login',
        });
      });
    }
    
    return {
      /**
      |'computed' functions allows to define computed properties.
      |computed properties are dynamically calculated based on other properties,
      |and they are cached and only re-evaluated when their dependency have changed.
       */
      user: computed(() => store.state.user.data),
      navigation,
      logout,
    };
  },
  
  };
  </script>
  