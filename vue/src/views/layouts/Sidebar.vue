<template>
    <div class="min-w-[160px] w-[160px]  transition-all bg-indigo-600 text-white py-4 px-2">
      <router-link :to="{name: 'app.dashboard'}"
                 class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <HomeIcon class="w-5"/>
      </span>
      <span class="text-xs">
        Dashboard
      </span>
    </router-link>
    
    <router-link :to="{name: 'app.users'}"
                   class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
        <span class="mr-2 text-gray-300">
          <UsersIcon class="w-5"/>
        </span>
        <span class="text-xs">
          Users
        </span>
    </router-link>


      <router-link :to="{name: 'app.report'}"
                   class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
        <span class="mr-2 text-gray-300">
          <ChartBarIcon class="w-5"/>
        </span>
        <span class="text-xs">
          Reports
        </span>
      </router-link>
    </div>
    
  </template>
  
  <script setup>
    import {HomeIcon, UserGroupIcon, UsersIcon, ViewListIcon, ChartBarIcon} from '@heroicons/vue/outline'
  </script>

  