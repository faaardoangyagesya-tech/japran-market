<script setup>
import { ref, onMounted } from 'vue'
import api from '../api'

const games = ref([])
const loading = ref(true)
const formOpen = ref(false)
const editing = ref(null)
const deleteConfirm = ref(null)

const form = ref({ name: '', icon: '', description: '' })
const notifications = ref([])

function notify(msg, type = 'success') {
  notifications.value.push({ id: Date.now(), msg, type })
  setTimeout(() => notifications.value.shift(), 3500)
}

async function loadGames() {
  try {
    const { data } = await api.get('/admin/games')
    games.value = data.data || data
  } catch { /* silent */ }
}

onMounted(async () => {
  await loadGames()
  loading.value = false
})

function openCreate() {
  editing.value = null
  form.value = { name: '', icon: '', description: '' }
  formOpen.value = true
}

function openEdit(game) {
  editing.value = game
  form.value = { name: game.name, icon: game.icon || '', description: game.description || '' }
  formOpen.value = true
}

async function handleSubmit() {
  try {
    if (editing.value) {
      await api.put(`/admin/games/${editing.value.id}`, form.value)
      notify('Game berhasil diupdate')
    } else {
      await api.post('/admin/games', form.value)
      notify('Game berhasil ditambahkan')
    }
    formOpen.value = false
    await loadGames()
  } catch (err) {
    notify(err.response?.data?.message || 'Gagal menyimpan', 'error')
  }
}

async function handleDelete(id) {
  try {
    await api.delete(`/admin/games/${id}`)
    deleteConfirm.value = null
    notify('Game berhasil dihapus')
    await loadGames()
  } catch { notify('Gagal menghapus', 'error') }
}
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-white">Manage Games</h1>
        <p class="text-text-muted text-sm mt-1">Kelola daftar game</p>
      </div>
      <button @click="openCreate" class="flex items-center gap-2 bg-gradient-to-r from-gold to-gold-dark text-dark-950 font-bold px-5 py-2.5 rounded-xl hover:shadow-lg hover:shadow-gold/20 active:scale-95 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Game
      </button>
    </div>

    <div v-if="notifications.length" class="fixed top-4 right-4 z-[100] space-y-2">
      <div v-for="n in notifications" :key="n.id"
        class="flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-medium shadow-2xl animate-fade-in backdrop-blur-sm"
        :class="n.type === 'error' ? 'bg-red-500/90 text-white' : 'bg-green-500/90 text-white'"
      >
        <svg v-if="n.type === 'success'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ n.msg }}
      </div>
    </div>

    <div class="bg-dark-900/60 border border-gold/10 rounded-2xl overflow-hidden">
      <div v-if="loading" class="p-12 text-center">
        <div class="w-8 h-8 border-2 border-gold/30 border-t-gold rounded-full animate-spin mx-auto" />
      </div>

      <div v-else-if="!games.length" class="p-12 text-center">
        <div class="text-4xl mb-3">🎮</div>
        <p class="text-text-muted">Belum ada game. Klik "Tambah Game" untuk mulai.</p>
      </div>

      <div v-else class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gold/10 text-text-muted text-xs uppercase tracking-wider">
              <th class="text-left p-4 font-medium">Icon</th>
              <th class="text-left p-4 font-medium">Nama</th>
              <th class="text-left p-4 font-medium">Slug</th>
              <th class="text-left p-4 font-medium">Total Akun</th>
              <th class="text-right p-4 font-medium">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="game in games" :key="game.id" class="border-b border-gold/5 hover:bg-gold/5 transition-colors">
              <td class="p-4">
                <span class="text-2xl">{{ game.icon || '🎮' }}</span>
              </td>
              <td class="p-4 text-white font-medium">{{ game.name }}</td>
              <td class="p-4 text-text-muted text-xs font-mono">{{ game.slug }}</td>
              <td class="p-4">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gold/10 text-gold font-bold text-sm">{{ game.accounts_count || 0 }}</span>
              </td>
              <td class="p-4 text-right">
                <button @click="openEdit(game)" class="inline-flex items-center gap-1 text-blue-accent-light hover:text-blue-accent text-xs font-medium mr-3 transition-colors">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Edit
                </button>
                <button @click="deleteConfirm = game.id" class="inline-flex items-center gap-1 text-red-400 hover:text-red-500 text-xs font-medium transition-colors">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <transition name="modal">
      <div v-if="formOpen" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4" @click.self="formOpen = false">
        <div class="bg-dark-900 border border-gold/20 rounded-2xl p-6 w-full max-w-md shadow-2xl">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-white">{{ editing ? 'Edit Game' : 'Tambah Game' }}</h2>
            <button @click="formOpen = false" class="text-text-muted hover:text-white transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="space-y-4">
            <div>
              <label class="block text-text-muted text-xs font-medium mb-1.5">Nama Game</label>
              <input v-model="form.name" required placeholder="Roblox, Minecraft, dll"
                class="w-full bg-dark-800/50 border border-dark-700 rounded-xl px-4 py-3 text-white placeholder-text-muted/30 focus:outline-none focus:border-gold/50 transition-colors"
              />
            </div>
            <div>
              <label class="block text-text-muted text-xs font-medium mb-1.5">Icon (emoji)</label>
              <input v-model="form.icon" placeholder="🎮" maxlength="10"
                class="w-full bg-dark-800/50 border border-dark-700 rounded-xl px-4 py-3 text-white placeholder-text-muted/30 focus:outline-none focus:border-gold/50 transition-colors"
              />
            </div>
            <div>
              <label class="block text-text-muted text-xs font-medium mb-1.5">Deskripsi</label>
              <textarea v-model="form.description" rows="3"
                class="w-full bg-dark-800/50 border border-dark-700 rounded-xl px-4 py-3 text-white placeholder-text-muted/30 focus:outline-none focus:border-gold/50 transition-colors resize-none"
              />
            </div>
          </div>

          <div class="flex gap-3 mt-6">
            <button @click="formOpen = false" class="flex-1 bg-dark-800/50 text-text-muted py-3 rounded-xl hover:bg-dark-700 transition-colors text-sm font-medium">
              Batal
            </button>
            <button @click="handleSubmit" class="flex-1 bg-gradient-to-r from-gold to-gold-dark text-dark-950 font-bold py-3 rounded-xl hover:shadow-lg hover:shadow-gold/20 active:scale-[0.98] transition-all text-sm">
              {{ editing ? 'Simpan' : 'Tambah' }}
            </button>
          </div>
        </div>
      </div>
    </transition>

    <transition name="modal">
      <div v-if="deleteConfirm" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4" @click.self="deleteConfirm = null">
        <div class="bg-dark-900 border border-red-500/20 rounded-2xl p-6 w-full max-w-sm shadow-2xl text-center">
          <div class="w-14 h-14 rounded-2xl bg-red-500/10 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
          </div>
          <h3 class="text-lg font-bold text-white mb-2">Hapus Game?</h3>
          <p class="text-text-muted text-sm mb-2">Semua akun terkait akan ikut terhapus.</p>
          <p class="text-text-muted text-xs mb-6">Tindakan ini tidak bisa dibatalkan.</p>
          <div class="flex gap-3">
            <button @click="deleteConfirm = null" class="flex-1 bg-dark-800/50 text-text-muted py-2.5 rounded-xl hover:bg-dark-700 transition-colors text-sm font-medium">Batal</button>
            <button @click="handleDelete(deleteConfirm)" class="flex-1 bg-red-500 text-white font-bold py-2.5 rounded-xl hover:bg-red-600 active:scale-[0.98] transition-all text-sm">Hapus</button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
