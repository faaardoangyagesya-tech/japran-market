<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '../api'

const stats = ref(null)
const loading = ref(true)

const maxGameCount = computed(() => {
  if (!stats.value?.accounts_by_game?.length) return 1
  return Math.max(...stats.value.accounts_by_game.map(g => g.total), 1)
})

onMounted(async () => {
  try {
    const { data } = await api.get('/admin/dashboard')
    stats.value = data
  } catch { /* silent */ } finally { loading.value = false }
})

function formatRupiah(val) {
  return Number(val).toLocaleString('id-ID')
}
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-2xl font-bold text-white">Dashboard</h1>
        <p class="text-text-muted text-sm mt-1">Overview status toko</p>
      </div>
      <div class="flex items-center gap-2 text-xs text-text-muted">
        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse" />
        Live
      </div>
    </div>

    <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      <div v-for="i in 4" :key="i" class="bg-dark-900/60 border border-gold/10 rounded-2xl p-6">
        <div class="h-8 bg-dark-800/50 rounded w-16 mb-2 shimmer" />
        <div class="h-4 bg-dark-800/50 rounded w-24 shimmer" />
      </div>
    </div>

    <template v-else-if="stats">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div v-for="card in [
          { value: stats.available_accounts, label: 'Akun Tersedia', icon: '📦', color: 'from-gold/20 to-gold/5' },
          { value: stats.sold_accounts, label: 'Akun Terjual', icon: '✅', color: 'from-green-500/20 to-green-500/5' },
          { value: stats.total_games, label: 'Total Game', icon: '🎮', color: 'from-blue-accent/20 to-blue-accent/5' },
          { value: stats.total_accounts, label: 'Total Akun', icon: '📊', color: 'from-purple-500/20 to-purple-500/5' },
        ]" :key="card.label"
          class="bg-dark-900/60 border border-gold/10 rounded-2xl p-6 card-hover"
        >
          <div class="flex items-start justify-between mb-3">
            <span class="text-2xl">{{ card.icon }}</span>
            <span class="text-xs text-gold font-medium">{{ card.value > 0 ? '+' + card.value : '0' }}</span>
          </div>
          <div class="text-3xl font-extrabold text-white tracking-tight">{{ card.value }}</div>
          <div class="text-text-muted text-sm mt-1">{{ card.label }}</div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-dark-900/60 border border-gold/10 rounded-2xl p-6">
          <h2 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Pengunjung
          </h2>
          <div class="grid grid-cols-2 gap-4">
            <div v-for="item in [
              { value: stats.visitor_stats?.daily || 0, label: 'Hari Ini' },
              { value: stats.visitor_stats?.weekly || 0, label: 'Minggu Ini' },
              { value: stats.visitor_stats?.monthly || 0, label: 'Bulan Ini' },
              { value: stats.visitor_stats?.total || 0, label: 'Total' },
            ]" :key="item.label" class="bg-dark-800/30 rounded-xl p-4">
              <div class="text-xl font-bold text-gold">{{ item.value }}</div>
              <div class="text-text-muted text-xs mt-0.5">{{ item.label }}</div>
            </div>
          </div>
        </div>

        <div class="bg-dark-900/60 border border-gold/10 rounded-2xl p-6">
          <h2 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Akun Termahal
          </h2>
          <div v-if="stats.most_expensive_account" class="bg-dark-800/30 rounded-xl p-5">
            <div class="flex items-center justify-between mb-2">
              <span class="text-gold font-mono font-bold text-lg">{{ stats.most_expensive_account.code }}</span>
              <span class="text-xs bg-gold/10 text-gold px-2 py-1 rounded-full">{{ stats.most_expensive_account.game }}</span>
            </div>
            <div class="text-2xl font-extrabold text-white">Rp {{ formatRupiah(stats.most_expensive_account.price) }}</div>
          </div>
          <div v-else class="bg-dark-800/30 rounded-xl p-5 text-text-muted text-sm text-center">
            Belum ada data akun termahal
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-dark-900/60 border border-gold/10 rounded-2xl p-6">
          <h2 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Akun per Game
          </h2>
          <div v-if="stats.accounts_by_game?.length" class="space-y-3">
            <div v-for="item in stats.accounts_by_game" :key="item.name" class="flex items-center justify-between">
              <span class="text-text-muted text-sm">{{ item.name }}</span>
              <div class="flex items-center gap-3">
                <div class="w-24 md:w-32 h-2 bg-dark-800 rounded-full overflow-hidden">
                  <div
                    class="h-full bg-gradient-to-r from-gold to-gold-dark rounded-full transition-all duration-500"
                    :style="{ width: maxGameCount > 0 ? `${(item.total / maxGameCount) * 100}%` : '0%' }"
                  />
                </div>
                <span class="text-gold font-semibold text-sm w-6 text-right">{{ item.total }}</span>
              </div>
            </div>
          </div>
          <div v-else class="text-text-muted text-sm text-center py-4">Belum ada data</div>
        </div>

        <div class="bg-dark-900/60 border border-gold/10 rounded-2xl p-6">
          <h2 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Akun Terbaru
          </h2>
          <div v-if="stats.recent_accounts?.length" class="space-y-2">
            <div
              v-for="item in stats.recent_accounts"
              :key="item.id"
              class="flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-dark-800/30 transition-colors"
            >
              <div class="flex items-center gap-2 min-w-0">
                <span class="text-gold font-mono text-sm font-semibold">{{ item.unique_code }}</span>
                <span class="text-text-muted text-xs truncate">{{ item.game?.name }}</span>
              </div>
              <span class="text-white text-sm font-medium shrink-0">Rp {{ formatRupiah(item.price) }}</span>
            </div>
          </div>
          <div v-else class="text-text-muted text-sm text-center py-4">Belum ada akun</div>
        </div>
      </div>
    </template>
  </div>
</template>
