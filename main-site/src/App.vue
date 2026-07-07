<script setup>
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import ParticlesBg from './components/ParticlesBg.vue'
import { useAppStore } from './stores/app'
import { onMounted } from 'vue'

const store = useAppStore()

onMounted(() => {
  store.fetchStats()
  store.trackVisit()
})
</script>

<template>
  <ParticlesBg />
  <div class="min-h-screen flex flex-col relative z-10">
    <Navbar />
    <main class="flex-1">
      <router-view v-slot="{ Component, route }">
        <transition name="page" mode="out-in">
          <component :is="Component" :key="route.path" />
        </transition>
      </router-view>
    </main>
    <Footer />
  </div>
</template>
