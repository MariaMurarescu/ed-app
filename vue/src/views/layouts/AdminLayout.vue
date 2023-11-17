<template>
    <div class = "min-h-full flex bg-gray-200 flex">
        <Sidebar :class="{'-ml-[200px]': !sidebarOpened}"/>

        <div class="flex-1">
            <Navbar @toggle-sidebar="toggleSidebar"></Navbar>
            <main class="p-6">
                <router-view> </router-view>
            </main>
        </div> 
    </div>
</template>

<script setup>
import Navbar from './Navbar.vue';
import Sidebar from './Sidebar.vue';
import {ref, computed, onMounted, onUnmounted} from 'vue'
import store from '../../store';
import { useRouter } from 'vue-router';

const router = useRouter()

const user = computed(() => store.state.user.data);

function toggleSidebar() {
  sidebarOpened.value = !sidebarOpened.value
}

function updateSidebarState() {
  sidebarOpened.value = window.outerWidth > 768;
}

const sidebarOpened = ref(true);

const logout = () => {
  store.dispatch('logout')
    .then(() => {
      router.push({
        name: 'Login',
      });
    });
};
    
/*
onMounted(() => {
  store.dispatch('getUser');
  updateSidebarState();
  window.addEventListener('resize', updateSidebarState);
});
*/

onUnmounted(() => {
  window.removeEventListener('resize', updateSidebarState);
});
</script>