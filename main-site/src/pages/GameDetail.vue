<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import api from '../api'
import AccountCard from '../components/AccountCard.vue'

const route = useRoute()
const game = ref(null)
const accounts = ref([])
const loading = ref(true)
const pagination = ref(null)

const totalText = computed(() => {
  const count = accounts.value.length
  if (count === 0) return 'Belum ada akun tersedia'
  return `${count} akun tersedia`
})

onMounted(async () => {
  try {
    const [gameRes, accountsRes] = await Promise.all([
      api.get(`/games/${route.params.slug}`),
      api.get(`/games/${route.params.slug}/accounts`),
    ])
    game.value = gameRes.data.data || gameRes.data
    const accData = accountsRes.data.data || accountsRes.data
    accounts.value = Array.isArray(accData) ? accData : []
    pagination.value = accountsRes.data.meta || null
  } catch { /* silent */ } finally { loading.value = false }
})
</script>

<template>
  <div class="pt-28 pb-20 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div v-if="loading">
        <div class="flex items-center gap-4 mb-8">
          <div class="w-16 h-16 rounded-2xl shimmer" />
          <div class="space-y-2">
            <div class="h-8 w-48 shimmer rounded" />
            <div class="h-4 w-32 shimmer rounded" />
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="i in 6" :key="i" class="bg-dark-900/60 border border-gold/20 rounded-2xl p-5 shimmer rounded-2xl h-40" />
        </div>
      </div>

      <div v-else-if="game">
        <div class="mb-10">
          <router-link to="/stock" class="inline-flex items-center gap-1 text-text-muted hover:text-gold text-sm transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Stock
          </router-link>
          <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gold/20 to-gold/5 border border-gold/20 flex items-center justify-center text-4xl shrink-0">
              {{ game.icon || '🎮' }}
            </div>
            <div>
              <h1 class="text-3xl md:text-4xl font-bold text-white">{{ game.name }}</h1>
              <p class="text-text-muted mt-1">{{ totalText }}</p>
            </div>
          </div>
        </div>

        <div v-if="accounts.length === 0" class="text-center py-24">
          <div class="text-6xl mb-4">📭</div>
          <p class="text-text-muted text-lg">Belum ada akun tersedia untuk game ini</p>
          <router-link to="/stock" class="inline-block mt-4 text-gold hover:text-gold-light transition-colors">
            &larr; Coba game lain
          </router-link>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <AccountCard v-for="account in accounts" :key="account.id" :account="account" />
        </div>

        <div v-if="pagination && pagination.last_page > 1" class="mt-10 flex justify-center gap-2">
          <button
            v-for="page in pagination.last_page"
            :key="page"
            :class="[
              'w-10 h-10 rounded-xl text-sm font-medium transition-all duration-200',
              page === pagination.current_page
                ? 'bg-gradient-to-r from-gold to-gold-dark text-dark-950 font-bold shadow-lg shadow-gold/20'
                : 'bg-dark-800/50 text-text-muted hover:bg-dark-700 hover:text-white border border-gold/10'
            ]"
          >
            {{ page }}
          </button>
        </div>
      </div>

      <div v-else class="text-center py-24">
        <div class="text-6xl mb-4">🔍</div>
        <p class="text-text-muted text-lg">Game tidak ditemukan</p>
        <router-link to="/stock" class="inline-block mt-4 text-gold hover:text-gold-light transition-colors">
          &larr; Lihat semua game
        </router-link>
      </div>
    </div>
  </div>
</template>
