<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../api'
import WhatsAppButton from '../components/WhatsAppButton.vue'

const route = useRoute()
const account = ref(null)
const loading = ref(true)

const formattedPrice = computed(() => {
  if (!account.value) return ''
  return new Intl.NumberFormat('id-ID', {
    style: 'currency', currency: 'IDR',
    minimumFractionDigits: 0, maximumFractionDigits: 0,
  }).format(account.value.price)
})

const copyToClipboard = async (text) => {
  try {
    await navigator.clipboard.writeText(text)
  } catch { /* silent */ }
}

onMounted(async () => {
  try {
    const { data } = await api.get(`/accounts/${route.params.id}`)
    account.value = data.data || data
  } catch { /* silent */ } finally { loading.value = false }
})
</script>

<template>
  <div class="pt-28 pb-20 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div v-if="loading">
        <div class="h-4 w-32 shimmer rounded mb-6" />
        <div class="bg-dark-900/60 border border-gold/20 rounded-3xl p-8 shimmer rounded-3xl h-80" />
      </div>

      <div v-else-if="account">
        <router-link
          :to="`/stock/${account.game?.slug}`"
          class="inline-flex items-center gap-1 text-text-muted hover:text-gold text-sm transition-colors mb-6"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Kembali ke {{ account.game?.name }}
        </router-link>

        <div class="relative bg-dark-900/60 border border-gold/20 rounded-3xl p-8 md:p-10 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-gold/5 via-transparent to-blue-accent/5" />
          <div class="absolute -top-20 -right-20 w-64 h-64 bg-gold/5 rounded-full blur-3xl" />

          <div class="relative">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8">
              <div>
                <div class="flex items-center gap-2 mb-2">
                  <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse" />
                  <span class="text-xs text-green-400 font-medium uppercase tracking-wider">Tersedia</span>
                </div>
                <div class="text-4xl md:text-5xl font-mono font-extrabold text-gold tracking-wider">
                  {{ account.unique_code }}
                </div>
                <p class="text-text-muted mt-1 flex items-center gap-2">
                  {{ account.game?.name }}
                  <button @click="copyToClipboard(account.unique_code)" class="text-xs text-gold/60 hover:text-gold transition-colors">
                    salin kode
                  </button>
                </p>
              </div>
            </div>

            <div v-if="account.description" class="bg-dark-800/50 border border-gold/10 rounded-2xl p-6 mb-8">
              <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Deskripsi Akun
              </h3>
              <p class="text-text-muted whitespace-pre-wrap leading-relaxed">{{ account.description }}</p>
            </div>

            <div class="border-t border-gold/10 pt-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
              <div>
                <span class="text-text-muted text-xs uppercase tracking-wider">Harga</span>
                <div class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">{{ formattedPrice }}</div>
              </div>
              <WhatsAppButton :game-name="account.game?.name" :code="account.unique_code" />
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-24">
        <div class="text-6xl mb-4">😕</div>
        <p class="text-text-muted text-lg">Akun tidak ditemukan atau sudah terjual</p>
        <router-link to="/stock" class="inline-block mt-4 text-gold hover:text-gold-light transition-colors">
          &larr; Lihat Stock Lain
        </router-link>
      </div>
    </div>
  </div>
</template>
