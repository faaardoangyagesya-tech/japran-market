<script setup>
defineProps({
  game: { type: Object, required: true },
})
</script>

<template>
  <router-link
    :to="`/stock/${game.slug}`"
    class="group relative bg-dark-900/60 border border-gold/20 rounded-2xl p-6 card-hover overflow-hidden"
  >
    <div class="absolute inset-0 bg-gradient-to-br from-gold/5 via-transparent to-blue-accent/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
    <div class="absolute -top-8 -right-8 w-24 h-24 bg-gold/5 rounded-full blur-xl group-hover:bg-gold/10 transition-all duration-500" />

    <div class="relative">
      <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-gold/20 to-gold/5 border border-gold/20 flex items-center justify-center mb-4 text-3xl group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-gold/20 transition-all duration-300">
        {{ game.icon || '🎮' }}
      </div>

      <h3 class="text-lg font-bold text-white group-hover:text-gold transition-colors duration-300">
        {{ game.name }}
      </h3>

      <p v-if="game.description" class="text-text-muted text-sm mt-1.5 line-clamp-2 leading-relaxed">
        {{ game.description }}
      </p>

      <div class="mt-4 pt-4 border-t border-gold/10 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="text-gold font-bold text-lg">{{ game.accounts_count }}</span>
          <span class="text-text-muted text-xs">tersedia</span>
        </div>
        <span class="text-xs text-gold/60 group-hover:text-gold group-hover:translate-x-1 transition-all duration-300">
          Lihat &rarr;
        </span>
      </div>
    </div>
  </router-link>
</template>
