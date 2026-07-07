<script setup>
import { useAppStore } from '../stores/app'
import StatsWidget from '../components/StatsWidget.vue'
import GameCard from '../components/GameCard.vue'
import { ref, onMounted } from 'vue'
import api from '../api'

const store = useAppStore()
const games = ref([])
const loading = ref(true)
const featuredAccounts = ref([])

onMounted(async () => {
  try {
    const { data } = await api.get('/games')
    games.value = data.data || data
  } catch { /* silent */ } finally { loading.value = false }
})
</script>

<template>
  <div>
    <section class="relative min-h-[90vh] flex items-center overflow-hidden">
      <div class="absolute inset-0 gold-sparkle" />
      <div class="absolute inset-0 blue-sparkle" />
      <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-gold/5 rounded-full blur-3xl floating" />
      <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-blue-accent/5 rounded-full blur-3xl floating-delayed" />

      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gold/20 bg-gold/5 text-gold text-xs font-medium mb-6 floating">
          <span class="w-1.5 h-1.5 rounded-full bg-gold animate-pulse" />
          Premium Game Account Store
        </div>

        <h1 class="text-5xl sm:text-6xl md:text-8xl font-extrabold leading-[1.1] mb-6">
          <span class="text-gradient">Japran</span><br />
          <span class="text-white">Market</span>
        </h1>

        <p class="text-text-muted text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
          Tempat terpercaya untuk membeli akun game berkualitas.
          Roblox, Minecraft, Free Fire, dan masih banyak lagi!
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
          <router-link
            to="/stock"
            class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-gold to-gold-dark text-dark-950 font-bold px-8 py-3.5 rounded-xl transition-all duration-300 shadow-xl shadow-gold/20 hover:shadow-gold/40 hover:scale-105 active:scale-95"
          >
            Lihat Stock
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </router-link>
          <router-link
            to="/about"
            class="inline-flex items-center gap-2 border border-gold/30 text-gold font-medium px-8 py-3.5 rounded-xl hover:bg-gold/5 hover:border-gold/50 transition-all duration-300"
          >
            Tentang Kami
          </router-link>
        </div>

        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
          <StatsWidget :value="store.stats.total_games" label="Total Game" icon="🎮" />
          <StatsWidget :value="store.stats.available_accounts" label="Akun Tersedia" icon="📦" />
          <StatsWidget :value="store.stats.total_visitors" label="Total Pengunjung" icon="👥" />
          <StatsWidget
            :value="store.stats.most_expensive_account?.price || 0"
            label="Akun Termahal" prefix="Rp" icon="👑"
          />
        </div>
      </div>
    </section>

    <section class="relative py-20">
      <div class="absolute inset-0 bg-gradient-to-b from-dark-950 via-dark-950 to-transparent" />
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-white">Game Tersedia</h2>
            <p class="text-text-muted text-sm mt-1">Pilih game untuk lihat akun yang tersedia</p>
          </div>
          <router-link to="/stock" class="hidden sm:flex items-center gap-1 text-gold text-sm font-medium hover:text-gold-light transition-colors">
            Lihat Semua <span class="text-lg">&rarr;</span>
          </router-link>
        </div>

        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="i in 8" :key="i" class="bg-dark-900/60 border border-gold/20 rounded-2xl p-6 shimmer rounded-2xl">
            <div class="w-14 h-14 rounded-2xl bg-dark-800 mb-4" />
            <div class="h-5 bg-dark-800/50 rounded w-24 mb-2" />
            <div class="h-3 bg-dark-800/50 rounded w-32" />
          </div>
        </div>

        <div v-else-if="games.length === 0" class="text-center py-16">
          <p class="text-text-muted text-lg">Belum ada game tersedia</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <GameCard v-for="game in games" :key="game.id" :game="game" />
        </div>

        <div class="mt-8 text-center sm:hidden">
          <router-link to="/stock" class="inline-flex items-center gap-1 text-gold text-sm font-medium">
            Lihat Semua Game <span class="text-lg">&rarr;</span>
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>
