<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const auth = useAuthStore()

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)

async function handleLogin() {
  error.value = ''
  loading.value = true
  try {
    await auth.login(email.value, password.value)
    router.push('/')
  } catch (err) {
    error.value = err.response?.data?.message || 'Login gagal'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-dark-950 p-4 relative overflow-hidden">
    <div class="absolute inset-0 gold-sparkle" />
    <div class="absolute top-1/3 left-1/3 w-96 h-96 bg-gold/5 rounded-full blur-3xl" />

    <div class="relative w-full max-w-md">
      <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gold to-gold-dark flex items-center justify-center mx-auto mb-4 shadow-xl shadow-gold/20">
          <svg class="w-8 h-8 text-dark-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-white">Admin Panel</h1>
        <p class="text-text-muted text-sm mt-1">Japran Market</p>
      </div>

      <form @submit.prevent="handleLogin" class="bg-dark-900/80 backdrop-blur-sm border border-gold/20 rounded-2xl p-8 space-y-5 shadow-2xl">
        <div>
          <label class="block text-text-muted text-xs font-medium mb-1.5 uppercase tracking-wider">Email</label>
          <input
            v-model="email"
            type="email"
            required
            class="w-full bg-dark-800/50 border border-dark-700 rounded-xl px-4 py-3 text-white placeholder-text-muted/30 focus:outline-none focus:border-gold/50 focus:ring-1 focus:ring-gold/20 transition-all"
            placeholder="admin@japranmarket.com"
          />
        </div>

        <div>
          <label class="block text-text-muted text-xs font-medium mb-1.5 uppercase tracking-wider">Password</label>
          <input
            v-model="password"
            type="password"
            required
            class="w-full bg-dark-800/50 border border-dark-700 rounded-xl px-4 py-3 text-white placeholder-text-muted/30 focus:outline-none focus:border-gold/50 focus:ring-1 focus:ring-gold/20 transition-all"
            placeholder="••••••••"
          />
        </div>

        <div v-if="error" class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm animate-fade-in">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ error }}
          </div>
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="relative w-full bg-gradient-to-r from-gold to-gold-dark text-dark-950 font-bold py-3 rounded-xl hover:shadow-xl hover:shadow-gold/20 active:scale-[0.98] transition-all duration-200 disabled:opacity-50 overflow-hidden group"
        >
          <span v-if="!loading">Masuk</span>
          <span v-else class="flex items-center justify-center gap-2">
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
            </svg>
            Loading...
          </span>
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.gold-sparkle {
  background: radial-gradient(circle at 30% 50%, rgba(245, 158, 11, 0.08), transparent 60%),
              radial-gradient(circle at 70% 30%, rgba(29, 78, 216, 0.06), transparent 50%);
}
</style>
