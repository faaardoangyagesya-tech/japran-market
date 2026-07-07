<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const route = useRoute()
const auth = useAuthStore()
const sidebarOpen = ref(false)

async function handleLogout() {
  await auth.logout()
  router.push('/login')
}

const navItems = [
  {
    name: 'Dashboard',
    path: '/',
    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>',
  },
  {
    name: 'Stock',
    path: '/stock',
    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>',
  },
  {
    name: 'Games',
    path: '/games',
    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
  },
]

function isActive(path) {
  if (path === '/') return route.path === '/'
  return route.path.startsWith(path)
}
</script>

<template>
  <div class="min-h-screen bg-dark-950 flex">
    <aside
      :class="[
        'fixed inset-y-0 left-0 z-40 w-64 bg-dark-900/90 backdrop-blur-sm border-r border-gold/10 transform transition-all duration-300 lg:translate-x-0 lg:static lg:inset-auto',
        sidebarOpen ? 'translate-x-0 shadow-2xl shadow-black/50' : '-translate-x-full'
      ]"
    >
      <div class="p-6 border-b border-gold/10">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-gold to-gold-dark flex items-center justify-center shadow-lg shadow-gold/20">
            <span class="text-dark-950 font-extrabold text-sm">JM</span>
          </div>
          <div>
            <span class="text-base font-bold text-gradient">Admin</span>
            <span class="text-base font-bold text-white">Panel</span>
          </div>
        </div>
      </div>

      <nav class="p-3 space-y-1">
        <router-link
          v-for="item in navItems"
          :key="item.path"
          :to="item.path"
          class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200"
          :class="isActive(item.path)
            ? 'bg-gradient-to-r from-gold/10 to-transparent text-gold border-l-2 border-gold'
            : 'text-text-muted hover:bg-dark-800/50 hover:text-white border-l-2 border-transparent'"
        >
          <span v-html="item.icon" />
          <span>{{ item.name }}</span>
        </router-link>
      </nav>

      <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gold/10">
        <div class="flex items-center justify-between">
          <div class="text-sm">
            <p class="text-white font-medium truncate">{{ auth.admin?.name }}</p>
            <p class="text-text-muted text-xs truncate">{{ auth.admin?.email }}</p>
          </div>
          <button @click="handleLogout" class="w-8 h-8 flex items-center justify-center rounded-lg text-text-muted hover:text-red-400 hover:bg-red-500/10 transition-all" title="Logout">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
          </button>
        </div>
      </div>
    </aside>

    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 lg:hidden" />

    <div class="flex-1 min-w-0">
      <header class="sticky top-0 z-20 glass border-b border-gold/10 px-6 py-3 flex items-center lg:hidden">
        <button @click="sidebarOpen = true" class="text-white mr-4 p-2 rounded-lg hover:bg-white/5 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <div class="flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-gold to-gold-dark flex items-center justify-center">
            <span class="text-dark-950 font-extrabold text-xs">JM</span>
          </div>
          <span class="text-sm font-bold text-gradient">Admin Panel</span>
        </div>
      </header>

      <main class="p-4 md:p-6 lg:p-8">
        <router-view />
      </main>
    </div>
  </div>
</template>
