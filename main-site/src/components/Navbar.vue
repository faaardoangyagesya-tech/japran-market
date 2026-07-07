<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'

const isOpen = ref(false)
const isScrolled = ref(false)

const scrollHandler = () => {
  isScrolled.value = window.scrollY > 50
}

onMounted(() => window.addEventListener('scroll', scrollHandler))
onUnmounted(() => window.removeEventListener('scroll', scrollHandler))
</script>

<template>
  <nav
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
    :class="isScrolled ? 'glass border-b border-gold/20 shadow-lg shadow-black/20' : 'bg-transparent'"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16 md:h-20">
        <router-link to="/" class="flex items-center gap-3 group">
          <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-gold to-gold-dark flex items-center justify-center shadow-lg shadow-gold/20 group-hover:shadow-gold/40 transition-all duration-300">
            <span class="text-dark-950 font-extrabold text-sm">JM</span>
          </div>
          <div class="flex items-baseline">
            <span class="text-xl md:text-2xl font-extrabold text-gradient tracking-tight">Japran</span>
            <span class="text-xl md:text-2xl font-extrabold text-white tracking-tight">Market</span>
          </div>
        </router-link>

        <div class="hidden md:flex items-center gap-1">
          <router-link
            to="/"
            class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300"
            :class="[$route.path === '/' ? 'text-gold bg-gold/10' : 'text-text-muted hover:text-white hover:bg-white/5']"
          >
            Home
            <span v-if="$route.path === '/'" class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-gradient-to-r from-gold to-gold-dark rounded-full" />
          </router-link>
          <router-link
            to="/stock"
            class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300"
            :class="[$route.path.startsWith('/stock') ? 'text-gold bg-gold/10' : 'text-text-muted hover:text-white hover:bg-white/5']"
          >
            Stock
            <span v-if="$route.path.startsWith('/stock')" class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-gradient-to-r from-gold to-gold-dark rounded-full" />
          </router-link>
          <router-link
            to="/about"
            class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300"
            :class="[$route.path === '/about' ? 'text-gold bg-gold/10' : 'text-text-muted hover:text-white hover:bg-white/5']"
          >
            About
            <span v-if="$route.path === '/about'" class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-gradient-to-r from-gold to-gold-dark rounded-full" />
          </router-link>
        </div>

        <button @click="isOpen = !isOpen" class="md:hidden relative w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white/5 transition-colors">
          <div class="w-5 flex flex-col gap-1.5">
            <span class="block h-0.5 bg-current rounded-full transition-all duration-300" :class="isOpen ? 'rotate-45 translate-y-1' : ''" />
            <span class="block h-0.5 bg-current rounded-full transition-all duration-300" :class="isOpen ? 'opacity-0' : ''" />
            <span class="block h-0.5 bg-current rounded-full transition-all duration-300" :class="isOpen ? '-rotate-45 -translate-y-1' : ''" />
          </div>
        </button>
      </div>
    </div>

    <transition
      enter-active-class="transition-all duration-300 ease-out"
      leave-active-class="transition-all duration-200 ease-in"
      enter-from-class="opacity-0 -translate-y-4"
      leave-to-class="opacity-0 -translate-y-4"
    >
      <div v-if="isOpen" class="md:hidden glass border-t border-gold/20">
        <div class="px-4 py-4 space-y-1">
          <router-link @click="isOpen = false" to="/" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors" :class="$route.path === '/' ? 'text-gold bg-gold/10' : 'text-text-muted hover:text-white hover:bg-white/5'">
            Home
          </router-link>
          <router-link @click="isOpen = false" to="/stock" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors" :class="$route.path.startsWith('/stock') ? 'text-gold bg-gold/10' : 'text-text-muted hover:text-white hover:bg-white/5'">
            Stock
          </router-link>
          <router-link @click="isOpen = false" to="/about" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors" :class="$route.path === '/about' ? 'text-gold bg-gold/10' : 'text-text-muted hover:text-white hover:bg-white/5'">
            About
          </router-link>
        </div>
      </div>
    </transition>
  </nav>
</template>
