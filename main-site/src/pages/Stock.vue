<script setup>
import { ref, onMounted } from 'vue'
import api from '../api'
import GameCard from '../components/GameCard.vue'

const games = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const { data } = await api.get('/games')
    games.value = data.data || data
  } catch { /* silent */ } finally { loading.value = false }
})
</script>

<template>
  <div class="pt-28 pb-20 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-10">
        <router-link to="/" class="inline-flex items-center gap-1 text-text-muted hover:text-gold text-sm transition-colors mb-4">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Kembali
        </router-link>
        <h1 class="text-3xl md:text-4xl font-bold text-white">Pilih Game</h1>
        <p class="text-text-muted mt-1.5">Pilih game untuk melihat akun yang tersedia</p>
      </div>

      <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div v-for="i in 8" :key="i" class="bg-dark-900/60 border border-gold/20 rounded-2xl p-6 shimmer rounded-2xl">
          <div class="w-14 h-14 rounded-2xl bg-dark-800 mb-4" />
          <div class="h-5 bg-dark-800/50 rounded w-24 mb-2" />
          <div class="h-3 bg-dark-800/50 rounded w-32" />
        </div>
      </div>

      <div v-else-if="games.length === 0" class="text-center py-24">
        <div class="text-6xl mb-4">🎮</div>
        <p class="text-text-muted text-lg">Belum ada game tersedia</p>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <GameCard v-for="game in games" :key="game.id" :game="game" />
      </div>
    </div>
  </div>
</template>
